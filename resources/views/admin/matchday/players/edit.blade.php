@extends('layouts.app')

@section('content')
<div class="p-4 sm:p-6 lg:p-8 max-w-6xl mx-auto">

    <!-- Top Breadcrumb & Heading -->
    <div class="flex items-center justify-between gap-4 mb-6">
        <div>
            <div class="flex items-center gap-2 text-xs text-gray-500 mb-1">
                <a href="{{ route('admin.matchday.players.index') }}" class="hover:text-gray-900 transition">Players Catalogue</a>
                <span>/</span>
                <span class="text-gray-900 font-semibold">Edit Player #{{ $player->id }}</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900">
                Edit Player: {{ $player->name }}
            </h1>
            <p class="text-sm text-gray-500 mt-1">Update player details, club, ratings, or upload a new photo.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.matchday.players.index') }}" 
               class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-semibold transition">
                <i data-lucide="arrow-left" style="width:16px; height:16px;"></i>
                <span>Back to Players</span>
            </a>
        </div>
    </div>

    <!-- Main Grid: Form on Left, Live Card Preview on Right -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        <!-- Form (7 Cols) -->
        <div class="lg:col-span-7 bg-white p-6 sm:p-8 rounded-3xl border border-gray-100 shadow-sm">
            
            <form action="{{ route('admin.matchday.players.update', $player->id) }}" 
                  method="POST" 
                  enctype="multipart/form-data" 
                  id="playerForm">
                @csrf
                @method('PUT')

                <!-- Basic Information Section -->
                <div class="mb-6">
                    <h2 class="text-xs uppercase tracking-wider text-gray-400 font-bold mb-4 pb-1 border-b border-gray-100">
                        1. Player Identity
                    </h2>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1.5">
                                Full Name <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" 
                                   name="name" 
                                   id="inputName" 
                                   value="{{ old('name', $player->name) }}" 
                                   required 
                                   class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#C25A2A]/40 focus:border-[#C25A2A]">
                            @error('name') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1.5">
                                Display / Jersey Name
                            </label>
                            <input type="text" 
                                   name="display_name" 
                                   id="inputDisplayName" 
                                   value="{{ old('display_name', $player->display_name) }}" 
                                   class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#C25A2A]/40 focus:border-[#C25A2A]">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1.5">
                                Club Name <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" 
                                   name="club_name" 
                                   id="inputClub" 
                                   value="{{ old('club_name', $player->club_name) }}" 
                                   required 
                                   class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#C25A2A]/40 focus:border-[#C25A2A]">
                            @error('club_name') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1.5">
                                Nationality
                            </label>
                            <input type="text" 
                                   name="nationality" 
                                   value="{{ old('nationality', $player->nationality ?: 'England') }}" 
                                   class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#C25A2A]/40 focus:border-[#C25A2A]">
                        </div>
                    </div>
                </div>

                <!-- Position & Rarity Section -->
                <div class="mb-6">
                    <h2 class="text-xs uppercase tracking-wider text-gray-400 font-bold mb-4 pb-1 border-b border-gray-100">
                        2. Position & Rarity
                    </h2>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1.5">
                                Position <span class="text-rose-500">*</span>
                            </label>
                            <select name="position" 
                                    id="inputPosition" 
                                    required 
                                    class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#C25A2A]/40 focus:border-[#C25A2A]">
                                <option value="FWD" {{ old('position', $player->position) == 'FWD' ? 'selected' : '' }}>Forward (FWD)</option>
                                <option value="MID" {{ old('position', $player->position) == 'MID' ? 'selected' : '' }}>Midfielder (MID)</option>
                                <option value="DEF" {{ old('position', $player->position) == 'DEF' ? 'selected' : '' }}>Defender (DEF)</option>
                                <option value="GK" {{ old('position', $player->position) == 'GK' ? 'selected' : '' }}>Goalkeeper (GK)</option>
                            </select>
                            @error('position') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1.5">
                                Sub-Position / Role
                            </label>
                            <input type="text" 
                                   name="sub_position" 
                                   id="inputSubPos" 
                                   value="{{ old('sub_position', $player->sub_position) }}" 
                                   class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#C25A2A]/40 focus:border-[#C25A2A]">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1.5">
                                Card Rarity <span class="text-rose-500">*</span>
                            </label>
                            <select name="rarity" 
                                    id="inputRarity" 
                                    required 
                                    class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#C25A2A]/40 focus:border-[#C25A2A]">
                                <option value="legendary" {{ old('rarity', $player->rarity) == 'legendary' ? 'selected' : '' }}>Legendary (Gold)</option>
                                <option value="epic" {{ old('rarity', $player->rarity) == 'epic' ? 'selected' : '' }}>Epic (Purple)</option>
                                <option value="rare" {{ old('rarity', $player->rarity) == 'rare' ? 'selected' : '' }}>Rare (Blue)</option>
                                <option value="common" {{ old('rarity', $player->rarity) == 'common' ? 'selected' : '' }}>Common (Silver)</option>
                            </select>
                            @error('rarity') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- Ratings & Statistics -->
                <div class="mb-6">
                    <h2 class="text-xs uppercase tracking-wider text-gray-400 font-bold mb-4 pb-1 border-b border-gray-100">
                        3. Ratings & Match Stats (0 - 99)
                    </h2>

                    <div class="grid grid-cols-2 sm:grid-cols-5 gap-3">
                        <div class="bg-amber-50/60 p-3 rounded-2xl border border-amber-200/80">
                            <label class="block text-[11px] font-black text-amber-900 uppercase mb-1">
                                OVR Rating <span class="text-rose-500">*</span>
                            </label>
                            <input type="number" 
                                   name="overall_rating" 
                                   id="inputOvr" 
                                   value="{{ old('overall_rating', $player->overall_rating) }}" 
                                   min="40" max="99" required 
                                   class="w-full bg-white border border-amber-300 rounded-xl px-2.5 py-1.5 text-base font-black text-center text-amber-950 focus:outline-none focus:ring-2 focus:ring-amber-500">
                        </div>

                        <div class="p-3 rounded-2xl border border-gray-200">
                            <label class="block text-[11px] font-bold text-gray-700 uppercase mb-1">
                                Attack (ATT)
                            </label>
                            <input type="number" 
                                   name="stat_attack" 
                                   id="inputAtt" 
                                   value="{{ old('stat_attack', $player->stat_attack) }}" 
                                   min="0" max="99" required 
                                   class="w-full bg-white border border-gray-200 rounded-xl px-2.5 py-1.5 text-sm font-bold text-center focus:outline-none focus:ring-2 focus:ring-[#C25A2A]/40">
                        </div>

                        <div class="p-3 rounded-2xl border border-gray-200">
                            <label class="block text-[11px] font-bold text-gray-700 uppercase mb-1">
                                Midfield (MID)
                            </label>
                            <input type="number" 
                                   name="stat_midfield" 
                                   id="inputMid" 
                                   value="{{ old('stat_midfield', $player->stat_midfield) }}" 
                                   min="0" max="99" required 
                                   class="w-full bg-white border border-gray-200 rounded-xl px-2.5 py-1.5 text-sm font-bold text-center focus:outline-none focus:ring-2 focus:ring-[#C25A2A]/40">
                        </div>

                        <div class="p-3 rounded-2xl border border-gray-200">
                            <label class="block text-[11px] font-bold text-gray-700 uppercase mb-1">
                                Defence (DEF)
                            </label>
                            <input type="number" 
                                   name="stat_defence" 
                                   id="inputDef" 
                                   value="{{ old('stat_defence', $player->stat_defence) }}" 
                                   min="0" max="99" required 
                                   class="w-full bg-white border border-gray-200 rounded-xl px-2.5 py-1.5 text-sm font-bold text-center focus:outline-none focus:ring-2 focus:ring-[#C25A2A]/40">
                        </div>

                        <div class="p-3 rounded-2xl border border-gray-200 col-span-2 sm:col-span-1">
                            <label class="block text-[11px] font-bold text-gray-700 uppercase mb-1">
                                GK (Goalkeeping)
                            </label>
                            <input type="number" 
                                   name="stat_goalkeeping" 
                                   id="inputGk" 
                                   value="{{ old('stat_goalkeeping', $player->stat_goalkeeping) }}" 
                                   min="0" max="99" required 
                                   class="w-full bg-white border border-gray-200 rounded-xl px-2.5 py-1.5 text-sm font-bold text-center focus:outline-none focus:ring-2 focus:ring-[#C25A2A]/40">
                        </div>
                    </div>
                </div>

                <!-- Player Image / Portrait Section -->
                <div class="mb-6">
                    <h2 class="text-xs uppercase tracking-wider text-gray-400 font-bold mb-4 pb-1 border-b border-gray-100">
                        4. Player Portrait & Photo
                    </h2>

                    <!-- Current Photo Thumbnail -->
                    <div class="mb-4 flex items-center gap-3 p-3 rounded-xl bg-gray-50 border border-gray-200">
                        <div class="w-12 h-12 rounded-lg bg-slate-900 flex items-center justify-center overflow-hidden border border-gray-300 flex-shrink-0">
                            <img src="{{ $player->image_url }}" alt="{{ $player->name }}" class="w-full h-full object-contain">
                        </div>
                        <div>
                            <div class="text-xs font-bold text-gray-800">Current Photo</div>
                            <div class="text-[11px] text-gray-500 break-all">{{ $player->avatar_url ?: 'Default Auto-generated Avatar' }}</div>
                        </div>
                    </div>

                    <!-- Option A: File Upload -->
                    <div class="mb-4">
                        <label class="block text-xs font-bold text-gray-700 mb-1.5">
                            Replace Photo File (PNG / JPG / WEBP)
                        </label>
                        <input type="file" 
                               name="image_file" 
                               id="inputImageFile" 
                               accept="image/png,image/jpeg,image/webp,image/svg+xml"
                               class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm text-gray-600 file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200">
                        <span class="text-[11px] text-gray-400 mt-1 block">Leave empty to keep current photo. Transparent PNG recommended.</span>
                        @error('image_file') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Option B: Direct URL -->
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1.5">
                            Or Set External Image URL
                        </label>
                        <input type="url" 
                               name="avatar_url" 
                               id="inputAvatarUrl" 
                               value="{{ old('avatar_url', $player->avatar_url) }}" 
                               placeholder="https://resources.premierleague.com/... or any image link" 
                               class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#C25A2A]/40 focus:border-[#C25A2A]">
                    </div>
                </div>

                <!-- Active Status Checkbox -->
                <div class="mb-8 p-4 rounded-2xl bg-gray-50 border border-gray-200/80 flex items-center justify-between">
                    <div>
                        <div class="text-sm font-bold text-gray-900">Active in Card Packs</div>
                        <div class="text-xs text-gray-500">Allow customers to unlock and pick this card when ordering food.</div>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" class="sr-only peer" {{ old('is_active', $player->is_active) ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-600"></div>
                    </label>
                </div>

                <!-- Submit Button -->
                <div class="flex items-center gap-3">
                    <button type="submit" 
                            class="flex-1 bg-[#C25A2A] hover:bg-[#a94c20] text-white py-3 px-6 rounded-xl font-bold text-sm shadow-md transition text-center">
                        Update Player Details
                    </button>
                    <a href="{{ route('admin.matchday.players.index') }}" 
                       class="px-5 py-3 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-semibold transition text-center">
                        Cancel
                    </a>
                </div>

            </form>
        </div>

        <!-- Live Preview Card (5 Cols) -->
        <div class="lg:col-span-5 sticky top-24">
            <div class="bg-gray-900 text-white p-5 rounded-3xl shadow-xl border border-gray-800">
                <div class="flex items-center justify-between gap-2 mb-4 pb-3 border-b border-white/10">
                    <span class="text-xs font-bold text-amber-300 uppercase tracking-wider flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                        Live Card Preview
                    </span>
                    <span id="previewRarityBadge" class="text-[10px] font-black uppercase px-2 py-0.5 rounded bg-gray-700 text-gray-300">
                        {{ $player->rarity }}
                    </span>
                </div>

                <!-- Card Body -->
                <div id="previewCardFrame" class="relative rounded-2xl p-5 overflow-hidden transition-all duration-300"
                     style="background: linear-gradient(145deg, #0f172a 0%, #1e293b 100%);">
                    
                    <!-- Top Ribbon: OVR & Position -->
                    <div class="flex items-center justify-between mb-3 relative z-10">
                        <div class="flex items-center gap-2">
                            <span id="previewOvr" class="text-3xl font-black text-amber-400 font-['Poppins']">{{ $player->overall_rating }}</span>
                            <div>
                                <span id="previewPos" class="text-xs font-black px-2 py-0.5 rounded bg-white/15 text-white">{{ $player->position }}</span>
                                <div class="text-[10px] text-gray-300 mt-0.5">🏴󠁧󠁢󠁥󠁮󠁧󠁿 England</div>
                            </div>
                        </div>
                        <div id="previewClub" class="text-xs font-semibold text-gray-300 max-w-[130px] truncate text-right">
                            {{ $player->club_name }}
                        </div>
                    </div>

                    <!-- Player Photo Stage -->
                    <div class="relative w-36 h-40 mx-auto my-2 flex items-center justify-center z-10">
                        <div class="absolute inset-0 rounded-full bg-amber-400/10 blur-xl"></div>
                        <img id="previewImg" 
                             src="{{ $player->image_url }}" 
                             alt="Player Preview" 
                             class="max-h-36 max-w-full object-contain filter drop-shadow-[0_8px_16px_rgba(0,0,0,0.6)]">
                    </div>

                    <!-- Player Name -->
                    <div class="text-center relative z-10 mt-2 mb-3">
                        <div id="previewName" class="text-lg font-black tracking-wide text-white font-['Poppins']">
                            {{ $player->display_name ?: $player->name }}
                        </div>
                        <div id="previewSubPos" class="text-[11px] text-amber-300 font-semibold">
                            {{ $player->sub_position ?: $player->position }}
                        </div>
                    </div>

                    <!-- Stat Bars Grid -->
                    <div class="grid grid-cols-4 gap-1.5 text-center relative z-10 bg-black/40 p-2.5 rounded-xl border border-white/10 text-xs">
                        <div>
                            <div class="text-[9px] text-gray-400 font-bold">ATT</div>
                            <div id="previewAtt" class="font-black text-white">{{ $player->stat_attack }}</div>
                        </div>
                        <div>
                            <div class="text-[9px] text-gray-400 font-bold">MID</div>
                            <div id="previewMid" class="font-black text-white">{{ $player->stat_midfield }}</div>
                        </div>
                        <div>
                            <div class="text-[9px] text-gray-400 font-bold">DEF</div>
                            <div id="previewDef" class="font-black text-white">{{ $player->stat_defence }}</div>
                        </div>
                        <div>
                            <div class="text-[9px] text-gray-400 font-bold">GK</div>
                            <div id="previewGk" class="font-black text-white">{{ $player->stat_goalkeeping }}</div>
                        </div>
                    </div>

                </div>

                <div class="mt-4 text-center text-xs text-gray-400">
                    Changes apply immediately to player packs, customer collections, and match simulations.
                </div>
            </div>
        </div>

    </div>

