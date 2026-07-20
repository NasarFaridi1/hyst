@extends('layouts.app')

@section('content')

    <div class="flex justify-between items-center mb-8">

        <h1 class="text-3xl font-bold">
            Offers & Discounts
        </h1>

        <a href="/restaurant/offers/create" class="bg-black text-white px-6 py-3 rounded-xl">
            Add Offer
        </a>

    </div>

    <div class="bg-white rounded-3xl shadow overflow-hidden">

        <table class="w-full">

            <thead class="bg-gray-100">

                <tr>

                    <th class="p-4 text-left">Image</th>

                    <th class="p-4 text-left">Title</th>

                    <th class="p-4 text-left">Type</th>

                    <th class="p-4 text-left">Value</th>

                    <th class="p-4 text-left">Status</th>
                    <th class="p-4 text-left">Featured</th>

                    <th class="p-4 text-left">Action</th>

                </tr>

            </thead>

            <tbody>

                @forelse($offers as $offer)

                    <tr class="border-b">

                        <td class="p-4">

                            @if($offer->image)

                                <img src="{{ asset('storage/' . $offer->image) }}" class="w-20 h-20 object-cover rounded-xl">

                            @endif

                        </td>

                        <td class="p-4">
                            {{ $offer->title }}
                        </td>

                        <td class="p-4">
                            {{ ucfirst($offer->type) }}
                        </td>

                        <td class="p-4">

                            @if($offer->value_type == 'percent')

                                {{ $offer->value }}%

                            @else

                                £{{ $offer->value }}

                            @endif

                        </td>

                        <td class="p-4">

                            @if($offer->is_active)

                                <span class="bg-green-500 text-white px-3 py-1 rounded-full">
                                    Active
                                </span>

                            @else

                                <span class="bg-red-500 text-white px-3 py-1 rounded-full">
                                    Inactive
                                </span>

                            @endif

                        </td>
                        <td class="p-4">

                            @if($offer->type == 'offer')

                                        <form action="/restaurant/offers/{{ $offer->id }}/featured" method="POST">

                                            @csrf

                                            <button class="
                                        px-4 py-2 rounded-xl text-white font-semibold
                                        {{ $offer->is_featured
                                ? 'bg-green-600'
                                : 'bg-gray-400'
                                        }}
                                    ">

                                                {{ $offer->is_featured
                                ? 'Featured'
                                : 'Set Featured'
                                    }}

                                            </button>

                                        </form>

                            @else

                                <span class="text-gray-400 text-sm">
                                    Only Offers
                                </span>

                            @endif

                        </td>

                        <td class="p-4 flex gap-3">

                            <a href="/restaurant/offers/{{ $offer->id }}/edit"
                                class="bg-blue-500 text-white px-4 py-2 rounded-lg">
                                Edit
                            </a>

                            <form action="/restaurant/offers/{{ $offer->id }}" method="POST">

                                @csrf
                                @method('DELETE')

                                <button class="bg-red-500 text-white px-4 py-2 rounded-lg">
                                    Delete
                                </button>

                            </form>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="6" class="p-10 text-center">
                            No Offers Found
                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

@endsection