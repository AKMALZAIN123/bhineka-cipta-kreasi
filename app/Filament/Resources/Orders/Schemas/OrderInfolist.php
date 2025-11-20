<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Support\Enums\FontWeight;
use Filament\Infolists\Components\TextEntry;
use Filament\Support\Enums\TextSize;

class OrderInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Order Details')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Group::make([
                                    TextEntry::make('order_id')
                                        ->label('Order ID')
                                        ->badge()
                                        ->color('primary')
                                        ->weight(FontWeight::Bold),

                                    TextEntry::make('user.name')
                                        ->label('Customer Name')
                                        ->icon('heroicon-o-user')
                                        ->weight(FontWeight::SemiBold),

                                    TextEntry::make('user.email')
                                        ->label('Customer Email')
                                        ->icon('heroicon-o-envelope')
                                        ->copyable()
                                        ->copyMessage('Email copied!')
                                        ->color('gray'),
                                ]),

                                Group::make([
                                    TextEntry::make('order_date')
                                        ->label('Order Date')
                                        ->date('d F Y')
                                        ->icon('heroicon-o-calendar'),

                                    TextEntry::make('total_amount')
                                        ->label('Total Amount')
                                        ->money('IDR')
                                        ->weight(FontWeight::Bold)
                                        ->size(TextSize::Large)
                                        ->color('success'),

                                    TextEntry::make('status')
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
                                        ->formatStateUsing(fn (string $state): string => ucfirst($state)),
                                ]),
                            ]),
                    ])
                    ->columns(1),

                Section::make('Timeline')
                    ->schema([
                        TextEntry::make('created_at')
                            ->label('Created At')
                            ->dateTime('d F Y, H:i')
                            ->icon('heroicon-o-plus-circle'),

                        TextEntry::make('updated_at')
                            ->label('Last Updated')
                            ->dateTime('d F Y, H:i')
                            ->icon('heroicon-o-arrow-path')
                            ->color('warning'),
                    ])
                    ->columns(2)
                    ->collapsible(),
            ]);
    }
}
