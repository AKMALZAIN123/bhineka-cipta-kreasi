<?php

namespace App\Filament\Resources\Customers\Widgets;

use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CustomerStatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $totalCustomers = User::count();
        $verifiedCustomers = User::whereNotNull('email_verified_at')->count();
        $activeCustomers = User::has('orders')->count();
        $newThisMonth = User::whereMonth('created_at', now()->month)->count();

        $lastMonth = User::whereMonth('created_at', now()->subMonth()->month)->count();
        $growth = $lastMonth > 0 
            ? round((($newThisMonth - $lastMonth) / $lastMonth) * 100, 1)
            : 0;

        return [
            Stat::make('Total Customers', number_format($totalCustomers))
                ->description('All registered customers')
                ->descriptionIcon('heroicon-o-users')
                ->color('primary')
                ->chart([3, 5, 4, 6, 5, 7, 6]),

            Stat::make('Verified Customers', number_format($verifiedCustomers))
                ->description(round(($verifiedCustomers / max($totalCustomers, 1)) * 100, 1) . '% of total')
                ->descriptionIcon('heroicon-o-check-badge')
                ->color('success')
                ->chart([4, 5, 6, 5, 7, 6, 8]),

            Stat::make('Active Buyers', number_format($activeCustomers))
                ->description(round(($activeCustomers / max($totalCustomers, 1)) * 100, 1) . '% have orders')
                ->descriptionIcon('heroicon-o-shopping-cart')
                ->color('info')
                ->chart([2, 4, 3, 5, 4, 6, 5]),

            Stat::make('New This Month', number_format($newThisMonth))
                ->description($growth >= 0 ? "+{$growth}% from last month" : "{$growth}% from last month")
                ->descriptionIcon($growth >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($growth >= 0 ? 'success' : 'danger')
                ->chart([1, 2, 3, 2, 4, 3, 5]),
        ];
    }
}
