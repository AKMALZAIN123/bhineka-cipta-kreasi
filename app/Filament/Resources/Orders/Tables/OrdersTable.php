<?php

namespace App\Filament\Resources\Orders\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\BulkAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\CreateAction;
use Filament\Actions\ActionGroup;
use Filament\Actions\Action;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;

class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('order_id')
                    ->label('Order ID')
                    ->sortable()
                    ->searchable()
                    ->badge()
                    ->color('primary'),

                TextColumn::make('user.name')
                    ->label('Customer')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->icon('heroicon-o-user'),
                
                TextColumn::make('alamat')
                    ->label('Alamat')
                    ->limit(30)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= 30) {
                            return null;
                        }
                        return $state;
                    })
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('no_telp')
                    ->label('No. Telp')
                    ->searchable()
                    ->icon('heroicon-o-phone')
                    ->copyable()
                    ->toggleable(),
                
                TextColumn::make('orderItems')
                    ->label('Items')
                    ->getStateUsing(fn ($record) => $record->orderItems()->count() . ' items')
                    ->badge()
                    ->color('info'),

                TextColumn::make('total_items')
                    ->label('Qty')
                    ->getStateUsing(fn ($record) => $record->orderItems()->sum('quantity'))
                    ->badge()
                    ->color('primary'),

                TextColumn::make('order_date')
                    ->label('Order Date')
                    ->date('d M Y')
                    ->sortable()
                    ->icon('heroicon-o-calendar'),

                TextColumn::make('total_amount')
                    ->label('Total Amount')
                    ->money('IDR')
                    ->sortable()
                    ->weight('bold')
                    ->color('success'),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'confirmed' => 'info',
                        'processing' => 'primary',
                        'shipped' => 'purple',
                        'delivered' => 'success',
                        'cancelled' => 'danger',
                        default => 'gray',
                    })
                    ->icon(fn (string $state): string => match ($state) {
                        'pending' => 'heroicon-o-clock',
                        'confirmed' => 'heroicon-o-check-circle',
                        'processing' => 'heroicon-o-arrow-path',
                        'shipped' => 'heroicon-o-truck',
                        'delivered' => 'heroicon-o-check-badge',
                        'cancelled' => 'heroicon-o-x-circle',
                        default => 'heroicon-o-question-mark-circle',
                    })
                    ->formatStateUsing(fn (string $state): string => ucfirst($state))
                    ->sortable()
                    ->searchable(),

                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Updated')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Pending',
                        'confirmed' => 'Confirmed',
                        'processing' => 'Processing',
                        'shipped' => 'Shipped',
                        'delivered' => 'Delivered',
                        'cancelled' => 'Cancelled',
                    ])
                    ->multiple()
                    ->placeholder('All statuses'),

                Filter::make('order_date')
                    ->form([
                       DatePicker::make('from')
                            ->label('From Date')
                            ->placeholder('Select start date'),
                       DatePicker::make('until')
                            ->label('Until Date')
                            ->placeholder('Select end date'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('order_date', '>=', $date),
                            )
                            ->when(
                                $data['until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('order_date', '<=', $date),
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];
                        if ($data['from'] ?? null) {
                            $indicators[] = Indicator::make('From: ' . \Carbon\Carbon::parse($data['from'])->format('d M Y'))
                                ->removeField('from');
                        }
                        if ($data['until'] ?? null) {
                            $indicators[] = Indicator::make('Until: ' . \Carbon\Carbon::parse($data['until'])->format('d M Y'))
                                ->removeField('until');
                        }
                        return $indicators;
                    }),

                Filter::make('total_amount')
                    ->form([
                       TextInput::make('amount_from')
                            ->numeric()
                            ->prefix('Rp')
                            ->placeholder('Min amount'),
                       TextInput::make('amount_to')
                            ->numeric()
                            ->prefix('Rp')
                            ->placeholder('Max amount'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['amount_from'],
                                fn (Builder $query, $amount): Builder => $query->where('total_amount', '>=', $amount),
                            )
                            ->when(
                                $data['amount_to'],
                                fn (Builder $query, $amount): Builder => $query->where('total_amount', '<=', $amount),
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];
                        if ($data['amount_from'] ?? null) {
                            $indicators[] = Indicator::make('Amount from Rp ' . number_format($data['amount_from']))
                                ->removeField('amount_from');
                        }
                        if ($data['amount_to'] ?? null) {
                            $indicators[] = Indicator::make('Amount to Rp ' . number_format($data['amount_to']))
                                ->removeField('amount_to');
                        }
                        return $indicators;
                    }),
            ])
            ->recordActions([
                ViewAction::make(),
                
                ActionGroup::make([
                    Action::make('confirm')
                        ->label('Confirm Order')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(fn ($record) => $record->update(['status' => 'confirmed']))
                        ->visible(fn ($record) => $record->status === 'pending'),

                    Action::make('process')
                        ->label('Process Order')
                        ->icon('heroicon-o-arrow-path')
                        ->color('primary')
                        ->requiresConfirmation()
                        ->action(fn ($record) => $record->update(['status' => 'processing']))
                        ->visible(fn ($record) => $record->status === 'confirmed'),

                    Action::make('ship')
                        ->label('Ship Order')
                        ->icon('heroicon-o-truck')
                        ->color('purple')
                        ->requiresConfirmation()
                        ->action(fn ($record) => $record->update(['status' => 'shipped']))
                        ->visible(fn ($record) => $record->status === 'processing'),

                    Action::make('deliver')
                        ->label('Mark as Delivered')
                        ->icon('heroicon-o-check-badge')
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(fn ($record) => $record->update(['status' => 'delivered']))
                        ->visible(fn ($record) => $record->status === 'shipped'),

                    Action::make('cancel')
                        ->label('Cancel Order')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->modalDescription('Are you sure you want to cancel this order? This action cannot be undone.')
                        ->action(fn ($record) => $record->update(['status' => 'cancelled']))
                        ->visible(fn ($record) => !in_array($record->status, ['delivered', 'cancelled'])),
                ])
                ->icon('heroicon-m-ellipsis-horizontal')
                ->button()
                ->label('Actions'),

                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    BulkAction::make('confirm')
                        ->label('Confirm Selected')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(fn ($records) => $records->each->update(['status' => 'confirmed'])),

                    BulkAction::make('cancel')
                        ->label('Cancel Selected')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->action(fn ($records) => $records->each->update(['status' => 'cancelled'])),

                    DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                CreateAction::make()
                    ->icon('heroicon-o-plus'),
            ])
            ->defaultSort('created_at', 'desc')
            ->striped()
            ->poll('30s');
    }
}
