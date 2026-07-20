@extends('layouts.app')

@section('content')

<div class="p-8">

    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-medium">Restaurant Banners</h1>
            <p class="text-sm text-gray-500 mt-1">
                Manage your restaurant banners
            </p>
        </div>

        <a href="{{ route('restaurant.banners.create') }}"
            class="inline-flex items-center gap-2 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium">
            + Add Banner
        </a>
    </div>

    <div class="bg-white rounded-xl border overflow-hidden">

        <table class="w-full">

            <thead class="bg-gray-50">

                <tr>

                    <th class="text-left px-4 py-3">Image</th>

                    <th class="text-left px-4 py-3">Status</th>

                    <th class="text-left px-4 py-3">Action</th>

                </tr>

            </thead>

            <tbody>

                @foreach($banners as $banner)

                <tr class="border-t">

                    <td class="px-4 py-3">

                        <img src="{{ asset($banner->image) }}"
                            class="w-32 h-20 rounded-lg object-cover">

                    </td>

                    <td class="px-4 py-3">

                        @if($banner->status)

                        <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs">
                            Active
                        </span>

                        @else

                        <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs">
                            Inactive
                        </span>

                        @endif

                    </td>

                    <td class="px-4 py-3 space-x-3">

                        <a href="{{ route('restaurant.banners.edit',$banner->id) }}"
                            class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded text-xs">
                            Edit
                        </a>

                        <form action="{{ route('restaurant.banners.destroy',$banner->id) }}"
                            method="POST"
                            class="inline">

                            @csrf
                            @method('DELETE')

                            <button
                                onclick="return confirm('Delete Banner?')"
                                class="bg-red-100 text-red-700 px-3 py-1 rounded text-xs">
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