@extends('layouts.app')
@section('title', 'Blog | John Paul Silva — IT Consultant')
@section('description', 'Articles on IT consulting, systems analysis, technical writing, and professional development by John Paul Silva.')

@section('content')
<div class="pt-28 pb-20 bg-white dark:bg-gray-950 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14">
            <p class="text-brand-600 dark:text-brand-400 font-semibold text-sm tracking-widest uppercase mb-3">Writing</p>
            <h1 class="text-4xl font-extrabold text-gray-900 dark:text-white mb-4">Articles & <span class="gradient-text">Insights</span></h1>
            <p class="text-gray-500 dark:text-gray-400 max-w-xl mx-auto">
                Thoughts on IT consulting, systems analysis, professional development, and technology in the Philippines.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($blogs as $post)
            <article class="group bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-2xl overflow-hidden card-hover shadow-sm">
                <div class="h-44 bg-gradient-to-br from-brand-100 to-violet-100 dark:from-brand-900/30 dark:to-violet-900/30 flex items-center justify-center">
                    <span class="text-6xl font-black text-brand-200 dark:text-brand-800 select-none">{{ substr($post->title, 0, 1) }}</span>
                </div>
                <div class="p-6">
                    <div class="flex flex-wrap gap-1.5 mb-3">
                        @foreach(array_slice($post->tags ?? [], 0, 2) as $tag)
                        <span class="px-2.5 py-0.5 bg-brand-50 dark:bg-brand-900/20 text-brand-700 dark:text-brand-400 text-xs rounded-full font-medium">{{ $tag }}</span>
                        @endforeach
                    </div>
                    <h2 class="font-bold text-gray-900 dark:text-white mb-2 line-clamp-2 group-hover:text-brand-600 transition-colors">
                        <a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a>
                    </h2>
                    @if($post->excerpt)
                    <p class="text-sm text-gray-500 dark:text-gray-400 line-clamp-3 mb-4">{{ $post->excerpt }}</p>
                    @endif
                    <div class="flex items-center justify-between text-xs text-gray-400">
                        <span class="flex items-center gap-1"><i data-lucide="clock" class="w-3.5 h-3.5"></i> {{ $post->reading_time }} min read</span>
                        @if($post->published_at)<span>{{ $post->published_at->format('M d, Y') }}</span>@endif
                    </div>
                </div>
            </article>
            @empty
            <div class="col-span-3 text-center py-20 text-gray-400">
                <i data-lucide="pencil-line" class="w-12 h-12 mx-auto mb-4 opacity-30"></i>
                <p>No articles published yet. Check back soon.</p>
            </div>
            @endforelse
        </div>

        @if($blogs->hasPages())
        <div class="mt-12 flex justify-center">{{ $blogs->links() }}</div>
        @endif
    </div>
</div>
@endsection
