@extends('layouts.app')

@section('title', 'All Support Tickets')

@section('content')
<div class="space-y-6">

    <!-- SEARCH & STATUS FILTERS -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
        <form method="GET" action="{{ route('support.tickets.index') }}" class="flex flex-col sm:flex-row gap-4">
            <div class="flex-1">
                <input type="text" name="search" value="{{ $search }}" placeholder="Search by Ticket #, Name, Email, Order ID..." class="w-full border border-slate-300 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
            </div>
            <div class="flex gap-2">
                <button type="submit" class="bg-orange-600 hover:bg-orange-700 text-white font-semibold px-6 py-3 rounded-xl text-sm transition">
                    Search
                </button>
                @if($search || $status)
                    <a href="{{ route('support.tickets.index') }}" class="bg-slate-200 hover:bg-slate-300 text-slate-700 font-semibold px-6 py-3 rounded-xl text-sm transition">
                        Reset
                    </a>
                @endif
            </div>
        </form>

        <!-- STATUS TABS -->
        <div class="flex flex-wrap gap-2 pt-2 border-t border-slate-100">
            <a href="{{ route('support.tickets.index', array_merge(request()->query(), ['status' => ''])) }}" class="px-4 py-2 rounded-xl text-xs font-bold transition {{ !$status ? 'bg-slate-900 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                All Tickets ({{ $totalCount }})
            </a>
            <a href="{{ route('support.tickets.index', array_merge(request()->query(), ['status' => 'open'])) }}" class="px-4 py-2 rounded-xl text-xs font-bold transition {{ $status === 'open' ? 'bg-amber-600 text-white' : 'bg-amber-50 text-amber-700 hover:bg-amber-100' }}">
                Open ({{ $openCount }})
            </a>
            <a href="{{ route('support.tickets.index', array_merge(request()->query(), ['status' => 'in_progress'])) }}" class="px-4 py-2 rounded-xl text-xs font-bold transition {{ $status === 'in_progress' ? 'bg-blue-600 text-white' : 'bg-blue-50 text-blue-700 hover:bg-blue-100' }}">
                In Progress ({{ $inProgressCount }})
            </a>
            <a href="{{ route('support.tickets.index', array_merge(request()->query(), ['status' => 'resolved'])) }}" class="px-4 py-2 rounded-xl text-xs font-bold transition {{ $status === 'resolved' ? 'bg-emerald-600 text-white' : 'bg-emerald-50 text-emerald-700 hover:bg-emerald-100' }}">
                Resolved ({{ $resolvedCount }})
            </a>
            <a href="{{ route('support.tickets.index', array_merge(request()->query(), ['status' => 'closed'])) }}" class="px-4 py-2 rounded-xl text-xs font-bold transition {{ $status === 'closed' ? 'bg-slate-700 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                Closed ({{ $closedCount }})
            </a>
        </div>
    </div>

    <!-- TICKETS TABLE -->
    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-[11px] font-bold uppercase text-slate-500 border-b border-slate-200">
                        <th class="p-4 pl-6">Ticket #</th>
                        <th class="p-4">Customer</th>
                        <th class="p-4">Contact</th>
                        <th class="p-4">Order ID</th>
                        <th class="p-4">Subject</th>
                        <th class="p-4">Status</th>
                        <th class="p-4">Submitted</th>
                        <th class="p-4 pr-6 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs">
                    @forelse($tickets as $ticket)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="p-4 pl-6 font-mono font-bold text-slate-900">
                                #{{ $ticket->ticket_number }}
                            </td>
                            <td class="p-4 font-semibold text-slate-800">
                                {{ $ticket->name }}
                            </td>
                            <td class="p-4 text-slate-600">
                                <div>{{ $ticket->email }}</div>
                                <div class="text-[11px] text-slate-400 font-mono mt-0.5">{{ $ticket->phone }}</div>
                            </td>
                            <td class="p-4">
                                @if($ticket->order_id)
                                    <a href="{{ route('support.orders.show', $ticket->order_id) }}" class="bg-slate-100 hover:bg-orange-100 text-slate-800 hover:text-orange-700 font-mono px-2.5 py-1 rounded-md font-semibold transition">
                                        #{{ $ticket->order_id }}
                                    </a>
                                @else
                                    <span class="text-slate-400">-</span>
                                @endif
                            </td>
                            <td class="p-4 text-slate-700 font-medium max-w-[200px] truncate">
                                {{ $ticket->subject ?? 'General Inquiry' }}
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
                            <td colspan="8" class="text-center py-16 text-slate-400">
                                No support tickets found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($tickets->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $tickets->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
