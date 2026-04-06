@extends('layouts.public')

@section('content')
    {{-- HERO --}}
    <section class="border-b border-slate-200 bg-white dark:border-slate-800 dark:bg-slate-950">
        <div class="mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8 lg:py-24">
            <div class="mx-auto max-w-4xl text-center">
                <div
                    class="inline-flex items-center rounded-full border border-blue-100 bg-blue-50 px-4 py-2 text-sm font-medium text-blue-700 dark:border-slate-700 dark:bg-slate-900 dark:text-blue-300">
                    Plateforme événementielle officielle de l’ENSA Khouribga
                </div>

                <h1 class="mt-8 text-4xl font-bold tracking-tight text-slate-950 md:text-5xl dark:text-white">
                    Gestion, publication et valorisation des activités para-universitaires
                </h1>

                <p class="mx-auto mt-6 max-w-3xl text-lg leading-8 text-slate-600 dark:text-slate-300">
                    EvEnsa centralise les événements publiés, les instances organisatrices, les annonces officielles
                    et les ressources utiles dans un cadre institutionnel clair, structuré et moderne.
                </p>

                <div class="mt-10 flex flex-wrap justify-center gap-4">
                    <a href="{{ route('events.index') }}"
                        class="inline-flex items-center rounded-xl bg-blue-700 px-6 py-3 text-sm font-semibold text-white transition hover:bg-blue-800">
                        Consulter les événements
                    </a>

                    <a href="{{ route('instances.index') }}"
                        class="inline-flex items-center rounded-xl border border-slate-200 bg-white px-6 py-3 text-sm font-semibold text-slate-700 transition hover:border-blue-200 hover:text-blue-700 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100">
                        Découvrir les instances
                    </a>
                </div>
            </div>

            {{-- STATS --}}
            <div class="mx-auto mt-14 grid max-w-5xl gap-4 sm:grid-cols-2 xl:grid-cols-4">
                <div
                    class="rounded-2xl border border-slate-200 bg-slate-50 p-5 text-center dark:border-slate-800 dark:bg-slate-900">
                    <div class="text-3xl font-bold text-slate-950 dark:text-white">
                        {{ $stats['active_instances'] }}
                    </div>
                    <div class="mt-2 text-sm text-slate-500 dark:text-slate-400">
                        Instances actives
                    </div>
                </div>

                <div
                    class="rounded-2xl border border-slate-200 bg-slate-50 p-5 text-center dark:border-slate-800 dark:bg-slate-900">
                    <div class="text-3xl font-bold text-slate-950 dark:text-white">
                        {{ $stats['published_events'] }}
                    </div>
                    <div class="mt-2 text-sm text-slate-500 dark:text-slate-400">
                        Événements publiés
                    </div>
                </div>

                <div
                    class="rounded-2xl border border-slate-200 bg-slate-50 p-5 text-center dark:border-slate-800 dark:bg-slate-900">
                    <div class="text-3xl font-bold text-slate-950 dark:text-white">
                        {{ $stats['upcoming_events'] }}
                    </div>
                    <div class="mt-2 text-sm text-slate-500 dark:text-slate-400">
                        Événements à venir
                    </div>
                </div>

                <div
                    class="rounded-2xl border border-slate-200 bg-slate-50 p-5 text-center dark:border-slate-800 dark:bg-slate-900">
                    <div class="text-3xl font-bold text-slate-950 dark:text-white">
                        {{ $stats['archived_events'] }}
                    </div>
                    <div class="mt-2 text-sm text-slate-500 dark:text-slate-400">
                        Événements archivés
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- BLOC ÉDITORIAL --}}
    <section class="bg-slate-50 py-16 dark:bg-slate-900">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-6 lg:grid-cols-3">
                <div class="rounded-2xl border border-slate-200 bg-white p-6 dark:border-slate-800 dark:bg-slate-950">
                    <h2 class="text-lg font-semibold text-slate-950 dark:text-white">
                        À propos
                    </h2>
                    <p class="mt-4 text-sm leading-7 text-slate-600 dark:text-slate-300">
                        EvEnsa constitue le portail institutionnel dédié à la structuration, à la publication et à la
                        valorisation des activités para-universitaires de l’ENSA Khouribga.
                    </p>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-6 dark:border-slate-800 dark:bg-slate-950">
                    <h2 class="text-lg font-semibold text-slate-950 dark:text-white">
                        Gouvernance
                    </h2>
                    <p class="mt-4 text-sm leading-7 text-slate-600 dark:text-slate-300">
                        La plateforme soutient un processus clair de soumission, d’examen, de validation,
                        de publication et de suivi des événements dans un cadre institutionnel cohérent.
                    </p>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-6 dark:border-slate-800 dark:bg-slate-950">
                    <h2 class="text-lg font-semibold text-slate-950 dark:text-white">
                        Portail public
                    </h2>
                    <p class="mt-4 text-sm leading-7 text-slate-600 dark:text-slate-300">
                        Les visiteurs accèdent aux événements publiés, aux instances actives, aux annonces
                        officielles et aux ressources utiles depuis une interface claire et crédible.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- INSTANCES MISES EN AVANT --}}
    <section class="bg-white py-16 dark:bg-slate-950">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mb-10 flex items-end justify-between gap-4">
                <div>
                    <div class="text-sm font-semibold uppercase tracking-[0.18em] text-blue-700 dark:text-blue-300">
                        Instances
                    </div>
                    <h2 class="mt-2 text-3xl font-bold tracking-tight text-slate-950 dark:text-white">
                        Instances mises en avant
                    </h2>
                    <p class="mt-3 max-w-2xl text-sm leading-7 text-slate-600 dark:text-slate-300">
                        Un aperçu des principales structures actives impliquées dans l’animation de la vie
                        para-universitaire.
                    </p>
                </div>

                <a href="{{ route('instances.index') }}"
                    class="hidden sm:inline-flex items-center rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:border-blue-200 hover:text-blue-700 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100">
                    Voir toutes les instances
                </a>
            </div>

            @if ($featuredInstances->isEmpty())
                <div
                    class="rounded-2xl border border-slate-200 bg-slate-50 p-8 text-center dark:border-slate-800 dark:bg-slate-900">
                    <h3 class="text-lg font-semibold text-slate-900 dark:text-white">
                        Aucune instance active pour le moment
                    </h3>
                </div>
            @else
                <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                    @foreach ($featuredInstances as $instance)
                        <article
                            class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition hover:border-blue-200 dark:border-slate-800 dark:bg-slate-950">
                            <div
                                class="h-20 bg-gradient-to-r from-slate-100 to-blue-50 dark:from-slate-900 dark:to-slate-800">
                            </div>

                            <div class="relative px-6 pb-6">
                                <div class="-mt-8 flex items-start gap-4">
                                    <div
                                        class="flex h-16 w-16 items-center justify-center rounded-2xl border border-slate-200 bg-white text-lg font-bold text-slate-700 shadow-sm dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200">
                                        {{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($instance->name, 0, 2)) }}
                                    </div>

                                    <div>
                                        <h3 class="text-xl font-semibold tracking-tight text-slate-950 dark:text-white">
                                            {{ $instance->name }}
                                        </h3>

                                        @if (filled($instance->type ?? null))
                                            <div class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                                                {{ $instance->type }}
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                @if (filled($instance->description ?? null))
                                    <p class="mt-5 text-sm leading-7 text-slate-600 dark:text-slate-300">
                                        {{ \Illuminate\Support\Str::limit($instance->description, 140) }}
                                    </p>
                                @endif

                                <div class="mt-6">
                                    <a href="{{ route('instances.show', $instance) }}"
                                        class="inline-flex items-center text-sm font-semibold text-blue-700 transition hover:text-blue-800 dark:text-blue-300">
                                        Consulter la fiche
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    {{-- ÉVÉNEMENTS --}}
    <section class="bg-slate-50 py-16 dark:bg-slate-900">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mb-10 flex items-end justify-between gap-4">
                <div>
                    <div class="text-sm font-semibold uppercase tracking-[0.18em] text-blue-700 dark:text-blue-300">
                        Événements publiés
                    </div>
                    <h2 class="mt-2 text-3xl font-bold tracking-tight text-slate-950 dark:text-white">
                        Activités à venir
                    </h2>
                    <p class="mt-3 max-w-2xl text-sm leading-7 text-slate-600 dark:text-slate-300">
                        Une sélection des événements actuellement publiés sur le portail institutionnel.
                    </p>
                </div>

                <a href="{{ route('events.index') }}"
                    class="hidden sm:inline-flex items-center rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:border-blue-200 hover:text-blue-700 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100">
                    Voir tous les événements
                </a>
            </div>

            @if ($featuredEvents->isEmpty())
                <div
                    class="rounded-2xl border border-slate-200 bg-white p-8 text-center dark:border-slate-800 dark:bg-slate-950">
                    <h3 class="text-lg font-semibold text-slate-900 dark:text-white">
                        Aucun événement publié pour le moment
                    </h3>
                    <p class="mt-3 text-sm text-slate-600 dark:text-slate-300">
                        Les prochains événements apparaîtront ici dès leur publication.
                    </p>
                </div>
            @else
                <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                    @foreach ($featuredEvents as $event)
                        <article
                            class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition hover:border-blue-200 dark:border-slate-800 dark:bg-slate-950">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <div
                                        class="text-xs font-semibold uppercase tracking-[0.16em] text-blue-700 dark:text-blue-300">
                                        {{ $event->category?->name ?? 'Événement' }}
                                    </div>
                                    <h3 class="mt-2 text-xl font-semibold tracking-tight text-slate-950 dark:text-white">
                                        <a href="{{ route('events.show', $event) }}" class="hover:text-blue-700">
                                            {{ $event->title }}
                                        </a>
                                    </h3>
                                </div>

                                @if ($event->eventType)
                                    <span
                                        class="rounded-full bg-slate-100 px-3 py-1 text-xs font-medium text-slate-700 dark:bg-slate-800 dark:text-slate-200">
                                        {{ $event->eventType->name }}
                                    </span>
                                @endif
                            </div>

                            <div class="mt-5 space-y-3 text-sm text-slate-600 dark:text-slate-300">
                                @if ($event->instance)
                                    <div>
                                        <span class="font-semibold text-slate-800 dark:text-slate-100">Instance :</span>
                                        {{ $event->instance->name }}
                                    </div>
                                @endif

                                @if ($event->start_at)
                                    <div>
                                        <span class="font-semibold text-slate-800 dark:text-slate-100">Date :</span>
                                        {{ $event->start_at->format('d/m/Y à H:i') }}
                                    </div>
                                @endif

                                @if ($event->venue)
                                    <div>
                                        <span class="font-semibold text-slate-800 dark:text-slate-100">Lieu :</span>
                                        {{ $event->venue->name }}
                                    </div>
                                @endif
                            </div>

                            @if ($event->description)
                                <p class="mt-5 text-sm leading-7 text-slate-600 dark:text-slate-300">
                                    {{ \Illuminate\Support\Str::limit($event->description, 140) }}
                                </p>
                            @endif

                            <div class="mt-6">
                                <a href="{{ route('events.show', $event) }}"
                                    class="inline-flex items-center text-sm font-semibold text-blue-700 transition hover:text-blue-800 dark:text-blue-300">
                                    Consulter les détails
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    {{-- ANNONCES RÉCENTES --}}
    <section class="bg-white py-16 dark:bg-slate-950">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mb-10 flex items-end justify-between gap-4">
                <div>
                    <div class="text-sm font-semibold uppercase tracking-[0.18em] text-blue-700 dark:text-blue-300">
                        Communication officielle
                    </div>
                    <h2 class="mt-2 text-3xl font-bold tracking-tight text-slate-950 dark:text-white">
                        Annonces récentes
                    </h2>
                    <p class="mt-3 max-w-2xl text-sm leading-7 text-slate-600 dark:text-slate-300">
                        Les dernières informations institutionnelles publiées sur le portail EvEnsa.
                    </p>
                </div>

                <a href="{{ route('announcements.index') }}"
                    class="hidden sm:inline-flex items-center rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:border-blue-200 hover:text-blue-700 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100">
                    Voir toutes les annonces
                </a>
            </div>

            @if ($recentAnnouncements->isEmpty())
                <div
                    class="rounded-2xl border border-slate-200 bg-slate-50 p-8 text-center dark:border-slate-800 dark:bg-slate-900">
                    <h3 class="text-lg font-semibold text-slate-900 dark:text-white">
                        Aucune annonce récente
                    </h3>
                    <p class="mt-3 text-sm text-slate-600 dark:text-slate-300">
                        Les annonces officielles apparaîtront ici dès leur publication.
                    </p>
                </div>
            @else
                <div class="grid gap-6 lg:grid-cols-3">
                    @foreach ($recentAnnouncements as $announcement)
                        <article
                            class="rounded-2xl border border-slate-200 bg-slate-50 p-6 transition hover:border-blue-200 dark:border-slate-800 dark:bg-slate-900">
                            <div class="flex flex-wrap items-center gap-3">
                                <span
                                    class="rounded-full bg-blue-100 px-3 py-1 text-xs font-medium text-blue-700 dark:bg-blue-900/40 dark:text-blue-300">
                                    @php
                                        $typeLabel = match ($announcement->type) {
                                            'information' => 'Information',
                                            'submission' => 'Soumission',
                                            'decision' => 'Décision',
                                            'notice' => 'Avis',
                                            default => ucfirst($announcement->type),
                                        };
                                    @endphp
                                    {{ $typeLabel }}
                                </span>

                                @if ($announcement->published_at)
                                    <span class="text-sm text-slate-500 dark:text-slate-400">
                                        {{ $announcement->published_at->format('d/m/Y') }}
                                    </span>
                                @endif
                            </div>

                            <h3 class="mt-4 text-xl font-semibold tracking-tight text-slate-950 dark:text-white">
                                {{ $announcement->title }}
                            </h3>

                            @if ($announcement->excerpt)
                                <p class="mt-4 text-sm leading-7 text-slate-600 dark:text-slate-300">
                                    {{ $announcement->excerpt }}
                                </p>
                            @elseif ($announcement->content)
                                <p class="mt-4 text-sm leading-7 text-slate-600 dark:text-slate-300">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($announcement->content), 160) }}
                                </p>
                            @endif
                        </article>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    {{-- BLOC ORIENTATION --}}
    <section class="bg-white py-16 dark:bg-slate-950">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-6 lg:grid-cols-2">
                <div class="rounded-2xl border border-slate-200 bg-slate-50 p-8 dark:border-slate-800 dark:bg-slate-900">
                    <h2 class="text-2xl font-semibold text-slate-950 dark:text-white">
                        Vous représentez une instance organisatrice ?
                    </h2>
                    <p class="mt-4 text-sm leading-8 text-slate-600 dark:text-slate-300">
                        Le portail instance permet de préparer, soumettre et suivre les demandes d’organisation
                        dans un cadre institutionnel clair.
                    </p>

                    <div class="mt-6">
                        <a href="/portal/login"
                            class="inline-flex items-center rounded-xl bg-blue-700 px-5 py-3 text-sm font-semibold text-white transition hover:bg-blue-800">
                            Accéder au Portail Instance
                        </a>
                    </div>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-slate-50 p-8 dark:border-slate-800 dark:bg-slate-900">
                    <h2 class="text-2xl font-semibold text-slate-950 dark:text-white">
                        Administration et Commission des activités para-universitaire
                    </h2>
                    <p class="mt-4 text-sm leading-8 text-slate-600 dark:text-slate-300">
                        Le portail administrateur centralise la gestion des demandes, des événements,
                        des utilisateurs, des référentiels et du pilotage global.
                    </p>

                    <div class="mt-6">
                        <a href="/admin/login"
                            class="inline-flex items-center rounded-xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:border-blue-200 hover:text-blue-700 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100">
                            Accéder au Portail Admin
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
