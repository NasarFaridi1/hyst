@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto">

    <div class="flex justify-between items-center mb-6">

        <div>

            <h1 class="text-3xl font-bold">

                {{ $restaurant->name }} Products

            </h1>

            <p class="text-gray-500">

                Manage restaurant products

            </p>

        </div>

        <div class="flex gap-3">

            <a href="{{ route('ambassador.restaurants.index') }}"
                class="bg-gray-700 hover:bg-gray-800 text-white px-5 py-3 rounded-lg">

                Back

            </a>

            <a href="{{ route('ambassador.products.create',$restaurant->id) }}"
                class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-lg">

                + Add Product

            </a>

        </div>

    </div>

    <div class="bg-white rounded-xl shadow p-5">

        <form method="GET" class="mb-5">

            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Search product..."
                class="border rounded-lg px-4 py-2 w-80">

        </form>

        <table class="w-full border">

            <thead class="bg-gray-100">

                <tr>

                    <th class="p-3">#</th>

                    <th class="p-3">Image</th>

                    <th class="p-3">Product</th>

                    <th class="p-3">Category</th>

                    <th class="p-3">Price</th>

                    <th class="p-3">Status</th>

                    <th class="p-3 text-center">Action</th>

                </tr>

            </thead>

            <tbody>

            @forelse($products as $product)

            <tr class="border-t">

                <td class="p-3">

                    {{ $product->id }}

                </td>

                <td class="p-3">

                    @if($product->image)

                        <img
                            src="{{ asset('storage/'.$product->image) }}"
                            class="w-14 h-14 rounded-lg object-cover">

                    @else

                        -

                    @endif

                </td>

                <td class="p-3">

                    <strong>

                        {{ $product->name }}

                    </strong>

                    <br>

                    <small class="text-gray-500">

                        {{ Str::limit($product->description,40) }}

                    </small>

                </td>

                <td class="p-3">

                    {{ optional($product->category)->name }}

                </td>

                <td class="p-3">

                    £{{ number_format($product->price,2) }}

                </td>

                <td class="p-3">

                    @if($product->status)

                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs">

                            Active

                        </span>

                    @else

                        <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs">

                            Inactive

                        </span>

                    @endif

                </td>

                <td class="p-3">

                    <div class="flex gap-2 justify-center">

                        <a href="{{ route('ambassador.products.edit',[$restaurant->id,$product->id]) }}"
                            class="bg-yellow-500 text-white px-3 py-2 rounded">

                            Edit

                        </a>

                        <form
                            action="{{ route('ambassador.products.destroy',[$restaurant->id,$product->id]) }}"
                            method="POST">

                            @csrf
                            @method('DELETE')

                            <button
                                onclick="return confirm('Delete Product?')"
                                class="bg-red-600 text-white px-3 py-2 rounded">

                                Delete

                            </button>

                        </form>

                    </div>

                </td>

            </tr>

            @empty

            <tr>

                <td colspan="7" class="text-center py-8">

                    No Products Found

                </td>

            </tr>

            @endforelse

            </tbody>

        </table>

        <div class="mt-5">

            {{ $products->links() }}

        </div>

    </div>

</div>

@endsection