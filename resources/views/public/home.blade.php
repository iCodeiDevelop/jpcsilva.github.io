@extends('layouts.app')
@section('title', $settings['meta_title'] ?? 'John Paul Silva | IT Consultant & Laravel Developer')
@section('description', $settings['meta_description'] ?? '')

@section('content')

{{-- ══════════════════════════════════════════════════════
     HERO SECTION
══════════════════════════════════════════════════════ --}}
<section id="hero" class="relative min-h-screen flex items-center justify-center overflow-hidden bg-gradient-to-br from-gray-50 via-white to-blue-50 dark:from-gray-950 dark:via-gray-900 dark:to-blue-950">
    <!-- Background decoration -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-40 w-96 h-96 bg-blue-400/20 dark:bg-blue-600/10 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-violet-400/15 dark:bg-violet-600/10 rounded-full blur-3xl"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px]"
             style="background:radial-gradient(circle, rgba(37,99,235,0.05) 0%, transparent 70%);"></div>
    </div>

    <div class="relative z-10 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center py-32">

        <!-- Available badge -->
        @if(($settings['availability_status'] ?? '') === 'open')
        <div class="inline-flex items-center gap-2 px-4 py-2 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-full text-sm text-green-700 dark:text-green-400 mb-10">
            <span class="relative flex h-2 w-2">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
            </span>
            ✦ {{ $settings['availability_note'] ?? 'Available for freelance projects' }}
        </div>
        @endif

        <!-- Greeting -->
        <p class="text-brand-600 dark:text-brand-400 font-semibold text-lg mb-4 tracking-wide">
            {{ $settings['hero_greeting'] ?? "Hi, I'm John Paul 👋" }}
        </p>

        <!-- Main headline -->
        <h1 class="text-5xl sm:text-6xl lg:text-7xl font-extrabold text-gray-900 dark:text-white tracking-tight mb-6 leading-tight">
            {{ $settings['hero_headline'] ?? 'IT Consultant &' }}<br/>
            <span class="gradient-text">Laravel Developer</span>
        </h1>

        <!-- Tagline -->
        <p class="text-xl sm:text-2xl text-gray-500 dark:text-gray-400 max-w-3xl mx-auto mb-4 leading-relaxed">
            {{ $settings['hero_tagline'] ?? 'I help businesses build systems that work — from Davao City to the world.' }}
        </p>

        <!-- Sub-tagline -->
        <p class="text-sm font-semibold text-gray-400 dark:text-gray-500 tracking-widest uppercase mb-12">
            {{ $settings['about_tagline'] ?? 'ITIL v4 · Licensed Professional Teacher · Laravel Developer' }}
        </p>

        <!-- CTAs -->
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4 mb-14">
            <a href="#projects"
               class="px-8 py-4 bg-brand-600 hover:bg-brand-700 text-white font-bold rounded-2xl shadow-xl shadow-brand-500/25 transition-all hover:-translate-y-1 hover:shadow-2xl text-base">
                {{ $settings['hero_cta_primary'] ?? '⚡ View My Work' }}
            </a>
            <a href="#contact"
               class="px-8 py-4 bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 font-bold rounded-2xl shadow-sm hover:border-brand-400 hover:text-brand-600 dark:hover:border-brand-600 dark:hover:text-brand-400 transition-all hover:-translate-y-1 text-base">
                {{ $settings['hero_cta_secondary'] ?? '💬 Get In Touch' }}
            </a>
        </div>

        <!-- Social links -->
        <div class="flex items-center justify-center gap-4">
            @if(!empty($settings['github_url']))
            <a href="{{ $settings['github_url'] }}" target="_blank"
               class="flex items-center gap-2 px-4 py-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl text-sm text-gray-600 dark:text-gray-400 hover:border-brand-300 hover:text-brand-600 transition-all shadow-sm">
                <i data-lucide="github" class="w-4 h-4"></i> GitHub
            </a>
            @endif
            @if(!empty($settings['linkedin_url']))
            <a href="{{ $settings['linkedin_url'] }}" target="_blank"
               class="flex items-center gap-2 px-4 py-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl text-sm text-gray-600 dark:text-gray-400 hover:border-blue-400 hover:text-blue-600 transition-all shadow-sm">
                <i data-lucide="linkedin" class="w-4 h-4"></i> LinkedIn
            </a>
            @endif
            @if(!empty($settings['email']))
            <a href="mailto:{{ $settings['email'] }}"
               class="flex items-center gap-2 px-4 py-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl text-sm text-gray-600 dark:text-gray-400 hover:border-brand-300 hover:text-brand-600 transition-all shadow-sm">
                <i data-lucide="mail" class="w-4 h-4"></i> Email
            </a>
            @endif
        </div>
    </div>

    <!-- Scroll indicator -->
    <a href="#about" class="absolute bottom-10 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2 text-gray-400 hover:text-brand-500 transition-colors animate-float">
        <span class="text-xs font-semibold tracking-widest uppercase">Scroll</span>
        <i data-lucide="chevrons-down" class="w-5 h-5"></i>
    </a>
