@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Blog Posts</h1>
            <p class="text-gray-500 mt-1">Manage articles, news, images, and videos for the frontend blog section</p>
        </div>
        <a href="{{ route('admin.blogs.create') }}"
           class="inline-flex items-center gap-2 bg-gradient-to-r from-orange-600 to-amber-600 hover:from-orange-700 hover:to-amber-700 text-white font-semibold px-6 py-3 rounded-xl shadow-md transition duration-200">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Add New Blog
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 rounded-lg shadow-sm flex justify-between items-center">
            <span>{{ session('success') }}</span>
            <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 font-bold">&times;</button>
        </div>
    @endif

    <!-- Filters -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 mb-6">
        <form method="GET" action="{{ route('admin.blogs.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Search</label>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Search by title or content..."
                       class="w-full border border-gray-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none text-sm">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Status</label>
                <select name="status" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none text-sm">
                    <option value="">All Statuses</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <div class="flex items-end gap-2">
                <button type="submit" class="bg-gray-900 hover:bg-black text-white px-6 py-2.5 rounded-xl font-medium text-sm transition">
                    Filter
                </button>
                <a href="{{ route('admin.blogs.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-5 py-2.5 rounded-xl font-medium text-sm transition">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Blog List Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-100 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        <th class="py-4 px-6">Blog Post</th>
                        <th class="py-4 px-6">Media</th>
                        <th class="py-4 px-6">Status</th>
                        <th class="py-4 px-6">Created Date</th>
                        <th class="py-4 px-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse($blogs as $blog)
                        <tr class="hover:bg-gray-50/60 transition">
                            <td class="py-4 px-6">
                                <div class="font-bold text-gray-900 mb-1">{{ $blog->title }}</div>
                                <div class="text-xs text-gray-400 font-mono">/blog/{{ $blog->slug }}</div>
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-2">
                                    @if($blog->image)
                                        <img src="{{ asset($blog->image) }}" alt="{{ $blog->title }}" class="w-12 h-12 object-cover rounded-lg border border-gray-200">
                                    @else
                                        <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center text-gray-400 text-xs">No Image</div>
                                    @endif

                                    @if($blog->video)
                                        <span class="inline-flex items-center px-2 py-1 rounded bg-purple-50 text-purple-700 text-xs font-medium border border-purple-200">
                                            🎬 Video Attached
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                @if($blog->status == 'active')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                                        Active
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-600">
                                        Inactive
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-gray-500 text-xs">
                                {{ $blog->created_at ? $blog->created_at->format('M d, Y') : 'N/A' }}
                            </td>
                            <td class="py-4 px-6 text-right space-x-2">
                                <a href="{{ route('front.blogs.show', $blog->slug) }}" target="_blank"
                                   class="inline-block p-2 text-gray-500 hover:text-gray-900 bg-gray-50 hover:bg-gray-100 rounded-lg transition" title="Preview">
                                    👁️
                                </a>
                                <a href="{{ route('admin.blogs.edit', $blog->id) }}"
                                   class="inline-block p-2 text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 rounded-lg transition" title="Edit">
                                    ✏️ Edit
                                </a>
                                <form action="{{ route('admin.blogs.destroy', $blog->id) }}" method="POST" class="inline-block"
                                      onsubmit="return confirm('Are you sure you want to delete this blog post?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-red-600 hover:text-red-800 bg-red-50 hover:bg-red-100 rounded-lg transition" title="Delete">
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

        @if($blogs->hasPages())
            <div class="p-4 border-t border-gray-100">
                {{ $blogs->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
