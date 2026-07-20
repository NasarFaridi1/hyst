@extends('layouts.app')

@section('content')

<div class="p-8">

<div class="bg-white rounded-xl p-6 max-w-xl">

<h2 class="text-xl font-semibold mb-5">

Edit Category

</h2>

<form
method="POST"
action="{{ route('admin.restaurant-categories.update',$category->id) }}"
enctype="multipart/form-data"
>

@csrf
@method('PUT')

<div class="mb-5">

<label>Name</label>

<input
name="name"
value="{{ $category->name }}"
class="w-full border rounded-lg px-4 py-2">

</div>

<div class="mb-5">

    <label>Display Order</label>

    <input
        type="number"
        name="display_order"
        value="{{ old('display_order',$category->display_order) }}"
        class="w-full border rounded-lg px-4 py-2"
        required>

</div>

<div class="mb-5">
    <label>Image</label>

    @if($category->image)
        <img
            src="{{ asset($category->image) }}"
            width="100"
            class="mb-2">
    @endif

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

<option
value="active"
{{ $category->status=='active'?'selected':'' }}>

Active

</option>

<option
value="inactive"
{{ $category->status=='inactive'?'selected':'' }}>

Inactive

</option>

</select>

</div>

<button
class="bg-green-500 text-white px-6 py-2 rounded-lg">

Update

</button>

</form>

</div>

</div>

@endsection