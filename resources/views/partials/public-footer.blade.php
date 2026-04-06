<footer class="border-t border-slate-200 bg-white dark:border-slate-800 dark:bg-slate-950">
    <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
        <div class="grid gap-8 md:grid-cols-3">
            <div>
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/evensa-logo.png') }}" alt="EvEnsa" class="h-10 w-auto">
                    <div>
                        <div class="text-base font-semibold text-slate-900 dark:text-white">EvEnsa</div>
                        <div class="text-sm text-slate-500 dark:text-slate-400">Plateforme événementielle ENSA Khouribga
                        </div>
                    </div>
                </div>

                <p class="mt-4 max-w-md text-sm leading-7 text-slate-600 dark:text-slate-300">
                    Portail institutionnel dédié à la publication et à la valorisation des activités
                    para-universitaires.
                </p>
            </div>

            <div>
                <h3 class="text-sm font-semibold uppercase tracking-[0.16em] text-slate-900 dark:text-white">
                    Navigation
                </h3>
                <ul class="mt-4 space-y-3 text-sm text-slate-600 dark:text-slate-300">
                    <li><a href="{{ route('about') }}" class="transition hover:text-blue-700">À propos</a></li>
                    <li><a href="{{ route('instances.index') }}" class="transition hover:text-blue-700">Instances</a>
                    </li>
                    <li><a href="{{ route('events.index') }}" class="transition hover:text-blue-700">Événements</a></li>
                    <li><a href="{{ route('announcements.index') }}" class="transition hover:text-blue-700">Annonces</a>
                    </li>
                    <li><a href="{{ route('faq') }}" class="transition hover:text-blue-700">FAQ</a></li>
                </ul>
            </div>

            <div>
                <h3 class="text-sm font-semibold uppercase tracking-[0.16em] text-slate-900 dark:text-white">
                    Contact
                </h3>
                <ul class="mt-4 space-y-3 text-sm text-slate-600 dark:text-slate-300">
                    <li>ENSA Khouribga</li>
                    <li><a href="mailto:evensa@usms.ma" class="transition hover:text-blue-700">evensa@usms.ma</a></li>
                    <li><a href="tel:+212523492335" class="transition hover:text-blue-700">+212 523 49 23 35</a></li>
                </ul>
            </div>
        </div>

        <div
            class="mt-8 border-t border-slate-200 pt-6 text-sm text-slate-500 dark:border-slate-800 dark:text-slate-400">
            © 2026 EvEnsa — Tous droits réservés.
        </div>
    </div>
</footer>
