<?php

namespace App\Filament\Resources\AbsensiRapatResource\Pages;

use App\Filament\Resources\AbsensiRapatResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAbsensiRapats extends ListRecords
{
    protected static string $resource = AbsensiRapatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
