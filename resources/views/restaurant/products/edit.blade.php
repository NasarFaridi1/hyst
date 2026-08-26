@extends('layouts.app')

@section('content')

    <div class="max-w-5xl mx-auto">

        <div class="bg-white rounded-2xl shadow p-10">

            <h1 class="text-4xl font-bold mb-8">

                Edit Product

            </h1>

            <form method="POST" action="/restaurant/products/{{ $product->id }}" enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <div class="grid grid-cols-2 gap-6">

                    <div>

                        <label class="font-bold block mb-2">

                            Product Name

                        </label>

                        <input type="text" name="name" value="{{ $product->name }}" class="w-full border p-4 rounded-xl">

                    </div>

                    <div>

                        <label class="font-bold block mb-2">

                            Category

                        </label>

                        <select name="category_id" class="w-full border p-4 rounded-xl">

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

                        <select name="product_type" class="w-full border p-4 rounded-xl">

                            <option value="veg" {{ ($product->product_type ?? 'veg') == 'veg' ? 'selected' : '' }}>🟢 Vegetarian (Veg)</option>

                            <option value="non_veg" {{ ($product->product_type ?? '') == 'non_veg' ? 'selected' : '' }}>🔴 Non-Vegetarian (Non-Veg)</option>

                        </select>

                    </div>

                    <div>

                        <label class="font-bold block mb-2">

                            Price(Regular)

                        </label>

                        <input type="number" name="price" value="{{ $product->price }}"
                            class="w-full border p-4 rounded-xl">

                    </div>

                    <div class="col-span-2">
                        <div class="flex justify-between items-center mb-3">
                            <label class="font-bold">Variants</label>

                            <button
                                type="button"
                                onclick="addVariant()"
                                class="bg-green-500 text-white px-4 py-2 rounded">
                                Add Variant
                            </button>
                        </div>

                        <div id="variants-wrapper">

                            @foreach($product->variants->where('is_default',0) as $variant)

                                <div class="grid grid-cols-12 gap-3 mb-3 variant-row">

                                    <input type="hidden"
                                        name="variant_ids[]"
                                        value="{{ $variant->id }}">

                                    <div class="col-span-5">
                                        <input type="text"
                                            name="variant_names[]"
                                            value="{{ $variant->name }}"
                                            class="w-full border p-3 rounded">
                                    </div>

                                    <div class="col-span-5">
                                        <input type="number"
                                            step="0.01"
                                            name="variant_prices[]"
                                            value="{{ $variant->price }}"
                                            class="w-full border p-3 rounded">
                                    </div>

                                    <div class="col-span-2">
                                        <button
                                            type="button"
                                            onclick="this.closest('.variant-row').remove()"
                                            class="bg-red-500 text-white px-4 py-3 rounded">
                                            X
                                        </button>
                                    </div>

                                </div>

                            @endforeach

                        </div>
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
        <div class="grid grid-cols-12 gap-3 mb-3 variant-row">

            <input type="hidden" name="variant_ids[]" value="">

            <div class="col-span-5">
                <input type="text"
                    name="variant_names[]"
                    placeholder="Variant Name"
                    class="w-full border p-3 rounded">
            </div>

            <div class="col-span-5">
                <input type="number"
                    step="0.01"
                    name="variant_prices[]"
                    placeholder="Price"
                    class="w-full border p-3 rounded">
            </div>

            <div class="col-span-2">
                <button
                    type="button"
                    onclick="this.closest('.variant-row').remove()"
                    class="bg-red-500 text-white px-4 py-3 rounded">
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