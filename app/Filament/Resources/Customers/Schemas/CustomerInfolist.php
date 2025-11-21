<?php

namespace App\Filament\Resources\Customers\Schemas;

use Filament\Infolists;
use App\Models\Order;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
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
                                    ->getStateUsing(fn ($record) => Order::where('user_id', $record->user_id)->count())
                                    ->badge()
                                    ->color('primary')
                                    ->icon('heroicon-o-shopping-cart')
                                    ->weight(FontWeight::Bold),

                                TextEntry::make('total_spent')
                                    ->label('Total Belanja')
                                    ->getStateUsing(fn ($record) => 
                                        Order::where('user_id', $record->user_id)
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
                                    ->getStateUsing(fn ($record) => Order::where('user_id', $record->user_id)->where('status', 'pending')->count())
                                    ->badge()
                                    ->color('warning')
                                    ->icon('heroicon-o-clock'),

                                TextEntry::make('completed_orders')
                                    ->label('Pesanan Selesai')
                                    ->getStateUsing(fn ($record) => Order::where('user_id', $record->user_id)->where('status', 'delivered')->count())
                                    ->badge()
                                    ->color('success')
                                    ->icon('heroicon-o-check-badge'),
                            ]),
                    ]),
            ]);
    }
}

