<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<style>
    * { margin:0; padding:0; box-sizing:border-box; }
    body { font-family:'DejaVu Sans',sans-serif; font-size:11px; color:#1a0000; }

    .header { background:#8B0000; color:#fff; padding:16px 20px; margin-bottom:16px; overflow:hidden; }
    .header h1 { font-size:16px; font-weight:700; margin:0 0 2px; }
    .header p  { font-size:9px; opacity:0.75; margin:0; }
    .meta { float:right; text-align:right; font-size:9px; opacity:0.85; line-height:1.6; }

    .summary { margin-bottom:14px; border:1px solid #fde8e8; border-radius:6px; padding:8px 12px; background:#fef2f2; font-size:10px; }
    .summary span { color:#8B0000; font-weight:700; }

    table { width:100%; border-collapse:collapse; }
    thead tr { background:#8B0000; color:#fff; }
    thead th { padding:8px 10px; text-align:left; font-size:9px; font-weight:700; text-transform:uppercase; letter-spacing:0.05em; }
    tbody tr:nth-child(even) { background:#fef2f2; }
    tbody tr:nth-child(odd)  { background:#fff; }
    tbody td { padding:7px 10px; font-size:10px; border-bottom:1px solid #fde8e8; vertical-align:top; }

    .footer { margin-top:14px; text-align:right; font-size:8px; color:#9e4a4a; border-top:1px solid #fde8e8; padding-top:6px; }
</style>
</head>
<body>

<div class="header">
    <div class="meta">
        Dicetak: {{ \Carbon\Carbon::now()->format('d M Y, H:i') }}<br>
        Pustaloka Library
    </div>
    <h1>Laporan Data Buku</h1>
    <p>Daftar lengkap koleksi buku perpustakaan Pustaloka</p>
</div>

<div class="summary">
    Total buku: <span>{{ $buku->count() }} judul</span> &nbsp;&bull;&nbsp;
    Total stok: <span>{{ $buku->sum('stock') }} buku</span>
</div>

<table>
    <thead>
        <tr>
            <th style="width:24px;">No</th>
            <th>Judul Buku</th>
            <th>Penulis</th>
            <th>Penerbit</th>
            <th>Kategori</th>
            <th style="width:44px;">Tahun</th>
            <th style="width:36px;text-align:center;">Stok</th>
        </tr>
    </thead>
    <tbody>
        @foreach($buku as $i => $b)
        <tr>
            <td style="color:#aaa;">{{ $i + 1 }}</td>
            <td style="font-weight:600;">{{ $b->judul }}</td>
            <td>{{ $b->penulis }}</td>
            <td>{{ $b->penerbit }}</td>
            <td>{{ $b->kategoris->pluck('nama_kategori')->join(', ') ?: '-' }}</td>
            <td>{{ $b->tahun_terbit }}</td>
            <td style="text-align:center;font-weight:700;color:#8B0000;">{{ $b->stock }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="footer">
    Laporan digenerate otomatis &bull; Pustaloka Library &bull; {{ \Carbon\Carbon::now()->format('d M Y') }}
</div>

</body>
</html>