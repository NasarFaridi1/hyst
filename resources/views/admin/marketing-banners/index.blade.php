@extends('layouts.app')

@section('content')

<div class="flex justify-between items-center mb-8">

<div>

    <h1 class="text-4xl font-bold">
        Marketing Banners
    </h1>

    <p class="text-gray-500 mt-2">
        Manage all marketing banners
    </p>

</div>

<a href="{{ route('admin.marketing-banners.create') }}"
    class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-xl">

    Add Banner

</a>


</div>

<div class="bg-white p-6 rounded-2xl shadow mb-6">

    <form method="GET"
        action="{{ route('admin.marketing-banners.index') }}">

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Search title..."
                class="border rounded-lg px-4 py-3">

            <select
                name="category_id"
                class="border rounded-lg px-4 py-3">

                <option value="">All Categories</option>

                @foreach($categories as $category)
                    <option
                        value="{{ $category->id }}"
                        {{ request('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach

            </select>

            <select
                name="status"
                class="border rounded-lg px-4 py-3">

                <option value="">All Status</option>

                <option value="active"
                    {{ request('status') == 'active' ? 'selected' : '' }}>
                    Active
                </option>

                <option value="inactive"
                    {{ request('status') == 'inactive' ? 'selected' : '' }}>
                    Inactive
                </option>

            </select>

            <div class="flex gap-2">

                <button
                    type="submit"
                    class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg">

                    Filter

                </button>

                <a href="{{ route('admin.marketing-banners.index') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg">

                    Reset

                </a>

            </div>

        </div>

    </form>

</div>

<div class="bg-white rounded-2xl shadow overflow-hidden">


<table class="w-full">

    <thead class="bg-gray-100">

        <tr>

            <th class="p-5 text-left">
                Image
            </th>

            <th class="p-5 text-left">
                Title
            </th>

            <th class="p-5 text-left">
                Category
            </th>

            <th class="p-5 text-left">
                Subtitle
            </th>

            <th class="p-5 text-left">
                Description
            </th>

            <th class="p-5 text-left">
                Status
            </th>

            <th class="p-5 text-left">
                Created At
            </th>

            <th class="p-5 text-left">
                Action
            </th>

        </tr>

    </thead>

    <tbody>

        @forelse($banners as $banner)

            <tr class="border-t hover:bg-gray-50">

                <td class="p-5">

                    @if($banner->banner_image)

                        <img
                            src="{{ asset($banner->banner_image) }}"
                            class="w-24 h-16 rounded-lg object-cover">

                    @else

                        <img
                            src="https://via.placeholder.com/120x80"
                            class="w-24 h-16 rounded-lg object-cover">

                    @endif

                </td>

                <td class="p-5 font-semibold">
                    {{ $banner->title }}
                </td>

                <td class="p-5">
                    {{ $banner->category->name ?? '-' }}
                </td>

                <td class="p-5">
                    {{ $banner->subtitle ?? '-' }}
                </td>

                <td class="p-5 max-w-xs">
                    {{ \Illuminate\Support\Str::limit($banner->description, 80) }}
                </td>

                <td class="p-5">

                    @if($banner->status == 'active')

                        <span class="bg-green-100 text-green-700 px-4 py-1 rounded-full text-sm">
                            Active
                        </span>

                    @else

                        <span class="bg-red-100 text-red-700 px-4 py-1 rounded-full text-sm">
                            Inactive
                        </span>

                    @endif

                </td>

                <td class="p-5">
                    {{ $banner->created_at->format('d M Y') }}
                </td>

                <td class="p-5">

                    <div class="flex gap-3">

                        <a href="{{ route('admin.marketing-banners.edit', $banner->id) }}"
                            class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg">

                            Edit

                        </a>

                        <form method="POST"
                            action="{{ route('admin.marketing-banners.destroy', $banner->id) }}"
                            onsubmit="return confirm('Delete Banner?')">

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

                <td colspan="8"
                    class="text-center py-20 text-gray-500">

                    No Marketing Banners Found

                </td>

            </tr>

        @endforelse

    </tbody>

</table>

<div class="p-5 border-t">
    {{ $banners->links() }}
</div>

</div>

@endsection