</section>

{{-- ══════════════════════════════════════════════════════
     ABOUT SECTION
══════════════════════════════════════════════════════ --}}
<section id="about" class="section-padding bg-white dark:bg-gray-950">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <!-- Text -->
            <div data-animate>
                <p class="text-brand-600 dark:text-brand-400 font-semibold text-sm tracking-widest uppercase mb-3">About Me</p>
                <h2 class="text-4xl font-extrabold text-gray-900 dark:text-white mb-6">
                    Building systems that <span class="gradient-text">actually work</span>
                </h2>
                <div class="prose prose-gray dark:prose-invert prose-lg max-w-none">
                    @foreach(explode("\n\n", $settings['about_bio'] ?? '') as $para)
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed mb-4">{{ $para }}</p>
                    @endforeach
                </div>

                <!-- Quick stats -->
                <div class="grid grid-cols-3 gap-6 mt-8 pt-8 border-t border-gray-100 dark:border-gray-800">
                    <div>
                        <p class="text-3xl font-extrabold text-brand-600 dark:text-brand-400">8+</p>
                        <p class="text-sm text-gray-500 mt-1">Years in IT</p>
                    </div>
                    <div>
                        <p class="text-3xl font-extrabold text-brand-600 dark:text-brand-400">{{ $allProjects->count() }}+</p>
                        <p class="text-sm text-gray-500 mt-1">Projects</p>
                    </div>
                    <div>
                        <p class="text-3xl font-extrabold text-brand-600 dark:text-brand-400">3</p>
                        <p class="text-sm text-gray-500 mt-1">Certifications</p>
                    </div>
                </div>

                <!-- CTA -->
                <div class="flex items-center gap-4 mt-8">
                    <a href="#contact"
                       class="inline-flex items-center gap-2 px-6 py-3 bg-brand-600 hover:bg-brand-700 text-white font-semibold rounded-xl transition-all shadow-md shadow-brand-500/20 hover:-translate-y-0.5">
                        <i data-lucide="send" class="w-4 h-4"></i> Work With Me
                    </a>
                    @if(!empty($settings['resume_url']))
                    <a href="{{ $settings['resume_url'] }}" target="_blank"
                       class="inline-flex items-center gap-2 px-6 py-3 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 font-semibold rounded-xl hover:border-brand-400 transition-all">
                        <i data-lucide="download" class="w-4 h-4"></i> Resume
                    </a>
                    @endif
                </div>
            </div>

            <!-- Services grid -->
            <div data-animate class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @foreach($services as $service)
                <div class="p-5 bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-2xl card-hover">
                    <div class="w-10 h-10 bg-brand-100 dark:bg-brand-900/30 rounded-xl flex items-center justify-center mb-4">
                        <i data-lucide="{{ $service['icon'] }}" class="w-5 h-5 text-brand-600 dark:text-brand-400"></i>
                    </div>
                    <h3 class="font-bold text-gray-900 dark:text-white text-sm mb-2">{{ $service['title'] }}</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed">{{ $service['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════════
     PROJECTS SECTION
