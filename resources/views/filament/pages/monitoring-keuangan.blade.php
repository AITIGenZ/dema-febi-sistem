<x-filament-panels::page>

    {{-- CARDS --}}
    <div style="display:grid; grid-template-columns:repeat(4,1fr); gap:1rem;">

        <div style="background:white; border-radius:1rem; box-shadow:0 1px 4px rgba(0,0,0,.08); padding:1.25rem; border-left:4px solid #3b82f6;">
            <p style="font-size:.85rem; color:#6b7280;">💰 Kas Bulanan</p>
            <p style="font-size:1.6rem; font-weight:700; color:#2563eb; margin-top:.25rem;">
                Rp {{ number_format($cards['kas_bulanan'], 0, ',', '.') }}
            </p>
            <p style="font-size:.75rem; color:#9ca3af; margin-top:.25rem;">Tahun {{ $tahun }}</p>
        </div>

        <div style="background:white; border-radius:1rem; box-shadow:0 1px 4px rgba(0,0,0,.08); padding:1.25rem; border-left:4px solid #22c55e;">
            <p style="font-size:.85rem; color:#6b7280;">🏦 Jumlah Semua Kas</p>
            <p style="font-size:1.6rem; font-weight:700; color:#16a34a; margin-top:.25rem;">
                Rp {{ number_format($cards['semua_kas'], 0, ',', '.') }}
            </p>
            <p style="font-size:.75rem; color:#9ca3af; margin-top:.25rem;">Total pemasukan</p>
        </div>

        <div style="background:white; border-radius:1rem; box-shadow:0 1px 4px rgba(0,0,0,.08); padding:1.25rem; border-left:4px solid #10b981;">
            <p style="font-size:.85rem; color:#6b7280;">✅ Sudah Bayar</p>
            <p style="font-size:1.6rem; font-weight:700; color:#059669; margin-top:.25rem;">
                {{ $cards['sudah_bayar'] }}/{{ $cards['total_anggota'] }}
            </p>
            <p style="font-size:.75rem; color:#9ca3af; margin-top:.25rem;">Bulan {{ now()->translatedFormat('F') }}</p>
        </div>

        <div style="background:white; border-radius:1rem; box-shadow:0 1px 4px rgba(0,0,0,.08); padding:1.25rem; border-left:4px solid #a855f7;">
            <p style="font-size:.85rem; color:#6b7280;">👥 Total Anggota</p>
            <p style="font-size:1.6rem; font-weight:700; color:#7c3aed; margin-top:.25rem;">
                {{ $cards['total_anggota'] }}
            </p>
            <p style="font-size:.75rem; color:#9ca3af; margin-top:.25rem;">
                Belum bayar: {{ $cards['belum_bayar'] }} orang
            </p>
        </div>

    </div>

    {{-- FILTER --}}
    <div style="background:white; border-radius:1rem; box-shadow:0 1px 4px rgba(0,0,0,.08); padding:1rem; display:flex; flex-wrap:wrap; gap:.75rem; align-items:center; margin-top:1rem;">

        <div style="position:relative; flex:1; min-width:200px;">
            <span style="position:absolute; left:.75rem; top:50%; transform:translateY(-50%); color:#9ca3af;">🔍</span>
            <input
                type="text"
                wire:model.live.debounce.300ms="search"
                placeholder="Cari nama anggota..."
                style="width:100%; padding:.5rem .75rem .5rem 2.25rem; border:1px solid #d1d5db; border-radius:.5rem; font-size:.875rem; outline:none;"
            />
        </div>

        <select wire:model.live="kasSettingId"
            style="border:1px solid #d1d5db; border-radius:.5rem; padding:.5rem .75rem; font-size:.875rem; outline:none;">
            @foreach($kasSettings as $setting)
                <option value="{{ $setting->id }}">{{ $setting->nama ?? 'Kas Bulanan' }}</option>
            @endforeach
        </select>

        <select wire:model.live="tahun"
            style="border:1px solid #d1d5db; border-radius:.5rem; padding:.5rem .75rem; font-size:.875rem; outline:none;">
            @foreach(range(now()->year, now()->year - 4) as $y)
                <option value="{{ $y }}">{{ $y }}</option>
            @endforeach
        </select>

        <div style="display:flex; gap:.5rem;">
            <button wire:click="$set('filterStatus', 'semua')"
                style="padding:.5rem .75rem; border-radius:.5rem; font-size:.875rem; font-weight:500; cursor:pointer; border:none;
                    background: {{ $filterStatus === 'semua' ? '#2563eb' : '#f3f4f6' }};
                    color: {{ $filterStatus === 'semua' ? 'white' : '#4b5563' }};">
                Semua
            </button>
            <button wire:click="$set('filterStatus', 'belum')"
                style="padding:.5rem .75rem; border-radius:.5rem; font-size:.875rem; font-weight:500; cursor:pointer; border:none; display:flex; align-items:center; gap:.35rem;
                    background: {{ $filterStatus === 'belum' ? '#dc2626' : '#f3f4f6' }};
                    color: {{ $filterStatus === 'belum' ? 'white' : '#4b5563' }};">
                Belum Bayar
                <span style="background:#ef4444; color:white; font-size:.7rem; border-radius:9999px; padding:0 .4rem;">
                    {{ $cards['belum_bayar'] }}
                </span>
            </button>
        </div>

    </div>

    {{-- TABEL --}}
    <div style="background:white; border-radius:1rem; box-shadow:0 1px 4px rgba(0,0,0,.08); overflow-x:auto; margin-top:1rem;">
        <table style="width:100%; font-size:.875rem; border-collapse:collapse;">
            <thead style="background:#f9fafb; color:#6b7280; font-size:.75rem; text-transform:uppercase;">
                <tr>
                    <th style="padding:.75rem 1rem; text-align:left; position:sticky; left:0; background:#f9fafb; z-index:10;">No</th>
                    <th style="padding:.75rem 1rem; text-align:left; position:sticky; left:2.5rem; background:#f9fafb; z-index:10; white-space:nowrap;">Nama</th>
                    @foreach($bulanAktif as $bulan)
                        <th style="padding:.75rem; text-align:center; white-space:nowrap;">
                            {{ ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'][$bulan - 1] }}
                        </th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @forelse($dataMonitoring as $i => $row)
                    <tr style="border-top:1px solid #f3f4f6;">
                        <td style="padding:.75rem 1rem; position:sticky; left:0; background:white;">{{ $i + 1 }}</td>
                        <td style="padding:.75rem 1rem; position:sticky; left:2.5rem; background:white; font-weight:500; color:#1f2937; white-space:nowrap;">
                            {{ $row['user']->name }}
                        </td>
                        @foreach($bulanAktif as $bulan)
                            @php
                                $status = $row['bulan'][$bulan];
                                $namaBulan = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'][$bulan - 1];
                            @endphp
                            <td style="padding:.75rem; text-align:center;">
                                @if($status === 'lunas')
                                    <span style="display:inline-block; width:2rem; height:2rem; border-radius:9999px; background:#22c55e;" title="Lunas"></span>
                                @elseif($status === 'libur')
                                    <span style="display:inline-block; width:2rem; height:2rem; border-radius:9999px; background:#fb923c;" title="Libur"></span>
                                @else
                                    <button
                                        onclick="konfirmasiBayar({{ $row['user']->id }}, {{ $bulan }}, '{{ $namaBulan }}', '{{ addslashes($row['user']->name) }}')"
                                        style="display:inline-block; width:2rem; height:2rem; border-radius:9999px; background:#ef4444; border:none; cursor:pointer;"
                                        onmouseover="this.style.background='#dc2626'"
                                        onmouseout="this.style.background='#ef4444'"
                                        title="Klik untuk tandai lunas"
                                    ></button>
                                @endif
                            </td>
                        @endforeach
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ count($bulanAktif) + 2 }}" style="text-align:center; padding:2.5rem; color:#9ca3af;">
                            Tidak ada data ditemukan
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- LEGENDA --}}
    <div style="display:flex; gap:1rem; font-size:.875rem; color:#6b7280; margin-top:.5rem;">
        <div style="display:flex; align-items:center; gap:.5rem;">
            <span style="display:inline-block; width:1rem; height:1rem; border-radius:9999px; background:#22c55e;"></span> Lunas
        </div>
        <div style="display:flex; align-items:center; gap:.5rem;">
            <span style="display:inline-block; width:1rem; height:1rem; border-radius:9999px; background:#ef4444;"></span> Belum Bayar
        </div>
        <div style="display:flex; align-items:center; gap:.5rem;">
            <span style="display:inline-block; width:1rem; height:1rem; border-radius:9999px; background:#fb923c;"></span> Libur
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function konfirmasiBayar(userId, bulan, namaBulan, namaUser) {
            Swal.fire({
                title: 'Konfirmasi Pembayaran',
                text: `Tandai ${namaUser} sudah bayar bulan ${namaBulan}?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#16a34a',
                cancelButtonColor: '#dc2626',
                confirmButtonText: 'Ya, Tandai Lunas!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.bayar(userId, bulan).then(() => {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: `${namaUser} sudah ditandai lunas bulan ${namaBulan}!`,
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    });
                }
            });
        }
    </script>
    @endpush

</x-filament-panels::page>