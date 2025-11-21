<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\Columns;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Support\Enums\FontWeight;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Support\Enums\TextSize;

class OrderInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Grid::make(2)
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

                                            TextEntry::make('no_telp')
                                                ->label('No. Telepon')
                                                ->icon('heroicon-o-phone')
                                                ->copyable()
                                                ->copyMessage('Phone copied!')
                                                ->color('info'),
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
                            ]),

                        Group::make([
                            Section::make('Shipping Information')
                                ->schema([
                                    TextEntry::make('alamat')
                                        ->label('Alamat Pengiriman')
                                        ->icon('heroicon-o-map-pin')
                                        ->columnSpanFull(),
                                ]),

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
                                ->collapsible(true),
                        ]),
                    ])
                    ->columnSpanFull(),

                Section::make('Order Items')
                    ->schema([
                        RepeatableEntry::make('orderItems')
                            ->schema([
                                Grid::make(6)->schema([

                                    TextEntry::make('product.name')
                                        ->label('Product')
                                        ->weight('bold'),

                                    TextEntry::make('product.category')
                                        ->label('Category')
                                        ->badge()
                                        ->color('info'),

                                    TextEntry::make('product.size')
                                        ->label('Size'),

                                    TextEntry::make('quantity')
                                        ->label('Qty')
                                        ->badge()
                                        ->color('primary'),

                                    TextEntry::make('product.price')
                                        ->label('Unit Price')
                                        ->money('IDR'),

                                    TextEntry::make('sub_total')
                                        ->label('Subtotal')
                                        ->money('IDR')
                                        ->color('success')
                                        ->weight('bold'),

                                ]),
                            ])
                            ->columnSpanFull()
                            ->contained(false),
                    ])
                    ->columnSpanFull(),
            ]);

    }
}
