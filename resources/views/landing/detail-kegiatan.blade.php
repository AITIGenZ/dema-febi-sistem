<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $kegiatan->nama_kegiatan }} - DEMA FEBI</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">

    {{-- Navbar --}}
    <nav class="bg-white shadow-md px-4 py-3">
        <div class="max-w-4xl mx-auto flex justify-between items-center">
            <a href="{{ route('landing') }}" class="flex items-center gap-2 text-blue-800 font-bold">
                ← Kembali ke Beranda
            </a>
            <a href="{{ url('/admin') }}" 
               class="bg-blue-700 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-800">
                Login Admin
            </a>
        </div>
    </nav>

    {{-- Detail Kegiatan --}}
    <div class="max-w-4xl mx-auto px-4 py-12">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-blue-700 px-8 py-6">
                <span class="text-blue-200 text-sm uppercase tracking-wide">
                    {{ $kegiatan->kategori ?? 'Kegiatan' }}
                </span>
                <h1 class="text-white text-3xl font-bold mt-2">
                    {{ $kegiatan->nama_kegiatan }}
                </h1>
            </div>

            <div class="p-8">
                {{-- Info grid --}}
                <div class="grid grid-cols-2 gap-4 mb-8">
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-gray-400 text-xs uppercase tracking-wide mb-1">Tanggal</p>
                        <p class="font-semibold text-gray-800">
                            {{ $kegiatan->tanggal->format('d F Y, H:i') }} WIB
                        </p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-gray-400 text-xs uppercase tracking-wide mb-1">Lokasi</p>
                        <p class="font-semibold text-gray-800">
                            {{ $kegiatan->lokasi ?? 'Akan diumumkan' }}
                        </p>
                    </div>
                    @if($kegiatan->kuota)
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-gray-400 text-xs uppercase tracking-wide mb-1">Kuota</p>
                        <p class="font-semibold text-gray-800">{{ $kegiatan->kuota }} orang</p>
                    </div>
                    @endif
                    @if($kegiatan->divisi)
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-gray-400 text-xs uppercase tracking-wide mb-1">Penyelenggara</p>
                        <p class="font-semibold text-gray-800">{{ $kegiatan->divisi->nama_divisi }}</p>
                    </div>
                    @endif
                </div>

                {{-- Deskripsi --}}
                @if($kegiatan->deskripsi)
                <div>
                    <h2 class="text-lg font-bold text-gray-800 mb-3">Tentang Kegiatan</h2>
                    <p class="text-gray-600 leading-relaxed">{{ $kegiatan->deskripsi }}</p>
                </div>
                @endif

                {{-- Tombol kembali --}}
                <div class="mt-8">
                    <a href="{{ route('landing') }}"
                       class="bg-blue-700 text-white px-6 py-3 rounded-lg hover:bg-blue-800 transition font-medium">
                        ← Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </div>

</body>
</html>