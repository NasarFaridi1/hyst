@extends('layouts.app')

@section('content')

<div class="flex justify-between items-center mb-8">

    <div>

        <h1 class="text-4xl font-bold">
            Banner Categories
        </h1>

        <p class="text-gray-500 mt-2">
            Manage banner categories
        </p>

    </div>

    <a href="{{ route('admin.marketing-banner-categories.create') }}"
    class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-xl">

        Add Category

    </a>

</div>

@if(session('success'))

<div class="bg-green-100 text-green-700 px-5 py-4 rounded-xl mb-5">
    {{ session('success') }}
</div>

@endif

@if(session('error'))

<div class="bg-red-100 text-red-700 px-5 py-4 rounded-xl mb-5">
    {{ session('error') }}
</div>

@endif

<div class="bg-white rounded-2xl shadow overflow-hidden">

    <table class="w-full">

        <thead class="bg-gray-100">

            <tr>

                <th class="p-5 text-left">
                    Name
                </th>

                <th class="p-5 text-left">
                    Description
                </th>

                <th class="p-5 text-left">
                    Banners
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

            @forelse($categories as $category)

            <tr class="border-t hover:bg-gray-50">

                <td class="p-5 font-bold">
                    {{ $category->name }}
                </td>

                <td class="p-5">
                    {{ $category->description }}
                </td>

                <td class="p-5">
                    {{ $category->banners()->count() }}
                </td>

                <td class="p-5">

                    @if($category->status)

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

                    <div class="flex gap-3">

                        <a href="{{ route('admin.marketing-banner-categories.edit',$category->id) }}"
                        class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg">

                            Edit

                        </a>

                        <form method="POST"
                        action="{{ route('admin.marketing-banner-categories.destroy',$category->id) }}"
                        onsubmit="return confirm('Delete Category?')">

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

                <td colspan="5"
                class="text-center py-20 text-gray-500">

                    No Categories Found

                </td>

            </tr>

            @endforelse

        </tbody>

    </table>

</div>

@endsection