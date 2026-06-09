<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AbsensiResource\Pages;
use App\Models\Absensi;
use App\Models\Kegiatan;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AbsensiResource extends Resource
{
    use \App\Filament\Traits\PimpinanOnly;
    protected static ?string $model = Absensi::class;
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';
    protected static ?string $navigationLabel = 'Absensi Kegiatan';
    protected static ?string $pluralModelLabel = 'Absensi';
    protected static ?string $navigationGroup = 'Manajemen Kegiatan';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Data Absensi')
                ->schema([
                    Forms\Components\Select::make('kegiatan_id')
                        ->label('Kegiatan')
                        ->options(Kegiatan::all()->pluck('nama_kegiatan', 'id'))
                        ->searchable()
                        ->required()
                        ->reactive(),

                    Forms\Components\Select::make('user_id')
                        ->label('Anggota')
                        ->options(User::all()->pluck('name', 'id'))
                        ->searchable()
                        ->required(),

                    Forms\Components\Select::make('status')
                        ->label('Status Kehadiran')
                        ->options([
                            'hadir' => 'Hadir',
                            'izin' => 'Izin',
                            'alpha' => 'Alpha',
                        ])
                        ->default('hadir')
                        ->required(),

                    Forms\Components\Textarea::make('keterangan')
                        ->label('Keterangan')
                        ->rows(3)
                        ->placeholder('Isi keterangan jika izin atau alpha')
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
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Nama Anggota')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('user.divisi.nama_divisi')
                    ->label('Divisi')
                    ->badge()
                    ->color('info'),

                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'success' => 'hadir',
                        'warning' => 'izin',
                        'danger' => 'alpha',
                    ]),

                Tables\Columns\TextColumn::make('keterangan')
                    ->label('Keterangan')
                    ->limit(40)
                    ->placeholder('-'),

                Tables\Columns\TextColumn::make('tgl_absen')
                    ->label('Tanggal Absen')
                    ->dateTime('d M Y')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'hadir' => 'Hadir',
                        'izin' => 'Izin',
                        'alpha' => 'Alpha',
                    ]),

                Tables\Filters\SelectFilter::make('kegiatan')
                    ->relationship('kegiatan', 'nama_kegiatan'),

                Tables\Filters\SelectFilter::make('dinas')
                    ->relationship('user.dinas', 'nama_dinas')
                    ->label('Dinas'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->actions([
                Tables\Actions\Action::make('export_pdf')
                    ->label('Export PDF')
                    ->icon('heroicon-o-document-arrow-down')
                    ->color('info')
                    ->url(fn($record) => route('export.absensi', $record->kegiatan_id))
                    ->openUrlInNewTab(),

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
            'index' => Pages\ListAbsensis::route('/'),
            'create' => Pages\CreateAbsensi::route('/create'),
            'edit' => Pages\EditAbsensi::route('/{record}/edit'),
        ];
    }
}