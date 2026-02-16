<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class PriceQuantityChart extends ChartWidget
{
    protected ?string $heading = 'Price vs. quantity';

    protected static ?int $sort = 7;

    protected function getType(): string
    {
        return 'scatter';
    }

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Product samples',
                    'showLine' => false,
                    'data' => [
                        ['x' => 5, 'y' => 20],
                        ['x' => 5, 'y' => 40],
                        ['x' => 10, 'y' => 30],
                        ['x' => 15, 'y' => 50],
                        ['x' => 15, 'y' => 20],
                        ['x' => 20, 'y' => 60],
                        ['x' => 20, 'y' => 40],
                        ['x' => 25, 'y' => 80],
                        ['x' => 30, 'y' => 50],
                        ['x' => 30, 'y' => 70],
                        ['x' => 35, 'y' => 60],
                        ['x' => 40, 'y' => 90],
                        ['x' => 45, 'y' => 70],
                        ['x' => 50, 'y' => 100],
                    ],
                ],
            ],
        ];
    }
}
