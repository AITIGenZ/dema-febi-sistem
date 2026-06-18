<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DEMA FEBI — UIN Mahmud Yunus Batusangkar</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.8/index.global.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --teal:      #1a7a7a;
            --teal-dark: #0f5858;
            --teal-mid:  #1a9090;
            --cream:     #f5f0e8;
            --cream2:    #eee8d8;
            --dark:      #1a2a2a;
            --text:      #3a4a4a;
            --muted:     #7a9090;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--cream); color: var(--text); }

        /* ===== NAVBAR ===== */
        .navbar {
            position: fixed; top: 0; left: 0; right: 0; z-index: 100;
            display: flex; align-items: center; justify-content: space-between;
            padding: 20px 52px;
            transition: all 0.35s;
        }
        .navbar.scrolled {
            background: rgba(15, 40, 40, 0.94);
            backdrop-filter: blur(14px);
            padding: 14px 52px;
            box-shadow: 0 2px 30px rgba(0,0,0,0.3);
        }
        .nav-brand { display: flex; align-items: center; gap: 14px; text-decoration: none; }

        /* KOTAK PUTIH PANJANG (WADAH GABUNGAN KETIGA LOGO) */
        .nav-logo-box {
            display: flex;
            align-items: center;
            gap: 10px;
            background-color: #ffffff !important;
            padding: 4px 10px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
            height: 40px;
        }

        /* SETTING DASAR UNTUK SEMUA LOGO DI DALAM KOTAK */
        .nav-logo-box img { 
            height: 30px;
            object-fit: contain;
            border: none !important;
        }

        /* KHUSUS LOGO UIN (Bentuk Asli / Kotak Perisai) */
        .nav-logo-box img.logo-asli {
            width: auto;
            border-radius: 0% !important;
        }

        /* KHUSUS LOGO KABINET & DEMA (Dipaksa Bulat Sempurna) */
        .nav-logo-box img.logo-bulat {
            width: 30px;
            object-fit: cover;
            border-radius: 50% !important;
        }

        .nav-brand-name { font-size: 13px; font-weight: 800; color: white; letter-spacing: 0.02em; line-height: 1.2; }
        .nav-brand-sub  { font-size: 9px; color: rgba(255,255,255,0.45); }
        .nav-links { display: flex; align-items: center; gap: 4px; }
        .nav-links a { font-size: 11px; font-weight: 700; color: rgba(255,255,255,0.65); padding: 8px 16px; border-radius: 50px; text-decoration: none; letter-spacing: 0.07em; text-transform: uppercase; transition: all 0.2s; }
        .nav-links a:hover { color: white; background: rgba(255,255,255,0.1); }
        .nav-cta { background: white !important; color: var(--teal-dark) !important; font-weight: 800 !important; border-radius: 50px; padding: 9px 22px !important; }
        .nav-cta:hover { background: #e0f5f5 !important; transform: translateY(-1px); }
        
        /* ===== HERO ===== */
        .hero {
            min-height: 100vh;
            position: relative;
            display: flex; flex-direction: column;
            align-items: center; justify-content: center;
            overflow: hidden;
            background-color: #0c4e4e;
            background-image:
                linear-gradient(rgba(255,255,255,0.035) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.035) 1px, transparent 1px),
                repeating-linear-gradient(45deg, transparent, transparent 40px, rgba(255,255,255,0.012) 40px, rgba(255,255,255,0.012) 41px),
                radial-gradient(ellipse 75% 55% at 50% 55%, rgba(26,160,160,0.3) 0%, transparent 70%),
                linear-gradient(155deg, #083838 0%, #1a7a7a 45%, #0d5050 75%, #061818 100%);
            background-size: 56px 56px, 56px 56px, auto, auto, auto;
        }
        .hero-ornament {
            position: absolute; pointer-events: none;
            background-image: url("data:image/svg+xml,%3Csvg width='160' height='160' viewBox='0 0 160 160' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' stroke='%23ffffff' stroke-width='1' opacity='0.07'%3E%3Crect x='10' y='10' width='60' height='60' rx='6'/%3E%3Crect x='90' y='90' width='60' height='60' rx='6'/%3E%3Cpath d='M10 70 L70 70 L70 10'/%3E%3Cpath d='M90 150 L150 150 L150 90'/%3E%3Cline x1='10' y1='10' x2='70' y2='70'/%3E%3Cline x1='90' y1='90' x2='150' y2='150'/%3E%3C/g%3E%3C/svg%3E");
            background-size: 160px;
        }
        .hero-ornament-bl { bottom: -20px; left: -20px; width: 480px; height: 480px; opacity: .7; }
        .hero-ornament-tr { top: -20px; right: -20px; width: 380px; height: 380px; opacity: .4; transform: rotate(180deg); }

        .hero-title {
            font-size: clamp(80px, 15vw, 170px);
            font-weight: 900;
            line-height: .88;
            text-align: center;
            letter-spacing: -5px;
            position: relative; z-index: 2;
            background: linear-gradient(135deg,
                rgba(255,255,255,0.10) 0%,
                rgba(160,235,235,0.65) 22%,
                rgba(255,255,255,0.97) 50%,
                rgba(160,235,235,0.65) 78%,
                rgba(255,255,255,0.10) 100%);
            background-size: 400% 100%;
            -webkit-background-clip: text; background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: shimmer 9s ease-in-out infinite;
            user-select: none;
        }
        .hero-title .l2 {
            display: block;
            background: linear-gradient(135deg,
                rgba(100,210,210,0.45) 0%,
                rgba(255,255,255,0.98) 42%,
                rgba(100,210,210,0.75) 72%,
                rgba(100,210,210,0.45) 100%);
            background-size: 400% 100%;
            -webkit-background-clip: text; background-clip: text;
            animation: shimmer 9s ease-in-out infinite reverse;
        }
        @keyframes shimmer {
            0%,100% { background-position: 0% center; }
            50%      { background-position: 200% center; }
        }

        .hero-tagline {
            position: relative; z-index: 2;
            text-align: center; margin-top: 24px;
            font-size: 14px; font-weight: 500;
            color: rgba(255,255,255,0.6); letter-spacing: .04em; line-height: 1.7;
        }
        .hero-tagline strong { color: rgba(255,255,255,.9); font-weight: 700; }

        .hero-stats {
            position: relative; z-index: 2;
            display: flex; align-items: stretch;
            margin-top: 44px;
            background: rgba(255,255,255,0.07);
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 16px; overflow: hidden;
            backdrop-filter: blur(8px);
        }
        .hstat { padding: 20px 40px; text-align: center; border-right: 1px solid rgba(255,255,255,0.1); }
        .hstat:last-child { border-right: none; }
        .hstat-num { font-size: 30px; font-weight: 800; color: white; line-height: 1; }
        .hstat-lbl { font-size: 10px; font-weight: 700; color: rgba(255,255,255,.45); letter-spacing: .12em; text-transform: uppercase; margin-top: 5px; }

        .hero-btns { position: relative; z-index: 2; display: flex; gap: 12px; margin-top: 32px; }
        .hbtn-white { background: white; color: var(--teal-dark); font-size: 13px; font-weight: 700; padding: 13px 30px; border-radius: 50px; text-decoration: none; transition: all .2s; box-shadow: 0 4px 20px rgba(0,0,0,.2); }
        .hbtn-white:hover { transform: translateY(-2px); box-shadow: 0 8px 28px rgba(0,0,0,.25); }
        .hbtn-ghost { background: rgba(255,255,255,.1); color: white; font-size: 13px; font-weight: 600; padding: 13px 30px; border-radius: 50px; border: 1.5px solid rgba(255,255,255,.3); text-decoration: none; transition: all .2s; backdrop-filter: blur(4px); }
        .hbtn-ghost:hover { background: rgba(255,255,255,.18); transform: translateY(-2px); }

        .hero-scroll {
            position: absolute; bottom: 28px; left: 50%; transform: translateX(-50%);
            z-index: 2; display: flex; flex-direction: column; align-items: center; gap: 5px;
            color: rgba(255,255,255,.35); font-size: 10px; font-weight: 700;
            letter-spacing: .12em; text-transform: uppercase;
            animation: bob 2.2s ease-in-out infinite;
        }
        @keyframes bob { 0%,100%{transform:translateX(-50%) translateY(0)} 50%{transform:translateX(-50%) translateY(7px)} }

        /* ===== SECTION COMMONS ===== */
        .sec-label { font-size: 10px; font-weight: 800; color: var(--teal); letter-spacing: .18em; text-transform: uppercase; display: block; margin-bottom: 10px; }
        .sec-title  { font-size: clamp(28px,4vw,42px); font-weight: 800; color: var(--dark); letter-spacing: -.5px; line-height: 1.1; }
        .sec-title span { color: var(--teal); }
        .sec-desc   { font-size: 14px; color: var(--muted); margin-top: 6px; line-height: 1.75; }
        .sec-header { display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 40px; }
        .view-all   { font-size: 11px; font-weight: 800; color: var(--teal); text-decoration: none; letter-spacing: .07em; text-transform: uppercase; white-space: nowrap; }
        .view-all:hover { text-decoration: underline; }

        /* ===== WELCOMING SPEECH (FIXED) ===== */
        .welcoming { padding: 110px 52px; background: var(--cream); overflow: hidden; }
        .welcoming-inner { max-width: 1080px; margin: 0 auto; display: grid; grid-template-columns: 1fr 1.1fr; gap: 60px; align-items: center; }
        .wleft-title { font-size: clamp(42px,6vw,72px); font-weight: 900; color: var(--teal); line-height: 1; letter-spacing: -2px; margin-bottom: 20px; }
        .wleft-desc { font-size: 14px; color: var(--muted); line-height: 1.8; }

        /* AREA STRUKTUR KANAN KARTU FLIP */
        .wright { 
            position: relative; 
            perspective: 1200px; 
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        .speech-card-wrap {
            width: 100%;
            max-width: 490px;
            height: 290px;
            cursor: pointer;
            position: relative;
        }
        .speech-card-inner {
            position: relative;
            width: 100%;
            height: 100%;
            transform-style: preserve-3d;
            transition: transform .8s cubic-bezier(.4,0,.2,1);
        }
        
        /* Trigger Class saat diklik */
        .speech-card-wrap.flipped .speech-card-inner { 
            transform: rotateY(180deg); 
        }

        /* FIX CHROMIUM BUG: Bungkus tambahan untuk mengisolasi 3D agar backface-visibility berfungsi */
        .speech-front, .speech-back {
            position: absolute; top: 0; left: 0; width: 100%; height: 100%;
            background: white;
            border-radius: 20px;
            box-shadow: 0 12px 40px rgba(26,122,122,0.1);
            border: 1px solid rgba(26,122,122,0.08);
            backface-visibility: hidden;
            -webkit-backface-visibility: hidden;
        }
        
        /* HALAMAN DEPAN: Kolom 1 murni space kosong agar teks terdorong otomatis */
        .speech-front {
            display: grid;
            grid-template-columns: 145px 1fr;
            gap: 15px;
            padding: 28px 30px 28px 10px;
        }

        /* HALAMAN BELAKANG: Diputar 180 derajat */
        .speech-back {
            transform: rotateY(180deg);
            padding: 28px 30px;
        }

        /* TEMPAT TEXT */
        .speech-text-content {
            z-index: 5;
        }
        .speech-front .speech-text-content {
            grid-column: 2; /* Memaksa teks hanya mengisi kolom kedua */
        }
        .speech-back .speech-text-content {
            width: 100%;
        }

        /* FOTO KETUM: absolute terhadap halaman depan, tidak akan menabrak teks kolom 2 */
        .ketum-cutout-wrap {
            position: absolute;
            bottom: 0;          
            left: 10px;         
            width: 150px;       
            height: 350px;      
            z-index: 10;
            pointer-events: none;
            display: flex;
            align-items: flex-end;
        }
        .ketum-png {
            width: 100%;
            height: auto;
            max-height: 100%;
            object-fit: contain;
            filter: drop-shadow(-6px 10px 10px rgba(0, 0, 0, 0.12));
        }

        .speech-quote-text { font-size: 14px; font-weight: 700; color: var(--teal); font-style: italic; line-height: 1.4; margin-bottom: 8px; }
        .speech-body-text { font-size: 12px; color: #666; line-height: 1.6; }
        .speech-hr { border: none; border-top: 1px solid #f0ece4; margin: 10px 0; }
        .speech-name { font-size: 13px; font-weight: 800; color: var(--dark); }
        .speech-role { font-size: 11px; color: var(--teal); margin-top: 2px; }
        .tap-hint { text-align: center; font-size: 11px; color: var(--muted); margin-top: 15px; letter-spacing: .04em; }

        /* ===== KEGIATAN ===== */
        .kegiatan-sec { padding: 90px 52px; background: var(--cream2); }
        .kegiatan-sec .inner { max-width: 1080px; margin: 0 auto; }

        .event-card {
            background: white; border-radius: 18px; overflow: hidden;
            display: flex; text-decoration: none; margin-bottom: 18px;
            box-shadow: 0 2px 20px rgba(0,0,0,0.055);
            border: 1px solid rgba(26,122,122,0.07);
            transition: all .25s;
        }
        .event-card:hover { transform: translateY(-4px); box-shadow: 0 14px 36px rgba(26,122,122,0.14); }
        .event-thumb {
            width: 180px; flex-shrink: 0;
            background: linear-gradient(145deg, #1a9a9a, #0f5858);
            position: relative; overflow: hidden; min-height: 180px;
        }
        .event-thumb-alt { background: linear-gradient(145deg, #2563eb, #1d4ed8); }
        .event-thumb-alt2 { background: linear-gradient(145deg, #7c3aed, #5b21b6); }
        .event-thumb-inner {
            position: absolute; inset: 0;
            display: flex; align-items: center; justify-content: center;
        }
        .event-thumb-letter { font-size: 56px; font-weight: 900; color: rgba(255,255,255,.18); line-height: 1; }
        .event-body { padding: 24px 28px; flex: 1; }
        .event-tags { display: flex; flex-wrap: wrap; gap: 6px; margin-bottom: 12px; }
        .event-tag { font-size: 11px; color: var(--teal); border: 1.5px solid rgba(26,122,122,0.3); padding: 3px 12px; border-radius: 50px; font-weight: 600; }
        .event-title { font-size: 18px; font-weight: 800; color: var(--dark); line-height: 1.3; margin-bottom: 8px; }
        .event-desc  { font-size: 13px; color: #888; line-height: 1.65; margin-bottom: 18px; }
        .event-footer { display: flex; align-items: center; justify-content: space-between; }
        .event-meta-info { font-size: 12px; color: var(--muted); display: flex; gap: 14px; }
        .badge-open   { font-size: 12px; font-weight: 700; background: #e6faf5; color: var(--teal); padding: 7px 20px; border-radius: 10px; }
        .badge-closed { font-size: 12px; font-weight: 700; background: #f4f4f4; color: #aaa; padding: 7px 20px; border-radius: 10px; }

        .empty-state { text-align: center; padding: 64px; background: white; border-radius: 18px; color: #aaa; font-size: 14px; }

        /* ===== BERITA ===== */
        .berita-sec { padding: 90px 52px; background: white; }
        .berita-sec .inner { max-width: 1080px; margin: 0 auto; }
        .news-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 22px; }
        .news-card {
            background: var(--cream); border-radius: 18px; overflow: hidden;
            text-decoration: none; display: block;
            box-shadow: 0 2px 16px rgba(0,0,0,0.05);
            border: 1px solid rgba(0,0,0,0.04);
            transition: all .25s;
        }
        .news-card:hover { transform: translateY(-5px); box-shadow: 0 14px 36px rgba(0,0,0,0.1); }
        .news-thumb { height: 190px; position: relative; overflow: hidden; }
        .news-thumb img { width: 100%; height: 100%; object-fit: cover; }
        .news-badge {
            position: absolute; top: 12px; right: 12px;
            background: rgba(26,42,42,.82); color: white;
            font-size: 9px; font-weight: 800; padding: 4px 12px;
            border-radius: 8px; letter-spacing: .1em; text-transform: uppercase;
            backdrop-filter: blur(4px);
        }
        .news-body { padding: 20px; }
        .news-date  { font-size: 11px; color: var(--muted); margin-bottom: 8px; }
        .news-title { font-size: 14px; font-weight: 800; color: var(--dark); line-height: 1.4; margin-bottom: 8px; }
        .news-excerpt { font-size: 12px; color: #888; line-height: 1.65; }

        /* ===== KALENDER ===== */
        .kalender-sec { padding: 90px 52px; background: var(--cream); }
        .kalender-sec .inner { max-width: 1080px; margin: 0 auto; }
        #kalender-container { background: white; border-radius: 20px; border: 1px solid rgba(26,122,122,.1); padding: 24px; box-shadow: 0 4px 24px rgba(0,0,0,.05); }
        .fc .fc-toolbar-title { font-size: 16px !important; font-weight: 800; color: var(--dark); }
        .fc .fc-button { background: var(--teal) !important; border-color: var(--teal) !important; font-size: 12px !important; font-weight: 700 !important; border-radius: 8px !important; }
        .fc .fc-button:hover { background: var(--teal-dark) !important; }

        /* ===== FOOTER ===== */
        .footer { background: #0a1818; padding: 68px 52px 24px; }
        .footer-inner { max-width: 1080px; margin: 0 auto; }
        .footer-grid { display: grid; grid-template-columns: 1.6fr 1fr 1fr 1.6fr; gap: 52px; }
        .ft-brand-name { font-size: 15px; font-weight: 900; color: white; }
        .ft-brand-sub  { font-size: 10px; color: #445; margin-bottom: 14px; }
        .ft-brand-desc { font-size: 13px; color: #445; line-height: 1.7; margin-bottom: 20px; }
        .ft-socials { display: flex; gap: 10px; }
        .ft-socials a { width: 38px; height: 38px; border-radius: 50%; background: #1a2828; display: flex; align-items: center; justify-content: center; color: #667; font-size: 15px; text-decoration: none; transition: all .2s; }
        .ft-socials a:hover { background: var(--teal); color: white; }
        .ft-col h4 { font-size: 10px; font-weight: 800; color: var(--teal); letter-spacing: .14em; text-transform: uppercase; margin-bottom: 20px; }
        .ft-col a { display: block; font-size: 13px; color: #445; text-decoration: none; margin-bottom: 10px; transition: color .2s; }
        .ft-col a:hover { color: white; }
        .ft-col p { font-size: 13px; color: #445; line-height: 1.75; }
        .ft-divider { border: none; border-top: 1px solid #1a2828; margin: 52px 0 20px; }
        .ft-bottom { text-align: center; font-size: 12px; color: #334; }
        .ft-bottom span { color: var(--teal); }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 960px) {
            .navbar, .navbar.scrolled { padding: 14px 20px; }
            .nav-links a:not(.nav-cta) { display: none; }
            .welcoming, .kegiatan-sec, .berita-sec, .kalender-sec { padding: 64px 20px; }
            .welcoming-inner { grid-template-columns: 1fr; gap: 40px; }
            /* FIX: Menghapus height wright yang merusak layout */
            .news-grid { grid-template-columns: 1fr 1fr; }
            .footer { padding: 48px 20px 20px; }
            .footer-grid { grid-template-columns: 1fr 1fr; gap: 32px; }
            .event-thumb { width: 120px; }
        }
        @media (max-width: 600px) {
            .hero-title { letter-spacing: -2px; }
            .hstat { padding: 14px 20px; }
            .news-grid { grid-template-columns: 1fr; }
            .footer-grid { grid-template-columns: 1fr; }
            .event-card { flex-direction: column; }
            .event-thumb { width: 100%; min-height: 140px; }
            .speech-front { grid-template-columns: 1fr; padding-left: 20px; }
            .ketum-cutout-wrap { display: none; } 
        }
    </style>
</head>
<body>

{{-- ===== NAVBAR ===== --}}
<nav class="navbar" id="mainNav">
    <a href="{{ url('/') }}" class="nav-brand">
        <div class="nav-logo-box">
            <img src="/images/logo uin.png" alt="Logo UIN" class="logo-asli" onerror="this.style.display='none'">
            <img src="/images/kabinet.png" alt="Kabinet" class="logo-bulat" onerror="this.style.display='none'">
            <img src="/images/logo.png" alt="Logo DEMA" class="logo-bulat" onerror="this.style.display='none'">
        </div>
        <div>
            <div class="nav-brand-name">DEMA FEBI</div>
            <div class="nav-brand-sub">UIN Mahmud Yunus Batusangkar</div>
        </div>
    </a>
    <div class="nav-links">
        <a href="#kegiatan">Kegiatan</a>
        <a href="#kalender">Kalender</a>
        <a href="{{ url('/admin') }}" class="nav-cta">Login Admin</a>
    </div>
</nav>

{{-- ===== HERO ===== --}}
<section class="hero">
    <div class="hero-ornament hero-ornament-bl"></div>
    <div class="hero-ornament hero-ornament-tr"></div>

    <h1 class="hero-title">
        DEMA<span class="l2">FEBI</span>
    </h1>

    <p class="hero-tagline">
        <strong>Dewan Eksekutif Mahasiswa</strong><br>
        Fakultas Ekonomi dan Bisnis Islam<br>
        UIN Mahmud Yunus Batusangkar
    </p>

    <div class="hero-stats">
        <div class="hstat">
            <div class="hstat-num">{{ $totalAnggota }}</div>
            <div class="hstat-lbl">Anggota Aktif</div>
        </div>
        <div class="hstat">
            <div class="hstat-num">{{ $totalKegiatan }}</div>
            <div class="hstat-lbl">Kegiatan</div>
        </div>
        <div class="hstat">
            <div class="hstat-num">2026</div>
            <div class="hstat-lbl">Periode</div>
        </div>
    </div>

    <div class="hero-btns">
        <a href="#kegiatan" class="hbtn-white">Lihat Kegiatan</a>
        <a href="#sambutan" class="hbtn-ghost">Sambutan Ketua</a>
    </div>

    <div class="hero-scroll">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 5v14M5 12l7 7 7-7"/></svg>
        Scroll
    </div>
</section>

{{-- ===== WELCOMING SPEECH (FIXED) ===== --}}
<section id="sambutan" class="welcoming">
    <div class="welcoming-inner">
        {{-- Left: Teks Judul Tetap --}}
        <div>
            <h2 class="wleft-title">Welcoming<br>Speech</h2>
            <p class="wleft-desc">
                Selamat datang di SIMA DEMA FEBI — Platform resmi untuk mengelola
                dan menginformasikan kegiatan, anggota, serta program kerja
                DEMA FEBI UIN Mahmud Yunus Batusangkar.
            </p>
        </div>

        {{-- Right: Kartu Melayang --}}
        <div class="wright">
            
            <div class="speech-card-wrap" id="speechCard">
                <div class="speech-card-inner">
                    
                    {{-- HALAMAN DEPAN KARTU --}}
                    <div class="speech-front">
                        {{-- FOTO KETUM MELAYANG (Terisolasi aman, tidak mengganggu grid teks) --}}
                        <div class="ketum-cutout-wrap">
                            <img src="/images/ketum dema.png" alt="Ketua DEMA" class="ketum-png">
                        </div>

                        {{-- Kolom Kosong 1 untuk Mengalah pada Foto --}}
                        <div></div>

                        {{-- Kolom 2: Konten Teks Kartu Depan --}}
                        <div class="speech-text-content">
                            <p class="speech-quote-text">"Bersama membangun FEBI yang Berkarakter dan Berprestasi."</p>
                            <p class="speech-body-text">Assalamu'alaikum Wr. Wb. Selamat datang di SIMA DEMA FEBI — Semoga Platform ini menjadi Jembatan Komunikasi yang efektif antara Pengurus dan seluruh Civitas FEBI.</p>
                            <hr class="speech-hr">
                            <div class="speech-name">Polis Umum DEMA FEBI</div>
                            <div class="speech-role">Periode 2025/2026</div>
                        </div>
                    </div>
                    
                    {{-- HALAMAN BELAKANG KARTU --}}
                    <div class="speech-back">
                        <div class="speech-text-content">
                            <p class="speech-quote-text">Visi</p>
                            <p class="speech-body-text">Mewujudkan DEMA FEBI yang harmonis dalam kepengurusan,aktif mengabdi kepada masyarakat,peka terhadap perkembangan informasi,serta menjunjung tinggi sportifitas dan profesionalitas </p>
                            <br>
                            <p class="speech-quote-text">Misi</p>
                            <p class="speech-body-text">1. Membudayakan komunikasi terbuka antar sesama ormawa febi terhadap permasalahan dan menjadi agen solutif untuk suatu perubahan</p>
                            <p class="speech-body-text">2. Mewujudkan program febi yg peduli dengan aksi sosial dan responsif terhadap isu masyarakat sekitar</p>
                            <p class="speech-body-text">3. Menciptakan hubungan internal ormawa febi yg saling menghargai dan dewasa sebagai individu yg profesional</p>
                            <hr class="speech-hr">
                        </div>
                    </div>

                </div>
            </div>
            
            <p class="tap-hint">Tap kartu untuk melihat Visi Misi</p>
        </div>
    </div>
</section>

{{-- ===== KEGIATAN ===== --}}
<section id="kegiatan" class="kegiatan-sec">
    <div class="inner">
        <div class="sec-header">
            <div>
                <span class="sec-label">Program Kerja</span>
                <h2 class="sec-title">Latest <span>Events</span></h2>
                <p class="sec-desc">Don't miss out on our upcoming activities and strategic initiatives.</p>
            </div>
            <a href="#" class="view-all">View All Events →</a>
        </div>

        @if($kegiatan->isEmpty())
            <div class="empty-state">Belum ada kegiatan yang dipublikasikan.</div>
        @else
            @php $thumbClasses = ['','event-thumb-alt','event-thumb-alt2']; @endphp
            @foreach($kegiatan as $item)
            <a href="{{ route('kegiatan.detail', $item->id) }}" class="event-card">
                <div class="event-thumb {{ $thumbClasses[$loop->index % 3] }}">
                    <div class="event-thumb-inner">
                        <span class="event-thumb-letter">{{ strtoupper(substr($item->nama_kegiatan,0,1)) }}</span>
                    </div>
                </div>
                <div class="event-body">
                    <div class="event-tags">
                        @foreach(explode(',', $item->kategori ?? 'Kegiatan') as $tag)
                            <span class="event-tag">{{ trim($tag) }}</span>
                        @endforeach
                    </div>
                    <div class="event-title">{{ $item->nama_kegiatan }}</div>
                    <div class="event-desc">{{ Str::limit($item->deskripsi, 140) ?? 'Kegiatan DEMA FEBI UIN Mahmud Yunus Batusangkar.' }}</div>
                    <div class="event-footer">
                        <div class="event-meta-info">
                            <span>📅 {{ $item->tanggal->format('d M Y') }}</span>
                            @if($item->lokasi)<span>📍 {{ $item->lokasi }}</span>@endif
                        </div>
                        @if($item->kuota && $item->kuota > 0)
                            <span class="badge-open">Open</span>
                        @else
                            <span class="badge-closed">Closed</span>
                        @endif
                    </div>
                </div>
            </a>
            @endforeach
        @endif
    </div>
</section>

{{-- ===== BERITA ===== --}}
<section class="berita-sec">
    <div class="inner">
        <div class="sec-header">
            <div>
                <span class="sec-label">Informasi</span>
                <h2 class="sec-title">Latest <span>News</span></h2>
                <p class="sec-desc">Stay updated with the latest faculty news and student activities.</p>
            </div>
            <a href="#" class="view-all">View All News →</a>
        </div>

        @if($kegiatan->isEmpty())
            <div class="empty-state">Belum ada berita.</div>
        @else
            <div class="news-grid">
                @foreach($kegiatan->take(3) as $item)
                <a href="{{ route('kegiatan.detail', $item->id) }}" class="news-card">
                    <div class="news-thumb">
                        <div style="width:100%;height:100%;background:linear-gradient(160deg,{{ ['#1a9a9a','#2563eb','#7c3aed'][($loop->index%3)] }},{{ ['#0f6060','#1d4ed8','#5b21b6'][($loop->index%3)] }});"></div>
                        <div class="news-badge">{{ strtoupper($item->kategori ?? 'Proker') }}</div>
                    </div>
                    <div class="news-body">
                        <div class="news-date">{{ $item->tanggal->format('d M Y') }}</div>
                        <div class="news-title">{{ $item->nama_kegiatan }}</div>
                        <div class="news-excerpt">{{ Str::limit($item->deskripsi, 110) ?? 'Kegiatan DEMA FEBI UIN Mahmud Yunus Batusangkar.' }}</div>
                    </div>
                </a>
                @endforeach
            </div>
        @endif
    </div>
</section>

{{-- ===== KALENDER ===== --}}
<section id="kalender" class="kalender-sec">
    <div class="inner">
        <div class="sec-header">
            <div>
                <span class="sec-label">Jadwal</span>
                <h2 class="sec-title">Kalender <span>Program Kerja</span></h2>
                <p class="sec-desc">Agenda dan jadwal kegiatan DEMA FEBI sepanjang periode kepengurusan.</p>
            </div>
        </div>
        <div id="kalender-container"></div>
    </div>
</section>

{{-- ===== FOOTER ===== --}}
<footer class="footer">
    <div class="footer-inner">
        <div class="footer-grid">
            <div>
                <div class="ft-brand-name">DEMA FEBI</div>
                <div class="ft-brand-sub">UIN Mahmud Yunus Batusangkar</div>
                <p class="ft-brand-desc">Sistem Informasi Manajemen Anggota dan Kegiatan DEMA FEBI.</p>
                <div class="ft-socials">
                    <a href="#" title="YouTube">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/></svg>
                    </a>
                    <a href="#" title="Instagram">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069"/></svg>
                    </a>
                </div>
            </div>
        </div>
        <div class="ft-divider"></div>
        <div class="ft-bottom">
            &copy; 2026 DEMA FEBI UIN MYB. All rights reserved. Built with <span>❤️</span>
        </div>
    </div>
</footer>

<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.8/index.global.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // 1. Logika Flip Card
        const card = document.getElementById('speechCard');
        if (card) {
            card.addEventListener('click', function() {
                this.classList.toggle('flipped');
            });
        }

        // 2. Efek Navbar
        const mainNav = document.getElementById('mainNav');
        window.addEventListener('scroll', function() {
            if (window.scrollY > 40) {
                mainNav.classList.add('scrolled');
            } else {
                mainNav.classList.remove('scrolled');
            }
        });

        // 3. Inisialisasi Kalender (Cek ID 'calendar' atau 'kalender-container')
        // SESUAIKAN: Jika di HTML kamu pakai <div id="calendar">, ganti teks di bawah jadi 'calendar'
        const calendarEl = document.getElementById('kalender-container') || document.getElementById('calendar');
        
        if (calendarEl) {
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'id',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth'
                },
                // Load data event secara aman
                events: {
                    url: '/kalender-data',
                    method: 'GET',
                    failure: function() {
                        console.error('Gagal load data kalender');
                    }
                },
                        @endforeach
                    @endif
                ]
            });
            calendar.render();
            console.log("Kalender berhasil di-render!");
        } else {
            console.error("Error: Element container kalender tidak ditemukan di HTML!");
        }
    });
</script>

</body>
</html>