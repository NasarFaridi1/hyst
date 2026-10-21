@extends('layouts.app')

@section('content')

    <div class="max-w-5xl mx-auto">

        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6 sm:mb-8">

            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold">

                Edit Product

            </h1>

            <a href="/restaurant/products" class="bg-black hover:bg-gray-800 text-white px-5 py-2.5 sm:px-6 sm:py-3 rounded-xl text-sm font-semibold transition">

                Back

            </a>

        </div>

        <div class="bg-white rounded-2xl shadow p-5 sm:p-8 md:p-10">

            <form method="POST" action="/restaurant/products/{{ $product->id }}" enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">

                    <div>

                        <label class="font-bold block mb-2">

                            Product Name

                        </label>

                        <input type="text" name="name" value="{{ $product->name }}" class="w-full border p-3.5 sm:p-4 rounded-xl text-sm">

                    </div>

                    <div>

                        <label class="font-bold block mb-2">

                            Category

                        </label>

                        <select name="category_id" class="w-full border p-3.5 sm:p-4 rounded-xl text-sm">

                            @foreach($categories as $category)

                                <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>

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

                            <option value="veg" {{ ($product->product_type ?? 'veg') == 'veg' ? 'selected' : '' }}>🟢 Vegetarian (Veg)</option>

                            <option value="non_veg" {{ ($product->product_type ?? '') == 'non_veg' ? 'selected' : '' }}>🔴 Non-Vegetarian (Non-Veg)</option>

                        </select>

                    </div>

                    <div>

                        <label class="font-bold block mb-2">

                            Price(Regular)

                        </label>

                        <input type="number" step="0.01" name="price" value="{{ $product->price }}"
                            class="w-full border p-3.5 sm:p-4 rounded-xl text-sm" required>

                    </div>

                    <div class="col-span-1 md:col-span-2">
                        <div class="flex justify-between items-center mb-3">
                            <label class="font-bold">Variants</label>

                            <button
                                type="button"
                                onclick="addVariant()"
                                class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">
                                + Add Variant
                            </button>
                        </div>

                        <div id="variants-wrapper">

                            @foreach($product->variants->where('is_default',0) as $variant)

                                <div class="grid grid-cols-1 sm:grid-cols-12 gap-2 sm:gap-3 mb-3 variant-row bg-gray-50 sm:bg-transparent p-3 sm:p-0 rounded-xl border sm:border-0 border-gray-200">

                                    <input type="hidden"
                                        name="variant_ids[]"
                                        value="{{ $variant->id }}">

                                    <div class="sm:col-span-5">
                                        <input type="text"
                                            name="variant_names[]"
                                            value="{{ $variant->name }}"
                                            class="w-full border p-3 rounded-lg text-sm bg-white">
                                    </div>

                                    <div class="sm:col-span-5">
                                        <input type="number"
                                            step="0.01"
                                            name="variant_prices[]"
                                            value="{{ $variant->price }}"
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

                            @endforeach

                        </div>
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

                    <textarea name="description" id="description" rows="5"
                        class="w-full border p-4 rounded-xl  h-64">{{ old('description', $product->description ?? '') }}</textarea>

                </div>


                <button class="bg-green-500 text-white px-10 py-4 rounded-xl mt-8">

                    Update Product

                </button>

            </form>

        </div>

    </div>
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

            <input type="hidden" name="variant_ids[]" value="">

            <div class="sm:col-span-5">
                <input type="text"
                    name="variant_names[]"
                    placeholder="Variant Name"
                    class="w-full border p-3 rounded-lg text-sm bg-white">
            </div>

            <div class="sm:col-span-5">
                <input type="number"
                    step="0.01"
                    name="variant_prices[]"
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