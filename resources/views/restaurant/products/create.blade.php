@extends('layouts.app')

@section('content')

    <div class="max-w-5xl mx-auto">

        <div class="flex justify-between items-center mb-8">

            <h1 class="text-4xl font-bold">

                Add Product

            </h1>

            <a href="/restaurant/products" class="bg-black text-white px-6 py-3 rounded-xl">

                Back

            </a>

        </div>

        <div class="bg-white rounded-2xl shadow p-10">

            <form method="POST" action="/restaurant/products" enctype="multipart/form-data">

                @csrf

                <div class="grid grid-cols-2 gap-6">

                    <div>

                        <label class="font-bold block mb-2">

                            Product Name

                        </label>

                        <input type="text" name="name" class="w-full border p-4 rounded-xl">

                    </div>

                    <div>

                        <label class="font-bold block mb-2">

                            Category

                        </label>

                        <select name="category_id" class="w-full border p-4 rounded-xl">

                            @foreach($categories as $category)

                                <option value="{{ $category->id }}">

                                    {{ $category->name }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    <div>

                        <label class="font-bold block mb-2">

                            Product Type (Veg / Non-Veg)

                        </label>

                        <select name="product_type" class="w-full border p-4 rounded-xl">

                            <option value="veg">🟢 Vegetarian (Veg)</option>

                            <option value="non_veg">🔴 Non-Vegetarian (Non-Veg)</option>

                        </select>

                    </div>

                    {{-- <div>

                        <label class="font-bold block mb-2">

                            Price

                        </label>

                        <input type="number" name="price" class="w-full border p-4 rounded-xl">

                    </div> --}}

                    <div class="col-span-2">
                        <label class="font-bold block mb-2">
                            Product Price (Regular)
                        </label>

                        <input
                            type="number"
                            step="0.01"
                            name="price"
                            class="w-full border p-4 rounded-xl"
                            required>
                    </div>

                    <div class="col-span-2">
                        <div class="flex justify-between items-center mb-3">
                            <label class="font-bold">
                                Product Variants
                            </label>

                            <button
                                type="button"
                                onclick="addVariant()"
                                class="bg-green-500 text-white px-4 py-2 rounded-lg">
                                + Add Variant
                            </button>
                        </div>

                        <div id="variants-wrapper"></div>
                    </div>

                    <div>

                        <label class="font-bold block mb-2">

                            Product Image

                        </label>

                        <input type="file" name="image" class="w-full border p-4 rounded-xl">

                    </div>

                </div>

                <div class="mt-6">

                    <label class="font-bold block mb-2">

                        Description

                    </label>

                    <textarea name="description"   id="description" rows="5" class="w-full border p-4 rounded-xl  h-64"></textarea>

                </div>

                <button class="bg-blue-500 hover:bg-blue-600 text-white px-10 py-4 rounded-xl mt-8">

                    Save Product

                </button>

            </form>

        </div>

    </div>
    <!-- CKEditor CDN -->
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

<script>
ClassicEditor
    .create(document.querySelector('#description'))
    .then(editor => {
        editor.editing.view.change(writer => {
            writer.setStyle(
                'height',
                '250px',
                editor.editing.view.document.getRoot()
            );
        });
    })
    .catch(error => {
        console.error(error);
    });
</script>

<script>
function addVariant() {
    let html = `
        <div class="grid grid-cols-12 gap-3 mb-3 variant-row">

            <div class="col-span-5">
                <input
                    type="text"
                    name="variant_name[]"
                    placeholder="Small / Medium / Large etc."
                    class="w-full border p-3 rounded-lg">
            </div>

            <div class="col-span-5">
                <input
                    type="number"
                    step="0.01"
                    name="variant_price[]"
                    placeholder="Price"
                    class="w-full border p-3 rounded-lg">
            </div>

            <div class="col-span-2">
                <button
                    type="button"
                    onclick="this.closest('.variant-row').remove()"
                    class="bg-red-500 text-white px-4 py-3 rounded-lg">
                    X
                </button>
            </div>

        </div>
    `;

    document.getElementById('variants-wrapper')
        .insertAdjacentHTML('beforeend', html);
}
</script>

@endsection