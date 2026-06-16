<?php

namespace App\Filament\Pages;

class Dashboard extends \Filament\Pages\Dashboard
{
    protected static ?string $title = '';
    protected static ?string $navigationLabel = 'Dashboard';

    protected static string $view = 'filament.pages.dashboard';
}