@extends('layouts.admin')
@section('title', isset($project->id) ? 'Edit Project' : 'New Project')
@section('header-actions')
<a href="{{ route('admin.projects.index') }}" class="px-4 py-2 border border-gray-300 text-gray-700 text-sm font-semibold rounded-xl hover:bg-gray-50 transition-colors">← Back</a>
@endsection
@section('content')
<form method="POST"
      action="{{ isset($project->id) ? route('admin.projects.update', $project) : route('admin.projects.store') }}"
      enctype="multipart/form-data"
      class="max-w-4xl space-y-6">
    @csrf
    @if(isset($project->id)) @method('PUT') @endif

    @if($errors->any())
    <div class="p-4 bg-red-50 border border-red-200 rounded-xl text-sm text-red-700">
        <p class="font-bold mb-1">Please fix these errors:</p>
        <ul class="list-disc list-inside space-y-1">
            @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
        </ul>
    </div>
    @endif

    {{-- Basic Info --}}
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 border-b border-gray-200"><h2 class="font-semibold text-gray-900">Basic Information</h2></div>
        <div class="p-6 space-y-5">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Project Title <span class="text-red-400">*</span></label>
                <input type="text" name="title" value="{{ old('title', $project->title ?? '') }}" required
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                       placeholder="e.g. WiFi Captive Portal Management System"/>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Slug (auto-generated if empty)</label>
                <input type="text" name="slug" value="{{ old('slug', $project->slug ?? '') }}"
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 font-mono"
                       placeholder="wifi-captive-portal-system"/>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Short Description <span class="text-red-400">*</span> <span class="font-normal text-gray-400">(max 500 chars — shown on cards)</span></label>
                <textarea name="short_description" rows="2" required maxlength="500"
                          class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('short_description', $project->short_description ?? '') }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Full Description <span class="text-red-400">*</span> <span class="font-normal text-gray-400">(Markdown supported)</span></label>
                <textarea name="description" rows="12" required
                          class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm font-mono focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description', $project->description ?? '') }}</textarea>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Category</label>
                    <select name="category" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @foreach(['web'=>'Web Application','systems'=>'Systems Development','mobile'=>'Mobile App','data'=>'Data & Analytics','devops'=>'DevOps / Infrastructure'] as $val => $label)
                        <option value="{{ $val }}" {{ old('category', $project->category ?? 'web') === $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Client / Organisation</label>
                    <input type="text" name="client" value="{{ old('client', $project->client ?? '') }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="e.g. San Pedro College, Personal Project"/>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Completed Date</label>
                    <input type="date" name="completed_at" value="{{ old('completed_at', isset($project->completed_at) ? $project->completed_at->format('Y-m-d') : '') }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"/>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Sort Order</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', $project->sort_order ?? 0) }}" min="0"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"/>
                </div>
            </div>
        </div>
    </div>

    {{-- Tech Stack & Links --}}
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 border-b border-gray-200"><h2 class="font-semibold text-gray-900">Tech Stack & Links</h2></div>
        <div class="p-6 space-y-5">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Tech Stack <span class="text-red-400">*</span> <span class="font-normal text-gray-400">(comma-separated)</span></label>
                <input type="text" name="tech_stack" required
                       value="{{ old('tech_stack', isset($project->tech_stack) ? implode(', ', $project->tech_stack) : '') }}"
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                       placeholder="Laravel, MySQL, PHP, Bootstrap, JavaScript"/>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Live URL</label>
                    <input type="url" name="link_live" value="{{ old('link_live', $project->links['live'] ?? '') }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="https://..."/>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">GitHub URL</label>
                    <input type="url" name="link_github" value="{{ old('link_github', $project->links['github'] ?? '') }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="https://github.com/..."/>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Case Study URL</label>
                    <input type="url" name="link_case_study" value="{{ old('link_case_study', $project->links['case_study'] ?? '') }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="https://..."/>
                </div>
            </div>
        </div>
    </div>

    {{-- Thumbnail & Visibility --}}
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 border-b border-gray-200"><h2 class="font-semibold text-gray-900">Thumbnail & Visibility</h2></div>
        <div class="p-6 space-y-5">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Thumbnail Image <span class="font-normal text-gray-400">(recommended: 800×500px, JPG/PNG)</span></label>
                @if(isset($project->thumbnail) && $project->thumbnail)
                <div class="mb-3"><img src="{{ $project->thumbnail_url }}" alt="Current thumbnail" class="h-24 w-auto rounded-lg border border-gray-200"/></div>
                @endif
                <input type="file" name="thumbnail" accept="image/*"
                       class="w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-600 hover:file:bg-blue-100"/>
            </div>
            <div class="flex flex-wrap gap-6">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_published" value="1" {{ old('is_published', $project->is_published ?? true) ? 'checked' : '' }} class="rounded text-blue-600 w-4 h-4"/>
                    <span class="text-sm font-semibold text-gray-700">Published (visible on portfolio)</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $project->is_featured ?? false) ? 'checked' : '' }} class="rounded text-amber-500 w-4 h-4"/>
                    <span class="text-sm font-semibold text-gray-700">⭐ Featured project</span>
                </label>
            </div>
        </div>
    </div>

    {{-- SEO --}}
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 border-b border-gray-200"><h2 class="font-semibold text-gray-900">SEO (optional)</h2></div>
        <div class="p-6 grid grid-cols-1 gap-4">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Meta Title <span class="font-normal text-gray-400">(max 70 chars)</span></label>
                <input type="text" name="meta_title" maxlength="70" value="{{ old('meta_title', $project->meta_title ?? '') }}"
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"/>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Meta Description <span class="font-normal text-gray-400">(max 160 chars)</span></label>
                <textarea name="meta_description" rows="2" maxlength="160"
                          class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('meta_description', $project->meta_description ?? '') }}</textarea>
            </div>
        </div>
    </div>

    <div class="flex items-center justify-end gap-3">
        <a href="{{ route('admin.projects.index') }}" class="px-6 py-2.5 border border-gray-300 text-gray-700 font-semibold rounded-xl text-sm hover:bg-gray-50 transition-colors">Cancel</a>
        <button type="submit" class="px-8 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl text-sm transition-all shadow-lg shadow-blue-500/20">
            {{ isset($project->id) ? 'Update Project' : 'Create Project' }}
        </button>
    </div>
</form>
@endsection
