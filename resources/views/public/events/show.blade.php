@extends('layouts.public')

@section('content')
    @php
        $eventModeLabel = match ($event->event_mode) {
            'internal' => 'Interne',
            'external' => 'Externe',
            'online' => 'En ligne',
            'hybrid' => 'Hybride',
            default => filled($event->event_mode) ? ucfirst($event->event_mode) : 'Non renseigné',
        };

        $countdownTarget = $event->start_at?->isFuture() ? $event->start_at->toIso8601String() : null;
    @endphp

    <section class="bg-slate-50 py-10 dark:bg-slate-900">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mb-6">
                <a href="{{ route('events.index') }}"
                    class="inline-flex items-center gap-2 text-sm font-semibold text-slate-600 transition hover:text-blue-700 dark:text-slate-300 dark:hover:text-blue-300">
                    <span aria-hidden="true">←</span>
                    <span>Retour aux événements</span>
                </a>
            </div>

            <div class="grid gap-8 lg:grid-cols-[360px_minmax(0,1fr)]">
                {{-- COLONNE GAUCHE --}}
                <aside class="space-y-6">
                    <div
                        class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-950">
                        <div
                            class="aspect-[4/4.2] bg-gradient-to-br from-slate-100 via-blue-50 to-slate-200 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900">
                            @if (!empty($event->cover_image))
                                <img src="{{ asset('storage/' . $event->cover_image) }}" alt="{{ $event->title }}"
                                    class="h-full w-full object-cover">
                            @else
                                <div class="flex h-full w-full items-center justify-center p-8">
                                    <div class="text-center">
                                        <div
                                            class="mx-auto flex h-20 w-20 items-center justify-center rounded-3xl border border-slate-200 bg-white text-2xl font-bold text-slate-700 shadow-sm dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200">
                                            {{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($event->title, 0, 2)) }}
                                        </div>

                                        <div
                                            class="mt-6 text-sm font-semibold uppercase tracking-[0.18em] text-blue-700 dark:text-blue-300">
                                            Événement
                                        </div>

                                        <div class="mt-2 text-xl font-bold text-slate-900 dark:text-white">
                                            {{ \Illuminate\Support\Str::limit($event->title, 28) }}
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div
                        class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-950">
                        <h2 class="text-sm font-semibold uppercase tracking-[0.16em] text-slate-500 dark:text-slate-400">
                            Instance organisatrice
                        </h2>

                        <div class="mt-4 flex items-start gap-4">
                            <div
                                class="flex h-14 w-14 items-center justify-center rounded-2xl border border-slate-200 bg-slate-50 text-base font-bold text-slate-700 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200">
                                {{ $event->instance ? \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($event->instance->name, 0, 2)) : 'EV' }}
                            </div>

                            <div>
                                <div class="text-base font-semibold text-slate-900 dark:text-white">
                                    {{ $event->instance?->name ?? 'Instance non renseignée' }}
                                </div>

                                @if (filled($event->instance?->type ?? null))
                                    <div class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                                        {{ $event->instance->type }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        @if ($event->instance)
                            <div class="mt-5">
                                <a href="{{ route('instances.show', $event->instance) }}"
                                    class="inline-flex items-center text-sm font-semibold text-blue-700 transition hover:text-blue-800 dark:text-blue-300">
                                    Consulter la fiche de l’instance
                                </a>
                            </div>
                        @endif
                    </div>

                    <div
                        class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-950">
                        <h2 class="text-sm font-semibold uppercase tracking-[0.16em] text-slate-500 dark:text-slate-400">
                            Repères
                        </h2>

                        <div class="mt-4 space-y-4">
                            @if ($event->eventType)
                                <div>
                                    <div
                                        class="text-xs font-semibold uppercase tracking-[0.14em] text-slate-500 dark:text-slate-400">
                                        Type
                                    </div>
                                    <div class="mt-1 text-sm font-medium text-slate-900 dark:text-white">
                                        {{ $event->eventType->name }}
                                    </div>
                                </div>
                            @endif

                            @if ($event->category)
                                <div>
                                    <div
                                        class="text-xs font-semibold uppercase tracking-[0.14em] text-slate-500 dark:text-slate-400">
                                        Catégorie
                                    </div>
                                    <div class="mt-1 text-sm font-medium text-slate-900 dark:text-white">
                                        {{ $event->category->name }}
                                    </div>
                                </div>
                            @endif

                            <div>
                                <div
                                    class="text-xs font-semibold uppercase tracking-[0.14em] text-slate-500 dark:text-slate-400">
                                    Mode
                                </div>
                                <div class="mt-1 text-sm font-medium text-slate-900 dark:text-white">
                                    {{ $eventModeLabel }}
                                </div>
                            </div>
                        </div>
                    </div>
                </aside>

                {{-- COLONNE DROITE --}}
                <div class="space-y-8">
                    <div
                        class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm dark:border-slate-800 dark:bg-slate-950">
                        <div class="flex flex-wrap items-center gap-3">
                            @if ($event->category)
                                <span
                                    class="rounded-full bg-blue-100 px-3 py-1 text-xs font-medium text-blue-700 dark:bg-blue-900/40 dark:text-blue-300">
                                    {{ $event->category->name }}
                                </span>
                            @endif

                            @if ($event->eventType)
                                <span
                                    class="rounded-full bg-slate-100 px-3 py-1 text-xs font-medium text-slate-700 dark:bg-slate-800 dark:text-slate-200">
                                    {{ $event->eventType->name }}
                                </span>
                            @endif

                            <span
                                class="rounded-full bg-slate-100 px-3 py-1 text-xs font-medium text-slate-700 dark:bg-slate-800 dark:text-slate-200">
                                {{ $eventModeLabel }}
                            </span>
                        </div>

                        <h1 class="mt-5 text-4xl font-bold tracking-tight text-slate-950 dark:text-white">
                            {{ $event->title }}
                        </h1>

                        <div class="mt-8 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
                            <div
                                class="rounded-2xl border border-slate-200 bg-slate-50 p-4 dark:border-slate-800 dark:bg-slate-900">
                                <div
                                    class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500 dark:text-slate-400">
                                    Date de début
                                </div>
                                <div class="mt-2 text-base font-semibold text-slate-900 dark:text-white">
                                    {{ $event->start_at?->format('d/m/Y') ?? '—' }}
                                </div>
                            </div>

                            <div
                                class="rounded-2xl border border-slate-200 bg-slate-50 p-4 dark:border-slate-800 dark:bg-slate-900">
                                <div
                                    class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500 dark:text-slate-400">
                                    Heure
                                </div>
                                <div class="mt-2 text-base font-semibold text-slate-900 dark:text-white">
                                    {{ $event->start_at?->format('H:i') ?? '—' }}
                                </div>
                            </div>

                            <div
                                class="rounded-2xl border border-slate-200 bg-slate-50 p-4 dark:border-slate-800 dark:bg-slate-900">
                                <div
                                    class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500 dark:text-slate-400">
                                    Date de fin
                                </div>
                                <div class="mt-2 text-base font-semibold text-slate-900 dark:text-white">
                                    {{ $event->end_at?->format('d/m/Y') ?? '—' }}
                                </div>
                            </div>

                            <div
                                class="rounded-2xl border border-slate-200 bg-slate-50 p-4 dark:border-slate-800 dark:bg-slate-900">
                                <div
                                    class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500 dark:text-slate-400">
                                    Participants attendus
                                </div>
                                <div class="mt-2 text-base font-semibold text-slate-900 dark:text-white">
                                    {{ $event->expected_attendees ?? '—' }}
                                </div>
                            </div>
                        </div>

                        @if ($countdownTarget)
                            <div class="mt-6 rounded-2xl border border-blue-100 bg-blue-50 p-5 dark:border-slate-700 dark:bg-slate-900"
                                x-data="{
                                    target: new Date(@js($countdownTarget)).getTime(),
                                    days: '00',
                                    hours: '00',
                                    minutes: '00',
                                    seconds: '00',
                                    expired: false,
                                    init() {
                                        this.updateCountdown();
                                        this.interval = setInterval(() => this.updateCountdown(), 1000);
                                    },
                                    updateCountdown() {
                                        const now = new Date().getTime();
                                        const distance = this.target - now;
                                
                                        if (distance <= 0) {
                                            this.expired = true;
                                            this.days = '00';
                                            this.hours = '00';
                                            this.minutes = '00';
                                            this.seconds = '00';
                                            clearInterval(this.interval);
                                            return;
                                        }
                                
                                        const day = 1000 * 60 * 60 * 24;
                                        const hour = 1000 * 60 * 60;
                                        const minute = 1000 * 60;
                                
                                        this.days = String(Math.floor(distance / day)).padStart(2, '0');
                                        this.hours = String(Math.floor((distance % day) / hour)).padStart(2, '0');
                                        this.minutes = String(Math.floor((distance % hour) / minute)).padStart(2, '0');
                                        this.seconds = String(Math.floor((distance % minute) / 1000)).padStart(2, '0');
                                    }
                                }">
                                <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                                    <div>
                                        <div
                                            class="text-sm font-semibold uppercase tracking-[0.16em] text-blue-700 dark:text-blue-300">
                                            Début dans
                                        </div>
                                        <div class="mt-2 text-sm text-slate-600 dark:text-slate-300">
                                            Compte à rebours avant le lancement de l’événement.
                                        </div>
                                    </div>

                                    <div class="flex flex-nowrap gap-3 overflow-x-auto sm:overflow-visible">
                                        <div
                                            class="min-w-[72px] flex-1 rounded-xl border border-slate-200 bg-white px-3 py-3 text-center dark:border-slate-700 dark:bg-slate-950">
                                            <div class="text-xl font-bold text-slate-900 sm:text-2xl dark:text-white"
                                                x-text="days"></div>
                                            <div
                                                class="mt-1 text-[10px] font-semibold uppercase tracking-[0.14em] text-slate-500 sm:text-[11px] dark:text-slate-400">
                                                Jours
                                            </div>
                                        </div>

                                        <div
                                            class="min-w-[72px] flex-1 rounded-xl border border-slate-200 bg-white px-3 py-3 text-center dark:border-slate-700 dark:bg-slate-950">
                                            <div class="text-xl font-bold text-slate-900 sm:text-2xl dark:text-white"
                                                x-text="hours"></div>
                                            <div
                                                class="mt-1 text-[10px] font-semibold uppercase tracking-[0.14em] text-slate-500 sm:text-[11px] dark:text-slate-400">
                                                Heures
                                            </div>
                                        </div>

                                        <div
                                            class="min-w-[72px] flex-1 rounded-xl border border-slate-200 bg-white px-3 py-3 text-center dark:border-slate-700 dark:bg-slate-950">
                                            <div class="text-xl font-bold text-slate-900 sm:text-2xl dark:text-white"
                                                x-text="minutes"></div>
                                            <div
                                                class="mt-1 text-[10px] font-semibold uppercase tracking-[0.14em] text-slate-500 sm:text-[11px] dark:text-slate-400">
                                                Minutes
                                            </div>
                                        </div>

                                        <div
                                            class="min-w-[72px] flex-1 rounded-xl border border-slate-200 bg-white px-3 py-3 text-center dark:border-slate-700 dark:bg-slate-950">
                                            <div class="text-xl font-bold text-slate-900 sm:text-2xl dark:text-white"
                                                x-text="seconds"></div>
                                            <div
                                                class="mt-1 text-[10px] font-semibold uppercase tracking-[0.14em] text-slate-500 sm:text-[11px] dark:text-slate-400">
                                                Secondes
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div
                            class="mt-6 rounded-2xl border border-slate-200 bg-slate-50 p-5 dark:border-slate-800 dark:bg-slate-900">
                            <div class="grid gap-4 md:grid-cols-2">
                                <div>
                                    <div
                                        class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500 dark:text-slate-400">
                                        Lieu
                                    </div>
                                    <div class="mt-2 text-sm font-medium text-slate-900 dark:text-white">
                                        {{ $event->venue?->name ?? 'À préciser' }}
                                    </div>
                                </div>

                                <div>
                                    <div
                                        class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500 dark:text-slate-400">
                                        Instance
                                    </div>
                                    <div class="mt-2 text-sm font-medium text-slate-900 dark:text-white">
                                        {{ $event->instance?->name ?? 'Non renseignée' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div
                        class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm dark:border-slate-800 dark:bg-slate-950">
                        <h2 class="text-2xl font-semibold text-slate-950 dark:text-white">
                            Présentation de l’événement
                        </h2>

                        <div class="mt-6 space-y-5 text-sm leading-8 text-slate-600 dark:text-slate-300">
                            @if (filled($event->description))
                                <p>{{ $event->description }}</p>
                            @else
                                <p>
                                    Aucune description détaillée n’a encore été publiée pour cet événement.
                                </p>
                            @endif
                        </div>
                    </div>

                    <div
                        class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm dark:border-slate-800 dark:bg-slate-950">
                        <h2 class="text-2xl font-semibold text-slate-950 dark:text-white">
                            Informations complémentaires
                        </h2>

                        <div class="mt-6 grid gap-4 md:grid-cols-2">
                            <div
                                class="rounded-2xl border border-slate-200 bg-slate-50 p-5 dark:border-slate-800 dark:bg-slate-900">
                                <div
                                    class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500 dark:text-slate-400">
                                    Instance organisatrice
                                </div>
                                <div class="mt-2 text-sm font-medium text-slate-900 dark:text-white">
                                    {{ $event->instance?->name ?? 'Non renseignée' }}
                                </div>
                            </div>

                            <div
                                class="rounded-2xl border border-slate-200 bg-slate-50 p-5 dark:border-slate-800 dark:bg-slate-900">
                                <div
                                    class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500 dark:text-slate-400">
                                    Type d’événement
                                </div>
                                <div class="mt-2 text-sm font-medium text-slate-900 dark:text-white">
                                    {{ $event->eventType?->name ?? 'Non renseigné' }}
                                </div>
                            </div>

                            <div
                                class="rounded-2xl border border-slate-200 bg-slate-50 p-5 dark:border-slate-800 dark:bg-slate-900">
                                <div
                                    class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500 dark:text-slate-400">
                                    Catégorie
                                </div>
                                <div class="mt-2 text-sm font-medium text-slate-900 dark:text-white">
                                    {{ $event->category?->name ?? 'Non renseignée' }}
                                </div>
                            </div>

                            <div
                                class="rounded-2xl border border-slate-200 bg-slate-50 p-5 dark:border-slate-800 dark:bg-slate-900">
                                <div
                                    class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500 dark:text-slate-400">
                                    Mode
                                </div>
                                <div class="mt-2 text-sm font-medium text-slate-900 dark:text-white">
                                    {{ $eventModeLabel }}
                                </div>
                            </div>

                            @if ($event->start_at && $event->end_at)
                                <div
                                    class="rounded-2xl border border-slate-200 bg-slate-50 p-5 md:col-span-2 dark:border-slate-800 dark:bg-slate-900">
                                    <div
                                        class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500 dark:text-slate-400">
                                        Période
                                    </div>
                                    <div class="mt-2 text-sm font-medium text-slate-900 dark:text-white">
                                        Du {{ $event->start_at->format('d/m/Y à H:i') }} au
                                        {{ $event->end_at->format('d/m/Y à H:i') }}
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
