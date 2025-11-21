<?php

namespace App\Filament\Resources\Customers\Pages;

use App\Filament\Resources\Customers\CustomerResource;
use Filament\Actions\EditAction;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Resources\Pages\ViewRecord;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Forms\Components\Textarea;

class ViewCustomer extends ViewRecord
{
    protected static string $resource = CustomerResource::class;

     protected function getHeaderActions(): array
    {
        return [
            ActionGroup::make([
                Action::make('send_email')
                    ->label('Send Email')
                    ->icon('heroicon-o-envelope')
                    ->color('info')
                    ->form([
                        TextInput::make('subject')
                            ->required()
                            ->label('Subject')
                            ->placeholder('Enter email subject'),
                        Textarea::make('message')
                            ->required()
                            ->rows(8)
                            ->label('Message')
                            ->placeholder('Type your message here...'),
                    ])
                    ->action(function (array $data) {
                        // Implement email sending
                        Notification::make()
                            ->title('Email sent successfully!')
                            ->success()
                            ->send();
                    }),

                Action::make('view_orders')
                    ->label('View All Orders')
                    ->icon('heroicon-o-shopping-cart')
                    ->color('primary')
                    ->url(fn ($record) => route('filament.admin.resources.orders.index', [
                        'tableFilters' => [
                            'user_id' => ['value' => $record->user_id],
                        ],
                    ]))
                    ->visible(fn () => $this->record->orders()->count() > 0),

                Action::make('export_data')
                    ->label('Export Customer Data')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('success')
                    ->action(function () {
                        // Implement export for single customer
                        Notification::make()
                            ->title('Customer data exported!')
                            ->success()
                            ->send();
                    }),

                Action::make('add_notes')
                    ->label('Add Notes')
                    ->icon('heroicon-o-document-text')
                    ->color('warning')
                    ->form([
                        Textarea::make('notes')
                            ->required()
                            ->rows(6)
                            ->label('Customer Notes')
                            ->placeholder('Add notes about this customer...'),
                    ])
                    ->action(function (array $data) {
                        // Implement notes saving
                        Notification::make()
                            ->title('Notes saved!')
                            ->success()
                            ->send();
                    }),

                Action::make('generate_report')
                    ->label('Generate Report')
                    ->icon('heroicon-o-document-chart-bar')
                    ->color('purple')
                    ->action(function () {
                        // Implement report generation
                        Notification::make()
                            ->title('Report generated!')
                            ->success()
                            ->send();
                    }),
            ])
            ->label('Actions')
            ->icon('heroicon-m-ellipsis-horizontal')
            ->button()
            ->color('primary'),
        ];
    }

    public function getTitle(): string
    {
        return "Customer: {$this->record->name}";
    }
}
