<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IuranResource\Pages;
use App\Models\Iuran;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class IuranResource extends Resource
{
    protected static ?string $model = Iuran::class;
    protected static ?string $navigationIcon = 'heroicon-o-banknotes';
    protected static ?string $navigationLabel = 'Data Iuran';
    protected static ?string $pluralModelLabel = 'Iuran';
    protected static ?string $navigationGroup = 'Keuangan';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Data Iuran Anggota')
                ->schema([
                    Forms\Components\Select::make('user_id')
                        ->label('Anggota')
                        ->options(User::all()->pluck('name', 'id'))
                        ->searchable()
                        ->required(),

                    Forms\Components\Select::make('bulan')
                        ->label('Bulan')
                        ->options([
                            'Januari' => 'Januari',
                            'Februari' => 'Februari',
                            'Maret' => 'Maret',
                            'April' => 'April',
                            'Mei' => 'Mei',
                            'Juni' => 'Juni',
                            'Juli' => 'Juli',
                            'Agustus' => 'Agustus',
                            'September' => 'September',
                            'Oktober' => 'Oktober',
                            'November' => 'November',
                            'Desember' => 'Desember',
                        ])
                        ->required(),

                    Forms\Components\TextInput::make('nominal')
                        ->label('Nominal (Rp)')
                        ->numeric()
                        ->prefix('Rp')
                        ->required(),

                    Forms\Components\Select::make('status')
                        ->label('Status')
                        ->options([
                            'lunas' => 'Lunas',
                            'belum' => 'Belum Lunas',
                        ])
                        ->default('belum')
                        ->required(),

                    Forms\Components\DatePicker::make('tgl_bayar')
                        ->label('Tanggal Bayar')
                        ->nullable(),

                    Forms\Components\FileUpload::make('bukti_bayar')
                        ->label('Bukti Pembayaran')
                        ->image()
                        ->directory('bukti-iuran')
                        ->nullable(),
                ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Nama Anggota')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('user.divisi.nama_divisi')
                    ->label('Divisi')
                    ->badge()
                    ->color('info'),

                Tables\Columns\TextColumn::make('bulan')
                    ->label('Bulan')
                    ->sortable(),

                Tables\Columns\TextColumn::make('nominal')
                    ->label('Nominal')
                    ->money('IDR')
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'success' => 'lunas',
                        'danger' => 'belum',
                    ]),

                Tables\Columns\TextColumn::make('tgl_bayar')
                    ->label('Tanggal Bayar')
                    ->date('d M Y')
                    ->placeholder('-')
                    ->sortable(),

                Tables\Columns\ImageColumn::make('bukti_bayar')
                    ->label('Bukti')
                    ->circular()
                    ->placeholder('-'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'lunas' => 'Lunas',
                        'belum' => 'Belum Lunas',
                    ]),

                Tables\Filters\SelectFilter::make('bulan')
                    ->options([
                        'Januari' => 'Januari',
                        'Februari' => 'Februari',
                        'Maret' => 'Maret',
                        'April' => 'April',
                        'Mei' => 'Mei',
                        'Juni' => 'Juni',
                        'Juli' => 'Juli',
                        'Agustus' => 'Agustus',
                        'September' => 'September',
                        'Oktober' => 'Oktober',
                        'November' => 'November',
                        'Desember' => 'Desember',
                    ]),
            ])
            ->actions([
                Tables\Actions\Action::make('tandai_lunas')
                    ->label('Tandai Lunas')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn($record) => $record->status === 'belum')
                    ->action(fn($record) => $record->update([
                        'status' => 'lunas',
                        'tgl_bayar' => now(),
                    ]))
                    ->requiresConfirmation(),

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
            'index' => Pages\ListIurans::route('/'),
            'create' => Pages\CreateIuran::route('/create'),
            'edit' => Pages\EditIuran::route('/{record}/edit'),
        ];
    }
}