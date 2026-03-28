<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use App\Models\User;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Validation\ValidationException;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (($data['role'] ?? null) !== 'instance_manager') {
            $data['instance_id'] = null;

            return $data;
        }

        $exists = User::query()
            ->where('id', '!=', $this->record->id)
            ->where('instance_id', $data['instance_id'])
            ->whereHas('roles', fn ($query) => $query->where('name', 'instance_manager'))
            ->exists();

        if ($exists) {
            throw ValidationException::withMessages([
                'instance_id' => 'Cette instance possède déjà un compte instance_manager.',
            ]);
        }

        return $data;
    }

    protected function afterSave(): void
    {
        $role = $this->data['role'] ?? null;

        if ($role) {
            $this->record->syncRoles([$role]);
        }
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
