@extends('layouts.app')

@section('content')

<div class="max-w-2xl mx-auto bg-white rounded-xl shadow p-8">

<h2 class="text-3xl font-bold mb-8">

Edit Addon

</h2>

<form method="POST"
action="{{ route('restaurant.products.addons.update',[$product->id,$addon->id]) }}">

@csrf
@method('PUT')

<div class="mb-5">

    <label class="font-semibold">
        Category Name
    </label>

    <select
        name="category_name"
        class="w-full border rounded-lg p-3 mt-2">

        <option value="">Select Category</option>

        <option value="Common Addons" {{ old('category_name', $addon->category_name) == 'Common Addons' ? 'selected' : '' }}>
            Common Addons
        </option>

        <option value="Sauces" {{ old('category_name', $addon->category_name) == 'Sauces' ? 'selected' : '' }}>
            Sauces
        </option>

        <option value="Salads" {{ old('category_name', $addon->category_name) == 'Salads' ? 'selected' : '' }}>
            Salads
        </option>

        <option value="Sides" {{ old('category_name', $addon->category_name) == 'Sides' ? 'selected' : '' }}>
            Sides
        </option>

        <option value="Drinks" {{ old('category_name', $addon->category_name) == 'Drinks' ? 'selected' : '' }}>
            Drinks
        </option>

        <option value="Desserts" {{ old('category_name', $addon->category_name) == 'Desserts' ? 'selected' : '' }}>
            Desserts
        </option>

        <option value="Toppings" {{ old('category_name', $addon->category_name) == 'Toppings' ? 'selected' : '' }}>
            Toppings
        </option>

    </select>

</div>

<div class="mb-5">

<label class="font-semibold">

Addon Name

</label>

<input
type="text"
name="addon_name"
class="w-full border rounded-lg p-3 mt-2"
value="{{ old('addon_name',$addon->addon_name) }}">

</div>

<div class="mb-5">

<label class="font-semibold">

Price

</label>

<input
type="number"
step="0.01"
name="price"
class="w-full border rounded-lg p-3 mt-2"
value="{{ old('price',$addon->price) }}">

</div>

<div class="mb-8">

<label class="font-semibold">

Status

</label>

<select
name="status"
class="w-full border rounded-lg p-3 mt-2">

<option value="1" {{ $addon->status ? 'selected' : '' }}>
Active
</option>

<option value="0" {{ !$addon->status ? 'selected' : '' }}>
Inactive
</option>

</select>

</div>

<div class="flex gap-3">

<button
class="bg-blue-600 text-white px-6 py-3 rounded-lg">

Update Addon

</button>

<a href="{{ route('restaurant.products.addons.index',$product->id) }}"
class="bg-gray-500 text-white px-6 py-3 rounded-lg">

Cancel

</a>

</div>

</form>

</div>

@endsection