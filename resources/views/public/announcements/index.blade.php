@extends('layouts.public')

@section('content')
    <section class="border-b border-slate-200 bg-white py-16 dark:border-slate-800 dark:bg-slate-950">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl">
                <div class="text-sm font-semibold uppercase tracking-[0.18em] text-blue-700 dark:text-blue-300">
                    Annonces
                </div>

                <h1 class="mt-3 text-4xl font-bold tracking-tight text-slate-950 dark:text-white">
                    Communication officielle
                </h1>

                <p class="mt-4 text-lg leading-8 text-slate-600 dark:text-slate-300">
                    Retrouvez les annonces, avis et informations institutionnelles publiés sur le portail EvEnsa.
                </p>
            </div>
        </div>
    </section>

    <section class="bg-slate-50 py-16 dark:bg-slate-900">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            @if ($announcements->isEmpty())
                <div
                    class="rounded-2xl border border-slate-200 bg-white p-8 text-center dark:border-slate-800 dark:bg-slate-950">
                    <h2 class="text-xl font-semibold text-slate-900 dark:text-white">
                        Aucune annonce publiée
                    </h2>
                    <p class="mt-3 text-sm text-slate-600 dark:text-slate-300">
                        Les annonces officielles apparaîtront ici dès leur publication.
                    </p>
                </div>
            @else
                <div class="space-y-6">
                    @foreach ($announcements as $announcement)
                        <article
                            class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-950">
                            <div class="flex flex-wrap items-center gap-3">
                                <span
                                    class="rounded-full bg-blue-100 px-3 py-1 text-xs font-medium text-blue-700 dark:bg-blue-900/40 dark:text-blue-300">
                                    {{ ucfirst($announcement->type) }}
                                </span>

                                @if ($announcement->published_at)
                                    <span class="text-sm text-slate-500 dark:text-slate-400">
                                        {{ $announcement->published_at->format('d/m/Y') }}
                                    </span>
                                @endif
                            </div>

                            <h2 class="mt-4 text-2xl font-semibold tracking-tight text-slate-950 dark:text-white">
                                {{ $announcement->title }}
                            </h2>

                            @if ($announcement->excerpt)
                                <p class="mt-4 text-sm leading-8 text-slate-600 dark:text-slate-300">
                                    {{ $announcement->excerpt }}
                                </p>
                            @elseif ($announcement->content)
                                <p class="mt-4 text-sm leading-8 text-slate-600 dark:text-slate-300">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($announcement->content), 220) }}
                                </p>
                            @endif
                        </article>
                    @endforeach
                </div>

                <div class="mt-10">
                    {{ $announcements->links() }}
                </div>
            @endif
        </div>
    </section>
@endsection
