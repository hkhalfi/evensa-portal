<?php

namespace App\Filament\Resources\HR\Projects\Pages;

use App\Filament\Resources\HR\Projects\ProjectResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewProject extends ViewRecord
{
    protected static string $resource = ProjectResource::class;

    protected function getActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
