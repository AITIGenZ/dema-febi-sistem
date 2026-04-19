# 🏛️ Sistem Informasi Manajemen Anggota dan Kegiatan DEMA FEBI
### UIN Mahmud Yunus Batusangkar

![Laravel](https://img.shields.io/badge/Laravel-11.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![Filament](https://img.shields.io/badge/Filament-3.x-F59E0B?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.3-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.x-4479A1?style=for-the-badge&logo=mysql&logoColor=white)

---

## 📋 Tentang Proyek

Sistem Informasi Manajemen Anggota dan Kegiatan DEMA FEBI adalah aplikasi berbasis web yang dirancang untuk mendigitalisasi seluruh proses operasional Dewan Eksekutif Mahasiswa Fakultas Ekonomi dan Bisnis Islam (DEMA FEBI) UIN Mahmud Yunus Batusangkar.

Sistem ini dibangun sebagai bagian dari mata kuliah **Proyek Sistem Informasi** Program Studi Sistem Informasi, FEBI UIN Mahmud Yunus Batusangkar, menggunakan metode pengembangan **Agile**.

---

## 🎯 Masalah yang Diselesaikan

| Masalah | Solusi |
|---|---|
| Pendataan anggota manual via WhatsApp/Excel | Sistem manajemen anggota digital terpusat |
| Pendaftaran kegiatan via kertas/WA | Pendaftaran online dengan konfirmasi otomatis |
| Absensi dicatat di kertas | Absensi digital per kegiatan dengan rekap |
| Keuangan dan iuran tidak transparan | Sistem pencatatan kas dan iuran real-time |
| Tidak ada kalender proker digital | Kalender interaktif yang bisa diakses publik |
| Tidak ada arsip kegiatan terstruktur | Dashboard statistik dan arsip dokumen |

---

## ✨ Fitur Utama

### 👥 Manajemen Anggota & Divisi
- CRUD data anggota lengkap (nama, NIM, email, foto, divisi)
- Manajemen divisi/departemen organisasi
- Sistem role & permission 5 level (Super Admin, Admin, Pengurus, Anggota, Publik)
- Filter dan pencarian data anggota

### 📅 Manajemen Kegiatan & Pendaftaran
- Buat dan kelola kegiatan dengan detail lengkap
- Pendaftaran online dengan sistem kuota
- Konfirmasi pendaftaran (diterima/ditolak)
- Arsip kegiatan yang telah berlangsung

### ✅ Absensi Digital
- Rekam kehadiran: Hadir, Izin, Alpha
- Rekap kehadiran per anggota dan per kegiatan
- Export daftar hadir ke PDF

### 💰 Keuangan & Iuran
- Pencatatan iuran anggota per bulan
- Manajemen kas masuk dan kas keluar
- Laporan keuangan yang dapat diexport ke PDF
- Upload bukti pembayaran iuran

### 🗓️ Kalender Program Kerja
- Kalender interaktif dengan FullCalendar.js
- Filter agenda per divisi
- Dapat diakses publik tanpa login
- Warna penanda berbeda per divisi

### 📊 Dashboard & Statistik
- Statistik real-time: total anggota, kegiatan, iuran
- Grafik anggota per divisi (Chart.js)
- Grafik kegiatan per bulan sepanjang tahun
- Widget statistik dengan indikator warna

### 🌐 Landing Page Publik
- Halaman publik tanpa login
- Info kegiatan terbaru
- Kalender program kerja publik
- Detail kegiatan dan pendaftaran publik

---

## 🛠️ Tech Stack

| Komponen | Teknologi | Versi |
|---|---|---|
| Framework Backend | Laravel | 11.x |
| Admin Panel | Filament PHP | 3.x |
| Bahasa Pemrograman | PHP | 8.3 |
| Database | MySQL | 8.x |
| Role & Permission | Spatie Laravel Permission | 6.x |
| Export PDF | DomPDF (barryvdh) | 3.x |
| Export Excel | Maatwebsite Excel | 3.x |
| Frontend Styling | Tailwind CSS | 3.x |
| Grafik | Chart.js | 4.x |
| Kalender | FullCalendar.js | 6.x |
| Local Server | Laragon | 6.x |
| Version Control | Git & GitHub | - |

---

## 🗄️ Struktur Database

Sistem menggunakan **9 tabel** yang saling berelasi:

```
users           → Data anggota dan pengguna sistem
divisis         → Data divisi/departemen DEMA FEBI
kegiatans       → Data master kegiatan organisasi
pendaftarans    → Data pendaftaran peserta kegiatan
absensis        → Rekam kehadiran anggota per kegiatan
iurans          → Data iuran bulanan anggota
kas             → Arus kas masuk dan keluar organisasi
kalender_prokers → Jadwal program kerja kalender
dokumens        → File dokumen dan foto kegiatan
```

---

## 👤 Akun Default (Seeder)

| Role | Email | Password |
|---|---|---|
| Super Admin (Ketua) | ketua@demafebi.ac.id | password123 |
| Admin (Sekjen) | sekjen@demafebi.ac.id | password123 |
| Pengurus (Kadiv) | kadiv@demafebi.ac.id | password123 |
| Anggota | anggota@demafebi.ac.id | password123 |

> ⚠️ **Penting:** Ganti password default setelah pertama kali login!

---

## 🚀 Cara Instalasi

### Prasyarat
- PHP 8.3+
- Composer
- MySQL 8.x
- Laragon / XAMPP / Herd
- Node.js & NPM

### Langkah Instalasi

**1. Clone repository**
```bash
git clone https://github.com/AITIGenZ/dema-febi-sistem.git
cd dema-febi-sistem
```

**2. Install dependencies PHP**
```bash
composer install
```

**3. Install dependencies NPM**
```bash
npm install
npm run build
```

**4. Salin file environment**
```bash
cp .env.example .env
php artisan key:generate
```

**5. Konfigurasi database di file `.env`**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=dema_febi_db
DB_USERNAME=root
DB_PASSWORD=
```

**6. Jalankan migration dan seeder**
```bash
php artisan migrate:fresh --seed
```

**7. Jalankan server**
```bash
php artisan serve
```

**8. Buka di browser**
```
Landing Page : http://127.0.0.1:8000
Admin Panel  : http://127.0.0.1:8000/admin
```

---

## 📁 Struktur Folder Utama

```
dema-febi-sistem/
├── app/
│   ├── Filament/
│   │   ├── Resources/          → Resource Filament per modul
│   │   └── Widgets/            → Widget dashboard
│   ├── Http/
│   │   └── Controllers/        → Controller PDF & Landing Page
│   └── Models/                 → Model Eloquent semua tabel
├── database/
│   ├── migrations/             → File migration 9 tabel
│   └── seeders/                → Seeder role & user awal
├── resources/
│   └── views/
│       ├── landing/            → Template Landing Page publik
│       └── pdf/                → Template export PDF
└── routes/
    └── web.php                 → Routing aplikasi
```

---

## 👥 Tim Pengembang

| Nama | NIM | Peran |
|---|---|---|
| Alwy Farid Sayuti | 2330407003 | Project Manager & Backend Developer |
| Afdal Ramadhani | 2330407001 | Backend Developer |
| Shafira Anazifa | 2330407062 | Frontend Developer |
| Nurkamila Chaerani | 2330407060 | Analyst & Dokumentasi |

**Dosen Pembimbing:** Abdurrahman Niarman, M.Sc.
**Program Studi:** Sistem Informasi
**Institusi:** UIN Mahmud Yunus Batusangkar

---

## 📄 Lisensi

Proyek ini dikembangkan untuk keperluan akademik mata kuliah Proyek Sistem Informasi UIN Mahmud Yunus Batusangkar.

© 2026 Kelompok 5 - Tim Develop | Sistem Informasi FEBI UIN Mahmud Yunus Batusangkar
