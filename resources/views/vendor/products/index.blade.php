@extends('layouts.app')

@section('content')

<div class="p-10">

    <div class="flex justify-between mb-8">

        <h1 class="text-4xl font-bold">

            My Products

        </h1>

        <a href="{{ route('vendor.products.create') }}"
        class="bg-blue-500 text-white px-6 py-3 rounded-xl">

            Add Product

        </a>

    </div>

    <div class="bg-white shadow rounded-2xl overflow-hidden">

        <table class="w-full">

            <thead class="bg-gray-100">

                <tr>

                    <th class="p-4 text-left">Image</th>

                    <th class="p-4 text-left">Name</th>

                    <th class="p-4 text-left">Price</th>

                    <th class="p-4 text-left">Action</th>

                </tr>

            </thead>

            <tbody>

                @foreach($products as $product)

                <tr class="border-t">

                    <td class="p-4">

                        <img
                        {{-- src="{{ asset('storage/'.$product->image) }}" --}}
                        src="{{ $product->image ? config('services.google_drive.image_url') . $product->image : asset('default.png') }}"
                        class="w-20 h-20 rounded-xl object-cover">

                    </td>

                    <td class="p-4">

                        {{ $product->name }}

                    </td>

                    <td class="p-4">

                        £{{ $product->price }}

                    </td>

                    <td class="p-4 flex gap-3">

                        <a
                        href="{{ route('vendor.products.edit', $product->id) }}"
                        class="bg-blue-500 text-white px-4 py-2 rounded-xl">

                            Edit

                        </a>

                        <form
                        method="POST"
                        action="{{ route('vendor.products.destroy', $product->id) }}">

                            @csrf
                            @method('DELETE')

                            <button
                            class="bg-red-500 text-white px-4 py-2 rounded-xl">

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