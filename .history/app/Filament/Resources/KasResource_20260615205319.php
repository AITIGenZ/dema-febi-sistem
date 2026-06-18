<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KasResource\Pages;
use App\Models\Kas;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class KasResource extends Resource
{
    protected static ?string $model = Kas::class;
    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';
    protected static ?string $navigationLabel = 'Kas Organisasi';
    protected static ?string $modelLabel = 'Kas';
    protected static ?string $navigationGroup = 'Keuangan';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Pencatatan Kas')
                ->schema([

                    // Jenis transaksi — masuk atau keluar
                    Forms\Components\Select::make('jenis')
                        ->label('Jenis Transaksi')
                        ->options([
                            'masuk'  => 'Kas Masuk',
                            'keluar' => 'Kas Keluar',
                        ])
                        ->required()
                        ->live(), // live() agar field sumber bisa reactive

                    
                    Forms\Components\Select::make('sumber')
                        ->label('Sumber Dana')
                        ->options([
                            'kas_bulanan' => 'Kas Bulanan',
                            'iuran'       => 'Iuran',
                            'dana_kampus' => 'Dana Kampus',
                            'saldo_awal'  => 'Saldo Awal',
                        ])
                        ->nullable()
                        ->placeholder('Pilih sumber (opsional)')
                        // Sumber hanya relevan untuk kas masuk
                        ->hidden(fn(Forms\Get $get): bool => $get('jenis') === 'keluar'),

                    Forms\Components\TextInput::make('nominal')
                        ->label('Nominal (Rp)')
                        ->numeric()
                        ->prefix('Rp')
                        ->required(),

                    Forms\Components\DatePicker::make('tanggal')
                        ->label('Tanggal')
                        ->required()
                        ->default(now()),

                    Forms\Components\Textarea::make('keterangan')
                        ->label('Keterangan')
                        ->rows(3)
                        ->required()
                        ->columnSpanFull(),

                ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                // ✅ BUG #7 FIX — BadgeColumn deprecated, ganti ke TextColumn->badge()
                // BadgeColumn pakai ->colors() dengan value sebagai key
                // TextColumn->badge() pakai ->color() dengan closure/match
                Tables\Columns\TextColumn::make('jenis')
                    ->label('Jenis')
                    ->badge()
                    ->color(fn(string $state): string => match($state) {
                        'masuk'  => 'success',
                        'keluar' => 'danger',
                        default  => 'gray',
                    }),

                // ✅ Tampilkan sumber sebagai badge juga
                Tables\Columns\TextColumn::make('sumber')
                    ->label('Sumber')
                    ->badge()
                    ->color('info')
                    ->placeholder('-')
                    ->formatStateUsing(fn(?string $state): string => match($state) {
                        'kas_bulanan' => 'Kas Bulanan',
                        'iuran'       => 'Iuran',
                        'dana_kampus' => 'Dana Kampus',
                        'saldo_awal'  => 'Saldo Awal',
                        default       => '-',
                    }),

                Tables\Columns\TextColumn::make('nominal')
                    ->label('Nominal')
                    ->money('IDR')
                    ->sortable(),

                Tables\Columns\TextColumn::make('keterangan')
                    ->label('Keterangan')
                    ->limit(50),

                Tables\Columns\TextColumn::make('tanggal')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('createdBy.name')
                    ->label('Dicatat Oleh')
                    ->sortable(),

            ])
            ->filters([
                Tables\Filters\SelectFilter::make('jenis')
                    ->options([
                        'masuk'  => 'Kas Masuk',
                        'keluar' => 'Kas Keluar',
                    ]),

                // ✅ Tambahkan filter sumber
                Tables\Filters\SelectFilter::make('sumber')
                    ->options([
                        'kas_bulanan' => 'Kas Bulanan',
                        'iuran'       => 'Iuran',
                        'dana_kampus' => 'Dana Kampus',
                        'saldo_awal'  => 'Saldo Awal',
                    ]),
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
            ->defaultSort('tanggal', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListKas::route('/'),
            'create' => Pages\CreateKas::route('/create'),
            'edit'   => Pages\EditKas::route('/{record}/edit'),
        ];
    }
}