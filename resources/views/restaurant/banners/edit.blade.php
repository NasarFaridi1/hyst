@extends('layouts.app')

@section('content')

<div class="max-w-3xl mx-auto p-6 md:p-8 space-y-6">

    {{-- Breadcrumb / Header --}}
    <div class="flex items-center justify-between">
        <div>
            <a href="{{ route('restaurant.banners.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-gray-500 hover:text-gray-800 transition-colors mb-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Banners
            </a>
            <h1 class="text-xl font-bold text-gray-900">Edit Banner</h1>
            <p class="text-xs text-gray-500 mt-0.5">Update desktop or mobile image assets and visibility status</p>
        </div>
    </div>

    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-xs space-y-1">
            <div class="font-bold">Please correct the errors below:</div>
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form Card --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 md:p-8">
        <form method="POST" action="{{ route('restaurant.banners.update', $banner->id) }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Image Inputs Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Desktop Banner Upload & Preview --}}
                <div class="space-y-3">
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-700">
                        Desktop Banner
                    </label>

                    {{-- Current Preview --}}
                    <div class="relative w-full h-36 rounded-2xl overflow-hidden bg-gray-100 border border-gray-200 shadow-inner">
                        @if($banner->image && file_exists(public_path($banner->image)))
                            <img id="desktopPreviewImg" src="{{ asset($banner->image) }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400 text-xs">No Desktop Image Uploaded</div>
                        @endif
                        <span class="absolute bottom-2 left-2 bg-black/70 text-white text-[10px] font-semibold px-2 py-0.5 rounded-md backdrop-blur-sm">
                            Current Desktop
                        </span>
                    </div>

                    <div class="relative border border-gray-200 hover:border-orange-400 rounded-xl p-3 bg-gray-50/50 transition-all cursor-pointer">
                        <input type="file" name="image" id="desktopImageInput" accept="image/*"
                               class="absolute inset-0 opacity-0 cursor-pointer w-full h-full z-10"
                               onchange="previewImage(this, 'desktopPreviewImg')">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-orange-100 text-orange-600 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div class="text-left">
                                <p class="text-xs font-semibold text-gray-700">Replace Desktop Image</p>
                                <p class="text-[10px] text-gray-400">Leave blank to keep existing image</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Mobile Banner Upload & Preview --}}
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-700">
                            Mobile Banner
                        </label>
                        <span class="text-[10px] bg-gray-100 text-gray-600 px-2 py-0.5 rounded-full font-medium">Mobile Device</span>
                    </div>

                    {{-- Current Preview --}}
                    <div class="relative w-full h-36 rounded-2xl overflow-hidden bg-gray-100 border border-gray-200 shadow-inner flex items-center justify-center">
                        @if($banner->mobile_img && file_exists(public_path($banner->mobile_img)))
                            <img id="mobilePreviewImg" src="{{ asset($banner->mobile_img) }}" class="w-full h-full object-cover">
                            <span class="absolute bottom-2 left-2 bg-black/70 text-white text-[10px] font-semibold px-2 py-0.5 rounded-md backdrop-blur-sm">
                                Current Mobile
                            </span>
                        @else
                            <div id="noMobileText" class="text-center p-2">
                                <span class="block text-xs font-medium text-gray-500">No Mobile Specific Image</span>
                                <span class="text-[10px] text-gray-400">Using Desktop Banner on mobile devices</span>
                            </div>
                            <img id="mobilePreviewImg" src="#" class="hidden w-full h-full object-cover">
                        @endif
                    </div>

                    <div class="relative border border-gray-200 hover:border-amber-400 rounded-xl p-3 bg-gray-50/50 transition-all cursor-pointer">
                        <input type="file" name="mobile_img" id="mobileImageInput" accept="image/*"
                               class="absolute inset-0 opacity-0 cursor-pointer w-full h-full z-10"
                               onchange="previewImage(this, 'mobilePreviewImg', 'noMobileText')">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-amber-100 text-amber-600 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div class="text-left">
                                <p class="text-xs font-semibold text-gray-700">
                                    {{ $banner->mobile_img ? 'Replace Mobile Image' : 'Upload Mobile Image' }}
                                </p>
                                <p class="text-[10px] text-gray-400">Recommended: 600 &times; 600 px or 800 &times; 600 px</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Status Selection --}}
            <div class="pt-4 border-t border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="w-full sm:w-64">
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-2">
                        Banner Status
                    </label>
                    <select name="status" class="w-full border border-gray-200 rounded-xl p-2.5 text-sm font-medium focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition-all">
                        <option value="1" {{ $banner->status ? 'selected' : '' }}>Active (Visible on store page)</option>
                        <option value="0" {{ !$banner->status ? 'selected' : '' }}>Inactive (Hidden)</option>
                    </select>
                </div>

                {{-- Action Buttons --}}
                <div class="flex items-center gap-3 pt-2 sm:pt-0">
                    <a href="{{ route('restaurant.banners.index') }}"
                       class="px-5 py-2.5 border border-gray-200 hover:bg-gray-50 text-gray-700 rounded-xl text-sm font-semibold transition-colors">
                        Cancel
                    </a>
                    <button type="submit"
                            class="px-6 py-2.5 bg-gradient-to-r from-orange-500 to-amber-600 hover:from-orange-600 hover:to-amber-700 text-white rounded-xl text-sm font-semibold shadow-md shadow-orange-500/20 transition-all hover:shadow-lg">
                        Update Banner
                    </button>
                </div>
            </div>
        </form>
    </div>

</div>

<script>
    function previewImage(input, imgId, noTextId = null) {
        const file = input.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.getElementById(imgId);
                img.src = e.target.result;
                img.classList.remove('hidden');
                if (noTextId) {
                    const noTxt = document.getElementById(noTextId);
                    if (noTxt) noTxt.classList.add('hidden');
                }
            }
            reader.readAsDataURL(file);
        }
    }
</script>

@endsection