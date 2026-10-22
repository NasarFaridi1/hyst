@extends('front.layouts.app')

@section('title', 'Foodie Community & Circles | HYST')

@section('content')
<main style="background: #F5F5F0; min-height: 85vh; padding: 36px 0 60px;">
    <div class="mx-auto max-w-6xl px-4 sm:px-6">

        <!-- Top Header & WhatsApp Invite Banner -->
        <div class="rounded-3xl bg-[#0D0B09] border border-white/10 p-6 sm:p-8 text-white relative overflow-hidden shadow-2xl mb-8">
            <div class="absolute -right-16 -top-16 w-60 h-60 bg-[#C25A2A]/20 rounded-full blur-3xl pointer-events-none"></div>

            <div class="relative z-10 flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 border border-white/15 text-xs font-semibold text-amber-300 uppercase tracking-wider mb-2.5">
                        <span>✨</span> HYST Foodie Community
                    </div>
                    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-white tracking-tight mb-2">
                        Eat Better, <span class="bg-gradient-to-r from-[#FF8A50] to-[#FBBF24] bg-clip-text text-transparent">Together.</span>
                    </h1>
                    <p class="text-xs sm:text-sm text-stone-300 max-w-xl leading-relaxed">
                        Share honest dining thoughts, discover secret menu items, and connect with fellow foodies. Invite your friends via WhatsApp so they can join your private Foodie Circle!
                    </p>
                </div>

                <!-- WhatsApp Share Quick Action Box -->
                <div class="w-full md:w-auto flex-shrink-0 bg-white/5 border border-white/10 rounded-2xl p-4 sm:p-5 flex flex-col items-stretch gap-2.5">
                    <div class="text-xs font-bold text-stone-300 flex items-center justify-between gap-3">
                        <span>📲 Invite Friends to Circle</span>
                        @if($userCircle)
                            <span class="text-[11px] font-mono text-amber-300 bg-white/10 px-2 py-0.5 rounded">{{ $userCircle->invite_code }}</span>
                        @endif
                    </div>

                    <a href="{{ $whatsappShareUrl }}" target="_blank" class="inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-[#25D366] hover:bg-[#20BD5A] text-white font-bold text-xs sm:text-sm shadow-lg shadow-[#25D366]/30 transition-all text-center">
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                            <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.312.045-.694.044-1.109-.087-.414-.131-.954-.312-1.637-.607-1.19-.515-2.079-1.671-2.14-1.75-.062-.079-.484-.645-.484-1.232 0-.588.307-.877.417-.996.11-.119.24-.149.32-.149.08 0 .16.002.23.006.075.004.175-.029.273.208.103.249.351.856.382.919.031.063.051.137.01.218-.041.081-.062.132-.122.203-.061.071-.129.158-.184.212-.061.06-.125.126-.054.248.071.122.315.52.677.842.465.414.858.543.98.604.122.061.194.051.266-.031.072-.082.307-.358.389-.48.082-.122.164-.102.276-.061.112.041.71.335.832.396.122.061.203.092.234.143.031.051.031.296-.113.701zM12 2C6.477 2 2 6.477 2 12c0 1.89.525 3.66 1.438 5.168L2.05 22l4.98-1.306A9.957 9.957 0 0012 22c5.523 0 10-4.477 10-10S17.523 2 12 2zm0 18.167a8.13 8.13 0 01-4.218-1.175l-.302-.18-2.964.777.791-2.89-.196-.312A8.134 8.134 0 013.833 12c0-4.503 3.664-8.167 8.167-8.167s8.167 3.664 8.167 8.167-3.664 8.167-8.167 8.167z"/>
                        </svg>
                        <span>Share on WhatsApp</span>
                    </a>

                    <button type="button" onclick="copyInviteLink('{{ $inviteUrl }}')" class="text-[11px] text-stone-400 hover:text-white transition-colors text-center underline underline-offset-2">
                        📋 Copy Invite Link
                    </button>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Left Feed & Creator (8 cols) -->
            <div class="lg:col-span-8 space-y-6">

                <!-- Post Creator Card -->
                @auth
                <div class="bg-white rounded-3xl p-6 sm:p-7 shadow-sm border border-stone-200">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-full bg-[#C25A2A] text-white flex items-center justify-center font-bold text-sm">
                            {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                        </div>
                        <div>
                            <div class="font-bold text-sm text-[#0D0B09]">Share a Food Thought or Review</div>
                            <div class="text-xs text-stone-500">Posting to: <span class="font-semibold text-[#C25A2A]">{{ $userCircle->name ?? 'HYST Community' }}</span></div>
                        </div>
                    </div>

                    <form action="{{ route('front.community.post') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <input type="hidden" name="community_id" value="{{ $userCircle->id ?? '' }}">

                        <textarea name="content" rows="3" required placeholder="What was your latest favorite dish on Hyst? Share your thoughts, flavor notes, or recommendations with your circle..." class="w-full rounded-2xl border border-stone-200 p-4 text-xs sm:text-sm text-stone-800 placeholder-stone-400 focus:outline-none focus:ring-2 focus:ring-[#C25A2A]/40 resize-none"></textarea>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <!-- Restaurant Tag -->
                            <div>
                                <label class="block text-[11px] font-bold text-stone-600 uppercase mb-1">Tag Restaurant</label>
                                <select name="restaurant_id" id="communityRestaurantSelect" onchange="onCommunityRestaurantChange(this.value)" class="w-full rounded-xl border border-stone-200 p-2.5 text-xs text-stone-700 focus:outline-none focus:ring-1 focus:ring-[#C25A2A]">
                                    <option value="">-- None / General --</option>
                                    @foreach($restaurants as $r)
                                        <option value="{{ $r->id }}">{{ $r->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Tag / Category -->
                            <div>
                                <label class="block text-[11px] font-bold text-stone-600 uppercase mb-1">Foodie Vibe</label>
                                <select name="tag" class="w-full rounded-xl border border-stone-200 p-2.5 text-xs text-stone-700 focus:outline-none focus:ring-1 focus:ring-[#C25A2A]">
                                    <option value="🔥 Must Try">🔥 Must Try</option>
                                    <option value="⭐ Hidden Gem">⭐ Hidden Gem</option>
                                    <option value="🍕 Late Night Craving">🍕 Late Night</option>
                                    <option value="🌱 Vegan Pick">🌱 Vegan Pick</option>
                                    <option value="🎉 Weekend Feast">🎉 Weekend Feast</option>
                                </select>
                            </div>

                            <!-- Rating -->
                            <div>
                                <label class="block text-[11px] font-bold text-stone-600 uppercase mb-1">Your Rating</label>
                                <select name="rating" class="w-full rounded-xl border border-stone-200 p-2.5 text-xs text-stone-700 focus:outline-none focus:ring-1 focus:ring-[#C25A2A]">
                                    <option value="5">★★★★★ (5/5 Outstanding)</option>
                                    <option value="4">★★★★☆ (4/5 Great)</option>
                                    <option value="3">★★★☆☆ (3/5 Good)</option>
                                </select>
                            </div>
                        </div>

                        <!-- Restaurant Dishes / Product Photo Selector -->
                        <div id="restaurantDishesContainer" class="hidden mt-3 pt-3 border-t border-stone-100">
                            <div class="flex items-center justify-between mb-2">
                                <label class="text-[11px] font-bold text-stone-700 uppercase tracking-wider flex items-center gap-1.5">
                                    <span>🍲</span> Select Dish Photo from Menu:
                                </label>
                                <span id="dishesLoadingStatus" class="text-[10px] text-stone-400 font-medium"></span>
                            </div>

                            <!-- Scrollable Dish Cards -->
                            <div id="dishesList" class="flex items-stretch gap-2.5 overflow-x-auto pb-2 scrollbar-thin">
                                <!-- Rendered dynamically via JS -->
                            </div>
                        </div>

                        <!-- Selected Dish Active Badge & Preview -->
                        <div id="selectedDishPreview" class="hidden mt-2.5 p-2.5 rounded-xl bg-amber-50/80 border border-amber-200 flex items-center justify-between gap-3">
                            <div class="flex items-center gap-2.5 min-w-0">
                                <img id="selectedDishImg" src="" alt="Selected Dish" class="w-11 h-11 rounded-lg object-cover border border-amber-300 shadow-2xs flex-shrink-0">
                                <div class="min-w-0">
                                    <div class="text-xs font-extrabold text-stone-900 truncate" id="selectedDishName"></div>
                                    <div class="text-[11px] font-bold text-[#C25A2A]" id="selectedDishPrice"></div>
                                </div>
                            </div>
                            <button type="button" onclick="clearSelectedDish()" class="text-xs text-stone-400 hover:text-red-600 font-bold px-2 py-1 transition-colors">
                                ✕ Remove
                            </button>
                        </div>

                        <input type="hidden" name="product_id" id="selectedProductId" value="">
                        <input type="hidden" name="selected_image" id="selectedDishImage" value="">

                        <div class="flex items-center justify-between pt-2 border-t border-stone-100">
                            <div class="flex items-center gap-2.5 flex-wrap">
                                <label class="cursor-pointer inline-flex items-center gap-1.5 text-xs text-stone-600 hover:text-[#C25A2A] font-medium transition-colors">
                                    <svg class="w-4 h-4 text-[#C25A2A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <span id="photoUploadLabel">Upload Custom Photo</span>
                                    <input type="file" name="image" id="customPhotoInput" accept="image/*" class="hidden" onchange="onCustomPhotoChange(this)">
                                </label>
                                <span id="customPhotoBadge" class="hidden text-[11px] bg-emerald-50 text-emerald-700 border border-emerald-200 px-2 py-0.5 rounded-full font-semibold"></span>
                            </div>

                            <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#C25A2A] hover:bg-[#A94A1F] text-white font-bold text-xs sm:text-sm shadow-md shadow-[#C25A2A]/30 transition-all cursor-pointer">
                                Post to Circle
                            </button>
                        </div>
                    </form>
                </div>
                @else
                <div class="bg-white rounded-3xl p-6 sm:p-8 text-center border border-stone-200 shadow-sm">
                    <div class="w-12 h-12 rounded-2xl bg-amber-50 text-[#C25A2A] flex items-center justify-center mx-auto text-2xl mb-3">
                        💬
                    </div>
                    <h3 class="font-extrabold text-base sm:text-lg text-stone-900 mb-1">Join the Foodie Conversation</h3>
                    <p class="text-xs sm:text-sm text-stone-500 mb-4 max-w-md mx-auto">
                        Sign in to share your favorite dishes, post honest restaurant thoughts, and invite your friends to your private Foodie Circle.
                    </p>
                    <a href="/login" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-[#C25A2A] text-white font-bold text-xs sm:text-sm shadow-md shadow-[#C25A2A]/30">
                        Sign In to Join
                    </a>
                </div>
                @endauth

                <!-- Community Feed List -->
                <div class="space-y-4">
                    <h2 class="text-lg font-extrabold text-stone-900 tracking-tight flex items-center gap-2">
                        <span>🔥</span> Circle Thoughts & Activity
                    </h2>

                    @forelse($posts as $post)
                    <div class="bg-white rounded-3xl p-6 sm:p-7 shadow-sm border border-stone-200 transition-all hover:border-stone-300">
                        
                        <!-- Post Author Header -->
                        <div class="flex items-start justify-between gap-3 mb-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-[#C25A2A] to-[#D97040] text-white flex items-center justify-center font-bold text-xs shadow-sm">
                                    {{ strtoupper(substr($post->user->name ?? 'F', 0, 1)) }}
                                </div>
                                <div>
                                    <div class="font-bold text-xs sm:text-sm text-stone-900">{{ $post->user->name ?? 'Community Foodie' }}</div>
                                    <div class="text-[11px] text-stone-400">
                                        {{ $post->created_at ? $post->created_at->diffForHumans() : 'Recently' }}
                                        @if($post->community)
                                            • in <span class="text-stone-600 font-medium">{{ $post->community->name }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center gap-2">
                                @if($post->tag)
                                    <span class="px-2.5 py-1 rounded-full bg-amber-50 text-amber-800 border border-amber-200/80 text-[10.5px] font-bold">
                                        {{ $post->tag }}
                                    </span>
                                @endif
                                @if($post->rating)
                                    <span class="text-amber-500 text-xs font-bold">
                                        {{ str_repeat('★', $post->rating) }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Post Text -->
                        <p class="text-xs sm:text-sm text-stone-700 leading-relaxed mb-4">
                            {{ $post->content }}
                        </p>

                        <!-- Attached Image -->
                        @php
                            $postImgUrl = null;
                            if (!empty($post->image)) {
                                if (str_starts_with($post->image, 'http')) {
                                    $postImgUrl = $post->image;
                                } elseif (str_starts_with($post->image, 'uploads/') || str_starts_with($post->image, 'storage/')) {
                                    $postImgUrl = asset($post->image);
                                } else {
                                    $postImgUrl = config('services.google_drive.image_url') . $post->image;
                                }
                            }
                        @endphp
                        @if($postImgUrl)
                            <div class="rounded-2xl overflow-hidden mb-4 border border-stone-100 max-h-80 bg-stone-50">
                                <img src="{{ $postImgUrl }}" alt="Food dish" class="w-full h-full object-cover">
                            </div>
                        @endif

                        <!-- Dish / Product Tag (if selected) -->
                        @if($post->product)
                            <div class="inline-flex items-center gap-1.5 px-3 py-1 mb-3 rounded-xl bg-amber-50/90 border border-amber-200 text-stone-800 text-xs font-bold">
                                <span>🍲</span>
                                <span>{{ $post->product->name }}</span>
                                @if($post->product->price)
                                    <span class="text-[#C25A2A]">£{{ number_format((float)$post->product->price, 2) }}</span>
                                @endif
                            </div>
                        @endif

                        <!-- Restaurant Link (if tagged) -->
                        @if($post->restaurant)
                            <div class="p-3 rounded-2xl bg-stone-50 border border-stone-200/80 flex items-center justify-between gap-3 mb-4">
                                <div class="flex items-center gap-3 min-w-0">
                                    <div class="w-8 h-8 rounded-lg bg-[#C25A2A]/15 text-[#C25A2A] flex items-center justify-center text-sm font-bold flex-shrink-0">
                                        🍴
                                    </div>
                                    <div class="min-w-0">
                                        <div class="font-bold text-xs text-stone-900 truncate">{{ $post->restaurant->name }}</div>
                                        <div class="text-[10.5px] text-stone-500">Order direct on HYST</div>
                                    </div>
                                </div>
                                <a href="{{ route('front.restaurants.show', $post->restaurant->slug ?? $post->restaurant->id) }}" class="inline-flex items-center gap-1 text-xs font-bold text-[#C25A2A] hover:underline flex-shrink-0">
                                    <span>View Menu</span>
                                    <span>→</span>
                                </a>
                            </div>
                        @endif

                        <!-- Post Footer: Likes & Share -->
                        <div class="flex items-center justify-between pt-3 border-t border-stone-100 text-xs text-stone-500">
                            <button type="button" onclick="togglePostLike({{ $post->id }}, this)" class="inline-flex items-center gap-1.5 font-semibold hover:text-[#C25A2A] transition-colors">
                                <span class="like-icon text-sm">❤️</span>
                                <span class="like-count">{{ $post->likes_count ?? 0 }}</span>
                                <span>Likes</span>
                            </button>

                            <div class="text-[11px] text-stone-400">
                                HYST Verified Foodie Experience
                            </div>
                        </div>

                    </div>
                    @empty
                    <div class="bg-white rounded-3xl p-8 text-center border border-stone-200">
                        <div class="text-3xl mb-2">🍽️</div>
                        <h4 class="font-bold text-sm text-stone-800 mb-1">Be the first to share a thought!</h4>
                        <p class="text-xs text-stone-500 max-w-sm mx-auto">
                            Share what you had for dinner or invite friends to your Foodie Circle via WhatsApp to kick off the conversation.
                        </p>
                    </div>
                    @endforelse
                </div>

            </div>

            <!-- Right Sidebar: Circles & Ethos (4 cols) -->
            <div class="lg:col-span-4 space-y-6">
                
                <!-- My Foodie Circle Card -->
                @auth
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-stone-200">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-extrabold text-sm text-stone-900">My Foodie Circles</h3>
                        <span class="text-xs bg-emerald-50 text-emerald-700 px-2 py-0.5 rounded-full font-bold">Active</span>
                    </div>

                    <div class="p-4 rounded-2xl bg-amber-50/60 border border-amber-200/60 mb-4">
                        <div class="font-bold text-xs text-stone-900 mb-0.5">{{ $userCircle->name ?? 'My Circle' }}</div>
                        <div class="text-[11px] text-stone-500 mb-3">Invite code: <span class="font-mono font-bold text-[#C25A2A]">{{ $userCircle->invite_code ?? 'HYST' }}</span></div>
                        
                        <a href="{{ $whatsappShareUrl }}" target="_blank" class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-[#25D366] text-white text-xs font-bold shadow-sm hover:bg-[#20BD5A] transition-all text-center">
                            <span>Invite on WhatsApp</span>
                        </a>
                    </div>

                    @if($joinedCircles->isNotEmpty())
                    <div class="text-xs font-bold text-stone-700 uppercase tracking-wider mb-2">Joined Circles</div>
                    <div class="space-y-2">
                        @foreach($joinedCircles as $jc)
                            <div class="flex items-center justify-between text-xs p-2.5 rounded-xl bg-stone-50 border border-stone-100">
                                <span class="font-semibold text-stone-800">{{ $jc->name }}</span>
                                <span class="text-[10px] text-stone-400">Member</span>
                            </div>
                        @endforeach
                    </div>
                    @endif
                </div>
                @endauth

                <!-- Community Ethos Card -->
                <div class="bg-[#0D0B09] rounded-3xl p-6 text-white border border-white/10 shadow-lg">
                    <div class="text-xs font-bold text-amber-400 uppercase tracking-wider mb-2">Circle Principles</div>
                    <h4 class="text-base font-extrabold text-white mb-2">Honest Food, Zero Noise</h4>
                    <p class="text-xs text-stone-300 leading-relaxed mb-4">
                        Hyst Foodie Circles are built for genuine friends and local food lovers. No paid endorsements, no algorithm trickery &mdash; just real recommendations from people you trust.
                    </p>

                    <div class="space-y-2 text-xs text-stone-300">
                        <div class="flex items-center gap-2">
                            <span class="text-emerald-400">✓</span>
                            <span>Direct restaurant pricing without 30% app tax</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-emerald-400">✓</span>
                            <span>Order directly with 1 click from reviews</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-emerald-400">✓</span>
                            <span>Safe, private circles for you and your friends</span>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
</main>

<script>
function copyInviteLink(url) {
    if (navigator.clipboard && window.isSecureContext) {
        navigator.clipboard.writeText(url).then(() => {
            alert('🎉 Invite link copied! Send it to your friends on WhatsApp or Messenger.');
        });
    } else {
        const input = document.createElement('textarea');
        input.value = url;
        document.body.appendChild(input);
        input.select();
        document.execCommand('copy');
        document.body.removeChild(input);
        alert('🎉 Invite link copied! Send it to your friends.');
    }
}

function togglePostLike(postId, button) {
    fetch('/community/posts/' + postId + '/like', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    })
    .then(r => {
        if (r.status === 401) {
            window.location.href = '/login';
            return;
        }
        return r.json();
    })
    .then(data => {
        if (data && data.success) {
            button.querySelector('.like-count').textContent = data.count;
            if (data.liked) {
                button.classList.add('text-[#C25A2A]');
            } else {
                button.classList.remove('text-[#C25A2A]');
            }
        }
    })
    .catch(err => console.error(err));
}

// ── Restaurant Dishes & Menu Photo Selector ──
let currentRestaurantProducts = [];

function onCommunityRestaurantChange(restaurantId) {
    clearSelectedDish();
    const container = document.getElementById('restaurantDishesContainer');
    const list = document.getElementById('dishesList');
    const status = document.getElementById('dishesLoadingStatus');

    if (!container || !list) return;

    if (!restaurantId) {
        container.classList.add('hidden');
        list.innerHTML = '';
        currentRestaurantProducts = [];
        return;
    }

    container.classList.remove('hidden');
    list.innerHTML = '';
    if (status) status.textContent = 'Loading menu dishes...';

    fetch('/community/restaurant/' + restaurantId + '/products', {
        headers: {
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {
        if (status) status.textContent = '';
        if (data.success && data.products && data.products.length > 0) {
            currentRestaurantProducts = data.products;
            if (status) status.textContent = `${data.products.length} dishes available`;

            data.products.forEach(p => {
                const card = document.createElement('div');
                card.id = 'dish-card-' + p.id;
                card.className = 'dish-select-card flex-shrink-0 w-28 bg-white border border-stone-200 rounded-xl p-2 cursor-pointer hover:border-[#C25A2A] hover:shadow-xs transition-all text-center group';
                card.onclick = () => selectDish(p.id, p.name, p.price, p.image, p.image_url);

                card.innerHTML = `
                    <div class="relative w-full h-16 rounded-lg overflow-hidden mb-1.5 bg-stone-100">
                        <img src="${p.image_url}" alt="${p.name}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-200">
                        <div class="dish-check-badge hidden absolute top-1 right-1 w-4 h-4 bg-[#C25A2A] text-white rounded-full flex items-center justify-center text-[10px] font-bold">✓</div>
                    </div>
                    <div class="text-[11px] font-bold text-stone-800 line-clamp-1 group-hover:text-[#C25A2A]">${p.name}</div>
                    <div class="text-[10px] font-extrabold text-[#C25A2A]">£${p.price}</div>
                `;
                list.appendChild(card);
            });
        } else {
            if (status) status.textContent = '';
            list.innerHTML = `
                <div class="text-[11px] text-stone-400 py-2 italic">
                    No dish photos available for this restaurant. You can upload your own photo below.
                </div>
            `;
        }
    })
    .catch(err => {
        if (status) status.textContent = '';
        list.innerHTML = `
            <div class="text-[11px] text-stone-400 py-2 italic">
                Could not load menu dishes. You can upload a photo below.
            </div>
        `;
    });
}

function selectDish(productId, dishName, dishPrice, dishImage, dishImageUrl) {
    // Set hidden inputs
    document.getElementById('selectedProductId').value = productId;
    document.getElementById('selectedDishImage').value = dishImage;

    // Show preview
    const preview = document.getElementById('selectedDishPreview');
    if (preview) {
        document.getElementById('selectedDishImg').src = dishImageUrl;
        document.getElementById('selectedDishName').textContent = dishName;
        document.getElementById('selectedDishPrice').textContent = '£' + dishPrice;
        preview.classList.remove('hidden');
    }

    // Highlight card
    document.querySelectorAll('.dish-select-card').forEach(c => {
        c.classList.remove('border-[#C25A2A]', 'ring-2', 'ring-[#C25A2A]/40', 'bg-amber-50/50');
        const badge = c.querySelector('.dish-check-badge');
        if (badge) badge.classList.add('hidden');
    });

    const activeCard = document.getElementById('dish-card-' + productId);
    if (activeCard) {
        activeCard.classList.add('border-[#C25A2A]', 'ring-2', 'ring-[#C25A2A]/40', 'bg-amber-50/50');
        const badge = activeCard.querySelector('.dish-check-badge');
        if (badge) badge.classList.remove('hidden');
    }

    // Reset custom file input if a menu photo is selected
    const fileInput = document.getElementById('customPhotoInput');
    if (fileInput) fileInput.value = '';
    const fileBadge = document.getElementById('customPhotoBadge');
    if (fileBadge) fileBadge.classList.add('hidden');
}

function clearSelectedDish() {
    const prodInput = document.getElementById('selectedProductId');
    if (prodInput) prodInput.value = '';
    const imgInput = document.getElementById('selectedDishImage');
    if (imgInput) imgInput.value = '';

    const preview = document.getElementById('selectedDishPreview');
    if (preview) preview.classList.add('hidden');

    document.querySelectorAll('.dish-select-card').forEach(c => {
        c.classList.remove('border-[#C25A2A]', 'ring-2', 'ring-[#C25A2A]/40', 'bg-amber-50/50');
        const badge = c.querySelector('.dish-check-badge');
        if (badge) badge.classList.add('hidden');
    });
}

function onCustomPhotoChange(input) {
    const fileBadge = document.getElementById('customPhotoBadge');
    if (input.files && input.files[0]) {
        // If uploading custom photo, unselect menu dish photo so custom photo takes precedence
        clearSelectedDish();
        if (fileBadge) {
            fileBadge.textContent = '📷 ' + input.files[0].name;
            fileBadge.classList.remove('hidden');
        }
    } else {
        if (fileBadge) fileBadge.classList.add('hidden');
    }
}
</script>
@endsection
