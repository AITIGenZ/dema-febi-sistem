<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DEMA FEBI — UIN Mahmud Yunus Batusangkar</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.8/index.global.min.css" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }
        body { background-color: #f5f0e8; font-family: 'Inter', sans-serif; }

        /* PATTERN BACKGROUND */
        .pattern-bg {
            background-color: #f5f0e8;
            background-image: url("data:image/svg+xml,%3Csvg width='80' height='80' viewBox='0 0 80 80' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg stroke='%231a8a8a' stroke-width='0.6' opacity='0.15'%3E%3Crect x='5' y='5' width='30' height='30' rx='2'/%3E%3Crect x='45' y='45' width='30' height='30' rx='2'/%3E%3Cpath d='M5 35 L35 35 L35 5'/%3E%3Cpath d='M45 75 L75 75 L75 45'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        /* HERO FULL SCREEN */
.hero-section {
    min-height: 100vh;
    background-color: #1a7a7a;
    background-image:
        repeating-linear-gradient(
            0deg,
            transparent,
            transparent 3px,
            rgba(0,0,0,0.04) 3px,
            rgba(0,0,0,0.04) 4px
        ),
        repeating-linear-gradient(
            90deg,
            transparent,
            transparent 3px,
            rgba(0,0,0,0.04) 3px,
            rgba(0,0,0,0.04) 4px
        ),
        url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' stroke='%23ffffff' stroke-width='0.4' opacity='0.06'%3E%3Crect x='5' y='5' width='40' height='40' rx='3'/%3E%3Crect x='55' y='55' width='40' height='40' rx='3'/%3E%3Cpath d='M5 45 L45 45 L45 5'/%3E%3Cpath d='M55 95 L95 95 L95 55'/%3E%3C/g%3E%3C/svg%3E");
    position: relative;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

        /* FLOATING NAVBAR */
        .navbar-float {
            position: fixed;
            top: 16px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 100;
            background: white;
            border-radius: 50px;
            padding: 10px 20px;
            display: flex;
            align-items: center;
            gap: 0;
            box-shadow: 0 4px 24px rgba(0,0,0,0.12);
            width: calc(100% - 48px);
            max-width: 900px;
        }
        .nav-brand { display: flex; align-items: center; gap: 10px; text-decoration: none; }
        .nav-brand-text { line-height: 1.2; }
        .nav-brand-title { font-size: 13px; font-weight: 700; color: #1a3a3a; display: block; }
        .nav-brand-sub { font-size: 10px; color: #888; display: block; }
        .nav-menu { display: flex; align-items: center; gap: 4px; margin: 0 auto; background: #f5f0e8; border-radius: 50px; padding: 4px 8px; }
        .nav-menu a { font-size: 12px; font-weight: 600; color: #888; padding: 6px 14px; border-radius: 50px; text-decoration: none; letter-spacing: 0.05em; text-transform: uppercase; transition: all 0.2s; }
        .nav-menu a:hover, .nav-menu a.active { color: #1a7a7a; background: white; }
        .nav-cta { background: #f5f0e8; border: 1.5px solid #e0d8c8; color: #1a3a3a; font-size: 12px; font-weight: 600; padding: 8px 20px; border-radius: 50px; text-decoration: none; white-space: nowrap; transition: all 0.2s; }
        .nav-cta:hover { background: #1a7a7a; color: white; border-color: #1a7a7a; }

        /* HERO TEXT */
.hero-title {
    font-size: clamp(60px, 12vw, 110px);
    font-weight: 700;
    line-height: 1;
    text-align: center;
    letter-spacing: -2px;
    user-select: none;
    background: linear-gradient(
        105deg,
        rgba(255,255,255,0.15) 0%,
        rgba(255,255,255,0.15) 30%,
        rgba(255,255,255,0.80) 48%,
        rgba(255,255,255,0.95) 50%,
        rgba(255,255,255,0.80) 52%,
        rgba(255,255,255,0.15) 70%,
        rgba(255,255,255,0.15) 100%
    );
    background-size: 300% 100%;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    animation: shimmer 12s ease-in-out infinite;
}
.hero-title span {
    -webkit-text-fill-color: transparent;
}
@keyframes shimmer {
    50%   { background-position: 200% center; }
    100% { background-position: -200% center; }
}
        .hero-subtitle { text-align: center; margin-top: 32px; }
        .hero-subtitle h2 { font-size: 20px; font-weight: 600; color: white; }
        .hero-subtitle p { font-size: 14px; color: rgba(255,255,255,0.65); margin-top: 6px; }

        /* HERO STATS */
        .hero-stats { display: flex; gap: 48px; margin-top: 40px; }
        .hstat { text-align: center; }
        .hstat-num { font-size: 36px; font-weight: 700; color: white; line-height: 1; }
        .hstat-lbl { font-size: 12px; color: rgba(255,255,255,0.55); margin-top: 4px; letter-spacing: 0.05em; text-transform: uppercase; }
        .hstat-divider { width: 1px; background: rgba(255,255,255,0.2); }

        /* HERO BTN */
        .hero-btn { margin-top: 36px; display: flex; gap: 12px; }
        .btn-primary { background: white; color: #1a7a7a; font-size: 13px; font-weight: 600; padding: 12px 28px; border-radius: 50px; text-decoration: none; transition: all 0.2s; }
        .btn-primary:hover { background: #f0fafa; }
        .btn-outline { background: transparent; color: white; font-size: 13px; font-weight: 600; padding: 12px 28px; border-radius: 50px; border: 1.5px solid rgba(255,255,255,0.4); text-decoration: none; transition: all 0.2s; }
        .btn-outline:hover { background: rgba(255,255,255,0.1); }

        /* SECTION STYLES */
        .section-label { font-size: 12px; font-weight: 700; color: #1a7a7a; letter-spacing: 0.1em; text-transform: uppercase; margin-bottom: 8px; display: block; }
        .section-title { font-size: 36px; font-weight: 700; color: #1a3a3a; line-height: 1.2; }
        .section-title span { color: #1a7a7a; }
        .section-desc { font-size: 14px; color: #888; margin-top: 8px; line-height: 1.7; }

        /* WELCOMING SECTION */
        .welcoming-section { padding: 100px 24px 80px; }
        .welcoming-title { font-size: clamp(36px, 6vw, 64px); font-weight: 700; color: #1a7a7a; line-height: 1.1; }
        .envelope-wrap { position: relative; }
        .speech-card { background: white; border-radius: 16px; padding: 28px; box-shadow: 0 8px 32px rgba(0,0,0,0.08); border: 0.5px solid #e8e4dc; }
        .speech-card p { font-size: 14px; color: #555; line-height: 1.8; margin-bottom: 8px; }
        .speech-card .ketua-name { font-weight: 700; color: #1a3a3a; font-size: 15px; }
        .speech-card .ketua-title { font-size: 12px; color: #1a7a7a; }

        /* EVENTS SECTION */
        .events-section { padding: 80px 24px; }
        .event-card { background: white; border-radius: 16px; overflow: hidden; display: flex; box-shadow: 0 2px 12px rgba(0,0,0,0.06); border: 0.5px solid #e8e4dc; transition: all 0.2s; text-decoration: none; }
        .event-card:hover { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(0,0,0,0.1); }
        .event-card-thumb { width: 160px; min-height: 200px; flex-shrink: 0; background: linear-gradient(160deg, #1a9a9a, #0f6060); }
        .event-card-body { padding: 24px; flex: 1; }
        .event-tags { display: flex; flex-wrap: wrap; gap: 6px; margin: 10px 0; }
        .event-tag { font-size: 11px; border: 1px solid #c8e8e8; color: #1a7a7a; padding: 3px 10px; border-radius: 50px; background: transparent; }
        .event-title { font-size: 18px; font-weight: 700; color: #1a3a3a; line-height: 1.3; margin: 0; }
        .event-desc { font-size: 13px; color: #888; margin-top: 10px; line-height: 1.6; }
        .event-status { display: inline-block; margin-top: 20px; padding: 7px 20px; border-radius: 8px; font-size: 12px; font-weight: 600; background: #f0f0f0; color: #999; }
        .event-status.open { background: #e8faf5; color: #1a7a7a; }

        /* NEWS SECTION */
        .news-section { padding: 80px 24px; }
        .news-card { background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 2px 12px rgba(0,0,0,0.06); border: 0.5px solid #e8e4dc; transition: all 0.2s; text-decoration: none; display: block; }
        .news-card:hover { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(0,0,0,0.1); }
        .news-thumb { height: 200px; background: #c8e8e8; position: relative; overflow: hidden; }
        .news-thumb img { width: 100%; height: 100%; object-fit: cover; }
        .news-badge { position: absolute; top: 12px; right: 12px; background: #1a3a3a; color: white; font-size: 10px; font-weight: 700; padding: 4px 12px; border-radius: 6px; letter-spacing: 0.08em; text-transform: uppercase; }
        .news-body { padding: 20px; }
        .news-date { font-size: 12px; color: #aaa; margin-bottom: 8px; }
        .news-title { font-size: 15px; font-weight: 700; color: #1a3a3a; line-height: 1.4; margin-bottom: 8px; }
        .news-excerpt { font-size: 13px; color: #888; line-height: 1.6; }

        /* KALENDER */
        .kalender-section { padding: 80px 24px; background: white; }
        .fc .fc-toolbar-title { font-size: 16px !important; font-weight: 700; color: #1a3a3a; }
        .fc .fc-button { background: #1a7a7a !important; border-color: #1a7a7a !important; font-size: 12px !important; }
        .fc .fc-button:hover { background: #0f6060 !important; }
        .fc-event { border-radius: 4px !important; font-size: 11px !important; }

        /* VIEW ALL LINK */
        .view-all { font-size: 13px; font-weight: 600; color: #1a7a7a; text-decoration: none; }
        .view-all:hover { text-decoration: underline; }

        /* FOOTER */
        .footer { background: #1a2a2a; padding: 60px 24px 24px; }
        .footer-logo-text { font-size: 15px; font-weight: 700; color: white; }
        .footer-logo-sub { font-size: 11px; color: #888; }
        .footer-social a { width: 36px; height: 36px; border-radius: 50%; background: #2a3a3a; display: inline-flex; align-items: center; justify-content: center; color: #aaa; font-size: 14px; text-decoration: none; transition: all 0.2s; margin-right: 8px; }
        .footer-social a:hover { background: #1a7a7a; color: white; }
        .footer-col h4 { font-size: 13px; font-weight: 700; color: #1a7a7a; margin-bottom: 16px; letter-spacing: 0.05em; }
        .footer-col a { display: block; font-size: 13px; color: #aaa; text-decoration: none; margin-bottom: 10px; transition: color 0.2s; }
        .footer-col a:hover { color: white; }
        .footer-col p { font-size: 13px; color: #aaa; line-height: 1.7; }
        .footer-bottom { border-top: 1px solid #2a3a3a; margin-top: 48px; padding-top: 20px; text-align: center; font-size: 12px; color: #555; }
        .footer-bottom span { color: #1a7a7a; }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .nav-menu { display: none; }
            .hero-stats { gap: 24px; }
            .hstat-num { font-size: 28px; }
            .event-card { flex-direction: column; }
            .event-card-thumb { width: 100%; min-height: 140px; }
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

    {{-- NAVBAR --}}
    <nav class="bg-white shadow-md sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-4 py-3 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <img src="/images/logo.png" class="h-10 w-10 rounded-full object-cover">
                <img src="/images/kabinet.png" class="h-10 w-10 rounded-full object-cover">
                <div>
                    <h1 class="font-bold">DEMA FEBI</h1>
                    <p class="text-sm text-gray-500">UIN Mahmud Yunus Batusangkar</p>
                </div>
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
    <section class="hero-gradient text-white py-20 px-4">
        <div class="max-w-4xl mx-auto text-center">
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
                {{-- Speech card --}}
                <div class="speech-card">
                    <p style="font-style: italic; color: #1a7a7a; font-weight: 600; font-size: 15px;">"Bersama membangun FEBI yang berkarakter dan berprestasi."</p>
                    <p>Assalamu'alaikum Wr. Wb. Selamat datang di SIMA DEMA FEBI — platform resmi kami untuk mengelola dan menginformasikan kegiatan, anggota, dan program kerja DEMA FEBI UIN Mahmud Yunus Batusangkar.</p>
                    <p>Mari bersama kita wujudkan mahasiswa FEBI yang unggul, berdedikasi, dan mampu memberikan kontribusi nyata bagi kampus dan masyarakat.</p>
                    <div style="border-top: 1px solid #f0ece4; margin-top: 20px; padding-top: 16px;">
                        <div class="ketua-name">Ketua DEMA FEBI</div>
                        <div class="ketua-title">Periode 2024/2025</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- LATEST EVENTS / KEGIATAN --}}
    <section id="kegiatan" class="events-section pattern-bg">
        <div class="max-w-5xl mx-auto">
            <div class="flex justify-between items-end mb-10">
                <div>
                    <span class="section-label">Program kerja</span>
                    <h2 class="section-title">Kegiatan <span>Terbaru</span></h2>
                    <p class="section-desc">Ikuti dan daftarkan diri kamu pada kegiatan DEMA FEBI.</p>
                </div>
                <a href="#" class="view-all">Lihat semua →</a>
            </div>

            @if($kegiatan->isEmpty())
                <div style="text-align:center; padding: 60px; color: #aaa; background: white; border-radius: 16px;">
                    <p style="font-size: 15px;">Belum ada kegiatan yang dipublikasikan.</p>
                </div>
            @else
                <div style="display: flex; flex-direction: column; gap: 16px;">
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
                                    <span class="event-tag">📍 {{ $item->lokasi }}</span>
                                @endif
                            </div>
                            <div class="event-desc">{{ Str::limit($item->deskripsi, 120) ?? 'Kegiatan DEMA FEBI UIN Mahmud Yunus Batusangkar.' }}</div>
                            @if($item->kuota && $item->kuota > 0)
                                <span class="event-status open">Buka pendaftaran</span>
                            @else
                                <span class="event-status">Selesai</span>
                            @endif
                        </div>
                    </a>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    {{-- LATEST NEWS / BERITA --}}
    <section class="news-section" style="background: #eee8d8;">
        <div class="max-w-5xl mx-auto">
            <div class="flex justify-between items-end mb-10">
                <div>
                    <span class="section-label">Informasi</span>
                    <h2 class="section-title">Berita <span>Terkini</span></h2>
                    <p class="section-desc">Update terbaru dari kegiatan dan program DEMA FEBI.</p>
                </div>
            </div>

            @if($kegiatan->isEmpty())
                <div style="text-align:center; padding: 60px; color: #aaa; background: white; border-radius: 16px;">
                    <p>Belum ada berita.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($kegiatan->take(3) as $item)
                    <a href="{{ route('kegiatan.detail', $item->id) }}" class="news-card">
                        <div class="news-thumb">
                            <div style="width:100%; height:100%; background: linear-gradient(160deg, {{ ['#1a9a9a','#2563eb','#7c3aed'][($loop->index % 3)] }}, {{ ['#0f6060','#1d4ed8','#5b21b6'][($loop->index % 3)] }});"></div>
                            <div class="news-badge">{{ strtoupper($item->kategori ?? 'Proker') }}</div>
                        </div>
                        <div class="news-body">
                            <div class="news-date">{{ $item->tanggal->format('d M Y') }}</div>
                            <div class="news-title">{{ $item->nama_kegiatan }}</div>
                            <div class="news-excerpt">{{ Str::limit($item->deskripsi, 100) ?? 'Kegiatan DEMA FEBI UIN Mahmud Yunus Batusangkar.' }}</div>
                        </div>
                    </a>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    {{-- KALENDER PROKER --}}
    <section id="kalender" class="kalender-section">
        <div class="max-w-5xl mx-auto">
            <div class="mb-10">
                <span class="section-label">Jadwal</span>
                <h2 class="section-title">Kalender <span>Program Kerja</span></h2>
                <p class="section-desc">Agenda dan jadwal kegiatan DEMA FEBI sepanjang periode kepengurusan.</p>
            </div>
            <div id="kalender-container" style="background: #fafafa; border-radius: 16px; border: 1px solid #e8e4dc; padding: 20px;"></div>
        </div>
    </section>

    {{-- FOOTER --}}
    <footer class="footer">
        <div class="max-w-5xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                {{-- Brand + Social --}}
                <div>
                    <div style="display:flex; align-items:center; gap:10px; margin-bottom:12px;">
                        <img src="/images/logo.png" class="h-9 w-9 rounded-full object-cover" onerror="this.style.display='none'">
                        <div>
                            <div class="footer-logo-text">DEMA FEBI</div>
                            <div class="footer-logo-sub">UIN Mahmud Yunus Batusangkar</div>
                        </div>
                    </div>
                    <p style="font-size:13px; color:#888; line-height:1.7; margin-bottom:16px;">
                        Sistem Informasi Manajemen Anggota dan Kegiatan DEMA FEBI.
                    </p>
                    <div class="footer-social">
                        <a href="#" title="Instagram">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                        <a href="#" title="YouTube">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/></svg>
                        </a>
                    </div>
                </div>

                {{-- Links --}}
                <div class="footer-col">
                    <h4>Links</h4>
                    <a href="{{ url('/') }}">Home</a>
                    <a href="#kegiatan">Kegiatan</a>
                    <a href="#sambutan">Sambutan</a>
                    <a href="#kalender">Kalender</a>
                </div>

                {{-- Quick Link --}}
                <div class="footer-col">
                    <h4>Quick Link</h4>
                    <a href="{{ url('/admin') }}">Login Admin</a>
                    <a href="{{ url('/admin') }}">SIMA DEMA FEBI</a>
                </div>

                {{-- Address --}}
                <div class="footer-col">
                    <h4>Alamat</h4>
                    <p>Gedung FEBI, UIN Mahmud Yunus Batusangkar,<br>Jl. Sudirman No. 137, Batusangkar,<br>Sumatera Barat.</p>
                    <h4 style="margin-top: 20px;">Kontak</h4>
                    <p>Email: demafebiunmayaba@gmail.com</p>
                </div>
            </div>

            <div class="footer-bottom">
                © {{ date('Y') }} DEMA FEBI UIN Mahmud Yunus Batusangkar. Dibuat dengan ❤️ oleh <span>Tim IT DEMA FEBI</span>.
            </div>
        </div>
    </footer>

    {{-- FullCalendar --}}
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
                    alert(info.event.title + '\nPenyelenggara: ' + (info.event.extendedProps.description || 'DEMA FEBI'));
                },
                height: 'auto',
                buttonText: { today: 'Hari Ini', month: 'Bulan', list: 'Agenda' }
            });
            calendar.render();
        });
    </script>

</body>
</html>
