<style>
    .restaurant-grid{
        display:grid;
        grid-template-columns:repeat(4,minmax(0,1fr));
        gap:20px;
    }

    .restaurant-card{
        background:#fff;
        border-radius:16px;
        overflow:hidden;
        box-shadow:0 2px 10px rgba(13,13,13,0.05);
        transition:transform .2s, box-shadow .2s;
        border:1px solid #F0F0EC;
        cursor:pointer;
        display:flex;
        flex-direction:column;
    }

    .restaurant-card:hover{
        transform:translateY(-3px);
        box-shadow:0 12px 28px rgba(13,13,13,0.1);
    }

    .restaurant-image-wrap{
        position:relative;
        overflow:hidden;
        aspect-ratio:4/3;
    }

    .restaurant-image{
        width:100%;
        height:100%;
        /* object-fit:cover; */
        transition:transform .4s;
        display:block;
    }

    .restaurant-card:hover .restaurant-image{
        transform:scale(1.04);
    }

    .open-badge{
        position:absolute;
        top:10px;
        left:10px;
        background:rgba(13,13,13,0.82);
        color:#fff;
        padding:4px 10px;
        border-radius:20px;
        font-size:11px;
        font-weight:600;
        font-family:'Poppins',sans-serif;
        display:flex;
        align-items:center;
        gap:5px;
    }

    .open-badge::before{
        content:'';
        width:5px;
        height:5px;
        border-radius:50%;
        background:#22C55E;
        flex-shrink:0;
    }

    .offer-strip{
        position:absolute;
        bottom:0;
        left:0;
        right:0;
        background:linear-gradient(0deg, rgba(0,0,0,0.72) 0%, rgba(0,0,0,0) 100%);
        color:#fff;
        padding:22px 12px 8px;
        font-size:12px;
        font-weight:700;
        font-family:'Poppins',sans-serif;
        letter-spacing:.2px;
    }

    .restaurant-body{
        padding:14px 16px 16px;
        flex:1;
        display:flex;
        flex-direction:column;
    }

    .restaurant-row1{
        display:flex;
        justify-content:space-between;
        align-items:flex-start;
        gap:8px;
        margin-bottom:4px;
    }

    .restaurant-title{
        margin:0;
        font-size:16px;
        font-weight:700;
        color:#0D0D0D;
        font-family:'Poppins',sans-serif;
        line-height:1.3;
        overflow:hidden;
        text-overflow:ellipsis;
        white-space:nowrap;
    }

    .rating-pill{
        flex-shrink:0;
        display:flex;
        align-items:center;
        gap:3px;
        background:#0D7D3C;
        color:#fff;
        padding:3px 7px;
        border-radius:6px;
        font-size:12px;
        font-weight:700;
        font-family:'Poppins',sans-serif;
    }

    .rating-pill.no-rating{
        background:#9CA3AF;
    }

    .restaurant-meta-line{
        font-size:12.5px;
        color:#6B7280;
        font-family:'Poppins',sans-serif;
        margin:0 0 6px;
        overflow:hidden;
        text-overflow:ellipsis;
        white-space:nowrap;
    }

    .restaurant-meta-line .dot{
        margin:0 5px;
        color:#D1D5DB;
    }

    .restaurant-footer{
        display:flex;
        align-items:center;
        justify-content:space-between;
        margin-top:auto;
        padding-top:8px;
        border-top:1px dashed #EFEAE0;
    }

    .hygiene-tag{
        font-size:11px;
        font-weight:700;
        color:#065F46;
        display:flex;
        align-items:center;
        gap:4px;
    }

    .delivery-tag{
        font-size:11px;
        font-weight:700;
        color:#16A34A;
        display:flex;
        align-items:center;
        gap:4px;
    }

    /* Search bar */
    .restaurant-search-wrap{
        display:flex;
        align-items:center;
        gap:10px;
        max-width:560px;
        margin:0 auto 28px;
        background:#fff;
        border:1px solid #E9E4D8;
        border-radius:14px;
        padding:6px 6px 6px 18px;
        box-shadow:0 4px 16px rgba(13,13,13,0.05);
    }

    #restaurantSearch{
        flex:1;
        border:none;
        outline:none;
        padding:10px 0;
        font-size:14px;
        font-family:inherit;
        color:#0D0D0D;
        background:transparent;
    }

    .search-icon-btn{
        width:40px;
        height:40px;
        border-radius:10px;
        background:#C25A2A;
        display:flex;
        align-items:center;
        justify-content:center;
        flex-shrink:0;
    }

    /* Quick filter chips */
    .filter-chips{
        display:flex;
        gap:10px;
        flex-wrap:wrap;
        justify-content:center;
        margin-bottom:28px;
    }

    .filter-chip{
        display:flex;
        align-items:center;
        gap:6px;
        padding:9px 16px;
        border-radius:999px;
        background:#fff;
        border:1px solid #E9E4D8;
        color:#374151;
        font-size:13px;
        font-weight:600;
        font-family:'Poppins',sans-serif;
        cursor:pointer;
        transition:.2s;
        user-select:none;
    }

    .filter-chip:hover{
        border-color:#C25A2A;
    }

    .filter-chip.active-chip{
        background:#0D0D0D;
        border-color:#0D0D0D;
        color:#fff;
    }

    /* Category strip */
    .category-filter{
        min-width:80px;
        cursor:pointer;
        text-align:center;
        transition:.2s;
        flex-shrink:0;
    }

    .category-image{
        width:64px;
        height:64px;
        margin:auto;
        border-radius:50%;
        overflow:hidden;
        border:2px solid #EFE9DF;
        background:#fff;
        display:flex;
        align-items:center;
        justify-content:center;
        font-size:24px;
        transition:.2s;
    }

    .category-image img{
        width:100%;
        height:100%;
        object-fit:cover;
    }

    .category-filter span{
        display:block;
        margin-top:8px;
        font-weight:600;
        font-size:12.5px;
        color:#374151;
        font-family:'Poppins',sans-serif;
    }

    .active-category .category-image{
        border-color:#C25A2A;
        box-shadow:0 0 0 3px rgba(194,90,42,0.15);
    }

    .active-category span{
        color:#C25A2A;
    }

    .category-scroll{
        display:flex;
        gap:18px;
        overflow-x:auto;
        overflow-y:hidden;
        padding:6px 4px 10px;
        /* scrollbar-width:none;
        -ms-overflow-style:none; */
        /* Firefox */
        scrollbar-width: thin;
        scrollbar-color: #999 #f1f1f1;
    }

    /* Chrome, Edge, Safari */
    .category-scroll::-webkit-scrollbar{
        height: 5px;   /* Thin horizontal scrollbar */
    }

    .category-scroll::-webkit-scrollbar-track{
        background: #f1f1f1;
        border-radius: 10px;
    }

    .category-scroll::-webkit-scrollbar-thumb{
        background: #999;
        border-radius: 10px;
    }

    .category-scroll::-webkit-scrollbar-thumb:hover{
        background: #666;
    }

    /* .category-scroll::-webkit-scrollbar{
        display:none;
    } */

    /* Tablet */
    @media(max-width:992px){
        .restaurant-grid{
            grid-template-columns:repeat(2,minmax(0,1fr));
            gap:16px;
        }
    }

    /* Mobile */
    @media(max-width:768px){
        .restaurant-grid{
            grid-template-columns:1fr;
            gap:14px;
        }
        .page-title{ font-size:24px !important; }
        .filter-chips{ justify-content:flex-start; overflow-x:auto; flex-wrap:nowrap; padding-bottom:4px; }
    }

    @media(max-width:480px){
        .page-title{ font-size:21px !important; }
    }
