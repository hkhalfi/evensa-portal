<?php

namespace App\Filament\Widgets;

use App\Enums\ProjectStatus;
use App\Models\HR\Project;
use Filament\Widgets\ChartWidget;

class BudgetVsSpentChart extends ChartWidget
{
    protected ?string $heading = 'Budget vs Spent (Active Projects)';

    protected static ?int $sort = 10;

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getData(): array
    {
        $projects = Project::where('status', ProjectStatus::Active)
            ->orderBy('name')
            ->limit(10)
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Budget',
                    'data' => $projects->pluck('budget')->map(fn ($v) => (float) $v)->all(),
                    'backgroundColor' => '#3b82f6',
                ],
                [
                    'label' => 'Spent',
                    'data' => $projects->pluck('spent')->map(fn ($v) => (float) $v)->all(),
                    'backgroundColor' => '#f59e0b',
                ],
            ],
            'labels' => $projects->pluck('name')->map(fn ($name) => strlen($name) > 20 ? substr($name, 0, 20) . '...' : $name)->all(),
        ];
    }
}
