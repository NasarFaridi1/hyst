<?php

namespace App\Http\Controllers\RestaurantAdmin;

use App\Http\Controllers\Controller;

use App\Mail\LoyaltyRewardMail;

use App\Models\LoyaltyRewardLog;

use App\Models\Offer;

use App\Models\User;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Mail;


class LoyaltyRewardController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | LOYALTY AND REWARDS PAGE
    |--------------------------------------------------------------------------
    */

    public function index()
    {

        $restaurantId =
            auth()->user()->restaurant_id;


        /*
        |--------------------------------------------------------------------------
        | RESTAURANT CUSTOMERS
        |--------------------------------------------------------------------------
        */

        $customers = User::whereHas(

            'orders',

            function ($query) use ($restaurantId) {

                $query->where(

                    'restaurant_id',

                    $restaurantId

                );

            }

        )

        ->orderBy('name')

        ->get();


        /*
        |--------------------------------------------------------------------------
        | RESTAURANT ACTIVE OFFERS
        |--------------------------------------------------------------------------
        */

        $offers = Offer::where(

            'restaurant_id',

            $restaurantId

        )

        ->where('is_active', 1)

        ->latest()

        ->get();


        /*
        |--------------------------------------------------------------------------
        | REWARD EMAIL HISTORY
        |--------------------------------------------------------------------------
        */

        $rewardLogs = LoyaltyRewardLog::with(

            'user'

        )

        ->where(

            'restaurant_id',

            $restaurantId

        )

        ->latest('sent_at')

        ->paginate(15);


        return view(

            'restaurant.loyalty.index',

            compact(

                'customers',

                'offers',

                'rewardLogs'

            )

        );

    }



    /*
    |--------------------------------------------------------------------------
    | SEND LOYALTY REWARD
    |--------------------------------------------------------------------------
    */

    public function send(Request $request)
    {

        $request->validate([

            'customers' => [
                'required',
                'array',
                'min:1'
            ],

            'customers.*' => [
                'required',
                'exists:users,id'
            ],

            'reward_type' => [
                'required',
                'in:birthday,festival'
            ],

            'festival_name' => [
                'nullable',
                'required_if:reward_type,festival',
                'string',
                'max:255'
            ],

            'offers' => [
                'required',
                'array',
                'min:1'
            ],

            'offers.*' => [
                'required',
                'exists:offers,id'
            ],

            'subject' => [
                'required',
                'string',
                'max:255'
            ],

            'message' => [
                'required',
                'string'
            ],

        ]);


        $restaurantId =

            auth()->user()->restaurant_id;


        /*
        |--------------------------------------------------------------------------
        | SELECTED USERS
        |--------------------------------------------------------------------------
        */

        $users = User::whereIn(

            'id',

            $request->customers

        )

        ->whereHas(

            'orders',

            function ($query) use ($restaurantId) {

                $query->where(

                    'restaurant_id',

                    $restaurantId

                );

            }

        )

        ->get();


        /*
        |--------------------------------------------------------------------------
        | SELECTED RESTAURANT OFFERS
        |--------------------------------------------------------------------------
        */

        $offers = Offer::whereIn(

            'id',

            $request->offers

        )

        ->where(

            'restaurant_id',

            $restaurantId

        )

        ->where(

            'is_active',

            1

        )

        ->get();


        if ($offers->isEmpty()) {

            return back()

                ->withInput()

                ->withErrors([

                    'offers'
                        => 'Please select a valid active offer.'

                ]);

        }


        $sentCount = 0;

        $failedCount = 0;


        /*
        |--------------------------------------------------------------------------
        | SEND EMAIL
        |--------------------------------------------------------------------------
        */

        foreach ($users as $user) {


            try {


                Mail::to(

                    $user->email

                )

                ->send(

                    new LoyaltyRewardMail(

                        $user,

                        $offers,

                        $request->reward_type,

                        $request->festival_name,

                        $request->subject,

                        $request->message

                    )

                );


                /*
                |--------------------------------------------------------------------------
                | SUCCESS HISTORY
                |--------------------------------------------------------------------------
                */

                LoyaltyRewardLog::create([

                    'restaurant_id'
                        => $restaurantId,

                    'user_id'
                        => $user->id,

                    'reward_type'
                        => $request->reward_type,

                    'festival_name'
                        => $request->festival_name,

                    'subject'
                        => $request->subject,

                    'message'
                        => $request->message,

                    'offers'
                        => $offers
                            ->pluck('id')
                            ->values()
                            ->toArray(),

                    'status'
                        => 'sent',

                    'sent_at'
                        => now(),

                ]);


                $sentCount++;


            } catch (\Throwable $error) {


                /*
                |--------------------------------------------------------------------------
                | FAILED HISTORY
                |--------------------------------------------------------------------------
                */

                LoyaltyRewardLog::create([

                    'restaurant_id'
                        => $restaurantId,

                    'user_id'
                        => $user->id,

                    'reward_type'
                        => $request->reward_type,

                    'festival_name'
                        => $request->festival_name,

                    'subject'
                        => $request->subject,

                    'message'
                        => $request->message,

                    'offers'
                        => $offers
                            ->pluck('id')
                            ->values()
                            ->toArray(),

                    'status'
                        => 'failed',

                    'error_message'
                        => $error->getMessage(),

                    'sent_at'
                        => now(),

                ]);


                $failedCount++;

            }

        }


        return back()->with(

            'success',

            $sentCount
            . ' reward emails sent successfully. '
            . $failedCount
            . ' failed.'

        );

    }

}