<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DEMA FEBI — UIN Mahmud Yunus Batusangkar</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.8/index.global.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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

        /* ===== NAVBAR PREMIUM (FIXED) ===== */
.navbar {
    position: fixed;
    top: 20px;
    left: 50%;
    transform: translateX(-50%);
    width: calc(100% - 40px);
    max-width: 1280px;
    z-index: 1000;
    background: rgba(10, 30, 30, 0.85);
    backdrop-filter: blur(16px);
    border-radius: 60px;
    border: 1px solid rgba(255, 255, 255, 0.12);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
    transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
}

/* Saat di-scroll */
.navbar.scrolled {
    top: 0;
    border-radius: 0 0 24px 24px;
    width: 100%;
    max-width: 100%;
    background: rgba(8, 25, 25, 0.96);
    backdrop-filter: blur(20px);
    padding: 8px 0;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
}

.nav-container {
    display: flex;
    align-items: center;
    justify-content: space-between;
    max-width: 1280px;
    margin: 0 auto;
    padding: 12px 32px;
}

/* ===== LEFT: Logo Area (tanpa background putih) ===== */
.nav-brand {
    display: flex;
    align-items: center;
    gap: 12px;
    text-decoration: none;
    transition: all 0.3s;
}

.nav-brand:hover {
    transform: translateY(-2px);
}

/* Logo single (warna kuning, tanpa background) */
.nav-logo-single {
    width: 48px;
    height: 48px;
    object-fit: contain;
    filter: drop-shadow(0 2px 6px rgba(0, 0, 0, 0.2));
}

.nav-brand-text {
    line-height: 1.2;
}

