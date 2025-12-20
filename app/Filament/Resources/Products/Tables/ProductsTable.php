<?php

namespace App\Filament\Resources\Products\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Table;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image_url')
                    ->label('Gambar')
                    ->disk('public')
                    ->height(50)
                    ->width(50)
                    ->circular(),

                TextColumn::make('name')->searchable(),
                TextColumn::make('category')->searchable(),
                TextColumn::make('size')->searchable(),
                TextColumn::make('price')->money('IDR')->sortable(),
                 TextColumn::make('availability')
                    ->label('Status')
                    ->badge()
                    ->colors([
                        'success' => 'available',
                        'danger'  => 'unavailable',
                    ])
                    ->formatStateUsing(fn ($state) =>
                        $state === 'available' ? 'Tersedia' : 'Tidak Tersedia'
                    ),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}