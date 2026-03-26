<?php

namespace App\Filament\Resources\EvEnsa\Requests\EventRequests\Pages;

use App\Filament\Resources\EvEnsa\Requests\EventRequests\EventRequestResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListEventRequests extends ListRecords
{
    protected static string $resource = EventRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('Toutes')
                ->badge($this->getModel()::count()),

            'draft' => Tab::make('Brouillons')
                ->icon('heroicon-o-pencil-square')
                ->badge($this->getModel()::where('status', 'draft')->count())
                ->badgeColor('gray')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'draft')),

            'submitted' => Tab::make('Soumises')
                ->icon('heroicon-o-paper-airplane')
                ->badge($this->getModel()::where('status', 'submitted')->count())
                ->badgeColor('info')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'submitted')),

            'under_review' => Tab::make('En examen')
                ->icon('heroicon-o-eye')
                ->badge($this->getModel()::where('status', 'under_review')->count())
                ->badgeColor('warning')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'under_review')),

            'needs_revision' => Tab::make('Révision')
                ->icon('heroicon-o-arrow-path')
                ->badge($this->getModel()::where('status', 'needs_revision')->count())
                ->badgeColor('warning')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'needs_revision')),

            'approved' => Tab::make('Approuvées')
                ->icon('heroicon-o-check-circle')
                ->badge($this->getModel()::where('status', 'approved')->count())
                ->badgeColor('success')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'approved')),

            'rejected' => Tab::make('Rejetées')
                ->icon('heroicon-o-x-circle')
                ->badge($this->getModel()::where('status', 'rejected')->count())
                ->badgeColor('danger')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'rejected')),
        ];
    }
}
