<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\CustomersChart;
use App\Filament\Widgets\LatestOrders;
use App\Filament\Widgets\OrderDistributionByStatusChart;
use App\Filament\Widgets\OrdersChart;
use App\Filament\Widgets\PriceQuantityChart;
use App\Filament\Widgets\RevenueShareByChannelChart;
use App\Filament\Widgets\SalesByCategoryChart;
use App\Filament\Widgets\StatsOverviewWidget;
use BackedEnum;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class ShopDashboard extends BaseDashboard
{
    use BaseDashboard\Concerns\HasFiltersForm;

    protected static string $routePath = 'shop';

    protected static ?string $title = 'Shop Dashboard';

    protected static string | BackedEnum | null $navigationIcon = Heroicon::OutlinedShoppingCart;

    protected static ?int $navigationSort = 2;

    public function filtersForm(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        Select::make('businessCustomersOnly')
                            ->boolean(),
                        DatePicker::make('startDate')
                            ->maxDate(fn (Get $get) => $get('endDate') ?: now()),
                        DatePicker::make('endDate')
                            ->minDate(fn (Get $get) => $get('startDate') ?: now())
                            ->maxDate(now()),
                    ])
                    ->columns(3)
                    ->columnSpanFull(),
            ]);
    }

    public function getWidgets(): array
    {
        return [
            StatsOverviewWidget::class,
            OrdersChart::class,
            CustomersChart::class,
            LatestOrders::class,
            SalesByCategoryChart::class,
            RevenueShareByChannelChart::class,
            OrderDistributionByStatusChart::class,
            PriceQuantityChart::class,
        ];
    }
}
