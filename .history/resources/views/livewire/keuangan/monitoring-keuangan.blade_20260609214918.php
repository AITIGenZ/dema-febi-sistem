<div class="p-6 space-y-6">

    {{-- CARDS --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

        {{-- Kas Bulanan --}}
        <div class="bg-white rounded-2xl shadow p-5 border-l-4 border-blue-500">
            <p class="text-sm text-gray-500">💰 Kas Bulanan</p>
            <p class="text-2xl font-bold text-blue-600 mt-1">
                Rp {{ number_format($cards['kas_bulanan'], 0, ',', '.') }}
            </p>
            <p class="text-xs text-gray-400 mt-1">Tahun {{ $tahun }}</p>
        </div>

        {{-- Semua Kas --}}
        <div class="bg-white rounded-2xl shadow p-5 border-l-4 border-green-500">
            <p class="text-sm text-gray-500">🏦 Jumlah Semua Kas</p>
            <p class="text-2xl font-bold text-green-600 mt-1">
                Rp {{ number_format($cards['semua_kas'], 0, ',', '.') }}
            </p>
            <p class="text-xs text-gray-400 mt-1">Total pemasukan</p>
        </div>

        {{-- Sudah Bayar --}}
        <div class="bg-white rounded-2xl shadow p-5 border-l-4 border-emerald-500">
            <p class="text-sm text-gray-500">✅ Sudah Bayar</p>
            <p class="text-2xl font-bold text-emerald-600 mt-1">
                {{ $cards['sudah_bayar'] }}/{{ $cards['total_anggota'] }}
            </p>
            <p class="text-xs text-gray-400 mt-1">Bulan {{ now()->translatedFormat('F') }}</p>
        </div>

        {{-- Total Anggota --}}
        <div class="bg-white rounded-2xl shadow p-5 border-l-4 border-purple-500">
            <p class="text-sm text-gray-500">👥 Total Anggota</p>
            <p class="text-2xl font-bold text-purple-600 mt-1">
                {{ $cards['total_anggota'] }}
            </p>
            <p class="text-xs text-gray-400 mt-1">
                Belum bayar: {{ $cards['total_anggota'] - $cards['sudah_bayar'] }} orang
            </p>
        </div>

    </div>

    {{-- FILTER --}}
    <div class="bg-white rounded-2xl shadow p-4 flex flex-wrap gap-3 items-center">

        {{-- Search --}}
        <div class="relative flex-1 min-w-[200px]">
            <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">🔍</span>
            <input
                type="text"
                wire:model.live.debounce.300ms="search"
                placeholder="Cari nama anggota..."
                class="w-full pl-9 pr-4 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-400"
            />
        </div>

        {{-- Pilih Setting Kas --}}
        <select wire:model.live="kasSettingId" class="border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
            @foreach($kasSettings as $setting)
                <option value="{{ $setting->id }}">{{ $setting->nama ?? 'Kas Bulanan' }}</option>
            @endforeach
        </select>

        {{-- Pilih Tahun --}}
        <select wire:model.live="tahun" class="border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
            @foreach(range(now()->year, now()->year - 4) as $y)
                <option value="{{ $y }}">{{ $y }}</option>
            @endforeach
        </select>

        {{-- Filter Status --}}
        <div class="flex gap-2">
            @foreach(['semua' => 'Semua', 'belum' => 'Belum Bayar'] as $val => $label)
                <button
                    wire:click="$set('filterStatus', '{{ $val }}')"
                    class="px-3 py-2 rounded-lg text-sm font-medium transition
                        {{ $filterStatus === $val
                            ? 'bg-blue-600 text-white'
                            : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}"
                >
                    {{ $label }}
                    @if($val === 'belum')
                        <span class="ml-1 bg-red-500 text-white text-xs rounded-full px-1">
                            {{ $cards['total_anggota'] - $cards['sudah_bayar'] }}
                        </span>
                    @endif
                </button>
            @endforeach
        </div>

    </div>

    {{-- TABEL --}}
    <div class="bg-white rounded-2xl shadow overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3 sticky left-0 bg-gray-50 z-10">No</th>
                    <th class="px-4 py-3 sticky left-10 bg-gray-50 z-10">Nama</th>
                    @foreach($bulanAktif as $bulan)
                        <th class="px-3 py-3 text-center whitespace-nowrap">
                            {{ ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'][$bulan - 1] }}
                        </th>
                    @endforeach
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($dataMonitoring as $i => $row)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-3 sticky left-0 bg-white">{{ $i + 1 }}</td>
                        <td class="px-4 py-3 sticky left-10 bg-white font-medium text-gray-800 whitespace-nowrap">
                            {{ $row['user']->name }}
                        </td>
                        @foreach($bulanAktif as $bulan)
                            @php $status = $row['bulan'][$bulan]; @endphp
                            <td class="px-3 py-3 text-center">
                                @if($status === 'lunas')
                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-green-100 text-green-600 text-xs font-bold">✓</span>
                                @elseif($status === 'libur')
                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-orange-100 text-orange-500 text-xs font-bold">L</span>
                                @else
                                    <button
                                        wire:click="bayar({{ $row['user']->id }}, {{ $bulan }})"
                                        wire:confirm="Tandai {{ $row['user']->name }} sudah bayar bulan ini?"
                                        class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-red-100 text-red-500 hover:bg-red-500 hover:text-white transition text-xs font-bold"
                                        title="Klik untuk tandai lunas"
                                    >✕</button>
                                @endif