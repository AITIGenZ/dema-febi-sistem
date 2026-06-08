<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DEMA FEBI UIN Mahmud Yunus Batusangkar</title>

    {{-- Tailwind CSS via CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- FullCalendar CSS --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.8/index.global.min.css" rel="stylesheet">

    <style>
        .hero-gradient {
            background: linear-gradient(135deg, #1e3a5f 0%, #2563eb 100%);
        }
        .card-hover {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }
        .fc-event { cursor: pointer; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

    {{-- NAVBAR --}}
    <nav class="bg-white shadow-md sticky top-0 z-50">
        <div class="max-w-full mx-auto px-10 py-3 flex items-center">
            <div class="flex items-center gap-3">
                <img src="/images/logo.png" class="h-10 w-10 rounded-full object-cover">
                <img src="/images/kabinet.png" class="h-10 w-10 rounded-full object-cover">
                <div>
                    <h1 class ="font-bold">DEMA FEBI</h1>
                    <p class="text-sm text-gray-500">UIN Mahmud Yunus Batusangkar</p>
            </div>
            
            <div class="flex items-center gap-4">
                <a href="#kegiatan" class="text-gray-600 hover:text-blue-700 text-sm font-medium">Kegiatan</a>
                <a href="#kalender" class="text-gray-600 hover:text-blue-700 text-sm font-medium">Kalender</a>
                <a href="{{ url('/admin') }}" 
                   class="bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-800 transition">
                    Login Admin
                </a>
            </div>
        </div>
    </nav>

    {{-- HERO SECTION --}}
    <<section class="hero-gradient text-white py-20 px-4 relative overflow-hidden">

    {{-- Foto Pengurus (letakkan foto di public/images/pengurus/) --}}
    <img src="/images/pengurus/ketua.png" alt=""
         class="absolute bottom-0 left-4 h-full max-h-72 object-cover object-top opacity-20 mix-blend-luminosity pointer-events-none select-none hidden md:block">
    <img src="/images/pengurus/wakil.png" alt=""
         class="absolute bottom-0 right-4 h-full max-h-72 object-cover object-top opacity-20 mix-blend-luminosity pointer-events-none select-none hidden md:block">

    <div class="max-w-4xl mx-auto text-center relative z-10">
            <h1 class="text-4xl font-bold mb-4">
                Dewan Eksekutif Mahasiswa
            </h1>
            <h2 class="text-2xl font-semibold mb-6 text-blue-200">
                Fakultas Ekonomi dan Bisnis Islam
            </h2>
            <p class="text-blue-100 text-lg mb-8 max-w-2xl mx-auto">
                UIN Mahmud Yunus Batusangkar — Bersama membangun mahasiswa 
                yang berkarakter, berprestasi dan berdedikasi.
            </p>
            <div class="flex justify-center gap-8">
                <div class="text-center">
                    <p class="text-4xl font-bold">{{ $totalAnggota }}</p>
                    <p class="text-blue-200 text-sm mt-1">Anggota Aktif</p>
                </div>
                <div class="w-px bg-blue-400"></div>
                <div class="text-center">
                    <p class="text-4xl font-bold">{{ $totalKegiatan }}</p>
                    <p class="text-blue-200 text-sm mt-1">Total Kegiatan</p>
                </div>
            </div>
        </div>
    </section>

    {{-- KEGIATAN TERBARU --}}
    <section id="kegiatan" class="py-16 px-4">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-10">
                <h2 class="text-3xl font-bold text-gray-800">Kegiatan Terbaru</h2>
                <p class="text-gray-500 mt-2">Program dan kegiatan DEMA FEBI yang dapat diikuti</p>
            </div>

            @if($kegiatan->isEmpty())
                <div class="text-center py-12 text-gray-400">
                    <p class="text-lg">Belum ada kegiatan yang dipublikasikan</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($kegiatan as $item)
                    <a href="{{ route('kegiatan.detail', $item->id) }}"
                       class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden card-hover block">
                        {{-- Header card --}}
                        <div class="bg-blue-700 px-5 py-3">
                            <span class="text-white text-xs font-medium uppercase tracking-wide">
                                {{ $item->kategori ?? 'Kegiatan' }}
                            </span>
                        </div>
                        <div class="p-5">
                            <h3 class="font-bold text-gray-800 text-lg mb-2 line-clamp-2">
                                {{ $item->nama_kegiatan }}
                            </h3>
                            <p class="text-gray-500 text-sm mb-3 line-clamp-2">
                                {{ $item->deskripsi ?? 'Kegiatan DEMA FEBI UIN Mahmud Yunus Batusangkar' }}
                            </p>
                            <div class="flex items-center gap-4 text-xs text-gray-400 mt-4">
                                <span class="flex items-center gap-1">
                                    📅 {{ $item->tanggal->format('d M Y') }}
                                </span>
                                @if($item->lokasi)
                                <span class="flex items-center gap-1">
                                    📍 {{ $item->lokasi }}
                                </span>
                                @endif
                            </div>
                            @if($item->divisi)
                            <div class="mt-3">
                                <span class="bg-blue-50 text-blue-700 text-xs px-3 py-1 rounded-full font-medium">
                                    {{ $item->divisi->nama_divisi }}
                                </span>
                            </div>
                            @endif
                        </div>
                    </a>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    {{-- KALENDER PROKER --}}
    <section id="kalender" class="py-16 px-4 bg-white">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-10">
                <h2 class="text-3xl font-bold text-gray-800">Kalender Program Kerja</h2>
                <p class="text-gray-500 mt-2">Agenda dan jadwal kegiatan DEMA FEBI sepanjang tahun</p>
            </div>
            <div id="kalender-container" class="bg-white rounded-xl shadow-sm border border-gray-100 p-4"></div>
        </div>
    </section>

    {{-- FOOTER --}}
    <footer class="bg-gray-800 text-white py-10 px-4">
        <div class="max-w-6xl mx-auto text-center">
            <div class="flex items-center justify-center gap-3 mb-4">
                <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center">
                    <span class="font-bold text-sm">DF</span>
                </div>
                <div class="text-left">
                    <p class="font-bold">DEMA FEBI</p>
                    <p class="text-gray-400 text-xs">UIN Mahmud Yunus Batusangkar</p>
                </div>
            </div>
            <p class="text-gray-400 text-sm">
                &copy; {{ date('Y') }} DEMA FEBI UIN Mahmud Yunus Batusangkar. 
                Sistem Informasi Manajemen Anggota dan Kegiatan.
            </p>
        </div>
    </footer>

    {{-- FullCalendar JS --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.8/index.global.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('kalender-container');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'id',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,listWeek'
                },
                events: '{{ route("kalender.data") }}',
                eventClick: function(info) {
                    alert(
                        info.event.title + '\n' +
                        'Penyelenggara: ' + (info.event.extendedProps.description || 'DEMA FEBI')
                    );
                },
                height: 'auto',
                buttonText: {
                    today: 'Hari Ini',
                    month: 'Bulan',
                    list: 'Agenda'
                }
            });
            calendar.render();
        });
    </script>

</body>
</html>