<?php

namespace App\Http\Controllers\RestaurantAdmin;

use App\Http\Controllers\Controller;

use App\Mail\MarketingMail;

use App\Models\MarketingEmailLog;

use App\Models\User;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Facades\Log;


class MarketingController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | MARKETING PAGE
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
        | EMAIL HISTORY
        |--------------------------------------------------------------------------
        */

        $emailLogs = MarketingEmailLog::where(

            'restaurant_id',

            $restaurantId

        )

        ->latest('sent_at')

        ->paginate(15);


        return view(

            'restaurant.marketing.index',

            compact(

                'customers',

                'emailLogs'

            )

        );

    }



    /*
    |--------------------------------------------------------------------------
    | SEND MARKETING EMAIL
    |--------------------------------------------------------------------------
    */

    public function send(Request $request)
    {

        $request->validate([

            'customers' => [
                'required',
                'array'
            ],

            'customers.*' => [
                'exists:users,id'
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
        | SECURITY:
        | SIRF IS RESTAURANT KE CUSTOMERS
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


        $sentCount = 0;

        $failedCount = 0;


        /*
        |--------------------------------------------------------------------------
        | SEND EMAIL AND SAVE HISTORY
        |--------------------------------------------------------------------------
        */

        foreach ($users as $user) {

            try {


                Mail::to(

                    $user->email

                )

                ->send(

                    new MarketingMail(

                        $request->subject,

                        $request->message,

                        $user

                    )

                );


                /*
                |--------------------------------------------------------------------------
                | SUCCESS EMAIL SAVE
                |--------------------------------------------------------------------------
                */

                MarketingEmailLog::create([

                    'restaurant_id'
                        => $restaurantId,

                    'user_id'
                        => $user->id,

                    'customer_name'
                        => $user->name,

                    'customer_email'
                        => $user->email,

                    'subject'
                        => $request->subject,

                    'message'
                        => $request->message,

                    'status'
                        => 'sent',

                    'sent_at'
                        => now(),

                ]);


                $sentCount++;


            } catch (\Throwable $error) {


                /*
                |--------------------------------------------------------------------------
                | FAILED EMAIL BHI DATABASE ME SAVE HOGI
                |--------------------------------------------------------------------------
                */

                MarketingEmailLog::create([

                    'restaurant_id'
                        => $restaurantId,

                    'user_id'
                        => $user->id,

                    'customer_name'
                        => $user->name,

                    'customer_email'
                        => $user->email,

                    'subject'
                        => $request->subject,

                    'message'
                        => $request->message,

                    'status'
                        => 'failed',

                    'error_message'
                        => $error->getMessage(),

                    'sent_at'
                        => now(),

                ]);


                Log::error(

                    'Marketing email failed',

                    [

                        'customer_id'
                            => $user->id,

                        'email'
                            => $user->email,

                        'error'
                            => $error->getMessage(),

                    ]

                );


                $failedCount++;

            }

        }


        return back()->with(

            'success',

            $sentCount
            . ' emails sent successfully. '
            . $failedCount
            . ' emails failed.'

        );

    }

}