<?php

namespace App\Filament\Widgets;

use App\Models\EvEnsa\Events\Event;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class EvEnsaEventStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total événements', Event::count())
                ->description('Tous les événements enregistrés'),

            Stat::make('Événements publiés', Event::where('is_published', true)->count())
                ->description('Visibles sur le portail public'),

            Stat::make('Événements à venir', Event::where('start_at', '>=', now())->count())
                ->description('Événements à venir'),

            Stat::make('Événements terminés', Event::where('status', 'completed')->count())
                ->description('Événements marqués comme terminés'),

            Stat::make('Événements archivés', Event::where('status', 'archived')->count())
                ->description('Historique archivé'),
        ];
    }
}