══════════════════════════════════════════════════════ --}}
<section id="projects" class="section-padding bg-gray-50 dark:bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16" data-animate>
            <p class="text-brand-600 dark:text-brand-400 font-semibold text-sm tracking-widest uppercase mb-3">Portfolio</p>
            <h2 class="text-4xl font-extrabold text-gray-900 dark:text-white mb-4">
                Featured <span class="gradient-text">Projects</span>
            </h2>
            <p class="text-lg text-gray-500 dark:text-gray-400 max-w-2xl mx-auto">
                Systems, web applications, and digital solutions I've built and delivered.
            </p>
        </div>

        <!-- Filter tabs -->
        <div x-data="{ filter: 'all' }" class="space-y-8">
            <div class="flex flex-wrap justify-center gap-2 mb-10">
                @foreach(['all' => 'All Projects', 'web' => 'Web Apps', 'systems' => 'Systems', 'mobile' => 'Mobile', 'data' => 'Data'] as $key => $label)
                <button @click="filter = '{{ $key }}'"
                        :class="filter === '{{ $key }}' ? 'bg-brand-600 text-white shadow-md shadow-brand-500/20' : 'bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-400 border border-gray-200 dark:border-gray-700 hover:border-brand-400'"
                        class="px-5 py-2 rounded-full text-sm font-semibold transition-all">
                    {{ $label }}
                </button>
                @endforeach
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($allProjects as $project)
                <article
                    x-show="filter === 'all' || filter === '{{ $project->category }}'"
                    x-transition
                    class="group bg-white dark:bg-gray-800 rounded-2xl overflow-hidden border border-gray-100 dark:border-gray-700 shadow-sm card-hover flex flex-col">

                    <!-- Thumbnail -->
                    <div class="relative h-48 bg-gradient-to-br from-brand-100 to-violet-100 dark:from-brand-900/30 dark:to-violet-900/30 overflow-hidden">
                        @if($project->thumbnail)
                        <img src="{{ $project->thumbnail_url }}" alt="{{ $project->title }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"/>
                        @else
                        <div class="absolute inset-0 flex items-center justify-center">
                            <span class="text-6xl font-black text-brand-200 dark:text-brand-800">{{ substr($project->title, 0, 1) }}</span>
                        </div>
                        @endif

                        <!-- Badges -->
                        <div class="absolute top-3 left-3 flex gap-2">
                            <span class="px-2.5 py-1 bg-brand-600 text-white text-xs font-semibold rounded-full">{{ $project->category_label }}</span>
                            @if($project->is_featured)
                            <span class="px-2.5 py-1 bg-amber-500 text-white text-xs font-semibold rounded-full">⭐ Featured</span>
                            @endif
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="flex flex-col flex-1 p-6">
                        <h3 class="font-bold text-gray-900 dark:text-white mb-2 group-hover:text-brand-600 dark:group-hover:text-brand-400 transition-colors">
                            {{ $project->title }}
                        </h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-4 flex-1 line-clamp-3">
                            {{ $project->short_description }}
                        </p>

                        <!-- Tech stack -->
                        <div class="flex flex-wrap gap-1.5 mb-5">
                            @foreach(array_slice($project->tech_stack ?? [], 0, 5) as $tech)
                            <span class="px-2 py-0.5 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 text-xs rounded-full font-medium">
                                {{ $tech }}
                            </span>
                            @endforeach
                            @if(count($project->tech_stack ?? []) > 5)
                            <span class="px-2 py-0.5 bg-gray-100 dark:bg-gray-700 text-gray-400 text-xs rounded-full">
                                +{{ count($project->tech_stack) - 5 }}
                            </span>
                            @endif
                        </div>

                        <!-- Links -->
                        <div class="flex items-center justify-between pt-4 border-t border-gray-100 dark:border-gray-700">
                            <div class="flex items-center gap-2">
                                @if(!empty($project->links['github']))
                                <a href="{{ $project->links['github'] }}" target="_blank"
                                   class="p-2 text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
                                    <i data-lucide="github" class="w-4 h-4"></i>
                                </a>
                                @endif
                                @if(!empty($project->links['live']))
                                <a href="{{ $project->links['live'] }}" target="_blank"
                                   class="p-2 text-gray-400 hover:text-brand-600 hover:bg-brand-50 dark:hover:bg-brand-950 rounded-lg transition-colors">
                                    <i data-lucide="external-link" class="w-4 h-4"></i>
                                </a>
                                @endif
                            </div>
                            <a href="{{ route('projects.show', $project->slug) }}"
                               class="text-xs font-bold text-brand-600 dark:text-brand-400 hover:underline flex items-center gap-1">
                                Details <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                            </a>
                        </div>
                    </div>
                </article>
                @empty
                <div class="col-span-3 text-center py-16 text-gray-400">
                    <i data-lucide="folder-open" class="w-12 h-12 mx-auto mb-4 opacity-40"></i>
                    <p>No projects yet — add them from the admin panel.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════════
     SKILLS SECTION
