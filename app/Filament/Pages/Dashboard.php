<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use App\Filament\Widgets\StatsOverview;
use App\Filament\Widgets\LatestOrders;
use App\Filament\Widgets\SalesChart;

class Dashboard extends BaseDashboard
{
    // protected static ?string $navigationIcon = 'heroicon-o-home';

    protected string $view = 'filament.pages.dashboard';

    protected static ?string $title = 'Dashboard BCK';

    public function getWidgets(): array
    {
        return [
            StatsOverview::class,
            SalesChart::class,
            LatestOrders::class,
        ];
    }

    public function getColumns(): array|int
    {
        return [
            'md' => 1,
            'xl' => 2,
        ];
    }
}
