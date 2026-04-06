@extends('layouts.public')

@section('content')
    <section class="border-b border-slate-200 bg-white py-16 dark:border-slate-800 dark:bg-slate-950">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl">
                <div class="text-sm font-semibold uppercase tracking-[0.18em] text-blue-700 dark:text-blue-300">
                    Événements
                </div>
                <h1 class="mt-3 text-4xl font-bold tracking-tight text-slate-950 dark:text-white">
                    Événements publiés
                </h1>
                <p class="mt-4 text-lg text-slate-600 dark:text-slate-300">
                    Retrouvez l’ensemble des événements actuellement publiés sur le portail institutionnel EvEnsa.
                </p>
            </div>
        </div>
    </section>

    <section class="bg-slate-50 py-16 dark:bg-slate-900">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            @if ($events->isEmpty())
                <div
                    class="rounded-2xl border border-slate-200 bg-white p-8 text-center dark:border-slate-800 dark:bg-slate-950">
                    <h2 class="text-xl font-semibold text-slate-900 dark:text-white">
                        Aucun événement publié pour le moment
                    </h2>
                    <p class="mt-3 text-sm text-slate-600 dark:text-slate-300">
                        Les événements apparaîtront ici dès leur publication.
                    </p>
                </div>
            @else
                <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                    @foreach ($events as $event)
                        <article
                            class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-950">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <div
                                        class="text-xs font-semibold uppercase tracking-[0.16em] text-blue-700 dark:text-blue-300">
                                        {{ $event->category?->name ?? 'Événement' }}
                                    </div>
                                    <h2 class="mt-2 text-xl font-semibold text-slate-950 dark:text-white">
                                        <a href="{{ route('events.show', $event) }}" class="hover:text-blue-700">
                                            {{ $event->title }}
                                        </a>
                                    </h2>
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
                                    <div><span class="font-semibold text-slate-800 dark:text-slate-100">Instance :</span>
                                        {{ $event->instance->name }}</div>
                                @endif

                                @if ($event->start_at)
                                    <div><span class="font-semibold text-slate-800 dark:text-slate-100">Date :</span>
                                        {{ $event->start_at->format('d/m/Y à H:i') }}</div>
                                @endif

                                @if ($event->venue)
                                    <div><span class="font-semibold text-slate-800 dark:text-slate-100">Lieu :</span>
                                        {{ $event->venue->name }}</div>
                                @endif
                            </div>

                            @if ($event->description)
                                <p class="mt-5 text-sm leading-7 text-slate-600 dark:text-slate-300">
                                    {{ \Illuminate\Support\Str::limit($event->description, 150) }}
                                </p>
                            @endif

                            <div class="mt-6">
                                <a href="{{ route('events.show', $event) }}"
                                    class="inline-flex items-center text-sm font-semibold text-blue-700 hover:text-blue-800 dark:text-blue-300">
                                    Consulter les détails
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>

                <div class="mt-10">
                    {{ $events->links() }}
                </div>
            @endif
        </div>
    </section>
@endsection
