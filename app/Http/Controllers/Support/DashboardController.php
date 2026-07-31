<?php

namespace App\Http\Controllers\Support;

use App\Http\Controllers\Controller;
use App\Models\SupportTicket;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalTickets      = SupportTicket::count();
        $openTickets       = SupportTicket::where('status', 'open')->count();
        $inProgressTickets = SupportTicket::where('status', 'in_progress')->count();
        $resolvedTickets   = SupportTicket::where('status', 'resolved')->count();
        $closedTickets     = SupportTicket::where('status', 'closed')->count();
        $totalOrders       = Order::count();
        $totalUsers        = User::where('role', 'user')->count();

        $recentTickets = SupportTicket::with(['user', 'order'])
            ->latest()
            ->take(8)
            ->get();

        return view('support.dashboard', compact(
            'totalTickets',
            'openTickets',
            'inProgressTickets',
            'resolvedTickets',
            'closedTickets',
            'totalOrders',
            'totalUsers',
            'recentTickets'
        ));
    }
}
