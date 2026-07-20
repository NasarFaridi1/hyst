@extends('layouts.app')
@section('content')
<div class="p-8 max-w-4xl">
  <div class="flex justify-between items-center mb-6">
    <div>
      <h1 class="text-2xl font-medium">Add product</h1>
      <p class="text-sm text-gray-500 mt-1">Fill in the product details below</p>
    </div>
    <a href="{{ route('admin.products.index') }}" class="inline-flex items-center gap-2 bg-gray-900 text-white px-4 py-2 rounded-lg text-sm font-medium">← Back</a>
  </div>

  <div class="bg-white border border-gray-100 rounded-xl p-6">
    <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
      @csrf
      <div class="grid grid-cols-2 gap-4">
        <div>
          <label class="block text-xs uppercase tracking-wide text-gray-400 font-medium mb-2">Product name</label>
          <input type="text" name="name" class="w-full border border-gray-200 rounded-lg p-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div>
          <label class="block text-xs uppercase tracking-wide text-gray-400 font-medium mb-2">Price (£)</label>
          <input type="number" name="price" step="0.01" class="w-full border border-gray-200 rounded-lg p-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div>
          <label class="block text-xs uppercase tracking-wide text-gray-400 font-medium mb-2">Restaurant</label>
          <select name="restaurant_id" class="w-full border border-gray-200 rounded-lg p-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">Select restaurant</option>
            @foreach($restaurants as $r)<option value="{{ $r->id }}">{{ $r->name }}</option>@endforeach
          </select>
        </div>
        <!-- <div>
          <label class="block text-xs uppercase tracking-wide text-gray-400 font-medium mb-2">Vendor</label>
          <select name="vendor_id" class="w-full border border-gray-200 rounded-lg p-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">Select vendor</option>
            @foreach($vendors as $v)<option value="{{ $v->id }}">{{ $v->name }}</option>@endforeach
          </select>
        </div> -->
        <div>
          <label class="block text-xs uppercase tracking-wide text-gray-400 font-medium mb-2">Category</label>
          <select name="category_id" class="w-full border border-gray-200 rounded-lg p-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">Select category</option>
            @foreach($categories as $c)<option value="{{ $c->id }}">{{ $c->name }}</option>@endforeach
          </select>
        </div>
      </div>

      <div class="mt-4">
        <label class="block text-xs uppercase tracking-wide text-gray-400 font-medium mb-2">Description</label>
        <textarea name="description" rows="4" class="w-full border border-gray-200 rounded-lg p-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
      </div>

      <div class="mt-4">
        <label class="block text-xs uppercase tracking-wide text-gray-400 font-medium mb-2">Product image</label>
        <div class="border border-dashed border-gray-200 rounded-lg p-4 bg-gray-50">
          <input type="file" name="image" class="text-sm text-gray-500">
          <p class="text-xs text-gray-400 mt-1">JPG, PNG or WebP · Max 2MB</p>
        </div>
      </div>

      <div class="flex justify-between items-center mt-6 pt-5 border-t border-gray-100">
        <a href="{{ route('admin.products.index') }}" class="text-sm text-gray-500 hover:text-gray-700">Cancel</a>
        <button class="inline-flex items-center gap-2 bg-green-500 hover:bg-green-600 text-white px-5 py-2.5 rounded-lg text-sm font-medium">✓ Save product</button>
      </div>
    </form>
  </div>
</div>
@endsection