@extends('layouts.public')

@section('content')
    <section class="border-b border-slate-200 bg-white py-16 dark:border-slate-800 dark:bg-slate-950">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl">
                <div class="text-sm font-semibold uppercase tracking-[0.18em] text-blue-700 dark:text-blue-300">
                    Instances
                </div>

                <h1 class="mt-3 text-4xl font-bold tracking-tight text-slate-950 dark:text-white">
                    Instances organisatrices
                </h1>

                <p class="mt-4 text-lg leading-8 text-slate-600 dark:text-slate-300">
                    Découvrez les structures actives impliquées dans l’organisation des activités
                    scientifiques, culturelles, sportives et sociales de l’ENSA Khouribga.
                </p>
            </div>
        </div>
    </section>

    <section class="bg-slate-50 py-16 dark:bg-slate-900">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            @if ($instances->isEmpty())
                <div
                    class="rounded-2xl border border-slate-200 bg-white p-8 text-center dark:border-slate-800 dark:bg-slate-950">
                    <h2 class="text-xl font-semibold text-slate-900 dark:text-white">
                        Aucune instance disponible
                    </h2>
                    <p class="mt-3 text-sm text-slate-600 dark:text-slate-300">
                        Les instances actives apparaîtront ici dès leur publication.
                    </p>
                </div>
            @else
                <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                    @foreach ($instances as $instance)
                        <article
                            class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition hover:border-blue-200 hover:shadow-md dark:border-slate-800 dark:bg-slate-950">
                            <div
                                class="h-24 bg-gradient-to-r from-slate-100 to-blue-50 dark:from-slate-900 dark:to-slate-800">
                            </div>

                            <div class="relative px-6 pb-6">
                                <div class="-mt-8 flex items-start justify-between gap-4">
                                    <div class="flex items-center gap-4">
                                        <div
                                            class="flex h-16 w-16 items-center justify-center rounded-2xl border border-slate-200 bg-white text-lg font-bold text-slate-700 shadow-sm dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200">
                                            {{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($instance->name, 0, 2)) }}
                                        </div>

                                        <div>
                                            <h2 class="text-xl font-semibold tracking-tight text-slate-950 dark:text-white">
                                                {{ $instance->name }}
                                            </h2>

                                            @if (filled($instance->type ?? null))
                                                <div class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                                                    {{ $instance->type }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <span
                                        class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-medium text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300">
                                        Active
                                    </span>
                                </div>

                                @if (filled($instance->description ?? null))
                                    <p class="mt-5 text-sm leading-7 text-slate-600 dark:text-slate-300">
                                        {{ \Illuminate\Support\Str::limit($instance->description, 170) }}
                                    </p>
                                @else
                                    <p class="mt-5 text-sm leading-7 text-slate-600 dark:text-slate-300">
                                        Cette instance participe à l’animation et à la structuration de la vie
                                        para-universitaire de l’ENSA Khouribga.
                                    </p>
                                @endif

                                <div class="mt-6 flex items-center justify-between">
                                    <div class="text-sm text-slate-500 dark:text-slate-400">
                                        ENSA Khouribga
                                    </div>

                                    <a href="{{ route('instances.show', $instance) }}"
                                        class="inline-flex items-center text-sm font-semibold text-blue-700 transition hover:text-blue-800 dark:text-blue-300">
                                        Voir la fiche
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
@endsection
