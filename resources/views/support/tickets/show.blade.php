@extends('support.layout')

@section('title', 'Ticket #' . $ticket->ticket_number)

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

    <!-- LEFT COLUMN: TICKET DETAILS & CONVERSATION THREAD -->
    <div class="lg:col-span-2 space-y-6">

        <!-- INITIAL CUSTOMER MESSAGE CARD -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                <div>
                    <h2 class="text-lg font-bold text-slate-900">{{ $ticket->subject ?? 'Customer Inquiry' }}</h2>
                    <span class="text-xs text-slate-400">Created {{ $ticket->created_at->format('d M Y \a\t h:i A') }} ({{ $ticket->created_at->diffForHumans() }})</span>
                </div>
                <form action="{{ route('support.tickets.status', $ticket->id) }}" method="POST" class="flex items-center gap-2">
                    @csrf
                    <select name="status" onchange="this.form.submit()" class="text-xs font-bold px-3 py-1.5 rounded-xl border border-slate-300 bg-slate-50 focus:outline-none">
                        <option value="open" {{ $ticket->status === 'open' ? 'selected' : '' }}>Open</option>
                        <option value="in_progress" {{ $ticket->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="resolved" {{ $ticket->status === 'resolved' ? 'selected' : '' }}>Resolved</option>
                        <option value="closed" {{ $ticket->status === 'closed' ? 'selected' : '' }}>Closed</option>
                    </select>
                </form>
            </div>

            <!-- CUSTOMER INITIAL MESSAGE -->
            <div class="bg-orange-50/50 p-4 rounded-xl border border-orange-100/70 text-slate-800 text-sm leading-relaxed whitespace-pre-line">
                <div class="flex items-center justify-between text-xs font-bold text-orange-900 mb-2">
                    <span>👤 {{ $ticket->name }} (Customer)</span>
                    <span class="text-[11px] font-normal text-orange-700">{{ $ticket->created_at->format('h:i A') }}</span>
                </div>
                {{ $ticket->message }}
            </div>
        </div>

        <!-- REPLIES THREAD -->
        <div class="space-y-4">
            <h3 class="text-sm font-bold uppercase tracking-wider text-slate-500 px-1">Conversation History</h3>

            @forelse($ticket->replies as $reply)
                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm space-y-2">
                    <div class="flex items-center justify-between text-xs border-b border-slate-100 pb-2">
                        <div class="flex items-center gap-2">
                            @if($reply->sender_type === 'support')
                                <span class="px-2 py-0.5 rounded bg-orange-100 text-orange-800 font-bold text-[10px] uppercase">Support Staff</span>
                                <span class="font-bold text-slate-900">{{ $reply->user->name ?? 'Support Agent' }}</span>
                            @else
                                <span class="px-2 py-0.5 rounded bg-slate-100 text-slate-700 font-bold text-[10px] uppercase">Customer</span>
                                <span class="font-bold text-slate-900">{{ $ticket->name }}</span>
                            @endif
                        </div>
                        <span class="text-slate-400 text-[11px]">{{ $reply->created_at->format('d M Y, h:i A') }}</span>
                    </div>
                    <div class="text-slate-800 text-sm leading-relaxed whitespace-pre-line pt-1">
                        {{ $reply->message }}
                    </div>
                </div>
            @empty
                <div class="bg-white p-6 rounded-2xl border border-slate-200 text-center text-slate-400 text-xs">
                    No replies yet. Use the form below to respond to the customer.
                </div>
            @endforelse
        </div>

        <!-- REPLY FORM CARD -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
            <h3 class="text-sm font-bold text-slate-900">Post Reply to Customer</h3>
            <form action="{{ route('support.tickets.reply', $ticket->id) }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <textarea name="message" rows="4" required placeholder="Write your response to the customer here..." class="w-full border border-slate-300 rounded-xl p-4 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500"></textarea>
                </div>
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="flex items-center gap-2 w-full sm:w-auto">
                        <label class="text-xs font-semibold text-slate-600">Update Status:</label>
                        <select name="status" class="text-xs font-semibold border border-slate-300 rounded-lg px-3 py-2 bg-slate-50 focus:outline-none">
                            <option value="in_progress" {{ $ticket->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="resolved" {{ $ticket->status === 'resolved' ? 'selected' : '' }}>Resolved</option>
                            <option value="closed" {{ $ticket->status === 'closed' ? 'selected' : '' }}>Closed</option>
                            <option value="open" {{ $ticket->status === 'open' ? 'selected' : '' }}>Open</option>
                        </select>
                    </div>
                    <button type="submit" class="w-full sm:w-auto bg-orange-600 hover:bg-orange-700 text-white font-bold text-sm px-6 py-2.5 rounded-xl transition shadow-md">
                        Send Reply
                    </button>
                </div>
            </form>
        </div>

    </div>

    <!-- RIGHT COLUMN: CUSTOMER & ORDER INFO CARD -->
    <div class="space-y-6">

        <!-- CUSTOMER DETAILS CARD -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 border-b border-slate-100 pb-3">Customer Information</h3>

            <div class="space-y-3 text-xs">
                <div>
                    <span class="text-slate-400 block mb-0.5">Full Name</span>
                    <span class="font-semibold text-slate-900 text-sm">{{ $ticket->name }}</span>
                </div>
                <div>
                    <span class="text-slate-400 block mb-0.5">Email Address</span>
                    <a href="mailto:{{ $ticket->email }}" class="font-semibold text-orange-600 hover:underline">{{ $ticket->email }}</a>
                </div>
                <div>
                    <span class="text-slate-400 block mb-0.5">Phone Number</span>
                    <a href="tel:{{ $ticket->phone }}" class="font-semibold text-slate-800 font-mono">{{ $ticket->phone }}</a>
                </div>
                <div>
                    <span class="text-slate-400 block mb-0.5">Registered Account</span>
                    @if($ticket->user)
                        <span class="inline-flex items-center gap-1 font-semibold text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-md">
                            ✓ Registered User (#{{ $ticket->user_id }})
                        </span>
                    @else
                        <span class="text-slate-500 italic">Guest User</span>
                    @endif
                </div>
            </div>
        </div>

        <!-- LINKED ORDER CARD -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 border-b border-slate-100 pb-3">Linked Order Info</h3>

            @if($ticket->order)
                <div class="space-y-3 text-xs">
                    <div class="flex items-center justify-between">
                        <span class="text-slate-400">Order ID:</span>
                        <span class="font-mono font-bold text-slate-900">#{{ $ticket->order->id }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-slate-400">Restaurant:</span>
                        <span class="font-semibold text-slate-800">{{ $ticket->order->restaurant->name ?? 'N/A' }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-slate-400">Total Amount:</span>
                        <span class="font-bold text-emerald-600 font-mono">£{{ number_format($ticket->order->total_amount, 2) }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-slate-400">Order Status:</span>
                        <span class="px-2.5 py-0.5 rounded-full font-bold text-[10px] uppercase bg-slate-100 text-slate-700">
                            {{ $ticket->order->status }}
                        </span>
                    </div>
                    <div class="pt-2 border-t border-slate-100 text-right">
                        <a href="{{ route('support.orders.show', $ticket->order->id) }}" class="text-xs font-bold text-orange-600 hover:underline">
                            View Full Order Details →
                        </a>
                    </div>
                </div>
            @elseif($ticket->order_id)
                <div class="text-xs text-slate-500 italic">
                    Order #{{ $ticket->order_id }} requested (not found in database).
                </div>
            @else
                <div class="text-xs text-slate-400 italic text-center py-4">
                    No order linked to this ticket.
                </div>
            @endif
        </div>

    </div>

</div>
@endsection
