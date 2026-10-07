@extends('layouts.admin')
@section('title', 'Experience')
@section('header-actions')
<a href="{{ route('admin.experience.create') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl">+ Add Experience</a>
@endsection
@section('content')
<div class="space-y-4">
    @forelse($experiences as $exp)
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-5 flex items-start gap-4">
        <div class="w-3 h-3 rounded-full mt-1.5 flex-shrink-0 {{ $exp->is_current ? 'bg-green-500' : 'bg-blue-400' }}"></div>
        <div class="flex-1">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <h3 class="font-bold text-gray-900">{{ $exp->position }}</h3>
                    <p class="text-blue-600 text-sm font-semibold">{{ $exp->company }}</p>
                    <p class="text-xs text-gray-400 mt-1">
                        {{ $exp->start_date->format('M Y') }} – {{ $exp->end_label }}
                        · {{ $exp->duration }}
                        @if($exp->location) · {{ $exp->location }} @endif
                        @if($exp->is_current) <span class="ml-1 px-2 py-0.5 bg-green-100 text-green-700 rounded-full font-bold">Current</span> @endif
                    </p>
                </div>
                <div class="flex items-center gap-2 flex-shrink-0">
                    <a href="{{ route('admin.experience.edit', $exp) }}" class="p-1.5 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                    </a>
                    <form method="POST" action="{{ route('admin.experience.destroy', $exp) }}" onsubmit="return confirm('Delete?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="bg-white border border-gray-200 rounded-xl p-12 text-center text-gray-400">
        No experience entries. <a href="{{ route('admin.experience.create') }}" class="text-blue-600 hover:underline">Add your first →</a>
    </div>
    @endforelse
</div>
@endsection
