<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BeneficiaryResource\Pages;
use App\Models\Beneficiary;
use App\Models\Region;
use Maatwebsite\Excel\Facades\Excel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Illuminate\Database\Eloquent\Collection;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ImportAction;
use Filament\Tables\Actions\ExportAction;
use App\Imports\BeneficiariesImport;
use App\Exports\BeneficiariesExport;

class BeneficiaryResource extends Resource
{
    protected static ?string $model = Beneficiary::class;
    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationGroup = 'Manajemen Penerima Bantuan';
    protected static ?int $navigationSort = 1;
    protected static ?string $recordTitleAttribute = 'head_of_family';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Wilayah')
                    ->schema([
                        Forms\Components\Select::make('kabupaten_id')
                            ->relationship('kabupaten', 'name', fn(Builder $query) => $query->where('type', 'kabupaten'))
                            ->searchable()
                            ->preload()
                            ->required()
                            ->reactive()
                            ->label('Kabupaten/Kota')
                            ->afterStateUpdated(function ($set) {
                                $set('kecamatan_id', null);
                                $set('desa_id', null);
                            }),
                        Forms\Components\Select::make('kecamatan_id')
                            ->relationship('kecamatan', 'name', function (Builder $query, callable $get) {
                                if ($get('kabupaten_id')) {
                                    return $query->where('type', 'kecamatan')
                                        ->where('parent_id', $get('kabupaten_id'));
                                }
                                return $query->where('type', 'kecamatan');
                            })
                            ->searchable()
                            ->preload()
                            ->required()
                            ->reactive()
                            ->label('Kecamatan')
                            ->afterStateUpdated(fn($set) => $set('desa_id', null)),
                        Forms\Components\Select::make('desa_id')
                            ->relationship('desa', 'name', function (Builder $query, callable $get) {
                                if ($get('kecamatan_id')) {
                                    return $query->where('type', 'desa')
                                        ->where('parent_id', $get('kecamatan_id'));
                                }
                                return $query->where('type', 'desa');
                            })
                            ->searchable()
                            ->preload()
                            ->required()
                            ->label('Desa/Kelurahan'),
                    ])
                    ->columns(3),
                Forms\Components\Section::make('Informasi Penerima')
                    ->schema([
                        Forms\Components\TextInput::make('family_card_number')
                            ->required()
                            ->maxLength(16)
                            ->label('Nomor Kartu Keluarga'),
                        Forms\Components\TextInput::make('head_of_family')
                            ->required()
                            ->maxLength(255)
                            ->label('Nama Kepala Keluarga'),
                        Forms\Components\Select::make('gender')
                            ->options([
                                'Laki-laki' => 'Laki-laki',
                                'Perempuan' => 'Perempuan',
                            ])
                            ->required()
                            ->label('Jenis Kelamin'),
                        Forms\Components\Textarea::make('address')
                            ->required()
                            ->maxLength(65535)
                            ->label('Alamat'),
                        Forms\Components\Toggle::make('has_received_aid')
                            ->label('Sudah Menerima Bantuan')
                            ->default(false),
                        Forms\Components\Select::make('department_id')
                            ->relationship('department', 'name')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->label('Bidang'),
                        Forms\Components\Hidden::make('user_id')
                            ->default(fn() => auth()->id()),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('family_card_number')
                    ->searchable()
                    ->label('No. KK'),
                Tables\Columns\TextColumn::make('head_of_family')
                    ->searchable()
                    ->label('Kepala Keluarga'),
                Tables\Columns\TextColumn::make('gender')
                    ->badge()
                    ->colors([
                        'primary' => 'Laki-laki',
                        'danger' => 'Perempuan',
                    ])
                    ->label('Jenis Kelamin'),
                Tables\Columns\TextColumn::make('kabupaten.name')
                    ->searchable()
                    ->label('Kabupaten/Kota'),
                Tables\Columns\TextColumn::make('kecamatan.name')
                    ->searchable()
                    ->label('Kecamatan'),
                Tables\Columns\TextColumn::make('desa.name')
                    ->searchable()
                    ->label('Desa/Kelurahan'),
                Tables\Columns\IconColumn::make('has_received_aid')
                    ->boolean()
                    ->label('Status Bantuan'),
                Tables\Columns\TextColumn::make('department.name')
                    ->searchable()
                    ->label('Bidang'),
            ])
            ->filters([
                SelectFilter::make('kabupaten_id')
                    ->relationship('kabupaten', 'name')
                    ->searchable()
                    ->preload()
                    ->label('Kabupaten/Kota'),
                SelectFilter::make('kecamatan_id')
                    ->relationship('kecamatan', 'name')
                    ->searchable()
                    ->preload()
                    ->label('Kecamatan'),
                SelectFilter::make('desa_id')
                    ->relationship('desa', 'name')
                    ->searchable()
                    ->preload()
                    ->label('Desa/Kelurahan'),
                SelectFilter::make('department_id')
                    ->relationship('department', 'name')
                    ->searchable()
                    ->preload()
                    ->label('Bidang'),
                TernaryFilter::make('gender')
                    ->placeholder('Semua Jenis Kelamin')
                    ->trueLabel('Laki-laki')
                    ->falseLabel('Perempuan')
                    ->queries(
                        true: fn(Builder $query) => $query->where('gender', 'Laki-laki'),
                        false: fn(Builder $query) => $query->where('gender', 'Perempuan'),
                    )
                    ->label('Jenis Kelamin'),
                TernaryFilter::make('has_received_aid')
                    ->label('Status Bantuan')
                    ->placeholder('Semua Status')
                    ->trueLabel('Sudah Menerima')
                    ->falseLabel('Belum Menerima'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    BulkAction::make('updateStatus')
                        ->label('Update Status Bantuan')
                        ->icon('heroicon-o-check-circle')
                        ->action(function (Collection $records, array $data): void {
                            foreach ($records as $record) {
                                $record->update([
                                    'has_received_aid' => $data['has_received_aid'],
                                ]);
                            }
                        })
                        ->form([
                            Forms\Components\Toggle::make('has_received_aid')
                                ->label('Sudah Menerima Bantuan')
                                ->required(),
                        ]),
                ]),
            ])
            ->headerActions([
                // Import Excel
                Action::make('import')
                    ->label('Import Excel')
                    ->icon('heroicon-o-arrow-up-tray')
                    ->color('primary')
                    ->form([
                        Forms\Components\FileUpload::make('file')
                            ->label('File Excel')
                            ->directory('imports')
                            ->acceptedFileTypes([
                                'application/vnd.ms-excel',
                                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                            ])
                            ->required(),
                    ])
                    ->action(function (array $data, $livewire) {
                        $path = storage_path('app/public/' . $data['file']);
                        Excel::import(new BeneficiariesImport, $path);
                        $livewire->notify('success', 'Data penerima berhasil diimpor!');
                    }),

                // Export Excel
                Action::make('export')
                    ->label('Export Excel')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('success')
                    ->action(function () {
                        $fileName = 'data_penerima_' . now()->format('Y-m-d_H-i-s') . '.xlsx';
                        return Excel::download(new BeneficiariesExport, $fileName);
                    }),
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
            'index' => Pages\ListBeneficiaries::route('/'),
            'create' => Pages\CreateBeneficiary::route('/create'),
            'edit' => Pages\EditBeneficiary::route('/{record}/edit'),
        ];
    }
}
