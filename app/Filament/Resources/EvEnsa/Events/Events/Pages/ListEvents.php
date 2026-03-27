<?php

namespace App\Filament\Resources\EvEnsa\Events\Events\Pages;

use App\Filament\Resources\EvEnsa\Events\Events\EventResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListEvents extends ListRecords
{
    protected static string $resource = EventResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('Tous')
                ->badge($this->getModel()::count()),

            'draft' => Tab::make('Brouillons')
                ->badge($this->getModel()::where('status', 'draft')->count())
                ->badgeColor('gray')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'draft')),

            'scheduled' => Tab::make('Planifiés')
                ->badge($this->getModel()::where('status', 'scheduled')->count())
                ->badgeColor('info')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'scheduled')),

            'published' => Tab::make('Publiés')
                ->badge($this->getModel()::where('status', 'published')->count())
                ->badgeColor('success')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'published')),

            'completed' => Tab::make('Terminés')
                ->badge($this->getModel()::where('status', 'completed')->count())
                ->badgeColor('warning')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'completed')),

            'archived' => Tab::make('Archivés')
                ->badge($this->getModel()::where('status', 'archived')->count())
                ->badgeColor('gray')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'archived')),
        ];
    }
}
