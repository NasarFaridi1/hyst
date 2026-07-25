@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto">

    <div class="flex justify-between items-center mb-6">

        <div>

            <h1 class="text-3xl font-bold">
                My Restaurants
            </h1>

            <p class="text-gray-500">
                Manage your restaurants
            </p>

        </div>

        <a href="{{ route('ambassador.restaurants.create') }}"
            class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-lg">

            + Add Restaurant

        </a>

    </div>

    <div class="bg-white rounded-xl shadow p-5">

        <form method="GET" class="mb-5">

            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Search restaurant..."
                class="border rounded-lg px-4 py-2 w-80">

        </form>

        <table class="w-full border">

            <thead class="bg-gray-100">

                <tr>

                    <th class="p-3 text-left">#</th>

                    <th class="p-3 text-left">Image</th>

                    <th class="p-3 text-left">Restaurant</th>

                    <th class="p-3 text-left">Phone</th>

                    <th class="p-3 text-left">City</th>

                    <th class="p-3 text-left">Status</th>

                    <th class="p-3 text-center">Action</th>

                </tr>

            </thead>

            <tbody>

            @forelse($restaurants as $restaurant)

                <tr class="border-t">

                    <td class="p-3">
                        {{ $restaurant->id }}
                    </td>

                    <td class="p-3">

                        @if($restaurant->image)

                            <img
                                src="{{ asset('storage/'.$restaurant->image) }}"
                                class="w-14 h-14 rounded-lg object-cover">

                        @else

                            -

                        @endif

                    </td>

                    <td class="p-3">

                        <strong>

                            {{ $restaurant->name }}

                        </strong>

                        <br>

                        <small class="text-gray-500">

                            {{ $restaurant->email }}

                        </small>

                    </td>

                    <td class="p-3">

                        {{ $restaurant->phone }}

                    </td>

                    <td class="p-3">

                        {{ $restaurant->city }}

                    </td>

                    <td class="p-3">

                        @if($restaurant->status)

                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs">

                                Active

                            </span>

                        @else

                            <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs">

                                Pending

                            </span>

                        @endif

                    </td>

                    <td class="p-3">

                        <div class="flex gap-2 justify-center">

                            <a href="{{ route('ambassador.restaurants.edit',$restaurant->id) }}"
                                class="bg-yellow-500 text-white px-3 py-2 rounded">

                                Edit

                            </a>

                           <a href="{{ route('ambassador.categories.index',$restaurant->id) }}"
                            class="bg-indigo-600 text-white px-3 py-2 rounded">
                            Categories
                        </a>

                        <a href="{{ route('ambassador.products.index',$restaurant->id) }}"
                            class="bg-green-600 text-white px-3 py-2 rounded">
                            Products
                        </a>

                            <form
                                action="{{ route('ambassador.restaurants.destroy',$restaurant->id) }}"
                                method="POST">

                                @csrf
                                @method('DELETE')

                                <button
                                    onclick="return confirm('Delete Restaurant?')"
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

                        No Restaurant Found

                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>

        <div class="mt-5">

            {{ $restaurants->links() }}

        </div>

    </div>

</div>

@endsection