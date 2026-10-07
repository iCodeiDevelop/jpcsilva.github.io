@extends('layouts.admin')
@section('title', 'Settings')
@section('content')
<form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-8">
    @csrf @method('PUT')

    {{-- Hero --}}
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 border-b border-gray-200"><h2 class="font-semibold text-gray-900">🦸 Hero Section</h2></div>
        <div class="p-6 space-y-4">
            <x-admin-field name="hero_greeting"     label="Greeting"       :value="$settings['hero_greeting'] ?? ''"     />
            <x-admin-field name="hero_headline"     label="Headline"       :value="$settings['hero_headline'] ?? ''"     />
            <x-admin-field name="hero_tagline"      label="Tagline"        :value="$settings['hero_tagline'] ?? ''"      />
            <div class="grid grid-cols-2 gap-4">
                <x-admin-field name="hero_cta_primary"   label="Primary CTA"   :value="$settings['hero_cta_primary'] ?? ''"   />
                <x-admin-field name="hero_cta_secondary" label="Secondary CTA" :value="$settings['hero_cta_secondary'] ?? ''" />
            </div>
        </div>
    </div>

    {{-- Profile --}}
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 border-b border-gray-200"><h2 class="font-semibold text-gray-900">👤 Profile</h2></div>
        <div class="p-6 space-y-4">
            <div class="grid grid-cols-2 gap-4">
                <x-admin-field name="display_name" label="Display Name" :value="$settings['display_name'] ?? ''" />
                <x-admin-field name="title"         label="Professional Title" :value="$settings['title'] ?? ''" />
            </div>
            <div class="grid grid-cols-2 gap-4">
                <x-admin-field name="location"     label="Location"   :value="$settings['location'] ?? ''" />
                <x-admin-field name="email"         label="Contact Email" :value="$settings['email'] ?? ''" />
            </div>
            <x-admin-field name="availability_note" label="Availability Note" :value="$settings['availability_note'] ?? ''" />
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Availability Status</label>
                <select name="availability_status" class="px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="open"   {{ ($settings['availability_status'] ?? '') === 'open'   ? 'selected' : '' }}>🟢 Open to Work</option>
                    <option value="limited"{{ ($settings['availability_status'] ?? '') === 'limited' ? 'selected' : '' }}>🟡 Limited Availability</option>
                    <option value="closed" {{ ($settings['availability_status'] ?? '') === 'closed'  ? 'selected' : '' }}>🔴 Not Available</option>
                </select>
            </div>
            <x-admin-field name="resume_url" label="Resume PDF URL" :value="$settings['resume_url'] ?? ''" placeholder="https://..." />
        </div>
    </div>

    {{-- About --}}
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 border-b border-gray-200"><h2 class="font-semibold text-gray-900">📖 About</h2></div>
        <div class="p-6 space-y-4">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Bio (supports paragraph breaks)</label>
                <textarea name="about_bio" rows="8" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">{{ $settings['about_bio'] ?? '' }}</textarea>
            </div>
            <x-admin-field name="about_tagline" label="Credentials Tagline" :value="$settings['about_tagline'] ?? ''" />
        </div>
    </div>

    {{-- Social --}}
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 border-b border-gray-200"><h2 class="font-semibold text-gray-900">🔗 Social Links</h2></div>
        <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
            <x-admin-field name="github_url"   label="GitHub URL"   :value="$settings['github_url'] ?? ''"   placeholder="https://github.com/..." />
            <x-admin-field name="linkedin_url" label="LinkedIn URL" :value="$settings['linkedin_url'] ?? ''" placeholder="https://linkedin.com/in/..." />
            <x-admin-field name="twitter_url"  label="Twitter URL"  :value="$settings['twitter_url'] ?? ''"  placeholder="https://twitter.com/..." />
            <x-admin-field name="upwork_url"   label="Upwork URL"   :value="$settings['upwork_url'] ?? ''"   placeholder="https://upwork.com/freelancers/..." />
        </div>
    </div>

    {{-- SEO --}}
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 border-b border-gray-200"><h2 class="font-semibold text-gray-900">🔍 SEO</h2></div>
        <div class="p-6 space-y-4">
            <x-admin-field name="meta_title"       label="Meta Title (max 70 chars)"       :value="$settings['meta_title'] ?? ''" />
            <x-admin-field name="meta_description" label="Meta Description (max 160 chars)" :value="$settings['meta_description'] ?? ''" />
            <x-admin-field name="meta_keywords"    label="Keywords (comma-separated)"       :value="$settings['meta_keywords'] ?? ''" />
        </div>
    </div>

    <div class="flex justify-end">
        <button type="submit" class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl transition-all shadow-lg shadow-blue-500/20">
            Save All Settings
        </button>
    </div>
</form>
@endsection
