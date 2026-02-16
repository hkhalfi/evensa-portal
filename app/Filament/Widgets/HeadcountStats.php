<?php

namespace App\Filament\Widgets;

use App\Enums\EmploymentType;
use App\Models\HR\Employee;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class HeadcountStats extends BaseWidget
{
    protected static ?int $sort = 8;

    protected function getStats(): array
    {
        return [
            Stat::make('Total Headcount', Employee::count())
                ->description('All employees')
                ->descriptionIcon(Heroicon::Users)
                ->color('primary'),
            Stat::make('Active Employees', Employee::where('is_active', true)->count())
                ->description('Currently active')
                ->descriptionIcon(Heroicon::CheckCircle)
                ->color('success'),
            Stat::make('Avg Salary', '$' . number_format((float) Employee::whereNotNull('salary')->avg('salary'), 0))
                ->description('Full-time & part-time')
                ->descriptionIcon(Heroicon::CurrencyDollar)
                ->color('info'),
            Stat::make('Contractors', Employee::where('employment_type', EmploymentType::Contractor)->count())
                ->description('Active contractors')
                ->descriptionIcon(Heroicon::Briefcase)
                ->color('warning'),
        ];
    }
}