══════════════════════════════════════════════════════ --}}
<section id="skills" class="section-padding bg-white dark:bg-gray-950">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16" data-animate>
            <p class="text-brand-600 dark:text-brand-400 font-semibold text-sm tracking-widest uppercase mb-3">Expertise</p>
            <h2 class="text-4xl font-extrabold text-gray-900 dark:text-white mb-4">
                Skills & <span class="gradient-text">Technologies</span>
            </h2>
            <p class="text-gray-500 dark:text-gray-400 max-w-2xl mx-auto">
                Tools and technologies I use to deliver professional IT solutions.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
            @foreach($skillsGrouped as $category => $skills)
            @php
                $labels = ['backend'=>'⚙️ Backend','frontend'=>'🎨 Frontend','database'=>'🗄️ Database','devops'=>'🐳 DevOps','tools'=>'🔧 Tools','design'=>'✏️ Design','soft'=>'🤝 Soft Skills'];
                $catLabel = $labels[$category] ?? ucfirst($category);
            @endphp
            <div class="bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-2xl p-6" data-animate>
                <h3 class="font-bold text-gray-800 dark:text-gray-200 mb-5 text-sm">{{ $catLabel }}</h3>
                <div class="space-y-4">
                    @foreach($skills as $skill)
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <div class="flex items-center gap-2">
                                <div class="w-2 h-2 rounded-full" style="background:{{ $skill->hex_color }}"></div>
                                <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">{{ $skill->name }}</span>
                                @if($skill->years_experience > 0)
                                <span class="text-xs text-gray-400">{{ $skill->years_experience }}y</span>
                                @endif
                            </div>
                            <span class="text-xs font-bold" style="color:{{ $skill->hex_color }}">{{ $skill->proficiency }}%</span>
                        </div>
                        <div class="h-1.5 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                            <div class="skill-fill h-full rounded-full" style="width:0%;background:{{ $skill->hex_color }}" data-pct="{{ $skill->proficiency }}"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════════
     EXPERIENCE SECTION
