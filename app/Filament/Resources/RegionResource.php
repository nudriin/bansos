<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RegionResource\Pages;
use App\Models\Region;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class RegionResource extends Resource
{
    protected static ?string $model = Region::class;
    protected static ?string $navigationIcon = 'heroicon-o-map';
    protected static ?string $navigationLabel = 'Wilayah';
    // protected static ?string $navigationGroup = 'Manajemen Data';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->label('Nama Wilayah'),
                Forms\Components\Select::make('type')
                    ->options([
                        'kabupaten' => 'Kabupaten/Kota',
                        'kecamatan' => 'Kecamatan',
                        'desa' => 'Desa/Kelurahan',
                    ])
                    ->required()
                    ->reactive()
                    ->label('Tipe Wilayah'),
                Forms\Components\Select::make('parent_id')
                    ->relationship('parent', 'name', function ($query, $get) {
                        if ($get('type') === 'kecamatan') {
                            return $query->where('type', 'kabupaten');
                        } elseif ($get('type') === 'desa') {
                            return $query->where('type', 'kecamatan');
                        }
                        return $query->whereNull('id');
                    })
                    ->searchable()
                    ->preload()
                    ->label('Wilayah Induk')
                    ->visible(fn($get) => $get('type') !== 'kabupaten'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->label('Nama Wilayah'),
                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'kabupaten' => 'Kabupaten/Kota',
                        'kecamatan' => 'Kecamatan',
                        'desa' => 'Desa/Kelurahan',
                        default => $state,
                    })
                    ->colors([
                        'primary' => 'kabupaten',
                        'secondary' => 'kecamatan',
                        'success' => 'desa',
                    ])
                    ->label('Tipe'),
                Tables\Columns\TextColumn::make('parent.name')
                    ->label('Wilayah Induk'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'kabupaten' => 'Kabupaten/Kota',
                        'kecamatan' => 'Kecamatan',
                        'desa' => 'Desa/Kelurahan',
                    ])
                    ->label('Tipe Wilayah'),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRegions::route('/'),
            'create' => Pages\CreateRegion::route('/create'),
            'edit' => Pages\EditRegion::route('/{record}/edit'),
        ];
    }
}
