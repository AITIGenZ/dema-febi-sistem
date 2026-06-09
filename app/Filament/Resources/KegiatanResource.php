<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KegiatanResource\Pages;
use App\Models\Kegiatan;
use App\Models\Dinas;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class KegiatanResource extends Resource
{
    use \App\Filament\Traits\PengurusCanManage;
    protected static ?string $model = Kegiatan::class;
    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    protected static ?string $navigationLabel = 'Data Kegiatan';
    protected static ?string $modelLabel = 'Kegiatan';
    protected static ?string $pluralModelLabel = 'Kegiatan';
    protected static ?string $navigationGroup = 'Manajemen Kegiatan';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Informasi Kegiatan')
                ->schema([
                    Forms\Components\TextInput::make('nama_kegiatan')
                        ->label('Nama Kegiatan')
                        ->required()
                        ->maxLength(255),

                    Forms\Components\Select::make('kategori')
                        ->label('Kategori')
                        ->options([
                            'seminar' => 'Seminar',
                            'rapat' => 'Rapat',
                            'pelatihan' => 'Pelatihan',
                            'sosial' => 'Kegiatan Sosial',
                            'olahraga' => 'Olahraga',
                            'lainnya' => 'Lainnya',
                        ])
                        ->required(),

                    Forms\Components\DateTimePicker::make('tanggal')
                        ->label('Tanggal & Waktu')
                        ->required(),

                    Forms\Components\TextInput::make('lokasi')
                        ->label('Lokasi')
                        ->maxLength(255),

                    Forms\Components\TextInput::make('kuota')
                        ->label('Kuota Peserta')
                        ->numeric()
                        ->minValue(1)
                        ->placeholder('Kosongkan jika tidak terbatas'),

                    Forms\Components\Select::make('dinas_id')
                        ->label('Dinas Penyelenggara')
                        ->options(Dinas::all()->pluck('nama_dinas', 'id'))
                        ->searchable()
                        ->placeholder('Pilih Dinas'),

                    Forms\Components\Toggle::make('is_publik')
                        ->label('Tampilkan ke Publik')
                        ->helperText('Aktifkan agar kegiatan ini bisa dilihat mahasiswa umum')
                        ->default(false),

                    Forms\Components\Textarea::make('deskripsi')
                        ->label('Deskripsi Kegiatan')
                        ->rows(4)
                        ->columnSpanFull(),
                ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_kegiatan')
                    ->label('Nama Kegiatan')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('kategori')
                    ->label('Kategori')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'seminar' => 'info',
                        'rapat' => 'warning',
                        'pelatihan' => 'success',
                        'sosial' => 'danger',
                        'olahraga' => 'primary',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('tanggal')
                    ->label('Tanggal')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),

                Tables\Columns\TextColumn::make('lokasi')
                    ->label('Lokasi')
                    ->limit(30),

                Tables\Columns\TextColumn::make('kuota')
                    ->label('Kuota')
                    ->default('Tidak terbatas'),

                Tables\Columns\TextColumn::make('dinas.nama_dinas')
                    ->label('Dinas')
                    ->badge()
                    ->color('info'),

                Tables\Columns\IconColumn::make('is_publik')
                    ->label('Publik')
                    ->boolean(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('kategori')
                    ->options([
                        'seminar' => 'Seminar',
                        'rapat' => 'Rapat',
                        'pelatihan' => 'Pelatihan',
                        'sosial' => 'Kegiatan Sosial',
                        'olahraga' => 'Olahraga',
                        'lainnya' => 'Lainnya',
                    ]),

                Tables\Filters\SelectFilter::make('dinas_id')
                    ->label('Dinas')
                    ->options(Dinas::pluck('nama_dinas', 'id')),

                Tables\Filters\TernaryFilter::make('is_publik')
                    ->label('Tampil ke Publik'),
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
            ])
            ->defaultSort('tanggal', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKegiatans::route('/'),
            'create' => Pages\CreateKegiatan::route('/create'),
            'edit' => Pages\EditKegiatan::route('/{record}/edit'),
        ];
    }
}