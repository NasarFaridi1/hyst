@extends('layouts.app')

@section('content')

<style>
    body { font-family: 'Poppins', sans-serif; }
    .hyst-page { background: #F5F0E8; min-height: 100vh; padding: 2rem 1.5rem; }
    .page-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:1.75rem; gap:1rem; flex-wrap:wrap; }
    .page-title { font-size:22px; font-weight:800; color:#0D0D0D; margin:0 0 3px; letter-spacing:-0.3px; }
    .page-sub { font-size:13px; color:#999; margin:0; }
    .btn-back { display:inline-flex; align-items:center; gap:7px; background:#fff; color:#555; font-family:'Poppins',sans-serif; font-size:13.5px; font-weight:600; border:1.5px solid #EBE5DE; border-radius:12px; padding:10px 18px; cursor:pointer; text-decoration:none; transition:border-color 0.16s,color 0.16s; }
    .btn-back:hover { border-color:#C25A2A; color:#C25A2A; }

    .hyst-card { background:#fff; border-radius:20px; box-shadow:0 4px 30px rgba(194,90,42,0.09),0 1px 4px rgba(0,0,0,0.05); overflow:hidden; }

    .card-head { padding:1.4rem 1.75rem; border-bottom:1.5px solid #F0EAE2; display:flex; align-items:center; gap:12px; }
    .card-head-icon { width:38px; height:38px; background:#FDF0E8; border-radius:10px; display:flex; align-items:center; justify-content:center; color:#C25A2A; flex-shrink:0; }
    .card-head-title { font-size:15px; font-weight:700; color:#0D0D0D; margin:0; }
    .card-head-sub { font-size:12px; color:#AAA; margin:2px 0 0; }

    .card-body { padding:1.75rem; }

    .form-grid { display:grid; grid-template-columns:1fr 1fr; gap:1.25rem; }
    .form-group { display:flex; flex-direction:column; gap:6px; }
    .form-group.full { grid-column:1/-1; }

    .field-label { font-size:11px; font-weight:700; color:#555; letter-spacing:0.07em; text-transform:uppercase; }

    .field-wrap { position:relative; }
    .field-icon { position:absolute; left:13px; top:50%; transform:translateY(-50%); color:#C25A2A; pointer-events:none; display:flex; align-items:center; }
    .field-icon-top { position:absolute; left:13px; top:14px; color:#C25A2A; pointer-events:none; display:flex; align-items:center; }

    .field-input, .field-select {
        width:100%; border:1.5px solid #EBE5DE;
        padding:12px 14px 12px 40px; border-radius:12px;
        font-family:'Poppins',sans-serif; font-size:14px;
        color:#0D0D0D; background:#FDFAF7; outline:none;
        box-sizing:border-box; transition:border-color 0.18s,background 0.18s;
        -webkit-appearance:none; appearance:none;
    }
    .field-input::placeholder { color:#BFBAB3; }
    .field-input:focus, .field-select:focus { border-color:#C25A2A; background:#fff; }

    .field-select {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='14' viewBox='0 0 24 24' fill='none' stroke='%23C25A2A' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
        background-repeat:no-repeat; background-position:right 13px center;
        padding-right:36px;
    }

    .field-textarea {
        width:100%; border:1.5px solid #EBE5DE;
        padding:12px 14px 12px 40px; border-radius:12px;
        font-family:'Poppins',sans-serif; font-size:14px;
        color:#0D0D0D; background:#FDFAF7; outline:none;
        box-sizing:border-box; resize:vertical; min-height:110px;
        transition:border-color 0.18s,background 0.18s;
    }
    .field-textarea::placeholder { color:#BFBAB3; }
    .field-textarea:focus { border-color:#C25A2A; background:#fff; }

    .file-zone {
        border:1.5px dashed #D8CECC; border-radius:12px;
        padding:1.1rem 1.25rem; background:#FDFAF7;
        transition:border-color 0.18s,background 0.18s;
        display:flex; align-items:center; gap:10px; cursor:pointer;
        position:relative;
    }
    .file-zone:hover { border-color:#C25A2A; background:#FDF8F5; }
    .file-zone input[type=file] { position:absolute; inset:0; opacity:0; cursor:pointer; width:100%; height:100%; }
    .file-zone-icon { width:36px; height:36px; background:#F5F0E8; border-radius:9px; display:flex; align-items:center; justify-content:center; color:#C25A2A; flex-shrink:0; }
    .file-zone-text { font-size:13px; color:#AAA; font-weight:500; line-height:1.4; }
    .file-zone-text span { color:#C25A2A; font-weight:700; }
    .file-zone-text small { display:block; font-size:11px; color:#CCC; }

    .form-divider { height:1.5px; background:#F0EAE2; grid-column:1/-1; margin:0.25rem 0; }

    .form-footer { padding:1.25rem 1.75rem; border-top:1.5px solid #F0EAE2; display:flex; align-items:center; justify-content:flex-end; gap:12px; }

    .btn-submit { display:inline-flex; align-items:center; gap:8px; background:#C25A2A; color:#fff; font-family:'Poppins',sans-serif; font-size:14px; font-weight:700; border:none; border-radius:12px; padding:13px 28px; cursor:pointer; transition:background 0.16s,transform 0.12s; }
    .btn-submit:hover { background:#A84B22; transform:scale(1.01); }

    .btn-cancel { display:inline-flex; align-items:center; gap:7px; background:#F5F0E8; color:#888; font-family:'Poppins',sans-serif; font-size:13.5px; font-weight:600; border:1.5px solid #EBE5DE; border-radius:12px; padding:12px 20px; cursor:pointer; text-decoration:none; transition:border-color 0.16s,color 0.16s; }
    .btn-cancel:hover { border-color:#C25A2A; color:#C25A2A; }
</style>

<div class="hyst-page">
<div class="max-w-4xl mx-auto">

    {{-- Page Header --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Add Product</h1>
            <p class="page-sub">Add a new menu item to {{ $restaurant->name }}</p>
        </div>
        <a href="{{ route('ambassador.products.index',$restaurant->id) }}" class="btn-back">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
            Back
        </a>
    </div>

    <div class="hyst-card">

        <div class="card-head">
            <div class="card-head-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
            </div>
            <div>
                <p class="card-head-title">Product Details</p>
                <p class="card-head-sub">Fill in the information below to add a new product</p>
            </div>
        </div>

        <form method="POST" enctype="multipart/form-data" action="{{ route('ambassador.products.store',$restaurant->id) }}">
            @csrf

            <div class="card-body">
                <div class="form-grid">

                    {{-- Category --}}
                    <div class="form-group">
                        <label class="field-label">Category</label>
                        <div class="field-wrap">
                            <span class="field-icon">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
                            </span>
                            <select name="category_id" class="field-select">
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id')==$category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Product Name --}}
                    <div class="form-group">
                        <label class="field-label">Product Name</label>
                        <div class="field-wrap">
                            <span class="field-icon">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 7H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                            </span>
                            <input type="text" name="name" value="{{ old('name') }}" placeholder="e.g. Grilled Chicken Burger" class="field-input">
                        </div>
                    </div>

                    {{-- Price --}}
                    <div class="form-group">
                        <label class="field-label">Price (£)</label>
                        <div class="field-wrap">
                            <span class="field-icon">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                            </span>
                            <input type="number" step="0.01" name="price" value="{{ old('price') }}" placeholder="0.00" class="field-input">
                        </div>
                    </div>

                    {{-- Status --}}
                    <div class="form-group">
                        <label class="field-label">Status</label>
                        <div class="field-wrap">
                            <span class="field-icon">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                            </span>
                            <select name="status" class="field-select">
                                <option value="1" {{ old('status')=='1' ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ old('status')=='0' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-divider"></div>

                    {{-- Description --}}
                    <div class="form-group full">
                        <label class="field-label">Description</label>
                        <div class="field-wrap">
                            <span class="field-icon-top">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="17" y1="10" x2="3" y2="10"/><line x1="21" y1="6" x2="3" y2="6"/><line x1="21" y1="14" x2="3" y2="14"/><line x1="17" y1="18" x2="3" y2="18"/></svg>
                            </span>
                            <textarea name="description" placeholder="Describe the product — ingredients, taste, portion size…" class="field-textarea">{{ old('description') }}</textarea>
                        </div>
                    </div>

                    {{-- Image Upload --}}
                    <div class="form-group full">
                        <label class="field-label">Product Image</label>
                        <label class="file-zone">
                            <input type="file" name="image" accept="image/*" onchange="previewFile(this,'img-preview-create')">
                            <div class="file-zone-icon">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                            </div>
                            <div class="file-zone-text">
                                <span>Choose file</span> or drag &amp; drop here
                                <small>PNG, JPG, WEBP — max 2MB</small>
                            </div>
                            <img id="img-preview-create" src="" alt="" style="display:none; width:56px; height:56px; border-radius:10px; object-fit:cover; border:1.5px solid #EBE5DE; margin-left:auto; flex-shrink:0;">
                        </label>
                    </div>

                </div>
            </div>

            <div class="form-footer">
                <a href="{{ route('ambassador.products.index',$restaurant->id) }}" class="btn-cancel">Cancel</a>
                <button type="submit" class="btn-submit">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                    Save Product
                </button>
            </div>

        </form>
    </div>
</div>
</div>

<script>
function previewFile(input, previewId) {
    var preview = document.getElementById(previewId);
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

@endsection