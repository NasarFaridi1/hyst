<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FCMController extends Controller
{
    public function saveToken(Request $request)
    {
        $token = $request->token;

        if (empty($token)) {
            return response()->json(['success' => false, 'message' => 'Token empty']);
        }

        if (auth()->check()) {
            auth()->user()->update([
                'fcm_token' => $token
            ]);
            \Log::info('FCM TOKEN SAVED FOR USER #' . auth()->id() . ' (' . auth()->user()->role . ')', [
                'token' => substr($token, 0, 25) . '...'
            ]);
        }

        session(['guest_fcm_token' => $token]);

        return response()->json([
            'success' => true,
            'user_id' => auth()->id()
        ]);
    }
}