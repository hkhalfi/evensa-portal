<?php

namespace App\Filament\Widgets;

use App\Enums\LeaveType;
use App\Models\HR\LeaveRequest;
use Filament\Widgets\ChartWidget;

class LeaveOverviewChart extends ChartWidget
{
    protected ?string $heading = 'Leave Requests by Type';

    protected static ?int $sort = 9;

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getData(): array
    {
        $data = collect(LeaveType::cases())->map(fn (LeaveType $type) => LeaveRequest::where('type', $type)
            ->whereYear('start_date', now()->year)
            ->count());

        return [
            'datasets' => [
                [
                    'data' => $data->values()->all(),
                    'backgroundColor' => ['#22c55e', '#ef4444', '#3b82f6', '#f59e0b', '#8b5cf6'],
                ],
            ],
            'labels' => collect(LeaveType::cases())->map(fn (LeaveType $type) => $type->getLabel())->all(),
        ];
    }
}
