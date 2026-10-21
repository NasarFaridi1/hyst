@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 sm:mb-8 gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 tracking-tight">Blog Posts</h1>
            <p class="text-gray-500 text-xs sm:text-sm mt-1">Manage articles, news, images, and videos for the frontend blog section</p>
        </div>
        <a href="{{ route('admin.blogs.create') }}"
           class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-gradient-to-r from-orange-600 to-amber-600 hover:from-orange-700 hover:to-amber-700 text-white font-semibold px-5 sm:px-6 py-3 rounded-xl shadow-md transition duration-200 text-sm">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            <span>Add New Blog</span>
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 rounded-xl shadow-sm flex justify-between items-center text-sm">
            <div class="flex items-center gap-2">
                <span class="text-emerald-500">✓</span>
                <span>{{ session('success') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 font-bold ml-4">&times;</button>
        </div>
    @endif

    <!-- Filters Section -->
    <div class="bg-white p-4 sm:p-6 rounded-2xl shadow-sm border border-gray-100 mb-6">
        <form method="GET" action="{{ route('admin.blogs.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-3 sm:gap-4 items-end">
            <!-- Search -->
            <div class="lg:col-span-6">
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Search</label>
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Search by title or content..."
                           class="w-full border border-gray-200 rounded-xl pl-10 pr-4 py-2.5 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none text-sm transition">
                    <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-sm">🔍</span>
                </div>
            </div>

            <!-- Status Dropdown -->
            <div class="lg:col-span-3">
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Status</label>
                <select name="status" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none text-sm bg-white transition">
                    <option value="">All Statuses</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <!-- Actions (Filter + Reset) -->
            <div class="flex items-center gap-2 sm:col-span-2 lg:col-span-3">
                <button type="submit" class="flex-1 inline-flex items-center justify-center bg-gray-900 hover:bg-black text-white px-5 py-2.5 rounded-xl font-medium text-sm transition shadow-sm">
                    Filter
                </button>
                <a href="{{ route('admin.blogs.index') }}" class="flex-1 text-center bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2.5 rounded-xl font-medium text-sm transition">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Mobile Card View (shown on screens < md) -->
    <div class="block md:hidden space-y-4">
        @forelse($blogs as $blog)
            <div class="bg-white rounded-2xl p-4 sm:p-5 border border-gray-100 shadow-sm space-y-3.5 transition hover:shadow-md">
                <!-- Top Row: Thumbnail + Status & Date -->
                <div class="flex items-start justify-between gap-3">
                    <div class="flex items-center gap-3 min-w-0">
                        @if($blog->image)
                            <img src="{{ asset($blog->image) }}" alt="{{ $blog->title }}" class="w-14 h-14 object-cover rounded-xl border border-gray-200 shadow-sm flex-shrink-0">
                        @else
                            <div class="w-14 h-14 bg-gray-100 rounded-xl flex items-center justify-center text-gray-400 text-xs flex-shrink-0 font-medium">
                                📷 No Img
                            </div>
                        @endif

                        <div class="min-w-0">
                            @if($blog->status == 'active')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5 animate-pulse"></span> Active
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-gray-100 text-gray-600">
                                    Inactive
                                </span>
                            @endif
                            <div class="text-xs text-gray-400 mt-1 flex items-center gap-1">
                                <span>📅</span> {{ $blog->created_at ? $blog->created_at->format('M d, Y') : 'N/A' }}
                            </div>
                        </div>
                    </div>

                    @if($blog->video)
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded bg-purple-50 text-purple-700 text-xs font-medium border border-purple-200 flex-shrink-0">
                            🎬 Video
                        </span>
                    @endif
                </div>

                <!-- Blog Title & Slug -->
                <div>
                    <h3 class="font-bold text-gray-900 text-base leading-snug line-clamp-2">
                        {{ $blog->title }}
                    </h3>
                    <p class="text-xs text-gray-400 font-mono mt-1 break-all">
                        /blog/{{ $blog->slug }}
                    </p>
                </div>

                <!-- SEO Configured Badge -->
                @if($blog->meta_title || $blog->meta_description)
                    <div class="flex items-center gap-1.5 text-xs text-emerald-700 bg-emerald-50/80 px-2.5 py-1 rounded-lg border border-emerald-100 w-fit">
                        <span>✓</span> SEO Configured
                    </div>
                @endif

                <!-- Mobile Action Buttons -->
                <div class="grid grid-cols-3 gap-2 pt-2 border-t border-gray-100">
                    <a href="{{ route('front.blogs.show', $blog->slug) }}" target="_blank"
                       class="inline-flex items-center justify-center gap-1.5 py-2 px-2.5 text-xs font-semibold text-gray-700 bg-gray-50 hover:bg-gray-100 border border-gray-200 rounded-xl transition">
                        <span>👁️</span> View
                    </a>
                    <a href="{{ route('admin.blogs.edit', $blog->id) }}"
                       class="inline-flex items-center justify-center gap-1.5 py-2 px-2.5 text-xs font-semibold text-blue-700 bg-blue-50 hover:bg-blue-100 border border-blue-200 rounded-xl transition">
                        <span>✏️</span> Edit
                    </a>
                    <form action="{{ route('admin.blogs.destroy', $blog->id) }}" method="POST"
                          onsubmit="return confirm('Are you sure you want to delete this blog post?');" class="inline-block w-full">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="w-full inline-flex items-center justify-center gap-1.5 py-2 px-2.5 text-xs font-semibold text-red-700 bg-red-50 hover:bg-red-100 border border-red-200 rounded-xl transition">
                            <span>🗑️</span> Del
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-2xl p-8 text-center text-gray-500 border border-gray-100 shadow-sm">
                <div class="text-4xl mb-3">📰</div>
                <div class="font-medium text-gray-700">No blog posts found.</div>
                <p class="text-xs text-gray-400 mt-1">Click "Add New Blog" above to create your first article.</p>
            </div>
        @endforelse
    </div>

    <!-- Desktop / Tablet Table View (shown on screens >= md) -->
    <div class="hidden md:block bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-[760px]">
                <thead>
                    <tr class="bg-gray-50/70 border-b border-gray-100 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        <th class="py-4 px-6 w-2/5">Blog Post</th>
                        <th class="py-4 px-6 w-32">Media</th>
                        <th class="py-4 px-6 w-28">Status</th>
                        <th class="py-4 px-6 w-32">Created Date</th>
                        <th class="py-4 px-6 text-right w-44">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse($blogs as $blog)
                        <tr class="hover:bg-gray-50/60 transition">
                            <td class="py-4 px-6">
                                <div class="font-bold text-gray-900 mb-1 leading-snug line-clamp-2" title="{{ $blog->title }}">
                                    {{ $blog->title }}
                                </div>
                                <div class="text-xs text-gray-400 font-mono break-all line-clamp-1" title="/blog/{{ $blog->slug }}">
                                    /blog/{{ $blog->slug }}
                                </div>
                                @if($blog->meta_title || $blog->meta_description)
                                    <span class="inline-flex items-center gap-1 text-[11px] font-medium text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded mt-1 border border-emerald-100">
                                        ✓ SEO Configured
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-2">
                                    @if($blog->image)
                                        <img src="{{ asset($blog->image) }}" alt="{{ $blog->title }}" class="w-12 h-12 object-cover rounded-xl border border-gray-200 flex-shrink-0 shadow-sm">
                                    @else
                                        <div class="w-12 h-12 bg-gray-100 rounded-xl flex items-center justify-center text-gray-400 text-xs flex-shrink-0 font-medium">No Img</div>
                                    @endif

                                    @if($blog->video)
                                        <span class="inline-flex items-center px-2 py-1 rounded bg-purple-50 text-purple-700 text-xs font-medium border border-purple-200 flex-shrink-0" title="Video Attached">
                                            🎬
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="py-4 px-6 whitespace-nowrap">
                                @if($blog->status == 'active')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></span> Active
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-600">
                                        Inactive
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-gray-500 text-xs whitespace-nowrap">
                                {{ $blog->created_at ? $blog->created_at->format('M d, Y') : 'N/A' }}
                            </td>
                            <td class="py-4 px-6 text-right whitespace-nowrap space-x-1.5">
                                <a href="{{ route('front.blogs.show', $blog->slug) }}" target="_blank"
                                   class="inline-inline-flex p-2 text-gray-600 hover:text-gray-900 bg-gray-50 hover:bg-gray-100 border border-gray-200 rounded-lg transition" title="Preview on Frontend">
                                    👁️
                                </a>
                                <a href="{{ route('admin.blogs.edit', $blog->id) }}"
                                   class="inline-inline-flex p-2 text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 border border-blue-200 rounded-lg transition" title="Edit Post">
                                    ✏️ Edit
                                </a>
                                <form action="{{ route('admin.blogs.destroy', $blog->id) }}" method="POST" class="inline-block"
                                      onsubmit="return confirm('Are you sure you want to delete this blog post?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-red-600 hover:text-red-800 bg-red-50 hover:bg-red-100 border border-red-200 rounded-lg transition" title="Delete Post">
                                        🗑️ Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-gray-500">
                                <div class="text-4xl mb-3">📰</div>
                                <div class="font-medium text-gray-700">No blog posts found.</div>
                                <p class="text-xs text-gray-400 mt-1">Click "Add New Blog" above to create your first article.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($blogs->hasPages())
        <div class="mt-6 p-4 bg-white rounded-2xl border border-gray-100 shadow-sm">
            {{ $blogs->links() }}
        </div>
    @endif
</div>
@endsection
