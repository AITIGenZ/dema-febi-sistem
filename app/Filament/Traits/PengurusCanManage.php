<?php

namespace App\Filament\Traits;

trait PengurusCanManage
{
    public static function canCreate(): bool
    {
        return auth()->user()->hasAnyRole(['pimpinan', 'pengurus']);
    }

    public static function canEdit($record): bool
    {
        return auth()->user()->hasAnyRole(['pimpinan', 'pengurus']);
    }

    public static function canDelete($record): bool
    {
        return auth()->user()->hasAnyRole(['pimpinan', 'pengurus']);
    }

    public static function canDeleteAny(): bool
    {
        return auth()->user()->hasAnyRole(['pimpinan', 'pengurus']);
    }
}