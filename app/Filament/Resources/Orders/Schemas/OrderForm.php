<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Order Information')
                    ->schema([
                        Select::make('user_id')
                            ->label('Customer')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->placeholder('Select customer')
                            ->columnSpan(2),

                        DatePicker::make('order_date')
                            ->label('Order Date')
                            ->required()
                            ->default(now())
                            ->native(false)
                            ->displayFormat('d/m/Y')
                            ->closeOnDateSelection(),

                        TextInput::make('total_amount')
                            ->label('Total Amount')
                            ->required()
                            ->numeric()
                            ->prefix('Rp')
                            ->minValue(0)
                            ->step(1000)
                            ->placeholder('Enter total amount'),

                        Select::make('status')
                            ->label('Order Status')
                            ->options([
                                'pending' => 'Pending',
                                'confirmed' => 'Confirmed',
                                'processing' => 'Processing',
                                'shipped' => 'Shipped',
                                'delivered' => 'Delivered',
                                'cancelled' => 'Cancelled',
                            ])
                            ->required()
                            ->default('pending')
                            ->native(false)
                            ->columnSpan(2),
                    ])
                    ->columns(2),

                Section::make('Additional Notes')
                    ->schema([
                        Textarea::make('notes')
                            ->rows(4)
                            ->placeholder('Add any notes about this order...')
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),
            ]);
    }
}
