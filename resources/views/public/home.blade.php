<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EvEnsa - Portail des événements</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 text-slate-900">
    <main>
        <section class="bg-white border-b">
            <div class="max-w-6xl mx-auto px-6 py-16">
                <div class="max-w-3xl">
                    <p class="text-sm font-medium text-blue-600 mb-3">EvEnsa</p>
                    <h1 class="text-4xl font-bold tracking-tight mb-4">
                        Portail de gestion et de valorisation des événements de l’ENSA
                    </h1>
                    <p class="text-lg text-slate-600 mb-8">
                        Découvrez les événements validés et publiés : conférences, workshops,
                        compétitions, formations et activités de la vie de l’école.
                    </p>

                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('public.events.index') }}"
                            class="inline-flex items-center rounded-xl bg-blue-600 px-5 py-3 text-white font-medium hover:bg-blue-700">
                            Voir tous les événements
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <section class="max-w-6xl mx-auto px-6 py-12">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-2xl font-semibold">Prochains événements</h2>
                    <p class="text-sm text-slate-600 mt-1">
                        Les événements à venir déjà publiés sur la plateforme.
                    </p>
                </div>

                <a href="{{ route('public.events.index') }}" class="text-sm font-medium text-blue-600 hover:underline">
                    Voir tout
                </a>
            </div>

            @if ($upcomingEvents->isEmpty())
                <div class="bg-white rounded-2xl border shadow-sm p-6">
                    <p class="text-slate-600">Aucun événement publié à venir pour le moment.</p>
                </div>
            @else
                <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                    @foreach ($upcomingEvents as $event)
                        <article class="bg-white rounded-2xl shadow-sm border overflow-hidden">
                            @if ($event->cover_image)
                                <img src="{{ asset('storage/' . $event->cover_image) }}" alt="{{ $event->title }}"
                                    class="w-full h-48 object-cover">
                            @endif

                            <div class="p-5">
                                <div class="flex flex-wrap gap-2 mb-3">
                                    <span class="text-xs px-2 py-1 rounded-full bg-blue-100 text-blue-700">
                                        {{ $event->eventType?->name }}
                                    </span>
                                    <span class="text-xs px-2 py-1 rounded-full bg-slate-100 text-slate-700">
                                        {{ $event->category?->name }}
                                    </span>
                                </div>

                                <h3 class="text-xl font-semibold mb-2">
                                    <a href="{{ route('public.events.show', $event) }}" class="hover:underline">
                                        {{ $event->title }}
                                    </a>
                                </h3>

                                <p class="text-sm text-slate-600 mb-2">
                                    {{ $event->instance?->name }}
                                </p>

                                <p class="text-sm text-slate-700 mb-3">
                                    {{ $event->start_at?->format('d/m/Y H:i') }}
                                </p>

                                @if ($event->venue?->name)
                                    <p class="text-sm text-slate-600 mb-3">
                                        Lieu : {{ $event->venue->name }}
                                    </p>
                                @endif

                                <a href="{{ route('public.events.show', $event) }}"
                                    class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-800">
                                    Voir le détail
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>
            @endif
        </section>
    </main>
</body>

</html>
