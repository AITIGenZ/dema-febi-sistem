<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KegiatanResource\Pages;
use App\Models\Kegiatan;
use App\Models\Divisi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class KegiatanResource extends Resource
{
    protected static ?string $model = Kegiatan::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    protected static ?string $navigationLabel = 'Data Kegiatan';
    protected static ?string $modelLabel = 'Kegiatan';
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
                        ->label('Kuota')
                        ->numeric()
                        ->nullable(),

                    Forms\Components\Select::make('divisi_id')
                        ->label('Divisi Penyelenggara')
                        ->options(
                            Divisi::pluck('nama_divisi', 'id')
                        )
                        ->searchable()
                        ->nullable(),

                    Forms\Components\Toggle::make('is_publik')
                        ->label('Publik')
                        ->default(false),

                    Forms\Components\Textarea::make('deskripsi')
                        ->label('Deskripsi')
                        ->rows(4)
                        ->columnSpanFull(),

                ])
                ->columns(2),
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

                Tables\Columns\TextColumn::make('status_pengajuan')
                    ->label('Status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'pending' => 'warning',
                        'disetujui' => 'success',
                        'ditolak' => 'danger',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('kategori')
                    ->badge(),

                Tables\Columns\TextColumn::make('tanggal')
                    ->dateTime('d M Y H:i')
                    ->sortable(),

                Tables\Columns\TextColumn::make('lokasi')
                    ->limit(25),

                Tables\Columns\TextColumn::make('divisi.nama_divisi')
                    ->label('Divisi')
                    ->badge(),

                Tables\Columns\TextColumn::make('createdBy.name')
                    ->label('Pengaju')
                    ->badge()
                    ->color('info'),

                Tables\Columns\TextColumn::make('approver.name')
                    ->label('Disetujui Oleh')
                    ->placeholder('-')
                    ->badge()
                    ->color('success'),

                Tables\Columns\IconColumn::make('is_publik')
                    ->label('Publik')
                    ->boolean(),

            ])

            ->filters([

                Tables\Filters\SelectFilter::make('status_pengajuan')
                    ->options([
                        'pending' => 'Pending',
                        'disetujui' => 'Disetujui',
                        'ditolak' => 'Ditolak',
                    ]),

                Tables\Filters\SelectFilter::make('kategori')
                    ->options([
                        'seminar' => 'Seminar',
                        'rapat' => 'Rapat',
                        'pelatihan' => 'Pelatihan',
                        'sosial' => 'Kegiatan Sosial',
                        'olahraga' => 'Olahraga',
                        'lainnya' => 'Lainnya',
                    ]),

            ])

            ->actions([

                Tables\Actions\Action::make('approve')
                    ->label('Approve')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(
                        fn($record) =>
                        $record->status_pengajuan === 'pending'
                    )
                    ->requiresConfirmation()
                    ->action(function ($record) {
                        abort_unless(Auth::check(), 403);
                        abort_unless(Auth::user()->hasAnyRole(['admin', 'ketua']), 403);

                        $record->update([
                            'status_pengajuan' => 'disetujui',
                            'approved_by'      => Auth::id(),
                            'approved_at'      => now(),
                        ]);
                    }),

                Tables\Actions\Action::make('reject')
                    ->label('Tolak')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->visible(
                        fn($record) =>
                        $record->status_pengajuan === 'pending'
                    )
                    ->requiresConfirmation()
                    ->action(function ($record) {

                        $record->update([
                            'status_pengajuan' => 'ditolak',
                        ]);
                    }),

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