</style>

<section id="restaurants" style="background:#FAF7F2; padding:20px 0;">

    <div style="max-width:1300px; margin:auto; padding:0 24px;">

        <div style="text-align:center; margin-bottom:15px;">
            <h1 class="page-title" style="font-size:24px; font-weight:600; margin:0 0 6px; color:#0D0D0D; font-family:'Poppins',sans-serif; letter-spacing:-.4px;">
                Explore Restaurants
            </h1>
            <p style="color:#6B7280; font-size:15px; margin:0;">
                Discover your favorite foods & restaurants — zero commission, always.
            </p>
        </div>

        <!-- SEARCH -->
        <div class="restaurant-search-wrap">
            <i data-lucide="search" style="width:18px; height:18px; color:#9CA3AF; flex-shrink:0;"></i>
            <input type="text" id="restaurantSearch" placeholder="Search restaurant...">
            <div class="search-icon-btn">
                <i data-lucide="search" style="width:16px; height:16px; color:#fff;"></i>
            </div>
        </div>

        <!-- CATEGORY STRIP -->
        <div style="margin-bottom:20px;">
            <div class="category-scroll">

                <div class="category-filter active-category" data-id="all">
                    <div class="category-image">🍽️</div>
                    <span>All</span>
                </div>

                @foreach($categories as $category)
                    <div class="category-filter" data-id="{{ $category->id }}">
                        <div class="category-image">
                            <img src="{{ asset($category->image) }}" alt="{{ $category->name }}">
                        </div>
                        <span>{{ $category->name }}</span>
                    </div>
                @endforeach

            </div>
        </div>

        <!-- QUICK FILTERS -->
        <div class="filter-chips">
            <div class="filter-chip active-chip" data-filter="all">
                <i data-lucide="layout-grid" style="width:14px; height:14px;"></i> All
            </div>
            <div class="filter-chip" data-filter="top-rated">
                <i data-lucide="star" style="width:14px; height:14px;"></i> Top Rated 4.5+
            </div>
            <div class="filter-chip" data-filter="offers">
                <i data-lucide="tag" style="width:14px; height:14px;"></i> Has Offers
            </div>
        </div>

        <!-- RESTAURANT GRID -->
        <div class="restaurant-grid">

            @forelse($restaurants as $restaurant)
                @php
                    $avgRating = $restaurant->reviews->avg('rating') ?? 0;
                    $reviewCount = $restaurant->reviews->count();
                @endphp
                <a href="{{ url('/restaurant/' . $restaurant->slug) }}"
                    class="restaurant-card"
                    style="text-decoration:none;"
                    data-name="{{ strtolower($restaurant->name) }}"
                    data-categories="{{ implode(',', $restaurant->category_ids ?? []) }}"
                    data-rating="{{ number_format($avgRating, 1) }}"
                    data-has-offer="{{ $restaurant->featuredOffer ? '1' : '0' }}">

                    <div class="restaurant-image-wrap">

                        <img
                            src="{{ $restaurant->image ? asset('storage/' . $restaurant->image) : 'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?q=80&w=1200&auto=format&fit=crop' }}"
                            class="restaurant-image">

                        <div class="open-badge">Open Now</div>

                        @if($restaurant->featuredOffer)
                            <div class="offer-strip">
                                @if($restaurant->featuredOffer->value_type == 'percent')
                                    {{ $restaurant->featuredOffer->value }}% OFF
                                @else
                                    £{{ $restaurant->featuredOffer->value }} OFF
                                @endif
                                — {{ Str::limit($restaurant->featuredOffer->title, 28) }}
                            </div>
                        @endif

                    </div>

                    <div class="restaurant-body">

                        <div class="restaurant-row1">
                            <h3 class="restaurant-title">{{ $restaurant->name }}</h3>
                            <div class="rating-pill {{ $avgRating == 0 ? 'no-rating' : '' }}">
                                ★ {{ $avgRating > 0 ? number_format($avgRating, 1) : 'New' }}
                            </div>
                        </div>

                        <p class="restaurant-meta-line">
                            {{ $restaurant->location }}
                            @if($reviewCount > 0)
                                <span class="dot">&bull;</span>{{ $reviewCount }} {{ Str::plural('review', $reviewCount) }}
                            @endif
                        </p>

                        <div class="restaurant-footer">
                            @if($restaurant->hygiene_rating)
                                <span class="hygiene-tag">
                                    <i data-lucide="shield-check" style="width:13px; height:13px;"></i>
                                    {{ number_format($restaurant->hygiene_rating,1) }}/5 hygiene
                                </span>
                            @else
                                <span></span>
                            @endif

                            <span class="delivery-tag">
                                <i data-lucide="bike" style="width:13px; height:13px;"></i> Fast & Ontime delivery
                            </span>
                        </div>

                    </div>

                </a>

            @empty

                <div style="grid-column:1/-1; text-align:center; background:#fff; padding:80px 20px; border-radius:24px; box-shadow:0 5px 20px rgba(0,0,0,0.06);">

                    <div style="width:88px; height:88px; background:#FFF2EE; border-radius:22px; margin:0 auto 24px; display:flex; align-items:center; justify-content:center;">
                        <i data-lucide="search-x" style="width:40px; height:40px; color:#C25A2A;"></i>
                    </div>

                    <h2 style="font-size:28px; margin-bottom:10px; color:#0D0D0D; font-family:'Poppins',sans-serif; font-weight:800;">
                        No Restaurants Found
                    </h2>

                    <p style="color:#6B7280; font-size:15px; margin:0;">
                        Restaurants will appear here soon.
                    </p>

                </div>

            @endforelse

        </div>

        <div id="noFilterResults" style="display:none; grid-column:1/-1; text-align:center; background:#fff; padding:60px 20px; border-radius:24px; box-shadow:0 5px 20px rgba(0,0,0,0.06); margin-top:28px;">
            <h3 style="font-size:20px; margin-bottom:8px; color:#0D0D0D; font-family:'Poppins',sans-serif; font-weight:700;">No matches for that filter</h3>
            <p style="color:#6B7280; font-size:14px; margin:0;">Try a different category or clear your search.</p>
        </div>

    </div>

    <script>
        (function(){

            const searchInput = document.getElementById('restaurantSearch');
            const categoryFilters = document.querySelectorAll('.category-filter');
            const quickChips = document.querySelectorAll('.filter-chip');
            const cards = document.querySelectorAll('.restaurant-card');
            const noResults = document.getElementById('noFilterResults');

            let state = { search: '', categoryId: 'all', chip: 'all' };

            function applyFilters(){
                let visibleCount = 0;

                cards.forEach(card => {
                    const name = card.dataset.name || '';
                    const categories = (card.dataset.categories || '').split(',');
                    const rating = parseFloat(card.dataset.rating || '0');
                    const hasOffer = card.dataset.hasOffer === '1';

                    let visible = true;

                    if(state.search && !name.includes(state.search)) visible = false;
                    if(state.categoryId !== 'all' && !categories.includes(state.categoryId)) visible = false;
                    if(state.chip === 'top-rated' && rating < 4.5) visible = false;
                    if(state.chip === 'offers' && !hasOffer) visible = false;

                    card.style.display = visible ? '' : 'none';
                    if(visible) visibleCount++;
                });

                if(noResults){
                    noResults.style.display = visibleCount === 0 ? 'block' : 'none';
                }
            }

            if(searchInput){
                searchInput.addEventListener('keyup', function(){
                    state.search = this.value.toLowerCase();
                    applyFilters();
                });
            }

            categoryFilters.forEach(filter => {
                filter.addEventListener('click', function(){
                    categoryFilters.forEach(x => x.classList.remove('active-category'));
                    this.classList.add('active-category');
                    state.categoryId = this.dataset.id;
                    applyFilters();
                });
            });

            quickChips.forEach(chip => {
                chip.addEventListener('click', function(){
                    quickChips.forEach(x => x.classList.remove('active-chip'));
                    this.classList.add('active-chip');
                    state.chip = this.dataset.filter;
                    applyFilters();
                });
            });

        })();
    </script>

</section>