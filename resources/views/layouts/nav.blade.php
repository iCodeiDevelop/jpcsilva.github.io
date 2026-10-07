<nav x-data="{ open: false, scrolled: false }"
     x-init="window.addEventListener('scroll', () => { scrolled = window.scrollY > 30 })"
     :class="scrolled ? 'bg-white/90 dark:bg-gray-950/90 backdrop-blur-md shadow-sm border-b border-gray-200/50 dark:border-gray-800/50' : 'bg-transparent'"
     class="fixed top-0 left-0 right-0 z-50 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">

            <!-- Logo -->
            <a href="{{ route('home') }}"
               class="font-mono font-bold text-xl text-brand-600 dark:text-brand-400 tracking-tight hover:text-brand-700 transition-colors">
                &lt;JP /&gt;
            </a>

            <!-- Desktop Nav -->
            <div class="hidden md:flex items-center gap-1">
                @foreach([
                    ['#about',    'About'],
                    ['#projects', 'Projects'],
                    ['#skills',   'Skills'],
                    ['#experience','Experience'],
                    ['#certs',    'Certifications'],
                    [route('blog.index'), 'Blog'],
                    ['#contact',  'Contact'],
                ] as [$href, $label])
                <a href="{{ $href }}"
                   class="px-3 py-2 rounded-lg text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-brand-600 dark:hover:text-brand-400 hover:bg-brand-50 dark:hover:bg-brand-950 transition-all">
                    {{ $label }}
                </a>
                @endforeach
            </div>

            <!-- Right actions -->
            <div class="hidden md:flex items-center gap-3">
                <!-- Dark mode toggle -->
                <button @click="darkMode = !darkMode"
                        class="p-2 rounded-lg text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors"
                        :title="darkMode ? 'Switch to light mode' : 'Switch to dark mode'">
                    <i x-show="!darkMode" data-lucide="moon" class="w-5 h-5"></i>
                    <i x-show="darkMode"  data-lucide="sun"  class="w-5 h-5"></i>
                </button>

                @if(!empty($settings['resume_url']))
                <a href="{{ $settings['resume_url'] }}" target="_blank"
                   class="flex items-center gap-2 px-4 py-2 bg-brand-600 hover:bg-brand-700 text-white text-sm font-semibold rounded-xl transition-all shadow-md shadow-brand-500/20 hover:shadow-lg hover:-translate-y-0.5">
                    <i data-lucide="download" class="w-4 h-4"></i> Resume
                </a>
                @endif
            </div>

            <!-- Mobile toggle -->
            <button @click="open = !open" class="md:hidden p-2 rounded-lg text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                <i x-show="!open" data-lucide="menu" class="w-6 h-6"></i>
                <i x-show="open"  data-lucide="x"    class="w-6 h-6"></i>
            </button>
        </div>
    </div>

    <!-- Mobile menu -->
    <div x-show="open" x-cloak x-transition
         class="md:hidden bg-white dark:bg-gray-900 border-t border-gray-100 dark:border-gray-800 px-4 py-4 space-y-1">
        @foreach([
            ['#about','About'], ['#projects','Projects'], ['#skills','Skills'],
            ['#experience','Experience'], ['#certs','Certifications'],
            [route('blog.index'),'Blog'], ['#contact','Contact'],
        ] as [$href, $label])
        <a href="{{ $href }}" @click="open = false"
           class="block px-3 py-2.5 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-brand-50 dark:hover:bg-brand-950 hover:text-brand-600 dark:hover:text-brand-400 transition-colors">
            {{ $label }}
        </a>
        @endforeach
        <div class="pt-3 flex items-center gap-3">
            <button @click="darkMode = !darkMode"
                    class="p-2 rounded-lg text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                <i data-lucide="moon" class="w-5 h-5"></i>
            </button>
        </div>
    </div>
</nav>
