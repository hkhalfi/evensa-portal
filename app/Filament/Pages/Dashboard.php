<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Widgets\AccountWidget;

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
            AccountWidget::class,
        ];
    }
}
