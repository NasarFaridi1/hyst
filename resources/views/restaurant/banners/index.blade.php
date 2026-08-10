@extends('layouts.app')

@section('content')

<div class="p-6 md:p-8 max-w-7xl mx-auto space-y-6">

    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
        <div>
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-orange-50 text-orange-600 flex items-center justify-center font-bold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-xl font-bold text-gray-900">Restaurant Banners</h1>
                    <p class="text-xs text-gray-500 mt-0.5">Manage separate Desktop and Mobile promotional banners</p>
                </div>
            </div>
        </div>

        <a href="{{ route('restaurant.banners.create') }}"
           class="inline-flex items-center justify-center gap-2 bg-gradient-to-r from-orange-500 to-amber-600 hover:from-orange-600 hover:to-amber-700 text-white px-5 py-2.5 rounded-xl text-sm font-semibold shadow-md shadow-orange-500/20 transition-all duration-200 hover:shadow-lg">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
            </svg>
            Add New Banner
        </a>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl text-sm font-medium flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">&times;</button>
        </div>
    @endif

    {{-- Banner List Table / Cards --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        @if(count($banners) > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/70 border-b border-gray-100 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            <th class="px-6 py-4">Desktop Banner</th>
                            <th class="px-6 py-4">Mobile Banner</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        @foreach($banners as $banner)
                            <tr class="hover:bg-gray-50/50 transition-colors duration-150">

                                {{-- Desktop Banner Preview --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="relative group w-36 h-20 rounded-xl overflow-hidden bg-gray-100 border border-gray-200 flex-shrink-0">
                                            @if($banner->image && file_exists(public_path($banner->image)))
                                                <img src="{{ asset($banner->image) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-gray-400 text-xs">No Desktop Image</div>
                                            @endif
                                            <span class="absolute bottom-1 left-1 bg-black/70 text-white text-[10px] font-semibold px-2 py-0.5 rounded-md backdrop-blur-sm">
                                                Desktop (16:9)
                                            </span>
                                        </div>
                                    </div>
                                </td>

                                {{-- Mobile Banner Preview --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="relative group w-20 h-20 rounded-xl overflow-hidden bg-gray-100 border border-gray-200 flex-shrink-0">
                                            @if($banner->mobile_img && file_exists(public_path($banner->mobile_img)))
                                                <img src="{{ asset($banner->mobile_img) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                                <span class="absolute bottom-1 left-1 bg-black/70 text-white text-[10px] font-semibold px-1.5 py-0.5 rounded-md backdrop-blur-sm">
                                                    Mobile
                                                </span>
                                            @else
                                                <div class="w-full h-full flex flex-col items-center justify-center text-gray-400 text-[10px] text-center p-1 leading-tight">
                                                    <span class="font-medium text-gray-500">Same as</span>
                                                    <span>Desktop</span>
                                                </div>
                                                <span class="absolute bottom-1 left-1 bg-gray-600/70 text-white text-[9px] font-semibold px-1 py-0.5 rounded">
                                                    Fallback
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                {{-- Status --}}
                                <td class="px-6 py-4">
                                    @if($banner->status)
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-full text-xs font-semibold">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                            Active
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-gray-100 text-gray-600 border border-gray-200 rounded-full text-xs font-semibold">
                                            <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                                            Inactive
                                        </span>
                                    @endif
                                </td>

                                {{-- Action Buttons --}}
                                <td class="px-6 py-4 text-right">
                                    <div class="inline-flex items-center gap-2">
                                        <a href="{{ route('restaurant.banners.edit', $banner->id) }}"
                                           class="inline-flex items-center gap-1 px-3 py-1.5 bg-amber-50 hover:bg-amber-100 text-amber-700 border border-amber-200 rounded-lg text-xs font-semibold transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                            Edit
                                        </a>

                                        <form action="{{ route('restaurant.banners.destroy', $banner->id) }}"
                                              method="POST"
                                              class="inline"
                                              onsubmit="return confirm('Are you sure you want to delete this banner?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="inline-flex items-center gap-1 px-3 py-1.5 bg-red-50 hover:bg-red-100 text-red-700 border border-red-200 rounded-lg text-xs font-semibold transition-colors">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            {{-- Empty State --}}
            <div class="py-16 px-6 text-center">
                <div class="w-16 h-16 bg-orange-50 text-orange-500 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h3 class="text-base font-bold text-gray-900 mb-1">No Banners Added Yet</h3>
                <p class="text-xs text-gray-500 max-w-sm mx-auto mb-6">Create desktop & mobile promotional banners to engage customers on your restaurant store page.</p>
                <a href="{{ route('restaurant.banners.create') }}"
                   class="inline-flex items-center gap-2 bg-gradient-to-r from-orange-500 to-amber-600 hover:from-orange-600 hover:to-amber-700 text-white px-5 py-2.5 rounded-xl text-xs font-semibold shadow-md">
                    + Add Your First Banner
                </a>
            </div>
        @endif
    </div>

</div>

@endsection