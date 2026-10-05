@extends('layouts.app')

@section('content')

<style>
    /* POS Custom Scrollbar & Touch Optimization */
    .no-scrollbar::-webkit-scrollbar {
        display: none;
    }
    .no-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }

    /* Smooth Drawer Animations */
    .drawer-backdrop {
        transition: opacity 0.3s ease-in-out;
    }
    .drawer-panel {
        transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }
    
    /* Touch Feedback & Pulse Effect */
    @keyframes cartPulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.1); }
        100% { transform: scale(1); }
    }
    .cart-bump {
        animation: cartPulse 0.3s ease-in-out;
    }
</style>

<div class="max-w-7xl mx-auto px-3 sm:px-6 py-4 sm:py-6">

    <form id="directOrderForm" method="POST" action="{{ route('restaurant.orders.store_offline') }}">
        @csrf

        {{-- Page Header --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
            <div>
                <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-[#C25A2A] mb-1">
                    <span class="w-4 h-0.5 bg-[#C25A2A] inline-block rounded"></span>
                    RESTAURANT DIRECT ORDERING • POS TERMINAL
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">
                    Create Direct Menu Order
                </h1>
                <p class="text-xs sm:text-sm text-gray-500 mt-0.5">
                    Place orders directly for walk-in, phone, table, or offline customers.
                </p>
            </div>

            <div class="flex items-center gap-3 w-full sm:w-auto justify-between sm:justify-end">
                <a href="/restaurant/orders"
                   class="bg-black hover:bg-gray-800 text-white font-semibold px-4 py-2.5 rounded-xl transition duration-150 inline-flex items-center gap-2 text-xs sm:text-sm shadow">
                    ← Back to Orders
                </a>
                
                {{-- Quick Cart View Button in Header --}}
                <button type="button" 
                        onclick="openCartDrawer()"
                        class="bg-[#C25A2A] hover:bg-[#A3451E] text-white font-bold px-4 py-2.5 rounded-xl transition duration-150 flex items-center gap-2 text-xs sm:text-sm shadow">
                    🛒 Order Cart
                    <span id="headerCartBadge" class="bg-white text-[#C25A2A] text-xs font-extrabold px-2 py-0.5 rounded-full">0</span>
                </button>
            </div>
        </div>

        @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-6 text-sm font-medium">
                ⚠️ {{ session('error') }}
            </div>
        @endif

        {{-- FULL SCREEN POS MENU CONTAINER --}}
        <div class="flex flex-col gap-5">
            
            {{-- 1. HORIZONTAL SCROLLABLE CATEGORIES (TOP) --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200/80 p-3 sm:p-4">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-xs font-bold uppercase tracking-wider text-gray-400 flex items-center gap-1.5">
                        📂 Categories
                    </span>
                    <span class="text-[11px] text-gray-400 sm:hidden">Scroll horizontally →</span>
                </div>
                
                <div class="flex items-center gap-2 overflow-x-auto no-scrollbar py-1 scroll-smooth" id="categoryTabs">
                    {{-- "All Categories" Pill --}}
                    <button type="button"
                            onclick="selectCategory('', this)"
                            class="cat-chip bg-[#C25A2A] text-white shadow-sm font-bold text-xs sm:text-sm px-4 py-2.5 rounded-xl whitespace-nowrap transition-all duration-150 flex items-center gap-2 flex-shrink-0 active-cat">
                        <span>🍽️</span> All Categories
                        <span class="bg-white/20 px-2 py-0.5 rounded-full text-[11px] font-semibold">
                            {{ $products->count() }}
                        </span>
                    </button>

                    @foreach($categories as $cat)
                        @php
                            $catProductCount = $products->where('category_id', $cat->id)->count();
                        @endphp
                        <button type="button"
                                onclick="selectCategory('{{ $cat->id }}', this)"
                                class="cat-chip bg-gray-50 hover:bg-gray-100 text-gray-700 border border-gray-200 font-semibold text-xs sm:text-sm px-4 py-2.5 rounded-xl whitespace-nowrap transition-all duration-150 flex items-center gap-2 flex-shrink-0">
                            <span>{{ $cat->name }}</span>
                            <span class="bg-gray-200/70 text-gray-600 px-2 py-0.5 rounded-full text-[11px]">
                                {{ $catProductCount }}
                            </span>
                        </button>
                    @endforeach
                </div>
            </div>

            {{-- 2. SEARCH BAR (BELOW CATEGORIES) --}}
            <div class="relative">
                <input type="text"
                       id="productSearch"
                       placeholder="🔍 Search menu items by name or keywords..."
                       onkeyup="filterProducts()"
                       class="w-full pl-11 pr-10 py-3 sm:py-3.5 bg-white border border-gray-200 rounded-2xl shadow-sm text-sm focus:ring-2 focus:ring-[#C25A2A] focus:border-[#C25A2A] focus:outline-none placeholder-gray-400 font-medium transition duration-150">
                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-base">🔍</span>
                <button type="button"
                        id="btnClearSearch"
                        onclick="clearSearch()"
                        class="hidden absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 text-sm font-bold p-1">
                    ✕
                </button>
            </div>

            {{-- 3. PRODUCT GRID (FULL WIDTH & TABLET RESPONSIVE) --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200/80 p-4 sm:p-6 min-h-[450px]">
                <div class="flex items-center justify-between mb-5 pb-3 border-b border-gray-100">
                    <h3 class="text-base sm:text-lg font-bold text-gray-900 flex items-center gap-2">
                        <span>🍱</span> Select Menu Items
                    </h3>
                    <span id="productCountBadge" class="text-xs font-semibold bg-orange-50 text-[#C25A2A] border border-orange-100 px-3 py-1 rounded-full">
                        Showing {{ $products->count() }} items
                    </span>
                </div>

                @if($products->isEmpty())
                    <div class="text-center py-16 text-gray-400 text-sm">
                        No menu items found. Please add products to your menu first.
                    </div>
                @else
                    {{-- Responsive POS Grid: 1 col on XS, 2 on Mobile, 3 on Tablet portrait, 4 on Tablet landscape, 5 on Desktop --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4" id="productGrid">
                        @foreach($products as $product)
                            <div class="product-card border border-gray-200/90 hover:border-[#C25A2A] rounded-2xl p-3.5 flex flex-col justify-between transition-all duration-200 hover:shadow-md bg-white group"
                                 data-name="{{ strtolower($product->name) }}"
                                 data-category="{{ $product->category_id }}">
                                
                                <div>
                                    {{-- Product Image / Icon --}}
                                    <div class="relative w-full h-32 sm:h-36 mb-3 rounded-xl overflow-hidden bg-gray-50 border border-gray-100 flex items-center justify-center">
                                        @if($product->image)
                                            <img src="{{ config('services.google_drive.image_url').$product->image }}"
                                                 alt="{{ $product->name }}"
                                                 class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                        @else
                                            <div class="text-3xl text-gray-300 select-none">
                                                🍲
                                            </div>
                                        @endif
                                        <div class="absolute top-2 right-2 bg-white/95 backdrop-blur-sm font-extrabold text-[#C25A2A] text-xs px-2.5 py-1 rounded-lg shadow-sm border border-gray-100">
                                            £{{ number_format($product->price, 2) }}
                                        </div>
                                    </div>

                                    {{-- Info --}}
                                    <h4 class="font-bold text-gray-900 text-sm sm:text-base leading-snug line-clamp-1 mb-0.5" title="{{ $product->name }}">
                                        {{ $product->name }}
                                    </h4>
                                    <p class="text-xs text-gray-400 font-medium mb-3 truncate">
                                        {{ $product->category->name ?? 'Uncategorized' }}
                                    </p>
                                </div>

                                <div>
                                    <div class="flex items-center justify-between pt-2.5 border-t border-gray-100 gap-2">
                                        <div class="flex flex-wrap gap-1">
                                            @if($product->variants->count() > 0)
                                                <span class="bg-amber-50 text-amber-800 border border-amber-200/60 text-[10px] font-bold px-2 py-0.5 rounded-md">
                                                    {{ $product->variants->count() }} Var
                                                </span>
                                            @endif
                                            @if($product->addons->count() > 0)
                                                <span class="bg-blue-50 text-blue-800 border border-blue-200/60 text-[10px] font-bold px-2 py-0.5 rounded-md">
                                                    {{ $product->addons->count() }} Add
                                                </span>
                                            @endif
                                        </div>

                                        <button type="button"
                                                onclick="handleProductClick({{ $product->id }})"
                                                class="bg-[#C25A2A] hover:bg-[#A3451E] active:scale-95 text-white font-bold text-xs px-3.5 py-2 rounded-xl transition duration-150 flex items-center gap-1 shadow-sm ml-auto">
                                            <span>+</span> Add Item
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- No Match Search Notice --}}
                    <div id="noProductsMatch" class="hidden text-center py-16">
                        <div class="text-3xl mb-2">🔍</div>
                        <p class="text-base font-bold text-gray-700">No matching menu items found</p>
                        <p class="text-xs text-gray-400 mt-1">Try adjusting your search query or selecting a different category.</p>
                        <button type="button" onclick="clearSearch(); selectCategory('', document.querySelector('.cat-chip'))" class="mt-4 text-xs text-[#C25A2A] font-bold hover:underline">
                            Reset All Filters
                        </button>
                    </div>
                @endif
            </div>

        </div>

        {{-- 4. FLOATING CART / ORDER BUTTON (POS FAB - BOTTOM RIGHT) --}}
        <div class="fixed bottom-6 right-6 z-40">
            <button type="button"
                    id="floatingCartBtn"
                    onclick="openCartDrawer()"
                    class="bg-[#C25A2A] hover:bg-[#A3451E] text-white font-bold p-3.5 sm:px-5 sm:py-3.5 rounded-full sm:rounded-2xl shadow-2xl hover:shadow-orange-900/30 transition-all duration-200 flex items-center gap-3 border-2 border-white/20 active:scale-95 group">
                
                <div class="relative flex items-center justify-center">
                    <span class="text-xl sm:text-2xl">🛒</span>
                    <span id="floatingCartBadge" 
                          class="absolute -top-2 -right-2 bg-white text-[#C25A2A] text-[11px] font-black w-5 h-5 rounded-full flex items-center justify-center shadow">
                        0
                    </span>
                </div>

                <div class="hidden sm:flex flex-col items-start text-left">
                    <span class="text-[10px] uppercase font-bold text-orange-200 tracking-wider">Order Cart</span>
                    <span id="floatingCartTotal" class="text-sm font-extrabold text-white">£0.00</span>
                </div>

                <span class="hidden sm:inline-block text-xs bg-white/20 group-hover:bg-white/30 px-2 py-1 rounded-lg font-bold">
                    View →
                </span>
            </button>
        </div>

        {{-- 5. ORDER DETAILS & CART SLIDE-OVER DRAWER / POPUP MODAL --}}
        <div id="cartDrawer" class="fixed inset-0 z-50 hidden">
            {{-- Backdrop --}}
            <div onclick="closeCartDrawer()" class="fixed inset-0 bg-black/60 backdrop-blur-xs transition-opacity"></div>

            {{-- Drawer Container --}}
            <div class="fixed inset-y-0 right-0 max-w-full flex pl-10">
                <div class="w-screen max-w-md sm:max-w-lg bg-white shadow-2xl flex flex-col h-full border-l border-gray-200 drawer-panel">
                    
                    {{-- Drawer Header --}}
                    <div class="bg-gray-900 text-white px-5 py-4 flex items-center justify-between border-b border-gray-800">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-[#C25A2A] flex items-center justify-center text-lg">
                                🛒
                            </div>
                            <div>
                                <h3 class="font-extrabold text-base text-white flex items-center gap-2">
                                    Order Summary & Checkout
                                </h3>
                                <p class="text-xs text-gray-400">Review items and customer details</p>
                            </div>
                        </div>

                        <button type="button" 
                                onclick="closeCartDrawer()"
                                class="text-gray-400 hover:text-white bg-gray-800 hover:bg-gray-700 w-8 h-8 rounded-xl flex items-center justify-center text-base font-bold transition">
                            ✕
                        </button>
                    </div>

                    {{-- Drawer Content (Scrollable) --}}
                    <div class="flex-1 overflow-y-auto p-5 space-y-5 bg-gray-50/50">
                        
                        {{-- Customer & Table Details Box --}}
                        <div class="bg-white rounded-2xl border border-gray-200/80 p-4 shadow-xs">
                            <div class="flex items-center justify-between mb-3 pb-2 border-b border-gray-100">
                                <h4 class="text-xs font-extrabold uppercase tracking-wider text-gray-800 flex items-center gap-1.5">
                                    👤 Customer Details
                                </h4>
                                <span class="bg-amber-50 text-amber-800 border border-amber-200/60 px-2.5 py-0.5 rounded-md text-[11px] font-bold flex items-center gap-1">
                                    🍽️ Dine In Order
                                </span>
                            </div>

                            <input type="hidden" name="order_type" value="dine_in">

                            <div class="space-y-3">
                                <div>
                                    <label class="block text-xs font-bold text-gray-700 mb-1">Customer Name *</label>
                                    <input type="text"
                                           name="customer_name"
                                           required
                                           placeholder="Walk-in Guest / Customer Name"
                                           value="Walk-in Guest"
                                           class="w-full border border-gray-300 rounded-xl px-3.5 py-2 text-xs sm:text-sm focus:ring-2 focus:ring-[#C25A2A] focus:outline-none bg-white">
                                </div>

                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-xs font-bold text-gray-700 mb-1">Table Number</label>
                                        <input type="text"
                                               name="table_number"
                                               placeholder="e.g. Table 4"
                                               class="w-full border border-gray-300 rounded-xl px-3.5 py-2 text-xs sm:text-sm focus:ring-2 focus:ring-[#C25A2A] focus:outline-none bg-white">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-gray-700 mb-1">Phone Number (Optional)</label>
                                        <input type="text"
                                               name="customer_phone"
                                               placeholder="e.g. 07123456789"
                                               class="w-full border border-gray-300 rounded-xl px-3.5 py-2 text-xs sm:text-sm focus:ring-2 focus:ring-[#C25A2A] focus:outline-none bg-white">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Selected Items List (Cart) --}}
                        <div class="bg-white rounded-2xl border border-gray-200/80 p-4 shadow-xs flex flex-col">
                            <div class="flex items-center justify-between mb-3 pb-2 border-b border-gray-100">
                                <h4 class="text-xs font-extrabold uppercase tracking-wider text-gray-800 flex items-center gap-1.5">
                                    🛒 Selected Items (<span id="itemCount">0</span>)
                                </h4>
                                <button type="button" 
                                        onclick="clearCart()" 
                                        class="text-xs text-red-500 hover:text-red-700 font-bold hover:underline">
                                    Clear All
                                </button>
                            </div>

                            <div id="cartContainer" class="min-h-[120px] max-h-[260px] overflow-y-auto space-y-2.5 pr-1">
                                <div id="emptyCartNotice" class="text-center py-10 text-gray-400 text-xs">
                                    <div class="text-2xl mb-1">🛒</div>
                                    No items added yet. Click "+ Add Item" on menu items.
                                </div>
                                <div id="cartList" class="space-y-2.5"></div>
                            </div>

                            {{-- Subtotal & Total breakdown --}}
                            <div class="mt-4 pt-3 border-t border-gray-100 space-y-1.5 text-xs">
                                <div class="flex justify-between text-gray-600 font-medium">
                                    <span>Subtotal</span>
                                    <span class="font-bold text-gray-900" id="subtotalText">£0.00</span>
                                </div>
                                <div class="flex justify-between text-sm sm:text-base font-extrabold text-gray-900 pt-2 border-t border-gray-200">
                                    <span>Total Amount</span>
                                    <span class="text-[#C25A2A]" id="totalText">£0.00</span>
                                </div>
                            </div>
                        </div>

                        {{-- Payment Method & Options Box --}}
                        <div class="bg-white rounded-2xl border border-gray-200/80 p-4 shadow-xs space-y-3.5">
                            <h4 class="text-xs font-extrabold uppercase tracking-wider text-gray-800 flex items-center gap-1.5 border-b border-gray-100 pb-2">
                                💳 Payment & Notes
                            </h4>

                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1">Payment Method</label>
                                <select name="payment_method" class="w-full border border-gray-300 rounded-xl px-3.5 py-2 text-xs sm:text-sm focus:ring-2 focus:ring-[#C25A2A] focus:outline-none bg-white font-medium">
                                    <option value="Cash">💵 Cash</option>
                                    <option value="Card at Counter">💳 Card at Counter / POS Machine</option>
                                    <option value="Pay at Counter">🏬 Pay at Counter</option>
                                    <option value="Offline Payment">🏦 Direct Offline Payment</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1">Payment Status</label>
                                <div class="grid grid-cols-2 gap-2">
                                    <label class="cursor-pointer">
                                        <input type="radio" name="payment_status" value="paid" checked class="sr-only peer">
                                        <div class="text-center py-2 border rounded-xl text-xs font-bold text-gray-600 peer-checked:bg-green-50 peer-checked:border-green-500 peer-checked:text-green-700 transition">
                                            ✅ Paid Now
                                        </div>
                                    </label>
                                    <label class="cursor-pointer">
                                        <input type="radio" name="payment_status" value="pending" class="sr-only peer">
                                        <div class="text-center py-2 border rounded-xl text-xs font-bold text-gray-600 peer-checked:bg-amber-50 peer-checked:border-amber-500 peer-checked:text-amber-700 transition">
                                            ⏳ Pay Later
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1">Order Notes (Optional)</label>
                                <textarea name="notes" rows="2" placeholder="e.g. Allergy info, table instructions..." class="w-full border border-gray-300 rounded-xl p-2.5 text-xs focus:ring-2 focus:ring-[#C25A2A] focus:outline-none"></textarea>
                            </div>
                        </div>

                    </div>

                    {{-- Drawer Footer (Submit Order Button) --}}
                    <div class="p-4 bg-white border-t border-gray-200">
                        <button type="submit"
                                id="btnSubmitOrder"
                                disabled
                                class="w-full bg-[#C25A2A] hover:bg-[#A3451E] disabled:bg-gray-300 text-white font-bold py-3.5 px-4 rounded-xl shadow-md transition duration-150 text-sm sm:text-base flex items-center justify-center gap-2">
                            <span>🚀</span> Place Direct Order
                        </button>
                    </div>

                </div>
            </div>
        </div>

    </form>

</div>

{{-- PRODUCT VARIANTS & ADDONS MODAL --}}
<div id="optionsModal" class="fixed inset-0 bg-black/60 backdrop-blur-xs z-50 flex items-center justify-center hidden p-4">
    <div class="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl relative max-h-[90vh] overflow-y-auto border border-gray-100">
        <button type="button" onclick="closeOptionsModal()" class="absolute right-4 top-4 text-gray-400 hover:text-gray-600 w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-lg font-bold">✕</button>
        
        <h3 id="modalProductName" class="text-lg font-extrabold text-gray-900 mb-0.5">Product Options</h3>
        <p id="modalCategoryName" class="text-xs font-medium text-gray-400 mb-4"></p>

        {{-- Variants --}}
        <div id="modalVariantsSection" class="mb-4">
            <label class="block text-xs font-extrabold text-gray-800 uppercase tracking-wider mb-2">Select Variant</label>
            <div id="modalVariantsList" class="space-y-2"></div>
        </div>

        {{-- Addons --}}
        <div id="modalAddonsSection" class="mb-5">
            <label class="block text-xs font-extrabold text-gray-800 uppercase tracking-wider mb-2">Select Addons (Optional)</label>
            <div id="modalAddonsList" class="space-y-2"></div>
        </div>

        {{-- Quantity --}}
        <div class="flex items-center justify-between mb-6 pt-3 border-t border-gray-100">
            <span class="text-xs font-bold text-gray-700">Quantity</span>
            <div class="flex items-center gap-3 bg-gray-100 px-3 py-1.5 rounded-xl border border-gray-200">
                <button type="button" onclick="modalQtyDec()" class="font-bold text-gray-700 px-1 text-base hover:text-black">-</button>
                <span id="modalQtyText" class="font-extrabold text-sm w-6 text-center text-gray-900">1</span>
                <button type="button" onclick="modalQtyInc()" class="font-bold text-gray-700 px-1 text-base hover:text-black">+</button>
            </div>
        </div>

        <button type="button"
                onclick="confirmAddToCart()"
                class="w-full bg-[#C25A2A] hover:bg-[#A3451E] text-white font-bold py-3.5 rounded-xl shadow-md text-sm transition flex items-center justify-center gap-2">
            Add to Order (<span id="modalTotalPrice">£0.00</span>)
        </button>
    </div>
</div>

<script>
    const allProductsMap = @json($products->keyBy('id'));
    let cartItems = [];
    let currentModalProduct = null;
    let modalQty = 1;
    let selectedCategoryId = '';

    // Category Selection via Horizontal Chips
    function selectCategory(catId, chipElement) {
        selectedCategoryId = catId ? String(catId) : '';

        // Reset all category chips styling
        document.querySelectorAll('.cat-chip').forEach(chip => {
            chip.classList.remove('bg-[#C25A2A]', 'text-white', 'shadow-sm', 'active-cat');
            chip.classList.add('bg-gray-50', 'text-gray-700', 'border-gray-200', 'hover:bg-gray-100');
            
            // Adjust count badge inside inactive chips
            const badge = chip.querySelector('span:last-child');
            if (badge) {
                badge.classList.remove('bg-white/20', 'text-white');
                badge.classList.add('bg-gray-200/70', 'text-gray-600');
            }
        });

        // Highlight selected chip
        if (chipElement) {
            chipElement.classList.remove('bg-gray-50', 'text-gray-700', 'border-gray-200', 'hover:bg-gray-100');
            chipElement.classList.add('bg-[#C25A2A]', 'text-white', 'shadow-sm', 'active-cat');

            const badge = chipElement.querySelector('span:last-child');
            if (badge) {
                badge.classList.remove('bg-gray-200/70', 'text-gray-600');
                badge.classList.add('bg-white/20', 'text-white');
            }
        }

        filterProducts();
    }

    // Filter product grid based on Category & Search query
    function filterProducts() {
        const searchInput = document.getElementById('productSearch');
        const query = searchInput ? searchInput.value.toLowerCase().trim() : '';
        const btnClear = document.getElementById('btnClearSearch');

        if (btnClear) {
            btnClear.style.display = query.length > 0 ? 'block' : 'none';
        }

        const catId = selectedCategoryId;
        const cards = document.querySelectorAll('.product-card');

        let visibleCount = 0;
        cards.forEach(card => {
            const name = card.getAttribute('data-name');
            const category = card.getAttribute('data-category');

            const matchQuery = !query || name.includes(query);
            const matchCat = !catId || category === catId;

            if (matchQuery && matchCat) {
                card.style.display = 'flex';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        const noMatchEl = document.getElementById('noProductsMatch');
        if (noMatchEl) {
            noMatchEl.style.display = (visibleCount === 0) ? 'block' : 'none';
        }

        const countBadge = document.getElementById('productCountBadge');
        if (countBadge) {
            countBadge.innerText = `Showing ${visibleCount} items`;
        }
    }

    function clearSearch() {
        const searchInput = document.getElementById('productSearch');
        if (searchInput) {
            searchInput.value = '';
            filterProducts();
        }
    }

    // Cart Drawer Controls
    function openCartDrawer() {
        const drawer = document.getElementById('cartDrawer');
        if (drawer) {
            drawer.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
    }

    function closeCartDrawer() {
        const drawer = document.getElementById('cartDrawer');
        if (drawer) {
            drawer.classList.add('hidden');
            document.body.style.overflow = '';
        }
    }

    function handleProductClick(productId) {
        const product = allProductsMap[productId];
        if (!product) return;

        const hasVariants = product.variants && product.variants.length > 0;
        const hasAddons = product.addons && product.addons.length > 0;

        if (hasVariants || hasAddons) {
            openOptionsModal(product);
        } else {
            addItemToCart(product.id, product.name, null, null, parseFloat(product.price), [], 1);
        }
    }

    function openOptionsModal(product) {
        currentModalProduct = product;
        modalQty = 1;
        document.getElementById('modalQtyText').innerText = modalQty;
        document.getElementById('modalProductName').innerText = product.name;
        document.getElementById('modalCategoryName').innerText = product.category ? product.category.name : '';

        // Render variants
        const vSection = document.getElementById('modalVariantsSection');
        const vList = document.getElementById('modalVariantsList');
        vList.innerHTML = '';

        if (product.variants && product.variants.length > 0) {
            vSection.style.display = 'block';
            product.variants.forEach((v, idx) => {
                vList.innerHTML += `
                    <label class="flex items-center justify-between p-3 border border-gray-200 rounded-xl cursor-pointer hover:bg-orange-50/50 transition text-xs font-medium">
                        <div class="flex items-center gap-2.5">
                            <input type="radio" name="modal_variant" value="${v.id}" data-price="${v.price}" data-name="${v.name}" ${idx === 0 ? 'checked' : ''} onchange="updateModalPrice()" class="text-[#C25A2A] focus:ring-[#C25A2A]">
                            <span class="font-bold text-gray-800">${v.name}</span>
                        </div>
                        <span class="font-extrabold text-[#C25A2A]">£${parseFloat(v.price).toFixed(2)}</span>
                    </label>
                `;
            });
        } else {
            vSection.style.display = 'none';
        }

        // Render addons
        const aSection = document.getElementById('modalAddonsSection');
        const aList = document.getElementById('modalAddonsList');
        aList.innerHTML = '';

        if (product.addons && product.addons.length > 0) {
            aSection.style.display = 'block';
            product.addons.forEach(a => {
                aList.innerHTML += `
                    <label class="flex items-center justify-between p-3 border border-gray-200 rounded-xl cursor-pointer hover:bg-orange-50/50 transition text-xs font-medium">
                        <div class="flex items-center gap-2.5">
                            <input type="checkbox" name="modal_addon" value="${a.id}" data-price="${a.price}" data-name="${a.addon_name}" onchange="updateModalPrice()" class="text-[#C25A2A] focus:ring-[#C25A2A] rounded">
                            <span class="text-gray-700">${a.addon_name} <span class="text-gray-400">(${a.category_name || 'Addon'})</span></span>
                        </div>
                        <span class="font-bold text-gray-900">+£${parseFloat(a.price).toFixed(2)}</span>
                    </label>
                `;
            });
        } else {
            aSection.style.display = 'none';
        }

        updateModalPrice();
        document.getElementById('optionsModal').classList.remove('hidden');
    }

    function closeOptionsModal() {
        document.getElementById('optionsModal').classList.add('hidden');
    }

    function modalQtyInc() { modalQty++; document.getElementById('modalQtyText').innerText = modalQty; updateModalPrice(); }
    function modalQtyDec() { if(modalQty > 1) { modalQty--; document.getElementById('modalQtyText').innerText = modalQty; updateModalPrice(); } }

    function updateModalPrice() {
        if (!currentModalProduct) return;
        let basePrice = parseFloat(currentModalProduct.price);

        const checkedVar = document.querySelector('input[name="modal_variant"]:checked');
        if (checkedVar) {
            basePrice = parseFloat(checkedVar.getAttribute('data-price'));
        }

        let addonTotal = 0;
        document.querySelectorAll('input[name="modal_addon"]:checked').forEach(ad => {
            addonTotal += parseFloat(ad.getAttribute('data-price'));
        });

        const singleTotal = basePrice + addonTotal;
        const total = singleTotal * modalQty;
        document.getElementById('modalTotalPrice').innerText = '£' + total.toFixed(2);
    }

    function confirmAddToCart() {
        if (!currentModalProduct) return;

        let basePrice = parseFloat(currentModalProduct.price);
        let variantId = null;
        let variantName = null;

        const checkedVar = document.querySelector('input[name="modal_variant"]:checked');
        if (checkedVar) {
            basePrice = parseFloat(checkedVar.getAttribute('data-price'));
            variantId = checkedVar.value;
            variantName = checkedVar.getAttribute('data-name');
        }

        let selectedAddons = [];
        document.querySelectorAll('input[name="modal_addon"]:checked').forEach(ad => {
            selectedAddons.push({
                id: ad.value,
                name: ad.getAttribute('data-name'),
                price: parseFloat(ad.getAttribute('data-price'))
            });
        });

        addItemToCart(
            currentModalProduct.id,
            currentModalProduct.name,
            variantId,
            variantName,
            basePrice,
            selectedAddons,
            modalQty
        );

        closeOptionsModal();
    }

    function areAddonsEqual(addons1, addons2) {
        if (addons1.length !== addons2.length) return false;
        const ids1 = addons1.map(a => String(a.id)).sort();
        const ids2 = addons2.map(a => String(a.id)).sort();
        return ids1.every((id, idx) => id === ids2[idx]);
    }

    function addItemToCart(productId, name, variantId, variantName, basePrice, addons, qty) {
        const existingIndex = cartItems.findIndex(item =>
            item.product_id === productId &&
            String(item.variant_id) === String(variantId) &&
            areAddonsEqual(item.addons, addons)
        );

        if (existingIndex > -1) {
            cartItems[existingIndex].quantity += qty;
        } else {
            cartItems.push({
                product_id: productId,
                name: name,
                variant_id: variantId,
                variant_name: variantName,
                base_price: basePrice,
                addons: addons,
                quantity: qty
            });
        }

        // Trigger visual pulse on floating cart button
        const floatBtn = document.getElementById('floatingCartBtn');
        if (floatBtn) {
            floatBtn.classList.add('cart-bump');
            setTimeout(() => floatBtn.classList.remove('cart-bump'), 300);
        }

        renderCart();
    }

    function renderCart() {
        const list = document.getElementById('cartList');
        const emptyNotice = document.getElementById('emptyCartNotice');
        const btnSubmit = document.getElementById('btnSubmitOrder');

        // Remove old dynamic hidden inputs
        document.querySelectorAll('.cart-hidden-input').forEach(el => el.remove());

        if (cartItems.length === 0) {
            if (emptyNotice) emptyNotice.style.display = 'block';
            if (list) list.innerHTML = '';
            
            // Sync all badges & total texts
            updateCartDisplays(0, 0);

            if (btnSubmit) btnSubmit.disabled = true;
            return;
        }

        if (emptyNotice) emptyNotice.style.display = 'none';
        if (list) list.innerHTML = '';

        let subtotal = 0;
        let itemCount = 0;

        cartItems.forEach((item, index) => {
            let addonSum = item.addons.reduce((acc, a) => acc + a.price, 0);
            let itemUnitPrice = item.base_price + addonSum;
            let itemTotal = itemUnitPrice * item.quantity;
            subtotal += itemTotal;
            itemCount += item.quantity;

            // Render UI item row
            const row = document.createElement('div');
            row.className = 'flex items-center justify-between p-3 bg-white rounded-xl text-xs border border-gray-200/80 shadow-2xs';

            let detailsHtml = `<div class="font-extrabold text-gray-900">${item.name}</div>`;
            if (item.variant_name) {
                detailsHtml += `<div class="text-amber-800 text-[11px] font-semibold">Option: ${item.variant_name}</div>`;
            }
            if (item.addons.length > 0) {
                detailsHtml += `<div class="text-blue-700 text-[10px] font-medium">Addons: ${item.addons.map(a => a.name).join(', ')}</div>`;
            }

            row.innerHTML = `
                <div class="flex-1 min-w-0 pr-2">
                    ${detailsHtml}
                    <div class="text-gray-500 font-semibold mt-0.5">£${itemUnitPrice.toFixed(2)} × ${item.quantity} = <span class="text-[#C25A2A] font-extrabold">£${itemTotal.toFixed(2)}</span></div>
                </div>
                <div class="flex items-center gap-2 flex-shrink-0">
                    <div class="flex items-center bg-gray-100 border border-gray-200 rounded-lg px-2 py-0.5">
                        <button type="button" onclick="changeCartQty(${index}, -1)" class="px-1 text-gray-700 font-bold hover:text-black text-sm">-</button>
                        <span class="px-1.5 font-extrabold text-gray-900">${item.quantity}</span>
                        <button type="button" onclick="changeCartQty(${index}, 1)" class="px-1 text-gray-700 font-bold hover:text-black text-sm">+</button>
                    </div>
                    <button type="button" onclick="removeCartItem(${index})" class="text-gray-400 hover:text-red-600 font-bold p-1 text-sm transition">✕</button>
                </div>
            `;
            if (list) list.appendChild(row);

            // Inject hidden inputs into form
            const form = document.getElementById('directOrderForm');
            if (form) {
                const inputProd = document.createElement('input');
                inputProd.type = 'hidden';
                inputProd.className = 'cart-hidden-input';
                inputProd.name = `items[${index}][product_id]`;
                inputProd.value = item.product_id;
                form.appendChild(inputProd);

                const inputQty = document.createElement('input');
                inputQty.type = 'hidden';
                inputQty.className = 'cart-hidden-input';
                inputQty.name = `items[${index}][quantity]`;
                inputQty.value = item.quantity;
                form.appendChild(inputQty);

                if (item.variant_id) {
                    const inputVar = document.createElement('input');
                    inputVar.type = 'hidden';
                    inputVar.className = 'cart-hidden-input';
                    inputVar.name = `items[${index}][variant_id]`;
                    inputVar.value = item.variant_id;
                    form.appendChild(inputVar);
                }

                item.addons.forEach((ad, aIdx) => {
                    const inputAd = document.createElement('input');
                    inputAd.type = 'hidden';
                    inputAd.className = 'cart-hidden-input';
                    inputAd.name = `items[${index}][addons][${aIdx}]`;
                    inputAd.value = ad.id;
                    form.appendChild(inputAd);
                });
            }
        });

        updateCartDisplays(itemCount, subtotal);
        if (btnSubmit) btnSubmit.disabled = false;
    }

    function updateCartDisplays(itemCount, subtotal) {
        const formattedTotal = '£' + subtotal.toFixed(2);

        // Drawer elements
        if (document.getElementById('itemCount')) document.getElementById('itemCount').innerText = itemCount;
        if (document.getElementById('subtotalText')) document.getElementById('subtotalText').innerText = formattedTotal;
        if (document.getElementById('totalText')) document.getElementById('totalText').innerText = formattedTotal;

        // Floating icon elements
        if (document.getElementById('floatingCartBadge')) document.getElementById('floatingCartBadge').innerText = itemCount;
        if (document.getElementById('floatingCartTotal')) document.getElementById('floatingCartTotal').innerText = formattedTotal;

        // Header badge
        if (document.getElementById('headerCartBadge')) document.getElementById('headerCartBadge').innerText = itemCount;
    }

    function changeCartQty(index, delta) {
        cartItems[index].quantity += delta;
        if (cartItems[index].quantity <= 0) {
            cartItems.splice(index, 1);
        }
        renderCart();
    }

    function removeCartItem(index) {
        cartItems.splice(index, 1);
        renderCart();
    }

    function clearCart() {
        cartItems = [];
        renderCart();
    }

    // Keyboard support (Escape closes modals)
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            closeCartDrawer();
            closeOptionsModal();
        }
    });
</script>

@endsection
