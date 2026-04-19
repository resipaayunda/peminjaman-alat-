<!DOCTYPE html>
<html>
<head>
    <title>Laporan Saya</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px; font-size: 12px; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>

<h3>Laporan Peminjaman Saya</h3>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Barang</th>
            <th>Jatuh Tempo</th>
            <th>Kembali</th>
            <th>Status</th>
        </tr>
    </thead>

    <tbody>
        @forelse($laporans as $i => $l)
        <tr>
            <td>{{ $i+1 }}</td>
            <td>{{ $l->tanggal_pinjam }}</td>
            <td>{{ $l->barang }}</td>
            <td>{{ $l->jatuh_tempo }}</td>
            <td>{{ $l->tanggal_kembali ?? '-' }}</td>

            <td>
                @if($l->tanggal_kembali)
                    Selesai
                @elseif(now()->gt($l->jatuh_tempo))
                    Terlambat
                @else
                    Dipinjam
                @endif
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6" style="text-align:center;">
                Tidak ada data
            </td>
        </tr>
        @endforelse
    </tbody>

</table>

</body>
</html>