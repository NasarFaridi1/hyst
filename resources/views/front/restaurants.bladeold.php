{{-- @extends('front.layouts.app')

@section('content')


    <section style="background:#F8F9FA; padding:20px 0; min-height:100vh;">

        <div style="max-width:1300px; margin:auto; padding:0 20px;">

            <div style="text-align:center; margin-bottom:50px;">

                <h1 style="
                                            font-size:30px;
                                            font-weight:800;
                                            margin-bottom:10px;
                                            color:#111827;
                                            font-family:'Syne',sans-serif;
                                        ">
                    Explore Restaurants
                </h1>

                <p style="
                                            color:#6B7280;
                                            font-size:17px;
                                        ">
                    Discover your favorite foods & restaurants
                </p>

            </div>





            <div style="
                                        display:grid;
                                        grid-template-columns:repeat(3,minmax(0,1fr));
                                        gap:30px;
                                    ">

                @forelse($restaurants as $restaurant)

                    <div style="
                                                                            background:#fff;
                                                                            border-radius:24px;
                                                                            overflow:hidden;
                                                                            box-shadow:0 10px 30px rgba(0,0,0,0.08);
                                                                            transition:0.3s;
                                                                            border:1px solid #F1F1F1;
                                                                        " onmouseover="this.style.transform='translateY(-8px)'"
                        onmouseout="this.style.transform='translateY(0)'">

                        <div style="
                                                                                position:relative;
                                                                                overflow:hidden;
                                                                            ">

                            <img src="{{ $restaurant->image ? asset('storage/' . $restaurant->image) : 'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?q=80&w=1200&auto=format&fit=crop' }}"
                                style="
                                                                                        width:100%;
                                                                                        height:230px;
                                                                                        object-fit:cover;
                                                                                    ">

                            <div style="
                                                                                    position:absolute;
                                                                                    top:15px;
                                                                                    left:15px;
                                                                                    background:#E63946;
                                                                                    color:#fff;
                                                                                    padding:6px 14px;
                                                                                    border-radius:30px;
                                                                                    font-size:13px;
                                                                                    font-weight:600;
                                                                                ">
                                Open Now
                            </div>
                            @if($restaurant->featuredOffer)

                                                <div style="
                                    position:absolute;
                                    bottom:15px;
                                    left:15px;
                                    background:#111827;
                                    color:#fff;
                                    padding:8px 16px;
                                    border-radius:30px;
                                    font-size:13px;
                                    font-weight:700;
                                ">

                                                    @if($restaurant->featuredOffer->value_type == 'percent')

                                                        {{ $restaurant->featuredOffer->value }}% OFF

                                                    @else

                                                        £{{ $restaurant->featuredOffer->value }} OFF

                                                    @endif

                                                </div>

                            @endif

                        </div>

                        <div style="padding:24px;">

                            <div style="
                                                                                    display:flex;
                                                                                    justify-content:space-between;
                                                                                    align-items:center;
                                                                                    margin-bottom:12px;
                                                                                ">

                                <h3 style="
                                                                                        margin:0;
                                                                                        font-size:24px;
                                                                                        font-weight:800;
                                                                                        color:#111827;
                                                                                        font-family:'Syne',sans-serif;
                                                                                    ">
                                    {{ $restaurant->name }}
                                </h3>

                                <div style="
                                                                                        background:#FFF3E6;
                                                                                        color:#FF9500;
                                                                                        padding:5px 10px;
                                                                                        border-radius:20px;
                                                                                        font-size:13px;
                                                                                        font-weight:700;
                                                                                    ">
                                   ★ {{ number_format($restaurant->reviews->avg('rating') ?? 0, 1) }}
                                     <div style="
        font-size:10px;
        color:#6B7280;
        margin-top:2px;
    ">
        {{ $restaurant->reviews->count() }} Reviews
    </div>
                                </div>

                            </div>

                            <p style="
                                                                                    color:#6B7280;
                                                                                    margin-bottom:20px;
                                                                                    line-height:1.7;
                                                                                    font-size:14px;
                                                                                ">
                                {{ $restaurant->description ?? 'Delicious food & fast delivery available.' }}
                            </p>
@if($restaurant->featuredOffer)

    <div style="
        background:#FFF7ED;
        border:1px solid #FED7AA;
        color:#C2410C;
        padding:10px 14px;
        border-radius:12px;
        margin-bottom:18px;
        font-size:14px;
        font-weight:700;
    ">

        🎉 {{ $restaurant->featuredOffer->title }}

    </div>

@endif
                            <div style="
                                                                                    display:flex;
                                                                                    justify-content:space-between;
                                                                                    align-items:center;
                                                                                    margin-bottom:22px;
                                                                                ">

                                <div style="
                                                                                        display:flex;
                                                                                        align-items:center;
                                                                                        gap:6px;
                                                                                        color:#6B7280;
                                                                                        font-size:14px;
                                                                                    ">
                                    📍 {{ $restaurant->location }}
                                </div>

                                <div style="
                                                                                        color:#10B981;
                                                                                        font-weight:700;
                                                                                        font-size:14px;
                                                                                    ">
                                    Free Delivery
                                </div>

                            </div>

                            <a href="{{ url('/restaurant/' . $restaurant->slug) }}" style="
                                                                                        display:block;
                                                                                        width:100%;
                                                                                        background:#111827;
                                                                                        color:#fff;
                                                                                        text-align:center;
                                                                                        padding:14px;
                                                                                        border-radius:14px;
                                                                                        text-decoration:none;
                                                                                        font-weight:700;
                                                                                        transition:0.3s;
                                                                                    "
                                onmouseover="this.style.background='#E63946'" onmouseout="this.style.background='#111827'">

                                View Menu

                            </a>

                        </div>

                    </div>

                @empty

                    <div style="
                                                                            grid-column:1/-1;
                                                                            text-align:center;
                                                                            background:#fff;
                                                                            padding:80px 20px;
                                                                            border-radius:24px;
                                                                            box-shadow:0 5px 20px rgba(0,0,0,0.06);
                                                                        ">

                        <img src="https://cdn-icons-png.flaticon.com/512/1046/1046784.png" style="
                                                                                    width:120px;
                                                                                    margin-bottom:25px;
                                                                                    opacity:0.8;
                                                                                ">

                        <h2 style="
                                                                                font-size:34px;
                                                                                margin-bottom:10px;
                                                                                color:#111827;
                                                                                font-family:'Syne',sans-serif;
                                                                            ">
                            No Restaurants Found
                        </h2>

                        <p style="
                                                                                color:#6B7280;
                                                                                font-size:16px;
                                                                            ">
                            Restaurants will appear here soon.
                        </p>

                    </div>

                @endforelse

            </div>

        </div>

    </section>



@endsection --}}