.nav-brand-name {
    font-size: 16px;
    font-weight: 800;
    color: white;
    letter-spacing: -0.3px;
    background: linear-gradient(135deg, #ffffff, #e0e0e0);
    background-clip: text;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.nav-brand-sub {
    font-size: 9px;
    color: rgba(255, 255, 255, 0.6);
    font-weight: 500;
    margin-top: 2px;
}

/* ===== CENTER: Navigation Links ===== */
.nav-links-center {
    display: flex;
    align-items: center;
    gap: 8px;
    background: rgba(255, 255, 255, 0.05);
    padding: 6px;
    border-radius: 50px;
    border: 1px solid rgba(255, 255, 255, 0.08);
}

.nav-link {
    font-size: 14px;
    font-weight: 600;
    color: rgba(255, 255, 255, 0.75);
    padding: 10px 28px;
    border-radius: 40px;
    text-decoration: none;
    transition: all 0.3s ease;
    position: relative;
    letter-spacing: 0.3px;
}

/* Animasi hover yang keren */
.nav-link:hover {
    color: white;
    background: rgba(255, 255, 255, 0.15);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

/* Efek underline saat hover */
.nav-link::after {
    content: '';
    position: absolute;
    bottom: 6px;
    left: 50%;
    transform: translateX(-50%) scaleX(0);
    width: 60%;
    height: 2px;
    background: linear-gradient(90deg, #1a7a7a, #2abfbf);
    border-radius: 2px;
    transition: transform 0.3s ease;
}

.nav-link:hover::after {
    transform: translateX(-50%) scaleX(1);
}

/* ===== RIGHT: Login Admin Button ===== */
.nav-right {
    display: flex;
    align-items: center;
}

.nav-cta {
    display: flex;
    align-items: center;
    gap: 8px;
    background: linear-gradient(135deg, #ffffff, #f0f0f0);
    color: #0f5858 !important;
    font-size: 13px;
    font-weight: 700;
    padding: 10px 24px;
    border-radius: 40px;
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.3);
}

.nav-cta svg {
    width: 16px;
    height: 16px;
}

.nav-cta:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    background: white;
}

/* ===== MOBILE MENU ===== */
.mobile-menu-btn {
    display: none;
    background: rgba(255, 255, 255, 0.1);
    border: none;
    padding: 12px 14px;
    border-radius: 12px;
    cursor: pointer;
    backdrop-filter: blur(4px);
}

.mobile-menu-btn span {
    display: block;
    width: 22px;
    height: 2px;
    background: white;
    margin: 5px 0;
    transition: all 0.3s;
}

.mobile-menu {
    display: none;
    position: fixed;
    top: 80px;
    left: 20px;
    right: 20px;
    background: rgba(10, 30, 30, 0.98);
    backdrop-filter: blur(20px);
    border-radius: 24px;
    padding: 20px;
    flex-direction: column;
    gap: 12px;
    z-index: 999;
    border: 1px solid rgba(255, 255, 255, 0.1);
    transform: translateY(-20px);
    opacity: 0;
    transition: all 0.3s;
    pointer-events: none;
}

.mobile-menu.open {
    display: flex;
    transform: translateY(0);
    opacity: 1;
    pointer-events: all;
}

.mobile-link {
    font-size: 16px;
    font-weight: 600;
    color: white;
    text-decoration: none;
    padding: 14px;
    text-align: center;
    border-radius: 16px;
    transition: all 0.2s;
}

.mobile-link:hover {
    background: rgba(255, 255, 255, 0.1);
}

.mobile-cta {
    background: white;
    color: #0f5858;
    font-weight: 700;
    text-decoration: none;
    padding: 14px;
    text-align: center;
    border-radius: 16px;
    margin-top: 8px;
}

/* ===== RESPONSIVE ===== */
@media (max-width: 968px) {
    .nav-links-center {
        display: none;
    }
    
    .mobile-menu-btn {
        display: block;
    }
    
    .nav-container {
        padding: 10px 20px;
    }
    
    .nav-brand-name {
        font-size: 14px;
    }
    
.nav-logo-single {
    width: 48px;
    height: 48px;
    object-fit: contain;
    background: transparent;
    /* Ini kunci utamanya - menghilangkan background putih */
    mix-blend-mode: multiply;
    filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.15));
}
/* Untuk navbar dengan background gelap, pakai screen */
.navbar .nav-logo-single {
    mix-blend-mode: screen;
}
}

@media (max-width: 480px) {
    .nav-brand-sub {
        display: none;
    }
    
    .nav-cta {
        padding: 8px 16px;
        font-size: 12px;
    }
    
    .nav-cta span {
        display: none;
    }
}
.navbar {
    /* ... kode yang sudah ada ... */
    border: 1px solid rgba(255, 255, 255, 0.15);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
}

/* Atau bisa pakai efek glow */
.navbar::before {
    content: '';
    position: absolute;
    inset: -1px;
    background: linear-gradient(135deg, rgba(26,122,122,0.5), rgba(42,191,191,0.2));
    border-radius: 60px;
    z-index: -1;
    opacity: 0.5;
}
        
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

        /* ===== FOOTER PREMIUM ===== */
.footer {
    background: linear-gradient(135deg, #0a1818 0%, #0d2020 100%);
    padding: 70px 0 30px;
    position: relative;
    overflow: hidden;
    border-top: 1px solid rgba(26, 122, 122, 0.3);
}

.footer::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, transparent, #1a7a7a, #2abfbf, #1a7a7a, transparent);
    animation: shimmer 3s infinite;
}

.footer-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 24px;
}

/* Footer Grid */
.footer-grid {
    display: grid;
    grid-template-columns: 1.8fr 1fr 1fr 1.5fr;
    gap: 48px;
    margin-bottom: 50px;
}

/* Brand Section */
.footer-logo-wrapper {
    display: flex;
    align-items: center;
    gap: 14px;
    margin-bottom: 20px;
}

.footer-logo-img {
    width: 52px;
    height: 52px;
    border-radius: 50%;
    object-fit: cover;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    border: 2px solid rgba(26, 122, 122, 0.5);
    transition: all 0.3s;
}

.footer-logo-img:hover {
    transform: scale(1.05);
    border-color: #1a7a7a;
}

