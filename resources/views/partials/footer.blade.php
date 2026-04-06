<footer class="border-t border-white/10 bg-slate-950">
    <div class="container-app py-10">
        <div class="flex flex-col gap-6 md:flex-row md:items-center md:justify-between">
            <div>
                <p class="text-sm font-medium text-white">EvEnsa</p>
                <p class="mt-2 text-sm text-slate-400">
                    Plateforme institutionnelle de gestion et de valorisation des événements de l’ENSA.
                </p>
            </div>

            <div class="flex flex-wrap gap-6 text-sm text-slate-400">
                <a href="{{ url('/a-propos') }}" class="transition hover:text-white">À propos</a>
                <a href="{{ url('/events') }}" class="transition hover:text-white">Événements</a>
                <a href="{{ url('/annonces') }}" class="transition hover:text-white">Annonces</a>
                <a href="{{ url('/faq') }}" class="transition hover:text-white">FAQ</a>
            </div>
        </div>
    </div>
</footer>
