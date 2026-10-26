@extends('layouts.app')

@section('content')

<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

    {{-- Breadcrumb & Header --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <div>
            <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-emerald-700 mb-1">
                <span class="w-4 h-0.5 bg-emerald-600 inline-block rounded"></span>
                DIRECT DELIVERY ORDER #{{ $order->id }}
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">
                Direct Delivery Dispatch & Tracking
            </h1>
            <p class="text-xs sm:text-sm text-gray-500 mt-0.5">
                Created on {{ $order->created_at->format('d M Y, h:i A') }} • Paid via Worldpay
            </p>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('restaurant.orders.create_direct_delivery') }}"
               class="bg-emerald-600 hover:bg-emerald-700 text-white font-semibold px-4 py-2 rounded-xl transition duration-150 inline-flex items-center gap-1.5 text-xs sm:text-sm shadow">
                + New Delivery
            </a>
            <a href="{{ url('/restaurant/orders') }}"
               class="bg-black hover:bg-gray-800 text-white font-semibold px-4 py-2 rounded-xl transition duration-150 inline-flex items-center gap-1.5 text-xs sm:text-sm shadow">
                ← Orders List
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-2xl mb-6 text-sm font-semibold flex items-center gap-2 shadow-sm">
            <span class="text-lg">🎉</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    {{-- 1. UBER COURIER LIVE TRACKING BANNER --}}
    <div class="bg-gradient-to-r from-gray-900 to-gray-800 rounded-3xl p-6 text-white shadow-xl mb-6 border border-gray-700">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
            <div class="space-y-2">
                <div class="flex items-center gap-2">
                    <span class="text-2xl">🚗</span>
                    <span class="text-xs uppercase font-extrabold tracking-wider px-2.5 py-0.5 rounded-full 
                        @if($order->uber_delivery_status === 'delivered') bg-emerald-500/20 text-emerald-300 border border-emerald-500/40
                        @elseif($order->uber_delivery_status === 'canceled') bg-red-500/20 text-red-300 border border-red-500/40
                        @else bg-amber-500/20 text-amber-300 border border-amber-500/40 @endif">
                        Uber Status: {{ strtoupper(str_replace('_', ' ', $order->uber_delivery_status ?? 'DISPATCHED')) }}
                    </span>
                </div>
                <h2 class="text-xl sm:text-2xl font-black">
                    @if($order->uber_delivery_status === 'delivered')
                        Package Successfully Delivered
                    @elseif(!empty($order->driver_name))
                        Courier {{ $order->driver_name }} is handling delivery
                    @else
                        Uber Courier is Being Assigned
                    @endif
                </h2>
                <p class="text-xs text-gray-300">
                    Uber Delivery ID: <span class="font-mono text-emerald-400 font-bold">{{ $order->uber_delivery_id ?? 'Pending Assignment' }}</span>
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-3 w-full md:w-auto">
                @if(!empty($order->uber_tracking_url))
                    <a href="{{ $order->uber_tracking_url }}" 
                       target="_blank" 
                       rel="noopener noreferrer"
                       class="bg-emerald-500 hover:bg-emerald-400 text-gray-900 font-extrabold px-5 py-3 rounded-2xl shadow-lg transition duration-150 inline-flex items-center justify-center gap-2 text-sm flex-1 md:flex-initial">
                        <span>🗺️ Open Live Uber Map</span>
                        <span>↗</span>
                    </a>
                @endif

                <button onclick="window.location.reload();" 
                        class="bg-gray-700 hover:bg-gray-600 text-white font-bold px-4 py-3 rounded-2xl shadow transition duration-150 inline-flex items-center justify-center gap-1.5 text-sm flex-1 md:flex-initial">
                    <span>🔄 Refresh Status</span>
                </button>
            </div>
        </div>

        {{-- Courier / Driver details if assigned --}}
        @if(!empty($order->driver_name) || !empty($order->driver_phone))
            <div class="mt-5 pt-5 border-t border-gray-700/80 grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                <div>
                    <span class="text-gray-400 block mb-0.5">Assigned Courier</span>
                    <span class="font-bold text-base text-white">{{ $order->driver_name ?? 'Uber Courier' }}</span>
                </div>
                <div>
                    <span class="text-gray-400 block mb-0.5">Driver Contact</span>
                    @if(!empty($order->driver_phone))
                        <a href="tel:{{ $order->driver_phone }}" class="font-bold text-base text-emerald-400 hover:underline">
                            📞 {{ $order->driver_phone }}
                        </a>
                    @else
                        <span class="text-gray-400">Available in live Uber map</span>
                    @endif
                </div>
            </div>
        @endif
    </div>

    <div class="grid grid-cols-1 md:grid-cols-12 gap-6">

        {{-- 2. ORDER ITEMS & CONTENT (7 Cols) --}}
        <div class="md:col-span-7 space-y-6">

            <div class="bg-white rounded-3xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-base font-extrabold text-gray-900 mb-3 flex items-center gap-2">
                    <span>📦</span> Prepared Items List
                </h3>

                <div class="bg-gray-50 rounded-2xl p-4 border border-gray-200/80">
                    @if(!empty($order->items_text))
                        <pre class="font-mono text-xs sm:text-sm text-gray-800 whitespace-pre-wrap leading-relaxed">{{ $order->items_text }}</pre>
                    @else
                        <p class="text-xs text-gray-500 italic">No detailed items text recorded.</p>
                    @endif
                </div>

                @if(!empty($order->dropoff_notes))
                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <span class="text-xs font-bold uppercase text-gray-500 block mb-1">Customer / Courier Instructions</span>
                        <p class="text-xs text-gray-800 bg-amber-50 p-2.5 rounded-xl border border-amber-200/70">
                            💬 {{ $order->dropoff_notes }}
                        </p>
                    </div>
                @endif
            </div>

            {{-- Pickup & Dropoff Route Card --}}
            <div class="bg-white rounded-3xl shadow-sm border border-gray-200 p-6 space-y-4">
                <h3 class="text-base font-extrabold text-gray-900 flex items-center gap-2">
                    <span>📍</span> Delivery Route
                </h3>

                {{-- Pickup --}}
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-800 flex items-center justify-center font-bold text-xs flex-shrink-0 mt-0.5">
                        A
                    </div>
                    <div class="text-xs">
                        <div class="font-bold text-gray-900 uppercase">Pickup: {{ $restaurant->name }}</div>
                        <div class="text-gray-600">{{ $restaurant->address }}, {{ $restaurant->city }} {{ $restaurant->postcode }}</div>
                        <div class="text-gray-500">Phone: {{ $restaurant->phone }}</div>
                    </div>
                </div>

                <div class="border-l-2 border-dashed border-gray-300 ml-4 h-6"></div>

                {{-- Dropoff --}}
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-800 flex items-center justify-center font-bold text-xs flex-shrink-0 mt-0.5">
                        B
                    </div>
                    <div class="text-xs">
                        <div class="font-bold text-gray-900 uppercase">Dropoff: {{ $order->guest_name }}</div>
                        <div class="text-gray-600">{{ $order->guest_address }}, {{ $order->guest_city }} {{ $order->guest_postcode }}</div>
                        <div class="text-gray-500">
                            Recipient Phone: <a href="tel:{{ $order->guest_phone }}" class="text-emerald-700 font-bold hover:underline">{{ $order->guest_phone }}</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- 3. PAYMENT RECEIPT & DETAILS (5 Cols) --}}
        <div class="md:col-span-5 space-y-6">

            <div class="bg-white rounded-3xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-base font-extrabold text-gray-900 mb-4 flex items-center gap-2">
                    <span>💳</span> Delivery Payment Receipt
                </h3>

                <div class="space-y-3 text-xs">
                    <div class="flex justify-between items-center text-gray-600">
                        <span>Payment Status:</span>
                        <span class="bg-emerald-100 text-emerald-800 font-bold px-2.5 py-0.5 rounded-full">
                            PAID (Worldpay)
                        </span>
                    </div>

                    <div class="flex justify-between items-center text-gray-600">
                        <span>Uber Base Courier Fee:</span>
                        <span class="font-semibold text-gray-900">
                            £{{ number_format($order->uber_base_fee ?? ($order->delivery_charge / 1.20), 2) }}
                        </span>
                    </div>

                    <div class="flex justify-between items-center text-gray-600">
                        <span>HYST Handling Markup (+20%):</span>
                        <span class="font-semibold text-emerald-700">
                            +£{{ number_format($order->uber_markup_fee ?? ($order->delivery_charge - ($order->delivery_charge / 1.20)), 2) }}
                        </span>
                    </div>

                    <div class="pt-3 border-t border-gray-200 flex justify-between items-center text-sm font-extrabold">
                        <span class="text-gray-900">Total Charged:</span>
                        <span class="text-emerald-800 text-lg">£{{ number_format($order->total_amount, 2) }}</span>
                    </div>
                </div>

                <div class="mt-4 pt-4 border-t border-gray-100 text-[11px] text-gray-400 space-y-1">
                    <div>Payment Gateway: <span class="text-gray-600 font-medium">Worldpay Hosted Payment</span></div>
                    <div>Order Reference: <span class="font-mono text-gray-600">#{{ $order->id }}</span></div>
                    <div>Uber Quote Reference: <span class="font-mono text-gray-600">{{ $order->uber_quote_id ?? 'N/A' }}</span></div>
                </div>
            </div>

            {{-- Support Help Card --}}
            <div class="bg-gray-50 rounded-3xl p-5 border border-gray-200 text-xs text-gray-600 space-y-2">
                <div class="font-bold text-gray-900">Need Delivery Support?</div>
                <p>If you need to contact the Uber courier or report an issue, use the live Uber map or call HYST merchant support.</p>
            </div>

        </div>

    </div>

</div>

@endsection
