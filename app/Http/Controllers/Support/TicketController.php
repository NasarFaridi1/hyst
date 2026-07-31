<?php

namespace App\Http\Controllers\Support;

use App\Http\Controllers\Controller;
use App\Models\SupportTicket;
use App\Models\SupportTicketReply;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TicketController extends Controller
{
    /**
     * Handle public support ticket creation (e.g. from chatbot widget).
     */
    public function storePublicTicket(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email',
            'phone'    => 'required|string|max:50',
            'order_id' => 'nullable|integer',
            'message'  => 'required|string|min:5',
        ]);

        // Generate unique ticket number (e.g. TICK-10045)
        $ticketNumber = 'TICK-' . rand(10000, 99999);
        while (SupportTicket::where('ticket_number', $ticketNumber)->exists()) {
            $ticketNumber = 'TICK-' . rand(10000, 99999);
        }

        // Validate optional order_id if present
        $orderId = null;
        if ($request->filled('order_id')) {
            $existingOrder = Order::find($request->order_id);
            if ($existingOrder) {
                $orderId = $existingOrder->id;
            }
        }

        $ticket = SupportTicket::create([
            'ticket_number' => $ticketNumber,
            'user_id'       => auth()->check() ? auth()->id() : null,
            'name'          => $request->name,
            'email'         => $request->email,
            'phone'         => $request->phone,
            'order_id'      => $orderId,
            'subject'       => $orderId ? "Support Request for Order #{$orderId}" : 'General Support Inquiry',
            'message'       => $request->message,
            'status'        => 'open',
            'priority'      => 'medium',
        ]);

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'status'        => 'success',
                'message'       => 'Ticket raised successfully!',
                'ticket_number' => $ticket->ticket_number,
            ]);
        }

        return back()->with('success', "Ticket #{$ticket->ticket_number} created successfully! Our support team will get back to you soon.");
    }

    /**
     * List all support tickets for support team.
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $status = $request->status;

        $tickets = SupportTicket::with(['user', 'order'])
            ->when($status, function ($q) use ($status) {
                $q->where('status', $status);
            })
            ->when($search, function ($q) use ($search) {
                $q->where(function ($sub) use ($search) {
                    $sub->where('ticket_number', 'like', "%{$search}%")
                        ->orWhere('name', 'like', "%{$search}%")
                        ->orWhere('order_id', 'like', "%{$search}%")
                        ->orWhere('subject', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $openCount       = SupportTicket::where('status', 'open')->count();
        $inProgressCount = SupportTicket::where('status', 'in_progress')->count();
        $resolvedCount   = SupportTicket::where('status', 'resolved')->count();
        $closedCount     = SupportTicket::where('status', 'closed')->count();
        $totalCount      = SupportTicket::count();

        return view('support.tickets.index', compact(
            'tickets',
            'search',
            'status',
            'openCount',
            'inProgressCount',
            'resolvedCount',
            'closedCount',
            'totalCount'
        ));
    }

    /**
     * Show ticket details & conversation history.
     */
    public function show($id)
    {
        $ticket = SupportTicket::with(['user', 'order.restaurant', 'replies.user'])->findOrFail($id);

        return view('support.tickets.show', compact('ticket'));
    }

    /**
     * Reply to a ticket as support staff.
     */
    public function reply(Request $request, $id)
    {
        $request->validate([
            'message' => 'required|string',
            'status'  => 'nullable|in:open,in_progress,resolved,closed',
        ]);

        $ticket = SupportTicket::findOrFail($id);

        SupportTicketReply::create([
            'ticket_id'   => $ticket->id,
            'user_id'     => auth()->id(),
            'sender_type' => 'support',
            'message'     => $request->message,
        ]);

        // Update ticket status if provided
        if ($request->filled('status')) {
            $ticket->update(['status' => $request->status]);
        } else if ($ticket->status === 'open') {
            $ticket->update(['status' => 'in_progress']);
        }

        // Send notification to customer if user_id exists
        if ($ticket->user_id && function_exists('sendNotification')) {
            sendNotification(
                $ticket->user_id,
                'support_reply',
                "Support Reply on Ticket #{$ticket->ticket_number}",
                Str::limit($request->message, 100),
                'ticket',
                $ticket->id,
                $ticket->order_id
            );
        }

        return back()->with('success', 'Reply posted successfully!');
    }

    /**
     * Update ticket status.
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:open,in_progress,resolved,closed',
        ]);

        $ticket = SupportTicket::findOrFail($id);
        $ticket->update(['status' => $request->status]);

        return back()->with('success', "Ticket status updated to " . ucfirst(str_replace('_', ' ', $request->status)));
    }
}