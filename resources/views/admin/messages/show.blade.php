@extends('layouts.admin')
@section('title', 'Message from ' . $message->name)
@section('content')
<div class="max-w-2xl">
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 space-y-4">
        <div class="flex items-start justify-between">
            <div>
                <h2 class="text-xl font-bold text-gray-900">{{ $message->subject }}</h2>
                <p class="text-sm text-gray-500 mt-1">From <span class="font-semibold text-gray-700">{{ $message->name }}</span> &lt;{{ $message->email }}&gt;</p>
            </div>
            <span class="text-xs text-gray-400">{{ $message->created_at->format('M d, Y H:i A') }}</span>
        </div>
        @if($message->project_type || $message->budget_range)
        <div class="flex gap-2">
            @if($message->project_type)<span class="px-3 py-1 bg-blue-100 text-blue-700 text-sm rounded-full font-medium">{{ $message->project_type }}</span>@endif
            @if($message->budget_range)<span class="px-3 py-1 bg-green-100 text-green-700 text-sm rounded-full font-medium">{{ $message->budget_range }}</span>@endif
        </div>
        @endif
        <div class="bg-gray-50 rounded-xl p-5">
            <p class="text-gray-700 whitespace-pre-wrap leading-relaxed">{{ $message->message }}</p>
        </div>
        <div class="flex gap-3 pt-2">
            <a href="mailto:{{ $message->email }}?subject=Re: {{ $message->subject }}"
               class="flex items-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl text-sm transition-all">
                ✉️ Reply via Email
            </a>
            <a href="{{ route('admin.messages.index') }}" class="px-5 py-2.5 border border-gray-300 text-gray-700 font-semibold rounded-xl text-sm hover:bg-gray-50 transition-colors">
                ← Back
            </a>
            <form method="POST" action="{{ route('admin.messages.destroy', $message) }}" class="ml-auto" onsubmit="return confirm('Delete?')">
                @csrf @method('DELETE')
                <button type="submit" class="px-5 py-2.5 border border-red-300 text-red-600 font-semibold rounded-xl text-sm hover:bg-red-50 transition-colors">🗑 Delete</button>
            </form>
        </div>
    </div>
</div>
@endsection
