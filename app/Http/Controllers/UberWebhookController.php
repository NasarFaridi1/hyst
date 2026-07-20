<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UberWebhookController extends Controller
{
    public function handle(Request $request)
    {
        Log::info('Uber Webhook', $request->all());

        $payload = $request->all();

        $deliveryId = $payload['delivery_id'];

        $order = Order::where(
            'uber_delivery_id',
            $deliveryId
        )->first();

        if(!$order){

            return response()->json([
                'success'=>false,
                'message'=>'Order not found'
            ]);

        }

        $data = $payload['data'];

        $order->update([

            'uber_delivery_status' => $payload['status'],
            'courier_imminent' => $data['courier_imminent'] ?? false,

            'uber_tracking_url' => $data['tracking_url'] ?? null,

            'uber_driver_name' => $data['courier']['name'] ?? null,

            'uber_driver_phone' => $data['courier']['phone_number'] ?? null,

            'uber_driver_id' => $data['courier']['public_phone_info']['pin_code'] ?? null,

            'uber_picked_at' => $data['pickup']['status_timestamp'] ?? null,

            'uber_delivered_at' => $data['dropoff']['status_timestamp'] ?? null,

            'uber_vehicle_type'=>$data['courier']['vehicle_type'] ?? null,

            'uber_vehicle_make'=>$data['courier']['vehicle_make'] ?? null,

            'uber_vehicle_model'=>$data['courier']['vehicle_model'] ?? null,

            'uber_vehicle_plate'=>$data['courier']['vehicle_license_plate'] ?? null,

            'uber_driver_lat'=>$data['courier']['location']['lat'] ?? null,

            'uber_driver_lng'=>$data['courier']['location']['lng'] ?? null,

        ]);

        return response()->json([
            'success'=>true
        ]);
    }
}