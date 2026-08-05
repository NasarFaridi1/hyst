@extends('layouts.app')

@section('content')

<style>
@media print {
    .no-print {
        display: none !important;
    }
    body {
        background: white !important;
    }
    .invoice-card {
        box-shadow: none !important;
        border: none !important;
    }
}
</style>

@php
    $isCancelled = in_array(strtolower($order->status), ['cancelled', 'canceled']);
    $paymentStatus = strtolower(optional($order->payment)->payment_status ?? 'pending');
@endphp

<div class="max-w-6xl mx-auto p-3 sm:p-5 lg:p-8">

    <!-- Back Button -->
    <div class="mb-5 no-print">
        <a href="{{ route('restaurant.orders.show', $order->id) }}"
            class="inline-flex items-center gap-2 bg-gray-700 hover:bg-gray-800 text-white px-5 py-2.5 rounded-xl font-medium transition shadow-sm">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            Back to Order Details
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100 invoice-card">

        <!-- Header -->
        <div class="{{ $isCancelled ? 'bg-gradient-to-r from-red-700 to-red-800' : 'bg-gradient-to-r from-[#C25A2A] to-[#E06B36]' }} text-white p-6 sm:p-8">
            <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                <!-- Brand -->
                <div class="text-center md:text-left">
                    <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">HYST</h1>
                    <p class="text-xs sm:text-sm text-orange-100 font-medium">Restaurant Tax Invoice & Receipt</p>
                </div>

                <!-- Restaurant Brand -->
                <div class="text-center">
                    @if(!empty($order->restaurant->image))
                        <img src="{{ str_starts_with($order->restaurant->image, 'http') ? $order->restaurant->image : asset('storage/'.$order->restaurant->image) }}"
                            alt="{{ $order->restaurant->name }}"
                            class="w-16 h-16 sm:w-20 sm:h-20 rounded-full object-cover mx-auto mb-2 border-2 border-white/80 shadow-md">
                    @endif
                    <h3 class="font-bold text-lg sm:text-xl break-words">
                        {{ $order->restaurant->name ?? 'Restaurant' }}
                    </h3>
                </div>

                <!-- Invoice Meta -->
                <div class="text-center md:text-right">
                    @if($isCancelled)
                        <span class="inline-block bg-red-900/80 text-white border border-red-400 px-3 py-1 rounded-full text-xs font-black uppercase tracking-widest mb-1 shadow-sm">
                            ❌ CANCELLED INVOICE
                        </span>
                    @else
                        <span class="inline-block bg-white/20 backdrop-blur-md px-3 py-1 rounded-full text-xs font-semibold uppercase tracking-wider mb-1">
                            Invoice
                        </span>
                    @endif
                    <h2 class="text-2xl sm:text-3xl font-bold">
                        {{ $order->invoice->invoice_number ?? ('INV-'.$order->id) }}
                    </h2>
                    <p class="text-xs sm:text-sm text-orange-100 mt-1">
                        Issued: {{ optional($order->invoice->invoice_date ?? $order->created_at)->format('d M Y, h:i A') }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Prominent Cancellation Banner if Cancelled -->
        @if($isCancelled)
            <div class="bg-red-50 border-b-2 border-red-200 p-4 sm:p-5 text-red-900 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-3 text-center sm:text-left">
                    <span class="text-3xl sm:text-4xl">❌</span>
                    <div>
                        <div class="font-black text-base sm:text-lg uppercase tracking-wider text-red-800">ORDER CANCELLED</div>
                        <p class="text-xs sm:text-sm text-red-700 font-medium">This order was cancelled and is no longer active.</p>
                        @if(!empty($order->cancel_reason))
                            <p class="text-xs text-red-600 mt-0.5 font-semibold"><strong>Cancellation Reason:</strong> {{ $order->cancel_reason }}</p>
                        @endif
                    </div>
                </div>
                <span class="bg-red-600 text-white font-extrabold px-4 py-1.5 rounded-full text-xs uppercase tracking-widest shadow-sm whitespace-nowrap">
                    Status: Cancelled
                </span>
            </div>
        @endif

        <div class="p-4 sm:p-6 lg:p-8">

            <!-- Information Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">

                <!-- Customer Details -->
                <div class="bg-gray-50/80 rounded-xl p-5 border border-gray-100">
                    <div class="flex items-center gap-2 text-[#C25A2A] font-bold text-base mb-3 pb-2 border-b border-gray-200/60">
                        <i data-lucide="user" class="w-4 h-4"></i>
                        <span>Customer Details</span>
                    </div>
                    <div class="space-y-2 text-xs sm:text-sm text-gray-700">
                        <p class="break-words">
                            <span class="font-semibold text-gray-900">Name:</span>
                            {{ optional($order->user)->name ?? $order->name ?? 'Guest Customer' }}
                        </p>
                        <p class="break-words">
                            <span class="font-semibold text-gray-900">Phone:</span>
                            {{ $order->phone ?? optional($order->user)->phone ?? '—' }}
                        </p>
                        <p class="break-words">
                            <span class="font-semibold text-gray-900">Address:</span>
                            {{ $order->address ?? '—' }}
                        </p>
                        <p class="break-words">
                            <span class="font-semibold text-gray-900">Postcode:</span>
                            {{ $order->pincode ?? '—' }}
                        </p>
                    </div>
                </div>

                <!-- Restaurant Details -->
                <div class="bg-gray-50/80 rounded-xl p-5 border border-gray-100">
                    <div class="flex items-center gap-2 text-[#C25A2A] font-bold text-base mb-3 pb-2 border-b border-gray-200/60">
                        <i data-lucide="store" class="w-4 h-4"></i>
                        <span>Restaurant Details</span>
                    </div>
                    <div class="space-y-2 text-xs sm:text-sm text-gray-700">
                        <p class="break-words">
                            <span class="font-semibold text-gray-900">Name:</span>
                            {{ $order->restaurant->name ?? '—' }}
                        </p>
                        <p class="break-words">
                            <span class="font-semibold text-gray-900">Phone:</span>
                            {{ $order->restaurant->phone ?? '—' }}
                        </p>
                        <p class="break-words">
                            <span class="font-semibold text-gray-900">Location:</span>
                            {{ $order->restaurant->location ?? '—' }}
                        </p>
                    </div>
                </div>

                <!-- Order & Invoice Info -->
                <div class="bg-gray-50/80 rounded-xl p-5 border border-gray-100">
                    <div class="flex items-center gap-2 text-[#C25A2A] font-bold text-base mb-3 pb-2 border-b border-gray-200/60">
                        <i data-lucide="file-text" class="w-4 h-4"></i>
                        <span>Order & Status Details</span>
                    </div>
                    <div class="space-y-2.5 text-xs sm:text-sm text-gray-700">
                        <p class="flex justify-between items-center">
                            <span class="font-semibold text-gray-900">Order ID:</span>
                            <span class="font-mono bg-gray-200 px-1.5 py-0.5 rounded text-xs font-bold">#{{ $order->id }}</span>
                        </p>
                        <p class="flex justify-between items-center">
                            <span class="font-semibold text-gray-900">Order Type:</span>
                            <span class="font-semibold text-gray-900 capitalize">{{ str_replace('_', ' ', $order->order_type) }}</span>
                        </p>
                        @if($order->is_scheduled && $order->scheduled_for)
                            <p class="text-amber-800 font-semibold bg-amber-50 p-1.5 rounded-lg border border-amber-200/60 text-xs">
                                📅 Scheduled: {{ \Carbon\Carbon::parse($order->scheduled_for)->format('d M Y, h:i A') }}
                            </p>
                        @endif

                        <!-- ORDER STATUS BADGE -->
                        <div class="flex justify-between items-center pt-1 border-t border-gray-200/60">
                            <span class="font-semibold text-gray-900">Order Status:</span>
                            @if($isCancelled)
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-extrabold uppercase bg-red-100 text-red-800 border border-red-300">
                                    ❌ Cancelled
                                </span>
                            @elseif(in_array(strtolower($order->status), ['completed', 'delivered']))
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-extrabold uppercase bg-emerald-100 text-emerald-800 border border-emerald-300">
                                    ✓ {{ ucfirst($order->status) }}
                                </span>
                            @elseif(in_array(strtolower($order->status), ['accepted', 'preparing', 'ready']))
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-extrabold uppercase bg-blue-100 text-blue-800 border border-blue-300">
                                    {{ ucfirst($order->status) }}
                                </span>
                            @else
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-extrabold uppercase bg-amber-100 text-amber-800 border border-amber-300">
                                    ⏳ {{ ucfirst($order->status) }}
                                </span>
                            @endif
                        </div>

                        <!-- PAYMENT STATUS BADGE -->
                        <div class="flex justify-between items-center">
                            <span class="font-semibold text-gray-900">Payment Status:</span>
                            @if($paymentStatus === 'paid')
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-extrabold uppercase bg-emerald-100 text-emerald-800 border border-emerald-300">
                                    ✓ Paid ({{ $order->payment_method ?? 'Card' }})
                                </span>
                            @elseif(in_array($paymentStatus, ['failed', 'cancelled']))
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-extrabold uppercase bg-red-100 text-red-800 border border-red-300">
                                    ❌ {{ ucfirst($paymentStatus) }}
                                </span>
                            @elseif(in_array($paymentStatus, ['refunded', 'partially_refunded']))
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-extrabold uppercase bg-purple-100 text-purple-800 border border-purple-300">
                                    ↩ {{ ucfirst(str_replace('_', ' ', $paymentStatus)) }}
                                </span>
                            @else
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-extrabold uppercase bg-amber-100 text-amber-800 border border-amber-300">
                                    ⏳ {{ ucfirst($paymentStatus) }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

            </div>

            <!-- Items Table -->
            <div class="rounded-xl border border-gray-200 overflow-hidden mb-8 shadow-sm">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs sm:text-sm">
                        <thead>
                            <tr class="bg-gray-100/80 text-gray-700 font-bold uppercase text-[11px] tracking-wider border-b border-gray-200">
                                <th class="px-4 py-3 sm:px-6">Item Description</th>
                                <th class="px-4 py-3 text-center sm:px-6">Qty</th>
                                <th class="px-4 py-3 text-right sm:px-6">Unit Price</th>
                                <th class="px-4 py-3 text-right sm:px-6">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @php $calcSubtotal = 0; @endphp
                            @foreach($order->items as $item)
                                @php
                                    $itemTotal = $item->total ?? ($item->price * $item->quantity);
                                    $calcSubtotal += $itemTotal;
                                    $unitPrice = $item->quantity > 0 ? ($itemTotal / $item->quantity) : $item->price;
                                @endphp
                                <tr class="hover:bg-gray-50/50 transition">
                                    <td class="px-4 py-3.5 sm:px-6 break-words">
                                        <div class="font-bold text-gray-900 text-sm sm:text-base">
                                            {{ $item->product->name ?? $item->product_name ?? 'Item' }}
                                        </div>
                                        @if(!empty($item->variant_name))
                                            <div class="text-xs text-gray-500 font-medium mt-0.5">
                                                Variant: {{ $item->variant_name }}
                                            </div>
                                        @endif

                                        @if($item->addons && $item->addons->count())
                                            @php $groupedAddons = $item->addons->groupBy('category_name'); @endphp
                                            <div class="mt-2 space-y-1">
                                                @foreach($groupedAddons as $category => $addons)
                                                    <div class="text-[11px] font-bold text-gray-700">
                                                        {{ $category ?: 'Addons' }}:
                                                    </div>
                                                    <div class="flex flex-wrap gap-1.5">
                                                        @foreach($addons as $addon)
                                                            <span class="inline-flex items-center gap-1 bg-amber-50 text-amber-900 border border-amber-200/80 px-2 py-0.5 rounded-full text-[11px] font-medium">
                                                                <span>{{ $addon->addon_name }}</span>
                                                                <span class="font-bold text-[#C25A2A]">+£{{ number_format($addon->price, 2) }}</span>
                                                            </span>
                                                        @endforeach
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3.5 text-center sm:px-6 font-semibold text-gray-700">
                                        {{ $item->quantity }}
                                    </td>
                                    <td class="px-4 py-3.5 text-right sm:px-6 font-medium text-gray-600 whitespace-nowrap">
                                        £{{ number_format($unitPrice, 2) }}
                                    </td>
                                    <td class="px-4 py-3.5 text-right sm:px-6 font-bold text-gray-900 whitespace-nowrap">
                                        £{{ number_format($itemTotal, 2) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Financial Totals Summary -->
            <div class="flex flex-col md:flex-row justify-between items-start gap-6 border-t border-gray-200 pt-6">

                <!-- Special Notes / Instructions -->
                <div class="w-full md:w-1/2">
                    @if(!empty($order->description))
                        <div class="bg-amber-50/70 border border-amber-200/80 rounded-xl p-4 text-xs sm:text-sm text-amber-900 mb-4">
                            <span class="font-bold block mb-1">Order Special Instructions:</span>
                            <p class="italic text-gray-700">{{ $order->description }}</p>
                        </div>
                    @endif
                    <div class="text-xs text-gray-500 space-y-1">
                        <p>• Thank you for operating with {{ $order->restaurant->name ?? 'HYST' }}.</p>
                        <p>• This official invoice details itemized breakdown and discount redemption.</p>
                    </div>
                </div>

                <!-- Calculation Rows -->
                <div class="w-full md:w-5/12 space-y-2.5 text-xs sm:text-sm text-gray-700 bg-gray-50/80 p-5 rounded-xl border border-gray-100">
                    
                    <div class="flex justify-between items-center pb-1">
                        <span class="font-medium text-gray-600">Items Subtotal</span>
                        <span class="font-bold text-gray-900">£{{ number_format($order->invoice->subtotal ?? $calcSubtotal, 2) }}</span>
                    </div>

                    @if($order->delivery_charge > 0)
                    <div class="flex justify-between items-center pb-1">
                        <span class="font-medium text-gray-600">Delivery Fee</span>
                        <span class="font-bold text-gray-900">£{{ number_format($order->delivery_charge, 2) }}</span>
                    </div>
                    @endif

                    @if($order->hyst_charge > 0)
                    <div class="flex justify-between items-center pb-1">
                        <span class="font-medium text-gray-600">Operational Charge (HYST)</span>
                        <span class="font-bold text-gray-900">£{{ number_format($order->hyst_charge, 2) }}</span>
                    </div>
                    @endif

                    <!-- Discounts -->
                    @if(($order->offer_discount ?? 0) > 0)
                    <div class="flex justify-between items-center pb-1 text-red-600">
                        <span class="font-medium flex items-center gap-1">
                            <span>🎉 Offer Discount</span>
                            @if(!empty($order->offer_title))
                                <span class="text-[11px] font-semibold text-amber-800">({{ $order->offer_title }})</span>
                            @endif
                        </span>
                        <span class="font-bold">-£{{ number_format($order->offer_discount, 2) }}</span>
                    </div>
                    @endif

                    @if($order->coupon_discount > 0)
                    <div class="flex justify-between items-center pb-1 text-red-600">
                        <span class="font-medium">Coupon Discount</span>
                        <span class="font-bold">-£{{ number_format($order->coupon_discount, 2) }}</span>
                    </div>
                    @endif

                    @if($order->gift_card_amount > 0)
                    <div class="flex justify-between items-center pb-1 text-red-600">
                        <span class="font-medium">Gift Card Applied</span>
                        <span class="font-bold">-£{{ number_format($order->gift_card_amount, 2) }}</span>
                    </div>
                    @endif

                    @if(($order->loyalty_discount ?? 0) > 0)
                    <div class="flex justify-between items-center pb-1 text-red-600">
                        <span class="font-medium flex items-center gap-1">
                            <span>Loyalty Reward Discount</span>
                            <span class="text-[10px] bg-amber-100 text-amber-900 px-1.5 py-0.5 rounded font-bold">REDEEMED</span>
                        </span>
                        <span class="font-bold">-£{{ number_format($order->loyalty_discount, 2) }}</span>
                    </div>
                    @endif

                    <div class="border-t border-gray-300 pt-3 mt-2 flex justify-between items-center">
                        <span class="text-base sm:text-lg font-extrabold text-gray-900">Total Amount</span>
                        <span class="text-xl sm:text-2xl font-extrabold text-[#C25A2A]">£{{ number_format($order->total_amount, 2) }}</span>
                    </div>

                </div>

            </div>

            <!-- Footer & Actions -->
            <div class="mt-8 pt-6 border-t border-gray-200 flex flex-col sm:flex-row items-center justify-between gap-4 no-print">
                <div class="text-xs text-gray-400">
                    Generated on {{ now()->format('d M Y, h:i A') }}
                </div>
                <div class="flex items-center gap-3 w-full sm:w-auto">
                    <button onclick="window.print()"
                        class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold px-6 py-2.5 rounded-xl transition shadow-sm">
                        <i data-lucide="printer" class="w-4 h-4"></i>
                        Print / Download PDF
                    </button>
                    <a href="{{ route('restaurant.orders.show', $order->id) }}"
                        class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-gray-600 hover:bg-gray-700 text-white font-semibold px-6 py-2.5 rounded-xl transition shadow-sm">
                        Back to Order Details
                    </a>
                </div>
            </div>

        </div>

    </div>

</div>

@endsection