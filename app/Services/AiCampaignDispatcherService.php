<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;
use App\Models\Restaurant;
use App\Models\User;
use App\Models\Notification;
use App\Services\FirebaseNotificationService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class AiCampaignDispatcherService
{
    protected ?FirebaseNotificationService $firebase = null;

    public function __construct()
    {
        try {
            $this->firebase = new FirebaseNotificationService();
        } catch (Throwable $e) {
            Log::warning('AiCampaignDispatcherService: Firebase init error: ' . $e->getMessage());
            $this->firebase = null;
        }
    }

    /**
     * Dispatch automated AI campaigns for a single restaurant
     */
    public function dispatchForRestaurant(int $restaurantId): array
    {
        $restaurant = Restaurant::find($restaurantId);
        if (!$restaurant) {
            return [
                'status' => 'error',
                'message' => 'Restaurant not found.',
                'dispatched_count' => 0,
                'skipped_fatigue_count' => 0,
            ];
        }

        // Fetch distinct customer IDs with completed orders at this restaurant
        $customerIds = Order::where('restaurant_id', $restaurantId)
            ->where('status', 'completed')
            ->distinct()
            ->pluck('user_id');

        if ($customerIds->isEmpty()) {
            return [
                'status' => 'success',
                'message' => "No completed customer orders found for {$restaurant->name}.",
                'dispatched_count' => 0,
                'skipped_fatigue_count' => 0,
            ];
        }

        $users = User::whereIn('id', $customerIds)->where('role', 'user')->get();

        $dispatchedCount = 0;
        $skippedFatigueCount = 0;
        $details = [];

        foreach ($users as $user) {
            // STEP 20: 7-DAY FATIGUE GUARD (ANTI-SPAM)
            $recentlyContacted = Notification::where('user_id', $user->id)
                ->where('type', 'like', 'ai_%')
                ->where('created_at', '>=', now()->subDays(7))
                ->exists();

            if ($recentlyContacted) {
                $skippedFatigueCount++;
                continue;
            }

            // Customer order history at this restaurant
            $orders = Order::where('restaurant_id', $restaurantId)
                ->where('user_id', $user->id)
                ->where('status', 'completed')
                ->orderBy('created_at', 'asc')
                ->get();

            $orderCount = $orders->count();
            if ($orderCount === 0) continue;

            $totalSpend = (float) $orders->sum('total_amount');
            $firstOrder = $orders->first();
            $lastOrder = $orders->last();
            $lastOrderTime = $lastOrder?->created_at ? strtotime($lastOrder->created_at) : time();
            $recencyDays = (int) floor((time() - $lastOrderTime) / 86400);

            // Compute typical interval
            $typicalInterval = 7.0;
            if ($orderCount > 1 && $firstOrder && $lastOrder) {
                $spanDays = (strtotime($lastOrder->created_at) - strtotime($firstOrder->created_at)) / 86400;
                $typicalInterval = round($spanDays / ($orderCount - 1), 1);
                if ($typicalInterval < 1.0) $typicalInterval = 1.0;
            }

            // Resolve Favourite Dish
            $favProduct = DB::table('order_items as oi')
                ->join('orders as o', 'o.id', '=', 'oi.order_id')
                ->join('products as p', 'p.id', '=', 'oi.product_id')
                ->where('o.restaurant_id', $restaurantId)
                ->where('o.user_id', $user->id)
                ->where('o.status', 'completed')
                ->select('p.name', DB::raw('SUM(oi.quantity) as total_qty'))
                ->groupBy('p.id', 'p.name')
                ->orderByDesc('total_qty')
                ->first();

            $favDish = $favProduct?->name ?: "Chef's Special";

            // Determine which AI campaign applies
            $campaign = $this->determineCampaign($restaurant, $user, $orderCount, $totalSpend, $recencyDays, $typicalInterval, $favDish);

            if (!$campaign) {
                continue;
            }

            // Execute Notification Dispatch via Existing HYST Notification System
            $this->sendAiNotification(
                $user,
                $restaurant,
                $campaign['type'],
                $campaign['title'],
                $campaign['message'],
                $campaign['click_url'],
                $campaign['reference_type']
            );

            $dispatchedCount++;
            $details[] = [
                'user_id' => $user->id,
                'campaign' => $campaign['type'],
                'fcm_sent' => !empty($user->fcm_token),
            ];
        }

        return [
            'status' => 'success',
            'message' => "Dispatched {$dispatchedCount} automated AI notifications ({$skippedFatigueCount} suppressed by 7-Day Fatigue Guard).",
            'dispatched_count' => $dispatchedCount,
            'skipped_fatigue_count' => $skippedFatigueCount,
            'details' => $details,
        ];
    }

    /**
     * Dispatch campaigns for all active restaurants (called by Cron)
     */
    public function dispatchAll(): array
    {
        $restaurants = Restaurant::where('is_active', 1)->get();
        if ($restaurants->isEmpty()) {
            $restaurants = Restaurant::all();
        }

        $totalDispatched = 0;
        $totalSkipped = 0;

        foreach ($restaurants as $restaurant) {
            try {
                $result = $this->dispatchForRestaurant($restaurant->id);
                $totalDispatched += ($result['dispatched_count'] ?? 0);
                $totalSkipped += ($result['skipped_fatigue_count'] ?? 0);
            } catch (Throwable $e) {
                Log::error("AiCampaignDispatcherService failed for restaurant {$restaurant->id}: " . $e->getMessage());
            }
        }

        return [
            'status' => 'success',
            'total_restaurants' => $restaurants->count(),
            'total_dispatched' => $totalDispatched,
            'total_skipped_fatigue' => $totalSkipped,
        ];
    }

    /**
     * Algorithmic Rule Engine: Matches customer to the single best campaign
     */
    protected function determineCampaign(
        Restaurant $restaurant,
        User $user,
        int $orderCount,
        float $totalSpend,
        int $recencyDays,
        float $typicalInterval,
        string $favDish
    ): ?array {
        $hour = (int) now()->format('H');

        // 1. VIP Gratitude (Top spenders >= £150 or >= 5 orders, active within 30 days)
        if (($totalSpend >= 150 || $orderCount >= 5) && $recencyDays <= 30) {
            return [
                'type' => 'ai_vip_gratitude',
                'title' => "👑 VIP Treat from {$restaurant->name}",
                'message' => "Thank you for being one of our most valued guests! Chef has prepared a complimentary treat for your next order tonight.",
                'click_url' => url("/order/usual/{$user->id}/{$restaurant->id}"),
                'reference_type' => 'order_usual',
            ];
        }

        // 2. Habit Reorder Nudge (Order due today based on natural frequency interval)
        if ($orderCount >= 2 && $recencyDays >= max(1, (int) round($typicalInterval - 1)) && $recencyDays <= (int) round($typicalInterval + 4)) {
            return [
                'type' => 'ai_habit_reorder',
                'title' => "🍛 Dinner sorted from {$restaurant->name}?",
                'message' => "Your favourite {$favDish} is ready to order in 1 tap tonight! Chef is preparing fresh orders now.",
                'click_url' => url("/order/usual/{$user->id}/{$restaurant->id}"),
                'reference_type' => 'order_usual',
            ];
        }

        // 3. Win-Back Lapsed Customer (Missed cycle, 21 to 90 days inactive)
        if ($orderCount >= 2 && $recencyDays >= 21 && $recencyDays <= 90) {
            return [
                'type' => 'ai_winback',
                'title' => "❤️ We've missed you at {$restaurant->name}!",
                'message' => "Chef has prepared a complimentary treat for your next order tonight. We'd love to welcome you back!",
                'click_url' => url("/restaurant/{$restaurant->id}"),
                'reference_type' => 'restaurant',
            ];
        }

        // 4. Quiet-Time Capacity Filler (Midday / afternoon slot between 14:00 - 17:30)
        if ($hour >= 13 && $hour <= 17 && $recencyDays <= 21) {
            return [
                'type' => 'ai_quiet_time',
                'title' => "☕ Afternoon Treat from {$restaurant->name}",
                'message' => "Enjoy a complimentary Chef's treat with any order over £15 between 2:30 PM & 5:30 PM today!",
                'click_url' => url("/restaurant/{$restaurant->id}"),
                'reference_type' => 'restaurant',
            ];
        }

        return null;
    }

    /**
     * Dispatch notification via existing HYST system
     */
    protected function sendAiNotification(
        User $user,
        Restaurant $restaurant,
        string $type,
        string $title,
        string $message,
        string $clickUrl,
        string $referenceType
    ): void {
        // 1. Create In-App Notification (Customer Bell Icon)
        try {
            if (function_exists('sendNotification')) {
                sendNotification(
                    $user->id,
                    $type,
                    $title,
                    $message,
                    $referenceType,
                    $restaurant->id,
                    null
                );
            } else {
                Notification::create([
                    'user_id' => $user->id,
                    'type' => $type,
                    'title' => $title,
                    'message' => $message,
                    'reference_type' => $referenceType,
                    'reference_id' => $restaurant->id,
                    'order_id' => null,
                ]);
            }
        } catch (Throwable $e) {
            Log::error("AiCampaignDispatcherService in-app notification failed for user {$user->id}: " . $e->getMessage());
        }

        // 2. Dispatch Firebase Cloud Messaging (FCM Push to Mobile Phone)
        if (!empty($user->fcm_token) && $this->firebase) {
            try {
                $this->firebase->send($user->fcm_token, $title, $message, $clickUrl);
            } catch (Throwable $fcmEx) {
                Log::warning("AiCampaignDispatcherService FCM failed for user {$user->id}: " . $fcmEx->getMessage());
            }
        }
    }
}
