@extends('layouts.app')

@section('content')

<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6 sm:mb-8">

    <div>

        <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold">

            My Products

        </h1>

        <p class="text-gray-500 mt-1 text-xs sm:text-sm">

            Restaurant products list

        </p>

    </div>

    <div class="flex flex-wrap items-center gap-2 sm:gap-3 w-full sm:w-auto">
        <a href="{{ route('restaurant.addons.index') }}"
        class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 sm:px-6 py-2.5 sm:py-3 rounded-xl text-xs sm:text-sm font-semibold flex-1 sm:flex-initial text-center transition shadow">
            Manage Addons
        </a>
        <a href="/restaurant/products/create"
        class="bg-blue-500 hover:bg-blue-600 text-white px-4 sm:px-6 py-2.5 sm:py-3 rounded-xl text-xs sm:text-sm font-semibold flex-1 sm:flex-initial text-center transition shadow">
            + Add Product
        </a>
    </div>

</div>
<div class="bg-white rounded-2xl shadow p-4 sm:p-5 mb-6">

    <form method="GET">

        <div class="flex flex-col sm:flex-row gap-3">

            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Search product, category, price..."
                class="flex-1 border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">

            <div class="flex gap-2">
                <button
                    type="submit"
                    class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-xl font-semibold text-sm flex-1 sm:flex-initial text-center transition">

                    Search

                </button>

                @if(request('search') || request('filter'))
                    <a href="{{ route('restaurant.products.index') }}"
                       class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-xl font-semibold text-sm flex-1 sm:flex-initial text-center transition">

                        Reset

                    </a>
                @endif
            </div>

        </div>

    </form>

    {{-- Quick filter tabs for specials --}}
    <div class="flex items-center gap-2 mt-4 pt-3 border-t border-gray-100 flex-wrap">
        <span class="text-xs font-semibold text-gray-500 mr-1">Filter list:</span>
        <a href="{{ route('restaurant.products.index', array_merge(request()->query(), ['filter' => null])) }}"
           class="px-3.5 py-1.5 rounded-full text-xs font-semibold transition {{ empty(request('filter')) ? 'bg-black text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
            All Products
        </a>
        <a href="{{ route('restaurant.products.index', array_merge(request()->query(), ['filter' => 'todays'])) }}"
           class="px-3.5 py-1.5 rounded-full text-xs font-semibold transition {{ request('filter') === 'todays' ? 'bg-indigo-600 text-white' : 'bg-indigo-50 text-indigo-700 hover:bg-indigo-100 border border-indigo-200' }}">
            ⚡ Today's Specials Only
        </a>
        <a href="{{ route('restaurant.products.index', array_merge(request()->query(), ['filter' => 'restaurant'])) }}"
           class="px-3.5 py-1.5 rounded-full text-xs font-semibold transition {{ request('filter') === 'restaurant' ? 'bg-amber-500 text-white' : 'bg-amber-50 text-amber-800 hover:bg-amber-100 border border-amber-200' }}">
            🌟 Restaurant Specials Only
        </a>
    </div>

</div>


