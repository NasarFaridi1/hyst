@extends('layouts.app')

@section('title', 'Order #' . $order->id)

@section('content')
<div class="space-y-6">

    <div class="flex items-center justify-between">
        <a href="{{ route('support.orders.index') }}" class="inline-flex items-center gap-2 text-xs font-bold text-slate-600 hover:text-slate-900 bg-white border border-slate-200 px-4 py-2 rounded-xl transition">
            ← Back to Orders
        </a>
        <span class="px-3 py-1 rounded-full text-xs font-bold uppercase bg-orange-100 text-orange-800">
            Status: {{ $order->status }}
        </span>
    </div>

    <!-- ORDER SUMMARY CARD -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- ORDER DETAILS & ITEMS -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
                <h3 class="text-sm font-bold uppercase tracking-wider text-slate-400 border-b border-slate-100 pb-3">Order Items</h3>

                <div class="divide-y divide-slate-100">
                    @forelse($order->items as $item)
                        <div class="py-3 flex items-center justify-between text-xs">
                            <div>
                                <span class="font-bold text-slate-900 text-sm">{{ $item->quantity }}x {{ $item->product->name ?? 'Item' }}</span>
                                @if($item->addons && $item->addons->count() > 0)
                                    <div class="text-slate-400 text-[11px] mt-1">
                                        Addons: {{ $item->addons->pluck('name')->join(', ') }}
                                    </div>
                                @endif
                            </div>
                            <span class="font-mono font-bold text-slate-800">£{{ number_format($item->price * $item->quantity, 2) }}</span>
                        </div>
                    @empty
                        <div class="py-4 text-center text-slate-400 text-xs">No items details found.</div>
                    @endforelse
                </div>

                <div class="pt-4 border-t border-slate-100 flex justify-between items-center text-sm font-bold">
                    <span class="text-slate-700">Total Paid Amount</span>
                    <span class="text-emerald-600 font-mono text-base">£{{ number_format($order->total_amount, 2) }}</span>
                </div>
            </div>
        </div>

        <!-- CUSTOMER & RESTAURANT SUMMARY -->
        <div class="space-y-6">
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-3 text-xs">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 border-b border-slate-100 pb-3">Customer Info</h3>
                <div>
                    <span class="text-slate-400 block">Name:</span>
                    <span class="font-bold text-slate-900 text-sm">{{ $order->user->name ?? 'N/A' }}</span>
                </div>
                <div>
                    <span class="text-slate-400 block">Email:</span>
                    <span class="font-semibold text-slate-800">{{ $order->user->email ?? 'N/A' }}</span>
                </div>
                <div>
                    <span class="text-slate-400 block">Phone:</span>
                    <span class="font-mono font-semibold text-slate-800">{{ $order->user->phone ?? 'N/A' }}</span>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-3 text-xs">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 border-b border-slate-100 pb-3">Restaurant Info</h3>
                <div>
                    <span class="text-slate-400 block">Name:</span>
                    <span class="font-bold text-slate-900 text-sm">{{ $order->restaurant->name ?? 'N/A' }}</span>
                </div>
                <div>
                    <span class="text-slate-400 block">Location:</span>
                    <span class="font-semibold text-slate-800">{{ $order->restaurant->location ?? 'N/A' }}</span>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection
