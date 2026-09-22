<?php

namespace App\Http\Controllers\RestaurantAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Restaurant;
use Illuminate\Support\Facades\DB;
use App\Services\Platforms\UberEatsService;
use App\Services\Platforms\DeliverooService;
use App\Services\Platforms\JustEatService;

class PlatformOrderController extends Controller
{
    protected UberEatsService $uberEats;
    protected DeliverooService $deliveroo;
    protected JustEatService $justEat;

    public function __construct(UberEatsService $uberEats, DeliverooService $deliveroo, JustEatService $justEat)
    {
        $this->uberEats  = $uberEats;
        $this->deliveroo = $deliveroo;
        $this->justEat   = $justEat;
    }

    /**
     * Display All Platforms Orders Dashboard with Tabs
     */
    public function index(Request $request)
    {
        $restaurantId = auth()->user()->restaurant_id;

        $tab = $request->get('tab', 'all'); // 'all', 'ubereats', 'deliveroo', 'justeat'

        $ordersQuery = Order::with(['items.product', 'user'])
            ->where('restaurant_id', $restaurantId)
            ->latest();

        if ($tab !== 'all') {
            $ordersQuery->where('platform_source', $tab);
        } else {
            $ordersQuery->whereIn('platform_source', ['ubereats', 'deliveroo', 'justeat', 'internal']);
        }

        $orders = $ordersQuery->paginate(15)->withQueryString();

        // Platform counts
        $counts = [
            'all'       => Order::where('restaurant_id', $restaurantId)->count(),
            'ubereats'  => Order::where('restaurant_id', $restaurantId)->where('platform_source', 'ubereats')->count(),
            'deliveroo' => Order::where('restaurant_id', $restaurantId)->where('platform_source', 'deliveroo')->count(),
            'justeat'   => Order::where('restaurant_id', $restaurantId)->where('platform_source', 'justeat')->count(),
        ];

        // Fetch saved credentials per platform
        $credentialsList = DB::table('restaurant_platform_credentials')
            ->where('restaurant_id', $restaurantId)
            ->get()
            ->keyBy('platform');

        return view('restaurant.platform_orders.index', compact('orders', 'counts', 'credentialsList', 'tab'));
    }

    /**
     * Save / Update Platform Integration Credentials
     */
    public function saveCredentials(Request $request)
    {
        $request->validate([
            'platform'          => 'required|in:ubereats,deliveroo,justeat',
            'is_enabled'        => 'nullable|boolean',
            'store_id'          => 'nullable|string',
            'client_id'         => 'nullable|string',
            'client_secret'     => 'nullable|string',
            'webhook_secret'    => 'nullable|string',
            'prep_time_minutes' => 'nullable|integer|min:5|max:120',
        ]);

        $restaurantId = auth()->user()->restaurant_id;

        DB::table('restaurant_platform_credentials')->updateOrInsert(
            [
                'restaurant_id' => $restaurantId,
                'platform'      => $request->platform,
            ],
            [
                'is_enabled'        => $request->has('is_enabled') ? 1 : 0,
                'store_id'          => $request->store_id,
                'client_id'         => $request->client_id,
                'client_secret'     => $request->client_secret,
                'webhook_secret'    => $request->webhook_secret,
                'prep_time_minutes' => $request->prep_time_minutes ?: 15,
                'updated_at'        => now(),
            ]
        );

        return back()->with('success', ucfirst($request->platform) . ' integration credentials saved successfully!');
    }

    /**
     * Accept Platform Order
     */
    public function acceptOrder(Request $request, $id)
    {
        $order = Order::where('restaurant_id', auth()->user()->restaurant_id)->findOrFail($id);

        $credentials = DB::table('restaurant_platform_credentials')
            ->where('restaurant_id', $order->restaurant_id)
            ->where('platform', $order->platform_source)
            ->first();

        if ($order->platform_source === 'ubereats') {
            $this->uberEats->acceptOrder($order, $credentials);
        } elseif ($order->platform_source === 'deliveroo') {
            $this->deliveroo->acceptOrder($order, $request->prep_time ?? 15, $credentials);
        } elseif ($order->platform_source === 'justeat') {
            $this->justEat->acceptOrder($order, $request->prep_time ?? 15, $credentials);
        }

        $order->update([
            'status'                 => 'completed',
            'platform_order_status'  => 'ACCEPTED',
        ]);

        return back()->with('success', 'Order #' . $order->id . ' accepted on ' . ucfirst($order->platform_source));
    }

    /**
     * Mark Order Prepared / Ready
     */
    public function markPrepared(Request $request, $id)
    {
        $order = Order::where('restaurant_id', auth()->user()->restaurant_id)->findOrFail($id);

        $credentials = DB::table('restaurant_platform_credentials')
            ->where('restaurant_id', $order->restaurant_id)
            ->where('platform', $order->platform_source)
            ->first();

        if ($order->platform_source === 'ubereats') {
            $this->uberEats->markReadyForPickup($order, $credentials);
        } elseif ($order->platform_source === 'deliveroo') {
            $this->deliveroo->markPrepared($order, $credentials);
        } elseif ($order->platform_source === 'justeat') {
            $this->justEat->markReady($order, $credentials);
        }

        $order->update(['platform_order_status' => 'PREPARED']);

        return back()->with('success', 'Order #' . $order->id . ' marked PREPARED for courier collection.');
    }

    /**
     * Toggle Store Status (Open / Pause per platform)
     */
    public function toggleStoreStatus(Request $request)
    {
        $request->validate([
            'platform' => 'required|in:ubereats,deliveroo,justeat',
            'status'   => 'required|in:open,paused',
        ]);

        $restaurantId = auth()->user()->restaurant_id;

        DB::table('restaurant_platform_credentials')
            ->where('restaurant_id', $restaurantId)
            ->where('platform', $request->platform)
            ->update(['store_status' => $request->status, 'updated_at' => now()]);

        return back()->with('success', ucfirst($request->platform) . ' store status set to ' . strtoupper($request->status));
    }
}
