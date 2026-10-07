<!DOCTYPE html>
<html lang="en" class="scroll-smooth" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }"
      x-init="$watch('darkMode', v => localStorage.setItem('darkMode', v))"
      :class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>@yield('title', $settings['meta_title'] ?? 'John Paul Silva | Portfolio')</title>
    <meta name="description" content="@yield('description', $settings['meta_description'] ?? '')"/>
    <meta name="keywords"    content="@yield('keywords',    $settings['meta_keywords']   ?? '')"/>
    <meta property="og:title"       content="@yield('og_title', $settings['meta_title'] ?? '')"/>
    <meta property="og:description" content="@yield('og_description', $settings['meta_description'] ?? '')"/>
    <meta property="og:type"        content="website"/>
    <meta property="og:url"         content="{{ url()->current() }}"/>
    @if(!empty($settings['og_image']))
    <meta property="og:image" content="{{ asset('storage/' . $settings['og_image']) }}"/>
    @endif
    <link rel="canonical" href="{{ url()->current() }}"/>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet"/>

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'system-ui', 'sans-serif'], mono: ['JetBrains Mono', 'monospace'] },
                    colors: {
                        brand: { 50:'#eff6ff',100:'#dbeafe',200:'#bfdbfe',300:'#93c5fd',400:'#60a5fa',500:'#3b82f6',600:'#2563eb',700:'#1d4ed8',800:'#1e40af',900:'#1e3a8f' }
                    },
                    animation: {
                        'fade-in-up': 'fadeInUp 0.6s ease-out both',
                        'float': 'float 4s ease-in-out infinite',
                    },
                    keyframes: {
                        fadeInUp: { '0%': { opacity:'0', transform:'translateY(24px)' }, '100%': { opacity:'1', transform:'translateY(0)' } },
                        float: { '0%,100%': { transform:'translateY(0)' }, '50%': { transform:'translateY(-8px)' } },
                    }
                }
            }
        }
    </script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        [x-cloak] { display: none !important; }
        .gradient-text { background: linear-gradient(135deg, #2563eb, #7c3aed); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .section-padding { padding: 5rem 0; }
        @media (max-width: 768px) { .section-padding { padding: 3rem 0; } }
        .skill-bar { transition: width 1.2s ease-out; }
        .card-hover { transition: transform 0.2s ease, box-shadow 0.2s ease; }
        .card-hover:hover { transform: translateY(-4px); box-shadow: 0 20px 40px rgba(0,0,0,0.12); }
        .dark .card-hover:hover { box-shadow: 0 20px 40px rgba(0,0,0,0.4); }
        html { scroll-behavior: smooth; }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }
        .dark ::-webkit-scrollbar-track { background: #1e293b; }
        .dark ::-webkit-scrollbar-thumb { background: #475569; }
    </style>
    @stack('head')
</head>
<body class="bg-white dark:bg-gray-950 text-gray-900 dark:text-gray-100 font-sans antialiased transition-colors duration-300">

    @include('layouts.nav')

    <main>@yield('content')</main>

    @include('layouts.footer')

    <script>
        // Init Lucide icons
        lucide.createIcons();

        // Scroll animations
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(el => {
                if (el.isIntersecting) {
                    el.target.classList.add('animate-fade-in-up');
                    observer.unobserve(el.target);
                }
            });
        }, { threshold: 0.1 });
        document.querySelectorAll('[data-animate]').forEach(el => observer.observe(el));

        // Skill bar animations
        const skillObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const bars = entry.target.querySelectorAll('.skill-fill');
                    bars.forEach(bar => {
                        const pct = bar.getAttribute('data-pct');
                        setTimeout(() => { bar.style.width = pct + '%'; }, 200);
                    });
                    skillObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.2 });
        document.querySelectorAll('#skills').forEach(el => skillObserver.observe(el));
    </script>
    @stack('scripts')
</body>
</html>