<div class="bg-white rounded-2xl shadow overflow-x-auto">

    <table class="w-full min-w-[700px]">

        <thead class="bg-gray-100">

            <tr>

                <th class="p-5 text-left">
                    Image
                </th>

                <th class="p-5 text-left">
                    Name
                </th>

                <th class="p-5 text-left">
                    Category
                </th>

                <th class="p-5 text-left">
                    Price
                </th>

                <th class="p-5 text-left">
                    Type
                </th>

                <th class="p-5 text-left">
                    Specials (Quick Select)
                </th>

                <th class="p-5 text-left">Allergy&Dietary</th>


                <th class="p-5 text-left">
                    Status
                </th>

                <th class="p-5 text-left">
                    Action
                </th>

            </tr>

        </thead>

        <tbody>

            @forelse($products as $product)

            <tr class="border-t">

                <td class="p-5">

                    @if($product->image)

                    <img
                    {{-- src="{{ asset('storage/'.$product->image) }}" --}}
                    src="{{ $product->image ? config('services.google_drive.image_url') . $product->image : asset('default.png') }}"
                    class="w-20 h-20 rounded-xl object-cover">

                    @endif

                </td>

                <td class="p-5 font-bold">

                    <div>{{ $product->name }}</div>
                    <div class="flex items-center gap-1.5 flex-wrap mt-1" id="badges-{{ $product->id }}">
                        <span class="badge-res-special inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-semibold bg-amber-100 text-amber-800 border border-amber-300 {{ empty($product->is_restaurant_special) ? 'hidden' : '' }}">
                            🌟 Restaurant Special
                        </span>
                        <span class="badge-todays-special inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-semibold bg-indigo-100 text-indigo-800 border border-indigo-300 {{ empty($product->is_todays_special) ? 'hidden' : '' }}">
                            ⚡ Today's Special
                        </span>
                    </div>

                </td>

                <td class="p-5">

                    {{ $product->category->name ?? '' }}

                </td>

                <td class="p-5">

                    £{{ $product->price }}

                </td>

                <td class="p-5">
                    @if(($product->product_type ?? 'veg') === 'veg')
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                            <span class="w-2 h-2 rounded-full bg-emerald-600"></span> Veg
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-rose-50 text-rose-700 border border-rose-200">
                            <span class="w-2 h-2 rounded-full bg-rose-600"></span> Non-Veg
                        </span>
                    @endif
                </td>

                {{-- Quick Select Special Column --}}
                <td class="p-5">
                    <div class="flex flex-col gap-1.5 min-w-[175px]" id="special-actions-{{ $product->id }}">
                        {{-- Today's Special Toggle --}}
                        <button type="button"
                                onclick="toggleSpecial({{ $product->id }}, 'todays', this)"
                                data-type="todays"
                                title="Click to toggle Today's Special"
                                class="quick-special-btn flex items-center justify-between gap-2 px-3 py-1.5 rounded-lg text-xs font-semibold transition border {{ !empty($product->is_todays_special) ? 'bg-indigo-600 text-white border-indigo-600 shadow-sm' : 'bg-gray-50 text-gray-700 border-gray-200 hover:border-indigo-400 hover:bg-indigo-50/50' }}">
                            <span class="flex items-center gap-1.5">
                                <span>⚡ Today's Special</span>
                            </span>
                            <span class="status-indicator text-[10.5px] px-1.5 py-0.5 rounded font-bold {{ !empty($product->is_todays_special) ? 'bg-white/20 text-white' : 'bg-gray-200 text-gray-600' }}">
                                {{ !empty($product->is_todays_special) ? 'ON' : 'OFF' }}
                            </span>
                        </button>

                        {{-- Restaurant's Special Toggle --}}
                        <button type="button"
                                onclick="toggleSpecial({{ $product->id }}, 'restaurant', this)"
                                data-type="restaurant"
                                title="Click to toggle Restaurant Special"
                                class="quick-special-btn flex items-center justify-between gap-2 px-3 py-1.5 rounded-lg text-xs font-semibold transition border {{ !empty($product->is_restaurant_special) ? 'bg-amber-500 text-white border-amber-500 shadow-sm' : 'bg-gray-50 text-gray-700 border-gray-200 hover:border-amber-400 hover:bg-amber-50/50' }}">
                            <span class="flex items-center gap-1.5">
                                <span>🌟 Rest. Special</span>
                            </span>
                            <span class="status-indicator text-[10.5px] px-1.5 py-0.5 rounded font-bold {{ !empty($product->is_restaurant_special) ? 'bg-white/20 text-white' : 'bg-gray-200 text-gray-600' }}">
                                {{ !empty($product->is_restaurant_special) ? 'ON' : 'OFF' }}
                            </span>
                        </button>
                    </div>
                </td>

                <td class="p-5">
                        @if($product->allergies->count())
                            <div class="mb-2 text-xs">
                                <strong>Allergy:</strong>
                                {{ $product->allergies->pluck('allergy')->join(', ') }}
                            </div>
                        @endif

                        @if($product->dietaries->count())
                            <div class="text-xs">
                                <strong>Dietary:</strong>
                                {{ $product->dietaries->pluck('dietary')->join(', ') }}
                            </div>
                        @endif

                        @if(!$product->allergies->count() && !$product->dietaries->count())
                            <span class="text-gray-400">-</span>
                        @endif
                </td>

                <td class="p-5">

                    @if($product->status == 1)

                    <span
                    class="bg-green-100 text-green-700 px-4 py-1 rounded-full">

                        Active

                    </span>

                    @else

                    <span
                    class="bg-red-100 text-red-700 px-4 py-1 rounded-full">

                        Inactive

                    </span>

                    @endif

                </td>

                <td class="p-5 flex gap-3">

                    <a href="/restaurant/products/{{ $product->id }}/edit"
                    class="bg-yellow-500 text-white px-4 py-2 rounded-lg">

                        Edit

                    </a>

                    {{-- <a href="{{ route('restaurant.addons.index') }}"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg">
                        Addons
                    </a> --}}

                    <form method="POST"
                    action="/restaurant/products/{{ $product->id }}">

                        @csrf
                        @method('DELETE')

                        <button
                        class="bg-red-500 text-white px-4 py-2 rounded-lg">

                            Delete

                        </button>

                    </form>

                </td>

            </tr>

            @empty

            <tr>

                <td colspan="9"
                class="text-center py-20 text-gray-500">

                    No Products Found

                </td>

            </tr>

            @endforelse

        </tbody>

    </table>

</div>

<div class="mt-6">
    {{ $products->links() }}
</div>

{{-- Toast Notification Container --}}
<div id="quickToast" class="fixed bottom-6 right-6 z-50 transform transition-all duration-300 translate-y-20 opacity-0 pointer-events-none flex items-center gap-3 bg-gray-900 text-white px-5 py-3.5 rounded-xl shadow-2xl text-sm font-semibold">
    <span id="quickToastIcon">✓</span>
    <span id="quickToastMessage">Updated successfully</span>
</div>

<script>
let toastTimeout;

function showQuickToast(msg, isError = false) {
    const toast = document.getElementById('quickToast');
    const msgEl = document.getElementById('quickToastMessage');
    const iconEl = document.getElementById('quickToastIcon');

    if (!toast || !msgEl) return;

    clearTimeout(toastTimeout);

    msgEl.textContent = msg;
    iconEl.textContent = isError ? '⚠️' : '✓';
    toast.className = `fixed bottom-6 right-6 z-50 transform transition-all duration-300 translate-y-0 opacity-100 flex items-center gap-3 ${isError ? 'bg-red-600' : 'bg-gray-900'} text-white px-5 py-3.5 rounded-xl shadow-2xl text-sm font-semibold`;

    toastTimeout = setTimeout(() => {
        toast.className = 'fixed bottom-6 right-6 z-50 transform transition-all duration-300 translate-y-20 opacity-0 pointer-events-none flex items-center gap-3 bg-gray-900 text-white px-5 py-3.5 rounded-xl shadow-2xl text-sm font-semibold';
    }, 2800);
}

function toggleSpecial(productId, type, btn) {
    btn.disabled = true;
    btn.style.opacity = '0.6';

    fetch(`/restaurant/products/${productId}/toggle-special`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
        body: JSON.stringify({ type: type })
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            const indicator = btn.querySelector('.status-indicator');
            const badgesWrap = document.getElementById(`badges-${productId}`);

            if (type === 'todays') {
                if (data.status) {
                    btn.className = 'quick-special-btn flex items-center justify-between gap-2 px-3 py-1.5 rounded-lg text-xs font-semibold transition border bg-indigo-600 text-white border-indigo-600 shadow-sm';
                    if (indicator) {
                        indicator.className = 'status-indicator text-[10.5px] px-1.5 py-0.5 rounded font-bold bg-white/20 text-white';
                        indicator.textContent = 'ON';
                    }
                    badgesWrap?.querySelector('.badge-todays-special')?.classList.remove('hidden');
                } else {
                    btn.className = 'quick-special-btn flex items-center justify-between gap-2 px-3 py-1.5 rounded-lg text-xs font-semibold transition border bg-gray-50 text-gray-700 border-gray-200 hover:border-indigo-400 hover:bg-indigo-50/50';
                    if (indicator) {
                        indicator.className = 'status-indicator text-[10.5px] px-1.5 py-0.5 rounded font-bold bg-gray-200 text-gray-600';
                        indicator.textContent = 'OFF';
                    }
                    badgesWrap?.querySelector('.badge-todays-special')?.classList.add('hidden');
                }
            } else if (type === 'restaurant') {
                if (data.status) {
                    btn.className = 'quick-special-btn flex items-center justify-between gap-2 px-3 py-1.5 rounded-lg text-xs font-semibold transition border bg-amber-500 text-white border-amber-500 shadow-sm';
                    if (indicator) {
                        indicator.className = 'status-indicator text-[10.5px] px-1.5 py-0.5 rounded font-bold bg-white/20 text-white';
                        indicator.textContent = 'ON';
                    }
                    badgesWrap?.querySelector('.badge-res-special')?.classList.remove('hidden');
                } else {
                    btn.className = 'quick-special-btn flex items-center justify-between gap-2 px-3 py-1.5 rounded-lg text-xs font-semibold transition border bg-gray-50 text-gray-700 border-gray-200 hover:border-amber-400 hover:bg-amber-50/50';
                    if (indicator) {
                        indicator.className = 'status-indicator text-[10.5px] px-1.5 py-0.5 rounded font-bold bg-gray-200 text-gray-600';
                        indicator.textContent = 'OFF';
                    }
                    badgesWrap?.querySelector('.badge-res-special')?.classList.add('hidden');
                }
            }
            showQuickToast(data.message);
        } else {
            showQuickToast(data.message || 'Failed to update', true);
        }
    })
    .catch(err => {
        console.error(err);
        showQuickToast('Error updating status', true);
    })
    .finally(() => {
        btn.disabled = false;
        btn.style.opacity = '1';
    });
}
</script>
@endsection