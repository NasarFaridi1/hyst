<?php

namespace App\Http\Controllers\RestaurantAdmin;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AiAnalyticsController extends Controller
{
    public function index(Request $request)
    {
        $restaurantId = auth()->user()->restaurant_id;
        $restaurant = Restaurant::find($restaurantId);

        // Customer Digital Twins & Scores
        $digitalTwins = [];
        $nextBestActions = [];

        // Counters for Opportunity Board
        $reorderReadyCount = 0;
        $reorderReadyPotential = 0.00;
        $atRiskCount = 0;
        $atRiskPotential = 0.00;
        $vipInactiveCount = 0;
        $vipInactivePotential = 0.00;
        $upsellCount = 0;
        $upsellPotential = 0.00;

        // Lifecycle Funnel Counters
        $funnel = [
            'new' => 0,
            'second_order' => 0,
            'regular' => 0,
            'loyal' => 0,
            'vip' => 0,
            'at_risk' => 0,
            'dormant' => 0,
        ];

        // 1. Attempt to read pre-computed AI records directly from decoupled hyst_ai database
        $aiRecords = collect();
        try {
            $aiRecords = DB::connection('hyst_ai')->table('customer_restaurant_affinities as cra')
                ->join('customer_digital_twins as cdt', 'cdt.user_id', '=', 'cra.user_id')
                ->leftJoin('restaurant_customer_opportunity_scores as rcos', function($join) use ($restaurantId) {
                    $join->on('rcos.user_id', '=', 'cra.user_id')
                         ->where('rcos.restaurant_id', '=', $restaurantId);
                })
                ->where('cra.restaurant_id', $restaurantId)
                ->select(
                    'cra.user_id',
                    'cra.orders_count as res_orders_count',
                    'cra.total_spend as res_total_spend',
                    'cra.last_order_at as res_last_order_at',
                    'cra.status as res_affinity_status',
                    'cdt.name',
                    'cdt.email',
                    'cdt.phone',
                    'cdt.total_orders',
                    'cdt.total_spend',
                    'cdt.average_order_value',
                    'cdt.favourite_food_name',
                    'cdt.favourite_basket_items',
                    'cdt.typical_order_day',
                    'cdt.typical_time_start',
                    'cdt.typical_time_end',
                    'cdt.typical_interval_days',
                    'cdt.recency_days',
                    'cdt.offer_sensitivity',
                    'cdt.customer_value',
                    'cdt.current_status',
                    'cdt.relationship_stage',
                    'rcos.reorder_score',
                    'rcos.churn_score',
                    'rcos.upsell_score',
                    'rcos.vip_score',
                    'rcos.offer_sensitivity_score',
                    'rcos.offer_sensitivity_level',
                    'rcos.engagement_score',
                    'rcos.restaurant_affinity_score',
                    'rcos.incentive_type',
                    'rcos.incentive_title',
                    'rcos.incentive_rationale',
                    'rcos.margin_saved_estimate'
                )
                ->get();
        } catch (\Exception $e) {
            $aiRecords = collect();
        }

        if ($aiRecords->isNotEmpty()) {
            foreach ($aiRecords as $row) {
                $aov = (float) ($row->average_order_value ?? 0.0);
                $typicalInterval = (float) ($row->typical_interval_days ?? 7.0);
                $recencyDays = (int) ($row->recency_days ?? 0);
                $favDishName = $row->favourite_food_name ?: 'Popular Dish';
                $favBasket = json_decode($row->favourite_basket_items, true) ?: [];
                $basketString = !empty($favBasket) ? implode(' + ', $favBasket) : $favDishName;
                $currentStatus = $row->current_status ?: 'COOLDOWN';
                $status = strtoupper($row->relationship_stage ?: 'REGULAR');

                $reorderScore = (int) ($row->reorder_score ?? 50);
                $churnScore = (int) ($row->churn_score ?? 20);
                $upsellScore = (int) ($row->upsell_score ?? 60);
                $vipScore = (int) ($row->vip_score ?? 40);
                $offerSensScore = (int) ($row->offer_sensitivity_score ?? 30);
                $engageScore = (int) ($row->engagement_score ?? 50);
                $affScore = (int) ($row->restaurant_affinity_score ?? 70);

                $incType = $row->incentive_type ?: 'NONE';
                $incBadge = $row->incentive_title ?: '🛡️ 0% Discount';
                $incRationale = $row->incentive_rationale ?: 'Natural buyer — would order anyway without margin-cutting discounts.';
                $marginSaved = (float) ($row->margin_saved_estimate ?? round($aov * 0.15, 2));

                $suggestedCopy = "Hi {$row->name}! Thinking about dinner? Your favourite {$favDishName} is freshly prepared and waiting for you tonight.";
                if ($incType === 'FREE_DESSERT') {
                    $suggestedCopy = "Hi {$row->name}! As one of our favourite VIP guests, enjoy a complimentary dessert or sweet treat on us when you order tonight!";
                } elseif ($incType === 'FREE_DELIVERY') {
                    $suggestedCopy = "Hi {$row->name}! We've missed having you. Order your favourite dishes tonight and enjoy FREE delivery on us!";
                } elseif ($incType === 'TARGETED_VOUCHER') {
                    $suggestedCopy = "Hi {$row->name}! Here's a special £3 off your favourite meal when you spend £20+ this evening. Tap here to order!";
                }

                $funnelKey = strtolower($row->relationship_stage ?? 'regular');
                if (isset($funnel[$funnelKey])) {
                    $funnel[$funnelKey]++;
                } else {
                    $funnel['regular']++;
                }

                if ($reorderScore >= 80 || $currentStatus === 'REORDER READY') {
                    $currentStatus = 'REORDER READY';
                    $reorderReadyCount++;
                    $reorderReadyPotential += $aov;
                } elseif ($status === 'AT_RISK' || $churnScore >= 60) {
                    $currentStatus = 'AT RISK';
                    $atRiskCount++;
                    $atRiskPotential += $aov;
                } elseif ($status === 'VIP' && $recencyDays >= 14) {
                    $currentStatus = 'VIP INACTIVE';
                    $vipInactiveCount++;
                    $vipInactivePotential += $aov;
                }

                if ($upsellScore >= 75) {
                    $upsellCount++;
                    $upsellPotential += 4.50;
                }

                $twin = [
                    'user_id' => $row->user_id,
                    'name' => $row->name,
                    'email' => $row->email,
                    'phone' => $row->phone,
                    'orders_count' => (int) $row->res_orders_count,
                    'average_order_value' => $aov,
                    'total_spend' => (float) $row->res_total_spend,
                    'favourite_food' => $favDishName,
                    'typical_day' => $row->typical_order_day ?: 'Friday',
                    'typical_time' => ($row->typical_time_start && $row->typical_time_end) ? substr($row->typical_time_start, 0, 5) . '–' . substr($row->typical_time_end, 0, 5) : '18:45–20:15',
                    'typical_interval' => $typicalInterval,
                    'last_order_days' => $recencyDays,
                    'offer_sensitivity' => ucfirst($row->offer_sensitivity ?: 'low'),
                    'favourite_basket' => $basketString,
                    'customer_value' => $row->customer_value ?: 'Medium',
                    'current_status' => $currentStatus,
                    'relationship_stage' => $status,
                    'scores' => [
                        'reorder' => $reorderScore,
                        'churn' => $churnScore,
                        'upsell' => $upsellScore,
                        'vip' => $vipScore,
                        'offer_sensitivity' => $offerSensScore,
                        'engagement' => $engageScore,
                        'affinity' => $affScore,
                    ],
                    'incentive' => [
                        'type' => $incType,
                        'badge' => $incBadge,
                        'rationale' => $incRationale,
                        'margin_saved' => $marginSaved,
                        'suggested_copy' => $suggestedCopy,
                    ]
                ];

                $digitalTwins[] = $twin;

                if ($currentStatus === 'REORDER READY' && count($nextBestActions) < 6) {
                    $nextBestActions[] = [
                        'category' => 'HIGH PRIORITY',
                        'badge_class' => 'bg-danger',
                        'customer' => $row->name,
                        'customer_id' => $row->user_id,
                        'headline' => "Usually orders every {$typicalInterval} days. Today = day {$recencyDays}.",
                        'potential' => $aov,
                        'incentive_badge' => $incBadge,
                        'recommendation' => "Remind customer about favourite ({$favDishName}). {$incRationale}",
                        'action_label' => 'Create Message',
                        'suggested_copy' => $suggestedCopy,
                        'margin_saved' => $marginSaved,
                    ];
                } elseif ($status === 'VIP' && $recencyDays >= 14 && count($nextBestActions) < 6) {
                    $nextBestActions[] = [
                        'category' => 'HIGH VALUE',
                        'badge_class' => 'bg-warning text-dark',
                        'customer' => $row->name,
                        'customer_id' => $row->user_id,
                        'headline' => "£{$aov} average order. No order for {$recencyDays} days.",
                        'potential' => $aov,
                        'incentive_badge' => $incBadge,
                        'recommendation' => "VIP reactivation: {$incRationale}",
                        'action_label' => 'Create VIP Campaign',
                        'suggested_copy' => $suggestedCopy,
                        'margin_saved' => $marginSaved,
                    ];
                } elseif ($upsellScore >= 80 && count($nextBestActions) < 6) {
                    $nextBestActions[] = [
                        'category' => 'UPSELL',
                        'badge_class' => 'bg-success',
                        'customer' => $row->name,
                        'customer_id' => $row->user_id,
                        'headline' => "Frequently buys mains. Rarely adds dessert or drinks.",
                        'potential' => 4.50,
                        'incentive_badge' => '🛒 Basket Builder',
                        'recommendation' => "Recommend dessert or beverage at checkout. High upsell probability.",
                        'action_label' => 'Recommend Add-On',
                        'suggested_copy' => "Complete your meal: Add a delicious treat to your favourite order tonight!",
                        'margin_saved' => 1.80,
                    ];
                }
            }
        } else {
            // 2. Operational DB Fallback: Compute on-the-fly if hyst_ai database hasn't synced yet
            $orders = Order::with(['items.product'])
                ->where('restaurant_id', $restaurantId)
                ->where('status', 'completed')
                ->orderBy('created_at', 'asc')
                ->get();

            $groupedByUser = $orders->groupBy('user_id');

            // Overall customer spend percentiles for VIP calculation
            $allCustomerSpends = [];
            foreach ($groupedByUser as $userId => $userOrders) {
                $allCustomerSpends[] = (float) $userOrders->sum('total_amount');
            }
            sort($allCustomerSpends);
            $totalCustCount = count($allCustomerSpends);
            $p80Spend = $totalCustCount > 0 ? ($allCustomerSpends[(int) floor($totalCustCount * 0.80)] ?? 100) : 100;

        foreach ($groupedByUser as $userId => $userOrders) {
            $user = User::find($userId);
            if (!$user) {
                continue;
            }

            $orderCount = $userOrders->count();
            $totalSpend = (float) $userOrders->sum('total_amount');
            $aov = $orderCount > 0 ? round($totalSpend / $orderCount, 2) : 0.00;

            $firstOrderDate = $userOrders->first()->created_at;
            $lastOrderDate = $userOrders->last()->created_at;
            $recencyDays = (int) floor((time() - strtotime($lastOrderDate)) / 86400);

            // Calculate Order Intervals
            $intervals = [];
            $prevDate = null;
            foreach ($userOrders as $ord) {
                $curTimestamp = strtotime($ord->created_at);
                if ($prevDate !== null) {
                    $intervals[] = ($curTimestamp - $prevDate) / 86400;
                }
                $prevDate = $curTimestamp;
            }

            $typicalInterval = 0.0;
            if (count($intervals) > 0) {
                $typicalInterval = round(array_sum($intervals) / count($intervals), 1);
            } elseif ($orderCount === 1) {
                $typicalInterval = 7.0; // default estimated baseline
            }

            // Find Favourite Dish & Basket items
            $itemCounts = [];
            $itemNames = [];
            $hasDessertOrDrink = false;
            $hasMainCourse = false;

            foreach ($userOrders as $ord) {
                foreach ($ord->items as $item) {
                    if ($item->product) {
                        $pId = $item->product_id;
                        $pName = $item->product->name;
                        $itemCounts[$pId] = ($itemCounts[$pId] ?? 0) + ($item->qty ?? 1);
                        $itemNames[$pId] = $pName;

                        $lowerName = strtolower($pName);
                        if (str_contains($lowerName, 'drink') || str_contains($lowerName, 'shake') || str_contains($lowerName, 'dessert') || str_contains($lowerName, 'cake') || str_contains($lowerName, 'lassi') || str_contains($lowerName, 'gulab')) {
                            $hasDessertOrDrink = true;
                        } else {
                            $hasMainCourse = true;
                        }
                    }
                }
            }

            arsort($itemCounts);
            $favDishId = key($itemCounts);
            $favDishName = $favDishId ? ($itemNames[$favDishId] ?? 'Special Dish') : 'Special Dish';

            $topItems = array_slice(array_keys($itemCounts), 0, 3);
            $favBasket = [];
            foreach ($topItems as $tid) {
                $favBasket[] = $itemNames[$tid];
            }

            // Typical Order Day & Time Slot
            $dayCounts = [];
            $hourCounts = [];
            foreach ($userOrders as $ord) {
                $dName = date('l', strtotime($ord->created_at));
                $dayCounts[$dName] = ($dayCounts[$dName] ?? 0) + 1;
                $hr = (int) date('H', strtotime($ord->created_at));
                $hourCounts[$hr] = ($hourCounts[$hr] ?? 0) + 1;
            }
            arsort($dayCounts);
            $typicalDay = key($dayCounts) ?? 'Friday';

            arsort($hourCounts);
            $typicalHr = key($hourCounts) ?? 19;
            $typicalTimeSlot = sprintf('%02d:45–%02d:15', max(0, $typicalHr - 1), min(23, $typicalHr + 1));

            // ── STEP 5: THE 7 AI OPPORTUNITY SCORES (0 - 100) ──
            // 1. Reorder Score
            $reorderScore = 20;
            if ($typicalInterval > 0) {
                $diff = abs($recencyDays - $typicalInterval);
                $ratio = $diff / max(1, $typicalInterval);
                $reorderScore = max(10, min(99, (int) round((1 - min(1, $ratio)) * 100)));
                if ($recencyDays >= floor($typicalInterval) && $recencyDays <= ceil($typicalInterval * 1.3)) {
                    $reorderScore = max($reorderScore, 88);
                }
            }

            // 2. Churn Score
            $churnScore = 15;
            if ($typicalInterval > 0 && $recencyDays > $typicalInterval) {
                $churnScore = min(98, (int) round((($recencyDays - $typicalInterval) / max(1, $typicalInterval)) * 70) + 25);
            }
            if ($recencyDays > 60) {
                $churnScore = 95;
            }

            // 3. Upsell Score
            $upsellScore = 40;
            if ($hasMainCourse && !$hasDessertOrDrink) {
                $upsellScore = 85; // prime upsell candidate
            } elseif ($orderCount >= 3) {
                $upsellScore = 70;
            }

            // 4. VIP Score
            $vipScore = min(99, (int) round(($totalSpend / max(1, $p80Spend)) * 80));
            if ($totalSpend >= 300 || $aov >= 40) {
                $vipScore = max($vipScore, 92);
            }

            // 5. Offer Sensitivity (Quantitative 0-100 + Category)
            $offerSensitivityScore = 25;
            $offerSensitivity = 'Low';
            if ($aov < 18) {
                $offerSensitivity = 'High';
                $offerSensitivityScore = 80;
            } elseif ($aov < 30) {
                $offerSensitivity = 'Medium';
                $offerSensitivityScore = 50;
            }

            // 6. Engagement Score
            $engagementScore = min(95, max(30, (int) ($orderCount * 12 + ($recencyDays < 14 ? 30 : 0))));

            // 7. Restaurant Affinity
            $affinityScore = min(99, max(50, 60 + ($orderCount * 5)));

            // ── STEP 6: STOP THINKING "DISCOUNT" (INCENTIVE POLICY ENGINE) ──
            // Default: Protect Margin (0% discount)
            $incentiveType = 'NONE';
            $incentiveBadge = '🛡️ 0% Discount';
            $incentiveRationale = 'Natural buyer — would order anyway without margin-cutting discounts.';
            $suggestedCopy = "{$typicalDay} again? Your favourite {$favDishName} is waiting hot and fresh!";
            $estimatedMarginSaved = round($aov * 0.15, 2); // 15% discount avoided

            if ($vipScore >= 85) {
                // Customer C: High-value VIP -> Complimentary item (value-add, food cost ~£0.80, saves 15-20% cash discount)
                $incentiveType = 'FREE_DESSERT';
                $incentiveBadge = '🍰 Value-Add (Free Treat)';
                $incentiveRationale = 'VIP Customer: Reward with complimentary treat rather than devaluing menu prices.';
                $suggestedCopy = "We appreciate your loyalty! Enjoy a complimentary dessert on your next order tonight.";
                $estimatedMarginSaved = max(0, round(($aov * 0.15) - 0.80, 2));
            } elseif ($recencyDays >= 18 && $aov >= 30) {
                // Customer B: High AOV lapsed -> Free delivery (costs restaurant ~£2.50, protects £35 order)
                $incentiveType = 'FREE_DELIVERY';
                $incentiveBadge = '🚚 Free Delivery';
                $incentiveRationale = 'High-order lapsed customer: Free delivery reactivates without slashing dish prices.';
                $suggestedCopy = "We've missed you! Enjoy free delivery on your favourite {$favDishName} this evening.";
                $estimatedMarginSaved = round(($aov * 0.15) - 2.50, 2);
            } elseif ($offerSensitivityScore >= 75) {
                // Customer D: Price-sensitive buyer -> Small targeted £3 voucher with £20 basket lock
                $incentiveType = 'TARGETED_VOUCHER';
                $incentiveBadge = '🏷️ £3 Targeted Voucher';
                $incentiveRationale = 'Price-sensitive customer: Controlled £3 voucher requiring minimum spend.';
                $suggestedCopy = "Special treat: Get £3 off your order over £20 tonight!";
                $estimatedMarginSaved = 0.00;
            } elseif ($reorderScore >= 80) {
                // Customer A: Orders regularly on schedule -> ZERO discount
                $incentiveType = 'NONE';
                $incentiveBadge = '🛡️ 0% Discount (Margin Safe)';
                $incentiveRationale = 'Regular on routine: Convenience reminder is enough — zero discount required.';
                $suggestedCopy = "Friday food sorted? 🍛 Your favourite {$favDishName} is ready to order in 1 tap.";
                $estimatedMarginSaved = round($aov * 0.15, 2);
            }

            // Lifecycle Stage & Current Digital Twin Status
            $status = 'REGULAR';
            if ($orderCount === 1) {
                $status = 'FIRST_TIME';
                $funnel['second_order']++;
            } elseif ($orderCount <= 3) {
                $status = 'REPEAT';
                $funnel['second_order']++;
            } elseif ($vipScore >= 85) {
                $status = 'VIP';
                $funnel['vip']++;
            } elseif ($recencyDays > 60) {
                $status = 'DORMANT';
                $funnel['dormant']++;
            } elseif ($churnScore >= 75) {
                $status = 'AT_RISK';
                $funnel['at_risk']++;
            } else {
                $status = 'REGULAR';
                $funnel['regular']++;
            }

            // Next Order Window Status
            $currentStatus = 'COOLDOWN';
            if ($reorderScore >= 80) {
                $currentStatus = 'REORDER READY';
                $reorderReadyCount++;
                $reorderReadyPotential += $aov;
            } elseif ($status === 'AT_RISK') {
                $currentStatus = 'AT RISK';
                $atRiskCount++;
                $atRiskPotential += $aov;
            } elseif ($status === 'VIP' && $recencyDays >= 14) {
                $currentStatus = 'VIP INACTIVE';
                $vipInactiveCount++;
                $vipInactivePotential += $aov;
            } elseif ($status === 'DORMANT') {
                $currentStatus = 'DORMANT';
            }

            if ($upsellScore >= 75) {
                $upsellCount++;
                $upsellPotential += 4.50; // Average dessert/beverage basket add-on
            }

            // Digital Twin Object with full Step 5 & Step 6 attributes
            $twin = [
                'user_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'orders_count' => $orderCount,
                'average_order_value' => $aov,
                'total_spend' => $totalSpend,
                'favourite_food' => $favDishName,
                'typical_day' => $typicalDay,
                'typical_time' => $typicalTimeSlot,
                'typical_interval' => $typicalInterval,
                'last_order_days' => $recencyDays,
                'offer_sensitivity' => $offerSensitivity,
                'favourite_basket' => implode(' + ', $favBasket) ?: $favDishName,
                'customer_value' => $vipScore >= 85 ? 'VIP' : ($totalSpend >= 100 ? 'High' : 'Medium'),
                'current_status' => $currentStatus,
                'relationship_stage' => $status,
                // Step 5: The 7 Opportunity Scores
                'scores' => [
                    'reorder' => $reorderScore,
                    'churn' => $churnScore,
                    'upsell' => $upsellScore,
                    'vip' => $vipScore,
                    'offer_sensitivity' => $offerSensitivityScore,
                    'engagement' => $engagementScore,
                    'affinity' => $affinityScore,
                ],
                // Step 6: Margin Protection & Policy
                'incentive' => [
                    'type' => $incentiveType,
                    'badge' => $incentiveBadge,
                    'rationale' => $incentiveRationale,
                    'margin_saved' => $estimatedMarginSaved,
                    'suggested_copy' => $suggestedCopy,
                ]
            ];

            $digitalTwins[] = $twin;

            // Generate Next Best Action Cards (Step 4 & Step 6 Integrated)
            if ($currentStatus === 'REORDER READY' && count($nextBestActions) < 6) {
                $nextBestActions[] = [
                    'category' => 'HIGH PRIORITY',
                    'badge_class' => 'bg-danger',
                    'customer' => $user->name,
                    'customer_id' => $user->id,
                    'headline' => "Usually orders every {$typicalInterval} days. Today = day {$recencyDays}.",
                    'potential' => $aov,
                    'incentive_badge' => $incentiveBadge,
                    'recommendation' => "Remind customer about favourite ({$favDishName}). {$incentiveRationale}",
                    'action_label' => 'Create Message',
                    'suggested_copy' => $suggestedCopy,
                    'margin_saved' => $estimatedMarginSaved,
                ];
            } elseif ($status === 'VIP' && $recencyDays >= 14 && count($nextBestActions) < 6) {
                $nextBestActions[] = [
                    'category' => 'HIGH VALUE',
                    'badge_class' => 'bg-warning text-dark',
                    'customer' => $user->name,
                    'customer_id' => $user->id,
                    'headline' => "£{$aov} average order. No order for {$recencyDays} days.",
                    'potential' => $aov,
                    'incentive_badge' => $incentiveBadge,
                    'recommendation' => "VIP reactivation: {$incentiveRationale}",
                    'action_label' => 'Create VIP Campaign',
                    'suggested_copy' => $suggestedCopy,
                    'margin_saved' => $estimatedMarginSaved,
                ];
            } elseif ($upsellScore >= 80 && count($nextBestActions) < 6) {
                $nextBestActions[] = [
                    'category' => 'UPSELL',
                    'badge_class' => 'bg-success',
                    'customer' => $user->name,
                    'customer_id' => $user->id,
                    'headline' => "Frequently buys mains. Rarely adds dessert or drinks.",
                    'potential' => 4.50,
                    'incentive_badge' => '🛒 Basket Builder',
                    'recommendation' => "Recommend dessert or refreshing drink at checkout. High upsell probability.",
                    'action_label' => 'Recommend Add-On',
                    'suggested_copy' => "Complete your meal: Add a delicious treat to your favourite order tonight!",
                    'margin_saved' => 1.80,
                ];
            }
        }
        }

        // Total Potential Opportunity Today
        $totalPotentialToday = $reorderReadyPotential + $atRiskPotential + $vipInactivePotential + $upsellPotential;

        // Step 6: Calculate Total Restaurant Margin Protected (Avoided blanket discounts)
        $totalMarginProtected = array_sum(array_column(array_column($digitalTwins, 'incentive'), 'margin_saved'));

        // If no actions generated yet, add fallback examples from real top customers
        if (empty($nextBestActions) && !empty($digitalTwins)) {
            $topTwin = $digitalTwins[0];
            $nextBestActions[] = [
                'category' => 'HIGH PRIORITY',
                'badge_class' => 'bg-danger',
                'customer' => $topTwin['name'],
                'customer_id' => $topTwin['user_id'],
                'headline' => "Usually orders every {$topTwin['typical_interval']} days. Current interval = {$topTwin['last_order_days']} days.",
                'potential' => $topTwin['average_order_value'],
                'incentive_badge' => $topTwin['incentive']['badge'],
                'recommendation' => "Reorder reminder: {$topTwin['incentive']['rationale']}",
                'action_label' => 'Create Message',
                'suggested_copy' => $topTwin['incentive']['suggested_copy'],
                'margin_saved' => $topTwin['incentive']['margin_saved'],
            ];
        }

        // Filter digital twins if requested (tab filtering)
        $filter = $request->query('filter', 'all');
        $filteredTwins = $digitalTwins;
        if ($filter === 'reorder_ready') {
            $filteredTwins = array_filter($digitalTwins, fn($t) => $t['current_status'] === 'REORDER READY');
        } elseif ($filter === 'at_risk') {
            $filteredTwins = array_filter($digitalTwins, fn($t) => $t['relationship_stage'] === 'AT_RISK');
        } elseif ($filter === 'vip') {
            $filteredTwins = array_filter($digitalTwins, fn($t) => $t['relationship_stage'] === 'VIP');
        } elseif ($filter === 'dormant') {
            $filteredTwins = array_filter($digitalTwins, fn($t) => $t['relationship_stage'] === 'DORMANT');
        } elseif ($filter === 'margin_safe') {
            $filteredTwins = array_filter($digitalTwins, fn($t) => $t['incentive']['type'] === 'NONE');
        }

        return view('restaurant.ai-analytics.index', compact(
            'restaurant',
            'digitalTwins',
            'filteredTwins',
            'nextBestActions',
            'reorderReadyCount',
            'reorderReadyPotential',
            'atRiskCount',
            'atRiskPotential',
            'vipInactiveCount',
            'vipInactivePotential',
            'upsellCount',
            'upsellPotential',
            'totalPotentialToday',
            'totalMarginProtected',
            'funnel',
            'filter'
        ));
    }
}
