@extends('layouts.app')
@section('content')
<div class="p-8">

  <div class="flex justify-between items-center mb-6">
    <div>
      <h1 class="text-2xl font-medium">Products</h1>
      <p class="text-sm text-gray-500 mt-1">All products in your catalogue</p>
    </div>
    <a href="{{ route('admin.products.create') }}" class="inline-flex items-center gap-2 bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-medium">+ Add product</a>
  </div>

  <div class="bg-white border border-gray-100 rounded-xl p-4 mb-6">

      <form method="GET" action="{{ route('admin.products.index') }}">

          <div class="flex gap-3">

              <input
                  type="text"
                  name="search"
                  value="{{ request('search') }}"
                  placeholder="Search product, restaurant, category..."
                  class="flex-1 border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">

              <button
                  type="submit"
                  class="bg-green-500 hover:bg-green-600 text-white px-5 py-2 rounded-lg">

                  Search

              </button>

              @if(request('search'))
                  <a href="{{ route('admin.products.index') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded-lg">

                      Reset

                  </a>
              @endif

          </div>

      </form>

  </div>

  <div class="bg-white border border-gray-100 rounded-xl overflow-x-auto">
    <table class="w-full">
      <thead>
        <tr class="bg-gray-50 border-b border-gray-100">
          <th class="text-left px-4 py-3 text-xs uppercase tracking-wide text-gray-400 font-medium">Image</th>
          <th class="text-left px-4 py-3 text-xs uppercase tracking-wide text-gray-400 font-medium">Name</th>
          <th class="text-left px-4 py-3 text-xs uppercase tracking-wide text-gray-400 font-medium">Restaurant</th>
          <!-- <th class="text-left px-4 py-3 text-xs uppercase tracking-wide text-gray-400 font-medium">Vendor</th> -->
          <th class="text-left px-4 py-3 text-xs uppercase tracking-wide text-gray-400 font-medium">Category</th>
          <th class="text-left px-4 py-3 text-xs uppercase tracking-wide text-gray-400 font-medium">Price</th>
          <th class="text-left px-4 py-3 text-xs uppercase tracking-wide text-gray-400 font-medium">Actions</th>
        </tr>
      </thead>
      <tbody>
       
        @forelse($products as $product)
        <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
          <td class="px-4 py-3">
            <img 
            {{-- src="{{ asset('storage/'.$product->image) }}" --}}
            src="{{ config('services.google_drive.image_url') . $product->image }}"
             class="w-11 h-11 object-cover rounded-lg border border-gray-100">
          </td>
          <td class="px-4 py-3 font-medium text-sm">{{ $product->name }}</td>
          <td class="px-4 py-3 text-sm text-gray-500">{{ $product->restaurant->name ?? '—' }}</td>
          <!-- <td class="px-4 py-3 text-sm text-gray-500">{{ $product->vendor->name ?? '—' }}</td> -->
          <td class="px-4 py-3">
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
              {{ $product->category->name ?? '—' }}
            </span>
          </td>
          <td class="px-4 py-3 text-sm font-medium">£{{ $product->price }}</td>
          <td class="px-4 py-3">
            <a href="{{ route('admin.products.edit',$product->id) }}" class="inline-flex items-center gap-1 bg-yellow-100 text-yellow-800 px-3 py-1 rounded-lg text-xs font-medium mr-1">Edit</a>
            <form method="POST" action="{{ route('admin.products.destroy',$product->id) }}" class="inline">
              @csrf @method('DELETE')
              <button class="inline-flex items-center gap-1 bg-red-100 text-red-800 px-3 py-1 rounded-lg text-xs font-medium" onclick="return confirm('Delete this product?')">Delete</button>
            </form>
          </td>
        </tr>
        @empty
        <tr>
            <td colspan="6" class="px-4 py-10 text-center text-gray-500">
                No products found
            </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <div class="mt-6">
      {{ $products->links() }}
  </div>
</div>
@endsection