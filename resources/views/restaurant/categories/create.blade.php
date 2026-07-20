@extends('layouts.app')
@section('content')
<div class="p-8 max-w-2xl">
  <div class="flex justify-between items-center mb-6">
    <div>
      <h1 class="text-2xl font-medium">Add category</h1>
      <p class="text-sm text-gray-500 mt-1">Create a new food category</p>
    </div>
    <a href="{{ route('restaurant.categories.index') }}" class="inline-flex items-center gap-2 bg-gray-900 text-white px-4 py-2 rounded-lg text-sm font-medium">← Back</a>
  </div>

  <div class="bg-white border border-gray-100 rounded-xl p-6">
    <form method="POST" action="{{ route('restaurant.categories.store') }}" enctype="multipart/form-data">
      @csrf
      <div class="mb-4">
        <label class="block text-xs uppercase tracking-wide text-gray-400 font-medium mb-2">Category name</label>
        <input type="text" name="name" placeholder="e.g. Burgers, Desserts…" class="w-full border border-gray-200 rounded-lg p-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
      </div>
      <div class="mb-4">
        <label class="block text-xs uppercase tracking-wide text-gray-400 font-medium mb-2">Parent category</label>
        <select name="parent_id" class="w-full border border-gray-200 rounded-lg p-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
          <option value="">Main category (none)</option>
          @foreach($categories as $c)<option value="{{ $c->id }}">{{ $c->name }}</option>@endforeach
        </select>
        <p class="text-xs text-gray-400 mt-1">Leave blank to make this a top-level category</p>
      </div>
      <div class="mb-4">
    <label class="block text-xs uppercase tracking-wide text-gray-400 font-medium mb-2">
        Display Order
    </label>

    <input type="number"
           name="display_order"
           min="1"
           placeholder="1,2,3..."
           class="w-full border border-gray-200 rounded-lg p-3 text-sm">

    <p class="text-xs text-gray-400 mt-1">
        Leave blank to show at the end.
    </p>
</div>
      <div class="mb-4">
        <label class="block text-xs uppercase tracking-wide text-gray-400 font-medium mb-2">Category image</label>
        <div class="border border-dashed border-gray-200 rounded-lg p-4 bg-gray-50">
          <input type="file" name="image" class="text-sm text-gray-500">
          <p class="text-xs text-gray-400 mt-1">JPG, PNG or WebP · Max 2MB</p>
        </div>
      </div>
      <div class="flex justify-between items-center mt-6 pt-5 border-t border-gray-100">
        <a href="{{ route('restaurant.categories.index') }}" class="text-sm text-gray-500 hover:text-gray-700">Cancel</a>
        <button class="inline-flex items-center gap-2 bg-blue-500 hover:bg-blue-600 text-white px-5 py-2.5 rounded-lg text-sm font-medium">✓ Save category</button>
      </div>
    </form>
  </div>
</div>
@endsection