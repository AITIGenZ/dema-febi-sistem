<x-filament-panels::page>

    <div class="space-y-4">

        {{-- NOTIFIKASI --}}
        @if (session('success'))
            <div class="p-3 bg-green-500 text-white rounded">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="p-3 bg-red-500 text-white rounded">
                {{ session('error') }}
            </div>
        @endif

        {{-- LIST ABSENSI --}}
        @forelse ($this->absensis as $absen)

            <div class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow">

                <h3 class="font-bold text-lg text-gray-900 dark:text-white">
                    {{ $absen->rapat_id
                        ? ($absen->rapat?->judul ?? 'Rapat')
                        : ($absen->kegiatan?->nama_kegiatan ?? 'Kegiatan') }}
                </h3>

                <p class="text-sm text-gray-500 dark:text-gray-400">
                    {{ $absen->tgl_absen?->format('d M Y H:i') }}
                </p>

                <p class="mt-2 text-gray-900 dark:text-white">
                    Status:
                    <strong>{{ strtoupper($absen->status) }}</strong>
                </p>

                @if ($absen->status !== 'hadir' && $absen->rapat_id)

                    <button
                        onclick="ambilLokasi({{ $absen->id }})"
                        class="mt-3 px-4 py-2 bg-primary-600 text-white rounded hover:bg-primary-700"
                    >
                        Hadir Sekarang
                    </button>

                @endif

            </div>

        @empty

            <div class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow text-gray-500 dark:text-gray-400">
                Belum ada data absensi.
            </div>

        @endforelse

    </div>

    <script>
        function ambilLokasi(absensiId) {
            if (!navigator.geolocation) {
                alert("Browser tidak mendukung GPS");
                return;
            }

            navigator.geolocation.getCurrentPosition(
                function(position) {
                    let lat = position.coords.latitude;
                    let lon = position.coords.longitude;

                    @this.call('absen', absensiId, lat, lon);
                },
                function(error) {
                    alert("Gagal mengambil lokasi: " + error.message);
                }
            );
        }
    </script>

</x-filament-panels::page>