══════════════════════════════════════════════════════ --}}
<section id="experience" class="section-padding bg-gray-50 dark:bg-gray-900">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16" data-animate>
            <p class="text-brand-600 dark:text-brand-400 font-semibold text-sm tracking-widest uppercase mb-3">Career</p>
            <h2 class="text-4xl font-extrabold text-gray-900 dark:text-white mb-4">
                Work <span class="gradient-text">Experience</span>
            </h2>
        </div>

        <div class="relative">
            <!-- Timeline line -->
            <div class="absolute left-8 top-0 bottom-0 w-0.5 bg-gradient-to-b from-brand-400 via-brand-200 to-transparent dark:from-brand-600 dark:via-brand-800"></div>

            <div class="space-y-10">
                @foreach($experiences as $exp)
                <div class="relative flex gap-8" data-animate>
                    <!-- Dot -->
                    <div class="flex-shrink-0 w-16 flex justify-center">
                        <div class="w-4 h-4 rounded-full border-4 border-white dark:border-gray-900 {{ $exp->is_current ? 'bg-green-500' : 'bg-brand-600' }} shadow-md mt-1.5 relative z-10"></div>
                    </div>

                    <!-- Card -->
                    <div class="flex-1 pb-2">
                        <div class="bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-2xl p-6 shadow-sm card-hover">
                            <div class="flex items-start justify-between gap-4 mb-3">
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ $exp->position }}</h3>
                                    <p class="text-brand-600 dark:text-brand-400 font-semibold text-sm mt-0.5">
                                        @if($exp->company_url)
                                        <a href="{{ $exp->company_url }}" target="_blank" class="hover:underline flex items-center gap-1">
                                            {{ $exp->company }} <i data-lucide="external-link" class="w-3 h-3"></i>
                                        </a>
                                        @else
                                        {{ $exp->company }}
                                        @endif
                                    </p>
                                </div>
                                @if($exp->is_current)
                                <span class="px-3 py-1 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 text-xs font-bold rounded-full flex-shrink-0">Current</span>
                                @endif
                            </div>

                            <div class="flex flex-wrap gap-4 text-xs text-gray-500 dark:text-gray-400 mb-4">
                                <span class="flex items-center gap-1.5">
                                    <i data-lucide="calendar" class="w-3.5 h-3.5"></i>
                                    {{ $exp->start_date->format('M Y') }} – {{ $exp->end_label }}
                                    <span class="text-gray-400">({{ $exp->duration }})</span>
                                </span>
                                @if($exp->location)
                                <span class="flex items-center gap-1.5">
                                    <i data-lucide="{{ $exp->is_remote ? 'wifi' : 'map-pin' }}" class="w-3.5 h-3.5"></i>
                                    {{ $exp->is_remote ? 'Remote · ' : '' }}{{ $exp->location }}
                                </span>
                                @endif
                                <span class="flex items-center gap-1.5">
                                    <i data-lucide="briefcase" class="w-3.5 h-3.5"></i>
                                    {{ ucfirst(str_replace('-', ' ', $exp->employment_type)) }}
                                </span>
                            </div>

                            @if($exp->description)
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4 leading-relaxed">{{ $exp->description }}</p>
                            @endif

                            @if($exp->highlights)
                            <ul class="space-y-1.5 mb-4">
                                @foreach($exp->highlights as $highlight)
                                <li class="flex items-start gap-2 text-sm text-gray-600 dark:text-gray-400">
                                    <span class="mt-1.5 w-1.5 h-1.5 rounded-full bg-brand-500 flex-shrink-0"></span>
                                    {{ $highlight }}
                                </li>
                                @endforeach
                            </ul>
                            @endif

                            @if($exp->tech_used)
                            <div class="flex flex-wrap gap-1.5">
                                @foreach($exp->tech_used as $tech)
                                <span class="px-2.5 py-0.5 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 text-xs rounded-full">{{ $tech }}</span>
                                @endforeach
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════════
     CERTIFICATIONS SECTION
══════════════════════════════════════════════════════ --}}
<section id="certs" class="section-padding bg-white dark:bg-gray-950">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16" data-animate>
            <p class="text-brand-600 dark:text-brand-400 font-semibold text-sm tracking-widest uppercase mb-3">Credentials</p>
            <h2 class="text-4xl font-extrabold text-gray-900 dark:text-white mb-4">
                Certifications & <span class="gradient-text">Licenses</span>
            </h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($certifications as $cert)
            <div class="bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-2xl p-6 card-hover" data-animate>
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 bg-brand-100 dark:bg-brand-900/30 rounded-xl flex items-center justify-center flex-shrink-0">
                        <i data-lucide="award" class="w-6 h-6 text-brand-600 dark:text-brand-400"></i>
                    </div>
                    <div class="flex-1">
                        <h3 class="font-bold text-gray-900 dark:text-white text-sm mb-1">{{ $cert->name }}</h3>
                        <p class="text-brand-600 dark:text-brand-400 text-xs font-semibold mb-2">{{ $cert->issuer }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 flex items-center gap-1 mb-3">
                            <i data-lucide="calendar" class="w-3 h-3"></i>
                            {{ $cert->issued_at->format('M Y') }}
                            @if($cert->expires_at) · Expires {{ $cert->expires_at->format('M Y') }} @endif
                        </p>
                        @if($cert->skills_covered)
                        <div class="flex flex-wrap gap-1 mb-3">
                            @foreach($cert->skills_covered as $skill)
                            <span class="px-2 py-0.5 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-400 text-xs rounded-full">{{ $skill }}</span>
                            @endforeach
                        </div>
                        @endif
                        @if($cert->credential_url)
                        <a href="{{ $cert->credential_url }}" target="_blank"
                           class="text-xs text-brand-600 dark:text-brand-400 hover:underline flex items-center gap-1">
                            Verify Credential <i data-lucide="external-link" class="w-3 h-3"></i>
                        </a>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════════
     BLOG PREVIEW
══════════════════════════════════════════════════════ --}}
@if($featuredBlogs->isNotEmpty())
<section id="blog" class="section-padding bg-gray-50 dark:bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-end justify-between mb-12" data-animate>
            <div>
                <p class="text-brand-600 dark:text-brand-400 font-semibold text-sm tracking-widest uppercase mb-2">Writing</p>
                <h2 class="text-4xl font-extrabold text-gray-900 dark:text-white">Latest <span class="gradient-text">Articles</span></h2>
            </div>
            <a href="{{ route('blog.index') }}" class="hidden md:flex items-center gap-1.5 text-brand-600 dark:text-brand-400 font-semibold text-sm hover:gap-2.5 transition-all">
                All Posts <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($featuredBlogs as $post)
            <article class="group bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-2xl overflow-hidden card-hover" data-animate>
                <div class="h-40 bg-gradient-to-br from-brand-100 to-violet-100 dark:from-brand-900/30 dark:to-violet-900/30 flex items-center justify-center">
                    <span class="text-5xl font-black text-brand-200 dark:text-brand-800">{{ substr($post->title, 0, 1) }}</span>
                </div>
                <div class="p-5">
                    <div class="flex flex-wrap gap-1.5 mb-3">
                        @foreach(array_slice($post->tags ?? [], 0, 2) as $tag)
                        <span class="px-2.5 py-0.5 bg-brand-50 dark:bg-brand-900/20 text-brand-700 dark:text-brand-400 text-xs rounded-full font-medium">{{ $tag }}</span>
                        @endforeach
                    </div>
                    <h3 class="font-bold text-gray-900 dark:text-white text-sm mb-2 line-clamp-2 group-hover:text-brand-600 transition-colors">
                        <a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a>
                    </h3>
                    @if($post->excerpt)
                    <p class="text-xs text-gray-500 dark:text-gray-400 line-clamp-3 mb-4">{{ $post->excerpt }}</p>
                    @endif
                    <div class="flex items-center justify-between text-xs text-gray-400">
                        <span class="flex items-center gap-1"><i data-lucide="clock" class="w-3 h-3"></i> {{ $post->reading_time }} min</span>
                        @if($post->published_at)<span>{{ $post->published_at->format('M d, Y') }}</span>@endif
                    </div>
                </div>
            </article>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ══════════════════════════════════════════════════════
     CONTACT SECTION
