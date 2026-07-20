@extends('layouts.app')
@section('content')
<div class="p-8">
  <div class="flex justify-between items-center mb-6">
    <div>
      <h1 class="text-2xl font-medium">Categories</h1>
      <p class="text-sm text-gray-500 mt-1">Manage your food categories</p>
    </div>
    <a href="{{ route('restaurant.categories.create') }}" class="inline-flex items-center gap-2 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium">+ Add category</a>
  </div>

  <div class="bg-white border border-gray-100 rounded-xl overflow-x-auto">
    <table class="w-full">
      <thead>
        <tr class="bg-gray-50 border-b border-gray-100">
          <th class="text-left px-4 py-3 text-xs uppercase tracking-wide text-gray-400 font-medium">Image</th>
          <th class="text-left px-4 py-3 text-xs uppercase tracking-wide text-gray-400 font-medium">Name</th>
          <th class="text-left px-4 py-3 text-xs uppercase tracking-wide text-gray-400 font-medium">Parent</th>
          <th class="text-left px-4 py-3 text-xs uppercase tracking-wide text-gray-400 font-medium">Display Order</th>
          <th class="text-left px-4 py-3 text-xs uppercase tracking-wide text-gray-400 font-medium">Status</th>
          <th class="text-left px-4 py-3 text-xs uppercase tracking-wide text-gray-400 font-medium">Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($categories as $category)
        <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
          <td class="px-4 py-3">
            @if($category->image)
            <img src="{{ asset('storage/'.$category->image) }}" class="w-11 h-11 object-cover rounded-lg border border-gray-100">
            @else
            <div class="w-11 h-11 rounded-lg bg-gray-100 flex items-center justify-center text-gray-400 text-xs">None</div>
            @endif
          </td>
          <td class="px-4 py-3 font-medium text-sm">{{ $category->name }}</td>
          <td class="px-4 py-3 text-sm text-gray-500">{{ $category->parent->name ?? '—' }}</td>
          <td class="px-4 py-3 text-sm text-gray-500">{{ $category->display_order ?? '—' }}</td>
          <td class="px-4 py-3">
            @if($category->status)
            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800"><span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>Active</span>
            @else
            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800"><span class="w-1.5 h-1.5 rounded-full bg-yellow-500"></span>Inactive</span>
            @endif
          </td>
          <td class="px-4 py-3">
            <a href="{{ route('restaurant.categories.edit',$category->id) }}" class="inline-flex items-center gap-1 bg-yellow-100 text-yellow-800 px-3 py-1 rounded-lg text-xs font-medium mr-1">Edit</a>
            <form method="POST" action="{{ route('restaurant.categories.destroy',$category->id) }}" class="inline">
              @csrf @method('DELETE')
              <button class="inline-flex items-center gap-1 bg-red-100 text-red-800 px-3 py-1 rounded-lg text-xs font-medium" onclick="return confirm('Delete this category?')">Delete</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection