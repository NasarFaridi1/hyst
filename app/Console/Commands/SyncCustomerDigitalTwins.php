<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;
use Exception;

class SyncCustomerDigitalTwins extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hyst:sync-digital-twins';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Extract operational order data from main DB, compute Customer 360 & Digital Twin patterns, and update hyst_ai_growth DB.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $startTime = now();
        $this->info('Starting Customer Digital Twin Sync Process...');

        // 1. Log Job Execution Start
        $logId = null;
        try {
            $logId = DB::connection('hyst_ai')->table('etl_sync_logs')->insertGetId([
                'job_name' => 'SyncCustomerDigitalTwins',
                'status' => 'running',
                'started_at' => $startTime,
            ]);
        } catch (Exception $e) {
            $this->warn('Could not log start to etl_sync_logs: ' . $e->getMessage());
        }

        try {
            // 2. Fetch all customers using Eloquent User model so encrypted casts (email, phone) are decrypted automatically
            $customers = User::where('role', 'user')->get();

            $processedCount = 0;

            foreach ($customers as $user) {
                // Fetch completed orders for this user
                $orders = DB::connection('mysql')->table('orders')
                    ->where('user_id', $user->id)
                    ->where('status', 'completed')
                    ->orderBy('created_at', 'asc')
                    ->get();

                $totalOrders = $orders->count();
                $totalSpend = (float) $orders->sum('total_amount');
                $avgOrderValue = $totalOrders > 0 ? round($totalSpend / $totalOrders, 2) : 0.00;

                $firstOrderAt = $orders->first()?->created_at;
                $lastOrderAt = $orders->last()?->created_at;
                
                $recencyDays = 0;
                if ($lastOrderAt) {
                    $recencyDays = (int) floor((time() - strtotime($lastOrderAt)) / 86400);
                }

                // Compute Average Interval between orders (in days)
                $typicalInterval = 0.00;
                if ($totalOrders > 1 && $firstOrderAt && $lastOrderAt) {
                    $spanDays = (strtotime($lastOrderAt) - strtotime($firstOrderAt)) / 86400;
                    $typicalInterval = round($spanDays / ($totalOrders - 1), 2);
                }

                // Find Favourite Restaurant
                $favRestaurant = DB::connection('mysql')->table('orders')
                    ->select('restaurant_id', DB::raw('COUNT(*) as cnt'))
                    ->where('user_id', $user->id)
                    ->where('status', 'completed')
                    ->groupBy('restaurant_id')
                    ->orderByDesc('cnt')
                    ->first();

                // Find Favourite Dish
                $favDish = DB::connection('mysql')->table('order_items as oi')
                    ->join('orders as o', 'o.id', '=', 'oi.order_id')
                    ->join('products as p', 'p.id', '=', 'oi.product_id')
                    ->select('oi.product_id', 'p.name as dish_name', DB::raw('SUM(oi.quantity) as total_qty'))
                    ->where('o.user_id', $user->id)
                    ->where('o.status', 'completed')
                    ->groupBy('oi.product_id', 'p.name')
                    ->orderByDesc('total_qty')
                    ->first();

                // Find Favourite Basket Combination (Top 3 most ordered items)
                $favBasket = DB::connection('mysql')->table('order_items as oi')
                    ->join('orders as o', 'o.id', '=', 'oi.order_id')
                    ->join('products as p', 'p.id', '=', 'oi.product_id')
                    ->where('o.user_id', $user->id)
                    ->where('o.status', 'completed')
                    ->select('p.name')
                    ->groupBy('p.name')
                    ->orderByRaw('SUM(oi.quantity) DESC')
                    ->limit(3)
                    ->pluck('p.name')
                    ->toArray();

                // Find Typical Order Day of Week (e.g. Friday)
                $typicalDayRaw = DB::connection('mysql')->table('orders')
                    ->select(DB::raw('DAYNAME(created_at) as day_name'), DB::raw('COUNT(*) as cnt'))
                    ->where('user_id', $user->id)
                    ->where('status', 'completed')
                    ->groupBy('day_name')
                    ->orderByDesc('cnt')
                    ->first()?->day_name;

                // Find Peak Order Window Hour (e.g. 18:45–20:15)
                $typicalHour = DB::connection('mysql')->table('orders')
                    ->select(DB::raw('HOUR(created_at) as hr'), DB::raw('COUNT(*) as cnt'))
                    ->where('user_id', $user->id)
                    ->where('status', 'completed')
                    ->groupBy('hr')
                    ->orderByDesc('cnt')
                    ->first()?->hr;

                $timeStart = $typicalHour !== null ? sprintf('%02d:45:00', max(0, $typicalHour - 1)) : null;
                $timeEnd = $typicalHour !== null ? sprintf('%02d:15:00', min(23, $typicalHour + 1)) : null;

                // Step 1: Relationship Stage Classification
                $stage = 'new';
                if ($totalOrders == 1) {
                    $stage = 'first_time';
                } elseif ($totalOrders >= 2 && $totalOrders <= 3) {
                    $stage = 'repeat';
                } elseif ($totalOrders >= 4) {
                    $stage = 'regular';
                    if ($totalSpend >= 300) {
                        $stage = 'vip';
                    }
                    if ($typicalInterval > 0 && $recencyDays > ($typicalInterval * 2)) {
                        $stage = 'at_risk';
                    }
                }
                if ($recencyDays > 60 && $totalOrders > 0) {
                    $stage = 'dormant';
                }

                // Step 2: Current Digital Twin Status
                $currentStatus = 'COOLDOWN';
                if ($totalOrders > 0 && $typicalInterval > 0) {
                    if ($recencyDays >= floor($typicalInterval)) {
                        $currentStatus = 'REORDER_READY';
                    }
                    if ($recencyDays > ($typicalInterval * 1.5)) {
                        $currentStatus = 'OVERDUE';
                    }
                }
                if ($stage === 'at_risk') {
                    $currentStatus = 'AT_RISK';
                }
                if ($stage === 'dormant') {
                    $currentStatus = 'DORMANT';
                }

                // Value & Sensitivity Scoring
                $customerValue = 'medium';
                if ($totalSpend >= 300 || $avgOrderValue >= 45) {
                    $customerValue = 'high';
                }
                if ($totalSpend >= 600) {
                    $customerValue = 'vip';
                }
                if ($totalSpend < 50 && $totalOrders > 0) {
                    $customerValue = 'low';
                }

                $offerSensitivity = 'medium';
                if ($avgOrderValue > 35) {
                    $offerSensitivity = 'low';
                }

                // Reorder Probability Calculation
                $reorderProb = 0.00;
                if ($typicalInterval > 0) {
                    $ratio = $recencyDays / $typicalInterval;
                    if ($ratio >= 0.8 && $ratio <= 1.3) {
                        $reorderProb = 88.50;
                    } elseif ($ratio > 1.3 && $ratio <= 2.0) {
                        $reorderProb = 62.00;
                    } elseif ($ratio < 0.8) {
                        $reorderProb = 20.00;
                    }
                }

                // Ensure email and phone are 100% decrypted plain text
                $userEmail = (string) $user->email;
                $userPhone = (string) $user->phone;
                $userPostcode = (string) ($user->postcode ?? null);

                if (str_starts_with($userEmail, 'eyJ')) {
                    try {
                        $userEmail = Crypt::decryptString($userEmail);
                    } catch (Exception $e) {
                        // ignore if not decryptable
                    }
                }

                if (str_starts_with($userPhone, 'eyJ')) {
                    try {
                        $userPhone = Crypt::decryptString($userPhone);
                    } catch (Exception $e) {
                        // ignore if not decryptable
                    }
                }

                // 3. Upsert into hyst_ai_growth.customer_digital_twins
                DB::connection('hyst_ai')->table('customer_digital_twins')->updateOrInsert(
                    ['user_id' => $user->id],
                    [
                        'name' => $user->name ?? 'Customer',
                        'email' => $userEmail,
                        'phone' => $userPhone,
                        'area_postcode' => $userPostcode,
                        'total_orders' => $totalOrders,
                        'total_spend' => $totalSpend,
                        'average_order_value' => $avgOrderValue,
                        'first_order_at' => $firstOrderAt,
                        'last_order_at' => $lastOrderAt,
                        'recency_days' => $recencyDays,
                        'typical_interval_days' => $typicalInterval,
                        'favourite_restaurant_id' => $favRestaurant?->restaurant_id,
                        'favourite_food_id' => $favDish?->product_id,
                        'favourite_food_name' => $favDish?->dish_name,
                        'favourite_basket_items' => json_encode($favBasket),
                        'typical_order_day' => $typicalDayRaw,
                        'typical_time_start' => $timeStart,
                        'typical_time_end' => $timeEnd,
                        'offer_sensitivity' => $offerSensitivity,
                        'customer_value' => $customerValue,
                        'relationship_stage' => $stage,
                        'current_status' => $currentStatus,
                        'reorder_probability' => $reorderProb,
                        'updated_at' => now(),
                    ]
                );

                // 4. Update Customer-Restaurant Affinities
                $restaurantBreakdowns = DB::connection('mysql')->table('orders')
                    ->select('restaurant_id', DB::raw('COUNT(*) as order_cnt'), DB::raw('SUM(total_amount) as spend'), DB::raw('MAX(created_at) as last_order'))
                    ->where('user_id', $user->id)
                    ->where('status', 'completed')
                    ->groupBy('restaurant_id')
                    ->get();

                foreach ($restaurantBreakdowns as $res) {
                    $resStatus = 'discovered';
                    if ($res->order_cnt == 1) $resStatus = 'first_order';
                    elseif ($res->order_cnt >= 2 && $res->order_cnt <= 3) $resStatus = 'returning';
                    elseif ($res->order_cnt >= 4) $resStatus = 'regular';
                    if ($res->spend >= 300) $resStatus = 'vip';

                    DB::connection('hyst_ai')->table('customer_restaurant_affinities')->updateOrInsert(
                        [
                            'user_id' => $user->id,
                            'restaurant_id' => $res->restaurant_id,
                        ],
                        [
                            'orders_count' => $res->order_cnt,
                            'total_spend' => $res->spend,
                            'last_order_at' => $res->last_order,
                            'status' => $resStatus,
                            'updated_at' => now(),
                        ]
                    );
                }

                $processedCount++;
            }

            // 5. Update Log to Success
            if ($logId) {
                DB::connection('hyst_ai')->table('etl_sync_logs')->where('id', $logId)->update([
                    'status' => 'success',
                    'records_processed' => $processedCount,
                    'completed_at' => now(),
                ]);
            }

            $this->info("Successfully synced {$processedCount} Customer Digital Twins!");

        } catch (Exception $e) {
            if ($logId) {
                DB::connection('hyst_ai')->table('etl_sync_logs')->where('id', $logId)->update([
                    'status' => 'failed',
                    'error_message' => $e->getMessage(),
                    'completed_at' => now(),
                ]);
            }
            $this->error("ETL Sync execution failed: " . $e->getMessage());
        }
    }
}