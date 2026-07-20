@forelse($products as $product)
    <div style="background:#fff; border-radius:20px; overflow:visible; box-shadow:0 2px 16px rgba(0,0,0,.07); border:1px solid #F0F0EC; transition:all .22s;"
        onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 16px 40px rgba(0,0,0,.12)'"
        onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 16px rgba(0,0,0,.07)'">

        <div style="position:relative; overflow:hidden;">
            <img
                src="{{ config('services.google_drive.image_url') . $product->image }}"
                style="width:100%; height:200px; object-fit:cover; display:block; transition:transform .5s;"
                onmouseover="this.style.transform='scale(1.06)'" onmouseout="this.style.transform='scale(1)'">

            <div style="position:absolute; top:12px; left:12px;">
                @if($product->product_type == 'veg')
                    <div class="product-type-badge veg" title="Vegetarian"><span></span></div>
                @elseif($product->product_type == 'non_veg')
                    <div class="product-type-badge non-veg" title="Non-Vegetarian"><span></span></div>
                @else
                @else
                    <div class="product-type-badge bev" title="Beverage"><span></span></div>
                @endif
            </div>

            <div style="position:absolute; top:12px; right:12px; background:rgba(255,255,255,0.95); border-radius:999px; padding:4px 12px;">
                <span style="font-size:14px; font-weight:800; color:#C25A2A;">£{{ $product->price }}</span>
            </div>
        </div>

        <div style="padding:16px;">
            <h3 style="font-weight:700; font-size:15px; margin:0 0 6px; line-height:1.3; color:#0D0D0D; font-family:'Poppins',sans-serif;">
                {{ $product->name }}
            </h3>

            <p style="color:#6B7280; font-size:13px; line-height:1.55; margin:0 0 14px;">
                {{ Str::limit(strip_tags($product->description), 80) }}
            </p>

            <div style="display:flex; gap:8px; justify-content:space-between; text-align:center; margin-top:2px; margin-bottom:8px;">
                <div class="info-tooltip">
                    <span class="details-link">Allergy & Dietary</span>
                    <div class="tooltip-content">
                        <h6>Allergy Information</h6>
                        @if($product->allergies->count())
                            <ul style="margin:0;padding-left:18px;list-style:disc;">
                                @foreach($product->allergies as $allergy)
                                    <li style="font-size:12px;line-height:1.5;">{{ $allergy->allergy }}</li>
                                @endforeach
                            </ul>
                        @else
                            <p style="font-size:12px;">May contain common allergens.</p>
                        @endif

                        <h6 style="margin-top:10px;">Dietary Information</h6>
                        @if($product->dietaries->count())
                            <ul style="margin:0;padding-left:18px;list-style:disc;">
                                @foreach($product->dietaries as $dietary)
                                    <li style="font-size:12px;line-height:1.5;">{{ $dietary->dietary }}</li>
                                @endforeach
                            </ul>
                        @else
                            <p style="font-size:12px;">
                                @if($product->product_type == 'veg') 🟢 Vegetarian
                                @elseif($product->product_type == 'non_veg') 🔴 Non Vegetarian
                                @else 🥤 Beverage
                                @endif
                            </p>
                        @endif
                    </div>
                </div>

                @php
                    $arImage = $product->image_3d
                        ? asset('storage/' . $product->image_3d)
                        : config('services.google_drive.image_url') . $product->image;
                @endphp
                <a href="javascript:void(0)" onclick="openAR('{{ $arImage }}')">
                    <div class="info-tooltip"><span class="details-link">3D View</span></div>
                </a>
            </div>

            <div style="display:flex; gap:8px; align-items:center;">
                <a href="{{ url('/product/' . $product->id) }}" class="btn-black" style="flex:1;">
                    Details
                </a>

                @if(!$isAdmin)
                    @auth
                        <form class="addCartForm"
                            style="flex:1;"
                            data-product="{{ $product->id }}"
                            data-variants='@json($product->variants)'
                            data-addons='@json($product->addons)'>
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="variant_id" class="variantId">
                            <input type="hidden" name="quantity" value="1" class="qtyInput">
                            <button class="btn-primary addBtn" type="submit">Add</button>
                        </form>
                    @else
                        @php session(['login_redirect' => request()->getRequestUri()]); @endphp
                        <a href="{{ route('login') }}" class="btn-primary"
                            style="flex:1; display:flex; justify-content:center; align-items:center; text-decoration:none;">
                            Add
                        </a>
                    @endauth
                @endif
            </div>
        </div>
    </div>
@empty
    <div style="grid-column:1/-1; text-align:center; padding:80px 20px; background:#fff; border-radius:20px; border:1px solid #F0F0EC;">
        <div style="width:80px; height:80px; background:#FFF0EC; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 20px;">
            <svg width="36" height="36" fill="none" stroke="#C25A2A" stroke-width="2" viewBox="0 0 24 24">
                <path d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z" />
                <path d="M12 22V12M3.27 6.96L12 12.01l8.73-5.05" />
            </svg>
        </div>
        <h3 style="font-size:20px; font-weight:700; margin-bottom:8px; color:#0D0D0D;">No Products Found</h3>
        <p style="color:#6B7280; font-size:14px; margin:0 0 20px;">This category has no products right now.</p>
    </div>
@endforelse