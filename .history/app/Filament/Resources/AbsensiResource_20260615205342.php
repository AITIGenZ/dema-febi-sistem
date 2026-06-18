<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AbsensiResource\Pages;
use App\Models\Absensi;
use App\Models\Kegiatan;
use App\Models\Rapat;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AbsensiResource extends Resource
{
    protected static ?string $model = Absensi::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';
    protected static ?string $navigationLabel = 'Absensi';
    protected static ?string $modelLabel = 'Absensi';
    protected static ?string $navigationGroup = 'Manajemen Kegiatan';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Data Absensi')
                ->schema([

                    Forms\Components\Select::make('kegiatan_id')
                        ->label('Kegiatan')
                        ->options(Kegiatan::pluck('nama_kegiatan', 'id'))
                        ->searchable()
                        ->nullable(),

                    Forms\Components\Select::make('rapat_id')
                        ->label('Rapat')
                        ->options(Rapat::pluck('judul', 'id'))
                        ->searchable()
                        ->nullable(),

                    Forms\Components\Select::make('user_id')
                        ->label('Anggota')
                        ->options(User::pluck('name', 'id'))
                        ->searchable()
                        ->required(),

                    Forms\Components\Select::make('status')
                        ->label('Status')
                        ->options([
                            'hadir' => 'Hadir',
                            'izin'  => 'Izin',
                            'alpha' => 'Alpha',
                        ])
                        ->default('hadir')
                        ->required(),

                    Forms\Components\Textarea::make('keterangan')
                        ->label('Keterangan')
                        ->rows(3)
                        ->columnSpanFull(),

                ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('kegiatan.nama_kegiatan')
                    ->label('Kegiatan')
                    ->placeholder('-')
                    ->searchable(),

                Tables\Columns\TextColumn::make('rapat.judul')
                    ->label('Rapat')
                    ->placeholder('-')
                    ->searchable(),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Anggota')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('user.divisi.nama_divisi')
                    ->label('Divisi')
                    ->badge()
                    ->color('info'),

                // ✅ BUG #7 FIX — BadgeColumn → TextColumn->badge()
                // BadgeColumn sudah dihapus dari Filament v3
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn(string $state): string => match($state) {
                        'hadir' => 'success',
                        'izin'  => 'warning',
                        'alpha' => 'danger',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('keterangan')
                    ->limit(40)
                    ->placeholder('-'),

                Tables\Columns\TextColumn::make('tgl_absen')
                    ->label('Tanggal Absen')
                    ->dateTime('d M Y H:i')
                    ->sortable(),

            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'hadir' => 'Hadir',
                        'izin'  => 'Izin',
                        'alpha' => 'Alpha',
                    ]),

                Tables\Filters\SelectFilter::make('kegiatan')
                    ->relationship('kegiatan', 'nama_kegiatan'),

                Tables\Filters\SelectFilter::make('rapat')
                    ->relationship('rapat', 'judul'),
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
            ->defaultSort('tgl_absen', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListAbsensis::route('/'),
            'create' => Pages\CreateAbsensi::route('/create'),
            'edit'   => Pages\EditAbsensi::route('/{record}/edit'),
        ];
    }
}