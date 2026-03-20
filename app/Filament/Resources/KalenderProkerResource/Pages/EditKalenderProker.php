<?php

namespace App\Filament\Resources\KalenderProkerResource\Pages;

use App\Filament\Resources\KalenderProkerResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKalenderProker extends EditRecord
{
    protected static string $resource = KalenderProkerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
