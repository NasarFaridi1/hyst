@extends('layouts.app')

@section('content')

<div class="flex justify-between items-center mb-8">

    <div>
        <h1 class="text-3xl font-bold">
            {{ $product->name }} - Addons
        </h1>

        <p class="text-gray-500 mt-2">
            Manage Product Addons
        </p>
    </div>

    <div class="flex gap-3">

        <a href="{{ route('restaurant.products.index') }}"
           class="bg-gray-500 text-white px-5 py-3 rounded-lg">
            Back
        </a>

        <a href="{{ route('restaurant.products.addons.create',$product->id) }}"
           class="bg-blue-600 text-white px-5 py-3 rounded-lg">
            + Add Addon
        </a>

    </div>

</div>

@if(session('success'))
<div class="bg-green-100 text-green-700 p-4 rounded-lg mb-5">
    {{ session('success') }}
</div>
@endif

<div class="bg-white rounded-xl shadow overflow-hidden">

<table class="w-full">

<thead class="bg-gray-100">

<tr>

<th class="p-4 text-left">Category</th>

<th class="p-4 text-left">Addon</th>

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

<a href="{{ route('restaurant.products.addons.edit',[$product->id,$addon->id]) }}"
class="bg-yellow-500 text-white px-4 py-2 rounded-lg">
Edit
</a>

<form method="POST"
action="{{ route('restaurant.products.addons.destroy',[$product->id,$addon->id]) }}">

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

No Addons Found

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