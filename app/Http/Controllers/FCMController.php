<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FCMController extends Controller
{
    public function saveToken(Request $request)
    {
        auth()->user()->update([

            'fcm_token' =>
                $request->token

        ]);

        return response()->json([

            'success' => true

        ]);
    }
}