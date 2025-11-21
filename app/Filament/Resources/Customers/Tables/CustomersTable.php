<?php
namespace App\Filament\Resources\Customers\Tables;

use Filament\Tables;
use App\Models\Order;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\BulkAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\CreateAction;
use Filament\Actions\ActionGroup;
use Filament\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Filters\Indicator;

class CustomersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user_id')
                    ->label('ID')
                    ->sortable()
                    ->searchable()
                    ->badge()
                    ->color('primary'),

                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->icon('heroicon-o-user'),

                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-o-envelope')
                    ->copyable()
                    ->copyMessage('Email copied!'),

                TextColumn::make('email_verified_at')
                    ->label('Status Email')
                    ->badge()
                    ->formatStateUsing(fn ($state) => $state ? 'Verified' : 'Not Verified')
                    ->color(fn ($state) => $state ? 'success' : 'warning')
                    ->icon(fn ($state) => $state ? 'heroicon-o-check-circle' : 'heroicon-o-x-circle')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('orders_count')
                    ->label('Total Pesanan')
                    ->getStateUsing(fn ($record) => Order::where('user_id', $record->user_id)->count())
                    ->badge()
                    ->color('info')
                    ->sortable(),

                TextColumn::make('total_spent')
                    ->label('Total Belanja')
                    ->getStateUsing(fn ($record) => 
                        Order::where('user_id', $record->user_id)
                            ->where('status', '!=', 'cancelled')
                            ->sum('total_amount')
                    )
                    ->money('IDR')
                    ->sortable()
                    ->weight('bold')
                    ->color('success'),

                TextColumn::make('created_at')
                    ->label('Bergabung')
                    ->date('d M Y')
                    ->sortable()
                    ->icon('heroicon-o-calendar'),

                TextColumn::make('updated_at')
                    ->label('Update Terakhir')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Filter::make('verified')
                    ->label('Email Verified')
                    ->query(fn (Builder $query): Builder => $query->whereNotNull('email_verified_at'))
                    ->toggle(),

                Filter::make('unverified')
                    ->label('Email Not Verified')
                    ->query(fn (Builder $query): Builder => $query->whereNull('email_verified_at'))
                    ->toggle(),

                Filter::make('has_orders')
                    ->label('Has Orders')
                    ->query(fn (Builder $query): Builder => $query->has('orders'))
                    ->toggle(),

                Filter::make('no_orders')
                    ->label('No Orders Yet')
                    ->query(fn (Builder $query): Builder => $query->doesntHave('orders'))
                    ->toggle(),

                Filter::make('joined_date')
                    ->form([
                        DatePicker::make('from')
                            ->label('From Date'),
                        DatePicker::make('until')
                            ->label('Until Date'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];
                        if ($data['from'] ?? null) {
                            $indicators[] = Indicator::make('Joined from: ' . \Carbon\Carbon::parse($data['from'])->format('d M Y'))
                                ->removeField('from');
                        }
                        if ($data['until'] ?? null) {
                            $indicators[] = Indicator::make('Joined until: ' . \Carbon\Carbon::parse($data['until'])->format('d M Y'))
                                ->removeField('until');
                        }
                        return $indicators;
                    }),

                Filter::make('total_spent')
                    ->form([
                        TextInput::make('min_spent')
                            ->numeric()
                            ->prefix('Rp')
                            ->placeholder('Min amount'),
                        TextInput::make('max_spent')
                            ->numeric()
                            ->prefix('Rp')
                            ->placeholder('Max amount'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['min_spent'],
                                fn (Builder $query, $amount): Builder => 
                                    $query->whereHas('orders', function ($q) use ($amount) {
                                        $q->where('status', '!=', 'cancelled')
                                          ->havingRaw('SUM(total_amount) >= ?', [$amount]);
                                    })
                            )
                            ->when(
                                $data['max_spent'],
                                fn (Builder $query, $amount): Builder => 
                                    $query->whereHas('orders', function ($q) use ($amount) {
                                        $q->where('status', '!=', 'cancelled')
                                          ->havingRaw('SUM(total_amount) <= ?', [$amount]);
                                    })
                            );
                    }),
            ])
            ->actions([
                ViewAction::make()
                    ->label('View Details'),

                ActionGroup::make([
                    Action::make('view_orders')
                        ->label('View Orders')
                        ->icon('heroicon-o-shopping-cart')
                        ->color('primary')
                        ->url(fn ($record) => route('filament.admin.resources.orders.index', [
                            'tableFilters' => [
                                'user_id' => ['value' => $record->user_id],
                            ],
                        ]))
                        ->visible(fn ($record) => $record->orders()->count() > 0),

                    Action::make('send_email')
                        ->label('Send Email')
                        ->icon('heroicon-o-envelope')
                        ->color('info')
                        ->form([
                            TextInput::make('subject')
                                ->required()
                                ->label('Subject'),
                            Textarea::make('message')
                                ->required()
                                ->rows(5)
                                ->label('Message'),
                        ])
                        ->action(function ($record, array $data) {
                            // Implement email sending logic here
                            Notification::make()
                                ->title('Email sent successfully!')
                                ->success()
                                ->send();
                        }),

                    Action::make('customer_notes')
                        ->label('Add Notes')
                        ->icon('heroicon-o-document-text')
                        ->color('warning')
                        ->form([
                            Textarea::make('notes')
                                ->required()
                                ->rows(4)
                                ->label('Customer Notes'),
                        ])
                        ->action(function ($record, array $data) {
                            // Implement notes saving logic here
                            Notification::make()
                                ->title('Notes saved!')
                                ->success()
                                ->send();
                        }),
                ])
                ->icon('heroicon-m-ellipsis-horizontal')
                ->button()
                ->label('Actions'),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    BulkAction::make('export')
                        ->label('Export Selected')
                        ->icon('heroicon-o-arrow-down-tray')
                        ->color('success')
                        ->action(function ($records) {
                            // Implement export logic
                            Notification::make()
                                ->title('Export successful!')
                                ->success()
                                ->send();
                        }),

                    BulkAction::make('send_bulk_email')
                        ->label('Send Bulk Email')
                        ->icon('heroicon-o-envelope')
                        ->color('info')
                        ->requiresConfirmation()
                        ->form([
                            TextInput::make('subject')
                                ->required()
                                ->label('Subject'),
                            Textarea::make('message')
                                ->required()
                                ->rows(5)
                                ->label('Message'),
                        ])
                        ->action(function ($records, array $data) {
                            // Implement bulk email logic
                            Notification::make()
                                ->title('Bulk email sent to ' . $records->count() . ' customers!')
                                ->success()
                                ->send();
                        }),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->striped()
            ->poll('60s');
    }
}