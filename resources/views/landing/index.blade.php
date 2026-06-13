<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>DEMA FEBI UIN Mahmud Yunus Batusangkar</title>

{{-- Google Fonts --}}
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet">

{{-- Tailwind --}}
<script src="https://cdn.tailwindcss.com"></script>

{{-- AlpineJS --}}
<script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        * { font-family: 'Inter', sans-serif; }
        .hero-gradient { background: linear-gradient(135deg, #0f172a 0%, #1e40af 100%); }
        .card-hover { transition: transform 0.25s ease, box-shadow 0.25s ease; }
        .card-hover:hover { transform: translateY(-5px); box-shadow: 0 20px 40px rgba(0,0,0,0.12); }
    </style>
</head>
<body class="bg-slate-50 text-gray-800">

    {{-- NAVBAR --}}
    <nav class="bg-white/80 backdrop-blur-md shadow-sm sticky top-0 z-50 border-b border-slate-100">
        <div class="max-w-full mx-auto px-10 py-3 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <img src="/images/logo uin.png" class="h-10 w-10 object-contain">
                <img src="/images/logo.png" class="h-10 w-10 rounded-full object-cover">
                <img src="/images/kabinet.png" class="h-10 w-10 rounded-full object-cover">
                <div>
                    <h1 class="font-bold text-slate-800" style="font-family: 'Plus Jakarta Sans', sans-serif;">DEMA FEBI</h1>
                    <p class="text-xs text-slate-400">UIN Mahmud Yunus Batusangkar</p>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <a href="#kegiatan" class="text-slate-500 hover:text-blue-700 text-sm font-medium transition">Kegiatan</a>
                <a href="#kalender" class="text-slate-500 hover:text-blue-700 text-sm font-medium transition">Kalender</a>
                <a href="{{ url('/admin') }}"
                class="bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-800 transition shadow-sm shadow-blue-200">
                    Login Admin
                </a>
            </div>
        </div>
    </nav>

    {{-- HERO SECTION --}}
    <section class="hero-gradient text-white py-20 px-4 relative overflow-hidden">
        <img src="/images/Pengurus DEMA.jpeg" alt=""
            class="absolute inset-0 w-full h-full object-cover opacity-20 mix-blend-luminosity pointer-events-none select-none">
        <img src="/images/pengurus/ketua.png" alt=""
            class="absolute bottom-0 left-4 h-full max-h-72 object-cover object-top opacity-20 mix-blend-luminosity pointer-events-none select-none hidden md:block">
        <img src="/images/pengurus/wakil.png" alt=""
            class="absolute bottom-0 right-4 h-full max-h-72 object-cover object-top opacity-20 mix-blend-luminosity pointer-events-none select-none hidden md:block">

        <div class="max-w-4xl mx-auto text-center relative z-10">
            <span class="inline-block bg-blue-500/20 border border-blue-400/30 text-blue-200 text-xs font-semibold px-4 py-1.5 rounded-full mb-6 tracking-wide uppercase">
                Periode 2025 / 2026
            </span>
            <h1 class="text-4xl md:text-5xl font-extrabold mb-4 leading-tight tracking-tight" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                Dewan Eksekutif Mahasiswa
            </h1>
            <h2 class="text-xl font-semibold mb-6 text-blue-200">
                Fakultas Ekonomi dan Bisnis Islam
            </h2>
            <p class="text-blue-100/80 text-base mb-10 max-w-2xl mx-auto leading-relaxed">
                UIN Mahmud Yunus Batusangkar — Bersama membangun mahasiswa
                yang berkarakter, berprestasi, dan berdedikasi.
            </p>
            <div class="flex justify-center gap-10">
                <div class="text-center">
                    <p class="text-5xl font-extrabold" style="font-family: 'Plus Jakarta Sans', sans-serif;">{{ $totalAnggota }}</p>
                    <p class="text-blue-300 text-sm mt-1 font-medium">Anggota Aktif</p>
                </div>
                <div class="w-px bg-blue-500/40"></div>
                <div class="text-center">
                    <p class="text-5xl font-extrabold" style="font-family: 'Plus Jakarta Sans', sans-serif;">{{ $totalKegiatan }}</p>
                    <p class="text-blue-300 text-sm mt-1 font-medium">Total Kegiatan</p>
                </div>
            </div>
        </div>
    </section>

    {{-- KEGIATAN TERBARU --}}
<section
    id="kegiatan"
    class="py-16 px-4"
    x-data="{
        search: '',
        open: null
    }"
>
    <div class="max-w-4xl mx-auto">

        {{-- Header --}}
        <div class="text-center mb-10">
            <p class="text-blue-600 text-xs font-bold uppercase tracking-widest mb-2">
                Program
            </p>

            <h2
                class="text-3xl font-bold text-slate-800"
                style="font-family: 'Plus Jakarta Sans', sans-serif;"
            >
                Kegiatan Terbaru
            </h2>

            <p class="text-slate-400 mt-2 text-sm">
                Program dan kegiatan DEMA FEBI yang dapat diikuti
            </p>
        </div>

        {{-- Search --}}
        <div class="relative mb-8 max-w-2xl mx-auto">
            <svg
                class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z"
                />
            </svg>

            <input
                type="text"
                x-model="search"
                placeholder="Cari kegiatan..."
                class="w-full pl-12 pr-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:outline-none"
            >
        </div>

        @if($kegiatan->isEmpty())

            <div class="text-center py-12">
                <p class="text-slate-400">
                    Belum ada kegiatan yang dipublikasikan.
                </p>
            </div>

        @else

            <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm">

                @foreach($kegiatan as $index => $item)

                    <div
                        x-data="{
                            nama: @js(strtolower($item->nama_kegiatan)),
                            kategori: @js(strtolower($item->kategori ?? ''))
                        }"
                        x-show="
                            search === '' ||
                            nama.includes(search.toLowerCase()) ||
                            kategori.includes(search.toLowerCase())
                        "
                        class="border-b border-slate-100 last:border-b-0"
                    >

                        {{-- Judul Accordion --}}
                        <button
                            type="button"
                            @click="open === {{ $index }} ? open = null : open = {{ $index }}"
                            class="w-full px-6 py-5 flex items-center justify-between text-left hover:bg-slate-50 transition"
                        >

                            <div>
                                <h3 class="font-semibold text-slate-800">
                                    {{ $item->nama_kegiatan }}
                                </h3>

                                @if($item->kategori)
                                    <p class="text-xs text-slate-400 mt-1">
                                        {{ $item->kategori }}
                                    </p>
                                @endif
                            </div>

                            <svg
                                class="w-5 h-5 text-slate-500 transition-transform duration-300"
                                :class="open === {{ $index }} ? 'rotate-180' : ''"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M19 9l-7 7-7-7"
                                />
                            </svg>

                        </button>

                        {{-- Isi Accordion --}}
                        <div
                            x-show="open === {{ $index }}"
                            x-collapse
                            x-cloak
                            class="px-6 pb-5"
                        >

                            <div class="border-t border-slate-100 pt-4">

                                <p class="text-slate-600 leading-relaxed">
                                    {{ $item->deskripsi ?? 'Belum ada deskripsi kegiatan.' }}
                                </p>

                                <div class="mt-4 space-y-2">

                                    @if($item->tanggal)
                                        <div class="flex items-center gap-2 text-sm text-slate-500">
                                            <span>📅</span>
                                            <span>
                                                {{ \Carbon\Carbon::parse($item->tanggal)->format('d F Y') }}
                                            </span>
                                        </div>
                                    @endif

                                    @if($item->lokasi)
                                        <div class="flex items-center gap-2 text-sm text-slate-500">
                                            <span>📍</span>
                                            <span>{{ $item->lokasi }}</span>
                                        </div>
                                    @endif

                                    @if($item->divisi)
                                        <div class="mt-2">
                                            <span class="inline-flex px-3 py-1 text-xs font-medium bg-blue-50 text-blue-600 rounded-full">
                                                {{ $item->divisi->nama_divisi }}
                                            </span>
                                        </div>
                                    @endif

                                </div>

                                <div class="mt-5">
                                    <a
                                        href="{{ route('kegiatan.detail', $item->id) }}"
                                        class="inline-flex items-center gap-2 text-blue-600 font-medium hover:text-blue-700"
                                    >
                                        Lihat Detail
                                        <span>→</span>
                                    </a>
                                </div>

                            </div>

                        </div>

                    </div>

                @endforeach

            </div>

        @endif

    </div>
