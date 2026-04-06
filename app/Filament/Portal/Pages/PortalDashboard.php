<?php

namespace App\Filament\Portal\Pages;

use Filament\Pages\Page;

class PortalDashboard extends Page
{
    protected string $view = 'filament.portal.pages.portal-dashboard';

    protected static ?string $navigationLabel = 'Tableau de bord';

    protected static ?string $title = 'Portail Instance';
}
