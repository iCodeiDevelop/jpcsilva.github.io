@extends('layouts.admin')
@section('title', isset($cert->id) ? 'Edit Certification' : 'Add Certification')
@section('header-actions')
<a href="{{ route('admin.certifications.index') }}" class="px-4 py-2 border border-gray-300 text-gray-700 text-sm font-semibold rounded-xl hover:bg-gray-50">← Back</a>
@endsection
@section('content')
<form method="POST" action="{{ isset($cert->id) ? route('admin.certifications.update', $cert) : route('admin.certifications.store') }}" class="max-w-xl space-y-5">
    @csrf @if(isset($cert->id)) @method('PUT') @endif
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 space-y-5">
        <div><label class="block text-sm font-semibold text-gray-700 mb-1.5">Certification Name *</label>
            <input type="text" name="name" value="{{ old('name', $cert->name ?? '') }}" required class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="e.g. ITIL® 4 Foundation"/></div>
        <div><label class="block text-sm font-semibold text-gray-700 mb-1.5">Issuing Organisation *</label>
            <input type="text" name="issuer" value="{{ old('issuer', $cert->issuer ?? '') }}" required class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="e.g. PRC, AXELOS, TESDA"/></div>
        <div class="grid grid-cols-2 gap-4">
            <div><label class="block text-sm font-semibold text-gray-700 mb-1.5">Issue Date *</label>
                <input type="date" name="issued_at" value="{{ old('issued_at', isset($cert->issued_at) ? $cert->issued_at->format('Y-m-d') : '') }}" required class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"/></div>
            <div><label class="block text-sm font-semibold text-gray-700 mb-1.5">Expiry Date <span class="font-normal text-gray-400">(leave blank if permanent)</span></label>
                <input type="date" name="expires_at" value="{{ old('expires_at', isset($cert->expires_at) ? $cert->expires_at->format('Y-m-d') : '') }}" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"/></div>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div><label class="block text-sm font-semibold text-gray-700 mb-1.5">Credential ID</label>
                <input type="text" name="credential_id" value="{{ old('credential_id', $cert->credential_id ?? '') }}" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"/></div>
            <div><label class="block text-sm font-semibold text-gray-700 mb-1.5">Verification URL</label>
                <input type="url" name="credential_url" value="{{ old('credential_url', $cert->credential_url ?? '') }}" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="https://..."/></div>
        </div>
        <div><label class="block text-sm font-semibold text-gray-700 mb-1.5">Skills Covered <span class="font-normal text-gray-400">(comma-separated)</span></label>
            <input type="text" name="skills_covered" value="{{ old('skills_covered', isset($cert->skills_covered) ? implode(', ', $cert->skills_covered) : '') }}" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="IT Service Management, ITSM, Process Design"/></div>
        <div class="grid grid-cols-2 gap-4">
            <div><label class="block text-sm font-semibold text-gray-700 mb-1.5">Sort Order</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', $cert->sort_order ?? 0) }}" min="0" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"/></div>
        </div>
        <label class="flex items-center gap-2 cursor-pointer">
            <input type="checkbox" name="is_visible" value="1" {{ old('is_visible', $cert->is_visible ?? true) ? 'checked' : '' }} class="rounded text-blue-600 w-4 h-4"/>
            <span class="text-sm font-semibold text-gray-700">Show on portfolio</span>
        </label>
    </div>
    <div class="flex justify-end gap-3">
        <a href="{{ route('admin.certifications.index') }}" class="px-6 py-2.5 border border-gray-300 text-gray-700 font-semibold rounded-xl text-sm hover:bg-gray-50">Cancel</a>
        <button type="submit" class="px-8 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl text-sm shadow-lg shadow-blue-500/20">
            {{ isset($cert->id) ? 'Update' : 'Add Certification' }}
        </button>
    </div>
</form>
@endsection
