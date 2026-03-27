<?php

namespace App\Filament\Widgets;

use App\Models\EvEnsa\Requests\EventRequest;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class EvEnsaRequestStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total demandes', EventRequest::count())
                ->description('Toutes les demandes enregistrées'),

            Stat::make('Brouillons', EventRequest::where('status', 'draft')->count())
                ->description('Demandes non encore soumises'),

            Stat::make('Soumises', EventRequest::where('status', 'submitted')->count())
                ->description('En attente de traitement'),

            Stat::make('En examen', EventRequest::where('status', 'under_review')->count())
                ->description('Demandes en cours d’examen'),

            Stat::make('Révision demandée', EventRequest::where('status', 'needs_revision')->count())
                ->description('Demandes à compléter'),

            Stat::make('Approuvées', EventRequest::where('status', 'approved')->count())
                ->description('Demandes validées'),

            Stat::make('Rejetées', EventRequest::where('status', 'rejected')->count())
                ->description('Demandes refusées'),
        ];
    }
}
