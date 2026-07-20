<!DOCTYPE html>

<html>

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        {{ $emailSubject }}
    </title>

</head>


<body style="
    margin: 0;
    padding: 30px 15px;
    background: #F6F1E8;
    font-family: Arial, sans-serif;
">


<table
    width="100%"
    cellspacing="0"
    cellpadding="0"
    border="0"
>

    <tr>

        <td align="center">


            <table
                width="600"
                cellspacing="0"
                cellpadding="0"
                border="0"
                style="
                    width: 100%;
                    max-width: 600px;
                    background: #FFFFFF;
                    border-radius: 20px;
                    overflow: hidden;
                    box-shadow: 0 10px 40px rgba(26, 18, 8, 0.12);
                "
            >


                {{-- TOP ACCENT STRIP --}}

                <tr>

                    <td style="
                        height: 6px;
                        background: linear-gradient(90deg, #C25A2A, #C99A3C, #C25A2A);
                        font-size: 0;
                        line-height: 0;
                    ">&nbsp;</td>

                </tr>



                {{-- EMAIL HEADER --}}

                <tr>

                    <td style="
                        padding: 50px 35px 45px;
                        color: #FFFFFF;
                        text-align: center;
                        background: linear-gradient(135deg, #C25A2A 0%, #8C3D1A 100%);
                        position: relative;
                    ">

                        <div style="
                            display: inline-block;
                            padding: 6px 18px;
                            margin-bottom: 18px;
                            border: 1px solid rgba(255,255,255,0.4);
                            border-radius: 30px;
                            font-size: 11px;
                            font-weight: bold;
                            letter-spacing: 2px;
                            text-transform: uppercase;
                            color: #FDE8D8;
                        ">

                            HYST Restaurant

                        </div>

                        <br>

                        @if($rewardType === 'birthday')

                            <div style="font-size: 46px; line-height: 1; margin-bottom: 12px;">
                                🎂
                            </div>

                            <h1 style="
                                margin: 0;
                                font-size: 30px;
                                font-weight: 800;
                                letter-spacing: 0.5px;
                            ">

                                Happy Birthday!

                            </h1>

                            <p style="
                                margin: 10px 0 0;
                                font-size: 14px;
                                color: #FDE8D8;
                                letter-spacing: 0.5px;
                            ">

                                A little something special, just for you 🎈

                            </p>

                        @else

                            <div style="font-size: 46px; line-height: 1; margin-bottom: 12px;">
                                🎉
                            </div>

                            <h1 style="
                                margin: 0;
                                font-size: 30px;
                                font-weight: 800;
                                letter-spacing: 0.5px;
                            ">

                                Happy {{ $festivalName }}!

                            </h1>

                            <p style="
                                margin: 10px 0 0;
                                font-size: 14px;
                                color: #FDE8D8;
                                letter-spacing: 0.5px;
                            ">

                                Celebrating the season with a treat for you

                            </p>

                        @endif

                    </td>

                </tr>



                {{-- EMAIL CONTENT --}}

                <tr>

                    <td style="
                        padding: 40px 35px 10px;
                        color: #2E2318;
                    ">


                        {{-- CUSTOMER NAME --}}

                        <h2 style="
                            margin: 0 0 16px;
                            font-size: 21px;
                            color: #1A1208;
                        ">

                            Hello {{ $customer->name }}, 👋

                        </h2>



                        {{-- CUSTOM MESSAGE --}}

                        <div style="
                            font-size: 15.5px;
                            line-height: 1.85;
                            color: #6B5C46;
                        ">

                            {!! nl2br(e($emailMessage)) !!}

                        </div>



                        {{-- DIVIDER --}}

                        <table width="100%" cellspacing="0" cellpadding="0" style="margin: 32px 0 26px;">
                            <tr>
                                <td style="border-top: 1px dashed #E0D5C0; font-size: 0; line-height: 0;">&nbsp;</td>
                            </tr>
                        </table>



                        {{-- OFFERS TITLE --}}

                        <table width="100%" cellspacing="0" cellpadding="0">
                            <tr>
                                <td>
                                    <span style="
                                        display: inline-block;
                                        padding: 5px 14px;
                                        background: #FDE8D8;
                                        color: #8C3D1A;
                                        border-radius: 20px;
                                        font-size: 11px;
                                        font-weight: bold;
                                        letter-spacing: 1px;
                                        text-transform: uppercase;
                                    ">
                                        🎁 Your Rewards
                                    </span>
                                </td>
                            </tr>
                        </table>



                        {{-- SELECTED OFFERS --}}

                        @foreach($offers as $offer)


                            <table width="100%" cellspacing="0" cellpadding="0" style="margin-top: 16px;">

                                <tr>

                                    <td style="
                                        padding: 22px;
                                        background: #F6F1E8;
                                        border: 1.5px dashed #D9A87B;
                                        border-radius: 14px;
                                    ">

                                        <table width="100%" cellspacing="0" cellpadding="0">

                                            <tr>

                                                <td>

                                                    {{-- OFFER NAME --}}

                                                    <h3 style="
                                                        margin: 0 0 6px;
                                                        color: #1A1208;
                                                        font-size: 17px;
                                                    ">

                                                        {{ $offer->title }}

                                                    </h3>



                                                    {{-- OFFER DESCRIPTION --}}

                                                    @if($offer->description)

                                                        <p style="
                                                            margin: 6px 0 0;
                                                            color: #8A7A62;
                                                            font-size: 13.5px;
                                                            line-height: 1.6;
                                                        ">

                                                            {{ $offer->description }}

                                                        </p>

                                                    @endif

                                                </td>

                                                <td align="right" valign="top" style="white-space: nowrap;">

                                                    {{-- OFFER DISCOUNT BADGE --}}

                                                    <div style="
                                                        display: inline-block;
                                                        padding: 10px 16px;
                                                        background: #3D8C5A;
                                                        color: #FFFFFF;
                                                        border-radius: 10px;
                                                        font-size: 16px;
                                                        font-weight: 800;
                                                        line-height: 1;
                                                    ">

                                                        @if($offer->value_type === 'percentage')

                                                            {{ $offer->value }}% OFF

                                                        @else

                                                            £{{ $offer->value }} OFF

                                                        @endif

                                                    </div>

                                                </td>

                                            </tr>

                                            @if($offer->end_date)

                                                <tr>

                                                    <td colspan="2" style="padding-top: 14px;">

                                                        <span style="
                                                            display: inline-block;
                                                            padding: 4px 10px;
                                                            background: #FFFFFF;
                                                            border: 1px solid #E0D5C0;
                                                            border-radius: 20px;
                                                            color: #8A7A62;
                                                            font-size: 11px;
                                                            font-weight: 600;
                                                        ">

                                                            ⏳ Valid until {{ \Carbon\Carbon::parse($offer->end_date)->format('d M Y') }}

                                                        </span>

                                                    </td>

                                                </tr>

                                            @endif

                                        </table>

                                    </td>

                                </tr>

                            </table>


                        @endforeach



                        {{-- CTA BUTTON --}}

                        <table width="100%" cellspacing="0" cellpadding="0" style="margin-top: 34px;">
                            <tr>
                                <td align="center">

                                    <a href="{{ $restaurantUrl ?? '#' }}" style="
                                        display: inline-block;
                                        padding: 15px 42px;
                                        background: #C25A2A;
                                        color: #FFFFFF;
                                        text-decoration: none;
                                        border-radius: 10px;
                                        font-size: 14.5px;
                                        font-weight: bold;
                                        letter-spacing: 0.3px;
                                        box-shadow: 0 6px 18px rgba(194,90,42,0.35);
                                    ">

                                        Order Now &nbsp;→

                                    </a>

                                </td>
                            </tr>
                        </table>



                        {{-- THANK YOU MESSAGE --}}

                        <p style="
                            margin: 34px 0 30px;
                            color: #8A7A62;
                            font-size: 13.5px;
                            line-height: 1.7;
                            text-align: center;
                        ">

                            Thank you for being our valued customer. We can't wait to serve you again. 💛

                        </p>


                    </td>

                </tr>



                {{-- EMAIL FOOTER --}}

                <tr>

                    <td style="
                        padding: 26px 35px;
                        color: #8A7A62;
                        background: #F6F1E8;
                        text-align: center;
                        border-top: 1px solid #E0D5C0;
                    ">

                        <p style="
                            margin: 0 0 6px;
                            color: #2E2318;
                            font-size: 13px;
                            font-weight: bold;
                        ">

                            HYST Restaurant

                        </p>

                        <p style="
                            margin: 0;
                            font-size: 11.5px;
                            line-height: 1.6;
                        ">

                            © {{ date('Y') }} HYST Restaurant. All rights reserved.
                            <br>
                            This offer was sent to you as a valued customer.

                        </p>

                    </td>

                </tr>


                {{-- BOTTOM ACCENT STRIP --}}

                <tr>

                    <td style="
                        height: 4px;
                        background: #C25A2A;
                        font-size: 0;
                        line-height: 0;
                    ">&nbsp;</td>

                </tr>


            </table>


        </td>

    </tr>

</table>


</body>

</html>