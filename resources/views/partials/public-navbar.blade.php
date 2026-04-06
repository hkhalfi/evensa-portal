<header class="sticky top-0 z-50 border-b border-slate-200 bg-white dark:border-slate-800 dark:bg-slate-950">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-3 items-center min-h-[84px]">

            {{-- LEFT — LOGO --}}
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    <img src="{{ asset('images/evensa-logo.png') }}" alt="EvEnsa" class="h-12 w-auto">
                    <div class="hidden sm:block">
                        <div class="text-[11px] font-semibold uppercase tracking-[0.22em] text-blue-700">
                            Portail institutionnel
                        </div>
                        <div class="text-lg font-bold tracking-tight text-slate-950 dark:text-white">
                            EvEnsa
                        </div>
                    </div>
                </a>
            </div>

            {{-- CENTER — NAVIGATION --}}
            <nav class="hidden lg:flex justify-center items-center gap-8">
                <a href="{{ route('about') }}"
                    class="text-sm font-medium text-slate-700 transition hover:text-blue-700 dark:text-slate-200">
                    Commission
                </a>

                <a href="{{ route('instances.index') }}"
                    class="text-sm font-medium text-slate-700 transition hover:text-blue-700 dark:text-slate-200">
                    Instances
                </a>

                <a href="{{ route('events.index') }}"
                    class="text-sm font-medium text-slate-700 transition hover:text-blue-700 dark:text-slate-200">
                    Événements
                </a>

                <a href="{{ route('announcements.index') }}"
                    class="text-sm font-medium text-slate-700 transition hover:text-blue-700 dark:text-slate-200">
                    Annonces
                </a>

                <a href="{{ route('faq') }}"
                    class="text-sm font-medium text-slate-700 transition hover:text-blue-700 dark:text-slate-200">
                    FAQ
                </a>
            </nav>

            {{-- RIGHT — ACTIONS --}}
            <div class="flex items-center justify-end gap-4">

                {{-- DARK MODE --}}
                <button type="button" x-on:click="darkMode = !darkMode"
                    class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-700 transition hover:border-blue-200 hover:text-blue-700 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200"
                    aria-label="Changer le thème">
                    <span x-show="!darkMode">☀️</span>
                    <span x-show="darkMode">🌙</span>
                </button>

                {{-- PORTAIL INSTANCE --}}
                <a href="/admin/login"
                    class="hidden sm:inline-flex items-center rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:border-blue-200 hover:text-blue-700 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100">
                    Portail Login
                </a>

            </div>

        </div>
    </div>
</header>
