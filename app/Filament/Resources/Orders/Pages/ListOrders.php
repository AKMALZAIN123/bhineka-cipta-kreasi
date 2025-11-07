<?php

namespace App\Filament\Resources\Orders\Pages;

use App\Filament\Resources\Orders\OrderResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;

class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;

    protected static bool $lazyTabs = true;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->icon('heroicon-o-plus')
                ->label('New Order'),
        ];
    }

    public function getTabs(): array
    {
        // Cache hasil hitung selama 10 detik agar tidak query berulang
        $counts = Cache::remember('order_counts', 10, function () {
            return $this->getModel()::selectRaw("
                SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending,
                SUM(CASE WHEN status = 'confirmed' THEN 1 ELSE 0 END) as confirmed,
                SUM(CASE WHEN status = 'processing' THEN 1 ELSE 0 END) as processing,
                SUM(CASE WHEN status = 'shipped' THEN 1 ELSE 0 END) as shipped,
                SUM(CASE WHEN status = 'delivered' THEN 1 ELSE 0 END) as delivered,
                SUM(CASE WHEN status = 'cancelled' THEN 1 ELSE 0 END) as cancelled,
                COUNT(*) as total
            ")->first();
        });

        return [
            'all' => Tab::make('All Orders')
                ->badge($counts->total ?? 0)
                ->icon('heroicon-o-rectangle-stack'),

            'pending' => Tab::make('Pending')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'pending'))
                ->badge($counts->pending ?? 0)
                ->badgeColor('warning')
                ->icon('heroicon-o-clock'),

            'confirmed' => Tab::make('Confirmed')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'confirmed'))
                ->badge($counts->confirmed ?? 0)
                ->badgeColor('info')
                ->icon('heroicon-o-check-circle'),

            'processing' => Tab::make('Processing')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'processing'))
                ->badge($counts->processing ?? 0)
                ->badgeColor('primary')
                ->icon('heroicon-o-arrow-path'),

            'shipped' => Tab::make('Shipped')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'shipped'))
                ->badge($counts->shipped ?? 0)
                ->badgeColor('purple')
                ->icon('heroicon-o-truck'),

            'delivered' => Tab::make('Delivered')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'delivered'))
                ->badge($counts->delivered ?? 0)
                ->badgeColor('success')
                ->icon('heroicon-o-check-badge'),

            'cancelled' => Tab::make('Cancelled')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'cancelled'))
                ->badge($counts->cancelled ?? 0)
                ->badgeColor('danger')
                ->icon('heroicon-o-x-circle'),
        ];
    }

    public function getTitle(): string
    {
        return 'Orders Management';
    }

    protected function getTableQuery(): Builder
    {
        return parent::getTableQuery()->with('user');
    }

    protected function getHeaderWidgets(): array
    {
        return [
            // Widget
        ];
    }
}
