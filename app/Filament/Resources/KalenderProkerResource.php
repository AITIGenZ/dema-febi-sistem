<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KalenderProkerResource\Pages;
use App\Models\KalenderProker;
use App\Models\Kegiatan;
use App\Models\Dinas;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class KalenderProkerResource extends Resource
{
    use \App\Filament\Traits\PengurusCanManage;
    protected static ?string $model = KalenderProker::class;
    protected static ?string $navigationIcon = 'heroicon-o-calendar';
    protected static ?string $navigationLabel = 'Kalender Proker';
    protected static ?string $modelLabel = 'Kalender Proker';
    protected static ?string $pluralModelLabel = 'Kalender Proker';
    protected static ?string $navigationGroup = 'Program Kerja';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Jadwal Program Kerja')
                ->description('Tambahkan kegiatan ke kalender program kerja DEMA FEBI')
                ->schema([
                    Forms\Components\Select::make('kegiatan_id')
                        ->label('Kegiatan')
                        ->options(
                            \App\Models\Kegiatan::all()
                                ->filter(fn($k) => !is_null($k->nama_kegiatan))
                                ->pluck('nama_kegiatan', 'id')
                        )
                        ->searchable()
                        ->required()
                        ->helperText('Pilih kegiatan yang ingin ditampilkan di kalender'),

                    Forms\Components\Select::make('divisi_id')
                        ->label('Dinas Penyelenggara')
                        ->options(
                            \App\Models\Dinas::all()
                                ->filter(fn($d) => !is_null($d->nama_dinas))
                                ->pluck('nama_dinas', 'id')
                        )
                        ->searchable()
                        ->nullable()
                        ->helperText('Opsional — untuk filter kalender per dinas'),

                    Forms\Components\DatePicker::make('tgl_mulai')
                        ->label('Tanggal Mulai')
                        ->required(),

                    Forms\Components\DatePicker::make('tgl_selesai')
                        ->label('Tanggal Selesai')
                        ->nullable()
                        ->helperText('Isi jika kegiatan berlangsung lebih dari 1 hari'),

                    Forms\Components\ColorPicker::make('warna')
                        ->label('Warna Penanda')
                        ->default('#3B82F6')
                        ->helperText('Warna ini akan muncul di tampilan kalender'),

                    Forms\Components\Toggle::make('is_publik')
                        ->label('Tampilkan ke Publik')
                        ->default(true)
                        ->helperText('Aktifkan agar agenda ini muncul di halaman publik'),
                ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('kegiatan.nama_kegiatan')
                    ->label('Nama Kegiatan')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('dinas.nama_dinas')
                    ->label('Dinas')
                    ->badge()
                    ->color('info')
                    ->placeholder('Semua Dinas'),

                Tables\Columns\TextColumn::make('tgl_mulai')
                    ->label('Tanggal Mulai')
                    ->date('d M Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('tgl_selesai')
                    ->label('Tanggal Selesai')
                    ->date('d M Y')
                    ->placeholder('1 hari')
                    ->sortable(),

                Tables\Columns\ColorColumn::make('warna')
                    ->label('Warna'),

                Tables\Columns\IconColumn::make('is_publik')
                    ->label('Publik')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('dinas_id')
                    ->label('Filter Dinas')
                    ->options(Dinas::pluck('nama_dinas', 'id')),

                Tables\Filters\TernaryFilter::make('is_publik')
                    ->label('Tampil ke Publik'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('tgl_mulai', 'asc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKalenderProkers::route('/'),
            'create' => Pages\CreateKalenderProker::route('/create'),
            'edit' => Pages\EditKalenderProker::route('/{record}/edit'),
        ];
    }
}