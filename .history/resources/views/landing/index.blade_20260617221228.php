<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DEMA FEBI — UIN Mahmud Yunus Batusangkar</title>

    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Alpine.js untuk search kegiatan --}}
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        /* ===== CSS VARIABLES (DESIGN TOKENS) ===== */
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
        .nav-logo-box {
            display: flex; align-items: center; gap: 10px;
            background-color: #ffffff !important;
            padding: 4px 10px; border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15); height: 40px;
        }
        .nav-logo-box img { height: 30px; object-fit: contain; border: none !important; }
        .nav-logo-box img.logo-asli { width: auto; border-radius: 0% !important; }
        .nav-logo-box img.logo-bulat { width: 30px; object-fit: cover; border-radius: 50% !important; }
        .nav-brand-name { font-size: 13px; font-weight: 800; color: white; letter-spacing: 0.02em; line-height: 1.2; }
        .nav-brand-sub  { font-size: 9px; color: rgba(255,255,255,0.45); }
        .nav-links { display: flex; align-items: center; gap: 4px; }
        .nav-links a { font-size: 11px; font-weight: 700; color: rgba(255,255,255,0.65); padding: 8px 16px; border-radius: 50px; text-decoration: none; letter-spacing: 0.07em; text-transform: uppercase; transition: all 0.2s; }
        .nav-links a:hover { color: white; background: rgba(255,255,255,0.1); }
        .nav-cta { background: white !important; color: var(--teal-dark) !important; font-weight: 800 !important; border-radius: 50px; padding: 9px 22px !important; }
        .nav-cta:hover { background: #e0f5f5 !important; transform: translateY(-1px); }

        /* ===== HERO ===== */
        .hero {
            min-height: 100vh; position: relative;
            display: flex; flex-direction: column;
            align-items: center; justify-content: center;
            overflow: hidden; background-color: #0c4e4e;
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
            font-size: clamp(80px, 15vw, 170px); font-weight: 900;
            line-height: .88; text-align: center; letter-spacing: -5px;
            position: relative; z-index: 2;
            background: linear-gradient(135deg,
                rgba(255,255,255,0.10) 0%, rgba(160,235,235,0.65) 22%,
                rgba(255,255,255,0.97) 50%, rgba(160,235,235,0.65) 78%,
                rgba(255,255,255,0.10) 100%);
            background-size: 400% 100%;
            -webkit-background-clip: text; background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: shimmer 9s ease-in-out infinite; user-select: none;
        }
        .hero-title .l2 {
            display: block;
            background: linear-gradient(135deg,
                rgba(100,210,210,0.45) 0%, rgba(255,255,255,0.98) 42%,
                rgba(100,210,210,0.75) 72%, rgba(100,210,210,0.45) 100%);
            background-size: 400% 100%;
            -webkit-background-clip: text; background-clip: text;
            animation: shimmer 9s ease-in-out infinite reverse;
        }
        @keyframes shimmer {
            0%,100% { background-position: 0% center; }
            50%      { background-position: 200% center; }
        }
        .hero-tagline {
            position: relative; z-index: 2; text-align: center; margin-top: 24px;
            font-size: 14px; font-weight: 500;
            color: rgba(255,255,255,0.6); letter-spacing: .04em; line-height: 1.7;
        }
        .hero-tagline strong { color: rgba(255,255,255,.9); font-weight: 700; }
        .hero-stats {
            position: relative; z-index: 2;
            display: flex; align-items: stretch; margin-top: 44px;
            background: rgba(255,255,255,0.07);
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 16px; overflow: hidden; backdrop-filter: blur(8px);
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

        /* ===== WELCOMING SPEECH ===== */
        .welcoming { padding: 110px 52px; background: var(--cream); overflow: hidden; }
        .welcoming-inner { max-width: 1080px; margin: 0 auto; display: grid; grid-template-columns: 1fr 1.1fr; gap: 60px; align-items: center; }
        .wleft-title { font-size: clamp(42px,6vw,72px); font-weight: 900; color: var(--teal); line-height: 1; letter-spacing: -2px; margin-bottom: 20px; }
        .wleft-desc { font-size: 14px; color: var(--muted); line-height: 1.8; }
        .wright { position: relative; perspective: 1200px; display: flex; flex-direction: column; align-items: center; justify-content: center; }
        .speech-card-wrap { width: 100%; max-width: 490px; height: 290px; cursor: pointer; position: relative; }
        .speech-card-inner { position: relative; width: 100%; height: 100%; transform-style: preserve-3d; transition: transform .8s cubic-bezier(.4,0,.2,1); }
        .speech-card-wrap.flipped .speech-card-inner { transform: rotateY(180deg); }
        .speech-front, .speech-back {
            position: absolute; top: 0; left: 0; width: 100%; height: 100%;
            background: white; border-radius: 20px;
            box-shadow: 0 12px 40px rgba(26,122,122,0.1);
            border: 1px solid rgba(26,122,122,0.08);
            backface-visibility: hidden; -webkit-backface-visibility: hidden;
        }
        .speech-front { display: grid; grid-template-columns: 145px 1fr; gap: 15px; padding: 28px 30px 28px 10px; }
        .speech-back  { transform: rotateY(180deg); padding: 28px 30px; }
        .ketum-cutout-wrap { position: absolute; bottom: 0; left: 10px; width: 150px; height: 350px; z-index: 10; pointer-events: none; display: flex; align-items: flex-end; }
        .ketum-png { width: 100%; height: auto; max-height: 100%; object-fit: contain; filter: drop-shadow(-6px 10px 10px rgba(0,0,0,0.12)); }
        .speech-quote-text { font-size: 14px; font-weight: 700; color: var(--teal); font-style: italic; line-height: 1.4; margin-bottom: 8px; }
        .speech-body-text  { font-size: 12px; color: #666; line-height: 1.6; }
        .speech-hr   { border: none; border-top: 1px solid #f0ece4; margin: 10px 0; }
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
            border: 1px solid rgba(26,122,122,0.07); transition: all .25s;
        }
        .event-card:hover { transform: translateY(-4px); box-shadow: 0 14px 36px rgba(26,122,122,0.14); }
        .event-thumb { width: 180px; flex-shrink: 0; background: linear-gradient(145deg, #1a9a9a, #0f5858); position: relative; overflow: hidden; min-height: 180px; }
        .event-thumb-alt  { background: linear-gradient(145deg, #2563eb, #1d4ed8); }
        .event-thumb-alt2 { background: linear-gradient(145deg, #7c3aed, #5b21b6); }
        .event-thumb-inner { position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; }
        .event-thumb-letter { font-size: 56px; font-weight: 900; color: rgba(255,255,255,.18); line-height: 1; }
        .event-body   { padding: 24px 28px; flex: 1; }
        .event-tags   { display: flex; flex-wrap: wrap; gap: 6px; margin-bottom: 12px; }
        .event-tag    { font-size: 11px; color: var(--teal); border: 1.5px solid rgba(26,122,122,0.3); padding: 3px 12px; border-radius: 50px; font-weight: 600; }
        .event-title  { font-size: 18px; font-weight: 800; color: var(--dark); line-height: 1.3; margin-bottom: 8px; }
        .event-desc   { font-size: 13px; color: #888; line-height: 1.65; margin-bottom: 18px; }
        .event-footer { display: flex; align-items: center; justify-content: space-between; }
        .event-meta-info { font-size: 12px; color: var(--muted); display: flex; gap: 14px; }
        .badge-open   { font-size: 12px; font-weight: 700; background: #e6faf5; color: var(--teal); padding: 7px 20px; border-radius: 10px; }
        .badge-closed { font-size: 12px; font-weight: 700; background: #f4f4f4; color: #aaa; padding: 7px 20px; border-radius: 10px; }
        .empty-state  { text-align: center; padding: 64px; background: white; border-radius: 18px; color: #aaa; font-size: 14px; }

        /* ===== BERITA ===== */
        .berita-sec { padding: 90px 52px; background: white; }
        .berita-sec .inner { max-width: 1080px; margin: 0 auto; }
        .news-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 22px; }
        .news-card { background: var(--cream); border-radius: 18px; overflow: hidden; text-decoration: none; display: block; box-shadow: 0 2px 16px rgba(0,0,0,0.05); border: 1px solid rgba(0,0,0,0.04); transition: all .25s; }
        .news-card:hover { transform: translateY(-5px); box-shadow: 0 14px 36px rgba(0,0,0,0.1); }
        .news-thumb { height: 190px; position: relative; overflow: hidden; }
        .news-badge { position: absolute; top: 12px; right: 12px; background: rgba(26,42,42,.82); color: white; font-size: 9px; font-weight: 800; padding: 4px 12px; border-radius: 8px; letter-spacing: .1em; text-transform: uppercase; backdrop-filter: blur(4px); }
        .news-body  { padding: 20px; }
        .news-date  { font-size: 11px; color: var(--muted); margin-bottom: 8px; }
        .news-title { font-size: 14px; font-weight: 800; color: var(--dark); line-height: 1.4; margin-bottom: 8px; }
        .news-excerpt { font-size: 12px; color: #888; line-height: 1.65; }

        /* ===== FOOTER ===== */
        .footer { background: #0a1818; padding: 68px 52px 24px; }
        .footer-inner { max-width: 1080px; margin: 0 auto; }
        .footer-grid { display: grid; grid-template-columns: 1.6fr 1fr 1fr 1.6fr; gap: 52px; }
        .ft-brand-name { font-size: 15px; font-weight: 900; color: white; }
        .ft-brand-sub  { font-size: 10px; color: #445; margin-bottom: 14px; }
        .ft-brand-desc { font-size: 13px; color: #445; line-height: 1.7; margin-bottom: 20px; }
        .ft-socials    { display: flex; gap: 10px; }
        .ft-socials a  { width: 38px; height: 38px; border-radius: 50%; background: #1a2828; display: flex; align-items: center; justify-content: center; color: #667; font-size: 15px; text-decoration: none; transition: all .2s; }
        .ft-socials a:hover { background: var(--teal); color: white; }
        .ft-col h4 { font-size: 10px; font-weight: 800; color: var(--teal); letter-spacing: .14em; text-transform: uppercase; margin-bottom: 20px; }
        .ft-col a  { display: block; font-size: 13px; color: #445; text-decoration: none; margin-bottom: 10px; transition: color .2s; }
        .ft-col a:hover { color: white; }
        .ft-col p  { font-size: 13px; color: #445; line-height: 1.75; }
        .ft-divider { border: none; border-top: 1px solid #1a2828; margin: 52px 0 20px; }
        .ft-bottom  { text-align: center; font-size: 12px; color: #334; }
        .ft-bottom span { color: var(--teal); }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 960px) {
            .navbar, .navbar.scrolled { padding: 14px 20px; }
            .nav-links a:not(.nav-cta) { display: none; }
            .welcoming, .kegiatan-sec, .berita-sec { padding: 64px 20px; }
            .welcoming-inner { grid-template-columns: 1fr; gap: 40px; }
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
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <path d="M12 5v14M5 12l7 7 7-7"/>
        </svg>
        Scroll
    </div>
</section>

{{-- ===== WELCOMING SPEECH ===== --}}
<section id="sambutan" class="welcoming">
    <div class="welcoming-inner">
        <div>
            <h2 class="wleft-title">Welcoming<br>Speech</h2>
            <p class="wleft-desc">
                Selamat datang di SIMA DEMA FEBI — Platform resmi untuk mengelola
                dan menginformasikan kegiatan, anggota, serta program kerja
                DEMA FEBI UIN Mahmud Yunus Batusangkar.
            </p>
        </div>

        <div class="wright">
            <div class="speech-card-wrap" id="speechCard">
                <div class="speech-card-inner">

                    {{-- DEPAN --}}
                    <div class="speech-front">
                        <div class="ketum-cutout-wrap">
                            <img src="/images/ketum dema.png" alt="Ketua DEMA" class="ketum-png">
                        </div>
                        <div></div>
                        <div class="speech-text-content">
                            <p class="speech-quote-text">"Bersama membangun FEBI yang Berkarakter dan Berprestasi."</p>
                            <p class="speech-body-text">Assalamu'alaikum Wr. Wb. Selamat datang di SIMA DEMA FEBI — Semoga platform ini menjadi jembatan komunikasi yang efektif antara pengurus dan seluruh civitas FEBI.</p>
                            <hr class="speech-hr">
                            <div class="speech-name">Polis Umum DEMA FEBI</div>
                            <div class="speech-role">Periode 2025/2026</div>
                        </div>
                    </div>

                    {{-- BELAKANG --}}
                    <div class="speech-back">
                        <div class="speech-text-content">
                            <p class="speech-quote-text">Visi</p>
                            <p class="speech-body-text">Mewujudkan DEMA FEBI yang harmonis dalam kepengurusan, aktif mengabdi kepada masyarakat, peka terhadap perkembangan informasi, serta menjunjung tinggi sportifitas dan profesionalitas.</p>
                            <br>
                            <p class="speech-quote-text">Misi</p>
                            <p class="speech-body-text">1. Membudayakan komunikasi terbuka antar sesama ormawa FEBI terhadap permasalahan dan menjadi agen solutif untuk suatu perubahan.</p>
                            <p class="speech-body-text">2. Mewujudkan program FEBI yang peduli dengan aksi sosial dan responsif terhadap isu masyarakat sekitar.</p>
                            <p class="speech-body-text">3. Menciptakan hubungan internal ormawa FEBI yang saling menghargai dan dewasa sebagai individu yang profesional.</p>
                            <hr class="speech-hr">
                        </div>
                    </div>

                </div>
            </div>
            <p class="tap-hint">Tap kartu untuk melihat Visi Misi →</p>
        </div>
    </div>
</section>

{{-- ===== KEGIATAN ===== --}}
<section id="kegiatan" class="kegiatan-sec" x-data="{ search: '' }">
    <div class="inner">
        <div class="sec-header">
            <div>
                <span class="sec-label">Program Kerja</span>
                <h2 class="sec-title">Latest <span>Events</span></h2>
                <p class="sec-desc">Program dan kegiatan DEMA FEBI yang dapat diikuti.</p>
            </div>
            {{-- Search box --}}
            <div style="position:relative;">
                <input
                    type="text"
                    x-model="search"
                    placeholder="Cari kegiatan..."
                    style="padding: 10px 16px 10px 40px; border-radius: 50px; border: 1.5px solid rgba(26,122,122,0.25); font-size: 13px; outline: none; width: 220px; font-family: inherit;"
                >
                <svg style="position:absolute; left:14px; top:50%; transform:translateY(-50%); width:16px; height:16px; color:#7a9090;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z"/>
                </svg>
            </div>
        </div>

        @if($kegiatan->isEmpty())
            <div class="empty-state">Belum ada kegiatan yang dipublikasikan.</div>
        @else
            @php $thumbClasses = ['', 'event-thumb-alt', 'event-thumb-alt2']; @endphp
            @foreach($kegiatan as $item)
            
                href="{{ route('kegiatan.detail', $item->id) }}"
                class="event-card"
                x-data="{ nama: @js(strtolower($item->nama_kegiatan)), kategori: @js(strtolower($item->kategori ?? '')) }"
                x-show="search === '' || nama.includes(search.toLowerCase()) || kategori.includes(search.toLowerCase())"
            >
                <div class="event-thumb {{ $thumbClasses[$loop->index % 3] }}">
                    <div class="event-thumb-inner">
                        <span class="event-thumb-letter">{{ strtoupper(substr($item->nama_kegiatan, 0, 1)) }}</span>
                    </div>
                </div>
                <div class="event-body">
                    <div class="event-tags">
                        @foreach(explode(',', $item->kategori ?? 'Kegiatan') as $tag)
                            <span class="event-tag">{{ trim($tag) }}</span>
                        @endforeach
                    </div>
                    <div class="event-title">{{ $item->nama_kegiatan }}</div>
                    <div class="event-desc">{{ Str::limit($item->deskripsi ?? 'Kegiatan DEMA FEBI UIN Mahmud Yunus Batusangkar.', 140) }}</div>
                    <div class="event-footer">
                        <div class="event-meta-info">
                            <span>📅 {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</span>
                            @if($item->lokasi)<span>📍 {{ $item->lokasi }}</span>@endif
                            @if($item->divisi)<span>🏢 {{ $item->divisi->nama_divisi }}</span>@endif
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
                <p class="sec-desc">Update terbaru seputar kegiatan dan informasi DEMA FEBI.</p>
            </div>
        </div>

        @if($kegiatan->isEmpty())
            <div class="empty-state">Belum ada berita.</div>
        @else
            <div class="news-grid">
                @php
                    $bgColors  = ['#1a9a9a','#2563eb','#7c3aed'];
                    $bgColors2 = ['#0f6060','#1d4ed8','#5b21b6'];
                @endphp
                @foreach($kegiatan->take(3) as $item)
                <a href="{{ route('kegiatan.detail', $item->id) }}" class="news-card">
                    <div class="news-thumb">
                        <div style="width:100%;height:100%;background:linear-gradient(160deg,{{ $bgColors[$loop->index % 3] }},{{ $bgColors2[$loop->index % 3] }});"></div>
                        <div class="news-badge">{{ strtoupper($item->kategori ?? 'Proker') }}</div>
                    </div>
                    <div class="news-body">
                        <div class="news-date">{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</div>
                        <div class="news-title">{{ $item->nama_kegiatan }}</div>
                        <div class="news-excerpt">{{ Str::limit($item->deskripsi ?? 'Kegiatan DEMA FEBI UIN Mahmud Yunus Batusangkar.', 110) }}</div>
                    </div>
                </a>
                @endforeach
            </div>
        @endif
    </div>
</section>

{{-- ===== KALENDER (dark theme, custom JS — dari file lama yang sudah working) ===== --}}
<section id="kalender" class="py-16 px-4 bg-slate-900">
    <div class="max-w-4xl mx-auto">
        <div class="text-center mb-10">
            <p class="text-cyan-400 text-xs font-bold uppercase tracking-widest mb-2">Agenda</p>
            <h2 class="text-3xl font-bold text-white" style="font-family: 'Plus Jakarta Sans', sans-serif;">Kalender Program Kerja</h2>
            <p class="text-slate-400 mt-2 text-sm">Jadwal dan agenda kegiatan DEMA FEBI sepanjang tahun</p>
        </div>

        <div class="flex items-center justify-between mb-6">
            <button id="cal-prev" class="text-slate-400 hover:text-cyan-400 transition text-3xl font-light px-3 py-1">&#8249;</button>
            <div class="text-center">
                <h3 id="cal-month" class="text-cyan-400 text-2xl font-extrabold uppercase tracking-widest" style="font-family: 'Plus Jakarta Sans', sans-serif;"></h3>
                <p id="cal-year" class="text-white text-lg font-bold"></p>
            </div>
            <button id="cal-next" class="text-slate-400 hover:text-cyan-400 transition text-3xl font-light px-3 py-1">&#8250;</button>
        </div>

        <div class="grid grid-cols-7 mb-2">
            @foreach(['Min','Sen','Sel','Rab','Kam','Jum','Sab'] as $day)
            <div class="text-center text-cyan-400 text-xs font-bold uppercase tracking-wider py-2">{{ $day }}</div>
            @endforeach
        </div>

        <div id="cal-grid" class="grid grid-cols-7 gap-1"></div>

        <div id="cal-popup" class="hidden mt-6 bg-slate-800 border border-slate-700 rounded-2xl p-5">
            <h4 class="text-cyan-400 font-bold text-sm uppercase tracking-wider mb-3">Kegiatan</h4>
            <div id="cal-popup-content" class="space-y-2"></div>
        </div>
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
            <div class="ft-col">
                <h4>Navigasi</h4>
                <a href="#kegiatan">Kegiatan</a>
                <a href="#kalender">Kalender</a>
                <a href="#sambutan">Sambutan</a>
            </div>
            <div class="ft-col">
                <h4>Sistem</h4>
                <a href="{{ url('/admin') }}">Login Admin</a>
            </div>
            <div class="ft-col">
                <h4>Kontak</h4>
                <p>Fakultas Ekonomi dan Bisnis Islam<br>UIN Mahmud Yunus Batusangkar</p>
            </div>
        </div>
        <hr class="ft-divider">
        <div class="ft-bottom">
            &copy; {{ date('Y') }} DEMA FEBI UIN MYB. All rights reserved. Built with <span>❤️</span>
        </div>
    </div>
</footer>

<script>
document.addEventListener('DOMContentLoaded', function () {

    // ===== FLIP CARD =====
    const card = document.getElementById('speechCard');
    if (card) {
        card.addEventListener('click', function () {
            this.classList.toggle('flipped');
        });
    }

    // ===== NAVBAR SCROLL EFFECT =====
    const mainNav = document.getElementById('mainNav');
    window.addEventListener('scroll', function () {
        mainNav.classList.toggle('scrolled', window.scrollY > 40);
    });

    // ===== KALENDER CUSTOM JS (fetch dari /kalender-data) =====
    (function () {
        const MONTHS = ['JANUARY','FEBRUARY','MARCH','APRIL','MAY','JUNE',
                        'JULY','AUGUST','SEPTEMBER','OCTOBER','NOVEMBER','DECEMBER'];

        let currentDate = new Date();
        let allEvents   = [];

        // Fetch events dari endpoint yang sama dengan sebelumnya
        fetch('/kalender-data')
            .then(r => r.json())
            .then(data => { allEvents = data.data || data; renderCalendar(); })
            .catch(() => renderCalendar()); // tetap render kalender meski fetch gagal

        function renderCalendar() {
            const year  = currentDate.getFullYear();
            const month = currentDate.getMonth();

            document.getElementById('cal-month').textContent = MONTHS[month];
            document.getElementById('cal-year').textContent  = year;

            const grid        = document.getElementById('cal-grid');
            grid.innerHTML    = '';

            const firstDay    = new Date(year, month, 1).getDay();
            const daysInMonth = new Date(year, month + 1, 0).getDate();
            const daysInPrev  = new Date(year, month, 0).getDate();
            const today       = new Date();

            // Isi hari dari bulan sebelumnya (grey out)
            for (let i = firstDay - 1; i >= 0; i--) {
                grid.appendChild(createCell(daysInPrev - i, true, false, []));
            }

            // Isi hari bulan ini
            for (let d = 1; d <= daysInMonth; d++) {
                const dateStr  = year + '-' + String(month + 1).padStart(2, '0') + '-' + String(d).padStart(2, '0');
                const isToday  = today.getFullYear() === year && today.getMonth() === month && today.getDate() === d;
                const dayEvents = allEvents.filter(e => e.start && e.start.startsWith(dateStr));
                grid.appendChild(createCell(d, false, isToday, dayEvents));
            }

            // Isi sisa sel bulan berikutnya
            const totalCells = Math.ceil((firstDay + daysInMonth) / 7) * 7;
            for (let d = 1; d <= totalCells - firstDay - daysInMonth; d++) {
                grid.appendChild(createCell(d, true, false, []));
            }

            document.getElementById('cal-popup').classList.add('hidden');
        }

        function createCell(day, isOther, isToday, events) {
            const cell = document.createElement('div');
            cell.style.cssText = 'min-height:64px;border-radius:12px;padding:8px;display:flex;flex-direction:column;position:relative;';

            if (isOther) {
                cell.style.background = 'rgba(30,41,59,0.4)';
                cell.style.opacity    = '0.3';
            } else {
                cell.style.background = '#1e293b';
                cell.style.cursor     = events.length > 0 ? 'pointer' : 'default';
                if (isToday) cell.style.outline = '2px solid #22d3ee';
            }

            if (!isOther) {
                cell.onmouseenter = function () { this.style.background = '#273549'; };
                cell.onmouseleave = function () { this.style.background = '#1e293b'; };
            }

            const num = document.createElement('span');
            num.textContent = day;
            num.style.cssText = 'font-size:1.1rem;font-weight:700;font-family:"Plus Jakarta Sans",sans-serif;';
            num.style.color   = isToday ? '#22d3ee' : '#f1f5f9';
            cell.appendChild(num);

            if (events.length > 0) {
                const dots = document.createElement('div');
                dots.style.cssText = 'margin-top:auto;display:flex;gap:3px;flex-wrap:wrap;padding-top:4px;';
                events.slice(0, 3).forEach(() => {
                    const dot = document.createElement('span');
                    dot.style.cssText = 'width:6px;height:6px;border-radius:50%;background:#22d3ee;display:inline-block;';
                    dots.appendChild(dot);
                });
                cell.appendChild(dots);
                cell.addEventListener('click', () => showEvents(events));
            }

            return cell;
        }

        function showEvents(events) {
            const popup   = document.getElementById('cal-popup');
            const content = document.getElementById('cal-popup-content');
            content.innerHTML = '';

            events.forEach(e => {
                const item = document.createElement('div');
                item.style.cssText = 'display:flex;align-items:flex-start;gap:12px;padding:12px;background:#0f172a;border-radius:12px;';
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

        document.getElementById('cal-prev').addEventListener('click', function () {
            currentDate.setMonth(currentDate.getMonth() - 1);
            renderCalendar();
        });

        document.getElementById('cal-next').addEventListener('click', function () {
            currentDate.setMonth(currentDate.getMonth() + 1);
            renderCalendar();
        });
    })();
});
</script>

</body>
</html>