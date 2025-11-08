<?php

namespace App\Filament\Resources\Customers\Pages;

use App\Filament\Resources\Customers\CustomerResource;
use Filament\Actions\CreateAction;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;
use Filament\Notifications\Notification;
use App\Filament\Resources\Customers\Widgets\CustomerStatsOverview;


class ListCustomers extends ListRecords
{
    protected static string $resource = CustomerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('export_all')
                ->label('Export All')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('success')
                ->action(function () {
                    Notification::make()
                        ->title('Export started!')
                        ->success()
                        ->send();
                }),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All Customers')
                ->badge(fn () => $this->getModel()::count()),

            'verified' => Tab::make('Verified')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereNotNull('email_verified_at'))
                ->badge(fn () => $this->getModel()::whereNotNull('email_verified_at')->count())
                ->badgeColor('success'),

            'unverified' => Tab::make('Not Verified')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereNull('email_verified_at'))
                ->badge(fn () => $this->getModel()::whereNull('email_verified_at')->count())
                ->badgeColor('warning'),

            'active' => Tab::make('Active Buyers')
                ->modifyQueryUsing(fn (Builder $query) => $query->has('orders'))
                ->badge(fn () => $this->getModel()::has('orders')->count())
                ->badgeColor('primary'),

            'inactive' => Tab::make('No Orders')
                ->modifyQueryUsing(fn (Builder $query) => $query->doesntHave('orders'))
                ->badge(fn () => $this->getModel()::doesntHave('orders')->count())
                ->badgeColor('gray'),

            'high_value' => Tab::make('High Value')
                ->modifyQueryUsing(function (Builder $query) {
                    return $query->whereHas('orders', function ($q) {
                        $q->selectRaw('user_id, SUM(total_amount) as total')
                          ->where('status', '!=', 'cancelled')
                          ->groupBy('user_id')
                          ->havingRaw('SUM(total_amount) >= ?', [1000000]); // > 1 juta
                    });
                })
                ->badge(function () {
                    return $this->getModel()::whereHas('orders', function ($q) {
                        $q->selectRaw('user_id, SUM(total_amount) as total')
                          ->where('status', '!=', 'cancelled')
                          ->groupBy('user_id')
                          ->havingRaw('SUM(total_amount) >= ?', [1000000]);
                    })->count();
                })
                ->badgeColor('success'),

            'new' => Tab::make('New This Month')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereMonth('created_at', now()->month))
                ->badge(fn () => $this->getModel()::whereMonth('created_at', now()->month)->count())
                ->badgeColor('info'),
        ];
    }

    public function getTitle(): string
    {
        return 'Customer Relationship Management';
    }

    protected function getHeaderWidgets(): array
    {
        return [
            CustomerStatsOverview::class,
        ];
    }
}
