<x-filament::page>
    <div class="space-y-6">

        <div>
            <h1 class="text-2xl font-bold">
                Bienvenue sur votre portail
            </h1>

            <p class="text-sm text-gray-500">
                Gérez vos demandes, événements et annonces depuis cet espace.
            </p>
        </div>

        <div class="grid gap-4 md:grid-cols-3">

            <div class="rounded-xl border p-4">
                <div class="text-sm text-gray-500">Demandes</div>
                <div class="text-xl font-bold">
                    {{ \App\Models\EvEnsa\Requests\EventRequest::where('instance_id', auth()->user()->instance_id)->count() }}
                </div>
            </div>

            <div class="rounded-xl border p-4">
                <div class="text-sm text-gray-500">Événements</div>
                <div class="text-xl font-bold">
                    {{ \App\Models\EvEnsa\Events\Event::where('instance_id', auth()->user()->instance_id)->count() }}
                </div>
            </div>

            <div class="rounded-xl border p-4">
                <div class="text-sm text-gray-500">Annonces</div>
                <div class="text-xl font-bold">
                    {{ \App\Models\Announcement::where('user_id', auth()->id())->count() }}
                </div>
            </div>

        </div>

    </div>
</x-filament::page>
