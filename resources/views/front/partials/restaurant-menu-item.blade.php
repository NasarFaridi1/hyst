{{--
    Partial: front/partials/restaurant-menu-item.blade.php
    Full variant + addon support, matching old form data attributes
--}}
@php
    $type     = $product->product_type ?? $product->type ?? 'veg';
    $isVeg    = $type === 'veg';
    $isBev    = $type === 'beverage';
    $dotClass = $isVeg ? 'veg' : ($isBev ? 'bev' : 'nonveg');

    $hasImage = !empty($product->image);
    $imgUrl   = $hasImage ? config('services.google_drive.image_url') . $product->image : null;

    $arImg = !empty($product->image_3d)
        ? asset('storage/' . $product->image_3d)
        : ($hasImage ? $imgUrl : null);

    $spicyLevel = $product->spicy_level ?? 0;

    // Build variants array exactly as old view: data-variants='@json($product->variants)'
    $variants = $product->variants ?? collect();
    $addons   = $product->addons   ?? collect();

    $hasCustom = $variants->count() || $addons->count();

    // Price: first variant price if exists, else product price
    $price = $variants->count() ? $variants->first()->price : ($product->price ?? 0);

    $avgRating = $product->reviews_avg_rating ?? null;

    $jsName  = addslashes(preg_replace('/\s+/', ' ', strip_tags($product->name)));
    $jsDesc  = addslashes(preg_replace('/\s+/', ' ', strip_tags($product->description ?? '')));
    $jsImg   = addslashes($imgUrl ?? '');
    $jsArImg = addslashes($arImg ?? '');

    $allergies = isset($product->allergies) ? $product->allergies->pluck('allergy')->values()->toArray() : [];
    $dietaries = isset($product->dietaries) ? $product->dietaries->pluck('dietary')->values()->toArray() : [];
@endphp

<div class="menu-card"
     onclick="openItemModalFromElement(this)"
     data-product-id="{{ $product->id }}"
     data-name="{{ $product->name }}"
     data-price="{{ (float) $price }}"
     data-desc="{{ strip_tags($product->description ?? '') }}"
     data-img="{{ $imgUrl }}"
     data-is-veg="{{ $isVeg ? 'true' : 'false' }}"
     data-has-custom="{{ $hasCustom ? 'true' : 'false' }}"
     data-rating="{{ $avgRating ? number_format($avgRating,1) : '' }}"
     data-ar-img="{{ $arImg }}"
     data-allergies='@json($allergies)'
     data-dietaries='@json($dietaries)'
     data-veg="{{ $isVeg ? '1' : '0' }}">

    {{-- LEFT: image --}}
    @if($hasImage)
        <div class="menu-card-img">
            <img src="{{ $imgUrl }}"
                 alt="{{ $product->name }}"
                 loading="lazy"
                 onerror="this.parentElement.style.display='none'">
        </div>
    @endif

    {{-- RIGHT: body --}}
    <div class="menu-card-body">

        <div class="menu-card-name-row">
            <span class="veg-dot-wrap {{ $dotClass }}"><span></span></span>
            <span class="menu-card-name">{{ $product->name }}</span>
            @if($product->is_popular ?? false)
                <span class="popular-badge">Popular</span>
            @endif
        </div>

        @if($product->description)
            <div class="menu-card-desc">{{ strip_tags($product->description) }}</div>
        @endif

         {{-- Allergy & Dietary tooltip --}}
        @php
            $allergiesCount = ($product->allergies ?? collect())->count();
            $dietariesCount = ($product->dietaries ?? collect())->count();
        @endphp

        
        <div style="display:flex; gap:10px; align-items:center; flex-wrap:wrap; margin-top:4px; min-width:0;">
            @if($allergiesCount || $dietariesCount)
                <div class="info-tooltip" onclick="event.stopPropagation()">
                    <span class="details-link"><i data-lucide="info" style="width:14px;height:14px;vertical-align:middle;"></i></span>
                    <div class="tooltip-content">
                        <h6>Allergy Information</h6>
                        @if($allergiesCount)
                            <ul style="margin:0 0 6px;padding-left:16px;list-style:disc;">
                                @foreach($product->allergies as $a)<li>{{ $a->allergy }}</li>@endforeach
                            </ul>
                        @else
                            <p>May contain common allergens.</p>
                        @endif
                        <h6 style="margin-top:8px;">Dietary</h6>
                        @if($dietariesCount)
                            <ul style="margin:0;padding-left:16px;list-style:disc;">
                                @foreach($product->dietaries as $d)<li>{{ $d->dietary }}</li>@endforeach
                            </ul>
                        @else
                            <p>{{ $isVeg ? '🟢 Vegetarian' : ($isBev ? '🥤 Beverage' : '🔴 Non-Vegetarian') }}</p>
                        @endif
                    </div>
                </div>
            @endif

            @if($arImg)
                <a href="javascript:void(0)" onclick="event.stopPropagation();openAR('{{ $jsArImg }}')"
                   style="font-size:11px;color:#757575;font-weight:600;border-bottom:1px dotted #bbb;line-height:1;white-space:nowrap;">🔭 3D View</a>
            @endif
        </div>

        {{-- @if($spicyLevel || ($product->is_gluten_free ?? false))
            <div class="menu-item-tags">
                @if($spicyLevel == 1)<span class="item-tag mild-tag">Mild spice</span>@endif
                @if($spicyLevel == 2)<span class="item-tag spicy-tag">Spicy</span>@endif
                @if($product->is_gluten_free ?? false)
                    <span class="item-tag" style="background:#F0F4FF;color:#3B5BDB;">Gluten free</span>
                @endif
            </div>
        @endif --}}

        {{-- Price + Add button --}}
        <div class="menu-card-footer">
            <div class="menu-card-price">
                £{{ number_format($price, 2) }}
                @if($variants->count())
                    <span style="font-size:12px;color:#999;font-weight:500;"> onwards</span>
                @endif
            </div>

            @if(!($isAdmin ?? false))
                {{-- @auth --}}
                    {{--
                        IMPORTANT: data-product, data-variants, data-addons
                        match exactly what the old JS expects.
                        Also added data-product-id for the new modal's modalAddToCart().
                    --}}
                    <form class="addCartForm"
                          data-no-loader="true"
                          data-product="{{ $product->id }}"
                          data-product-id="{{ $product->id }}"
                          data-variants='@json($variants)'
                          data-addons='@json($addons)'
                          style="display:contents;">
                        @csrf
                        <input type="hidden" name="product_id"  value="{{ $product->id }}">
                        <input type="hidden" name="quantity"     value="1" class="qtyInput">
                        <input type="hidden" name="variant_id"   value="" class="variantId">

                        <button type="submit"
                                class="menu-card-add-btn"
                                onclick="event.stopPropagation()"
                                title="Add to order">+</button>
                    </form>
                {{-- @else
                    <a href="{{ route('login') }}"
                       onclick="event.stopPropagation()"
                       class="menu-card-add-btn"
                       style="text-decoration:none;display:flex;align-items:center;justify-content:center;"
                       title="Login to order">+</a>
                @endauth --}}
            @endif
        </div>

    </div>
</div>