{{-- @extends('front.layouts.app')

@section('content') --}}

<style>
    .restaurant-grid{
        display:grid;
        grid-template-columns:repeat(3,minmax(0,1fr));
        gap:30px;
    }

    .restaurant-card{
        background:#fff;
        border-radius:24px;
        overflow:hidden;
        box-shadow:0 10px 30px rgba(0,0,0,0.08);
        transition:0.3s;
        border:1px solid #F1F1F1;
    }

    .restaurant-card:hover{
        transform:translateY(-8px);
    }

    .restaurant-image{
        width:100%;
        height:230px;
        object-fit:fill;
    }

    /* Tablet */
    @media(max-width:992px){
        .restaurant-grid{
            grid-template-columns:repeat(2,minmax(0,1fr));
            gap:20px;
        }
    }

    /* Mobile */
    @media(max-width:768px){

        .restaurant-grid{
            grid-template-columns:1fr;
            gap:18px;
        }

        .restaurant-image{
            height:210px;
        }

        .page-title{
            font-size:24px !important;
        }

        .restaurant-title{
            font-size:20px !important;
        }

        .restaurant-card-content{
            padding:18px !important;
        }

        .restaurant-desc{
            font-size:13px !important;
        }

        .restaurant-meta{
            flex-direction:column;
            align-items:flex-start !important;
            gap:10px;
        }

        .restaurant-header{
            align-items:flex-start !important;
            gap:12px;
        }
    }

    /* Small Mobile */
    @media(max-width:480px){

        .page-title{
            font-size:22px !important;
        }

        .restaurant-image{
            height:190px;
        }

        .view-btn{
            padding:12px !important;
            font-size:14px;
        }
    }

    .category-filter{

        min-width:100px;

        cursor:pointer;

        text-align:center;

        transition:.3s;

    }

    .category-image{

        width:80px;
        height:80px;

        margin:auto;

        border-radius:50%;

        overflow:hidden;

        border:3px solid #eee;

    }

    .category-image img{

        width:100%;
        height:100%;
        object-fit:cover;

    }

    .category-filter span{

        display:block;

        margin-top:10px;

        font-weight:700;

        font-size:14px;

    }

    .active-category .category-image{

        border-color:#E63946;

    }

    .active-category span{

        color:#E63946;

    }

    .category-scroll{
        display:flex;
        gap:18px;
        overflow-x:auto;
        overflow-y:hidden;
        padding-bottom:8px;

        /* Firefox */
        scrollbar-width:none;

        /* IE */
        -ms-overflow-style:none;
    }

    .category-scroll::-webkit-scrollbar{
        display:none;
    }

    .category-scroll-hint{
        text-align:end;
        margin-top:10px;
        color:#6B7280;
        font-size:13px;
        font-weight:600;
        animation:scrollHint 1.8s infinite;
        user-select:none;
    }

    @keyframes scrollHint{

        0%{
            transform:translateX(0);
            opacity:.5;
        }

        50%{
            transform:translateX(8px);
            opacity:1;
        }

        100%{
            transform:translateX(0);
            opacity:.5;
        }

    }

    @media(min-width:768px){

        .category-scroll-hint{
            font-size:14px;
        }

    }
