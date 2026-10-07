@extends('layouts.admin')
@section('title', 'Dashboard')
@section('content')

<div class="space-y-8">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
        <p class="text-gray-500 text-sm mt-1">Welcome back, {{ auth()->user()->name }}!</p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        @php $statCards = [
            ['label'=>'Published Projects','value'=>$stats['published'],'total'=>$stats['projects'],'icon'=>'folder-open','color'=>'blue'],
            ['label'=>'Blog Posts',         'value'=>$stats['blog_published'],'total'=>$stats['blogs'],'icon'=>'file-text','color'=>'purple'],
            ['label'=>'Total Views',        'value'=>number_format($stats['total_views']),'total'=>null,'icon'=>'eye','color'=>'green'],
            ['label'=>'Unread Messages',    'value'=>$stats['unread'],'total'=>$stats['messages'],'icon'=>'inbox','color'=>'orange'],
        ]; @endphp
        @foreach($statCards as $card)
        <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
            <div class="flex items-start justify-between mb-3">
                <div class="p-2.5 bg-{{ $card['color'] }}-50 rounded-xl">
                    <svg class="w-5 h-5 text-{{ $card['color'] }}-600"><use href="#{{ $card['icon'] }}"/></svg>
                </div>
            </div>
            <p class="text-3xl font-extrabold text-gray-900">{{ $card['value'] }}</p>
            <p class="text-sm text-gray-500 mt-1">
                {{ $card['label'] }}
                @if($card['total'] !== null)<span class="text-gray-400">/ {{ $card['total'] }} total</span>@endif
            </p>
        </div>
        @endforeach
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Messages -->
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                <h2 class="font-semibold text-gray-900">Recent Messages</h2>
                <a href="{{ route('admin.messages.index') }}" class="text-xs text-blue-600 hover:underline">View all</a>
            </div>
            <div class="divide-y divide-gray-50">
                @forelse($recentMessages as $msg)
                <a href="{{ route('admin.messages.show', $msg) }}" class="flex items-start gap-3 px-5 py-3.5 hover:bg-gray-50 transition-colors {{ !$msg->is_read ? 'bg-blue-50/50' : '' }}">
                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center text-xs font-bold text-blue-700 flex-shrink-0">
                        {{ strtoupper(substr($msg->name, 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-900 truncate {{ !$msg->is_read ? 'font-bold' : '' }}">{{ $msg->name }}</p>
                        <p class="text-xs text-gray-500 truncate">{{ $msg->subject }}</p>
                    </div>
                    <span class="text-xs text-gray-400 flex-shrink-0">{{ $msg->created_at->diffForHumans() }}</span>
                </a>
                @empty
                <p class="px-5 py-8 text-sm text-gray-400 text-center">No messages yet.</p>
                @endforelse
            </div>
        </div>

        <!-- Recent Projects -->
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                <h2 class="font-semibold text-gray-900">Projects</h2>
                <a href="{{ route('admin.projects.index') }}" class="text-xs text-blue-600 hover:underline">Manage</a>
            </div>
            <div class="divide-y divide-gray-50">
                @forelse($recentProjects as $project)
                <div class="flex items-center gap-3 px-5 py-3.5">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-900 truncate">{{ $project->title }}</p>
                        <p class="text-xs text-gray-400">{{ $project->category_label }} · {{ $project->views }} views</p>
                    </div>
                    <span class="px-2 py-0.5 text-xs font-semibold rounded-full {{ $project->is_published ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                        {{ $project->is_published ? 'Live' : 'Draft' }}
                    </span>
                    <a href="{{ route('admin.projects.edit', $project) }}" class="text-gray-400 hover:text-blue-600 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                    </a>
                </div>
                @empty
                <p class="px-5 py-8 text-sm text-gray-400 text-center">No projects yet. <a href="{{ route('admin.projects.create') }}" class="text-blue-600 hover:underline">Create one →</a></p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Quick Links -->
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">
        @foreach([
            ['route'=>'admin.projects.create','label'=>'+ Project','color'=>'blue'],
            ['route'=>'admin.skills.create',  'label'=>'+ Skill',  'color'=>'purple'],
            ['route'=>'admin.experience.create','label'=>'+ Experience','color'=>'green'],
            ['route'=>'admin.certifications.create','label'=>'+ Cert','color'=>'orange'],
            ['route'=>'admin.blog.create',    'label'=>'+ Blog Post','color'=>'pink'],
            ['route'=>'admin.settings.index', 'label'=>'⚙ Settings','color'=>'gray'],
        ] as $link)
        <a href="{{ route($link['route']) }}"
           class="text-center py-3 px-4 bg-white border border-gray-200 rounded-xl text-sm font-semibold text-gray-700 hover:border-blue-400 hover:text-blue-600 hover:bg-blue-50 transition-all shadow-sm">
            {{ $link['label'] }}
        </a>
        @endforeach
    </div>
</div>
@endsection
