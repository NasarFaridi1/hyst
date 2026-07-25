@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto">

    <div class="flex justify-between items-center mb-6">

        <div>

            <h2 class="text-3xl font-bold">

                {{ $restaurant->name }} Categories

            </h2>

        </div>

        <a href="{{ route('ambassador.categories.create',$restaurant->id) }}"
            class="bg-blue-600 text-white px-5 py-3 rounded">

            + Add Category

        </a>

    </div>

    <table class="w-full border">

        <thead class="bg-gray-100">

            <tr>

                <th class="p-3">Image</th>

                <th class="p-3">Name</th>

                <th class="p-3">Parent</th>

                <th class="p-3">Status</th>

                <th class="p-3">Action</th>

            </tr>

        </thead>

        <tbody>

        @forelse($categories as $category)

        <tr class="border-t">

            <td class="p-3">

                @if($category->image)

                <img
                    src="{{ asset('storage/'.$category->image) }}"
                    class="w-14 h-14 rounded object-cover">

                @endif

            </td>

            <td class="p-3">

                {{ $category->name }}

            </td>

            <td class="p-3">

                {{ optional($category->parent)->name }}

            </td>

            <td class="p-3">

                @if($category->status)

                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded">

                        Active

                    </span>

                @else

                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded">

                        Inactive

                    </span>

                @endif

            </td>

            <td class="p-3 flex gap-2">

                <a href="{{ route('ambassador.categories.edit',[$restaurant->id,$category->id]) }}"
                    class="bg-yellow-500 text-white px-3 py-2 rounded">

                    Edit

                </a>

                <form
                    action="{{ route('ambassador.categories.destroy',[$restaurant->id,$category->id]) }}"
                    method="POST">

                    @csrf
                    @method('DELETE')

                    <button
                        onclick="return confirm('Delete Category?')"
                        class="bg-red-600 text-white px-3 py-2 rounded">

                        Delete

                    </button>

                </form>

            </td>

        </tr>

        @empty

        <tr>

            <td colspan="5" class="text-center py-10">

                No Categories Found

            </td>

        </tr>

        @endforelse

        </tbody>

    </table>

    <div class="mt-5">

        {{ $categories->links() }}

    </div>

</div>

@endsection