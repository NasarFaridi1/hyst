@extends('layouts.app')
@section('content')
<div class="p-8 max-w-4xl">
  <div class="flex justify-between items-center mb-6">
    <div>
      <h1 class="text-2xl font-medium">Edit product</h1>
      <p class="text-sm text-gray-500 mt-1">Update product details</p>
    </div>
    <a href="{{ route('admin.products.index') }}" class="inline-flex items-center gap-2 bg-gray-900 text-white px-4 py-2 rounded-lg text-sm font-medium">← Back</a>
  </div>

  <div class="bg-white border border-gray-100 rounded-xl p-6">
    <form method="POST" action="{{ route('admin.products.update',$product->id) }}" enctype="multipart/form-data">
      @csrf @method('PUT')
      <div class="grid grid-cols-2 gap-4">
        <div>
          <label class="block text-xs uppercase tracking-wide text-gray-400 font-medium mb-2">Product name</label>
          <input type="text" name="name" value="{{ $product->name }}" class="w-full border border-gray-200 rounded-lg p-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div>
          <label class="block text-xs uppercase tracking-wide text-gray-400 font-medium mb-2">Price (£)</label>
          <input type="number" name="price" step="0.01" value="{{ $product->price }}" class="w-full border border-gray-200 rounded-lg p-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <!-- <div>
          <label class="block text-xs uppercase tracking-wide text-gray-400 font-medium mb-2">Vendor</label>
          <select name="vendor_id" class="w-full border border-gray-200 rounded-lg p-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            @foreach($vendors as $v)
            <option value="{{ $v->id }}" {{ $product->vendor_id==$v->id?'selected':'' }}>{{ $v->name }}</option>
            @endforeach
          </select>
        </div> -->

         <div>
          <label class="block text-xs uppercase tracking-wide text-gray-400 font-medium mb-2">Category</label>
          <select name="category_id" class="w-full border border-gray-200 rounded-lg p-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">Select category</option>
            
            @foreach($categories as $c)
            <option value="{{ $c->id }}" {{ $product->category_id==$c->id?'selected':'' }}>{{ $c->name }}</option>

            @endforeach
          </select>
        </div>
      </div>

      <div class="mt-4">
        <label class="block text-xs uppercase tracking-wide text-gray-400 font-medium mb-2">Description</label>
        <textarea name="description" rows="4" class="w-full border border-gray-200 rounded-lg p-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">{{ $product->description }}</textarea>
      </div>

      <div class="mt-4">
        <label class="block text-xs uppercase tracking-wide text-gray-400 font-medium mb-2">Product image</label>
        <div class="flex items-center gap-3 mb-3">
          <img
           {{-- src="{{ asset('storage/'.$product->image) }}"  --}}
           src="{{ config('services.google_drive.image_url') . $product->image }}"
          class="w-14 h-14 object-cover rounded-lg border border-gray-100">
          <span class="text-xs text-gray-400">Current image · Upload new to replace</span>
        </div>
        <div class="border border-dashed border-gray-200 rounded-lg p-4 bg-gray-50">
          <input type="file" name="image" class="text-sm text-gray-500">
        </div>
      </div>

      <div class="flex justify-between items-center mt-6 pt-5 border-t border-gray-100">
        <a href="{{ route('admin.products.index') }}" class="text-sm text-gray-500 hover:text-gray-700">Discard changes</a>
        <button class="inline-flex items-center gap-2 bg-blue-500 hover:bg-blue-600 text-white px-5 py-2.5 rounded-lg text-sm font-medium">✓ Update product</button>
      </div>
    </form>
  </div>
</div>
@endsection