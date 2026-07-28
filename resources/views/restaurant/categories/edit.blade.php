@extends('layouts.app')
@section('content')
<div class="p-8 max-w-2xl">
  <div class="flex justify-between items-center mb-6">
    <div>
      <h1 class="text-2xl font-medium">Edit category</h1>
      <p class="text-sm text-gray-500 mt-1">Update category details</p>
    </div>
    <a href="{{ route('restaurant.categories.index') }}" class="inline-flex items-center gap-2 bg-gray-900 text-white px-4 py-2 rounded-lg text-sm font-medium">← Back</a>
  </div>

  <div class="bg-white border border-gray-100 rounded-xl p-6">
    <form method="POST" action="{{ route('restaurant.categories.update',$category->id) }}" enctype="multipart/form-data">
      @csrf @method('PUT')

      <div class="mb-4">
        <label class="block text-xs uppercase tracking-wide text-gray-400 font-medium mb-2">Category name</label>
        <input type="text" name="name" value="{{ $category->name }}" class="w-full border border-gray-200 rounded-lg p-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
      </div>

      <div class="mb-4">
        <label class="block text-xs uppercase tracking-wide text-gray-400 font-medium mb-2">Parent category</label>
        <select name="parent_id" class="w-full border border-gray-200 rounded-lg p-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
          <option value="">Main category (none)</option>
          @foreach($categories as $cat)
          <option value="{{ $cat->id }}" {{ $category->parent_id==$cat->id?'selected':'' }}>{{ $cat->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="mb-4">
    <label class="block text-xs uppercase tracking-wide text-gray-400 font-medium mb-2">
        Display Order
    </label>

    <input type="number"
           name="display_order"
           value="{{ $category->display_order }}"
           min="1"
           class="w-full border border-gray-200 rounded-lg p-3 text-sm">

    <p class="text-xs text-gray-400 mt-1">
        Leave blank to show at the end.
    </p>
</div>

      <div class="mb-4">
        <label class="block text-xs uppercase tracking-wide text-gray-400 font-medium mb-2">Category image</label>
        @if($category->image)
        <div class="flex items-center gap-3 mb-3">
          <img src="{{ asset($category->image) }}" class="w-14 h-14 object-cover rounded-lg border border-gray-100">
          <span class="text-xs text-gray-400">Current image · Upload new to replace</span>
        </div>
        @endif
        <div class="border border-dashed border-gray-200 rounded-lg p-4 bg-gray-50">
          <input type="file" name="image" class="text-sm text-gray-500">
        </div>
      </div>

      <div class="mb-4">
        <label class="block text-xs uppercase tracking-wide text-gray-400 font-medium mb-2">Status</label>
        <div class="grid grid-cols-2 gap-3">
          <label class="flex items-center gap-3 border rounded-xl p-3 cursor-pointer {{ $category->status ? 'border-green-400 bg-green-50' : 'border-gray-200' }}">
            <input type="radio" name="status" value="1" {{ $category->status ? 'checked' : '' }} class="accent-green-500">
            <div>
              <div class="text-sm font-medium text-green-800">Active</div>
              <div class="text-xs text-green-500">Visible to customers</div>
            </div>
          </label>
          <label class="flex items-center gap-3 border rounded-xl p-3 cursor-pointer {{ !$category->status ? 'border-yellow-400 bg-yellow-50' : 'border-gray-200' }}">
            <input type="radio" name="status" value="0" {{ !$category->status ? 'checked' : '' }} class="accent-yellow-500">
            <div>
              <div class="text-sm font-medium text-yellow-800">Inactive</div>
              <div class="text-xs text-yellow-500">Hidden from customers</div>
            </div>
          </label>
        </div>
      </div>

      <div class="flex justify-between items-center mt-6 pt-5 border-t border-gray-100">
        <a href="{{ route('restaurant.categories.index') }}" class="text-sm text-gray-500 hover:text-gray-700">Discard changes</a>
        <button class="inline-flex items-center gap-2 bg-blue-500 hover:bg-blue-600 text-white px-5 py-2.5 rounded-lg text-sm font-medium">✓ Update category</button>
      </div>
    </form>
  </div>
</div>
@endsection