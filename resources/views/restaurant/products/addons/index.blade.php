@extends('layouts.app')

@section('content')

<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6 sm:mb-8">

    <div>
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">
            Restaurant Addons
        </h1>

        <p class="text-gray-500 mt-1 text-xs sm:text-sm">
            Manage Common Addons (Available Across All Products)
        </p>
    </div>

    <div class="flex flex-wrap items-center gap-2 sm:gap-3 w-full sm:w-auto">

        <a href="{{ route('restaurant.products.index') }}"
           class="bg-gray-500 hover:bg-gray-600 text-white px-4 sm:px-5 py-2.5 sm:py-3 rounded-lg text-xs sm:text-sm font-semibold flex-1 sm:flex-initial text-center transition">
            Back to Products
        </a>

        <a href="{{ route('restaurant.addons.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 sm:px-5 py-2.5 sm:py-3 rounded-lg text-xs sm:text-sm font-semibold flex-1 sm:flex-initial text-center transition shadow">
            + Add Addon
        </a>

    </div>

</div>

@if(session('success'))
<div class="bg-green-100 text-green-700 p-4 rounded-lg mb-5 text-sm">
    {{ session('success') }}
</div>
@endif

<div class="bg-white rounded-xl shadow overflow-x-auto">

<table class="w-full min-w-[550px]">

<thead class="bg-gray-100">

<tr>

<th class="p-4 text-left">Category</th>

<th class="p-4 text-left">Addon Name</th>

<th class="p-4 text-left">Price</th>

<th class="p-4 text-left">Status</th>

<th class="p-4 text-center">Action</th>

</tr>

</thead>

<tbody>

@forelse($addons as $addon)

<tr class="border-t">

<td class="p-4">
{{ $addon->category_name }}
</td>

<td class="p-4 font-medium">
{{ $addon->addon_name }}
</td>

<td class="p-4">
£{{ number_format($addon->price,2) }}
</td>

<td class="p-4">

@if($addon->status)

<span class="bg-green-100 text-green-700 px-3 py-1 rounded-full">
Active
</span>

@else

<span class="bg-red-100 text-red-700 px-3 py-1 rounded-full">
Inactive
</span>

@endif

</td>

<td class="p-4">

<div class="flex justify-center gap-2">

<a href="{{ route('restaurant.addons.edit', $addon->id) }}"
class="bg-yellow-500 text-white px-4 py-2 rounded-lg">
Edit
</a>

<form method="POST"
action="{{ route('restaurant.addons.destroy', $addon->id) }}">

@csrf
@method('DELETE')

<button onclick="return confirm('Delete this addon?')"
class="bg-red-500 text-white px-4 py-2 rounded-lg">

Delete

</button>

</form>

</div>

</td>

</tr>

@empty

<tr>

<td colspan="5" class="text-center py-12 text-gray-500">

No Addons Found. Click "+ Add Addon" to create one.

</td>

</tr>

@endforelse

</tbody>

</table>

</div>

<div class="mt-6">

{{ $addons->links() }}

</div>

@endsection