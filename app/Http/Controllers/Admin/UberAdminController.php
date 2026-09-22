<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\UberService;
use App\Models\Order;
use App\Models\Restaurant;

class UberAdminController extends Controller
{
    protected UberService $uberService;

    public function __construct(UberService $uberService)
    {
        $this->uberService = $uberService;
    }

    /**
     * Update Delivery (e.g. dropoff_notes, dropoff address/lat/lng)
     */
    public function updateDelivery(Request $request, $id)
    {
        $request->validate([
            'dropoff_notes' => 'nullable|string|max:500',
            'dropoff_latitude' => 'nullable|numeric',
            'dropoff_longitude' => 'nullable|numeric',
        ]);

        $order = Order::findOrFail($id);

        if (empty($order->uber_delivery_id)) {
            return back()->with('error', 'Order has no active Uber delivery ID.');
        }

        $restaurant = $order->restaurant;

        $response = $this->uberService->updateDelivery(
            $order->uber_delivery_id,
            $request->only(['dropoff_notes', 'dropoff_latitude', 'dropoff_longitude']),
            $restaurant
        );

        if (isset($response['id']) || isset($response['delivery_id'])) {
            if ($request->filled('dropoff_notes')) {
                $order->update(['dropoff_notes' => $request->dropoff_notes]);
            }
            return back()->with('success', 'Uber delivery updated successfully.');
        }

        return back()->with('error', 'Failed to update Uber delivery: ' . ($response['message'] ?? 'Unknown error'));
    }

    /**
     * Request Uber Delivery Refund
     */
    public function requestRefund(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|string',
            'amount' => 'nullable|numeric|min:0.01',
        ]);

        $order = Order::findOrFail($id);

        if (empty($order->uber_delivery_id)) {
            return back()->with('error', 'Order has no active Uber delivery ID.');
        }

        $response = $this->uberService->requestRefund(
            $order->uber_delivery_id,
            $request->reason,
            $request->amount,
            $order->restaurant
        );

        if (isset($response['id']) || isset($response['refund_id']) || isset($response['status'])) {
            return back()->with('success', 'Uber refund request submitted successfully.');
        }

        return back()->with('error', 'Failed to request Uber refund: ' . ($response['message'] ?? 'Unknown error'));
    }

    /**
     * Fetch & Refresh Live Delivery Status (GET /v1/customers/{customer_id}/deliveries/{delivery_id})
     */
    public function refreshDeliveryStatus($id)
    {
        $order = Order::findOrFail($id);

        if (empty($order->uber_delivery_id)) {
            return back()->with('error', 'Order has no active Uber delivery ID.');
        }

        $data = $this->uberService->getDelivery($order->uber_delivery_id, $order->restaurant);

        if (!empty($data['id'])) {
            $courier = $data['courier'] ?? [];
            $status  = $data['status'] ?? $order->uber_delivery_status;

            $order->update(array_filter([
                'uber_delivery_status' => $status,
                'uber_tracking_url'    => $data['tracking_url'] ?? $order->uber_tracking_url,
                'uber_driver_name'     => $courier['name'] ?? $order->uber_driver_name,
                'uber_driver_phone'    => $courier['phone_number'] ?? $order->uber_driver_phone,
            ], fn($val) => !is_null($val)));

            return back()->with('success', 'Live Uber status refreshed: ' . strtoupper(str_replace('_', ' ', $status)));
        }

        return back()->with('error', 'Failed to fetch Uber delivery details: ' . ($data['message'] ?? 'Unknown error'));
    }

    /**
     * Fetch Proof of Delivery
     */
    public function proofOfDelivery($id)
    {
        $order = Order::findOrFail($id);

        if (empty($order->uber_delivery_id)) {
            return back()->with('error', 'Order has no active Uber delivery ID.');
        }

        $response = $this->uberService->getProofOfDelivery($order->uber_delivery_id, 'picture', $order->restaurant);

        return response()->json($response);
    }

    /**
     * Create New Organization for a Restaurant
     */
    public function createOrganization(Request $request, $id)
    {
        $restaurant = Restaurant::findOrFail($id);

        $response = $this->uberService->createOrganization($restaurant);

        if (!empty($response['organization_id'])) {
            return back()->with('success', 'Uber Organization created successfully! Org ID: ' . $response['organization_id']);
        }

        return back()->with('error', 'Failed to create Uber Organization: ' . ($response['message'] ?? json_encode($response)));
    }

    /**
     * Invite Member to Organization (POST /v1/direct/organizations/{org_id}/memberships/invite)
     */
    public function inviteMember(Request $request, $id)
    {
        $request->validate([
            'email'      => 'required|email',
            'first_name' => 'nullable|string',
            'last_name'  => 'nullable|string',
            'role'       => 'required|in:ADMIN,EMPLOYEE',
        ]);

        $restaurant = Restaurant::findOrFail($id);
        $orgId = $restaurant->uber_organization_id ?: config('services.uber.customer_id');

        $response = $this->uberService->inviteUserToOrganization(
            $request->email,
            $request->first_name ?? 'Admin',
            $request->last_name ?? ($restaurant->name ?? 'User'),
            $orgId,
            $request->role
        );

        return back()->with('success', 'Uber Direct Organization invitation sent to ' . $request->email . ' as ' . $request->role);
    }
}
