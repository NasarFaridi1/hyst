@extends('layouts.app')

@section('content')

<div class="flex justify-between items-center mb-8">

    <div>

        <h1 class="text-4xl font-bold">

            My Products

        </h1>

        <p class="text-gray-500 mt-2">

            Restaurant products list

        </p>

    </div>

    <a href="/restaurant/products/create"
    class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-xl">

        Add Product

    </a>

</div>
<div class="bg-white rounded-2xl shadow p-5 mb-6">

    <form method="GET">

        <div class="flex gap-3">

            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Search product, category, price..."
                class="flex-1 border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">

            <button
                type="submit"
                class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-xl">

                Search

            </button>

            @if(request('search'))
                <a href="{{ url()->current() }}"
                   class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-xl">

                    Reset

                </a>
            @endif

        </div>

    </form>

</div>


<div class="bg-white rounded-2xl shadow overflow-x-auto">

    <table class="w-full">

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

                    {{ $product->name }}

                </td>

                <td class="p-5">

                    {{ $product->category->name ?? '' }}

                </td>

                <td class="p-5">

                    £{{ $product->price }}

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

                    <a href="{{ route('restaurant.products.addons.index',$product->id) }}"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg">
                        Addons
                    </a>

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

                <td colspan="6"
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
@endsection