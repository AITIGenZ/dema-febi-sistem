@php
    $user = filament()->auth()->user();
@endphp

<x-filament-widgets::widget class="fi-account-widget">
    <x-filament::section>
        <div class="flex items-center gap-x-4">

            {{-- Foto + Nama --}}
            <div class="flex items-center gap-x-3 flex-1">
                <img
                    src="{{ asset('images/ketum.jpeg') }}"
                    alt="Ketua Umum"
                    style="width:52px; height:52px; border-radius:50%; object-fit:cover; border:2px solid #6366f1; box-shadow: 0 0 0 3px rgba(99,102,241,0.2);"
                >
                <div>
                    <h2 class="text-base font-bold text-gray-900 dark:text-white">
                        Ketua Umum 
                    </h2>
                    <p class="text-sm font-semibold text-indigo-600">
                        Alwy Farid Sayuti
                    </p>
                </div>
            </div>

            {{-- Sign Out --}}
            <form
                action="{{ filament()->getLogoutUrl() }}"
                method="post"
                class="my-auto ml-auto"
            >
                @csrf
                <x-filament::button
                    color="gray"
                    icon="heroicon-m-arrow-left-on-rectangle"
                    labeled-from="sm"
                    tag="button"
                    type="submit"
                >
                    Sign Out
                </x-filament::button>
            </form>

        </div>
    </x-filament::section>
</x-filament-widgets::widget>