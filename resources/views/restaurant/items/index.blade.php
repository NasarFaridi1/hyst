@extends('layouts.app')

@section('content')

<div class="p-6">

    <div class="flex justify-between mb-6">

        <h2 class="text-2xl font-bold">
            Restaurant Items
        </h2>

        <a href="/restaurant/items/create"
        class="bg-blue-500 text-white px-5 py-2 rounded">

            Add Item

        </a>

    </div>

    <div class="bg-white rounded shadow overflow-x-auto">

        <table class="w-full">

            <thead class="bg-gray-100">

                <tr>

                    <th class="p-3">Image</th>

                    <th class="p-3">Name</th>

                    <th class="p-3">Unit</th>

                    <th class="p-3">Price</th>

                    <th class="p-3">Qty</th>


                    <th class="p-3">Action</th>

                </tr>

            </thead>

            <tbody>

                @foreach($items as $item)

                <tr class="border-b">

                    <td class="p-3">

                        <img src="{{ asset('storage/'.$item->image) }}"
                        class="w-16 h-16 rounded object-cover">

                    </td>

                    <td class="p-3">
                        {{ $item->name }}
                    </td>

                    <td class="p-3">
                        {{ $item->unit }}
                    </td>

                    <td class="p-3">
                        ₹{{ $item->price }}
                    </td>

                    <td class="p-3">
                        {{ $item->quantity }}
                    </td>

                    


                    <td class="p-3 flex gap-2">

                        <a href="/restaurant/items/{{ $item->id }}/edit"
                        class="bg-yellow-500 text-white px-3 py-1 rounded">

                            Edit

                        </a>

                        <form method="POST"
                        action="/restaurant/items/{{ $item->id }}">

                            @csrf
                            @method('DELETE')

                            <button class="bg-red-500 text-white px-3 py-1 rounded">

                                Delete

                            </button>

                        </form>

                    </td>

                </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</div>

@endsection