@extends('layouts.admin')
@section('title', 'Blog Posts')
@section('header-actions')
<a href="{{ route('admin.blog.create') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl">+ New Post</a>
@endsection
@section('content')
<div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
    <table class="w-full">
        <thead><tr class="bg-gray-50 border-b border-gray-200">
            <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase">Title</th>
            <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase">Status</th>
            <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase">Views</th>
            <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase">Published</th>
            <th class="text-right px-5 py-3 text-xs font-semibold text-gray-500 uppercase">Actions</th>
        </tr></thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($posts as $post)
            <tr class="hover:bg-gray-50">
                <td class="px-5 py-4">
                    <p class="font-semibold text-sm text-gray-900">{{ $post->title }}</p>
                    <p class="text-xs text-gray-400 mt-0.5 flex items-center gap-2">
                        /blog/{{ $post->slug }}
                        <span>· {{ $post->reading_time }} min read</span>
                        @if($post->tags) · {{ implode(', ', array_slice($post->tags, 0, 2)) }} @endif
                    </p>
                </td>
                <td class="px-5 py-4">
                    <span class="px-2.5 py-1 text-xs font-semibold rounded-full {{ $post->status === 'published' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                        {{ ucfirst($post->status) }}
                    </span>
                </td>
                <td class="px-5 py-4 text-sm text-gray-600">{{ $post->views }}</td>
                <td class="px-5 py-4 text-sm text-gray-500">{{ $post->published_at ? $post->published_at->format('M d, Y') : '—' }}</td>
                <td class="px-5 py-4 text-right">
                    <div class="flex items-center justify-end gap-2">
                        @if($post->status === 'published')
                        <a href="{{ route('blog.show', $post->slug) }}" target="_blank" class="p-1.5 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="View">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        </a>
                        @endif
                        <a href="{{ route('admin.blog.edit', $post) }}" class="p-1.5 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                        </a>
                        <form method="POST" action="{{ route('admin.blog.destroy', $post) }}" onsubmit="return confirm('Delete this post?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="px-5 py-12 text-center text-gray-400">
                No posts yet. <a href="{{ route('admin.blog.create') }}" class="text-blue-600 hover:underline">Write your first article →</a>
            </td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
