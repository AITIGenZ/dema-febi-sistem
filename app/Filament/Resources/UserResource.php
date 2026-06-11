<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use App\Models\Dinas;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    // Hanya pimpinan yang bisa akses menu ini
    use \App\Filament\Traits\PimpinanOnly;
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Data Anggota';
    protected static ?string $pluralModelLabel = 'Anggota';
    protected static ?string $navigationGroup = 'Manajemen Anggota';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Informasi Pribadi')
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->label('Nama Lengkap')
                        ->required()
                        ->maxLength(255),

                    Forms\Components\TextInput::make('nim')
                        ->label('NIM')
                        ->unique(ignoreRecord: true)
                        ->maxLength(20),

                    Forms\Components\TextInput::make('email')
                        ->label('Email')
                        ->email()
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->maxLength(255),

                    Forms\Components\TextInput::make('phone')
                        ->label('No. HP')
                        ->tel()
                        ->maxLength(15),
                ])->columns(2),

            Forms\Components\Section::make('Informasi Organisasi')
                ->schema([
                    Forms\Components\Select::make('dinas_id')
                        ->label('Dinas')
                        ->options(\App\Models\Dinas::pluck('nama_dinas', 'id'))
                        ->searchable()
                        ->placeholder('Pilih Dinas'),

                    Forms\Components\Select::make('roles')
                        ->label('Role / Jabatan')
                        ->relationship('roles', 'name')
                        ->multiple()
                        ->preload()
                        ->searchable(),

                    Forms\Components\Select::make('status')
                        ->label('Status')
                        ->options([
                            'aktif' => 'Aktif',
                            'nonaktif' => 'Non Aktif',
                        ])
                        ->default('aktif')
                        ->required(),
                ])->columns(3),

            Forms\Components\Section::make('Foto & Password')
                ->schema([
                    Forms\Components\FileUpload::make('photo')
                        ->label('Foto Profil')
                        ->image()
                        ->directory('foto-anggota')
                        ->columnSpan(1),

                    Forms\Components\TextInput::make('password')
                        ->label('Password')
                        ->password()
                        ->dehydrateStateUsing(fn($state) => Hash::make($state))
                        ->dehydrated(fn($state) => filled($state))
                        ->required(fn(string $context) => $context === 'create')
                        ->columnSpan(1),
                ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('photo')
                    ->label('Foto')
                    ->circular()
                    ->defaultImageUrl(
                        fn($record) =>
                        'https://ui-avatars.com/api/?name=' . urlencode($record->name) . '&color=7F9CF5&background=EBF4FF'
                    ),

                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('nim')
                    ->label('NIM')
                    ->searchable(),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),

                Tables\Columns\TextColumn::make('dinas.nama_dinas')
                    ->label('Dinas')
                    ->badge()
                    ->color('info'),

                Tables\Columns\TextColumn::make('roles.name')
                    ->label('Role')
                    ->badge()
                    ->color('warning'),

                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'success' => 'aktif',
                        'danger' => 'nonaktif',
                    ]),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Terdaftar')
                    ->dateTime('d M Y')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'aktif' => 'Aktif',
                        'nonaktif' => 'Non Aktif',
                    ]),

                Tables\Filters\SelectFilter::make('dinas_id')
                    ->label('Dinas')
                    ->options(\App\Models\Dinas::pluck('nama_dinas', 'id')),
            ])
            ->actions([
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}