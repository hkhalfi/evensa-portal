@extends('layouts.public')

@section('content')
    {{-- HEADER --}}
    <section class="border-b border-slate-200 bg-white py-16 dark:border-slate-800 dark:bg-slate-950">
        <div class="mx-auto max-w-4xl px-4 text-center sm:px-6 lg:px-8">
            <div class="text-sm font-semibold uppercase tracking-[0.18em] text-blue-700 dark:text-blue-300">
                À propos
            </div>

            <h1 class="mt-4 text-4xl font-bold tracking-tight text-slate-950 dark:text-white">
                Commission des activités scientifiques, culturelles, sportives et sociales
            </h1>

            <p class="mt-6 text-lg leading-8 text-slate-600 dark:text-slate-300">
                Cadre institutionnel de gouvernance, de validation et de suivi des activités
                para-universitaires de l’ENSA Khouribga.
            </p>
        </div>
    </section>

    {{-- PRÉSENTATION --}}
    <section class="bg-white py-16 dark:bg-slate-950">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-8 dark:border-slate-800 dark:bg-slate-900">
                <h2 class="text-2xl font-semibold text-slate-950 dark:text-white">
                    Présentation générale
                </h2>

                <p class="mt-6 text-sm leading-8 text-slate-600 dark:text-slate-300">
                    La commission des activités scientifiques, culturelles, sportives et sociales constitue
                    l’organe institutionnel chargé de l’encadrement, de la validation et du suivi des activités
                    para-universitaires au sein de l’École Nationale des Sciences Appliquées de Khouribga.
                </p>

                <p class="mt-4 text-sm leading-8 text-slate-600 dark:text-slate-300">
                    Elle veille à assurer la cohérence des activités proposées avec les orientations pédagogiques,
                    les valeurs de l’établissement et les exigences de qualité, de sécurité et de gouvernance.
                </p>
            </div>
        </div>
    </section>

    {{-- MISSIONS --}}
    <section class="bg-slate-50 py-16 dark:bg-slate-900">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-semibold text-slate-950 dark:text-white">
                Missions
            </h2>

            <div class="mt-8 grid gap-4">
                <div class="rounded-xl border border-slate-200 bg-white p-5 dark:border-slate-800 dark:bg-slate-950">
                    Validation des demandes d’organisation d’événements
                </div>

                <div class="rounded-xl border border-slate-200 bg-white p-5 dark:border-slate-800 dark:bg-slate-950">
                    Évaluation de la pertinence scientifique, culturelle et institutionnelle des activités
                </div>

                <div class="rounded-xl border border-slate-200 bg-white p-5 dark:border-slate-800 dark:bg-slate-950">
                    Suivi du bon déroulement des événements validés
                </div>

                <div class="rounded-xl border border-slate-200 bg-white p-5 dark:border-slate-800 dark:bg-slate-950">
                    Contribution à la structuration et à la valorisation de la vie para-universitaire
                </div>
            </div>
        </div>
    </section>

    {{-- OBJECTIFS --}}
    <section class="bg-white py-16 dark:bg-slate-950">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-semibold text-slate-950 dark:text-white">
                Objectifs
            </h2>

            <ul class="mt-8 space-y-4 text-sm leading-8 text-slate-600 dark:text-slate-300">
                <li>• Promouvoir des activités de qualité alignées avec les orientations de l’établissement</li>
                <li>• Encourager l’engagement étudiant dans un cadre structuré</li>
                <li>• Assurer une gouvernance claire et transparente des activités</li>
                <li>• Renforcer la visibilité des initiatives para-universitaires</li>
                <li>• Garantir le respect des règles institutionnelles</li>
            </ul>
        </div>
    </section>

    {{-- COMPOSITION --}}
    <section class="bg-slate-50 py-16 dark:bg-slate-900">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-semibold text-slate-950 dark:text-white">
                Composition de la commission
            </h2>

            <p class="mt-4 text-sm leading-8 text-slate-600 dark:text-slate-300">
                La commission est composée de membres représentant les différentes composantes de l’établissement.
            </p>

            @if ($members->isEmpty())
                <div
                    class="mt-8 rounded-2xl border border-slate-200 bg-white p-8 text-center dark:border-slate-800 dark:bg-slate-950">
                    <h3 class="text-lg font-semibold text-slate-900 dark:text-white">
                        Composition non renseignée
                    </h3>
                    <p class="mt-3 text-sm text-slate-600 dark:text-slate-300">
                        Les membres de la commission seront affichés ici dès leur publication.
                    </p>
                </div>
            @else
                <div class="mt-10 space-y-10">
                    @foreach ($members as $category => $group)
                        <div>
                            <h3 class="text-lg font-semibold text-slate-950 dark:text-white">
                                @php
                                    $categoryLabel = match ($category) {
                                        'académique' => 'Membres académiques',
                                        'étudiant' => 'Représentation étudiante',
                                        'administratif' => 'Membres administratifs',
                                        default => ucfirst($category),
                                    };
                                @endphp

                                {{ $categoryLabel }}
                            </h3>

                            <div class="mt-4 grid gap-4 md:grid-cols-2">
                                @foreach ($group as $member)
                                    <article
                                        class="rounded-xl border border-slate-200 bg-white p-5 dark:border-slate-800 dark:bg-slate-950">
                                        <div class="flex items-start justify-between gap-4">
                                            <div>
                                                <div class="text-base font-semibold text-slate-900 dark:text-white">
                                                    {{ $member->name }}
                                                </div>

                                                <div class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                                                    {{ $member->role }}
                                                </div>
                                            </div>

                                            @if ($member->position)
                                                <span
                                                    class="rounded-full bg-blue-100 px-3 py-1 text-xs font-medium text-blue-700 dark:bg-blue-900/40 dark:text-blue-300">
                                                    {{ $member->position }}
                                                </span>
                                            @endif
                                        </div>

                                        @if ($member->email || $member->phone)
                                            <div class="mt-4 space-y-1 text-xs text-slate-500 dark:text-slate-400">
                                                @if ($member->email)
                                                    <div>{{ $member->email }}</div>
                                                @endif

                                                @if ($member->phone)
                                                    <div>{{ $member->phone }}</div>
                                                @endif
                                            </div>
                                        @endif
                                    </article>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    {{-- EVEnsa --}}
    <section class="bg-white py-16 dark:bg-slate-950">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-8 dark:border-slate-800 dark:bg-slate-900">
                <h2 class="text-2xl font-semibold text-slate-950 dark:text-white">
                    À propos de la plateforme EvEnsa
                </h2>

                <p class="mt-6 text-sm leading-8 text-slate-600 dark:text-slate-300">
                    EvEnsa est une plateforme numérique conçue pour accompagner la commission dans ses missions.
                    Elle permet de structurer les processus de soumission, d’évaluation, de publication et de suivi
                    des événements dans un environnement centralisé.
                </p>

                <p class="mt-4 text-sm leading-8 text-slate-600 dark:text-slate-300">
                    Elle constitue également un portail public permettant de valoriser les activités validées
                    et de renforcer la visibilité des initiatives de l’établissement.
                </p>
            </div>
        </div>
    </section>
@endsection
