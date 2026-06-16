<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use App\Models\Absensi;

class MonitoringKehadiran extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Kehadiran';
    protected static ?string $navigationLabel = 'Monitoring Kehadiran';
    protected static string $view = 'filament.pages.monitoring-kehadiran';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Absensi::query()->with(['user.divisi', 'rapat', 'kegiatan'])
            )
            ->columns([

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Nama Anggota')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('user.divisi.nama_divisi')
                    ->label('Divisi')
                    ->badge()
                    ->color('info'),

                Tables\Columns\TextColumn::make('rapat.judul')
                    ->label('Rapat')
                    ->placeholder('-'),

                Tables\Columns\TextColumn::make('kegiatan.nama_kegiatan')
                    ->label('Kegiatan')
                    ->placeholder('-'),

                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'success' => 'hadir',
                        'warning' => 'izin',
                        'danger' => 'alpha',
                    ]),

                Tables\Columns\TextColumn::make('tgl_absen')
                    ->label('Tanggal')
                    ->dateTime('d M Y H:i')
                    ->sortable(),

            ])
            ->filters([

                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'hadir' => 'Hadir',
                        'izin' => 'Izin',
                        'alpha' => 'Alpha',
                    ]),

                Tables\Filters\SelectFilter::make('rapat')
                    ->relationship('rapat', 'judul')
                    ->label('Rapat'),

                Tables\Filters\SelectFilter::make('divisi')
                    ->relationship('user.divisi', 'nama_divisi')
                    ->label('Divisi'),

            ])
            ->defaultSort('tgl_absen', 'desc');
    }
}