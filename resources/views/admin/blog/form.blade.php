@extends('layouts.admin')
@section('title', isset($post->id) ? 'Edit Post' : 'New Post')
@section('header-actions')
<a href="{{ route('admin.blog.index') }}" class="px-4 py-2 border border-gray-300 text-gray-700 text-sm font-semibold rounded-xl hover:bg-gray-50">← Back</a>
@endsection
@section('content')
<form method="POST" action="{{ isset($post->id) ? route('admin.blog.update', $post) : route('admin.blog.store') }}" class="max-w-4xl space-y-6">
    @csrf @if(isset($post->id)) @method('PUT') @endif
    @if($errors->any())
    <div class="p-4 bg-red-50 border border-red-200 rounded-xl text-sm text-red-700">{{ $errors->first() }}</div>
    @endif
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 space-y-5">
        <div><label class="block text-sm font-semibold text-gray-700 mb-1.5">Post Title *</label>
            <input type="text" name="title" value="{{ old('title', $post->title ?? '') }}" required class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="e.g. Getting Started with ITIL 4"/></div>
        <div><label class="block text-sm font-semibold text-gray-700 mb-1.5">Excerpt <span class="font-normal text-gray-400">(max 400 chars — shown on blog listing)</span></label>
            <textarea name="excerpt" rows="2" maxlength="400" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('excerpt', $post->excerpt ?? '') }}</textarea></div>
        <div><label class="block text-sm font-semibold text-gray-700 mb-1.5">Content * <span class="font-normal text-gray-400">(Markdown supported)</span></label>
            <textarea name="content" rows="20" required class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm font-mono focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('content', $post->content ?? '') }}</textarea></div>
        <div class="grid grid-cols-2 gap-4">
            <div><label class="block text-sm font-semibold text-gray-700 mb-1.5">Tags <span class="font-normal text-gray-400">(comma-separated)</span></label>
                <input type="text" name="tags" value="{{ old('tags', isset($post->tags) ? implode(', ', $post->tags) : '') }}" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="ITIL, IT Management, Philippines"/></div>
            <div><label class="block text-sm font-semibold text-gray-700 mb-1.5">Status</label>
                <select name="status" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="draft" {{ old('status', $post->status ?? 'draft') === 'draft' ? 'selected' : '' }}>Draft (not public)</option>
                    <option value="published" {{ old('status', $post->status ?? 'draft') === 'published' ? 'selected' : '' }}>Published (live)</option>
                </select></div>
        </div>
        <label class="flex items-center gap-2 cursor-pointer">
            <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $post->is_featured ?? false) ? 'checked' : '' }} class="rounded text-blue-600 w-4 h-4"/>
            <span class="text-sm font-semibold text-gray-700">Show in Featured section on homepage</span>
        </label>
        <div class="grid grid-cols-2 gap-4">
            <div><label class="block text-sm font-semibold text-gray-700 mb-1.5">Meta Title</label>
                <input type="text" name="meta_title" value="{{ old('meta_title', $post->meta_title ?? '') }}" maxlength="70" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"/></div>
            <div><label class="block text-sm font-semibold text-gray-700 mb-1.5">Meta Description</label>
                <input type="text" name="meta_description" value="{{ old('meta_description', $post->meta_description ?? '') }}" maxlength="160" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"/></div>
        </div>
    </div>
    <div class="flex justify-end gap-3">
        <a href="{{ route('admin.blog.index') }}" class="px-6 py-2.5 border border-gray-300 text-gray-700 font-semibold rounded-xl text-sm hover:bg-gray-50">Cancel</a>
        <button type="submit" class="px-8 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl text-sm shadow-lg shadow-blue-500/20">
            {{ isset($post->id) ? 'Update Post' : 'Save Post' }}
        </button>
    </div>
</form>
@endsection
