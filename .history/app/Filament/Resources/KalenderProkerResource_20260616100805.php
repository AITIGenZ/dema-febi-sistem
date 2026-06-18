<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KalenderProkerResource\Pages;
use App\Models\KalenderProker;
use App\Models\Kegiatan;
use App\Models\Divisi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class KalenderProkerResource extends Resource
{
    protected static ?string $model = KalenderProker::class;
    protected static ?string $navigationIcon = 'heroicon-o-calendar';
    protected static ?string $navigationLabel = 'Kalender Proker';
    protected static ?string $modelLabel = 'Kalender Proker';
    protected static ?string $navigationGroup = 'Program Kerja';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Jadwal Program Kerja')
                ->description('Tambahkan kegiatan ke kalender program kerja DEMA FEBI')
                ->schema([
                    Forms\Components\Select::make('kegiatan_id')
                        ->label('Kegiatan')
                        ->options(Kegiatan::pluck('nama_kegiatan', 'id'))
                        ->searchable()
                        ->required()
                        ->helperText('Pilih kegiatan yang ingin ditampilkan di kalender'),

                    Forms\Components\Select::make('divisi_id')
                        ->label('Divisi Penyelenggara')
                        ->options(Divisi::pluck('nama_divisi', 'id'))
                        ->searchable()
                        ->nullable()
                        ->helperText('Opsional — untuk filter kalender per divisi'),

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

                Tables\Columns\TextColumn::make('divisi.nama_divisi')
                    ->label('Divisi')
                    ->badge()
                    ->color('info')
                    ->placeholder('Semua Divisi'),

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

                // ✅ Ganti IconColumn jadi TextColumn badge supaya lebih jelas
                Tables\Columns\TextColumn::make('is_publik')
                    ->label('Publik')
                    ->badge()
                    ->formatStateUsing(fn (bool $state): string => $state ? 'Publik' : 'Privat')
                    ->color(fn (bool $state): string => $state ? 'success' : 'gray'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('divisi')
                    ->relationship('divisi', 'nama_divisi')
                    ->label('Filter Divisi'),

                Tables\Filters\TernaryFilter::make('is_publik')
                    ->label('Tampil ke Publik'),
            ])
            ->actions([
                // ✅ Toggle publik/privat dengan konfirmasi
                Tables\Actions\Action::make('togglePublik')
                    ->label(fn (KalenderProker $record): string => $record->is_publik ? 'Set Privat' : 'Set Publik')
                    ->icon(fn (KalenderProker $record): string => $record->is_publik ? 'heroicon-o-eye-slash' : 'heroicon-o-eye')
                    ->color(fn (KalenderProker $record): string => $record->is_publik ? 'warning' : 'success')
                    ->requiresConfirmation()
                    ->modalHeading(fn (KalenderProker $record): string => $record->is_publik ? 'Sembunyikan dari Publik?' : 'Tampilkan ke Publik?')
                    ->modalDescription(fn (KalenderProker $record): string => $record->is_publik
                        ? 'Kegiatan ini tidak akan muncul di halaman publik.'
                        : 'Kegiatan ini akan muncul di halaman publik dan kalender landing page.')
                    ->modalSubmitActionLabel('Ya, lanjutkan')
                    ->action(function (KalenderProker $record): void {
                        $record->update(['is_publik' => ! $record->is_publik]);
                    }),

                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),

                    // ✅ Bulk set publik
                    Tables\Actions\BulkAction::make('setPublik')
                        ->label('Set Publik')
                        ->icon('heroicon-o-eye')
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(fn ($records) => $records->each->update(['is_publik' => true])),

                    // ✅ Bulk set privat
                    Tables\Actions\BulkAction::make('setPrivat')
                        ->label('Set Privat')
                        ->icon('heroicon-o-eye-slash')
                        ->color('warning')
                        ->requiresConfirmation()
                        ->action(fn ($records) => $records->each->update(['is_publik' => false])),
                ]),
            ])
            ->defaultSort('tgl_mulai', 'asc');
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListKalenderProkers::route('/'),
            'create' => Pages\CreateKalenderProker::route('/create'),
            'edit'   => Pages\EditKalenderProker::route('/{record}/edit'),
        ];
    }
}a