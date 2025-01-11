<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CarStoreResource\Pages;
use App\Filament\Resources\CarStoreResource\RelationManagers;
use App\Filament\Resources\CarStoreResource\RelationManagers\PhotosRelationManager;
use App\Filament\Resources\CarStoreServiceResource\RelationManagers\CarServicesRelationManager;
use App\Models\CarService;
use App\Models\CarStore;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CarStoreResource extends Resource
{
    protected static ?string $model = CarStore::class;

    protected static ?string $navigationIcon = 'heroicon-o-home-modern';
    protected static ?string $navigationGroup = 'Car Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->helperText('Masukkan data kota'),

                Forms\Components\FileUpload::make('thumbnail')
                    ->required()
                    ->image()
                    ->directory('stores')
                    ->columnSpan(2),

                Forms\Components\Select::make('is_open')
                    ->options([
                        true => 'Open',
                        false => 'Close',
                    ])
                    ->required(),

                Forms\Components\Select::make('is_full')
                    ->options([
                        true => 'Full',
                        false => 'Available',
                    ])
                    ->required(),

                Forms\Components\TextInput::make('cs_name')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('phone_number')
                    ->required()
                    ->maxLength(255),

                Forms\Components\Textarea::make('address')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('rating')
                    ->required()
                    ->numeric(),

                Forms\Components\Select::make('city_id')
                    ->relationship('city', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),

                // Forms\Components\Repeater::make('storeServices')
                //     ->relationship()
                //     ->schema([
                //         Forms\Components\Select::make('car_service_id')
                //             ->relationship('service', 'name')
                //             ->required(),
                //     ])



            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\IconColumn::make('is_open')
                    ->boolean()
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->label('Open?'),
                Tables\Columns\IconColumn::make('is_full')
                    ->boolean()
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->label('Full?'),

                Tables\Columns\TextColumn::make('city.name')
                    ->label('Kota'),
                Tables\Columns\ImageColumn::make('thumbnail')
                    ->label('Thumbnail'),
            ])
            ->filters([
                SelectFilter::make('city_id')
                    ->label("City")
                    ->relationship('city', 'name'),
                SelectFilter::make('car_services_id')
                    ->label('Service')
                    ->options(CarService::pluck('name', 'id'))
                    ->query(function (Builder $query, array $data) {
                        if ($data['value']) {
                            $query->whereHas('storeServices', function ($query) use ($data) {
                                $query->where('car_service_id', $data['value']);
                            });
                        }
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            PhotosRelationManager::class,
            CarServicesRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCarStores::route('/'),
            'create' => Pages\CreateCarStore::route('/create'),
            'edit' => Pages\EditCarStore::route('/{record}/edit'),
        ];
    }
}
