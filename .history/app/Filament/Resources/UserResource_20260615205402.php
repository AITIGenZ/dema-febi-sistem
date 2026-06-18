<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\Divisi;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Data Anggota';
    protected static ?string $modelLabel = 'Anggota';
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

                    // ✅ BUG #12 FIX sekalian — Divisi::all()->pluck() → Divisi::pluck()
                    // Divisi::all() load semua kolom ke memori dulu baru di-pluck
                    // Divisi::pluck() langsung SELECT id, nama_divisi saja — jauh lebih efisien
                    Forms\Components\Select::make('divisi_id')
                        ->label('Divisi')
                        ->options(Divisi::pluck('nama_divisi', 'id'))
                        ->searchable()
                        ->placeholder('Pilih Divisi'),

                    Forms\Components\Select::make('roles')
                        ->label('Role / Jabatan')
                        ->relationship('roles', 'name')
                        ->multiple()
                        ->preload()
                        ->searchable(),

                    Forms\Components\Select::make('status')
                        ->label('Status')
                        ->options([
                            'aktif'    => 'Aktif',
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
                        ->required(fn(string $context): bool => $context === 'create')
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

                Tables\Columns\TextColumn::make('divisi.nama_divisi')
                    ->label('Divisi')
                    ->badge()
                    ->color('info'),

                Tables\Columns\TextColumn::make('roles.name')
                    ->label('Role')
                    ->badge()
                    ->color('warning'),

                // ✅ BUG #7 FIX — BadgeColumn → TextColumn->badge()
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn(string $state): string => match($state) {
                        'aktif'    => 'success',
                        'nonaktif' => 'danger',
                        default    => 'gray',
                    }),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Terdaftar')
                    ->dateTime('d M Y')
                    ->sortable(),

            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'aktif'    => 'Aktif',
                        'nonaktif' => 'Non Aktif',
                    ]),

                Tables\Filters\SelectFilter::make('divisi')
                    ->relationship('divisi', 'nama_divisi'),
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
            'index'  => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit'   => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}