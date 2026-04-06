<x-filament::page>
    <form wire:submit="save" class="space-y-6">
        {{ $this->form }}

        <div class="flex justify-end">
            <x-filament::button type="submit">
                Enregistrer les modifications
            </x-filament::button>
        </div>
    </form>
</x-filament::page>
