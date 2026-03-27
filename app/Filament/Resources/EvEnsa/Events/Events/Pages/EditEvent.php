<?php

namespace App\Filament\Resources\EvEnsa\Events\Events\Pages;

use App\Filament\Resources\EvEnsa\Events\Events\EventResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditEvent extends EditRecord
{
    protected static string $resource = EventResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
