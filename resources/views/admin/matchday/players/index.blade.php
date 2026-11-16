@extends('layouts.app')

@section('content')
<div class="p-4 sm:p-6 lg:p-8 max-w-7xl mx-auto">

    <!-- Top Breadcrumb & Navigation Tabs -->
    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <div>
            <div class="flex items-center gap-2 text-xs text-gray-500 mb-1">
                <span>Admin</span>
                <span>/</span>
                <span class="text-gray-900 font-semibold">Matchday Fantasy XI</span>
                <span>/</span>
                <span>Players</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 flex items-center gap-2.5">
                <span>🏴󠁧󠁢󠁥󠁮󠁧󠁿 England Squad Catalogue</span>
            </h1>
            <p class="text-sm text-gray-500 mt-1">
                Manage all players, photos, clubs, positions, ratings, and stats for the Hyst Matchday experience.
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-2.5">
            <a href="{{ route('admin.matchday.campaigns.index') }}" 
               class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-semibold transition">
                <i data-lucide="settings" style="width:16px; height:16px;"></i>
                <span>Campaign Settings</span>
            </a>

            <form action="{{ route('admin.matchday.players.seed-defaults') }}" method="POST" class="inline"
                  onsubmit="return confirm('Sync official 23-man England squad with high-res photos and ratings? This will add or update players safely.')">
                @csrf
                <button type="submit" 
                        class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-indigo-50 hover:bg-indigo-100 border border-indigo-200 text-indigo-700 text-sm font-semibold transition">
                    <i data-lucide="sparkles" style="width:16px; height:16px;"></i>
                    <span>Sync Official 23 Squad</span>
                </button>
            </form>

            <a href="{{ route('admin.matchday.players.create') }}" 
               class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-[#C25A2A] hover:bg-[#a94c20] text-white text-sm font-bold shadow-sm transition">
                <i data-lucide="plus" style="width:18px; height:18px;"></i>
                <span>Add New Player</span>
            </a>
        </div>
    </div>

    <!-- Quick Metrics Row -->
    <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-7 gap-3 mb-6">
        <div class="bg-white p-3.5 rounded-2xl border border-gray-100 shadow-xs">
            <div class="text-xs text-gray-500 font-medium">Total Squad</div>
            <div class="text-2xl font-black text-gray-900 mt-0.5">{{ $stats['total'] }}</div>
        </div>
        <div class="bg-white p-3.5 rounded-2xl border border-gray-100 shadow-xs">
            <div class="text-xs text-emerald-600 font-medium">Active In Packs</div>
            <div class="text-2xl font-black text-emerald-700 mt-0.5">{{ $stats['active'] }}</div>
        </div>
        <div class="bg-white p-3.5 rounded-2xl border border-gray-100 shadow-xs">
            <div class="text-xs text-amber-600 font-medium">Goalkeepers</div>
            <div class="text-2xl font-black text-amber-700 mt-0.5">{{ $stats['gk'] }}</div>
        </div>
        <div class="bg-white p-3.5 rounded-2xl border border-gray-100 shadow-xs">
            <div class="text-xs text-blue-600 font-medium">Defenders</div>
            <div class="text-2xl font-black text-blue-700 mt-0.5">{{ $stats['def'] }}</div>
        </div>
        <div class="bg-white p-3.5 rounded-2xl border border-gray-100 shadow-xs">
            <div class="text-xs text-purple-600 font-medium">Midfielders</div>
            <div class="text-2xl font-black text-purple-700 mt-0.5">{{ $stats['mid'] }}</div>
        </div>
        <div class="bg-white p-3.5 rounded-2xl border border-gray-100 shadow-xs">
            <div class="text-xs text-rose-600 font-medium">Forwards</div>
            <div class="text-2xl font-black text-rose-700 mt-0.5">{{ $stats['fwd'] }}</div>
        </div>
        <div class="bg-white p-3.5 rounded-2xl border border-gray-100 shadow-xs">
            <div class="text-xs text-gray-500 font-medium">Avg Rating</div>
            <div class="text-2xl font-black text-gray-900 mt-0.5">{{ $stats['avg_rating'] }}</div>
        </div>
    </div>

    <!-- Search & Filter Bar -->
    <div class="bg-white border border-gray-100 rounded-2xl p-4 mb-6 shadow-xs">
        <form method="GET" action="{{ route('admin.matchday.players.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-3">
            
            <!-- Search Text -->
            <div class="lg:col-span-2">
                <label class="block text-xs font-semibold text-gray-600 mb-1">Search Player or Club</label>
                <div class="relative">
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}" 
                           placeholder="e.g. Kane, Saka, Palmer, Arsenal..."
                           class="w-full border border-gray-200 rounded-xl pl-9 pr-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#C25A2A]/40 focus:border-[#C25A2A]">
                    <div class="absolute left-3 top-2.5 text-gray-400">
                        <i data-lucide="search" style="width:16px; height:16px;"></i>
                    </div>
                </div>
            </div>

            <!-- Position Filter -->
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">Position</label>
                <select name="position" class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#C25A2A]/40 focus:border-[#C25A2A]">
                    <option value="">All Positions</option>
                    <option value="GK" {{ request('position') == 'GK' ? 'selected' : '' }}>Goalkeeper (GK)</option>
                    <option value="DEF" {{ request('position') == 'DEF' ? 'selected' : '' }}>Defender (DEF)</option>
                    <option value="MID" {{ request('position') == 'MID' ? 'selected' : '' }}>Midfielder (MID)</option>
                    <option value="FWD" {{ request('position') == 'FWD' ? 'selected' : '' }}>Forward (FWD)</option>
                </select>
            </div>

            <!-- Rarity Filter -->
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">Rarity</label>
                <select name="rarity" class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#C25A2A]/40 focus:border-[#C25A2A]">
                    <option value="">All Rarities</option>
                    <option value="legendary" {{ request('rarity') == 'legendary' ? 'selected' : '' }}>Legendary</option>
                    <option value="epic" {{ request('rarity') == 'epic' ? 'selected' : '' }}>Epic</option>
                    <option value="rare" {{ request('rarity') == 'rare' ? 'selected' : '' }}>Rare</option>
                    <option value="common" {{ request('rarity') == 'common' ? 'selected' : '' }}>Common</option>
                </select>
            </div>

            <!-- Status Filter -->
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">Status</label>
                <select name="status" class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#C25A2A]/40 focus:border-[#C25A2A]">
                    <option value="">All Statuses</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-end gap-2">
                <button type="submit" 
                        class="flex-1 bg-gray-900 hover:bg-black text-white px-4 py-2 rounded-xl text-sm font-semibold transition">
                    Filter
                </button>
                @if(request()->hasAny(['search', 'position', 'rarity', 'status']))
                    <a href="{{ route('admin.matchday.players.index') }}" 
                       class="px-3 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-semibold transition"
                       title="Reset Filters">
                        Reset
                    </a>
                @endif
            </div>

        </form>
    </div>

    <!-- Players Table -->
    <div class="bg-white border border-gray-100 rounded-2xl overflow-hidden shadow-xs">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/80 border-b border-gray-100 text-[11px] uppercase tracking-wider text-gray-500 font-bold">
                        <th class="py-3.5 px-4">Player</th>
                        <th class="py-3.5 px-3">Club</th>
                        <th class="py-3.5 px-3">Position</th>
                        <th class="py-3.5 px-3">Rarity</th>
                        <th class="py-3.5 px-3 text-center">OVR</th>
                        <th class="py-3.5 px-3 text-center">Stats (ATT / MID / DEF / GK)</th>
                        <th class="py-3.5 px-3 text-center">Status</th>
                        <th class="py-3.5 px-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 text-sm">
                    @forelse($players as $player)
                        <tr class="hover:bg-amber-50/20 transition">
                            
                            <!-- Player Info & Thumbnail -->
                            <td class="py-3 px-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 rounded-xl bg-slate-900 flex items-center justify-center overflow-hidden border border-gray-200 flex-shrink-0 relative group">
                                        <img src="{{ $player->image_url }}" 
                                             alt="{{ $player->name }}" 
                                             class="w-full h-full object-contain p-0.5"
                                             onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode($player->name) }}&background=0F172A&color=FFF';">
                                    </div>
                                    <div>
                                        <div class="font-bold text-gray-900 flex items-center gap-1.5">
                                            <span>{{ $player->name }}</span>
                                            @if($player->display_name && $player->display_name !== $player->name)
                                                <span class="text-xs text-gray-400">({{ $player->display_name }})</span>
                                            @endif
                                        </div>
                                        <div class="text-xs text-gray-500 flex items-center gap-1">
                                            <span>🏴󠁧󠁢󠁥󠁮󠁧󠁿</span>
                                            <span>{{ $player->nationality ?: 'England' }}</span>
                                            @if($player->sub_position)
                                                <span>&bull;</span>
                                                <span class="text-gray-400">{{ $player->sub_position }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Club -->
                            <td class="py-3 px-3 font-medium text-gray-700">
                                {{ $player->club_name }}
                            </td>

                            <!-- Position Badge -->
                            <td class="py-3 px-3">
                                @php
                                    $posStyles = [
                                        'GK'  => 'bg-amber-50 text-amber-800 border-amber-200',
                                        'DEF' => 'bg-blue-50 text-blue-800 border-blue-200',
                                        'MID' => 'bg-purple-50 text-purple-800 border-purple-200',
                                        'FWD' => 'bg-rose-50 text-rose-800 border-rose-200',
                                    ];
                                    $posStyle = $posStyles[$player->position] ?? 'bg-gray-100 text-gray-800 border-gray-200';
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-xs font-black border {{ $posStyle }}">
                                    {{ $player->position }}
                                </span>
                            </td>

                            <!-- Rarity Badge -->
                            <td class="py-3 px-3">
                                @php
                                    $rarityStyles = [
                                        'legendary' => 'bg-gradient-to-r from-amber-400 to-yellow-500 text-slate-950 font-black',
                                        'epic'      => 'bg-gradient-to-r from-purple-500 to-indigo-600 text-white font-extrabold',
                                        'rare'      => 'bg-gradient-to-r from-blue-500 to-cyan-500 text-white font-bold',
                                        'common'    => 'bg-gray-100 text-gray-700 font-semibold',
                                    ];
                                    $rStyle = $rarityStyles[$player->rarity] ?? 'bg-gray-100 text-gray-700';
                                @endphp
                                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] uppercase tracking-wide {{ $rStyle }}">
                                    {{ $player->rarity }}
                                </span>
                            </td>

                            <!-- Overall Rating (OVR) -->
                            <td class="py-3 px-3 text-center">
                                <span class="inline-block px-2.5 py-1 rounded-lg text-xs font-black bg-slate-900 text-amber-400 shadow-xs">
                                    {{ $player->overall_rating }}
                                </span>
                            </td>

                            <!-- Stats Matrix -->
                            <td class="py-3 px-3 text-center">
                                <div class="inline-flex items-center gap-1.5 text-[11px] font-bold">
                                    <span class="px-1.5 py-0.5 rounded bg-rose-50 text-rose-700 border border-rose-200" title="Attack">ATT {{ $player->stat_attack }}</span>
                                    <span class="px-1.5 py-0.5 rounded bg-purple-50 text-purple-700 border border-purple-200" title="Midfield">MID {{ $player->stat_midfield }}</span>
                                    <span class="px-1.5 py-0.5 rounded bg-blue-50 text-blue-700 border border-blue-200" title="Defence">DEF {{ $player->stat_defence }}</span>
                                    <span class="px-1.5 py-0.5 rounded bg-amber-50 text-amber-700 border border-amber-200" title="Goalkeeping">GK {{ $player->stat_goalkeeping }}</span>
                                </div>
                            </td>

                            <!-- Status Toggle -->
                            <td class="py-3 px-3 text-center">
                                <form action="{{ route('admin.matchday.players.toggle-status', $player->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" 
                                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold transition {{ $player->is_active ? 'bg-emerald-50 text-emerald-700 border border-emerald-200 hover:bg-emerald-100' : 'bg-gray-100 text-gray-500 border border-gray-200 hover:bg-gray-200' }}"
                                            title="Click to toggle active status">
                                        <span class="w-1.5 h-1.5 rounded-full {{ $player->is_active ? 'bg-emerald-500 animate-pulse' : 'bg-gray-400' }}"></span>
                                        <span>{{ $player->is_active ? 'Active' : 'Hidden' }}</span>
                                    </button>
                                </form>
                            </td>

                            <!-- Actions -->
                            <td class="py-3 px-4 text-right">
                                <div class="inline-flex items-center gap-1.5">
                                    <a href="{{ route('admin.matchday.players.edit', $player->id) }}" 
                                       class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg bg-amber-50 hover:bg-amber-100 text-amber-800 border border-amber-200 text-xs font-semibold transition"
                                       title="Edit Player">
                                        <i data-lucide="edit-3" style="width:13px; height:13px;"></i>
                                        <span>Edit</span>
                                    </a>

                                    <form action="{{ route('admin.matchday.players.destroy', $player->id) }}" 
                                          method="POST" 
                                          class="inline"
                                          onsubmit="return confirm('Are you sure you want to delete {{ $player->name }}? This cannot be undone.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 text-xs font-semibold transition"
                                                title="Delete Player">
                                            <i data-lucide="trash-2" style="width:13px; height:13px;"></i>
                                            <span>Delete</span>
                                        </button>
                                    </form>
                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-12 text-center text-gray-500">
                                <div class="max-w-sm mx-auto">
                                    <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center mx-auto mb-3">
                                        <i data-lucide="users" style="width:24px; height:24px;"></i>
                                    </div>
                                    <h3 class="text-base font-bold text-gray-900 mb-1">No players found</h3>
                                    <p class="text-xs text-gray-500 mb-4">You can add your first player manually or sync the official 23-man squad in 1 click.</p>
                                    <div class="flex items-center justify-center gap-2">
                                        <form action="{{ route('admin.matchday.players.seed-defaults') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="px-3.5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold transition">
                                                ⚡ Sync Official 23 Squad
                                            </button>
                                        </form>
                                        <a href="{{ route('admin.matchday.players.create') }}" class="px-3.5 py-2 bg-[#C25A2A] hover:bg-[#a94c20] text-white rounded-xl text-xs font-bold transition">
                                            + Add Player
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($players->hasPages())
            <div class="p-4 border-t border-gray-100 bg-gray-50/50">
                {{ $players->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
