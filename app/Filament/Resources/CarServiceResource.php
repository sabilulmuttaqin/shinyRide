<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CarServiceResource\Pages;
use App\Filament\Resources\CarServiceResource\RelationManagers;
use App\Models\CarService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CarServiceResource extends Resource
{
    protected static ?string $model = CarService::class;

    protected static ?string $navigationIcon = 'heroicon-o-wrench-screwdriver';
    protected static ?string $navigationGroup = 'Car Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->helperText('Masukkan data kota')
                    ->unique(),
                Forms\Components\FileUpload::make('icon')
                    ->required()
                    ->image()
                    ->directory('icons'),
                Forms\Components\FileUpload::make('photo')
                    ->required()
                    ->image()
                    ->directory('services'),
                Forms\Components\Textarea::make('about')
                    ->required()
                    ->rows(10)
                    ->cols(20),
                Forms\Components\TextInput::make('duration_in_hour')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('IDR')

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\ImageColumn::make('photo'),
                Tables\Columns\TextColumn::make('about'),
                Tables\Columns\TextColumn::make('duration_in_hour'),
                Tables\Columns\TextColumn::make('price'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCarServices::route('/'),
            'create' => Pages\CreateCarService::route('/create'),
            'edit' => Pages\EditCarService::route('/{record}/edit'),
        ];
    }
}
