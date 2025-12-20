<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('image_url')
                    ->label('Gambar Produk')
                    ->image()
                    ->directory('products')
                    ->disk('public')
                    ->imagePreviewHeight('150')
                    ->nullable(),

                TextInput::make('name')->required(),
                TextInput::make('category')->required(),
                TextInput::make('size')->required(),
                TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('Rp'),

                Textarea::make('description')
                    ->default(null)
                    ->columnSpanFull(),
                
                Select::make('availability')
                    ->label('Ketersediaan')
                    ->options([
                        'available' => 'Tersedia',
                        'unavailable' => 'Tidak Tersedia',
                    ])
                    ->default('available')
                    ->required(),    
            ]);
    }
}

