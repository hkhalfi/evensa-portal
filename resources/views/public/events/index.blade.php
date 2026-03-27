<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Événements publiés - EvEnsa</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 text-slate-900">
    <main class="max-w-6xl mx-auto px-6 py-10">
        <header class="mb-8">
            <h1 class="text-3xl font-bold">Événements publiés</h1>
            <p class="text-sm text-slate-600 mt-2">
                Liste des événements validés et publiés sur EvEnsa.
            </p>
        </header>

        @if ($events->isEmpty())
            <div class="bg-white rounded-xl shadow-sm border p-6">
                <p class="text-slate-600">Aucun événement publié pour le moment.</p>
            </div>
        @else
            <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                @foreach ($events as $event)
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

                            <h2 class="text-xl font-semibold mb-2">
                                <a href="{{ route('public.events.show', $event) }}" class="hover:underline">
                                    {{ $event->title }}
                                </a>
                            </h2>

                            <p class="text-sm text-slate-600 mb-2">
                                {{ $event->instance?->name }}
                            </p>

                            <p class="text-sm text-slate-700 mb-3">
                                {{ $event->start_at?->format('d/m/Y H:i') }}
                                @if ($event->end_at)
                                    — {{ $event->end_at->format('d/m/Y H:i') }}
                                @endif
                            </p>

                            @if ($event->venue?->name)
                                <p class="text-sm text-slate-600 mb-3">
                                    Lieu : {{ $event->venue->name }}
                                </p>
                            @endif

                            @if ($event->description)
                                <p class="text-sm text-slate-700 line-clamp-4 mb-4">
                                    {{ $event->description }}
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
    </main>
</body>

</html>
