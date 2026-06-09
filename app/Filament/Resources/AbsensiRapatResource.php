<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AbsensiRapatResource\Pages;
use App\Models\Absensi;
use App\Models\Rapat;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AbsensiRapatResource extends Resource
{
    protected static ?string $model = Absensi::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';

    protected static ?string $navigationLabel = 'Absensi Rapat';

    protected static ?string $navigationGroup = 'Manajemen Rapat';

    protected static ?string $modelLabel = 'Absensi Rapat';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('rapat_id')
                    ->label('Rapat')
                    ->options(
                        Rapat::pluck('judul', 'id')
                    )
                    ->searchable()
                    ->required(),

                Forms\Components\Select::make('user_id')
                    ->label('Anggota')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->required(),

                Forms\Components\Select::make('status')
                    ->label('Status Kehadiran')
                    ->options([
                        'hadir' => 'Hadir',
                        'izin' => 'Izin',
                        'alpha' => 'Alpha',
                    ])
                    ->default('alpha')
                    ->required(),

                Forms\Components\Textarea::make('keterangan')
                    ->label('Keterangan')
                    ->nullable()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('rapat.judul')
                    ->label('Rapat')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Nama Anggota')
                    ->searchable(),

                Tables\Columns\TextColumn::make('user.divisi.nama_divisi')
                    ->label('Divisi')
                    ->badge()
                    ->color('info'),

                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'success' => 'hadir',
                        'warning' => 'izin',
                        'danger' => 'alpha',
                    ]),

                Tables\Columns\TextColumn::make('tgl_absen')
                    ->label('Tanggal Absen')
                    ->dateTime('d M Y H:i'),

            ])

            ->filters([

                Tables\Filters\SelectFilter::make('rapat_id')
                    ->label('Rapat')
                    ->options(Rapat::pluck('judul', 'id')),

                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'hadir' => 'Hadir',
                        'izin' => 'Izin',
                        'alpha' => 'Alpha',
                    ]),

                Tables\Filters\SelectFilter::make('divisi')
                    ->relationship('user.divisi', 'nama_divisi')
                    ->label('Divisi'),

            ])

            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])

            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])

            ->defaultSort('tgl_absen', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAbsensiRapats::route('/'),
            'create' => Pages\CreateAbsensiRapat::route('/create'),
            'edit' => Pages\EditAbsensiRapat::route('/{record}/edit'),
        ];
    }
}