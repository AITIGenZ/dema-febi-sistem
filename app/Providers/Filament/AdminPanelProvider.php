<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->authGuard('web')
            ->brandName('DEMA FEBI - UIN Mahmud Yunus Batusangkar')
            ->colors([
                'primary' => Color::Amber,
            ])
            ->viteTheme('resources/css/filament/admin/theme.css')
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                \App\Filament\Widgets\StatsOverview::class,
                \App\Filament\Widgets\AnggotaChart::class,
                \App\Filament\Widgets\KegiatanChart::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            // Menyuntikkan 3 logo ke topbar (Kabinet & DEMA diubah menjadi bulat)
            ->renderHook(
                \Filament\View\PanelsRenderHook::USER_MENU_BEFORE,
                fn (): string => \Illuminate\Support\Facades\Blade::render('
                    <div class="flex items-center gap-2 bg-white rounded-xl px-3 py-1 shadow-sm border border-gray-200 dark:bg-gray-800 dark:border-white/10 hidden sm:flex mr-2">
                        <!-- Logo UIN tetap kotak/natural -->
                        <img src="'.asset('images/logo uin.png').'" alt="UIN" style="height:32px; width:32px; object-fit:contain;">
                        
                        <!-- Logo Kabinet diubah bulat -->
                        <img class="rounded-full" src="'.asset('images/kabinet.png').'" alt="Kabinet" style="height:32px; width:32px; object-fit:cover;">
                        
                        <!-- Logo DEMA diubah bulat -->
                        <img class="rounded-full" src="'.asset('images/logo.png').'" alt="DEMA" style="height:32px; width:32px; object-fit:cover;">
                    </div>
                '),
            );
    }
}