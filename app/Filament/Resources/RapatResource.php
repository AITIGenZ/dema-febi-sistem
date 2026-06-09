<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RapatResource\Pages;
use App\Models\Rapat;
use App\Models\Divisi;
use App\Models\User;
use App\Models\Absensi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class RapatResource extends Resource
{
    protected static ?string $model = Rapat::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationLabel = 'Rapat';

    protected static ?string $navigationGroup = 'Manajemen Kegiatan';

    protected static ?string $modelLabel = 'Rapat';

    protected static ?string $pluralModelLabel = 'Rapat';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\TextInput::make('judul')
                    ->required()
                    ->maxLength(255),

                Forms\Components\Textarea::make('deskripsi')
                    ->rows(4),

                Forms\Components\DateTimePicker::make('tanggal')
                    ->required(),

                Forms\Components\TextInput::make('lokasi')
                    ->maxLength(255),

                Forms\Components\Select::make('tipe')
                    ->options([
                        'global' => 'Global',
                        'divisi' => 'Divisi',
                    ])
                    ->required()
                    ->reactive(),

                Forms\Components\Select::make('divisi_id')
                    ->label('Divisi')
                    ->options(
                        Divisi::pluck('nama_divisi', 'id')
                    )
                    ->searchable()
                    ->visible(fn ($get) =>
                        $get('tipe') === 'divisi'
                    ),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('judul')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('tipe')
                    ->badge()
                    ->color(fn (string $state) => match ($state) {
                        'global' => 'success',
                        'divisi' => 'warning',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('divisi.nama_divisi')
                    ->label('Divisi')
                    ->placeholder('Semua Divisi'),

                Tables\Columns\TextColumn::make('tanggal')
                    ->dateTime('d M Y H:i')
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('status_pengajuan')
                    ->label('Status')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'disetujui',
                        'danger' => 'ditolak',
                    ]),

                Tables\Columns\TextColumn::make('approver.name')
                    ->label('Disetujui Oleh')
                    ->placeholder('-'),

                Tables\Columns\TextColumn::make('approved_at')
                    ->dateTime('d M Y H:i')
                    ->label('Tanggal Approve')
                    ->placeholder('-'),

            ])

            ->filters([
                //
            ])

            ->actions([

                Tables\Actions\Action::make('approve')
                    ->label('Approve')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')

                    ->visible(fn ($record) =>
                        $record->status_pengajuan === 'pending'
                    )

                    ->action(function ($record) {

                        $record->update([
                            'status_pengajuan' => 'disetujui',
                            'approved_by' => auth()->id(),
                            'approved_at' => now(),
                        ]);

                        if ($record->tipe === 'global') {

                            $users = User::all();

                        } else {

                            $users = User::where(
                                'divisi_id',
                                $record->divisi_id
                            )->get();

                        }

                        foreach ($users as $user) {

                            Absensi::firstOrCreate(
                                [
                                    'user_id' => $user->id,
                                    'rapat_id' => $record->id,
                                ],
                                [
                                    'status' => 'alpha',
                                    'tgl_absen' => now(),
                                ]
                            );

                        }

                    }),

                Tables\Actions\Action::make('reject')
                    ->label('Tolak')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')

                    ->visible(fn ($record) =>
                        $record->status_pengajuan === 'pending'
                    )

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

            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRapats::route('/'),
            'create' => Pages\CreateRapat::route('/create'),
            'edit' => Pages\EditRapat::route('/{record}/edit'),
        ];
    }
}