</div>

<script>
    const inputName = document.getElementById('inputName');
    const inputDisplayName = document.getElementById('inputDisplayName');
    const inputClub = document.getElementById('inputClub');
    const inputPosition = document.getElementById('inputPosition');
    const inputSubPos = document.getElementById('inputSubPos');
    const inputRarity = document.getElementById('inputRarity');
    const inputOvr = document.getElementById('inputOvr');
    const inputAtt = document.getElementById('inputAtt');
    const inputMid = document.getElementById('inputMid');
    const inputDef = document.getElementById('inputDef');
    const inputGk = document.getElementById('inputGk');
    const inputAvatarUrl = document.getElementById('inputAvatarUrl');
    const inputImageFile = document.getElementById('inputImageFile');

    const previewName = document.getElementById('previewName');
    const previewClub = document.getElementById('previewClub');
    const previewPos = document.getElementById('previewPos');
    const previewSubPos = document.getElementById('previewSubPos');
    const previewRarityBadge = document.getElementById('previewRarityBadge');
    const previewOvr = document.getElementById('previewOvr');
    const previewAtt = document.getElementById('previewAtt');
    const previewMid = document.getElementById('previewMid');
    const previewDef = document.getElementById('previewDef');
    const previewGk = document.getElementById('previewGk');
    const previewImg = document.getElementById('previewImg');
    const previewCardFrame = document.getElementById('previewCardFrame');

    function updatePreview() {
        previewName.textContent = inputDisplayName.value || inputName.value || 'Player Name';
        previewClub.textContent = inputClub.value || 'Club Name';
        previewPos.textContent = inputPosition.value;
        previewSubPos.textContent = inputSubPos.value || inputPosition.value;
        previewOvr.textContent = inputOvr.value || '80';
        previewAtt.textContent = inputAtt.value || '0';
        previewMid.textContent = inputMid.value || '0';
        previewDef.textContent = inputDef.value || '0';
        previewGk.textContent = inputGk.value || '0';

        const rarity = inputRarity.value;
        previewRarityBadge.textContent = rarity;
        
        if (rarity === 'legendary') {
            previewRarityBadge.className = 'text-[10px] font-black uppercase px-2 py-0.5 rounded bg-amber-400 text-stone-950';
            previewCardFrame.style.background = 'linear-gradient(145deg, #1C1917 0%, #3B2E10 40%, #1C1917 100%)';
            previewCardFrame.style.border = '2px solid rgba(251, 191, 36, 0.4)';
        } else if (rarity === 'epic') {
            previewRarityBadge.className = 'text-[10px] font-black uppercase px-2 py-0.5 rounded bg-purple-500 text-white';
            previewCardFrame.style.background = 'linear-gradient(145deg, #0f172a 0%, #2e1065 50%, #0f172a 100%)';
            previewCardFrame.style.border = '2px solid rgba(168, 85, 247, 0.4)';
        } else if (rarity === 'rare') {
            previewRarityBadge.className = 'text-[10px] font-black uppercase px-2 py-0.5 rounded bg-blue-500 text-white';
            previewCardFrame.style.background = 'linear-gradient(145deg, #082f49 0%, #0c4a6e 50%, #031b2d 100%)';
            previewCardFrame.style.border = '2px solid rgba(56, 189, 248, 0.4)';
        } else {
            previewRarityBadge.className = 'text-[10px] font-black uppercase px-2 py-0.5 rounded bg-gray-700 text-gray-300';
            previewCardFrame.style.background = 'linear-gradient(145deg, #0f172a 0%, #1e293b 100%)';
            previewCardFrame.style.border = '2px solid rgba(255, 255, 255, 0.1)';
        }

        if (inputAvatarUrl.value) {
            previewImg.src = inputAvatarUrl.value;
        }
    }

    inputImageFile.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(evt) {
                previewImg.src = evt.target.result;
            };
            reader.readAsDataURL(file);
        }
    });

    [inputName, inputDisplayName, inputClub, inputPosition, inputSubPos, inputRarity, inputOvr, inputAtt, inputMid, inputDef, inputGk, inputAvatarUrl].forEach(el => {
        el.addEventListener('input', updatePreview);
        el.addEventListener('change', updatePreview);
    });

    updatePreview();
</script>
@endsection
