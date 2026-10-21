@extends('layouts.app')

@section('content')
<div class="p-2 sm:p-4 md:p-6">

    <div class="mb-6 sm:mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Restaurant Refund Policy</h1>
        <p class="text-gray-500 text-sm mt-1">
            Manage website Restaurant Refund Policy
        </p>
    </div>

    <div class="bg-white border border-gray-100 rounded-xl p-4 sm:p-6 shadow-sm">
        <form action="{{ route('restaurant.refund-policy.update',$restaurant->id)}}" method="POST">
            @csrf

            <textarea id="editor" name="content">
                {{ old('content', $policy->content) }}
            </textarea>

            <button type="submit"
                class="mt-4 bg-blue-500 text-white px-5 py-2 rounded-lg">
                Save Changes
            </button>
        </form>
    </div>

</div>

<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>

<script>
    ClassicEditor
        .create(document.querySelector('#editor'))
        .catch(error => {
            console.error(error);
        });
</script>
@endsection



