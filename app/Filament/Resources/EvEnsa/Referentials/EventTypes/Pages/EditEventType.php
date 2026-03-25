<?php

namespace App\Filament\Resources\EvEnsa\Referentials\EventTypes\Pages;

use App\Filament\Resources\EvEnsa\Referentials\EventTypes\EventTypeResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditEventType extends EditRecord
{
    protected static string $resource = EventTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
