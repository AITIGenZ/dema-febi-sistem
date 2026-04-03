<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Daftar Hadir - {{ $kegiatan->nama_kegiatan }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #1F3864;
            padding-bottom: 10px;
        }
        .header h2 {
            color: #1F3864;
            margin: 0;
            font-size: 16px;
        }
        .header p {
            margin: 4px 0;
            font-size: 11px;
            color: #666;
        }
        .info-box {
            background: #f5f5f5;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 15px;
        }
        .info-box table {
            width: 100%;
        }
        .info-box td {
            padding: 3px 8px;
            font-size: 11px;
        }
        .info-box td:first-child {
            font-weight: bold;
            width: 150px;
            color: #1F3864;
        }
        table.data {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table.data th {
            background: #1F3864;
            color: white;
            padding: 8px;
            text-align: left;
            font-size: 11px;
        }
        table.data td {
            padding: 7px 8px;
            border-bottom: 1px solid #ddd;
            font-size: 11px;
        }
        table.data tr:nth-child(even) {
            background: #f9f9f9;
        }
        .badge {
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 10px;
            font-weight: bold;
        }
        .hadir  { background: #d1fae5; color: #065f46; }
        .izin   { background: #fef3c7; color: #92400e; }
        .alpha  { background: #fee2e2; color: #991b1b; }
        .footer {
            margin-top: 20px;
            font-size: 10px;
            color: #999;
            text-align: center;
            border-top: 1px solid #ddd;
            padding-top: 8px;
        }
        .rekap {
            margin-top: 15px;
            display: flex;
            gap: 10px;
        }
        .rekap-item {
            padding: 8px 15px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: bold;
        }
    </style>
</head>
<body>

    {{-- Header --}}
    <div class="header">
        <h2>DEMA FEBI UIN MAHMUD YUNUS BATUSANGKAR</h2>
        <p>Dewan Eksekutif Mahasiswa Fakultas Ekonomi dan Bisnis Islam</p>
        <h3 style="margin:8px 0 0; color:#333">DAFTAR HADIR KEGIATAN</h3>
    </div>

    {{-- Info Kegiatan --}}
    <div class="info-box">
        <table>
            <tr>
                <td>Nama Kegiatan</td>
                <td>: {{ $kegiatan->nama_kegiatan }}</td>
            </tr>
            <tr>
                <td>Tanggal</td>
                <td>: {{ $kegiatan->tanggal->format('d F Y, H:i') }} WIB</td>
            </tr>
            <tr>
                <td>Lokasi</td>
                <td>: {{ $kegiatan->lokasi ?? '-' }}</td>
            </tr>
            <tr>
                <td>Divisi</td>
                <td>: {{ $kegiatan->divisi->nama_divisi ?? 'Semua Divisi' }}</td>
            </tr>
            <tr>
                <td>Total Peserta</td>
                <td>: {{ $absensis->count() }} orang</td>
            </tr>
        </table>
    </div>

    {{-- Tabel Absensi --}}
    <table class="data">
        <thead>
            <tr>
                <th style="width:40px">No</th>
                <th>Nama Anggota</th>
                <th>NIM</th>
                <th>Divisi</th>
                <th>Status</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($absensis as $index => $absensi)
            <tr>
                <td style="text-align:center">{{ $index + 1 }}</td>
                <td>{{ $absensi->user->name }}</td>
                <td>{{ $absensi->user->nim ?? '-' }}</td>
                <td>{{ $absensi->user->divisi->nama_divisi ?? '-' }}</td>
                <td>
                    <span class="badge {{ $absensi->status }}">
                        {{ ucfirst($absensi->status) }}
                    </span>
                </td>
                <td>{{ $absensi->keterangan ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align:center; color:#999">
                    Belum ada data absensi
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Rekap --}}
    <table style="margin-top:15px; width:100%">
        <tr>
            <td style="padding:5px 10px; background:#d1fae5; color:#065f46; font-weight:bold; border-radius:4px; margin-right:5px">
                Hadir: {{ $absensis->where('status', 'hadir')->count() }}
            </td>
            <td style="padding:5px 10px; background:#fef3c7; color:#92400e; font-weight:bold; border-radius:4px">
                Izin: {{ $absensis->where('status', 'izin')->count() }}
            </td>
            <td style="padding:5px 10px; background:#fee2e2; color:#991b1b; font-weight:bold; border-radius:4px">
                Alpha: {{ $absensis->where('status', 'alpha')->count() }}
            </td>
        </tr>
    </table>

    {{-- Footer --}}
    <div class="footer">
        <p>Dicetak pada: {{ now()->format('d F Y, H:i') }} WIB &nbsp;|&nbsp;
        Sistem Informasi DEMA FEBI UIN Mahmud Yunus Batusangkar</p>
    </div>

</body>
</html>