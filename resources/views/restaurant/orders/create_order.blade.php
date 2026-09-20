@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto px-4 py-6">

    {{-- Page Header --}}
    <div class="flex justify-between items-center mb-6">
        <div>
            <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-[#C25A2A] mb-1">
                <span class="w-4 h-0.5 bg-[#C25A2A] inline-block rounded"></span>
                RESTAURANT DIRECT ORDERING
            </div>
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">
                Create Direct Menu Order
            </h1>
            <p class="text-sm text-gray-500 mt-1">
                Place orders directly for walk-in, phone, table, or offline customers.
            </p>
        </div>

        <a href="/restaurant/orders"
           class="bg-black hover:bg-gray-800 text-white font-semibold px-5 py-2.5 rounded-xl transition duration-150 inline-flex items-center gap-2 text-sm shadow">
            ← Back to Orders
        </a>
    </div>

    @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-6 text-sm font-medium">
            ⚠️ {{ session('error') }}
        </div>
    @endif

    {{-- Form wrap --}}
    <form id="directOrderForm" method="POST" action="{{ route('restaurant.orders.store_offline') }}">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

            {{-- LEFT COLUMN: MENU ITEMS SELECTION (7 Cols) --}}
            <div class="lg:col-span-7 flex flex-col gap-6">
                
                {{-- Search & Category Filter --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4">
                    <div class="flex flex-col sm:flex-row gap-3">
                        <div class="relative flex-1">
                            <input type="text"
                                   id="productSearch"
                                   placeholder="Search menu item by name..."
                                   onkeyup="filterProducts()"
                                   class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#C25A2A] focus:outline-none text-sm">
                            <span class="absolute left-3 top-3 text-gray-400">🔍</span>
                        </div>
                        <select id="categoryFilter"
                                onchange="filterProducts()"
                                class="border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-[#C25A2A] focus:outline-none text-sm bg-white">
                            <option value="">All Categories</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Product Grid --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                    <h3 class="text-base font-bold text-gray-900 mb-4 flex items-center gap-2">
                        🍽️ Select Menu Items
                    </h3>

                    @if($products->isEmpty())
                        <div class="text-center py-10 text-gray-400 text-sm">
                            No menu items found. Please add products to your menu first.
                        </div>
                    @else
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 max-h-[620px] overflow-y-auto pr-1" id="productGrid">
                            @foreach($products as $product)
                                <div class="product-card border border-gray-200 rounded-xl p-3 flex flex-col justify-between hover:border-[#C25A2A] transition duration-150 bg-white"
                                     data-name="{{ strtolower($product->name) }}"
                                     data-category="{{ $product->category_id }}">
                                    
                                    <div class="flex gap-3 items-start mb-2">
                                        @if($product->image)
                                            <img src="{{ config('services.google_drive.image_url').$product->image }}"
                                                 alt="{{ $product->name }}"
                                                 class="w-14 h-14 object-cover rounded-lg flex-shrink-0 bg-gray-100">
                                        @else
                                            <div class="w-14 h-14 rounded-lg bg-gray-100 flex items-center justify-center text-xl flex-shrink-0 text-gray-400">
                                                🍲
                                            </div>
                                        @endif
                                        <div class="flex-1 min-w-0">
                                            <h4 class="font-bold text-gray-900 text-sm truncate" title="{{ $product->name }}">
                                                {{ $product->name }}
                                            </h4>
                                            <p class="text-xs text-gray-500 truncate">
                                                {{ $product->category->name ?? 'Uncategorized' }}
                                            </p>
                                            <div class="font-extrabold text-[#C25A2A] text-sm mt-1">
                                                £{{ number_format($product->price, 2) }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="flex items-center justify-between pt-2 border-t border-gray-100 text-xs">
                                        <div class="text-gray-400">
                                            @if($product->variants->count() > 0)
                                                <span class="bg-amber-50 text-amber-700 px-2 py-0.5 rounded font-medium">
                                                    {{ $product->variants->count() }} Variants
                                                </span>
                                            @endif
                                            @if($product->addons->count() > 0)
                                                <span class="bg-blue-50 text-blue-700 px-2 py-0.5 rounded font-medium ml-1">
                                                    {{ $product->addons->count() }} Addons
                                                </span>
                                            @endif
                                        </div>

                                        <button type="button"
                                                onclick="openOptionsModal({{ json_encode($product) }})"
                                                class="bg-[#C25A2A] hover:bg-[#A3451E] text-white px-3 py-1.5 rounded-lg font-semibold text-xs transition duration-150">
                                            + Add Item
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

            </div>

            {{-- RIGHT COLUMN: ORDER DETAILS & CART (5 Cols) --}}
            <div class="lg:col-span-5 flex flex-col gap-6">

                {{-- Customer & Order Type Box --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                    <h3 class="text-base font-bold text-gray-900 mb-3 flex items-center justify-between">
                        <span class="flex items-center gap-2">👤 Customer & Table Details</span>
                        <span class="bg-amber-50 text-amber-800 border border-amber-200 px-2.5 py-1 rounded-lg text-xs font-bold flex items-center gap-1">
                            🍽️ Dine In Order
                        </span>
                    </h3>

                    <input type="hidden" name="order_type" value="dine_in">

                    {{-- Customer Info Inputs --}}
                    <div class="space-y-3">
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Customer Name *</label>
                            <input type="text"
                                   name="customer_name"
                                   required
                                   placeholder="Walk-in Guest / Customer Name"
                                   value="Walk-in Guest"
                                   class="w-full border border-gray-300 rounded-xl px-3.5 py-2 text-sm focus:ring-2 focus:ring-[#C25A2A] focus:outline-none">
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1">Table Number</label>
                                <input type="text"
                                       name="table_number"
                                       placeholder="e.g. Table 4"
                                       class="w-full border border-gray-300 rounded-xl px-3.5 py-2 text-sm focus:ring-2 focus:ring-[#C25A2A] focus:outline-none">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1">Phone Number (Optional)</label>
                                <input type="text"
                                       name="customer_phone"
                                       placeholder="e.g. 07123456789"
                                       class="w-full border border-gray-300 rounded-xl px-3.5 py-2 text-sm focus:ring-2 focus:ring-[#C25A2A] focus:outline-none">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Selected Items List (Order Summary) --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 flex-1 flex flex-col">
                    <h3 class="text-base font-bold text-gray-900 mb-3 flex items-center justify-between">
                        <span>🛒 Selected Items (<span id="itemCount">0</span>)</span>
                        <button type="button" onclick="clearCart()" class="text-xs text-red-500 hover:underline">Clear All</button>
                    </h3>

                    <div id="cartList" class="flex-1 overflow-y-auto max-h-[300px] border-y border-gray-100 py-3 space-y-3">
                        <div id="emptyCartNotice" class="text-center py-8 text-gray-400 text-xs">
                            No items added yet. Click "+ Add Item" on menu items on the left.
                        </div>
                    </div>

                    {{-- Total Breakdown --}}
                    <div class="pt-4 space-y-2 text-sm">
                        <div class="flex justify-between text-gray-600">
                            <span>Subtotal</span>
                            <span class="font-semibold text-gray-900" id="subtotalText">£0.00</span>
                        </div>
                        <div class="flex justify-between text-base font-extrabold text-gray-900 pt-2 border-t border-gray-200">
                            <span>Total Amount</span>
                            <span class="text-[#C25A2A]" id="totalText">£0.00</span>
                        </div>
                    </div>

                    {{-- Offline Payment Options --}}
                    <div class="mt-4 pt-4 border-t border-gray-200 space-y-3">
                        <label class="block text-xs font-semibold text-gray-700">Payment Method</label>
                        <select name="payment_method" class="w-full border border-gray-300 rounded-xl px-3.5 py-2 text-sm focus:ring-2 focus:ring-[#C25A2A] focus:outline-none bg-white">
                            <option value="Cash">💵 Cash</option>
                            <option value="Card at Counter">💳 Card at Counter / POS Machine</option>
                            <option value="Pay at Counter">🏬 Pay at Counter</option>
                            <option value="Offline Payment">🏦 Direct Offline Payment</option>
                        </select>

                        <label class="block text-xs font-semibold text-gray-700">Initial Payment Status</label>
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
                                    ⏳ Unpaid / Pay Later
                                </div>
                            </label>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Order Notes (Optional)</label>
                            <textarea name="notes" rows="2" placeholder="e.g. Allergy info, special instructions..." class="w-full border border-gray-300 rounded-xl p-2.5 text-xs focus:ring-2 focus:ring-[#C25A2A] focus:outline-none"></textarea>
                        </div>

                        <button type="submit"
                                id="btnSubmitOrder"
                                disabled
                                class="w-full bg-[#C25A2A] hover:bg-[#A3451E] disabled:bg-gray-300 text-white font-bold py-3 px-4 rounded-xl shadow transition duration-150 text-sm mt-2">
                            🚀 Place Direct Order
                        </button>
                    </div>

                </div>

            </div>

        </div>

    </form>

</div>

{{-- MODAL FOR PRODUCT VARIANTS & ADDONS --}}
<div id="optionsModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center hidden p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl relative max-h-[90vh] overflow-y-auto">
        <button type="button" onclick="closeOptionsModal()" class="absolute right-4 top-4 text-gray-400 hover:text-gray-600 text-xl font-bold">×</button>
        
        <h3 id="modalProductName" class="text-lg font-bold text-gray-900 mb-1">Product Options</h3>
        <p id="modalCategoryName" class="text-xs text-gray-500 mb-4"></p>

        {{-- Variants --}}
        <div id="modalVariantsSection" class="mb-4">
            <label class="block text-xs font-bold text-gray-800 uppercase tracking-wider mb-2">Select Variant</label>
            <div id="modalVariantsList" class="space-y-2"></div>
        </div>

        {{-- Addons --}}
        <div id="modalAddonsSection" class="mb-5">
            <label class="block text-xs font-bold text-gray-800 uppercase tracking-wider mb-2">Select Addons (Optional)</label>
            <div id="modalAddonsList" class="space-y-2"></div>
        </div>

        {{-- Quantity --}}
        <div class="flex items-center justify-between mb-6 pt-3 border-t border-gray-100">
            <span class="text-xs font-bold text-gray-700">Quantity</span>
            <div class="flex items-center gap-3 bg-gray-100 px-3 py-1.5 rounded-xl">
                <button type="button" onclick="modalQtyDec()" class="font-bold text-gray-600 px-1 text-base">-</button>
                <span id="modalQtyText" class="font-bold text-sm w-6 text-center">1</span>
                <button type="button" onclick="modalQtyInc()" class="font-bold text-gray-600 px-1 text-base">+</button>
            </div>
        </div>

        <button type="button"
                onclick="confirmAddToCart()"
                class="w-full bg-[#C25A2A] hover:bg-[#A3451E] text-white font-bold py-3 rounded-xl shadow text-sm transition">
            Add to Order (<span id="modalTotalPrice">£0.00</span>)
        </button>
    </div>
</div>

<script>
    let cartItems = [];
    let currentModalProduct = null;
    let modalQty = 1;

    function filterProducts() {
        const query = document.getElementById('productSearch').value.toLowerCase();
        const catId = document.getElementById('categoryFilter').value;
        const cards = document.querySelectorAll('.product-card');

        cards.forEach(card => {
            const name = card.getAttribute('data-name');
            const category = card.getAttribute('data-category');

            const matchQuery = name.includes(query);
            const matchCat = !catId || category === catId;

            if (matchQuery && matchCat) {
                card.style.display = 'flex';
            } else {
                card.style.display = 'none';
            }
        });
    }

    function toggleOrderTypeFields() {
        const type = document.querySelector('input[name="order_type"]:checked').value;
        const tableWrap = document.getElementById('tableNumWrap');
        const addressWrap = document.getElementById('addressWrap');

        if (type === 'dine_in') {
            tableWrap.style.display = 'block';
            addressWrap.style.display = 'none';
        } else if (type === 'delivery') {
            tableWrap.style.display = 'none';
            addressWrap.style.display = 'block';
        } else {
            tableWrap.style.display = 'none';
            addressWrap.style.display = 'none';
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
                    <label class="flex items-center justify-between p-2.5 border rounded-xl cursor-pointer hover:bg-gray-50 transition text-xs">
                        <div class="flex items-center gap-2">
                            <input type="radio" name="modal_variant" value="${v.id}" data-price="${v.price}" data-name="${v.name}" ${idx === 0 ? 'checked' : ''} onchange="updateModalPrice()">
                            <span class="font-semibold text-gray-800">${v.name}</span>
                        </div>
                        <span class="font-bold text-[#C25A2A]">£${parseFloat(v.price).toFixed(2)}</span>
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
                    <label class="flex items-center justify-between p-2.5 border rounded-xl cursor-pointer hover:bg-gray-50 transition text-xs">
                        <div class="flex items-center gap-2">
                            <input type="checkbox" name="modal_addon" value="${a.id}" data-price="${a.price}" data-name="${a.addon_name}" onchange="updateModalPrice()">
                            <span class="text-gray-700">${a.addon_name} <span class="text-gray-400">(${a.category_name || 'Addon'})</span></span>
                        </div>
                        <span class="font-semibold text-gray-900">+£${parseFloat(a.price).toFixed(2)}</span>
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

        const cartItem = {
            key: Date.now() + '_' + Math.random().toString(36).substr(2, 5),
            product_id: currentModalProduct.id,
            name: currentModalProduct.name,
            variant_id: variantId,
            variant_name: variantName,
            base_price: basePrice,
            addons: selectedAddons,
            quantity: modalQty
        };

        cartItems.push(cartItem);
        renderCart();
        closeOptionsModal();
    }

    function renderCart() {
        const list = document.getElementById('cartList');
        const emptyNotice = document.getElementById('emptyCartNotice');
        const btnSubmit = document.getElementById('btnSubmitOrder');

        // Remove old dynamic inputs
        document.querySelectorAll('.cart-hidden-input').forEach(el => el.remove());

        if (cartItems.length === 0) {
            emptyNotice.style.display = 'block';
            list.innerHTML = '';
            list.appendChild(emptyNotice);
            document.getElementById('itemCount').innerText = 0;
            document.getElementById('subtotalText').innerText = '£0.00';
            document.getElementById('totalText').innerText = '£0.00';
            btnSubmit.disabled = true;
            return;
        }

        emptyNotice.style.display = 'none';
        list.innerHTML = '';

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
            row.className = 'flex items-center justify-between p-2.5 bg-gray-50 rounded-xl text-xs border border-gray-100';

            let detailsHtml = `<div class="font-bold text-gray-900">${item.name}</div>`;
            if (item.variant_name) {
                detailsHtml += `<div class="text-amber-700 text-[11px]">Option: ${item.variant_name}</div>`;
            }
            if (item.addons.length > 0) {
                detailsHtml += `<div class="text-blue-700 text-[10px]">Addons: ${item.addons.map(a => a.name).join(', ')}</div>`;
            }

            row.innerHTML = `
                <div class="flex-1 min-w-0 pr-2">
                    ${detailsHtml}
                    <div class="text-gray-500 font-semibold mt-0.5">£${itemUnitPrice.toFixed(2)} × ${item.quantity} = <span class="text-[#C25A2A]">£${itemTotal.toFixed(2)}</span></div>
                </div>
                <div class="flex items-center gap-2 flex-shrink-0">
                    <div class="flex items-center bg-white border border-gray-200 rounded-lg px-1.5 py-0.5">
                        <button type="button" onclick="changeCartQty(${index}, -1)" class="px-1 text-gray-600 font-bold">-</button>
                        <span class="px-1 font-bold text-gray-900">${item.quantity}</span>
                        <button type="button" onclick="changeCartQty(${index}, 1)" class="px-1 text-gray-600 font-bold">+</button>
                    </div>
                    <button type="button" onclick="removeCartItem(${index})" class="text-red-500 hover:text-red-700 font-bold px-1">✕</button>
                </div>
            `;
            list.appendChild(row);

            // Inject hidden inputs into form
            const form = document.getElementById('directOrderForm');
            
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
        });

        document.getElementById('itemCount').innerText = itemCount;
        document.getElementById('subtotalText').innerText = '£' + subtotal.toFixed(2);
        document.getElementById('totalText').innerText = '£' + subtotal.toFixed(2);
        btnSubmit.disabled = false;
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

    document.addEventListener('DOMContentLoaded', () => {
        toggleOrderTypeFields();
    });
</script>

@endsection
