@extends('layouts.app')

@section('content')

<style>
    body { font-family: 'Poppins', sans-serif; }

    .hyst-page { background: #F5F0E8; min-height: 100vh; padding: 2rem 1.5rem; }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1.75rem;
        gap: 1rem;
        flex-wrap: wrap;
    }
    .page-title { font-size: 22px; font-weight: 800; color: #0D0D0D; margin: 0 0 3px; letter-spacing: -0.3px; }
    .page-sub { font-size: 13px; color: #999; margin: 0; font-weight: 400; }

    .btn-add {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        background: #C25A2A;
        color: #fff;
        font-family: 'Poppins', sans-serif;
        font-size: 13.5px;
        font-weight: 700;
        border: none;
        border-radius: 12px;
        padding: 11px 20px;
        cursor: pointer;
        text-decoration: none;
        transition: background 0.16s, transform 0.12s;
        white-space: nowrap;
    }
    .btn-add:hover { background: #A84B22; transform: scale(1.01); color: #fff; }

    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        background: #fff;
        color: #555;
        font-family: 'Poppins', sans-serif;
        font-size: 13.5px;
        font-weight: 600;
        border: 1.5px solid #EBE5DE;
        border-radius: 12px;
        padding: 10px 18px;
        cursor: pointer;
        text-decoration: none;
        transition: border-color 0.16s, color 0.16s;
        white-space: nowrap;
    }
    .btn-back:hover { border-color: #C25A2A; color: #C25A2A; }

    .hyst-card {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 4px 30px rgba(194,90,42,0.09), 0 1px 4px rgba(0,0,0,0.05);
        overflow: hidden;
    }

    .search-bar {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 1.25rem 1.5rem;
        border-bottom: 1.5px solid #F0EAE2;
        flex-wrap: wrap;
    }
    .search-wrap {
        position: relative;
        flex: 1;
        min-width: 220px;
        max-width: 360px;
    }
    .search-icon {
        position: absolute;
        left: 13px;
        top: 50%;
        transform: translateY(-50%);
        color: #C25A2A;
        display: flex;
        align-items: center;
        pointer-events: none;
    }
    .search-input {
        width: 100%;
        border: 1.5px solid #EBE5DE;
        padding: 10px 14px 10px 40px;
        border-radius: 10px;
        font-family: 'Poppins', sans-serif;
        font-size: 13.5px;
        color: #0D0D0D;
        background: #FDFAF7;
        outline: none;
        box-sizing: border-box;
        transition: border-color 0.18s;
    }
    .search-input::placeholder { color: #BFBAB3; }
    .search-input:focus { border-color: #C25A2A; background: #fff; }

    .btn-search {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #C25A2A;
        color: #fff;
        font-family: 'Poppins', sans-serif;
        font-size: 13px;
        font-weight: 600;
        border: none;
        border-radius: 10px;
        padding: 10px 18px;
        cursor: pointer;
        transition: background 0.16s;
    }
    .btn-search:hover { background: #A84B22; }

    .btn-reset {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #F5F0E8;
        color: #888;
        font-family: 'Poppins', sans-serif;
        font-size: 13px;
        font-weight: 600;
        border: 1.5px solid #EBE5DE;
        border-radius: 10px;
        padding: 10px 16px;
        cursor: pointer;
        text-decoration: none;
        transition: border-color 0.16s, color 0.16s;
    }
    .btn-reset:hover { border-color: #C25A2A; color: #C25A2A; }

    .hyst-table { width: 100%; border-collapse: collapse; }
    .hyst-table thead tr { background: #FDF5F0; }
    .hyst-table th {
        padding: 12px 16px;
        font-size: 11px;
        font-weight: 700;
        color: #C25A2A;
        text-transform: uppercase;
        letter-spacing: 0.07em;
        text-align: left;
        border-bottom: 2px solid #F0EAE2;
    }
    .hyst-table th.center { text-align: center; }
    .hyst-table td {
        padding: 13px 16px;
        font-size: 13.5px;
        color: #333;
        border-bottom: 1px solid #F5F0E8;
        vertical-align: middle;
    }
    .hyst-table tbody tr:last-child td { border-bottom: none; }
    .hyst-table tbody tr:hover { background: #FDFAF7; }

    .product-img {
        width: 48px;
        height: 48px;
        border-radius: 10px;
        object-fit: cover;
        border: 1.5px solid #EBE5DE;
    }
    .img-placeholder {
        width: 48px;
        height: 48px;
        border-radius: 10px;
        background: #F5F0E8;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #C25A2A;
        border: 1.5px solid #EBE5DE;
    }

    .product-name { font-weight: 700; color: #0D0D0D; font-size: 13.5px; }
    .product-desc { font-size: 12px; color: #999; margin-top: 2px; }

    .price-tag {
        display: inline-flex;
        align-items: center;
        gap: 2px;
        font-weight: 700;
        font-size: 13.5px;
        color: #C25A2A;
    }

    .cat-chip {
        display: inline-flex;
        align-items: center;
        background: #F5F0E8;
        color: #888;
        border-radius: 6px;
        padding: 3px 9px;
        font-size: 12px;
        font-weight: 500;
    }

    .badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11.5px;
        font-weight: 600;
    }
    .badge-active   { background: #E8F7EF; color: #1F8F55; }
    .badge-inactive { background: #FEF0EE; color: #D94F3D; }

    .action-group { display: flex; gap: 6px; justify-content: center; flex-wrap: wrap; }

    .btn-action {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-family: 'Poppins', sans-serif;
        font-size: 12px;
        font-weight: 600;
        border: none;
        border-radius: 8px;
        padding: 7px 13px;
        cursor: pointer;
        text-decoration: none;
        transition: opacity 0.15s, transform 0.12s;
        white-space: nowrap;
    }
    .btn-action:hover { opacity: 0.88; transform: scale(1.03); }
    .btn-edit { background: #FFF3E0; color: #D97706; }
    .btn-del  { background: #FEF2F2; color: #DC2626; }

    .empty-state {
        text-align: center;
        padding: 3.5rem 1rem;
    }
    .empty-state-icon {
        width: 56px; height: 56px;
        background: #F5F0E8;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        color: #C25A2A;
    }
    .empty-state p { font-size: 14px; font-weight: 500; color: #999; }

    .pagination-wrap { padding: 1.25rem 1.5rem; border-top: 1.5px solid #F0EAE2; }
</style>

<div class="hyst-page">
<div class="max-w-7xl mx-auto">

    {{-- Page Header --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">{{ $restaurant->name }} — Products</h1>
            <p class="page-sub">Manage menu items for this restaurant</p>
        </div>
        <div style="display:flex; gap:10px; flex-wrap:wrap;">
            <a href="{{ route('ambassador.restaurants.index') }}" class="btn-back">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                Back
            </a>
            <a href="{{ route('ambassador.products.create',$restaurant->id) }}" class="btn-add">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Add Product
            </a>
        </div>
    </div>

    {{-- Card --}}
    <div class="hyst-card">

        {{-- Search --}}
        <form method="GET" class="search-bar">
            <div class="search-wrap">
                <span class="search-icon">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                </span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search product by name..." class="search-input">
            </div>
            <button type="submit" class="btn-search">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                Search
            </button>
            @if(request('search'))
                <a href="{{ route('ambassador.products.index', $restaurant->id) }}" class="btn-reset">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    Reset
                </a>
            @endif
        </form>

        {{-- Table --}}
        <table class="hyst-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Image</th>
                    <th>Product</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th class="center">Actions</th>
                </tr>
            </thead>
            <tbody>
            @forelse($products as $i => $product)
                <tr>
                    <td style="color:#BBB; font-size:12px; font-weight:600;">{{ $products->firstItem() + $i }}</td>
                    <td>
                        @if($product->image)
                            <img src="{{ asset('storage/'.$product->image) }}" class="product-img">
                        @else
                            <div class="img-placeholder">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                            </div>
                        @endif
                    </td>
                    <td>
                        <div class="product-name">{{ $product->name }}</div>
                        <div class="product-desc">{{ Str::limit($product->description, 42) }}</div>
                    </td>
                    <td>
                        @if(optional($product->category)->name)
                            <span class="cat-chip">{{ $product->category->name }}</span>
                        @else
                            <span style="color:#CCC; font-size:12px;">—</span>
                        @endif
                    </td>
                    <td>
                        <span class="price-tag">£{{ number_format($product->price, 2) }}</span>
                    </td>
                    <td>
                        @if(($product->product_type ?? 'veg') === 'veg')
                            <span class="badge badge-active" style="background:#E8F7EF; color:#1F8F55;">
                                🟢 Veg
                            </span>
                        @else
                            <span class="badge badge-inactive" style="background:#FEF0EE; color:#D94F3D;">
                                🔴 Non-Veg
                            </span>
                        @endif
                    </td>
                    <td>
                        @if($product->status)
                            <span class="badge badge-active">
                                <svg width="8" height="8" viewBox="0 0 8 8"><circle cx="4" cy="4" r="4" fill="#1F8F55"/></svg>
                                Active
                            </span>
                        @else
                            <span class="badge badge-inactive">
                                <svg width="8" height="8" viewBox="0 0 8 8"><circle cx="4" cy="4" r="4" fill="#D94F3D"/></svg>
                                Inactive
                            </span>
                        @endif
                    </td>
                    <td>
                        <div class="action-group">
                            <a href="{{ route('ambassador.products.edit',[$restaurant->id,$product->id]) }}" class="btn-action btn-edit">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                Edit
                            </a>
                            <form action="{{ route('ambassador.products.destroy',[$restaurant->id,$product->id]) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Delete this product?')" class="btn-action btn-del">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">
                        <div class="empty-state">
                            <div class="empty-state-icon">
                                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                            </div>
                            <p>No products found{{ request('search') ? ' for "'.request('search').'"' : '' }}</p>
                        </div>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>

        {{-- Pagination --}}
        <div class="pagination-wrap">
            {{ $products->links() }}
        </div>

    </div>
</div>
</div>

@endsection