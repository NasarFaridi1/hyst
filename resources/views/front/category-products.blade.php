@extends('front.layouts.app')

@section('content')


    <section id="products" style="background:#fff; padding:80px 0;">
        <div style="max-width:1280px; margin:0 auto; padding:0 24px;">
            <div
                style="display:flex; justify-content:space-between; align-items:flex-end; margin-bottom:36px; flex-wrap:wrap; gap:12px;">
                <div>
                    <p
                        style="color:#C25A2A; font-family:'Poppins',sans-serif; font-weight:700; font-size:12px; letter-spacing:.1em; text-transform:uppercase; margin:0 0 6px;">
                        Today's Pick</p>
                    <h2 class="section-title"
                        style="font-family:'Poppins',sans-serif; font-size:36px; font-weight:800; margin:0; letter-spacing:-.4px;">
                        {{ $category->name }}</h2>
                </div>
                <p style="color:#6B7280; font-size:14px; margin:0;">Most popular dishes today</p>
            </div>

            <div class="products-grid" style="display:grid; grid-template-columns:repeat(4,1fr); gap:22px;">
                @foreach($products as $product)
                        <div style="background:#fff; border-radius:20px; overflow:hidden; box-shadow:0 2px 16px rgba(0,0,0,.07); border:1px solid #F0F0EC; transition:all .22s;"
                            onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 16px 40px rgba(0,0,0,.12)'"
                            onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 16px rgba(0,0,0,.07)'">

                            <div style="position:relative; overflow:hidden;">
                                <img
                                {{-- src="{{ $product->image
                                ? asset('storage/' . $product->image)
                                : asset('default.png') }}" --}}
                                src="{{ $product->image ? config('services.google_drive.image_url') . $product->image :asset('default.png') }}"

                                    style="width:100%; height:210px; object-fit:cover; transition:transform .5s; display:block;"
                                    onmouseover="this.style.transform='scale(1.06)'" onmouseout="this.style.transform='scale(1)'">
                                <div style="position:absolute; top:12px; left:12px;" class="badge-primary">
                                    <span style="display:flex; align-items:center; gap:4px; font-size:11px;">
                                        <i data-lucide="star" style="width:11px; height:11px; fill:#fff;"></i> Featured
                                    </span>
                                </div>
                            </div>

                            <div style="padding:18px;">
                                <div
                                    style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:8px; gap:8px;">
                                    <h3
                                        style="font-family:'Poppins',sans-serif; font-weight:700; font-size:16px; margin:0; line-height:1.35; color:#0D0D0D;">
                                        {{ $product->name }}
                                    </h3>
                                    <span
                                        style="font-family:'Poppins',sans-serif; font-size:18px; font-weight:800; color:#C25A2A; white-space:nowrap;">
                                        £{{ $product->price }}
                                    </span>
                                </div>
                                <p style="color:#6B7280; font-size:13px; line-height:1.6; margin:0 0 16px;">
                                    <!-- {{ Str::limit($product->description, 80) }} -->
                                      {{ Str::limit(strip_tags($product->description), 80) }}

                                </p>
                                <div style="display:flex; gap:8px;">
                                    <a href="/product/{{ $product->id }}" class="btn-black"
                                        style="flex:1; text-align:center; padding:10px 0; font-size:13px; text-decoration:none;">View</a>
                                    <form method="POST" action="/cart/add" style="flex:1;">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="current_url" value="{{ url()->current() }}">
                                        <button class="btn-primary"
                                            style="width:100%; padding:10px 0; font-size:13px; border:none; cursor:pointer; display:flex; align-items:center; justify-content:center; gap:6px;">
                                            <i data-lucide="shopping-cart" style="width:14px; height:14px;"></i> Add
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                @endforeach
            </div>
        </div>
    </section>



@endsection