</section>

    {{-- KALENDER PROKER --}}
    <section id="kalender" class="py-16 px-4 bg-slate-900">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-10">
                <p class="text-cyan-400 text-xs font-bold uppercase tracking-widest mb-2">Agenda</p>
                <h2 class="text-3xl font-bold text-white" style="font-family: 'Plus Jakarta Sans', sans-serif;">Kalender Program Kerja</h2>
                <p class="text-slate-400 mt-2 text-sm">Jadwal dan agenda kegiatan DEMA FEBI sepanjang tahun</p>
            </div>

            {{-- Header navigasi bulan --}}
            <div class="flex items-center justify-between mb-6">
                <button id="cal-prev" class="text-slate-400 hover:text-cyan-400 transition text-3xl font-light px-3 py-1">&#8249;</button>
                <div class="text-center">
                    <h3 id="cal-month" class="text-cyan-400 text-2xl font-extrabold uppercase tracking-widest" style="font-family: 'Plus Jakarta Sans', sans-serif;"></h3>
                    <p id="cal-year" class="text-white text-lg font-bold"></p>
                </div>
                <button id="cal-next" class="text-slate-400 hover:text-cyan-400 transition text-3xl font-light px-3 py-1">&#8250;</button>
            </div>

            {{-- Header hari --}}
            <div class="grid grid-cols-7 mb-2">
                <div class="text-center text-cyan-400 text-xs font-bold uppercase tracking-wider py-2">Min</div>
                <div class="text-center text-cyan-400 text-xs font-bold uppercase tracking-wider py-2">Sen</div>
                <div class="text-center text-cyan-400 text-xs font-bold uppercase tracking-wider py-2">Sel</div>
                <div class="text-center text-cyan-400 text-xs font-bold uppercase tracking-wider py-2">Rab</div>
                <div class="text-center text-cyan-400 text-xs font-bold uppercase tracking-wider py-2">Kam</div>
                <div class="text-center text-cyan-400 text-xs font-bold uppercase tracking-wider py-2">Jum</div>
                <div class="text-center text-cyan-400 text-xs font-bold uppercase tracking-wider py-2">Sab</div>
            </div>

            {{-- Grid tanggal --}}
            <div id="cal-grid" class="grid grid-cols-7 gap-1"></div>

            {{-- Popup event --}}
            <div id="cal-popup" class="hidden mt-6 bg-slate-800 border border-slate-700 rounded-2xl p-5">
                <h4 class="text-cyan-400 font-bold text-sm uppercase tracking-wider mb-3">Kegiatan</h4>
                <div id="cal-popup-content" class="space-y-2"></div>
            </div>
        </div>
    </section>

    {{-- FOOTER --}}
    <footer class="bg-slate-900 border-t border-slate-800 text-white py-10 px-4">
        <div class="max-w-6xl mx-auto text-center">
            <div class="flex items-center justify-center gap-3 mb-4">
                <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center">
                    <span class="font-bold text-sm" style="font-family: 'Plus Jakarta Sans', sans-serif;">DF</span>
                </div>
                <div class="text-left">
                    <p class="font-bold text-sm" style="font-family: 'Plus Jakarta Sans', sans-serif;">DEMA FEBI</p>
                    <p class="text-slate-500 text-xs">UIN Mahmud Yunus Batusangkar</p>
                </div>
            </div>
            <p class="text-slate-500 text-xs">
                &copy; {{ date('Y') }} DEMA FEBI UIN Mahmud Yunus Batusangkar.
                Sistem Informasi Manajemen Anggota dan Kegiatan.
            </p>
        </div>
    </footer>

    <script>
    (function() {
        const MONTHS = ['JANUARY','FEBRUARY','MARCH','APRIL','MAY','JUNE',
                        'JULY','AUGUST','SEPTEMBER','OCTOBER','NOVEMBER','DECEMBER'];

        let currentDate = new Date();
        let allEvents = [];

        fetch('/kalender-data')
            .then(r => r.json())
            .then(data => { allEvents = data; renderCalendar(); })
            .catch(() => renderCalendar());

        function renderCalendar() {
            const year = currentDate.getFullYear();
            const month = currentDate.getMonth();

            document.getElementById('cal-month').textContent = MONTHS[month];
            document.getElementById('cal-year').textContent = year;

            const grid = document.getElementById('cal-grid');
            grid.innerHTML = '';

            const firstDay = new Date(year, month, 1).getDay();
            const daysInMonth = new Date(year, month + 1, 0).getDate();
            const daysInPrev = new Date(year, month, 0).getDate();
            const today = new Date();

            for (let i = firstDay - 1; i >= 0; i--) {
                grid.appendChild(createCell(daysInPrev - i, true, false, []));
            }

            for (let d = 1; d <= daysInMonth; d++) {
                const dateStr = year + '-' + String(month + 1).padStart(2, '0') + '-' + String(d).padStart(2, '0');
                const isToday = today.getFullYear() === year && today.getMonth() === month && today.getDate() === d;
                const dayEvents = allEvents.filter(e => e.start && e.start.startsWith(dateStr));
                grid.appendChild(createCell(d, false, isToday, dayEvents));
            }

            const totalCells = Math.ceil((firstDay + daysInMonth) / 7) * 7;
            const remaining = totalCells - firstDay - daysInMonth;
            for (let d = 1; d <= remaining; d++) {
                grid.appendChild(createCell(d, true, false, []));
            }

            document.getElementById('cal-popup').classList.add('hidden');
        }

        function createCell(day, isOther, isToday, events) {
            const cell = document.createElement('div');
            cell.style.cssText = 'min-height:64px; border-radius:12px; padding:8px; display:flex; flex-direction:column; position:relative;';

            if (isOther) {
                cell.style.background = 'rgba(30,41,59,0.4)';
                cell.style.opacity = '0.3';
            } else if (isToday) {
                cell.style.background = '#1e293b';
                cell.style.outline = '2px solid #22d3ee';
                cell.style.cursor = 'pointer';
            } else {
                cell.style.background = '#1e293b';
                cell.style.cursor = events.length > 0 ? 'pointer' : 'default';
            }

            if (!isOther) {
                cell.onmouseenter = function() { this.style.background = '#273549'; };
                cell.onmouseleave = function() { this.style.background = isToday ? '#1e293b' : '#1e293b'; };
            }

            const num = document.createElement('span');
            num.textContent = day;
            num.style.cssText = 'font-size:1.1rem; font-weight:700; font-family:"Plus Jakarta Sans",sans-serif;';
            num.style.color = isToday ? '#22d3ee' : '#f1f5f9';
            cell.appendChild(num);

            if (events.length > 0) {
                const dots = document.createElement('div');
                dots.style.cssText = 'margin-top:auto; display:flex; gap:3px; flex-wrap:wrap; padding-top:4px;';
                events.slice(0, 3).forEach(() => {
                    const dot = document.createElement('span');
                    dot.style.cssText = 'width:6px; height:6px; border-radius:50%; background:#22d3ee; display:inline-block;';
                    dots.appendChild(dot);
                });
                cell.appendChild(dots);
                cell.addEventListener('click', () => showEvents(events));
            }

            return cell;
        }

        function showEvents(events) {
            const popup = document.getElementById('cal-popup');
            const content = document.getElementById('cal-popup-content');
            content.innerHTML = '';

            events.forEach(e => {
                const item = document.createElement('div');
                item.style.cssText = 'display:flex; align-items:flex-start; gap:12px; padding:12px; background:#0f172a; border-radius:12px;';
                item.innerHTML =
                    '<span style="width:8px;height:8px;border-radius:50%;background:#22d3ee;margin-top:4px;flex-shrink:0;display:inline-block;"></span>' +
                    '<div>' +
                        '<p style="color:#f1f5f9;font-weight:600;font-size:0.875rem;margin:0;">' + e.title + '</p>' +
                        (e.description ? '<p style="color:#94a3b8;font-size:0.75rem;margin:2px 0 0 0;">' + e.description + '</p>' : '') +
                    '</div>';
                content.appendChild(item);
            });

            popup.classList.remove('hidden');
            popup.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }

        document.getElementById('cal-prev').addEventListener('click', function() {
            currentDate.setMonth(currentDate.getMonth() - 1);
            renderCalendar();
        });

        document.getElementById('cal-next').addEventListener('click', function() {
            currentDate.setMonth(currentDate.getMonth() + 1);
            renderCalendar();
        });
    })();
    </script>

</body>
</html>