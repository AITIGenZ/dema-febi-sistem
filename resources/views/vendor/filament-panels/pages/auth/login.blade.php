<x-filament-panels::page.simple>

    <x-slot name="logo">
        <div style="
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 14px;
            margin-bottom: 4px;
        ">
            <div style="width:56px;height:56px;border-radius:50%;border:2px solid rgba(26,160,160,0.5);overflow:hidden;background:#fff;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <img src="{{ asset('images/logo uin.png') }}" alt="Logo UIN" style="width:50px;height:50px;object-fit:contain;">
            </div>
            <div style="width:1px;height:44px;background:rgba(26,160,160,0.35);"></div>
            <div style="width:56px;height:56px;border-radius:50%;border:2px solid rgba(26,160,160,0.5);overflow:hidden;background:#fff;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <img src="{{ asset('images/logo_dema_febi.png') }}" alt="Logo DEMA FEBI" style="width:50px;height:50px;object-fit:contain;">
            </div>
            <div style="width:1px;height:44px;background:rgba(26,160,160,0.35);"></div>
            <div style="width:56px;height:56px;border-radius:50%;border:2px solid rgba(26,160,160,0.5);overflow:hidden;background:#fff;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <img src="{{ asset('images/logo_kabinet.jpeg') }}" alt="Logo Kabinet" style="width:50px;height:50px;object-fit:contain;">
            </div>
        </div>
    </x-slot>

    <x-slot name="heading">
        <div style="text-align:center;line-height:1.2;">
            <div style="font-family:Georgia,'Times New Roman',serif;font-size:24px;font-weight:700;color:#1a7a7a;letter-spacing:0.08em;">DEMA FEBI</div>
            <div style="font-size:10px;color:rgba(0,0,0,0.35);letter-spacing:0.12em;margin-top:4px;">Kabinet Nebula Leviosa · 2026</div>
        </div>
    </x-slot>

    {{ \Filament\Facades\Filament::renderHook(\Filament\View\PanelsRenderHook::AUTH_LOGIN_FORM_BEFORE) }}

    <x-filament-panels::form wire:submit="authenticate">
        {{ $this->form }}
        <x-filament-panels::form.actions
            :actions="$this->getCachedFormActions()"
            :full-width="$this->hasFullWidthFormActions()"
        />
    </x-filament-panels::form>

    {{ \Filament\Facades\Filament::renderHook(\Filament\View\PanelsRenderHook::AUTH_LOGIN_FORM_AFTER) }}

    <div style="text-align:center;font-size:10px;color:rgba(0,0,0,0.3);margin-top:0.5rem;letter-spacing:0.06em;">
        UIN Mahmud Yunus Batusangkar
    </div>

</x-filament-panels::page.simple>