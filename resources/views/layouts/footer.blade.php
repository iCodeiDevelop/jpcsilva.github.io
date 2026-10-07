<footer class="bg-gray-900 dark:bg-black text-gray-400 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row items-center justify-between gap-6">
            <div>
                <a href="{{ route('home') }}" class="font-mono text-xl font-bold text-white">&lt;JP /&gt;</a>
                <p class="text-sm mt-1">{{ $settings['display_name'] ?? 'John Paul Silva' }} — IT Consultant & Laravel Developer</p>
            </div>
            <div class="flex items-center gap-4">
                @if(!empty($settings['github_url']))
                <a href="{{ $settings['github_url'] }}" target="_blank" class="p-2.5 bg-gray-800 hover:bg-brand-600 rounded-full text-gray-400 hover:text-white transition-all">
                    <i data-lucide="github" class="w-5 h-5"></i>
                </a>
                @endif
                @if(!empty($settings['linkedin_url']))
                <a href="{{ $settings['linkedin_url'] }}" target="_blank" class="p-2.5 bg-gray-800 hover:bg-blue-600 rounded-full text-gray-400 hover:text-white transition-all">
                    <i data-lucide="linkedin" class="w-5 h-5"></i>
                </a>
                @endif
                @if(!empty($settings['email']))
                <a href="mailto:{{ $settings['email'] }}" class="p-2.5 bg-gray-800 hover:bg-brand-600 rounded-full text-gray-400 hover:text-white transition-all">
                    <i data-lucide="mail" class="w-5 h-5"></i>
                </a>
                @endif
            </div>
        </div>
        <div class="mt-8 pt-8 border-t border-gray-800 text-center">
            <p class="text-sm">
                &copy; {{ date('Y') }} {{ $settings['display_name'] ?? 'John Paul Silva' }} · All rights reserved ·
                Built with <span class="text-red-400">♥</span> using Laravel + Tailwind CSS ·
                <a href="{{ route('admin.login') }}" class="hover:text-gray-300 transition-colors">Admin</a>
            </p>
        </div>
    </div>
</footer>
<script>lucide.createIcons();</script>
