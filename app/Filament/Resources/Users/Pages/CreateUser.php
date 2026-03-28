<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Si ce n'est pas un instance_manager → on enlève l'instance
        if (($data['role'] ?? null) !== 'instance_manager') {
            $data['instance_id'] = null;
        }

        return $data;
    }

    protected function afterCreate(): void
    {
        $role = $this->data['role'] ?? null;

        if ($role) {
            $this->record->syncRoles([$role]);
        }
    }
}
