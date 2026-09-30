@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Edit Blog Post</h1>
            <p class="text-gray-500 mt-1">Update blog details, image, or video media.</p>
        </div>
        <a href="{{ route('admin.blogs.index') }}"
           class="inline-flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 px-5 py-2.5 rounded-xl font-medium transition text-sm">
            &larr; Back to Blogs
        </a>
    </div>

    @if($errors->any())
        <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-lg">
            <div class="font-bold mb-1">Please fix the following errors:</div>
            <ul class="list-disc list-inside text-sm">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
        <form action="{{ route('admin.blogs.update', $blog->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Title -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Blog Title <span class="text-red-500">*</span></label>
                    <input type="text" name="title" value="{{ old('title', $blog->title) }}" required
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none">
                </div>

                <!-- Slug -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">URL Slug</label>
                    <input type="text" name="slug" value="{{ old('slug', $blog->slug) }}"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none">
                </div>
            </div>

            <!-- Description -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Description / Content</label>
                <textarea name="description" id="editor" rows="10"
                          class="w-full border border-gray-200 rounded-xl p-4 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none text-base">{{ old('description', $blog->description) }}</textarea>
            </div>

            <!-- Media Section -->
            <div class="bg-gray-50/70 p-6 rounded-2xl border border-gray-100 mb-6 space-y-6">
                <h3 class="text-base font-bold text-gray-900 border-b border-gray-200 pb-3">Media Attachments</h3>
                
                <!-- Image Upload & Preview -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Featured Image</label>
                    @if($blog->image)
                        <div class="mb-3 flex items-center gap-4">
                            <img src="{{ asset($blog->image) }}" alt="{{ $blog->title }}" class="w-24 h-24 object-cover rounded-xl border border-gray-200 shadow-sm">
                            <span class="text-xs text-gray-500">Current Image Attached</span>
                        </div>
                    @endif
                    <input type="file" name="image" accept="image/*"
                           class="w-full border border-gray-200 rounded-xl p-3 bg-white focus:ring-2 focus:ring-orange-500 outline-none text-sm">
                    <p class="text-xs text-gray-400 mt-1">Leave empty to keep existing image.</p>
                </div>

                <!-- Video File Upload or Link -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-2">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Upload New Video File</label>
                        @if($blog->video && !Str::startsWith($blog->video, ['http://', 'https://']))
                            <div class="mb-2 text-xs text-purple-700 bg-purple-50 p-2 rounded border border-purple-200">
                                🎬 Current Video: {{ basename($blog->video) }}
                            </div>
                        @endif
                        <input type="file" name="video_file" accept="video/mp4,video/webm,video/mov,video/quicktime"
                               class="w-full border border-gray-200 rounded-xl p-3 bg-white focus:ring-2 focus:ring-orange-500 outline-none text-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">OR Video Link (YouTube / Vimeo / External MP4)</label>
                        <input type="url" name="video_url" value="{{ old('video_url', Str::startsWith($blog->video, ['http://', 'https://']) ? $blog->video : '') }}"
                               placeholder="https://www.youtube.com/watch?v=..."
                               class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-white focus:ring-2 focus:ring-orange-500 outline-none text-sm">
                    </div>
                </div>
            </div>

            <!-- Status -->
            <div class="mb-8">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Publishing Status <span class="text-red-500">*</span></label>
                <select name="status" class="w-full md:w-1/2 border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none">
                    <option value="active" {{ old('status', $blog->status) == 'active' ? 'selected' : '' }}>Active (Published on frontend)</option>
                    <option value="inactive" {{ old('status', $blog->status) == 'inactive' ? 'selected' : '' }}>Inactive (Draft / Hidden)</option>
                </select>
            </div>

            <!-- Submit Button -->
            <div class="flex items-center gap-4">
                <button type="submit"
                        class="bg-gradient-to-r from-orange-600 to-amber-600 hover:from-orange-700 hover:to-amber-700 text-white font-bold px-8 py-3.5 rounded-xl shadow-md transition">
                    Update Blog Post
                </button>
                <a href="{{ route('admin.blogs.index') }}" class="text-gray-500 hover:text-gray-700 font-medium text-sm">
                    Cancel
                </a>
            </div>
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
