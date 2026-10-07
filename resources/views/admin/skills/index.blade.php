@extends('layouts.admin')
@section('title', 'Skills')
@section('header-actions')
<a href="{{ route('admin.skills.create') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl">+ Add Skill</a>
@endsection
@section('content')
<div class="space-y-6">
    @foreach($skills as $category => $group)
    @php $labels = ['backend'=>'⚙️ Backend','frontend'=>'🎨 Frontend','database'=>'🗄️ Database','devops'=>'🐳 DevOps','tools'=>'🔧 Tools','design'=>'✏️ Design','soft'=>'🤝 Soft Skills']; @endphp
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
        <div class="px-5 py-3 bg-gray-50 border-b border-gray-200">
            <h3 class="font-bold text-gray-900">{{ $labels[$category] ?? ucfirst($category) }}</h3>
        </div>
        <table class="w-full">
            <tbody class="divide-y divide-gray-100">
                @foreach($group as $skill)
                <tr class="hover:bg-gray-50">
                    <td class="px-5 py-3">
                        <div class="flex items-center gap-3">
                            <div class="w-3 h-3 rounded-full flex-shrink-0" style="background:{{ $skill->hex_color }}"></div>
                            <span class="font-semibold text-sm text-gray-900">{{ $skill->name }}</span>
                        </div>
                    </td>
                    <td class="px-5 py-3">
                        <div class="flex items-center gap-2">
                            <div class="w-24 h-1.5 bg-gray-200 rounded-full overflow-hidden">
                                <div class="h-full rounded-full" style="width:{{ $skill->proficiency }}%;background:{{ $skill->hex_color }}"></div>
                            </div>
                            <span class="text-xs font-bold text-gray-600">{{ $skill->proficiency }}%</span>
                        </div>
                    </td>
                    <td class="px-5 py-3 text-xs text-gray-400">{{ $skill->years_experience }}y exp</td>
                    <td class="px-5 py-3">
                        @if($skill->is_featured)<span class="px-2 py-0.5 bg-amber-100 text-amber-700 text-xs rounded-full">Featured</span>@endif
                        @if(!$skill->is_visible)<span class="px-2 py-0.5 bg-gray-100 text-gray-500 text-xs rounded-full">Hidden</span>@endif
                    </td>
                    <td class="px-5 py-3 text-right">
                        <a href="{{ route('admin.skills.edit', $skill) }}" class="p-1.5 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg inline-flex transition-colors mr-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                        </a>
                        <form method="POST" action="{{ route('admin.skills.destroy', $skill) }}" class="inline" onsubmit="return confirm('Delete {{ $skill->name }}?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endforeach
    @if($skills->isEmpty())
    <div class="bg-white border border-gray-200 rounded-xl p-12 text-center text-gray-400">
        No skills yet. <a href="{{ route('admin.skills.create') }}" class="text-blue-600 hover:underline">Add your first skill →</a>
    </div>
    @endif
</div>
@endsection
