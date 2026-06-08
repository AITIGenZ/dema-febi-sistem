<x-filament-panels::page.simple>

    {{-- ═══════════════════════════════════════════
         LOGO TIGA INSTITUSI
         Pastikan file ada di: public/images/
    ════════════════════════════════════════════ --}}
    <x-slot name="logo">
        <div style="
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 14px;
            margin-bottom: 4px;
        ">
            {{-- Logo UIN --}}
            <div style="
                width: 56px; height: 56px;
                border-radius: 50%;
                border: 2px solid rgba(196,160,48,0.5);
                overflow: hidden;
                background: #fff;
                display: flex; align-items: center; justify-content: center;
                flex-shrink: 0;
            ">
                <img src="{{ asset('images/logo_uin.png') }}"
                     alt="Logo UIN"
                     style="width: 50px; height: 50px; object-fit: contain;">
            </div>

            {{-- Garis pemisah --}}
            <div style="width: 1px; height: 44px; background: rgba(196,160,48,0.35);"></div>

            {{-- Logo DEMA FEBI --}}
            <div style="
                width: 56px; height: 56px;
                border-radius: 50%;
                border: 2px solid rgba(196,160,48,0.5);
                overflow: hidden;
                background: #fff;
                display: flex; align-items: center; justify-content: center;
                flex-shrink: 0;
            ">
                <img src="{{ asset('images/logo_dema.jpeg') }}"
                     alt="Logo DEMA FEBI"
                     style="width: 50px; height: 50px; object-fit: contain;">
            </div>

            {{-- Garis pemisah --}}
            <div style="width: 1px; height: 44px; background: rgba(196,160,48,0.35);"></div>

            {{-- Logo Kabinet Nebula Leviosa --}}
            <div style="
                width: 56px; height: 56px;
                border-radius: 50%;
                border: 2px solid rgba(196,160,48,0.5);
                overflow: hidden;
                background: #fff;
                display: flex; align-items: center; justify-content: center;
                flex-shrink: 0;
            ">
                <img src="{{ asset('images/kabinet.jpeg') }}"
                     alt="Logo Kabinet Nebula Leviosa"
                     style="width: 50px; height: 50px; object-fit: contain;">
            </div>
        </div>
    </x-slot>

    {{-- ═══════════════════════════════════════════
         HEADING: DEMA FEBI
    ════════════════════════════════════════════ --}}
    <x-slot name="heading">
        <div style="text-align: center; line-height: 1.2;">
            <div style="
                font-size: 10px;
                letter-spacing: 0.2em;
                color: rgba(196,160,48,0.75);
                text-transform: uppercase;
                margin-bottom: 4px;
                font-weight: 400;
            ">Dewan Eksekutif Mahasiswa</div>
            <div style="
                font-family: Georgia, 'Times New Roman', serif;
                font-size: 24px;
                font-weight: 700;
                color: #C4A030;
                letter-spacing: 0.08em;
            ">DEMA FEBI</div>
            <div style="
                font-size: 10px;
                color: rgba(255,255,255,0.3);
                letter-spacing: 0.12em;
                margin-top: 4px;
            ">Kabinet Nebula Leviosa · 2026</div>
        </div>
    </x-slot>

    {{-- ═══════════════════════════════════════════
         SUBHEADING: Log In
    ════════════════════════════════════════════ --}}
    <x-slot name="subheading">
        <div style="
            text-align: center;
            font-size: 11px;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.55);
            padding-top: 4px;
        ">Log In</div>
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

    {{-- Footer --}}
    <div style="
        text-align: center;
        font-size: 10px;
        color: rgba(255,255,255,0.2);
        margin-top: 0.5rem;
        letter-spacing: 0.06em;
    ">UIN Mahmud Yunus Batusangkar</div>

</x-filament-panels::page.simple>