</style>

<section style="background:rgba(245, 240, 232, 0.95); padding:20px 0; min-height:100vh;">

    <div style="max-width:1300px; margin:auto; padding:0 20px;">

        <div style="text-align:center; margin-bottom:50px;">

            <h1 class="page-title"
                style="
                    font-size:30px;
                    font-weight:800;
                    margin-bottom:10px;
                    color:#111827;
                    font-family:'Syne',sans-serif;
                ">
                Explore Restaurants
            </h1>

            <p style="color:#6B7280; font-size:17px;">
                Discover your favorite foods & restaurants
            </p>

        </div>

       
            <div style="
                max-width:600px;
                margin:auto;
                display:flex;
                gap:10px;
            ">
                <input
                    type="text"
                    id="restaurantSearch"
                    placeholder="Search restaurant..."
                    style="
                        width:100%;
                        max-width:600px;
                        margin:0 auto 30px;
                        display:block;
                        padding:14px 18px;
                        border:1px solid #ddd;
                        border-radius:12px;
                    "
                >

            </div>

        
        <div style="margin-bottom:30px;">

            <div class="category-scroll">

                <div
                    class="category-filter active-category"
                    data-id="all">

                    <div class="category-image">
                        🍽️
                    </div>

                    <span>All</span>

                </div>

                @foreach($categories as $category)

                    <div
                        class="category-filter"
                        data-id="{{ $category->id }}">

                        <div class="category-image">

                            <img
                                src="{{ asset($category->image) }}"
                                alt="{{ $category->name }}">

                        </div>

                        <span>
                            {{ $category->name }}
                        </span>

                    </div>

                @endforeach

            </div>
            <div class="category-scroll-hint">
                <span>← Scroll for more categories →</span>
            </div>

        </div>    
        

        <div class="restaurant-grid">

            @forelse($restaurants as $restaurant)

                <div class="restaurant-card"
                    data-name="{{ strtolower($restaurant->name) }}"
                    data-categories="{{ implode(',', $restaurant->category_ids ?? []) }}"
                    >

                    <div style="position:relative; overflow:hidden;">

                        <img
                            src="{{ $restaurant->image ? asset('storage/' . $restaurant->image) : 'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?q=80&w=1200&auto=format&fit=crop' }}"
                            class="restaurant-image">

                        <div style="
                            position:absolute;
                            top:15px;
                            left:15px;
                            background:#E63946;
                            color:#fff;
                            padding:6px 14px;
                            border-radius:30px;
                            font-size:13px;
                            font-weight:600;
                        ">
                            Open Now
                        </div>

                        @if($restaurant->featuredOffer)

                            <div style="
                                position:absolute;
                                bottom:15px;
                                left:15px;
                                background:#111827;
                                color:#fff;
                                padding:8px 16px;
                                border-radius:30px;
                                font-size:13px;
                                font-weight:700;
                            ">

                                @if($restaurant->featuredOffer->value_type == 'percent')

                                    {{ $restaurant->featuredOffer->value }}% OFF

                                @else

                                    £{{ $restaurant->featuredOffer->value }} OFF

                                @endif

                            </div>

                        @endif

                    </div>

                    <div class="restaurant-card-content" style="padding:24px;">

                        <div class="restaurant-header"
                            style="
                                display:flex;
                                justify-content:space-between;
                                align-items:center;
                                margin-bottom:12px;
                            ">

                            <h3 class="restaurant-title"
                                style="
                                    margin:0;
                                    font-size:24px;
                                    font-weight:800;
                                    color:#111827;
                                    font-family:'Syne',sans-serif;
                                ">
                                {{ $restaurant->name }}
                            </h3>

                            {{-- <div style="
                                background:#FFF3E6;
                                color:#FF9500;
                                padding:5px 10px;
                                border-radius:20px;
                                font-size:13px;
                                font-weight:700;
                                text-align:center;
                                min-width:70px;
                            ">

                                ★ {{ number_format($restaurant->reviews->avg('rating') ?? 0, 1) }}

                                <div style="
                                    font-size:10px;
                                    color:#6B7280;
                                    margin-top:2px;
                                ">
                                    {{ $restaurant->reviews->count() }} Reviews
                                </div>

                            </div> --}}
                            <div style="
                                display:flex;
                                flex-direction:column;
                                gap:6px;
                                align-items:flex-end;
                            ">

                                {{-- Customer Rating --}}
                                <div style="
                                    background:#FFF3E6;
                                    color:#FF9500;
                                    padding:6px 12px;
                                    border-radius:20px;
                                    font-size:13px;
                                    font-weight:700;
                                    text-align:center;
                                ">
                                    ★ {{ number_format($restaurant->reviews->avg('rating') ?? 0, 1) }}

                                    <div style="
                                        font-size:10px;
                                        color:#6B7280;
                                        margin-top:2px;
                                    ">
                                        {{ $restaurant->reviews->count() }} Reviews
                                    </div>
                                </div>

                                {{-- Hygiene Rating --}}
                                @if($restaurant->hygiene_rating)
                                    <div style="
                                        background:#ECFDF5;
                                        color:#065F46;
                                        padding:6px 12px;
                                        border-radius:20px;
                                        font-size:12px;
                                        font-weight:700;
                                        border:1px solid #BBF7D0;
                                    ">
                                        🛡 Hygiene {{ number_format($restaurant->hygiene_rating,1) }}/5
                                    </div>
                                @endif

                            </div>

                        </div>

                        <p class="restaurant-desc"
                            style="
                                color:#6B7280;
                                margin-bottom:20px;
                                line-height:1.7;
                                font-size:14px;
                            ">
                            {{ $restaurant->description ?? 'Delicious food & fast delivery available.' }}
                        </p>

                        @if($restaurant->featuredOffer)

                            <div style="
                                background:#FFF7ED;
                                border:1px solid #FED7AA;
                                color:#C2410C;
                                padding:10px 14px;
                                border-radius:12px;
                                margin-bottom:18px;
                                font-size:14px;
                                font-weight:700;
                            ">

                                🎉 {{ $restaurant->featuredOffer->title }}

                            </div>

                        @endif

                        <div class="restaurant-meta"
                            style="
                                display:flex;
                                justify-content:space-between;
                                align-items:center;
                                margin-bottom:22px;
                            ">

                            <div style="
                                display:flex;
                                align-items:center;
                                gap:6px;
                                color:#6B7280;
                                font-size:14px;
                            ">
                                📍 {{ $restaurant->location }}
                            </div>

                            {{-- <div style="
                                color:#10B981;
                                font-weight:700;
                                font-size:14px;
                            ">
                                Free Delivery
                            </div> --}}

                        </div>

                        <a href="{{ url('/restaurant/' . $restaurant->slug) }}"
                            class="view-btn"
                            style="
                                display:block;
                                width:100%;
                                background:#111827;
                                color:#fff;
                                text-align:center;
                                padding:14px;
                                border-radius:14px;
                                text-decoration:none;
                                font-weight:700;
                                transition:0.3s;
                            "
                            onmouseover="this.style.background='#E63946'"
                            onmouseout="this.style.background='#111827'">

                            View Menu

                        </a>

                    </div>

                </div>

            @empty

                <div style="
                    grid-column:1/-1;
                    text-align:center;
                    background:#fff;
                    padding:80px 20px;
                    border-radius:24px;
                    box-shadow:0 5px 20px rgba(0,0,0,0.06);
                ">

                    <img src="https://cdn-icons-png.flaticon.com/512/1046/1046784.png"
                        style="
                            width:120px;
                            margin-bottom:25px;
                            opacity:0.8;
                        ">

                    <h2 style="
                        font-size:34px;
                        margin-bottom:10px;
                        color:#111827;
                        font-family:'Syne',sans-serif;
                    ">
                        No Restaurants Found
                    </h2>

                    <p style="color:#6B7280; font-size:16px;">
                        Restaurants will appear here soon.
                    </p>

                </div>

            @endforelse

        </div>

    </div>

    <script>
    document.getElementById('restaurantSearch').addEventListener('keyup', function() {

        let value = this.value.toLowerCase();

        document.querySelectorAll('.restaurant-card').forEach(card => {

            let name = card.dataset.name;

            if(name.includes(value)){
                card.style.display = '';
            }else{
                card.style.display = 'none';
            }

        });

    });

    const filters=document.querySelectorAll('.category-filter');

    filters.forEach(filter=>{

        filter.addEventListener('click',function(){

            filters.forEach(x=>x.classList.remove('active-category'));

            this.classList.add('active-category');

            let id=this.dataset.id;

            document.querySelectorAll('.restaurant-card').forEach(card=>{

                if(id==="all"){

                    card.style.display="";

                    return;

                }

                let categories=card.dataset.categories.split(',');

                if(categories.includes(id)){

                    card.style.display="";

                }else{

                    card.style.display="none";

                }

            });

        });

    });
    </script>

</section>

{{-- @endsection --}}