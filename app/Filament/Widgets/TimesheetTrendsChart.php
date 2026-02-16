<?php

namespace App\Filament\Widgets;

use App\Models\HR\Timesheet;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class TimesheetTrendsChart extends ChartWidget
{
    protected ?string $heading = 'Hours per Week (Last 12 Weeks)';

    protected static ?int $sort = 11;

    protected function getType(): string
    {
        return 'line';
    }

    protected function getData(): array
    {
        $weeks = collect(range(11, 0))->map(function ($weeksAgo) {
            $start = Carbon::now()->subWeeks($weeksAgo)->startOfWeek();
            $end = Carbon::now()->subWeeks($weeksAgo)->endOfWeek();

            return [
                'label' => $start->format('M d'),
                'hours' => (float) Timesheet::whereBetween('date', [$start, $end])->sum('hours'),
            ];
        });

        return [
            'datasets' => [
                [
                    'label' => 'Hours',
                    'data' => $weeks->pluck('hours')->all(),
                    'fill' => 'start',
                    'borderColor' => '#8b5cf6',
                    'backgroundColor' => 'rgba(139, 92, 246, 0.1)',
                ],
            ],
            'labels' => $weeks->pluck('label')->all(),
        ];
    }
}
