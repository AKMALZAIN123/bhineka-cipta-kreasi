<?php

namespace App\Filament\Resources\Orders\Pages;

use App\Filament\Resources\Orders\OrderResource;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Resources\Pages\ViewRecord;

class ViewOrder extends ViewRecord
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),

            ActionGroup::make([
                Action::make('confirm')
                    ->label('Confirm Order')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(function () {
                        $this->record->update(['status' => 'confirmed']);
                        $this->refreshFormData(['status']);
                    })
                    ->visible(fn () => $this->record->status === 'pending'),

                Action::make('process')
                    ->label('Process Order')
                    ->icon('heroicon-o-arrow-path')
                    ->color('primary')
                    ->requiresConfirmation()
                    ->action(function () {
                        $this->record->update(['status' => 'processing']);
                        $this->refreshFormData(['status']);
                    })
                    ->visible(fn () => $this->record->status === 'confirmed'),

                Action::make('ship')
                    ->label('Ship Order')
                    ->icon('heroicon-o-truck')
                    ->color('purple')
                    ->requiresConfirmation()
                    ->action(function () {
                        $this->record->update(['status' => 'shipped']);
                        $this->refreshFormData(['status']);
                    })
                    ->visible(fn () => $this->record->status === 'processing'),

                Action::make('deliver')
                    ->label('Mark as Delivered')
                    ->icon('heroicon-o-check-badge')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(function () {
                        $this->record->update(['status' => 'delivered']);
                        $this->refreshFormData(['status']);
                    })
                    ->visible(fn () => $this->record->status === 'shipped'),

                Action::make('cancel')
                    ->label('Cancel Order')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalDescription('Are you sure you want to cancel this order? This action cannot be undone.')
                    ->action(function () {
                        $this->record->update(['status' => 'cancelled']);
                        $this->refreshFormData(['status']);
                    })
                    ->visible(fn () => !in_array($this->record->status, ['delivered', 'cancelled'])),
            ]),

            DeleteAction::make()
                ->requiresConfirmation(),
        ];
    }

    public function getTitle(): string
    {
        return "Order #{$this->record->order_id}";
    }

    protected function getFooterWidgets(): array
    {
        return [
            // Untuk Widget
        ];
    }
}
