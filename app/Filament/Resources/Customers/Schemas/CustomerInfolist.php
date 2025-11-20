<?php

namespace App\Filament\Resources\Customers\Schemas;

use Filament\Infolists;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Infolists\Components\TextEntry;
use Filament\Support\Enums\TextSize;

class CustomerInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Informasi Pelanggan')
                    ->schema([
                        Grid::make(2)
                                ->schema([
                                    Group::make([
                                        TextEntry::make('user_id')
                                            ->label('Customer ID')
                                            ->badge()
                                            ->color('primary')
                                            ->weight(FontWeight::Bold),

                                        TextEntry::make('name')
                                            ->label('Nama Lengkap')
                                            ->icon('heroicon-o-user')
                                            ->weight(FontWeight::Bold)
                                            ->size(TextSize::Large),

                                        TextEntry::make('email')
                                            ->label('Email')
                                            ->icon('heroicon-o-envelope')
                                            ->copyable()
                                            ->copyMessage('Email copied!')
                                            ->color('info'),
                                    ]),

                                    Group::make([
                                        TextEntry::make('created_at')
                                            ->label('Bergabung Sejak')
                                            ->date('d F Y')
                                            ->icon('heroicon-o-calendar')
                                            ->badge()
                                            ->color('success'),

                                        TextEntry::make('email_verified_at')
                                            ->label('Status Email')
                                            ->badge()
                                            ->formatStateUsing(fn ($state) => $state ? 'Terverifikasi' : 'Belum Terverifikasi')
                                            ->color(fn ($state) => $state ? 'success' : 'warning')
                                            ->icon(fn ($state) => $state ? 'heroicon-o-check-circle' : 'heroicon-o-x-circle'),

                                        TextEntry::make('updated_at')
                                            ->label('Terakhir Update')
                                            ->dateTime('d F Y, H:i')
                                            ->icon('heroicon-o-clock'),
                                    ]),
                                ]),

                    ])
                    ->columns(1),

                Section::make('Statistik Pelanggan')
                    ->schema([
                        Grid::make(4)
                            ->schema([
                                TextEntry::make('orders_count')
                                    ->label('Total Pesanan')
                                    ->getStateUsing(fn ($record) => $record->orders()->count())
                                    ->badge()
                                    ->color('primary')
                                    ->icon('heroicon-o-shopping-cart')
                                    ->weight(FontWeight::Bold),

                                TextEntry::make('total_spent')
                                    ->label('Total Belanja')
                                    ->getStateUsing(fn ($record) => 
                                        $record->orders()
                                            ->where('status', '!=', 'cancelled')
                                            ->sum('total_amount')
                                    )
                                    ->money('IDR')
                                    ->badge()
                                    ->color('success')
                                    ->icon('heroicon-o-banknotes')
                                    ->weight(FontWeight::Bold),

                                TextEntry::make('pending_orders')
                                    ->label('Pesanan Pending')
                                    ->getStateUsing(fn ($record) => $record->orders()->where('status', 'pending')->count())
                                    ->badge()
                                    ->color('warning')
                                    ->icon('heroicon-o-clock'),

                                TextEntry::make('completed_orders')
                                    ->label('Pesanan Selesai')
                                    ->getStateUsing(fn ($record) => $record->orders()->where('status', 'delivered')->count())
                                    ->badge()
                                    ->color('success')
                                    ->icon('heroicon-o-check-badge'),
                            ]),
                    ]),

                Section::make('Riwayat Pesanan')
                    ->schema([
                        RepeatableEntry::make('orders')
                            ->label('')
                            ->schema([
                                TextEntry::make('order_id')
                                    ->label('Order ID')
                                    ->badge()
                                    ->color('primary'),

                                TextEntry::make('order_date')
                                    ->label('Tanggal')
                                    ->date('d M Y'),

                                TextEntry::make('total_amount')
                                    ->label('Total')
                                    ->money('IDR')
                                    ->weight(FontWeight::Bold),

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
                                    ->formatStateUsing(fn (string $state): string => ucfirst($state)),
                            ])
                            ->columns(4)
                            ->grid(4)
                            ->contained(false),
                    ])
                    ->collapsible()
                    ->collapsed(false),

                Section::make('Desain yang Diunggah')
                    ->schema([
                        RepeatableEntry::make('designUploads')
                            ->label('')
                            ->schema([
                                TextEntry::make('design_id')
                                    ->label('Design ID')
                                    ->badge()
                                    ->color('info'),

                                TextEntry::make('product.name')
                                    ->label('Produk')
                                    ->icon('heroicon-o-cube'),

                                TextEntry::make('file_name')
                                    ->label('File')
                                    ->icon('heroicon-o-document')
                                    ->copyable()
                                    ->color('primary'),

                                TextEntry::make('upload_date')
                                    ->label('Tanggal Upload')
                                    ->date('d M Y')
                                    ->icon('heroicon-o-calendar'),
                            ])
                            ->columns(4)
                            ->grid(4)
                            ->contained(false),
                    ])
                    ->collapsible()
                    ->collapsed(true),

                Section::make('Keranjang Belanja')
                    ->schema([
                        RepeatableEntry::make('carts')
                            ->label('')
                            ->schema([
                                TextEntry::make('cart_id')
                                    ->label('Cart ID')
                                    ->badge(),

                                TextEntry::make('cartItems')
                                    ->label('Jumlah Item')
                                    ->getStateUsing(fn ($record) => $record->cartItems()->count())
                                    ->badge()
                                    ->color('info'),

                                TextEntry::make('total_price')
                                    ->label('Total')
                                    ->money('IDR')
                                    ->weight(FontWeight::Bold),

                                TextEntry::make('updated_at')
                                    ->label('Terakhir Update')
                                    ->dateTime('d M Y, H:i'),
                            ])
                            ->columns(4)
                            ->grid(4)
                            ->contained(false),
                    ])
                    ->collapsible()
                    ->collapsed(true),
            ]);
    }
}

