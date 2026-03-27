<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\EvEnsaEventStats;
use App\Filament\Widgets\EvEnsaRequestStats;
use App\Filament\Widgets\RecentEventRequests;
use App\Filament\Widgets\UpcomingEvents;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static ?int $navigationSort = -2;

    protected static ?string $navigationLabel = 'Tableau de bord';

    protected static ?string $title = 'EvEnsa';

    protected ?string $heading = 'EvEnsa';

    protected ?string $subheading = 'Portail de gestion des événements ENSA';

    public function getWidgets(): array
    {
        return [
            EvEnsaRequestStats::class,
            EvEnsaEventStats::class,
            RecentEventRequests::class,
            UpcomingEvents::class,
        ];
    }
}
