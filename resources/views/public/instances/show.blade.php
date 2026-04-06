@extends('layouts.public')

@section('content')
    <section class="border-b border-slate-200 bg-white dark:border-slate-800 dark:bg-slate-950">
        <div class="mx-auto max-w-6xl px-4 py-16 sm:px-6 lg:px-8">
            <div
                class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-950">
                <div class="h-36 bg-gradient-to-r from-slate-100 to-blue-50 dark:from-slate-900 dark:to-slate-800"></div>

                <div class="relative px-8 pb-8">
                    <div class="-mt-10 flex flex-col gap-6 md:flex-row md:items-end md:justify-between">
                        <div class="flex items-center gap-5">
                            <div
                                class="flex h-20 w-20 items-center justify-center rounded-3xl border border-slate-200 bg-white text-2xl font-bold text-slate-700 shadow-sm dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200">
                                {{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($instance->name, 0, 2)) }}
                            </div>

                            <div>
                                <div
                                    class="text-sm font-semibold uppercase tracking-[0.18em] text-blue-700 dark:text-blue-300">
                                    Instance organisatrice
                                </div>

                                <h1 class="mt-2 text-3xl font-bold tracking-tight text-slate-950 dark:text-white">
                                    {{ $instance->name }}
                                </h1>

                                @if (filled($instance->type ?? null))
                                    <div class="mt-2 text-sm text-slate-500 dark:text-slate-400">
                                        {{ $instance->type }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div>
                            <a href="{{ route('instances.index') }}"
                                class="inline-flex items-center rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:border-blue-200 hover:text-blue-700 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100">
                                Retour aux instances
                            </a>
                        </div>
                    </div>

                    <div class="mt-8 grid gap-6 lg:grid-cols-[1.3fr_0.7fr]">
                        <div
                            class="rounded-2xl border border-slate-200 bg-slate-50 p-6 dark:border-slate-800 dark:bg-slate-900">
                            <h2 class="text-xl font-semibold text-slate-950 dark:text-white">
                                Présentation
                            </h2>

                            @if (filled($instance->description ?? null))
                                <p class="mt-4 text-sm leading-8 text-slate-600 dark:text-slate-300">
                                    {{ $instance->description }}
                                </p>
                            @else
                                <p class="mt-4 text-sm leading-8 text-slate-600 dark:text-slate-300">
                                    Cette instance contribue à l’organisation et à la valorisation des activités
                                    para-universitaires de l’ENSA Khouribga.
                                </p>
                            @endif
                        </div>

                        <div class="space-y-4">
                            <div
                                class="rounded-2xl border border-slate-200 bg-white p-5 dark:border-slate-800 dark:bg-slate-950">
                                <div
                                    class="text-sm font-semibold uppercase tracking-[0.14em] text-slate-500 dark:text-slate-400">
                                    Statut
                                </div>
                                <div class="mt-2 text-sm font-medium text-emerald-700 dark:text-emerald-300">
                                    Active
                                </div>
                            </div>

                            @if (filled($instance->email ?? null))
                                <div
                                    class="rounded-2xl border border-slate-200 bg-white p-5 dark:border-slate-800 dark:bg-slate-950">
                                    <div
                                        class="text-sm font-semibold uppercase tracking-[0.14em] text-slate-500 dark:text-slate-400">
                                        Email
                                    </div>
                                    <div class="mt-2 text-sm text-slate-700 dark:text-slate-200">
                                        {{ $instance->email }}
                                    </div>
                                </div>
                            @endif

                            @if (filled($instance->phone ?? null))
                                <div
                                    class="rounded-2xl border border-slate-200 bg-white p-5 dark:border-slate-800 dark:bg-slate-950">
                                    <div
                                        class="text-sm font-semibold uppercase tracking-[0.14em] text-slate-500 dark:text-slate-400">
                                        Téléphone
                                    </div>
                                    <div class="mt-2 text-sm text-slate-700 dark:text-slate-200">
                                        {{ $instance->phone }}
                                    </div>
                                </div>
                            @endif

                            @if (filled($instance->website ?? null))
                                <div
                                    class="rounded-2xl border border-slate-200 bg-white p-5 dark:border-slate-800 dark:bg-slate-950">
                                    <div
                                        class="text-sm font-semibold uppercase tracking-[0.14em] text-slate-500 dark:text-slate-400">
                                        Site web
                                    </div>
                                    <div class="mt-2 text-sm">
                                        <a href="{{ $instance->website }}" target="_blank" rel="noopener noreferrer"
                                            class="font-medium text-blue-700 hover:text-blue-800 dark:text-blue-300">
                                            {{ $instance->website }}
                                        </a>
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
