@extends('layouts.admin')
@section('title', 'Messages')
@section('content')
<div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
    <div class="divide-y divide-gray-100">
        @forelse($messages as $msg)
        <div class="flex items-start gap-4 px-5 py-4 {{ !$msg->is_read ? 'bg-blue-50/50' : '' }} hover:bg-gray-50 transition-colors">
            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center text-sm font-bold text-blue-700 flex-shrink-0">
                {{ strtoupper(substr($msg->name, 0, 1)) }}
            </div>
            <div class="flex-1 min-w-0">
                <div class="flex items-center gap-2 mb-1">
                    <p class="font-semibold text-gray-900 text-sm {{ !$msg->is_read ? 'font-bold' : '' }}">{{ $msg->name }}</p>
                    @if(!$msg->is_read)<span class="w-2 h-2 rounded-full bg-blue-500"></span>@endif
                    @if($msg->project_type)<span class="px-2 py-0.5 text-xs bg-gray-100 text-gray-600 rounded-full">{{ $msg->project_type }}</span>@endif
                    @if($msg->budget_range)<span class="px-2 py-0.5 text-xs bg-green-100 text-green-700 rounded-full">{{ $msg->budget_range }}</span>@endif
                </div>
                <p class="text-sm font-medium text-gray-700">{{ $msg->subject }}</p>
                <p class="text-xs text-gray-500 mt-0.5 truncate">{{ Str::limit($msg->message, 100) }}</p>
                <p class="text-xs text-gray-400 mt-1">{{ $msg->email }} · {{ $msg->created_at->format('M d, Y H:i') }}</p>
            </div>
            <div class="flex items-center gap-2 flex-shrink-0">
                <a href="{{ route('admin.messages.show', $msg) }}" class="px-3 py-1.5 text-xs font-semibold text-blue-600 border border-blue-200 rounded-lg hover:bg-blue-50 transition-colors">Read</a>
                <form method="POST" action="{{ route('admin.messages.destroy', $msg) }}" onsubmit="return confirm('Delete this message?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="px-3 py-1.5 text-xs font-semibold text-red-600 border border-red-200 rounded-lg hover:bg-red-50 transition-colors">Delete</button>
                </form>
            </div>
        </div>
        @empty
        <div class="py-16 text-center text-gray-400">
            <svg class="w-12 h-12 mx-auto mb-3 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
            No messages yet. Your inbox will fill up soon!
        </div>
        @endforelse
    </div>
    <div class="px-5 py-3 border-t border-gray-100">{{ $messages->links() }}</div>
</div>
@endsection