.footer-brand-name {
    font-size: 20px;
    font-weight: 800;
    background: linear-gradient(135deg, #ffffff, #a0e0e0);
    background-clip: text;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    letter-spacing: -0.5px;
}

.footer-brand-sub {
    font-size: 10px;
    color: #7aa0a0;
    letter-spacing: 1px;
    margin-top: 4px;
}

.footer-description {
    font-size: 13px;
    color: #b0c4c4 !important;
    line-height: 1.7;
    margin-bottom: 24px;
    opacity: 0.9;
}

/* Social Icons */
.footer-social {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
}

.social-icon {
    width: 40px;
    height: 40px;
    background: rgba(255, 255, 255, 0.08);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #b0d4d4 !important;
    font-size: 18px;
    transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
    text-decoration: none;
    border: 1px solid rgba(26, 122, 122, 0.3);
}

.social-icon:hover {
    background: #1a7a7a;
    color: white !important;
    transform: translateY(-5px);
    box-shadow: 0 6px 16px rgba(26, 122, 122, 0.3);
}

/* Footer Columns */
.footer-col-title {
    font-size: 14px;
    font-weight: 800;
    color: #ffffff !important;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.title-icon {
    font-size: 16px;
    background: rgba(26, 122, 122, 0.2);
    padding: 4px 8px;
    border-radius: 8px;
}

.footer-links {
    list-style: none;
    padding: 0;
    margin: 0;
}

.footer-links li {
    margin-bottom: 12px;
}

.footer-links a {
    font-size: 13px;
    color: #b0c4c4 !important;
    text-decoration: none;
    transition: all 0.3s;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.footer-links a i {
    font-size: 10px;
    transition: all 0.3s;
    color: #1a7a7a;
}

.footer-links a:hover {
    color: white !important;
    transform: translateX(8px);
}

.footer-links a:hover i {
    transform: translateX(4px);
    color: #2abfbf;
}

/* Contact Items */
.footer-contact {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.contact-item {
    display: flex;
    align-items: flex-start;
    gap: 12px;
}

.contact-item i {
    font-size: 14px;
    color: #1a7a7a;
    margin-top: 2px;
    min-width: 18px;
}

.contact-item p, .contact-item a {
    font-size: 12px;
    color: #b0c4c4 !important;
    line-height: 1.6;
    text-decoration: none;
    transition: all 0.3s;
}

.contact-item a:hover {
    color: white !important;
    transform: translateX(4px);
}

/* Newsletter Section */
.footer-newsletter {
    background: rgba(26, 122, 122, 0.08);
    border-radius: 20px;
    padding: 24px 32px;
    margin-bottom: 48px;
    border: 1px solid rgba(26, 122, 122, 0.2);
    backdrop-filter: blur(4px);
}

.newsletter-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 20px;
}

.newsletter-text {
    display: flex;
    align-items: center;
    gap: 12px;
}

.newsletter-text i {
    font-size: 28px;
    color: #1a7a7a;
    animation: float 3s ease-in-out infinite;
}

.newsletter-text span {
    font-size: 14px;
    font-weight: 600;
    color: #ffffff !important;
    letter-spacing: 0.5px;
}

.newsletter-form {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
}

.newsletter-input {
    padding: 12px 20px;
    border-radius: 50px;
    border: 1px solid rgba(26, 122, 122, 0.3);
    background: rgba(255, 255, 255, 0.1);
    color: white;
    font-size: 13px;
    width: 260px;
    transition: all 0.3s;
}

.newsletter-input::placeholder {
    color: #7aa0a0;
}

.newsletter-input:focus {
    outline: none;
    border-color: #1a7a7a;
    background: rgba(255, 255, 255, 0.15);
}

.newsletter-btn {
    padding: 12px 28px;
    border-radius: 50px;
    background: #1a7a7a;
    border: none;
    color: white;
    font-weight: 700;
    font-size: 13px;
    cursor: pointer;
    transition: all 0.3s;
}

.newsletter-btn:hover {
    background: #0f5858;
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(26, 122, 122, 0.3);
}

/* Footer Bottom */
.footer-bottom {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 16px;
    padding-top: 24px;
    border-top: 1px solid rgba(26, 122, 122, 0.2);
}

.footer-copyright p {
    font-size: 12px;
    color: #8aa8a8 !important;
}

.footer-copyright .highlight {
    color: #1a7a7a;
    font-weight: 600;
}

.footer-copyright i {
    animation: pulse 1.5s ease-in-out infinite;
}

@keyframes pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.2); }
}

.footer-legal {
    display: flex;
    gap: 16px;
    align-items: center;
}

.footer-legal a {
    font-size: 11px;
    color: #8aa8a8 !important;
    text-decoration: none;
    transition: all 0.3s;
}

.footer-legal a:hover {
    color: white !important;
    text-decoration: underline;
}

.footer-legal .separator {
    color: #3a5a5a;
}

/* Responsive Footer */
@media (max-width: 1024px) {
    .footer-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 40px;
    }
}

