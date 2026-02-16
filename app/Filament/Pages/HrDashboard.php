<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\BudgetVsSpentChart;
use App\Filament\Widgets\ExpensesByCategoryChart;
use App\Filament\Widgets\HeadcountStats;
use App\Filament\Widgets\LeaveOverviewChart;
use App\Filament\Widgets\TimesheetTrendsChart;
use BackedEnum;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Support\Icons\Heroicon;

class HrDashboard extends BaseDashboard
{
    protected static string $routePath = 'hr';

    protected static ?string $title = 'HR Dashboard';

    protected static string | BackedEnum | null $navigationIcon = Heroicon::OutlinedBriefcase;

    protected static ?int $navigationSort = 3;

    public function getWidgets(): array
    {
        return [
            HeadcountStats::class,
            LeaveOverviewChart::class,
            BudgetVsSpentChart::class,
            TimesheetTrendsChart::class,
            ExpensesByCategoryChart::class,
        ];
    }
}
