<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Keuangan DEMA FEBI</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; color: #333; margin: 20px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #1F3864; padding-bottom: 10px; }
        .header h2 { color: #1F3864; margin: 0; font-size: 16px; }
        table.data { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table.data th { background: #1F3864; color: white; padding: 8px; font-size: 11px; }
        table.data td { padding: 7px 8px; border-bottom: 1px solid #ddd; font-size: 11px; }
        table.data tr:nth-child(even) { background: #f9f9f9; }
        .masuk  { color: #065f46; font-weight: bold; }
        .keluar { color: #991b1b; font-weight: bold; }
        .summary { margin-top: 15px; padding: 10px; background: #f5f5f5; border-radius: 4px; }
        .footer { margin-top: 20px; font-size: 10px; color: #999; text-align: center; border-top: 1px solid #ddd; padding-top: 8px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>DEMA FEBI UIN MAHMUD YUNUS BATUSANGKAR</h2>
        <p>Dewan Eksekutif Mahasiswa Fakultas Ekonomi dan Bisnis Islam</p>
        <h3 style="margin:8px 0 0; color:#333">LAPORAN KEUANGAN ORGANISASI</h3>
        <p style="font-size:10px">Per {{ now()->format('d F Y') }}</p>
    </div>

    <table class="data">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Jenis</th>
                <th>Keterangan</th>
                <th>Nominal</th>
                <th>Dicatat Oleh</th>
            </tr>
        </thead>
        <tbody>
            @forelse($kas as $index => $item)
            <tr>
                <td style="text-align:center">{{ $index + 1 }}</td>
                <td>{{ $item->tanggal->format('d M Y') }}</td>
                <td class="{{ $item->jenis }}">
                    {{ $item->jenis === 'masuk' ? 'Kas Masuk' : 'Kas Keluar' }}
                </td>
                <td>{{ $item->keterangan }}</td>
                <td class="{{ $item->jenis }}">
                    Rp {{ number_format($item->nominal, 0, ',', '.') }}
                </td>
                <td>{{ $item->createdBy->name ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align:center; color:#999">Belum ada data kas</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="summary">
        <table style="width:100%">
            <tr>
                <td style="color:#065f46; font-weight:bold">Total Kas Masuk</td>
                <td style="color:#065f46; font-weight:bold; text-align:right">
                    Rp {{ number_format($totalMasuk, 0, ',', '.') }}
                </td>
            </tr>
            <tr>
                <td style="color:#991b1b; font-weight:bold">Total Kas Keluar</td>
                <td style="color:#991b1b; font-weight:bold; text-align:right">
                    Rp {{ number_format($totalKeluar, 0, ',', '.') }}
                </td>
            </tr>
            <tr style="border-top: 2px solid #1F3864">
                <td style="color:#1F3864; font-weight:bold; font-size:13px">Saldo Akhir</td>
                <td style="color:#1F3864; font-weight:bold; font-size:13px; text-align:right">
                    Rp {{ number_format($saldo, 0, ',', '.') }}
                </td>
            </tr>
        </table>
    </div>

    <div class="footer">
        Dicetak pada: {{ now()->format('d F Y, H:i') }} WIB &nbsp;|&nbsp;
        Sistem Informasi DEMA FEBI UIN Mahmud Yunus Batusangkar
    </div>
</body>
</html>