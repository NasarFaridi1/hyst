{{--
    Partial: front/partials/restaurant-products-grid.blade.php
    Returns grouped menu sections with 2-column card grid per section.
    Used by both initial page render and AJAX fetchProducts().
--}}
@php
    $grouped = $products->groupBy('category_id');
@endphp

@forelse($grouped as $categoryId => $catProducts)
    @php
        $categoryName = optional($catProducts->first()->category)->name ?? 'Menu';
    @endphp
    <div class="menu-section" data-section="{{ $categoryId }}">
        <h2 class="menu-section-title">{{ $categoryName }}</h2>
        <div class="menu-cards-grid">
            @foreach($catProducts as $product)
                @include('front.partials.restaurant-menu-item', ['product' => $product, 'isAdmin' => $isAdmin])
            @endforeach
        </div>
    </div>
@empty
    <div style="text-align:center;padding:64px 24px;color:#999;font-size:15px;">
        No dishes match — try clearing your search.
    </div>
@endforelse