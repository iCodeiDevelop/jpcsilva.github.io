@extends('layouts.admin')
@section('title', isset($experience->id) ? 'Edit Experience' : 'Add Experience')
@section('header-actions')
<a href="{{ route('admin.experience.index') }}" class="px-4 py-2 border border-gray-300 text-gray-700 text-sm font-semibold rounded-xl hover:bg-gray-50">← Back</a>
@endsection
@section('content')
<form method="POST" action="{{ isset($experience->id) ? route('admin.experience.update', $experience) : route('admin.experience.store') }}" class="max-w-2xl space-y-6">
    @csrf @if(isset($experience->id)) @method('PUT') @endif
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 space-y-5">
        <div class="grid grid-cols-2 gap-4">
            <div><label class="block text-sm font-semibold text-gray-700 mb-1.5">Position *</label>
                <input type="text" name="position" value="{{ old('position', $experience->position ?? '') }}" required class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"/></div>
            <div><label class="block text-sm font-semibold text-gray-700 mb-1.5">Company *</label>
                <input type="text" name="company" value="{{ old('company', $experience->company ?? '') }}" required class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"/></div>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div><label class="block text-sm font-semibold text-gray-700 mb-1.5">Company URL</label>
                <input type="url" name="company_url" value="{{ old('company_url', $experience->company_url ?? '') }}" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="https://..."/></div>
            <div><label class="block text-sm font-semibold text-gray-700 mb-1.5">Location</label>
                <input type="text" name="location" value="{{ old('location', $experience->location ?? '') }}" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"/></div>
        </div>
        <div class="grid grid-cols-3 gap-4">
            <div><label class="block text-sm font-semibold text-gray-700 mb-1.5">Type</label>
                <select name="employment_type" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @foreach(['full-time','part-time','contract','freelance','internship'] as $t)
                    <option value="{{ $t }}" {{ old('employment_type', $experience->employment_type ?? 'full-time') === $t ? 'selected' : '' }}>{{ ucfirst(str_replace('-',' ',$t)) }}</option>
                    @endforeach
                </select></div>
            <div><label class="block text-sm font-semibold text-gray-700 mb-1.5">Start Date *</label>
                <input type="date" name="start_date" value="{{ old('start_date', isset($experience->start_date) ? $experience->start_date->format('Y-m-d') : '') }}" required class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"/></div>
            <div><label class="block text-sm font-semibold text-gray-700 mb-1.5">End Date</label>
                <input type="date" name="end_date" value="{{ old('end_date', isset($experience->end_date) ? $experience->end_date->format('Y-m-d') : '') }}" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"/></div>
        </div>
        <div class="flex gap-6">
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="is_current" value="1" {{ old('is_current', $experience->is_current ?? false) ? 'checked' : '' }} class="rounded text-blue-600 w-4 h-4"/>
                <span class="text-sm font-semibold text-gray-700">Current role (no end date)</span>
            </label>
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="is_remote" value="1" {{ old('is_remote', $experience->is_remote ?? false) ? 'checked' : '' }} class="rounded text-blue-600 w-4 h-4"/>
                <span class="text-sm font-semibold text-gray-700">Remote</span>
            </label>
        </div>
        <div><label class="block text-sm font-semibold text-gray-700 mb-1.5">Description</label>
            <textarea name="description" rows="3" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description', $experience->description ?? '') }}</textarea></div>
        <div><label class="block text-sm font-semibold text-gray-700 mb-1.5">Key Highlights <span class="font-normal text-gray-400">(one per line)</span></label>
            <textarea name="highlights" rows="4" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm font-mono focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Managed IT infrastructure for 3,000+ users&#10;Led Digital Literacy programs">{{ old('highlights', isset($experience->highlights) ? implode("\n", $experience->highlights) : '') }}</textarea></div>
        <div><label class="block text-sm font-semibold text-gray-700 mb-1.5">Technologies Used <span class="font-normal text-gray-400">(comma-separated)</span></label>
            <input type="text" name="tech_used" value="{{ old('tech_used', isset($experience->tech_used) ? implode(', ', $experience->tech_used) : '') }}" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="PHP, MySQL, Laravel, MS Office"/></div>
    </div>
    <div class="flex justify-end gap-3">
        <a href="{{ route('admin.experience.index') }}" class="px-6 py-2.5 border border-gray-300 text-gray-700 font-semibold rounded-xl text-sm hover:bg-gray-50">Cancel</a>
        <button type="submit" class="px-8 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl text-sm shadow-lg shadow-blue-500/20">
            {{ isset($experience->id) ? 'Update' : 'Add Experience' }}
        </button>
    </div>
</form>
@endsection
