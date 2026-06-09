<?php

namespace App\Filament\Traits;

trait PimpinanOnly
{
    public static function canCreate(): bool
    {
        return auth()->user()->hasRole('pimpinan');
    }

    public static function canEdit($record): bool
    {
        return auth()->user()->hasRole('pimpinan');
    }

    public static function canDelete($record): bool
    {
        return auth()->user()->hasRole('pimpinan');
    }

    public static function canDeleteAny(): bool
    {
        return auth()->user()->hasRole('pimpinan');
    }
}