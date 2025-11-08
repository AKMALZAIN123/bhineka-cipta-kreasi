<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $totalOrders = Order::count();
        $totalRevenue = Order::where('status', '!=', 'cancelled')->sum('total_amount');
        $totalCustomers = User::count();
        $activeProducts = Product::count();

        // Calculate growth percentages (comparing with previous month)
        $ordersLastMonth = Order::whereMonth('created_at', now()->subMonth()->month)->count();
        $ordersGrowth = $ordersLastMonth > 0 
            ? round((($totalOrders - $ordersLastMonth) / $ordersLastMonth) * 100, 1)
            : 0;

        $revenueLastMonth = Order::whereMonth('created_at', now()->subMonth()->month)
            ->where('status', '!=', 'cancelled')
            ->sum('total_amount');
        $revenueGrowth = $revenueLastMonth > 0
            ? round((($totalRevenue - $revenueLastMonth) / $revenueLastMonth) * 100, 1)
            : 0;

        return [
            Stat::make('Total Pesanan', number_format($totalOrders))
                ->description($ordersGrowth >= 0 ? "+{$ordersGrowth}% dari bulan lalu" : "{$ordersGrowth}% dari bulan lalu")
                ->descriptionIcon($ordersGrowth >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($ordersGrowth >= 0 ? 'success' : 'danger')
                ->icon('heroicon-o-shopping-cart')
                ->chart([7, 3, 4, 5, 6, 3, 5, 3]),

            Stat::make('Total Pendapatan', 'Rp ' . number_format($totalRevenue, 0, ',', '.'))
                ->description($revenueGrowth >= 0 ? "+{$revenueGrowth}% dari bulan lalu" : "{$revenueGrowth}% dari bulan lalu")
                ->descriptionIcon($revenueGrowth >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($revenueGrowth >= 0 ? 'success' : 'danger')
                ->icon('heroicon-o-banknotes')
                ->chart([3, 5, 7, 9, 6, 8, 10, 8]),

            Stat::make('Total Pelanggan', number_format($totalCustomers))
                ->description('Pelanggan terdaftar')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('info')
                ->icon('heroicon-o-users')
                ->chart([2, 3, 4, 3, 5, 4, 6, 5]),

            Stat::make('Produk Aktif', number_format($activeProducts))
                ->description('Produk tersedia')
                ->descriptionIcon('heroicon-m-cube')
                ->color('warning')
                ->icon('heroicon-o-cube')
                ->chart([5, 4, 5, 6, 5, 7, 6, 7]),
        ];
    }

    protected ?string $pollingInterval = '30s';
}
