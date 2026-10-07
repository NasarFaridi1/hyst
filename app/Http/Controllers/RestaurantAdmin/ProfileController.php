<?php

namespace App\Http\Controllers\RestaurantAdmin;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $restaurant = Restaurant::findOrFail(
            auth()->user()->restaurant_id
        );

        return view(
            'restaurant.profile.index',
            compact('restaurant')
        );
    }

    public function update(Request $request)
    {
        $restaurant = Restaurant::findOrFail(
            auth()->user()->restaurant_id
        );

        $image = $restaurant->image;

        if ($request->hasFile('image')) {

            $image = $request->file('image')
                ->store('restaurants', 'public');
        }

        $certificate = $restaurant->hygiene_certificate;

        if ($request->hasFile('hygiene_certificate')) {

            $file = $request->file('hygiene_certificate');

            $fileName = time().'_'.$file->getClientOriginalName();

            $file->move(public_path('restaurant-certificates'), $fileName);

            $certificate = 'restaurant-certificates/'.$fileName;
        }

        $updateData = [

            'name' => $request->name,

            'email' => $request->email ?? auth()->user()->email,

            'phone' => $request->phone,

            'location' => $request->location,
            
            'address' => $request->location,

            'latitude' => $request->latitude,

            'longitude' => $request->longitude,

            'city' => $request->city,

            'state' => $request->state,

            'country' => $request->country,

            'postcode' => $request->postcode,

            'description' => $request->description,

            'image' => $image,

            'dine_in' => $request->dine_in,

            'table_book' => $request->table_book,

            'home_delivery' => $request->home_delivery,

            'hygiene_rating' => $request->hygiene_rating,

            'hygiene_certificate' => $certificate,
        ];

        $daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        $openingHoursInput = $request->input('opening_hours', []);

        if (is_array($openingHoursInput) && !empty($openingHoursInput)) {
            $openingHoursData = [];
            $enabledDays = [];
            $firstOpenTime = null;
            $firstCloseTime = null;

            foreach ($daysOfWeek as $day) {
                $dayData = $openingHoursInput[$day] ?? [];
                $isEnabled = isset($dayData['enabled']) && ($dayData['enabled'] == '1' || $dayData['enabled'] == 'on' || $dayData['enabled'] == true);
                $openTime = $dayData['open'] ?? '09:00';
                $closeTime = $dayData['close'] ?? '22:00';

                if ($isEnabled) {
                    $enabledDays[] = $day;
                    if (!$firstOpenTime) {
                        $firstOpenTime = $openTime;
                        $firstCloseTime = $closeTime;
                    }
                }

                $openingHoursData[$day] = [
                    'enabled' => $isEnabled,
                    'open'    => $openTime,
                    'close'   => $closeTime,
                ];
            }

            $updateData['opening_hours'] = $openingHoursData;
            $updateData['working_days'] = implode(',', $enabledDays);
            $updateData['opening_time'] = $firstOpenTime ?? $request->opening_time;
            $updateData['closing_time'] = $firstCloseTime ?? $request->closing_time;
        } else {
            $updateData['working_days'] = $request->filled('working_days')
                ? implode(',', $request->working_days)
                : null;
            $updateData['opening_time'] = $request->opening_time;
            $updateData['closing_time'] = $request->closing_time;
        }

        $updateData = array_merge($updateData, [
            'allow_asap' => $request->input('allow_asap', 1),
            'allow_schedule' => $request->input('allow_schedule', 1),
            'notification_sound' => $request->input('notification_sound', 'hyst_notification.mp3'),
            'dietary_categories' => $request->input('dietary_categories', []),
            'verifone_enabled' => $request->has('verifone_enabled') ? (bool)$request->verifone_enabled : $restaurant->verifone_enabled,
            'verifone_uid' => $request->input('verifone_uid', $restaurant->verifone_uid),
            'verifone_api_key' => $request->input('verifone_api_key', $restaurant->verifone_api_key),
            'verifone_serial_number' => $request->input('verifone_serial_number', $restaurant->verifone_serial_number),
            'verifone_poiid' => $request->input('verifone_poiid', $restaurant->verifone_poiid),
            'verifone_sale_id' => $request->input('verifone_sale_id', $restaurant->verifone_sale_id ?? 'RetailPOS'),
            'verifone_environment' => $request->input('verifone_environment', $restaurant->verifone_environment ?? 'sandbox'),
        ]);

        $restaurant->update($updateData);

        // If Verifone is enabled and Serial Number is provided, automatically query Status API to fetch POIID & EntityUID
        if ($restaurant->verifone_enabled && ($restaurant->verifone_serial_number || $restaurant->verifone_poiid)) {
            try {
                app(\App\Services\VerifonePosService::class)->checkStatus($restaurant);
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::warning('Auto fetch Verifone status failed: ' . $e->getMessage());
            }
        }

        return back()->with(
            'success',
            'Profile Updated Successfully'
        );
    }


    public function updateStatus(Request $request)
    {
        $request->validate([
            'restaurant_status' => 'required|in:Open,Closed',
        ]);

        $restaurant = Restaurant::findOrFail(auth()->user()->restaurant_id);

        $restaurant->update([
            'restaurant_status' => $request->restaurant_status,
        ]);

        return back()->with('success', 'Restaurant status updated successfully.');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => ['required', 'string', 'confirmed', new \App\Rules\PasswordComplexity()],
        ]);

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password does not match.'])->withInput();
        }

        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        return back()->with('success', 'Password changed successfully.');
    }
}