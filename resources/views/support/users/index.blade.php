@extends('support.layout')

@section('title', 'All Registered Users')

@section('content')
<div class="space-y-6">

    <!-- SEARCH BAR -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <form method="GET" action="{{ route('support.users.index') }}" class="flex gap-4">
            <input type="text" name="search" value="{{ $search }}" placeholder="Search users by ID, Name, Email, Phone..." class="flex-1 border border-slate-300 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
            <button type="submit" class="bg-orange-600 hover:bg-orange-700 text-white font-semibold px-6 py-3 rounded-xl text-sm transition">
                Search
            </button>
            @if($search)
                <a href="{{ route('support.users.index') }}" class="bg-slate-200 hover:bg-slate-300 text-slate-700 font-semibold px-6 py-3 rounded-xl text-sm transition">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- USERS TABLE -->
    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-[11px] font-bold uppercase text-slate-500 border-b border-slate-200">
                        <th class="p-4 pl-6">ID</th>
                        <th class="p-4">Name</th>
                        <th class="p-4">Email</th>
                        <th class="p-4">Phone</th>
                        <th class="p-4">Orders Placed</th>
                        <th class="p-4 pr-6">Joined Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs">
                    @forelse($users as $user)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="p-4 pl-6 font-mono font-bold text-slate-900">
                                #{{ $user->id }}
                            </td>
                            <td class="p-4 font-semibold text-slate-800">
                                {{ $user->name }}
                            </td>
                            <td class="p-4 text-slate-600">
                                {{ $user->email }}
                            </td>
                            <td class="p-4 text-slate-700 font-mono">
                                {{ $user->phone }}
                            </td>
                            <td class="p-4 font-bold text-orange-600">
                                {{ $user->orders_count ?? 0 }} Orders
                            </td>
                            <td class="p-4 pr-6 text-slate-500">
                                {{ $user->created_at->format('d M Y') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-16 text-slate-400">
                                No users found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $users->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
