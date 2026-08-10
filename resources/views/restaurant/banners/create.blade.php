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
            <h1 class="text-xl font-bold text-gray-900">Add New Banner</h1>
            <p class="text-xs text-gray-500 mt-0.5">Upload responsive banners tailored for Desktop and Mobile devices</p>
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
        <form method="POST" action="{{ route('restaurant.banners.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf

            {{-- Image Inputs Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Desktop Banner Upload --}}
                <div class="space-y-3">
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-700">
                        Desktop Banner <span class="text-red-500">*</span>
                    </label>
                    
                    <div class="relative border-2 border-dashed border-gray-200 hover:border-orange-400 rounded-2xl p-4 text-center bg-gray-50/50 hover:bg-orange-50/30 transition-all cursor-pointer group flex flex-col items-center justify-center min-h-[190px]">
                        <input type="file" name="image" id="desktopImageInput" required accept="image/*"
                               class="absolute inset-0 opacity-0 cursor-pointer w-full h-full z-10"
                               onchange="previewImage(this, 'desktopPreviewContainer', 'desktopPreviewImg')">
                        
                        <div id="desktopPreviewContainer" class="hidden w-full h-36 rounded-xl overflow-hidden mb-2 relative">
                            <img id="desktopPreviewImg" src="#" alt="Desktop Preview" class="w-full h-full object-cover">
                        </div>

                        <div id="desktopPlaceholder" class="space-y-2">
                            <div class="w-10 h-10 bg-orange-100 text-orange-600 rounded-xl flex items-center justify-center mx-auto group-hover:scale-110 transition-transform">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-gray-700">Click to upload Desktop Banner</p>
                                <p class="text-[11px] text-gray-400 mt-1">Recommended: 1200 &times; 400 px (Landscape)</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Mobile Banner Upload --}}
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-700">
                            Mobile Banner <span class="text-xs font-normal text-gray-400 lowercase">(optional)</span>
                        </label>
                        <span class="text-[10px] bg-gray-100 text-gray-600 px-2 py-0.5 rounded-full font-medium">Mobile Optimized</span>
                    </div>

                    <div class="relative border-2 border-dashed border-gray-200 hover:border-amber-400 rounded-2xl p-4 text-center bg-gray-50/50 hover:bg-amber-50/30 transition-all cursor-pointer group flex flex-col items-center justify-center min-h-[190px]">
                        <input type="file" name="mobile_img" id="mobileImageInput" accept="image/*"
                               class="absolute inset-0 opacity-0 cursor-pointer w-full h-full z-10"
                               onchange="previewImage(this, 'mobilePreviewContainer', 'mobilePreviewImg')">
                        
                        <div id="mobilePreviewContainer" class="hidden w-28 h-36 rounded-xl overflow-hidden mb-2 relative mx-auto">
                            <img id="mobilePreviewImg" src="#" alt="Mobile Preview" class="w-full h-full object-cover">
                        </div>

                        <div id="mobilePlaceholder" class="space-y-2">
                            <div class="w-10 h-10 bg-amber-100 text-amber-600 rounded-xl flex items-center justify-center mx-auto group-hover:scale-110 transition-transform">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-gray-700">Click to upload Mobile Banner</p>
                                <p class="text-[11px] text-gray-400 mt-1">Recommended: 600 &times; 600 px or 800 &times; 600 px</p>
                                <p class="text-[10px] text-amber-600 font-medium mt-0.5">Falls back to desktop banner if left blank</p>
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
                        <option value="1" selected>Active (Visible on store page)</option>
                        <option value="0">Inactive (Hidden)</option>
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
                        Save Banner
                    </button>
                </div>
            </div>
        </form>
    </div>

</div>

<script>
    function previewImage(input, containerId, imgId) {
        const file = input.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById(imgId).src = e.target.result;
                document.getElementById(containerId).classList.remove('hidden');
                if (containerId === 'desktopPreviewContainer') {
                    document.getElementById('desktopPlaceholder').classList.add('hidden');
                } else {
                    document.getElementById('mobilePlaceholder').classList.add('hidden');
                }
            }
            reader.readAsDataURL(file);
        }
    }
</script>

@endsection