══════════════════════════════════════════════════════ --}}
<section id="contact" class="section-padding bg-white dark:bg-gray-950">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16" data-animate>
            <p class="text-brand-600 dark:text-brand-400 font-semibold text-sm tracking-widest uppercase mb-3">Contact</p>
            <h2 class="text-4xl font-extrabold text-gray-900 dark:text-white mb-4">
                {{ $settings['contact_heading'] ?? "Let's Work Together" }}
            </h2>
            <p class="text-lg text-gray-500 dark:text-gray-400 max-w-xl mx-auto">
                {{ $settings['contact_subheading'] ?? "Have a project in mind? I'd love to hear about it." }}
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-5 gap-12">
            <!-- Info -->
            <div class="lg:col-span-2 space-y-8" data-animate>
                <div class="space-y-4">
                    @if(!empty($settings['location']))
                    <div class="flex items-center gap-3 text-gray-600 dark:text-gray-400">
                        <div class="w-10 h-10 bg-brand-50 dark:bg-brand-900/20 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i data-lucide="map-pin" class="w-5 h-5 text-brand-600 dark:text-brand-400"></i>
                        </div>
                        <span>{{ $settings['location'] }}</span>
                    </div>
                    @endif
                    @if(!empty($settings['email']))
                    <div class="flex items-center gap-3 text-gray-600 dark:text-gray-400">
                        <div class="w-10 h-10 bg-brand-50 dark:bg-brand-900/20 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i data-lucide="mail" class="w-5 h-5 text-brand-600 dark:text-brand-400"></i>
                        </div>
                        <a href="mailto:{{ $settings['email'] }}" class="hover:text-brand-600 transition-colors">{{ $settings['email'] }}</a>
                    </div>
                    @endif
                    @if(!empty($settings['timezone']))
                    <div class="flex items-center gap-3 text-gray-600 dark:text-gray-400">
                        <div class="w-10 h-10 bg-brand-50 dark:bg-brand-900/20 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i data-lucide="clock" class="w-5 h-5 text-brand-600 dark:text-brand-400"></i>
                        </div>
                        <span>{{ $settings['timezone'] }}</span>
                    </div>
                    @endif
                </div>

                @if(($settings['availability_status'] ?? '') === 'open')
                <div class="p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-xl">
                    <p class="text-sm font-bold text-green-800 dark:text-green-400 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                        Open to opportunities
                    </p>
                    @if(!empty($settings['availability_note']))
                    <p class="text-sm text-green-700 dark:text-green-500 mt-1">{{ $settings['availability_note'] }}</p>
                    @endif
                </div>
                @endif
            </div>

            <!-- Form -->
            <div class="lg:col-span-3" data-animate>
                @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-xl text-green-700 dark:text-green-400 flex items-start gap-3">
                    <i data-lucide="check-circle" class="w-5 h-5 flex-shrink-0 mt-0.5"></i>
                    <p>{{ session('success') }}</p>
                </div>
                @endif

                <form method="POST" action="{{ route('contact.send') }}"
                      class="bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-2xl p-8 space-y-5">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Full Name <span class="text-red-400">*</span></label>
                            <input type="text" name="name" value="{{ old('name') }}" required placeholder="John Doe"
                                   class="w-full px-4 py-2.5 border border-gray-200 dark:border-gray-700 rounded-xl bg-white dark:bg-gray-800 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 transition-all @error('name') border-red-400 @enderror"/>
                            @error('name')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Email Address <span class="text-red-400">*</span></label>
                            <input type="email" name="email" value="{{ old('email') }}" required placeholder="john@company.com"
                                   class="w-full px-4 py-2.5 border border-gray-200 dark:border-gray-700 rounded-xl bg-white dark:bg-gray-800 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 transition-all @error('email') border-red-400 @enderror"/>
                            @error('email')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Project Type</label>
                            <select name="project_type" class="w-full px-4 py-2.5 border border-gray-200 dark:border-gray-700 rounded-xl bg-white dark:bg-gray-800 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500">
                                <option value="">Select type...</option>
                                <option value="Laravel Development">Laravel / PHP Development</option>
                                <option value="IT Consulting">IT Consulting</option>
                                <option value="Systems Analysis">Systems Analysis & Design</option>
                                <option value="Technical Writing">Technical Writing</option>
                                <option value="IT Training">IT Training / Facilitation</option>
                                <option value="Project Management">IT Project Management</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Budget Range</label>
                            <select name="budget_range" class="w-full px-4 py-2.5 border border-gray-200 dark:border-gray-700 rounded-xl bg-white dark:bg-gray-800 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500">
                                <option value="">Select budget...</option>
                                <option value="Under $500">Under $500</option>
                                <option value="$500–$2,000">$500 – $2,000</option>
                                <option value="$2,000–$5,000">$2,000 – $5,000</option>
                                <option value="$5,000–$10,000">$5,000 – $10,000</option>
                                <option value="$10,000+">$10,000+</option>
                                <option value="Discuss">Let's discuss</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Subject <span class="text-red-400">*</span></label>
                        <input type="text" name="subject" value="{{ old('subject') }}" required placeholder="Project inquiry — Laravel web application"
                               class="w-full px-4 py-2.5 border border-gray-200 dark:border-gray-700 rounded-xl bg-white dark:bg-gray-800 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 @error('subject') border-red-400 @enderror"/>
                        @error('subject')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Message <span class="text-red-400">*</span></label>
                        <textarea name="message" rows="5" required placeholder="Tell me about your project, timeline, and what you're looking to achieve..."
                                  class="w-full px-4 py-2.5 border border-gray-200 dark:border-gray-700 rounded-xl bg-white dark:bg-gray-800 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 resize-y @error('message') border-red-400 @enderror">{{ old('message') }}</textarea>
                        @error('message')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                    </div>

                    <button type="submit"
                            class="w-full flex items-center justify-center gap-2 py-3.5 bg-brand-600 hover:bg-brand-700 text-white font-bold rounded-xl transition-all shadow-lg shadow-brand-500/20 hover:-translate-y-0.5 hover:shadow-xl">
                        <i data-lucide="send" class="w-4 h-4"></i> Send Message
                    </button>
                    <p class="text-center text-xs text-gray-400">Response time: usually within 24 hours · Rate limited to 5 messages/hour</p>
                </form>
            </div>
        </div>
    </div>
</section>

@endsection
