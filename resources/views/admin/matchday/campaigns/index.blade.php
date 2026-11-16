@extends('layouts.app')

@section('content')
<div class="p-4 sm:p-6 lg:p-8 max-w-7xl mx-auto">

    <!-- Top Breadcrumb & Navigation -->
    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <div>
            <div class="flex items-center gap-2 text-xs text-gray-500 mb-1">
                <span>Admin</span>
                <span>/</span>
                <span class="text-gray-900 font-semibold">Matchday Fantasy XI</span>
                <span>/</span>
                <span>Campaign Settings</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 flex items-center gap-2.5">
                <span>⚙️ Matchday Campaign Settings</span>
            </h1>
            <p class="text-sm text-gray-500 mt-1">
                Configure order unlock thresholds, free card choices, active dates, and rules.
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-2.5">
            <a href="{{ route('admin.matchday.players.index') }}" 
               class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-semibold transition">
                <i data-lucide="users" style="width:16px; height:16px;"></i>
                <span>Players Catalogue</span>
            </a>

            <a href="{{ route('admin.matchday.campaigns.create') }}" 
               class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-[#C25A2A] hover:bg-[#a94c20] text-white text-sm font-bold shadow-sm transition">
                <i data-lucide="plus" style="width:18px; height:18px;"></i>
                <span>Create New Campaign</span>
            </a>
        </div>
    </div>

    <!-- Campaigns Table -->
    <div class="bg-white border border-gray-100 rounded-2xl overflow-hidden shadow-xs">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/80 border-b border-gray-100 text-[11px] uppercase tracking-wider text-gray-500 font-bold">
                        <th class="py-3.5 px-4">Campaign Name</th>
                        <th class="py-3.5 px-3">Min Order Spend</th>
                        <th class="py-3.5 px-3">Card Choices</th>
                        <th class="py-3.5 px-3">Pack Expiry</th>
                        <th class="py-3.5 px-3">Schedule</th>
                        <th class="py-3.5 px-3 text-center">Status</th>
                        <th class="py-3.5 px-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 text-sm">
                    @forelse($campaigns as $camp)
                        <tr class="hover:bg-amber-50/20 transition">
                            <td class="py-3.5 px-4">
                                <div class="font-bold text-gray-900">{{ $camp->name }}</div>
                                <div class="text-xs text-gray-400 font-mono">{{ $camp->slug }}</div>
                            </td>
                            <td class="py-3.5 px-3 font-bold text-gray-900">
                                £{{ number_format($camp->min_order_amount, 2) }}
                            </td>
                            <td class="py-3.5 px-3 text-gray-700">
                                <span class="font-bold text-emerald-700">{{ $camp->choices_per_order }} cards</span> presented
                            </td>
                            <td class="py-3.5 px-3 text-gray-500 text-xs">
                                {{ $camp->entitlement_expiry_days }} days
                            </td>
                            <td class="py-3.5 px-3 text-xs text-gray-600">
                                @if($camp->starts_at || $camp->ends_at)
                                    <div>{{ $camp->starts_at ? $camp->starts_at->format('d M Y') : 'Immediate' }} &rarr; {{ $camp->ends_at ? $camp->ends_at->format('d M Y') : 'Ongoing' }}</div>
                                @else
                                    <span class="text-gray-400">Always active</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-3 text-center">
                                <form action="{{ route('admin.matchday.campaigns.toggle-status', $camp->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" 
                                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold transition {{ $camp->is_active ? 'bg-emerald-50 text-emerald-700 border border-emerald-200 hover:bg-emerald-100' : 'bg-gray-100 text-gray-500 border border-gray-200 hover:bg-gray-200' }}"
                                            title="Click to toggle active status">
                                        <span class="w-1.5 h-1.5 rounded-full {{ $camp->is_active ? 'bg-emerald-500 animate-pulse' : 'bg-gray-400' }}"></span>
                                        <span>{{ $camp->is_active ? 'Active' : 'Inactive' }}</span>
                                    </button>
                                </form>
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <div class="inline-flex items-center gap-1.5">
                                    <a href="{{ route('admin.matchday.campaigns.edit', $camp->id) }}" 
                                       class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg bg-amber-50 hover:bg-amber-100 text-amber-800 border border-amber-200 text-xs font-semibold transition"
                                       title="Edit Campaign">
                                        <i data-lucide="edit-3" style="width:13px; height:13px;"></i>
                                        <span>Edit</span>
                                    </a>

                                    <form action="{{ route('admin.matchday.campaigns.destroy', $camp->id) }}" 
                                          method="POST" 
                                          class="inline"
                                          onsubmit="return confirm('Are you sure you want to delete this campaign?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 text-xs font-semibold transition">
                                            <i data-lucide="trash-2" style="width:13px; height:13px;"></i>
                                            <span>Delete</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-10 text-center text-gray-500">
                                No campaigns found. Create your first Matchday Campaign!
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($campaigns->hasPages())
            <div class="p-4 border-t border-gray-100 bg-gray-50/50">
                {{ $campaigns->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
