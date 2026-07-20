@extends('layouts.app')

@section('content')

<div class="p-8">

<div class="bg-white rounded-xl p-6 max-w-xl">

<h2 class="text-xl font-semibold mb-5">

Add Category

</h2>

<form
method="POST"
action="{{ route('admin.restaurant-categories.store') }}"
enctype="multipart/form-data"
>

@csrf

<div class="mb-5">

<label>Name</label>

<input
name="name"
class="w-full border rounded-lg px-4 py-2"
required>

</div>


<div class="mb-5">

    <label>Display Order</label>

    <input
        type="number"
        name="display_order"
        value="{{ old('display_order',0) }}"
        class="w-full border rounded-lg px-4 py-2"
        required>

</div>

<div class="mb-5">
    <label>Image</label>

    <input
        type="file"
        name="image"
        class="w-full border rounded-lg px-4 py-2">
</div>

<div class="mb-5">

<label>Status</label>

<select
name="status"
class="w-full border rounded-lg px-4 py-2">

<option value="active">
Active
</option>

<option value="inactive">
Inactive
</option>

</select>

</div>

<button
class="bg-green-500 text-white px-6 py-2 rounded-lg">

Save

</button>

</form>

</div>

</div>

@endsection