@extends('layouts.app')

@section('title', 'Support Dashboard')

@section('content')
<div class="space-y-8">

    <!-- STATS GRID -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Open Tickets -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase tracking-wider text-amber-600">Open Tickets</span>
                <span class="p-2 bg-amber-50 rounded-xl text-amber-600 font-bold">📩</span>
            </div>
            <div class="mt-4 flex items-baseline justify-between">
                <span class="text-3xl font-extrabold text-slate-900">{{ $openTickets }}</span>
                <span class="text-xs text-amber-600 bg-amber-50 px-2.5 py-1 rounded-full font-semibold">Requires Action</span>
            </div>
        </div>

        <!-- In Progress -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase tracking-wider text-blue-600">In Progress</span>
                <span class="p-2 bg-blue-50 rounded-xl text-blue-600 font-bold">⏳</span>
            </div>
            <div class="mt-4 flex items-baseline justify-between">
                <span class="text-3xl font-extrabold text-slate-900">{{ $inProgressTickets }}</span>
                <span class="text-xs text-blue-600 bg-blue-50 px-2.5 py-1 rounded-full font-semibold">Active Handling</span>
            </div>
        </div>

        <!-- Resolved -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase tracking-wider text-emerald-600">Resolved</span>
                <span class="p-2 bg-emerald-50 rounded-xl text-emerald-600 font-bold">✅</span>
            </div>
            <div class="mt-4 flex items-baseline justify-between">
                <span class="text-3xl font-extrabold text-slate-900">{{ $resolvedTickets }}</span>
                <span class="text-xs text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-full font-semibold">Solved</span>
            </div>
        </div>

        <!-- Total Orders -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase tracking-wider text-purple-600">Total System Orders</span>
                <span class="p-2 bg-purple-50 rounded-xl text-purple-600 font-bold">🛍️</span>
            </div>
            <div class="mt-4 flex items-baseline justify-between">
                <span class="text-3xl font-extrabold text-slate-900">{{ $totalOrders }}</span>
                <span class="text-xs text-purple-600 bg-purple-50 px-2.5 py-1 rounded-full font-semibold">{{ $totalUsers }} Users</span>
            </div>
        </div>
    </div>

    <!-- RECENT TICKETS TABLE -->
    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="text-lg font-bold text-slate-900">Recent Support Tickets</h3>
                <p class="text-xs text-slate-500 mt-1">Latest customer inquiries and raised tickets</p>
            </div>
            <a href="{{ route('support.tickets.index') }}" class="text-xs font-bold text-orange-600 hover:text-orange-700 underline">
                View All Tickets →
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-[11px] font-bold uppercase text-slate-500 border-b border-slate-200">
                        <th class="p-4 pl-6">Ticket #</th>
                        <th class="p-4">Customer Name</th>
                        <th class="p-4">Email</th>
                        <th class="p-4">Order ID</th>
                        <th class="p-4">Status</th>
                        <th class="p-4">Created Date</th>
                        <th class="p-4 pr-6 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs">
                    @forelse($recentTickets as $ticket)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="p-4 pl-6 font-mono font-bold text-slate-900">
                                #{{ $ticket->ticket_number }}
                            </td>
                            <td class="p-4 font-semibold text-slate-800">
                                {{ $ticket->name }}
                            </td>
                            <td class="p-4 text-slate-600">
                                {{ $ticket->email }}
                            </td>
                            <td class="p-4">
                                @if($ticket->order_id)
                                    <span class="bg-slate-100 text-slate-800 font-mono px-2.5 py-1 rounded-md font-semibold">
                                        #{{ $ticket->order_id }}
                                    </span>
                                @else
                                    <span class="text-slate-400">-</span>
                                @endif
                            </td>
                            <td class="p-4">
                                @if($ticket->status === 'open')
                                    <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-amber-100 text-amber-800">Open</span>
                                @elseif($ticket->status === 'in_progress')
                                    <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-blue-100 text-blue-800">In Progress</span>
                                @elseif($ticket->status === 'resolved')
                                    <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-800">Resolved</span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-slate-100 text-slate-700">Closed</span>
                                @endif
                            </td>
                            <td class="p-4 text-slate-500">
                                {{ $ticket->created_at->format('d M Y, h:i A') }}
                            </td>
                            <td class="p-4 pr-6 text-right">
                                <a href="{{ route('support.tickets.show', $ticket->id) }}" class="inline-flex items-center gap-1 bg-slate-900 hover:bg-orange-600 text-white text-xs font-semibold px-3 py-1.5 rounded-lg transition">
                                    View / Reply
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-12 text-slate-400">
                                No support tickets raised yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
