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
     * Display All Platforms Orders Dashboard with Tabs (Live API Proxy Mode)
     */
    public function index(Request $request)
    {
        $restaurantId = auth()->user()->restaurant_id;
        $tab = $request->get('tab', 'all'); // 'all', 'ubereats', 'deliveroo', 'justeat'

        // Fetch saved credentials per platform for this restaurant
        $credentialsList = DB::table('restaurant_platform_credentials')
            ->where('restaurant_id', $restaurantId)
            ->get()
            ->keyBy('platform');

        $liveOrders = [];

        $ueCred = $credentialsList['ubereats'] ?? null;
        $dlCred = $credentialsList['deliveroo'] ?? null;
        $jeCred = $credentialsList['justeat'] ?? null;

        // Fetch Live Orders via APIs dynamically without database storage
        if ($tab === 'ubereats' || $tab === 'all') {
            $ueOrders = $this->uberEats->fetchActiveOrders($ueCred);
            foreach ($ueOrders as $o) {
                $o['platform'] = 'ubereats';
                $liveOrders[]  = $o;
            }
        }

        if ($tab === 'deliveroo' || $tab === 'all') {
            $dlOrders = $this->deliveroo->fetchActiveOrders($dlCred);
            foreach ($dlOrders as $o) {
                $o['platform'] = 'deliveroo';
                $liveOrders[]  = $o;
            }
        }

        if ($tab === 'justeat' || $tab === 'all') {
            $jeOrders = $this->justEat->fetchActiveOrders($jeCred);
            foreach ($jeOrders as $o) {
                $o['platform'] = 'justeat';
                $liveOrders[]  = $o;
            }
        }

        // Live Counts
        $counts = [
            'all'       => count($liveOrders),
            'ubereats'  => count(array_filter($liveOrders, fn($i) => ($i['platform'] ?? '') === 'ubereats')),
            'deliveroo' => count(array_filter($liveOrders, fn($i) => ($i['platform'] ?? '') === 'deliveroo')),
            'justeat'   => count(array_filter($liveOrders, fn($i) => ($i['platform'] ?? '') === 'justeat')),
        ];

        return view('restaurant.platform_orders.index', compact('liveOrders', 'counts', 'credentialsList', 'tab'));
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
     * Accept Platform Order via Platform API
     */
    public function acceptOrder(Request $request, $id)
    {
        $restaurantId = auth()->user()->restaurant_id;
        $platform     = $request->input('platform', 'ubereats');

        $credentials = DB::table('restaurant_platform_credentials')
            ->where('restaurant_id', $restaurantId)
            ->where('platform', $platform)
            ->first();

        if ($platform === 'ubereats') {
            $this->uberEats->acceptOrder($id, $credentials);
        } elseif ($platform === 'deliveroo') {
            $this->deliveroo->acceptOrder($id, $request->prep_time ?? 15, $credentials);
        } elseif ($platform === 'justeat') {
            $this->justEat->acceptOrder($id, $request->prep_time ?? 15, $credentials);
        }

        return back()->with('success', 'Order #' . $id . ' accepted on ' . ucfirst($platform));
    }

    /**
     * Mark Order Prepared / Ready via Platform API
     */
    public function markPrepared(Request $request, $id)
    {
        $restaurantId = auth()->user()->restaurant_id;
        $platform     = $request->input('platform', 'ubereats');

        $credentials = DB::table('restaurant_platform_credentials')
            ->where('restaurant_id', $restaurantId)
            ->where('platform', $platform)
            ->first();

        if ($platform === 'ubereats') {
            $this->uberEats->markReadyForPickup($id, $credentials);
        } elseif ($platform === 'deliveroo') {
            $this->deliveroo->markPrepared($id, $credentials);
        } elseif ($platform === 'justeat') {
            $this->justEat->markReady($id, $credentials);
        }

        return back()->with('success', 'Order #' . $id . ' marked PREPARED for courier collection.');
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
