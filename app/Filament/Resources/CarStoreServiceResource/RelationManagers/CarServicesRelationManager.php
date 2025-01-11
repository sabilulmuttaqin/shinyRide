<?php

namespace App\Filament\Resources\CarStoreServiceResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CarServicesRelationManager extends RelationManager
{
    protected static string $relationship = 'storeServices';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('car_service_id')
                    ->label('Service')
                    ->relationship('service', 'name')
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('car_service_id')
            ->columns([
                Tables\Columns\TextColumn::make('service.name')
                    ->label('Service Name'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
