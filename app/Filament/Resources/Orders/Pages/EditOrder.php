<?php

namespace App\Filament\Resources\Orders\Pages;

use App\Filament\Resources\Orders\OrderResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Resources\Pages\EditRecord;

class EditOrder extends EditRecord
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),

            ActionGroup::make([
                Action::make('confirm')
                    ->label('Confirm Order')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(fn () => $this->record->update(['status' => 'confirmed']))
                    ->visible(fn () => $this->record->status === 'pending'),

                Action::make('process')
                    ->label('Process Order')
                    ->icon('heroicon-o-arrow-path')
                    ->color('primary')
                    ->requiresConfirmation()
                    ->action(fn () => $this->record->update(['status' => 'processing']))
                    ->visible(fn () => $this->record->status === 'confirmed'),

                Action::make('ship')
                    ->label('Ship Order')
                    ->icon('heroicon-o-truck')
                    ->color('purple')
                    ->requiresConfirmation()
                    ->action(fn () => $this->record->update(['status' => 'shipped']))
                    ->visible(fn () => $this->record->status === 'processing'),

                Action::make('deliver')
                    ->label('Mark as Delivered')
                    ->icon('heroicon-o-check-badge')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(fn () => $this->record->update(['status' => 'delivered']))
                    ->visible(fn () => $this->record->status === 'shipped'),

                Action::make('cancel')
                    ->label('Cancel Order')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalDescription('Are you sure you want to cancel this order?')
                    ->action(fn () => $this->record->update(['status' => 'cancelled']))
                    ->visible(fn () => !in_array($this->record->status, ['delivered', 'cancelled'])),
            ]),

            DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Order updated successfully!';
    }

    public function getTitle(): string
    {
        return "Edit Order #{$this->record->order_id}";
    }
}
