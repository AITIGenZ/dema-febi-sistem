<x-filament-panels::page>
    <div style="position:relative; overflow:hidden; border-radius:16px; background:linear-gradient(135deg, #0f766e, #0d9488); padding:24px; margin-bottom:16px; box-shadow:0 4px 24px rgba(15,118,110,0.3);">
        <div style="position:relative; z-index:10; display:flex; align-items:center; gap:16px;">
            {{-- Foto Profil --}}
            @if(auth()->user()->avatar_url)
                <img src="{{ asset('storage/' . auth()->user()->avatar_url) }}"
                     style="width:64px; height:64px; border-radius:50%; object-fit:cover; border:3px solid rgba(255,255,255,0.4); flex-shrink:0;">
            @else
                <div style="width:64px; height:64px; border-radius:50%; background:rgba(255,255,255,0.2); border:3px solid rgba(255,255,255,0.4); display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                    <span style="color:#ffffff; font-size:24px; font-weight:700;">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </span>
                </div>
            @endif

            {{-- Teks --}}
            <div>
                <p style="color:#99f6e4; font-size:13px; margin-bottom:4px;">{{ now()->translatedFormat('l, d F Y') }}</p>
                <h1 style="color:#ffffff; font-size:22px; font-weight:700; margin-bottom:4px;">
                    Halo, {{ auth()->user()->name }}!
                </h1>
                <p style="color:#ccfbf1; font-size:13px;">Selamat datang kembali di SIMA - Sistem Informasi Manajemen Anggota DEMA FEBI</p>
            </div>
        </div>

        <div style="position:absolute; top:-24px; right:-24px; width:160px; height:160px; background:rgba(255,255,255,0.08); border-radius:50%;"></div>
        <div style="position:absolute; bottom:-32px; right:-64px; width:220px; height:220px; background:rgba(255,255,255,0.05); border-radius:50%;"></div>
        <div style="position:absolute; top:16px; right:130px; width:48px; height:48px; background:rgba(255,255,255,0.1); border-radius:50%;"></div>
    </div>

    <x-filament-widgets::widgets
        :widgets="$this->getVisibleWidgets()"
        :columns="$this->getColumns()"
    />
</x-filament-panels::page>