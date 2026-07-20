@extends('layouts.app')

@section('content')

<div class="p-8">

<div class="flex justify-between items-center mb-6">

<div>

<h1 class="text-2xl font-medium">
Restaurant Categories
</h1>

<p class="text-sm text-gray-500 mt-1">
Manage Categories
</p>

</div>

<a
href="{{ route('admin.restaurant-categories.create') }}"
class="bg-green-500 text-white px-4 py-2 rounded-lg">

+ Add Category

</a>

</div>

<div class="bg-white rounded-xl p-4 mb-5">

<form>

<div class="flex gap-3">

<input
name="search"
value="{{ request('search') }}"
placeholder="Search..."
class="flex-1 border rounded-lg px-4 py-2">

<button class="bg-green-500 text-white px-5 rounded-lg">

Search

</button>

@if(request('search'))

<a
href="{{ route('admin.restaurant-categories.index') }}"
class="bg-gray-500 text-white px-5 py-2 rounded-lg">

Reset

</a>

@endif

</div>

</form>

</div>

<div class="bg-white rounded-xl overflow-hidden">

<table class="w-full">

<thead>

<tr class="bg-gray-100">

<th class="p-3 text-left">#</th>
<th class="p-3 text-left">Image</th>

<th class="p-3 text-left">Name</th>
<th class="p-3 text-left">Display Order</th>

<th class="p-3 text-left">Status</th>

<th class="p-3 text-left">Action</th>


</tr>

</thead>

<tbody>

@forelse($categories as $category)

<tr class="border-b">

<td class="p-3">
{{ $category->id }}
</td>

<td class="p-3">
    @if($category->image)
        <img
            src="{{ asset($category->image) }}"
            width="60"
            height="60"
            style="object-fit:cover;border-radius:8px;">
    @endif
</td>

<td class="p-3">
{{ $category->name }}
</td>

<td class="p-3">
    {{ $category->display_order }}
</td>

<td class="p-3">

@if($category->status=='active')

<span class="text-green-600">
Active
</span>

@else

<span class="text-red-600">
Inactive
</span>

@endif

</td>

<td class="p-3">

<a
href="{{ route('admin.restaurant-categories.edit',$category->id) }}"
class="text-blue-600">

Edit

</a>

<form
method="POST"
action="{{ route('admin.restaurant-categories.destroy',$category->id) }}"
class="inline">

@csrf
@method('DELETE')

<button
onclick="return confirm('Delete?')"
class="text-red-600 ml-3">

Delete

</button>

</form>

</td>

</tr>

@empty

<tr>

<td colspan="4" class="text-center py-10">

No Categories

</td>

</tr>

@endforelse

</tbody>

</table>

</div>

<div class="mt-6">

{{ $categories->links() }}

</div>

</div>

@endsection