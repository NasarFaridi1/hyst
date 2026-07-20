@extends('layouts.app')

@section('content')

<div class="max-w-2xl mx-auto bg-white rounded-xl shadow p-8">

<h2 class="text-3xl font-bold mb-8">

Add Addon

</h2>

<form method="POST"
action="{{ route('restaurant.products.addons.store',$product->id) }}">

@csrf

<div class="mb-5">

    <label class="font-semibold">
        Category Name
    </label>

    <select
        name="category_name"
        class="w-full border rounded-lg p-3 mt-2">

        <option value="">Select Category</option>

        <option value="Common Addons" {{ old('category_name') == 'Common Addons' ? 'selected' : '' }}>
            Common Addons
        </option>

        <option value="Sauces" {{ old('category_name') == 'Sauces' ? 'selected' : '' }}>
            Sauces
        </option>

        <option value="Salads" {{ old('category_name') == 'Salads' ? 'selected' : '' }}>
            Salads
        </option>

        <option value="Sides" {{ old('category_name') == 'Sides' ? 'selected' : '' }}>
            Sides
        </option>

        <option value="Drinks" {{ old('category_name') == 'Drinks' ? 'selected' : '' }}>
            Drinks
        </option>

        <option value="Desserts" {{ old('category_name') == 'Desserts' ? 'selected' : '' }}>
            Desserts
        </option>

        <option value="Toppings" {{ old('category_name') == 'Toppings' ? 'selected' : '' }}>
            Toppings
        </option>

    </select>

    @error('category_name')
        <p class="text-red-500 mt-1">{{ $message }}</p>
    @enderror

</div>

<div class="mb-5">

<label class="font-semibold">

Addon Name

</label>

<input
type="text"
name="addon_name"
class="w-full border rounded-lg p-3 mt-2"
placeholder="Extra Cheese"
value="{{ old('addon_name') }}">

@error('addon_name')
<p class="text-red-500">{{ $message }}</p>
@enderror

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
value="{{ old('price') }}">

</div>

<div class="mb-8">

<label class="font-semibold">

Status

</label>

<select
name="status"
class="w-full border rounded-lg p-3 mt-2">

<option value="1">Active</option>

<option value="0">Inactive</option>

</select>

</div>

<div class="flex gap-3">

<button
class="bg-blue-600 text-white px-6 py-3 rounded-lg">

Save Addon

</button>

<a href="{{ route('restaurant.products.addons.index',$product->id) }}"
class="bg-gray-500 text-white px-6 py-3 rounded-lg">

Cancel

</a>

</div>

</form>

</div>

@endsection