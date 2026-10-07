@extends('layouts.admin')
@section('title', 'Projects')
@section('header-actions')
<a href="{{ route('admin.projects.create') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl transition-colors">+ New Project</a>
@endsection
@section('content')
<div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
    <table class="w-full">
        <thead><tr class="bg-gray-50 border-b border-gray-200">
            <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase">Title</th>
            <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase">Category</th>
            <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase">Status</th>
            <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase">Views</th>
            <th class="text-right px-5 py-3 text-xs font-semibold text-gray-500 uppercase">Actions</th>
        </tr></thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($projects as $project)
            <tr class="hover:bg-gray-50 transition-colors">
                <td class="px-5 py-4">
                    <p class="font-semibold text-gray-900 text-sm">{{ $project->title }}</p>
                    <p class="text-xs text-gray-400 mt-0.5">/projects/{{ $project->slug }}</p>
                </td>
                <td class="px-5 py-4 text-sm text-gray-600 capitalize">{{ $project->category }}</td>
                <td class="px-5 py-4">
                    <span class="px-2.5 py-1 text-xs font-semibold rounded-full {{ $project->is_published ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                        {{ $project->is_published ? 'Published' : 'Draft' }}
                    </span>
                    @if($project->is_featured)
                    <span class="ml-1 px-2.5 py-1 text-xs font-semibold rounded-full bg-amber-100 text-amber-700">⭐ Featured</span>
                    @endif
                </td>
                <td class="px-5 py-4 text-sm text-gray-600">{{ $project->views }}</td>
                <td class="px-5 py-4">
                    <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('projects.show', $project->slug) }}" target="_blank" class="p-1.5 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="View">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        </a>
                        <form method="POST" action="{{ route('admin.projects.toggle-featured', $project) }}">
                            @csrf
                            <button type="submit" class="p-1.5 text-gray-400 hover:text-amber-500 hover:bg-amber-50 rounded-lg transition-colors" title="{{ $project->is_featured ? 'Remove featured' : 'Mark featured' }}">
                                <svg class="w-4 h-4" fill="{{ $project->is_featured ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                            </button>
                        </form>
                        <a href="{{ route('admin.projects.edit', $project) }}" class="p-1.5 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Edit">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                        </a>
                        <form method="POST" action="{{ route('admin.projects.destroy', $project) }}" onsubmit="return confirm('Delete this project?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Delete">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="px-5 py-12 text-center text-gray-400">
                No projects yet. <a href="{{ route('admin.projects.create') }}" class="text-blue-600 hover:underline">Create your first project →</a>
            </td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
