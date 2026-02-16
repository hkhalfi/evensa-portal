<?php

namespace App\Filament\Widgets;

use App\Enums\ExpenseCategory;
use App\Models\HR\Expense;
use Filament\Widgets\ChartWidget;

class ExpensesByCategoryChart extends ChartWidget
{
    protected ?string $heading = 'Expenses by Category';

    protected static ?int $sort = 12;

    protected function getType(): string
    {
        return 'pie';
    }

    protected function getData(): array
    {
        $data = collect(ExpenseCategory::cases())->map(fn (ExpenseCategory $category) => (float) Expense::where('category', $category)->sum('total_amount'));

        return [
            'datasets' => [
                [
                    'data' => $data->values()->all(),
                    'backgroundColor' => ['#3b82f6', '#22c55e', '#f59e0b', '#8b5cf6', '#6b7280', '#94a3b8'],
                ],
            ],
            'labels' => collect(ExpenseCategory::cases())->map(fn (ExpenseCategory $category) => $category->getLabel())->all(),
        ];
    }
}
