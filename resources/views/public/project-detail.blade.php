@extends('layouts.app')
@section('title', $project->meta_title ?: $project->title . ' | John Paul Silva')
@section('description', $project->meta_description ?: $project->short_description)

@section('content')
<div class="pt-20 bg-gray-50 dark:bg-gray-950 min-h-screen">
    <!-- Back link -->
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 pt-8">
        <a href="{{ route('home') }}#projects"
           class="inline-flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 hover:text-brand-600 dark:hover:text-brand-400 transition-colors mb-8">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Back to Portfolio
        </a>
    </div>

    <article class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 pb-20">
        <!-- Header -->
        <div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-2xl p-8 shadow-sm mb-8">
            <div class="flex items-start justify-between gap-4 mb-4">
                <div>
                    <div class="flex items-center gap-2 mb-3">
                        <span class="px-3 py-1 bg-brand-100 dark:bg-brand-900/30 text-brand-700 dark:text-brand-400 text-xs font-bold rounded-full">
                            {{ $project->category_label }}
                        </span>
                        @if($project->is_featured)
                        <span class="px-3 py-1 bg-amber-100 text-amber-700 text-xs font-bold rounded-full">⭐ Featured</span>
                        @endif
                    </div>
                    <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900 dark:text-white mb-3">{{ $project->title }}</h1>
                    <p class="text-lg text-gray-500 dark:text-gray-400">{{ $project->short_description }}</p>
                </div>
            </div>

            <!-- Meta row -->
            <div class="flex flex-wrap gap-4 text-sm text-gray-500 dark:text-gray-400 pt-4 border-t border-gray-100 dark:border-gray-800 mt-4">
                @if($project->client)
                <span class="flex items-center gap-1.5"><i data-lucide="building-2" class="w-4 h-4"></i> {{ $project->client }}</span>
                @endif
                @if($project->completed_at)
                <span class="flex items-center gap-1.5"><i data-lucide="calendar-check" class="w-4 h-4"></i> {{ $project->completed_at->format('M Y') }}</span>
                @endif
                <span class="flex items-center gap-1.5"><i data-lucide="eye" class="w-4 h-4"></i> {{ $project->views }} views</span>
            </div>

            <!-- Links -->
            <div class="flex flex-wrap gap-3 mt-5">
                @if(!empty($project->links['live']))
                <a href="{{ $project->links['live'] }}" target="_blank"
                   class="flex items-center gap-2 px-4 py-2 bg-brand-600 hover:bg-brand-700 text-white text-sm font-semibold rounded-xl transition-colors shadow-md shadow-brand-500/20">
                    <i data-lucide="external-link" class="w-4 h-4"></i> Live Site
                </a>
                @endif
                @if(!empty($project->links['github']))
                <a href="{{ $project->links['github'] }}" target="_blank"
                   class="flex items-center gap-2 px-4 py-2 bg-gray-900 hover:bg-gray-800 text-white text-sm font-semibold rounded-xl transition-colors">
                    <i data-lucide="github" class="w-4 h-4"></i> Source Code
                </a>
                @endif
                @if(!empty($project->links['case_study']))
                <a href="{{ $project->links['case_study'] }}" target="_blank"
                   class="flex items-center gap-2 px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 text-sm font-semibold rounded-xl hover:border-brand-400 transition-colors">
                    <i data-lucide="book-open" class="w-4 h-4"></i> Case Study
                </a>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main content -->
            <div class="lg:col-span-2">
                <div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-2xl p-8 shadow-sm">
                    <div class="prose prose-gray dark:prose-invert max-w-none prose-headings:font-bold prose-h2:text-xl prose-a:text-brand-600">
                        @php
                            $html = \League\CommonMark\CommonMarkConverter::class === class_exists(\League\CommonMark\CommonMarkConverter::class)
                                ? (new \League\CommonMark\CommonMarkConverter())->convert($project->description)
                                : nl2br(e($project->description));
                        @endphp
                        {!! $html !!}
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Tech stack -->
                <div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-2xl p-6 shadow-sm">
                    <h3 class="font-bold text-gray-900 dark:text-white mb-4 text-sm uppercase tracking-wide">Tech Stack</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($project->tech_stack ?? [] as $tech)
                        <span class="px-3 py-1.5 bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-lg">
                            {{ $tech }}
                        </span>
                        @endforeach
                    </div>
                </div>

                <!-- Share / back -->
                <div class="bg-brand-50 dark:bg-brand-950 border border-brand-100 dark:border-brand-900 rounded-2xl p-6">
                    <h3 class="font-bold text-brand-900 dark:text-brand-300 mb-3 text-sm">Interested in similar work?</h3>
                    <p class="text-sm text-brand-700 dark:text-brand-400 mb-4">Let's discuss your project and how I can help.</p>
                    <a href="{{ route('home') }}#contact"
                       class="block text-center py-2.5 bg-brand-600 hover:bg-brand-700 text-white text-sm font-bold rounded-xl transition-colors">
                        Get In Touch →
                    </a>
                </div>
            </div>
        </div>

        <!-- Related -->
        @if($related->isNotEmpty())
        <div class="mt-12">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Other Projects</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($related as $rel)
                <a href="{{ route('projects.show', $rel->slug) }}"
                   class="group bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-xl p-5 hover:border-brand-300 hover:shadow-md transition-all">
                    <p class="font-bold text-gray-900 dark:text-white text-sm group-hover:text-brand-600 transition-colors mb-1">{{ $rel->title }}</p>
                    <p class="text-xs text-gray-500 line-clamp-2">{{ $rel->short_description }}</p>
                </a>
                @endforeach
            </div>
        </div>
        @endif
    </article>
</div>
@endsection