@media (max-width: 768px) {
    .footer-grid {
        grid-template-columns: 1fr;
        gap: 32px;
    }
    
    .footer-newsletter {
        padding: 20px;
    }
    
    .newsletter-content {
        flex-direction: column;
        text-align: center;
    }
    
    .footer-bottom {
        flex-direction: column;
        text-align: center;
    }
    
    .footer-legal {
        justify-content: center;
    }
}

@media (max-width: 480px) {
    .newsletter-form {
        flex-direction: column;
        width: 100%;
    }
    
    .newsletter-input {
        width: 100%;
    }
    
    .newsletter-btn {
        width: 100%;
    }
}

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

{{-- ===== NAVBAR PREMIUM (FIXED) ===== --}}
<nav class="navbar" id="mainNav">
    <div class="nav-container">
        <!-- LEFT: Logo DEMA FEBI (tanpa background putih) -->
        <a href="{{ url('/') }}" class="nav-brand">
            <img src="/images/logo.png" alt="DEMA FEBI" class="nav-logo-single" onerror="this.style.display='none'">
            <div class="nav-brand-text">
                <div class="nav-brand-name">DEMA FEBI</div>
                <div class="nav-brand-sub">UIN Mahmud Yunus Batusangkar</div>
            </div>
        </a>

        <!-- CENTER: Navigation Links (Home, Event, News) -->
        <div class="nav-links-center">
            <a href="#home" class="nav-link">Home</a>
            <a href="#events" class="nav-link">Event</a>
            <a href="#news" class="nav-link">News</a>
        </div>

        <!-- RIGHT: Login Admin Button -->
        <div class="nav-right">
            <a href="{{ url('/admin') }}" class="nav-cta">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4M10 17l5-5-5-5M13.8 12H3"/>
                </svg>
                Login Admin
            </a>
        </div>

        <!-- Mobile Menu Button -->
        <button class="mobile-menu-btn" id="mobileMenuBtn">
            <span></span><span></span><span></span>
        </button>
    </div>

    <!-- Mobile Menu Dropdown -->
    <div class="mobile-menu" id="mobileMenu">
        <a href="#home" class="mobile-link">Home</a>
        <a href="#events" class="mobile-link">Event</a>
        <a href="#news" class="mobile-link">News</a>
        <a href="{{ url('/admin') }}" class="mobile-cta">Login Admin</a>
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
            <div class="hstat-num">{{ $kegiatan->count() }}</div>
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

