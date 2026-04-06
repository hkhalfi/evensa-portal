<header class="sticky top-0 z-50 border-b border-white/10 bg-slate-950/80 backdrop-blur-xl">
    <div class="container-app flex h-16 items-center justify-between">
        <a href="{{ url('/') }}" class="flex items-center gap-3">
            <img src="{{ asset('images/evensa-logo.png') }}" alt="EvEnsa" class="h-9 w-9 rounded-lg object-contain">
            <div class="leading-tight">
                <div class="text-sm font-semibold text-white">EvEnsa</div>
                <div class="text-xs text-slate-400">Portail des événements</div>
            </div>
        </a>

        <nav class="hidden items-center gap-8 md:flex">
            <a href="{{ url('/') }}" class="text-sm text-slate-300 transition hover:text-white">Accueil</a>
            <a href="{{ url('/events') }}" class="text-sm text-slate-300 transition hover:text-white">Événements</a>
            <a href="{{ url('/instances') }}" class="text-sm text-slate-300 transition hover:text-white">Instances</a>
            <a href="{{ url('/annonces') }}" class="text-sm text-slate-300 transition hover:text-white">Annonces</a>
            <a href="{{ url('/faq') }}" class="text-sm text-slate-300 transition hover:text-white">FAQ</a>
        </nav>

        <div class="flex items-center gap-3">
            <a href="{{ url('/instance') }}"
                class="hidden text-sm text-slate-300 transition hover:text-white md:inline-flex">
                Portail Instance
            </a>
            <a href="{{ url('/admin') }}" class="btn-primary-app">
                Portail Admin
            </a>
        </div>
    </div>
</header>
