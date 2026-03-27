<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $event->title }} - EvEnsa</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 text-slate-900">
    <main class="max-w-4xl mx-auto px-6 py-10">
        <div class="mb-6">
            <a href="{{ route('public.events.index') }}" class="text-sm text-blue-600 hover:underline">
                ← Retour aux événements
            </a>
        </div>

        <article class="bg-white rounded-2xl shadow-sm border overflow-hidden">
            @if ($event->cover_image)
                <img src="{{ asset('storage/' . $event->cover_image) }}" alt="{{ $event->title }}"
                    class="w-full h-72 object-cover">
            @endif

            <div class="p-8">
                <div class="flex flex-wrap gap-2 mb-4">
                    <span class="text-xs px-2 py-1 rounded-full bg-blue-100 text-blue-700">
                        {{ $event->eventType?->name }}
                    </span>
                    <span class="text-xs px-2 py-1 rounded-full bg-slate-100 text-slate-700">
                        {{ $event->category?->name }}
                    </span>
                </div>

                <h1 class="text-3xl font-bold mb-3">{{ $event->title }}</h1>

                <div class="space-y-2 text-sm text-slate-700 mb-6">
                    <p><strong>Organisateur :</strong> {{ $event->instance?->name }}</p>
                    <p><strong>Mode :</strong>
                        @switch($event->event_mode)
                            @case('internal')
                                Interne
                            @break

                            @case('external')
                                Externe
                            @break

                            @case('online')
                                En ligne
                            @break

                            @case('hybrid')
                                Hybride
                            @break

                            @default
                                {{ $event->event_mode }}
                        @endswitch
                    </p>
                    <p><strong>Début :</strong> {{ $event->start_at?->format('d/m/Y H:i') }}</p>
                    <p><strong>Fin :</strong> {{ $event->end_at?->format('d/m/Y H:i') }}</p>
                    @if ($event->venue?->name)
                        <p><strong>Lieu :</strong> {{ $event->venue->name }}</p>
                    @endif
                    @if ($event->expected_attendees)
                        <p><strong>Participants attendus :</strong> {{ $event->expected_attendees }}</p>
                    @endif
                </div>

                @if ($event->description)
                    <section>
                        <h2 class="text-lg font-semibold mb-3">Description</h2>
                        <div class="prose max-w-none text-slate-700">
                            {!! nl2br(e($event->description)) !!}
                        </div>
                    </section>
                @endif
            </div>
        </article>
    </main>
</body>

</html>
