<?php

namespace App\Filament\Resources\AbsensiRapatResource\Pages;

use App\Filament\Resources\AbsensiRapatResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAbsensiRapat extends EditRecord
{
    protected static string $resource = AbsensiRapatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
