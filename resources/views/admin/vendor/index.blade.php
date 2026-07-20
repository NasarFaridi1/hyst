@extends('layouts.app')

@section('content')

<div class="p-10">

    <div class="flex justify-between mb-5">

        <h1 class="text-2xl font-bold">
            Vendors
        </h1>

        <a href="{{ route('admin.vendor.create') }}"
        class="bg-green-500 text-white px-5 py-2 rounded">

            Add Vendor

        </a>

    </div>

    <table class="w-full border">

        <tr class="bg-gray-200">

            <th class="border p-3">Name</th>
            <th class="border p-3">Email</th>
            <th class="border p-3">Action</th>

        </tr>

        @foreach($vendors as $vendor)

        <tr>

            <td class="border p-3">
                {{ $vendor->name }}
            </td>

            <td class="border p-3">
                {{ $vendor->email }}
            </td>

            <td class="border p-3">

                <a href="{{ route('admin.vendor.edit',$vendor->id) }}"
                class="bg-yellow-500 text-white px-3 py-1 rounded">

                    Edit

                </a>

                <form method="POST"
                action="{{ route('admin.vendor.destroy',$vendor->id) }}"
                class="inline">

                    @csrf
                    @method('DELETE')

                    <button class="bg-red-500 text-white px-3 py-1 rounded">

                        Delete

                    </button>

                </form>

            </td>

        </tr>

        @endforeach

    </table>

</div>

@endsection