{{-- ===== FOOTER PREMIUM ===== --}}
<footer class="footer">
    <div class="footer-container">
        <!-- Main Footer Grid -->
        <div class="footer-grid">
            <!-- Brand Section -->
            <div class="footer-brand" data-aos="fade-up" data-aos-duration="600">
                <div class="footer-logo-wrapper">
                    <img src="/images/logo.png" class="footer-logo-img" onerror="this.style.display='none'" alt="Logo DEMA FEBI">
                    <div>
                        <div class="footer-brand-name">DEMA FEBI</div>
                        <div class="footer-brand-sub">UIN Mahmud Yunus Batusangkar</div>
                    </div>
                </div>
                <p class="footer-description">
                    Sistem Informasi Manajemen Anggota dan Kegiatan DEMA FEBI. 
                    Menjembatani komunikasi dan kolaborasi seluruh civitas akademika FEBI.
                </p>
                <div class="footer-social">
                    <a href="#" class="social-icon" title="Instagram">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="social-icon" title="YouTube">
                        <i class="fab fa-youtube"></i>
                    </a>
                    <a href="#" class="social-icon" title="Twitter">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="social-icon" title="LinkedIn">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    <a href="#" class="social-icon" title="TikTok">
                        <i class="fab fa-tiktok"></i>
                    </a>
                </div>
            </div>

            <!-- Links Column -->
            <div class="footer-col" data-aos="fade-up" data-aos-duration="600" data-aos-delay="100">
                <h4 class="footer-col-title">
                    <span class="title-icon">🔗</span> Links
                </h4>
                <ul class="footer-links">
                    <li><a href="{{ url('/') }}"><i class="fas fa-chevron-right"></i> Beranda</a></li>
                    <li><a href="#sambutan"><i class="fas fa-chevron-right"></i> Sambutan</a></li>
                    <li><a href="#events"><i class="fas fa-chevron-right"></i> Kegiatan</a></li>
                    <li><a href="#news"><i class="fas fa-chevron-right"></i> Berita</a></li>
                    <li><a href="#calendar"><i class="fas fa-chevron-right"></i> Kalender</a></li>
                </ul>
            </div>

            <!-- Quick Links Column -->
            <div class="footer-col" data-aos="fade-up" data-aos-duration="600" data-aos-delay="200">
                <h4 class="footer-col-title">
                    <span class="title-icon">⚡</span> Quick Link
                </h4>
                <ul class="footer-links">
                    <li><a href="{{ url('/admin') }}"><i class="fas fa-chevron-right"></i> Login Admin</a></li>
                    <li><a href="#"><i class="fas fa-chevron-right"></i> SIMA DEMA FEBI</a></li>
                    <li><a href="#"><i class="fas fa-chevron-right"></i> Laporan Kegiatan</a></li>
                    <li><a href="#"><i class="fas fa-chevron-right"></i> Arsip Program</a></li>
                    <li><a href="#"><i class="fas fa-chevron-right"></i> Pedoman Organisasi</a></li>
                </ul>
            </div>

            <!-- Contact & Address Column -->
            <div class="footer-col" data-aos="fade-up" data-aos-duration="600" data-aos-delay="300">
                <h4 class="footer-col-title">
                    <span class="title-icon">📍</span> Alamat & Kontak
                </h4>
                <div class="footer-contact">
                    <div class="contact-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <p>Gedung FEBI, UIN Mahmud Yunus Batusangkar,<br>Jl. Sudirman No. 137, Batusangkar,<br>Sumatera Barat, Indonesia</p>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-envelope"></i>
                        <a href="mailto:demafebiunmayaba@gmail.com">demafebiunmayaba@gmail.com</a>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-phone-alt"></i>
                        <a href="tel:+628123456789">+62 812 3456 7890</a>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-clock"></i>
                        <p>Senin - Jumat: 08.00 - 16.00 WIB</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Newsletter Section -->
        <div class="footer-newsletter" data-aos="fade-up" data-aos-duration="600">
            <div class="newsletter-content">
                <div class="newsletter-text">
                    <i class="fas fa-paper-plane"></i>
                    <span>Dapatkan informasi terbaru dari kami!</span>
                </div>
                <div class="newsletter-form">
                    <input type="email" placeholder="Email Anda..." class="newsletter-input">
                    <button class="newsletter-btn">Berlangganan</button>
                </div>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="footer-bottom" data-aos="fade-up" data-aos-duration="600">
            <div class="footer-copyright">
                <p>© {{ date('Y') }} <strong>DEMA FEBI</strong> UIN Mahmud Yunus Batusangkar. 
                Dibuat dengan <i class="fas fa-heart" style="color: #ff6b6b;"></i> oleh <strong class="highlight">Tim IT DEMA FEBI</strong>.</p>
            </div>
            <div class="footer-legal">
                <a href="#">Privacy Policy</a>
                <span class="separator">|</span>
                <a href="#">Terms of Service</a>
                <span class="separator">|</span>
                <a href="#">Cookie Policy</a>
            </div>
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
                events: [
                    @if(isset($kegiatan) && count($kegiatan) > 0)
                        @foreach($kegiatan as $item)
                        {
                            title: "{{ $item->nama_kegiatan }}",
                            // Memastikan format tanggal aman yyyy-mm-dd
                            start: "{{ \Carbon\Carbon::parse($item->tanggal)->format('Y-m-d') }}",
                            color: '#1a7a7a'
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
    // Smooth scroll untuk anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
        const targetId = this.getAttribute('href');
        if (targetId === '#') return;
        
        const target = document.querySelector(targetId);
        if (target) {
            e.preventDefault();
            target.scrollIntoView({ 
                behavior: 'smooth', 
                block: 'start' 
            });
            
            // Tutup mobile menu jika terbuka
            const mobileMenu = document.getElementById('mobileMenu');
            const mobileBtn = document.getElementById('mobileMenuBtn');
            if (mobileMenu && mobileMenu.classList.contains('open')) {
                mobileMenu.classList.remove('open');
                mobileBtn?.classList.remove('active');
            }
        }
    });
});
</script>

</body>
</html>