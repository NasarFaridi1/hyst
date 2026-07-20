@extends('layouts.app')

@section('content')

<div class="flex justify-between items-center mb-8">

    <div>

        <h1 class="text-4xl font-bold">

            Restaurants

        </h1>

        <p class="text-gray-500 mt-2">

            Manage all restaurants

        </p>

    </div>

    <a href="{{ route('admin.restaurants.create') }}"
    class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-xl">

        Add Restaurant

    </a>

</div>

<div class="bg-white p-5 rounded-2xl shadow mb-6">

    <form method="GET" action="{{ route('admin.restaurants.index') }}">

        <div class="flex gap-3">

            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Search by name, email, phone or location..."
                class="flex-1 border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">

            <button
                type="submit"
                class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-xl">

                Search

            </button>

            @if(request('search'))
                <a href="{{ route('admin.restaurants.index') }}"
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
                    Email
                </th>

                <th class="p-5 text-left">
                    Phone
                </th>

                <th class="p-5 text-left">
                    Location
                </th>

                <th class="p-5 text-left">
                    Hygiene Rating
                </th>

                <th class="p-5 text-left">
                    Certificate
                </th>

                <th class="p-5 text-left">
                    Status
                </th>

                <th class="p-5 text-left">
                    Display Order
                </th>

                <th class="p-5 text-left">
                    Action
                </th>

            </tr>

        </thead>

        <tbody>

            @forelse($restaurants as $restaurant)

            <tr class="border-t hover:bg-gray-50">

                <td class="p-5">

                    @if($restaurant->image)

                    <img
                    src="{{ asset('storage/'.$restaurant->image) }}"
                    class="w-20 h-20 rounded-xl object-cover">

                    @else

                    <img
                    src="https://via.placeholder.com/80"
                    class="w-20 h-20 rounded-xl object-cover">

                    @endif

                </td>

                <td class="p-5 font-bold">

                    {{ $restaurant->name }}

                </td>

                <td class="p-5">

                    {{ $restaurant->email }}

                </td>

                <td class="p-5">

                    {{ $restaurant->phone }}

                </td>

                <td class="p-5">

                    {{ $restaurant->location }}

                </td>

                <td class="p-5 whitespace-nowrap">

                    @if($restaurant->hygiene_rating)

                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">
                            ⭐ {{ $restaurant->hygiene_rating }}/5
                        </span>

                    @else

                        <span class="text-gray-400">
                            N/A
                        </span>

                    @endif

                </td>

                <td class="p-5">

                    @if($restaurant->hygiene_certificate)

                        <a href="{{ asset('storage/'.$restaurant->hygiene_certificate) }}"
                        target="_blank"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded-lg text-sm">
                            View
                        </a>

                    @else

                        <span class="text-red-500">
                            Not Uploaded
                        </span>

                    @endif

                </td>

                

                <td class="p-5">

                    @if($restaurant->status == 1)

                    <span
                    class="bg-green-100 text-green-700 px-4 py-1 rounded-full text-sm">

                        Active

                    </span>

                    @else

                    <span
                    class="bg-red-100 text-red-700 px-4 py-1 rounded-full text-sm">

                        Inactive

                    </span>

                    @endif

                </td>

                <td class="p-5">
                    <form action="{{ route('admin.restaurants.updateOrder', $restaurant->id) }}" method="POST" class="flex items-center gap-2">
                        @csrf
                        @method('PUT')

                        <input
                            type="number"
                            name="display_order"
                            value="{{ $restaurant->display_order }}"
                            min="1"
                            placeholder="-"
                            class="w-20 border rounded-lg px-2 py-1 text-center">

                        <button
                            type="submit"
                            class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded-lg text-sm">
                            Save
                        </button>
                    </form>
                </td>

                <td class="p-5">

                    <div class="flex flex-nowrap gap-2 whitespace-nowrap">

                        <a href="{{ route('admin.restaurants.edit',$restaurant->id) }}"
                        class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg">

                            Edit

                        </a>

                        <a href="{{ route('admin.restaurant.privacy-policy.edit', $restaurant->id) }}"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm">
                            Policy
                        </a>

                        <a href="{{ route('admin.restaurant.refund-policy.edit', $restaurant->id) }}"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm">
                            Refund Policy
                        </a>
                        <a href="{{ route('admin.restaurant.terms.edit', $restaurant->id) }}"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                            Terms & Conditions
                        </a>

                        <form method="POST"
                        action="{{ route('admin.restaurants.destroy',$restaurant->id) }}"
                        onsubmit="return confirm('Delete Restaurant?')">

                            @csrf
                            @method('DELETE')

                            <button
                            class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg">

                                Delete

                            </button>

                        </form>


                    </div>

                </td>

            </tr>

            @empty

            <tr>

                <td colspan="10"
                class="text-center py-20 text-gray-500">

                    No Restaurants Found

                </td>

            </tr>

            @endforelse

        </tbody>

    </table>

</div>

<div class="mt-6">
    {{ $restaurants->links() }}
</div>

@endsection