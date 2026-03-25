<?php

namespace App\Filament\Resources\EvEnsa\Referentials\Venues\Pages;

use App\Filament\Resources\EvEnsa\Referentials\Venues\VenueResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditVenue extends EditRecord
{
    protected static string $resource = VenueResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
