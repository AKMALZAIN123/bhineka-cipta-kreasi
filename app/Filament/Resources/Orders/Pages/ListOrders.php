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
        ];
    }

    public function getTabs(): array
    {
        // Cache hasil hitung selama 10 detik agar tidak query berulang
        $counts = Cache::remember('order_counts', 10, function () {
            return $this->getModel()::selectRaw("
                SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending,
                SUM(CASE WHEN status = 'paid' THEN 1 ELSE 0 END) as paid,
                SUM(CASE WHEN status = 'confirmed' THEN 1 ELSE 0 END) as confirmed,
                SUM(CASE WHEN status = 'packing' THEN 1 ELSE 0 END) as packing,
                SUM(CASE WHEN status = 'onroad' THEN 1 ELSE 0 END) as onroad,
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

            'paid' => Tab::make('Paid')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'paid'))
                ->badge($counts->paid ?? 0)
                ->badgeColor('info')
                ->icon('heroicon-o-credit-card'),

            'confirmed' => Tab::make('Confirmed')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'confirmed'))
                ->badge($counts->confirmed ?? 0)
                ->badgeColor('info')
                ->icon('heroicon-o-check-circle'),

            'packing' => Tab::make('Packing')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'packing'))
                ->badge($counts->packing ?? 0)
                ->badgeColor('primary')
                ->icon('heroicon-o-archive-box-arrow-down'),

            'onroad' => Tab::make('On Road')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'onroad'))
                ->badge($counts->onroad ?? 0)
                ->badgeColor('purple')
                ->icon('heroicon-o-truck'),

            'confirmed' => Tab::make('Confirmed')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'confirmed'))
                ->badge($counts->confirmed ?? 0)
                ->badgeColor('info')
                ->icon('heroicon-o-check-circle'),

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
