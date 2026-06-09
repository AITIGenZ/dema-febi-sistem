<x-filament-panels::page.simple>

<style>
    html,
    body,
    .fi-body,
    .fi-layout,
    .fi-main,
    .fi-simple-layout,
    .fi-simple-page,
    .fi-simple-main {
        background: #071c56 !important;
    }

    .fi-simple-header,
    .fi-simple-header-heading,
    .fi-simple-header-subheading,
    .fi-logo,
    .fi-brand {
        display: none !important;
    }

    .fi-simple-main {
        max-width: 100% !important;
        background: transparent !important;
        box-shadow: none !important;
        border: none !important;
        padding: 0 !important;
    }

    .dema-wrapper {
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 40px 20px;
    }

    .dema-card {
        width: 100%;
        max-width: 620px;
        background: #152f73;
        border-radius: 30px;
        padding: 40px;
        border: 1px solid rgba(212,175,55,.25);
        box-shadow: 0 20px 60px rgba(0,0,0,.35);
    }

    .logo-box {
        background: #fff;
        border-radius: 22px;
        padding: 20px;
        width: fit-content;
        margin: 0 auto 30px auto;
    }

    .logo-row {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 20px;
    }

    .logo-uin {
        width: 90px;
        height: 90px;
        object-fit: contain;
    }

    .logo-kabinet {
        width: 95px;
        height: 95px;
        object-fit: cover;
        border-radius: 50%;
        border: 3px solid #d4af37;
        padding: 3px;
        background: #fff;
    }

    .logo-dema {
        width: 90px;
        height: 90px;
        object-fit: cover;
        border-radius: 50%;
        border: 3px solid #d4af37;
        padding: 3px;
        background: #fff;
    }

    .title-small {
        text-align: center;
        color: #d4af37;
        letter-spacing: 5px;
        font-size: 14px;
        margin-bottom: 10px;
    }

    .title-main {
        text-align: center;
        color: #d4af37;
        font-size: 58px;
        font-weight: 700;
        font-family: Georgia, serif;
        line-height: 1;
        white-space: nowrap;
    }

    .subtitle {
        text-align: center;
        color: #aab6d9;
        font-size: 18px;
        margin-top: 12px;
        margin-bottom: 25px;
    }

    .divider {
        border-top: 1px solid rgba(212,175,55,.20);
        margin: 25px 0;
    }

    .fi-input,
    .fi-input-wrp {
        background: rgba(255,255,255,.06) !important;
        border: 1px solid rgba(212,175,55,.25) !important;
        border-radius: 12px !important;
    }

    .fi-input {
        color: white !important;
    }

    .fi-label {
        color: #d4af37 !important;
        letter-spacing: 2px;
        font-weight: 600 !important;
    }

    button[type="submit"] {
        width: 100% !important;
        height: 55px !important;
        background: #d4af37 !important;
        color: #071c56 !important;
        font-weight: 700 !important;
        border-radius: 12px !important;
        font-size: 15px !important;
        border: none !important;
        box-shadow: 0 4px 12px rgba(0,0,0,.15);
        cursor: pointer;
    }

    button[type="submit"]:hover {
        background: #c49e2f !important;
    }

    button[type="submit"] span {
        color: #071c56 !important;
        font-weight: 700 !important;
    }

    .footer {
        text-align: center;
        color: #7f8db6;
        margin-top: 25px;
        font-size: 14px;
    }
</style>

<div class="dema-wrapper">
    <div class="dema-card">

        <div class="logo-box">
            <div class="logo-row">
                <img src="{{ asset('images/logo uin.png') }}" alt="UIN" class="logo-uin">
                <img src="{{ asset('images/kabinet.png') }}" alt="Kabinet" class="logo-kabinet">
                <img src="{{ asset('images/logo.png') }}" alt="DEMA" class="logo-dema">
            </div>
        </div>

        <div class="title-small">DEWAN EKSEKUTIF MAHASISWA</div>
        <div class="title-main">DEMA FEBI</div>
        <div class="subtitle">Kabinet Nebula Leviosa • 2026</div>
        <div class="divider"></div>

        <form wire:submit.prevent="authenticate">
            {{ $this->form }}

            <x-filament::button
                type="submit"
                size="lg"
                class="w-full mt-4"
            >
                LOG IN
            </x-filament::button>
        </form>

        <div class="footer">UIN Mahmud Yunus Batusangkar</div>

    </div>
</div>

</x-filament-panels::page.simple>