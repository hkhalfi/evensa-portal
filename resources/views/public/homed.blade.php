@extends('layouts.public')

@section('content')
    {{-- HERO --}}
    <section class="relative overflow-hidden border-b border-white/10 bg-slate-950">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,rgba(59,130,246,0.22),transparent_38%)]"></div>
        <div class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-white/20 to-transparent"></div>

        <div class="container-app relative py-20 md:py-28">
            <div class="mx-auto max-w-5xl text-center">
                <div
                    class="inline-flex items-center rounded-full border border-white/10 bg-white/5 px-4 py-2 text-xs font-medium uppercase tracking-[0.22em] text-slate-300">
                    Plateforme événementielle officielle de l’ENSA Khouribga
                </div>

                <h1 class="mt-8 text-4xl font-semibold tracking-tight text-white md:text-6xl md:leading-[1.05]">
                    Gouverner, publier et valoriser
                    <span class="text-slate-300">les événements de l’établissement</span>
                </h1>

                <p class="mx-auto mt-6 max-w-3xl text-base leading-8 text-slate-400 md:text-lg">
                    EvEnsa centralise les événements publiés, les instances organisatrices, les annonces officielles
                    et les ressources utiles dans un portail institutionnel moderne, structuré et crédible.
                </p>

                <div class="mt-10 flex flex-wrap justify-center gap-4">
                    <a href="{{ route('events.index') }}" class="btn-primary-app">
                        Consulter les événements
                    </a>

                    <a href="{{ route('instances.index') }}" class="btn-secondary-app">
                        Découvrir les instances
                    </a>
                </div>
            </div>

            {{-- Stats --}}
            <div class="mx-auto mt-14 grid max-w-6xl gap-4 sm:grid-cols-2 xl:grid-cols-4">
                <div class="card-app bg-white/[0.03] p-5 text-center backdrop-blur-sm">
                    <div class="text-3xl font-semibold text-white">
                        {{ $stats['active_instances'] ?? 0 }}
                    </div>
                    <div class="mt-2 text-sm text-slate-400">
                        Instances actives
                    </div>
                </div>

                <div class="card-app bg-white/[0.03] p-5 text-center backdrop-blur-sm">
                    <div class="text-3xl font-semibold text-white">
                        {{ $stats['published_events'] ?? 0 }}
                    </div>
                    <div class="mt-2 text-sm text-slate-400">
                        Événements publiés
                    </div>
                </div>

                <div class="card-app bg-white/[0.03] p-5 text-center backdrop-blur-sm">
                    <div class="text-3xl font-semibold text-white">
                        {{ $stats['upcoming_events'] ?? 0 }}
                    </div>
                    <div class="mt-2 text-sm text-slate-400">
                        Événements à venir
                    </div>
                </div>

                <div class="card-app bg-white/[0.03] p-5 text-center backdrop-blur-sm">
                    <div class="text-3xl font-semibold text-white">
                        {{ $stats['archived_events'] ?? 0 }}
                    </div>
                    <div class="mt-2 text-sm text-slate-400">
                        Événements archivés
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- VISION --}}
    <section class="bg-slate-950 py-20">
        <div class="container-app">
            <div class="mb-10 max-w-3xl">
                <div class="text-sm font-semibold uppercase tracking-[0.18em] text-sky-300">
                    Vision de la plateforme
                </div>
                <h2 class="mt-3 text-3xl font-semibold tracking-tight text-white md:text-4xl">
                    Une plateforme institutionnelle, pas seulement un site d’événements
                </h2>
                <p class="mt-4 text-base leading-8 text-slate-400">
                    EvEnsa soutient la gouvernance des activités para-universitaires, la structuration des demandes
                    et la valorisation publique des initiatives académiques, scientifiques, culturelles et sociales.
                </p>
            </div>

            <div class="grid gap-6 lg:grid-cols-3">
                <div class="card-app bg-white/[0.03] p-7">
                    <div
                        class="mb-4 inline-flex rounded-full border border-white/10 bg-white/5 px-3 py-1 text-xs text-slate-300">
                        Cadre institutionnel
                    </div>
                    <h3 class="text-lg font-semibold text-white">À propos</h3>
                    <p class="mt-4 text-sm leading-7 text-slate-400">
                        EvEnsa constitue le portail institutionnel dédié à la structuration, à la publication
                        et à la valorisation des activités para-universitaires de l’ENSA Khouribga.
                    </p>
                </div>

                <div class="card-app bg-white/[0.03] p-7">
                    <div
                        class="mb-4 inline-flex rounded-full border border-white/10 bg-white/5 px-3 py-1 text-xs text-slate-300">
                        Workflow
                    </div>
                    <h3 class="text-lg font-semibold text-white">Gouvernance</h3>
                    <p class="mt-4 text-sm leading-7 text-slate-400">
                        La plateforme accompagne un processus clair de soumission, d’examen, de validation,
                        de publication et de suivi des événements dans un cadre institutionnel cohérent.
                    </p>
                </div>

                <div class="card-app bg-white/[0.03] p-7">
                    <div
                        class="mb-4 inline-flex rounded-full border border-white/10 bg-white/5 px-3 py-1 text-xs text-slate-300">
                        Communication
                    </div>
                    <h3 class="text-lg font-semibold text-white">Portail public</h3>
                    <p class="mt-4 text-sm leading-7 text-slate-400">
                        Les visiteurs accèdent aux événements publiés, aux instances actives, aux annonces officielles
                        et aux ressources utiles depuis une interface claire, premium et crédible.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- INSTANCES --}}
    <section class="bg-slate-900 py-20">
        <div class="container-app">
            <div class="mb-10 flex items-end justify-between gap-4">
                <div>
                    <div class="text-sm font-semibold uppercase tracking-[0.18em] text-sky-300">
                        Instances
                    </div>
                    <h2 class="mt-2 text-3xl font-semibold tracking-tight text-white">
                        Instances mises en avant
                    </h2>
                    <p class="mt-3 max-w-2xl text-sm leading-7 text-slate-400">
                        Un aperçu des structures actives impliquées dans la vie para-universitaire de l’établissement.
                    </p>
                </div>

                <a href="{{ route('instances.index') }}"
                    class="hidden text-sm font-medium text-sky-300 transition hover:text-white sm:inline-flex">
                    Voir toutes les instances →
                </a>
            </div>

            <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                @forelse($instances ?? [] as $instance)
                    <article class="card-app overflow-hidden bg-white/[0.03]">
                        <div class="h-24 bg-gradient-to-r from-slate-800 via-slate-900 to-sky-950"></div>

                        <div class="relative p-6">
                            <div
                                class="-mt-12 mb-4 flex h-16 w-16 items-center justify-center rounded-2xl border border-white/10 bg-slate-900 text-lg font-semibold text-white shadow-lg">
                                {{ \Illuminate\Support\Str::of($instance->name)->explode(' ')->map(fn($word) => \Illuminate\Support\Str::substr($word, 0, 1))->take(2)->join('') }}
                            </div>

                            <h3 class="text-xl font-semibold tracking-tight text-white">
                                {{ $instance->name }}
                            </h3>

                            @if (!empty($instance->description))
                                <p class="mt-4 text-sm leading-7 text-slate-400">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($instance->description), 120) }}
                                </p>
                            @endif

                            <div class="mt-6">
                                <a href="{{ route('instances.show', $instance) }}"
                                    class="text-sm font-medium text-sky-300 transition hover:text-white">
                                    Consulter la fiche →
                                </a>
                            </div>
                        </div>
                    </article>
                @empty
                    <article class="card-app bg-white/[0.03] p-6 md:col-span-2 xl:col-span-3">
                        <p class="text-base font-medium text-white">Aucune instance disponible pour le moment.</p>
                        <p class="mt-2 text-sm text-slate-400">
                            Les instances actives apparaîtront ici automatiquement.
                        </p>
                    </article>
                @endforelse
            </div>
        </div>
    </section>

    {{-- EVENTS --}}
    <section class="bg-slate-950 py-20">
        <div class="container-app">
            <div class="mb-10 flex items-end justify-between gap-4">
                <div>
                    <div class="text-sm font-semibold uppercase tracking-[0.18em] text-sky-300">
                        Événements publiés
                    </div>
                    <h2 class="mt-2 text-3xl font-semibold tracking-tight text-white">
                        Activités à venir
                    </h2>
                    <p class="mt-3 max-w-2xl text-sm leading-7 text-slate-400">
                        Une sélection des événements actuellement publiés sur le portail institutionnel.
                    </p>
                </div>

                <a href="{{ route('events.index') }}"
                    class="hidden text-sm font-medium text-sky-300 transition hover:text-white sm:inline-flex">
                    Voir tous les événements →
                </a>
            </div>

            <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                @forelse($events ?? [] as $event)
                    <article class="card-app bg-white/[0.03] p-6 transition hover:bg-white/[0.05]">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                @if (optional($event->category)->name)
                                    <div class="text-xs font-semibold uppercase tracking-[0.16em] text-sky-300">
                                        {{ $event->category->name }}
                                    </div>
                                @endif

                                <h3 class="mt-2 text-xl font-semibold tracking-tight text-white">
                                    <a href="{{ route('events.show', $event) }}" class="transition hover:text-sky-300">
                                        {{ $event->title }}
                                    </a>
                                </h3>
                            </div>

                            @if (optional($event->eventType)->name)
                                <span
                                    class="rounded-full border border-white/10 bg-white/5 px-3 py-1 text-xs font-medium text-slate-300">
                                    {{ $event->eventType->name }}
                                </span>
                            @endif
                        </div>

                        <div class="mt-5 space-y-3 text-sm text-slate-400">
                            @if (optional($event->instance)->name)
                                <div>
                                    <span class="font-semibold text-slate-200">Instance :</span>
                                    {{ $event->instance->name }}
                                </div>
                            @endif

                            @if ($event->start_at)
                                <div>
                                    <span class="font-semibold text-slate-200">Date :</span>
                                    {{ $event->start_at->format('d/m/Y à H:i') }}
                                </div>
                            @endif

                            @if (optional($event->venue)->name)
                                <div>
                                    <span class="font-semibold text-slate-200">Lieu :</span>
                                    {{ $event->venue->name }}
                                </div>
                            @endif
                        </div>

                        @if (!empty($event->description))
                            <p class="mt-5 text-sm leading-7 text-slate-400">
                                {{ \Illuminate\Support\Str::limit(strip_tags($event->description), 150) }}
                            </p>
                        @endif

                        <div class="mt-6">
                            <a href="{{ route('events.show', $event) }}"
                                class="text-sm font-medium text-sky-300 transition hover:text-white">
                                Consulter les détails →
                            </a>
                        </div>
                    </article>
                @empty
                    <article class="card-app bg-white/[0.03] p-6 md:col-span-2 xl:col-span-3">
                        <p class="text-base font-medium text-white">Aucun événement publié pour le moment.</p>
                        <p class="mt-2 text-sm text-slate-400">
                            Les événements publiés apparaîtront ici automatiquement.
                        </p>
                    </article>
                @endforelse
            </div>
        </div>
    </section>

    {{-- ANNOUNCEMENTS --}}
    <section class="bg-slate-900 py-20">
        <div class="container-app">
            <div class="mb-10 flex items-end justify-between gap-4">
                <div>
                    <div class="text-sm font-semibold uppercase tracking-[0.18em] text-sky-300">
                        Communication officielle
                    </div>
                    <h2 class="mt-2 text-3xl font-semibold tracking-tight text-white">
                        Annonces récentes
                    </h2>
                    <p class="mt-3 max-w-2xl text-sm leading-7 text-slate-400">
                        Les dernières informations institutionnelles publiées sur le portail EvEnsa.
                    </p>
                </div>

                <a href="{{ route('announcements.index') }}"
                    class="hidden text-sm font-medium text-sky-300 transition hover:text-white sm:inline-flex">
                    Voir toutes les annonces →
                </a>
            </div>

            <div class="grid gap-6 lg:grid-cols-3">
                @forelse($announcements ?? [] as $announcement)
                    <article class="card-app bg-white/[0.03] p-6 transition hover:bg-white/[0.05]">
                        <div class="flex flex-wrap items-center gap-3">
                            @if (!empty($announcement->type))
                                <span
                                    class="rounded-full border border-sky-400/20 bg-sky-400/10 px-3 py-1 text-xs font-medium text-sky-300">
                                    {{ $announcement->type }}
                                </span>
                            @endif

                            @if ($announcement->published_at)
                                <span class="text-sm text-slate-500">
                                    {{ $announcement->published_at->format('d/m/Y') }}
                                </span>
                            @endif
                        </div>

                        <h3 class="mt-4 text-xl font-semibold tracking-tight text-white">
                            <a href="{{ route('announcements.show', $announcement) }}"
                                class="transition hover:text-sky-300">
                                {{ $announcement->title }}
                            </a>
                        </h3>

                        @if (!empty($announcement->excerpt))
                            <p class="mt-4 text-sm leading-7 text-slate-400">
                                {{ \Illuminate\Support\Str::limit(strip_tags($announcement->excerpt), 140) }}
                            </p>
                        @elseif(!empty($announcement->content))
                            <p class="mt-4 text-sm leading-7 text-slate-400">
                                {{ \Illuminate\Support\Str::limit(strip_tags($announcement->content), 140) }}
                            </p>
                        @endif
                    </article>
                @empty
                    <article class="card-app bg-white/[0.03] p-6 lg:col-span-3">
                        <p class="text-base font-medium text-white">Aucune annonce disponible pour le moment.</p>
                        <p class="mt-2 text-sm text-slate-400">
                            Les annonces publiées apparaîtront ici automatiquement.
                        </p>
                    </article>
                @endforelse
            </div>
        </div>
    </section>

    {{-- CTA FINAL --}}
    <section class="bg-slate-950 py-24">
        <div class="container-app">
            <div class="grid gap-6 lg:grid-cols-2">
                <div class="card-app bg-white/[0.03] p-8">
                    <h2 class="text-2xl font-semibold text-white">
                        Vous représentez une instance organisatrice ?
                    </h2>
                    <p class="mt-4 text-sm leading-8 text-slate-400">
                        Le portail instance permet de préparer, soumettre et suivre les demandes d’organisation
                        dans un cadre institutionnel clair.
                    </p>

                    <div class="mt-6">
                        <a href="{{ url('/portal/login') }}" class="btn-primary-app">
                            Accéder au Portail Instance
                        </a>
                    </div>
                </div>

                <div class="card-app bg-white/[0.03] p-8">
                    <h2 class="text-2xl font-semibold text-white">
                        Administration et commission des activités
                    </h2>
                    <p class="mt-4 text-sm leading-8 text-slate-400">
                        Le portail administrateur centralise la gestion des demandes, des événements,
                        des utilisateurs, des référentiels et du pilotage global.
                    </p>

                    <div class="mt-6">
                        <a href="{{ url('/admin/login') }}" class="btn-secondary-app">
                            Accéder au Portail Admin
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
