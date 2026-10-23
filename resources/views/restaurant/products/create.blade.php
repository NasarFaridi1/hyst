@extends('layouts.app')

@section('content')

    <div class="max-w-5xl mx-auto">

        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6 sm:mb-8">

            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold">

                Add Product

            </h1>

            <a href="/restaurant/products" class="bg-black hover:bg-gray-800 text-white px-5 py-2.5 sm:px-6 sm:py-3 rounded-xl text-sm font-semibold transition">

                Back

            </a>

        </div>

        <div class="bg-white rounded-2xl shadow p-5 sm:p-8 md:p-10">

            <form method="POST" action="/restaurant/products" enctype="multipart/form-data">

                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">

                    <div>

                        <label class="font-bold block mb-2">

                            Product Name

                        </label>

                        <input type="text" name="name" class="w-full border p-3.5 sm:p-4 rounded-xl text-sm">

                    </div>

                    <div>

                        <label class="font-bold block mb-2">

                            Category

                        </label>

                        <select name="category_id" class="w-full border p-3.5 sm:p-4 rounded-xl text-sm">

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

                        <select name="product_type" class="w-full border p-3.5 sm:p-4 rounded-xl text-sm">

                            <option value="veg">🟢 Vegetarian (Veg)</option>

                            <option value="non_veg">🔴 Non-Vegetarian (Non-Veg)</option>

                        </select>

                    </div>

                    {{-- Restaurant Special & Today's Special Options --}}
                    <div class="col-span-1 md:col-span-2 bg-amber-50/60 border border-amber-200/80 rounded-2xl p-4 sm:p-5">
                        <label class="font-bold block text-gray-900 mb-1 text-sm sm:text-base">
                            Featured Highlights (Optional)
                        </label>
                        <p class="text-xs sm:text-sm text-gray-600 mb-4">
                            Highlight this dish on your menu page with dedicated quick-filter buttons for customers.
                        </p>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                            <label class="flex items-start gap-3 bg-white border border-gray-200 rounded-xl p-3.5 cursor-pointer hover:border-amber-400 transition">
                                <input type="checkbox" name="is_restaurant_special" value="1" class="mt-1 w-4 h-4 text-amber-600 rounded border-gray-300 focus:ring-amber-500">
                                <div>
                                    <span class="block font-semibold text-gray-900 text-sm">🌟 Special Food of Restaurant</span>
                                    <span class="block text-xs text-gray-500 mt-0.5">Mark as chef's recommendation / signature dish</span>
                                </div>
                            </label>

                            <label class="flex items-start gap-3 bg-white border border-gray-200 rounded-xl p-3.5 cursor-pointer hover:border-amber-400 transition">
                                <input type="checkbox" name="is_todays_special" value="1" class="mt-1 w-4 h-4 text-amber-600 rounded border-gray-300 focus:ring-amber-500">
                                <div>
                                    <span class="block font-semibold text-gray-900 text-sm">⚡ Today's Special Food</span>
                                    <span class="block text-xs text-gray-500 mt-0.5">Mark as today's fresh daily special</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="col-span-1 md:col-span-2">
                        <label class="font-bold block mb-2">
                            Product Price (Regular)
                        </label>

                        <input
                            type="number"
                            step="0.01"
                            name="price"
                            class="w-full border p-3.5 sm:p-4 rounded-xl text-sm"
                            required>
                    </div>

                    <div class="col-span-1 md:col-span-2">
                        <div class="flex justify-between items-center mb-3">
                            <label class="font-bold">
                                Product Variants
                            </label>

                            <button
                                type="button"
                                onclick="addVariant()"
                                class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">
                                + Add Variant
                            </button>
                        </div>

                        <div id="variants-wrapper"></div>
                    </div>

                    <div class="col-span-1 md:col-span-2">

                        <label class="font-bold block mb-2">

                            Product Image

                        </label>

                        <input type="file" name="image" class="w-full border p-3.5 sm:p-4 rounded-xl text-sm">

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
        <div class="grid grid-cols-1 sm:grid-cols-12 gap-2 sm:gap-3 mb-3 variant-row bg-gray-50 sm:bg-transparent p-3 sm:p-0 rounded-xl border sm:border-0 border-gray-200">

            <div class="sm:col-span-5">
                <input
                    type="text"
                    name="variant_name[]"
                    placeholder="Small / Medium / Large etc."
                    class="w-full border p-3 rounded-lg text-sm bg-white">
            </div>

            <div class="sm:col-span-5">
                <input
                    type="number"
                    step="0.01"
                    name="variant_price[]"
                    placeholder="Price"
                    class="w-full border p-3 rounded-lg text-sm bg-white">
            </div>

            <div class="sm:col-span-2 flex justify-end sm:justify-start">
                <button
                    type="button"
                    onclick="this.closest('.variant-row').remove()"
                    class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 sm:py-3 rounded-lg text-sm font-semibold w-full sm:w-auto transition">
                    Remove
                </button>
            </div>

        </div>
    `;

    document.getElementById('variants-wrapper')
        .insertAdjacentHTML('beforeend', html);
}
</script>

@endsection