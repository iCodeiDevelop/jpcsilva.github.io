@extends('layouts.admin')
@section('title', isset($skill->id) ? 'Edit Skill' : 'Add Skill')
@section('header-actions')
<a href="{{ route('admin.skills.index') }}" class="px-4 py-2 border border-gray-300 text-gray-700 text-sm font-semibold rounded-xl hover:bg-gray-50">← Back</a>
@endsection
@section('content')
<form method="POST" action="{{ isset($skill->id) ? route('admin.skills.update', $skill) : route('admin.skills.store') }}" class="max-w-xl space-y-5">
    @csrf @if(isset($skill->id)) @method('PUT') @endif
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 space-y-5">
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Skill Name *</label>
                <input type="text" name="name" value="{{ old('name', $skill->name ?? '') }}" required class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="e.g. MySQL"/>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Category *</label>
                <select name="category" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @foreach(['backend','frontend','database','devops','tools','design','soft'] as $cat)
                    <option value="{{ $cat }}" {{ old('category', $skill->category ?? '') === $cat ? 'selected' : '' }}>{{ ucfirst($cat) }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Proficiency: <span id="pct">{{ old('proficiency', $skill->proficiency ?? 80) }}%</span></label>
            <input type="range" name="proficiency" min="0" max="100" value="{{ old('proficiency', $skill->proficiency ?? 80) }}"
                   oninput="document.getElementById('pct').textContent = this.value + '%'"
                   class="w-full"/>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Hex Color</label>
                <div class="flex items-center gap-2">
                    <input type="color" name="hex_color" value="{{ old('hex_color', $skill->hex_color ?? '#2563eb') }}" class="h-10 w-10 rounded cursor-pointer border border-gray-300"/>
                    <input type="text" id="hex_text" value="{{ old('hex_color', $skill->hex_color ?? '#2563eb') }}" class="flex-1 px-3 py-2.5 border border-gray-300 rounded-xl text-sm font-mono focus:outline-none focus:ring-2 focus:ring-blue-500" readonly/>
                </div>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Years of Experience</label>
                <input type="number" name="years_experience" value="{{ old('years_experience', $skill->years_experience ?? 1) }}" min="0" max="50" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"/>
            </div>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Sort Order</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', $skill->sort_order ?? 0) }}" min="0" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"/>
            </div>
        </div>
        <div class="flex gap-6">
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="is_visible" value="1" {{ old('is_visible', $skill->is_visible ?? true) ? 'checked' : '' }} class="rounded text-blue-600 w-4 h-4"/>
                <span class="text-sm font-semibold text-gray-700">Visible on portfolio</span>
            </label>
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $skill->is_featured ?? false) ? 'checked' : '' }} class="rounded text-amber-500 w-4 h-4"/>
                <span class="text-sm font-semibold text-gray-700">Featured</span>
            </label>
        </div>
    </div>
    <div class="flex justify-end gap-3">
        <a href="{{ route('admin.skills.index') }}" class="px-6 py-2.5 border border-gray-300 text-gray-700 font-semibold rounded-xl text-sm hover:bg-gray-50">Cancel</a>
        <button type="submit" class="px-8 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl text-sm shadow-lg shadow-blue-500/20">
            {{ isset($skill->id) ? 'Update Skill' : 'Add Skill' }}
        </button>
    </div>
</form>
<script>
    document.querySelector('input[type=color]').addEventListener('input', function() {
        document.getElementById('hex_text').value = this.value;
        document.querySelector('input[name=hex_color]').value = this.value;
    });
</script>
@endsection
