<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<style>
    * { margin:0; padding:0; box-sizing:border-box; }
    body { font-family: 'DejaVu Sans', sans-serif; font-size:11px; color:#1a0000; background:#fff; }

    .header { background:#15803d; color:#fff; padding:18px 24px; margin-bottom:16px; }
    .header h1 { font-size:18px; font-weight:700; margin:0 0 2px; }
    .header p  { font-size:10px; opacity:0.8; margin:0; }
    .meta { float:right; text-align:right; font-size:10px; opacity:0.85; }

    .filter-info { background:#f0fdf4; border:1px solid #bbf7d0; border-radius:6px; padding:7px 12px; margin-bottom:14px; font-size:10px; color:#15803d; }

    table { width:100%; border-collapse:collapse; }
    thead tr { background:#15803d; color:#fff; }
    thead th { padding:9px 10px; text-align:left; font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:0.05em; }
    tbody tr:nth-child(even) { background:#f0fdf4; }
    tbody tr:nth-child(odd)  { background:#fff; }
    tbody td { padding:8px 10px; font-size:10px; border-bottom:1px solid #bbf7d0; vertical-align:middle; }

    .ket { display:inline-block; padding:2px 8px; border-radius:999px; font-size:9px; font-weight:700; }
    .ket-tepat     { background:#f0fdf4; color:#15803d; }
    .ket-terlambat { background:#fff7ed; color:#c2410c; }

    .footer { margin-top:20px; text-align:right; font-size:9px; color:#15803d; }
</style>
</head>
<body>

<div class="header">
    <div class="meta">
        Dicetak: {{ \Carbon\Carbon::now()->format('d M Y, H:i') }}<br>
        Pustaloka Library
    </div>
    <h1>Laporan Pengembalian</h1>
    <p>Riwayat buku yang sudah dikembalikan</p>
</div>

@php
    $bulanNama   = ['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
    $filterAktif = collect($filter)->filter()->isNotEmpty();
    $totalTerlambat = $pengembalian->filter(fn($p) =>
        $p->tanggal_dikembalikan && $p->tanggal_kembali &&
        \Carbon\Carbon::parse($p->tanggal_dikembalikan)->greaterThan($p->tanggal_kembali)
    )->count();
    $totalTepat = $pengembalian->count() - $totalTerlambat;
@endphp

@if($filterAktif)
<div class="filter-info">
    <strong>Filter:</strong>
    @if($filter['tgl_mulai'] || $filter['tgl_akhir'])
        Tanggal dikembalikan:
        {{ $filter['tgl_mulai'] ? \Carbon\Carbon::parse($filter['tgl_mulai'])->format('d M Y') : '—' }}
        s/d
        {{ $filter['tgl_akhir'] ? \Carbon\Carbon::parse($filter['tgl_akhir'])->format('d M Y') : '—' }}
    @endif
    @if($filter['bulan'])
        &nbsp;|&nbsp; Bulan: {{ $bulanNama[(int)$filter['bulan']] }}
    @endif
    @if($filter['tahun'])
        &nbsp;|&nbsp; Tahun: {{ $filter['tahun'] }}
    @endif
    &nbsp;&nbsp; Total: <strong>{{ $pengembalian->count() }} data</strong>
    &nbsp;|&nbsp; Tepat Waktu: <strong>{{ $totalTepat }}</strong>
    &nbsp;|&nbsp; Terlambat: <strong>{{ $totalTerlambat }}</strong>
</div>
@else
<table style="width:auto;border-collapse:collapse;margin-bottom:14px;">
    <tr>
        <td style="font-size:10px;color:#6b7280;padding:2px 12px 2px 0;">Total Dikembalikan</td>
        <td style="font-size:10px;font-weight:700;color:#15803d;">{{ $pengembalian->count() }} data</td>
    </tr>
    <tr>
        <td style="font-size:10px;color:#6b7280;padding:2px 12px 2px 0;">Tepat Waktu</td>
        <td style="font-size:10px;font-weight:700;color:#15803d;">{{ $totalTepat }} data</td>
    </tr>
    <tr>
        <td style="font-size:10px;color:#6b7280;padding:2px 12px 2px 0;">Terlambat</td>
        <td style="font-size:10px;font-weight:700;color:#c2410c;">{{ $totalTerlambat }} data</td>
    </tr>
</table>
@endif

<table>
    <thead>
        <tr>
            <th style="width:28px;">No</th>
            <th>Peminjam</th>
            <th>Buku</th>
            <th>Batas Kembali</th>
            <th>Tgl Dikembalikan</th>
            <th>Keterlambatan</th>
            <th>Keterangan</th>
        </tr>
    </thead>
    <tbody>
        @forelse($pengembalian as $i => $p)
        @php
            $terlambatHari = 0;
            if ($p->tanggal_dikembalikan && $p->tanggal_kembali) {
                $d = \Carbon\Carbon::parse($p->tanggal_dikembalikan);
                $s = \Carbon\Carbon::parse($p->tanggal_kembali);
                if ($d->greaterThan($s)) $terlambatHari = $s->diffInDays($d);
            }
        @endphp
        <tr>
            <td style="color:#aaa;">{{ $i + 1 }}</td>
            <td>
                <div style="font-weight:600;color:#1a0000;">{{ $p->user->name }}</div>
                <div style="color:#6b7280;font-size:9px;">{{ $p->user->email }}</div>
            </td>
            <td style="font-weight:600;">{{ $p->buku->judul }}</td>
            <td>{{ $p->tanggal_kembali ? \Carbon\Carbon::parse($p->tanggal_kembali)->format('d M Y') : '-' }}</td>
            <td>{{ $p->tanggal_dikembalikan ? \Carbon\Carbon::parse($p->tanggal_dikembalikan)->format('d M Y') : '-' }}</td>
            <td style="color:{{ $terlambatHari > 0 ? '#c2410c' : '#15803d' }};font-weight:700;">
                {{ $terlambatHari > 0 ? $terlambatHari.' hari' : '-' }}
            </td>
            <td>
                @if($terlambatHari > 0)
                    <span class="ket ket-terlambat">Terlambat</span>
                @else
                    <span class="ket ket-tepat">Tepat Waktu</span>
                @endif
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="7" style="text-align:center;padding:20px;color:#9ca3af;">Tidak ada data untuk filter yang dipilih</td>
        </tr>
        @endforelse
    </tbody>
</table>

<div class="footer">
    Laporan ini digenerate otomatis oleh sistem Pustaloka &bull; {{ \Carbon\Carbon::now()->format('d M Y') }}
</div>

</body>
</html>