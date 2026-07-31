@extends('support.layout')

@section('title', 'All System Orders')

@section('content')
<div class="space-y-6">

    <!-- SEARCH BAR -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <form method="GET" action="{{ route('support.orders.index') }}" class="flex gap-4">
            <input type="text" name="search" value="{{ $search }}" placeholder="Search by Order ID, Customer Name, Restaurant Name, Status..." class="flex-1 border border-slate-300 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
            <button type="submit" class="bg-orange-600 hover:bg-orange-700 text-white font-semibold px-6 py-3 rounded-xl text-sm transition">
                Search
            </button>
            @if($search)
                <a href="{{ route('support.orders.index') }}" class="bg-slate-200 hover:bg-slate-300 text-slate-700 font-semibold px-6 py-3 rounded-xl text-sm transition">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- ORDERS TABLE -->
    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-[11px] font-bold uppercase text-slate-500 border-b border-slate-200">
                        <th class="p-4 pl-6">Order ID</th>
                        <th class="p-4">Customer</th>
                        <th class="p-4">Restaurant</th>
                        <th class="p-4">Total Amount</th>
                        <th class="p-4">Status</th>
                        <th class="p-4">Date</th>
                        <th class="p-4 pr-6 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs">
                    @forelse($orders as $order)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="p-4 pl-6 font-mono font-bold text-slate-900">
                                #{{ $order->id }}
                            </td>
                            <td class="p-4 font-semibold text-slate-800">
                                {{ $order->user->name ?? 'Guest/Deleted' }}
                            </td>
                            <td class="p-4 text-slate-700">
                                {{ $order->restaurant->name ?? 'N/A' }}
                            </td>
                            <td class="p-4 font-mono font-bold text-emerald-600">
                                £{{ number_format($order->total_amount, 2) }}
                            </td>
                            <td class="p-4">
                                <span class="px-2.5 py-1 rounded-full text-[11px] font-bold uppercase bg-slate-100 text-slate-700">
                                    {{ $order->status }}
                                </span>
                            </td>
                            <td class="p-4 text-slate-500">
                                {{ $order->created_at->format('d M Y, h:i A') }}
                            </td>
                            <td class="p-4 pr-6 text-right">
                                <a href="{{ route('support.orders.show', $order->id) }}" class="inline-flex items-center gap-1 bg-slate-900 hover:bg-orange-600 text-white text-xs font-semibold px-3 py-1.5 rounded-lg transition">
                                    View Details
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-16 text-slate-400">
                                No orders found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($orders->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $orders->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
