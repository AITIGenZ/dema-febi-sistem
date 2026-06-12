@props([
    'navigation',
])

<header
    {{
        $attributes->class([
            'fi-topbar sticky top-0 z-20 flex h-16 items-center border-b border-gray-100 bg-white px-4 shadow-sm dark:border-white/5 dark:bg-gray-900 sm:px-6 lg:px-8',
        ])
    }}
>
    {{-- Tombol Toggle Sidebar untuk Mobile --}}
    <x-filament::icon-button
        color="gray"
        icon="heroicon-o-bars-3"
        icon-alias="panels::topbar.open-sidebar-button"
        inline-label
        :label="__('filament-panels::layout.actions.open_sidebar.label')"
        type="button"
        class="fi-topbar-open-sidebar-btn -ms-1.5 sm:hidden"
        x-on:click="$store.sidebar.open()"
    />

    {{-- Bagian Tengah / Kiri Topbar --}}
    <div class="flex items-center gap-x-4 flex-1">
        {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::TOPBAR_START) }}

        @if (filament()->hasNavigation())
            <x-filament-panels::sidebar.toggle class="hidden sm:inline-flex" />
        @endif

        {{-- Ini komponen global search yang tidak muncul --}}
        @if (filament()->hasGlobalSearch())
            <x-filament-panels::global-search />
        @endif

        {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::TOPBAR_END) }}
    </div>

    {{-- Bagian Kanan Topbar (Tempat menu profil "KF") --}}
    <div class="flex items-center gap-x-4">
        {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::USER_MENU_BEFORE) }}

        {{-- 3 LOGO DILETAKKAN DI SINI (Tepat sebelum User Menu) --}}
        <div class="flex items-center gap-2 bg-white rounded-xl px-3 py-1 shadow-sm border border-gray-200 hidden sm:flex dark:bg-gray-800 dark:border-white/10">
            <img src="{{ asset('images/logo uin.png') }}" alt="UIN" style="height:32px; width:32px; object-fit:contain;">
            <img src="{{ asset('images/kabinet.png') }}" alt="Kabinet" style="height:32px; width:32px; object-fit:cover;">
            <img src="{{ asset('images/logo.png') }}" alt="DEMA" style="height:32px; width:32px; object-fit:cover;">
        </div>

        @if (filament()->auth()->check())
            <x-filament-panels::user-menu />
        @endif

        {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::USER_MENU_AFTER) }}
    </div>
</header>