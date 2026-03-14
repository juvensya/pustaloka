<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<style>
    * { margin:0; padding:0; box-sizing:border-box; }
    body { font-family: 'DejaVu Sans', sans-serif; font-size:11px; color:#1a0000; background:#fff; }

    .header { background:#1d4ed8; color:#fff; padding:18px 24px; margin-bottom:16px; }
    .header h1 { font-size:18px; font-weight:700; margin:0 0 2px; }
    .header p  { font-size:10px; opacity:0.8; margin:0; }
    .meta { float:right; text-align:right; font-size:10px; opacity:0.85; }

    .filter-info { background:#eff6ff; border:1px solid #bfdbfe; border-radius:6px; padding:7px 12px; margin-bottom:14px; font-size:10px; color:#1d4ed8; }

    table { width:100%; border-collapse:collapse; }
    thead tr { background:#1d4ed8; color:#fff; }
    thead th { padding:9px 10px; text-align:left; font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:0.05em; }
    tbody tr:nth-child(even) { background:#eff6ff; }
    tbody tr:nth-child(odd)  { background:#fff; }
    tbody td { padding:8px 10px; font-size:10px; border-bottom:1px solid #dbeafe; vertical-align:middle; }

    .status { display:inline-block; padding:2px 8px; border-radius:999px; font-size:9px; font-weight:700; }
    .s-menunggu         { background:#fefce8; color:#a16207; }
    .s-disetujui        { background:#f0fdf4; color:#15803d; }
    .s-terlambat        { background:#fff7ed; color:#c2410c; }
    .s-menunggu_kembali { background:#eff6ff; color:#1d4ed8; }

    .footer { margin-top:20px; text-align:right; font-size:9px; color:#1d4ed8; }

    @php
        $bulanNama = ['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
    @endphp
</style>
</head>
<body>

<div class="header">
    <div class="meta">
        Dicetak: {{ \Carbon\Carbon::now()->format('d M Y, H:i') }}<br>
        Pustaloka Library
    </div>
    <h1>Laporan Peminjaman</h1>
    <p>Data peminjaman buku perpustakaan</p>
</div>

@php
    $bulanNama = ['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
    $filterAktif = collect($filter)->filter()->isNotEmpty();
@endphp

@if($filterAktif)
<div class="filter-info">
    <strong>Filter:</strong>
    @if($filter['tgl_mulai'] || $filter['tgl_akhir'])
        Tanggal:
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
    &nbsp;&nbsp; Total: <strong>{{ $peminjaman->count() }} data</strong>
</div>
@else
<table style="width:auto;border-collapse:collapse;margin-bottom:14px;">
    <tr>
        <td style="font-size:10px;color:#6b7280;padding:2px 12px 2px 0;">Total Peminjaman</td>
        <td style="font-size:10px;font-weight:700;color:#1d4ed8;">{{ $peminjaman->count() }} data</td>
    </tr>
</table>
@endif

<table>
    <thead>
        <tr>
            <th style="width:28px;">No</th>
            <th>Peminjam</th>
            <th>Buku</th>
            <th>Tgl Pinjam</th>
            <th>Batas Kembali</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @forelse($peminjaman as $i => $p)
        @php
            $late = $p->tanggal_kembali && \Carbon\Carbon::now()->greaterThan($p->tanggal_kembali);
        @endphp
        <tr>
            <td style="color:#aaa;">{{ $i + 1 }}</td>
            <td>
                <div style="font-weight:600;color:#1a0000;">{{ $p->user->name }}</div>
                <div style="color:#6b7280;font-size:9px;">{{ $p->user->email }}</div>
            </td>
            <td style="font-weight:600;">{{ $p->buku->judul }}</td>
            <td>{{ $p->tanggal_pinjam ? \Carbon\Carbon::parse($p->tanggal_pinjam)->format('d M Y') : '-' }}</td>
            <td style="color:{{ $late ? '#c2410c' : '#374151' }};font-weight:{{ $late ? '700' : '400' }};">
                {{ $p->tanggal_kembali ? \Carbon\Carbon::parse($p->tanggal_kembali)->format('d M Y') : '-' }}
            </td>
            <td>
                <span class="status s-{{ $p->status }}">
                    {{ ucfirst(str_replace('_', ' ', $p->status)) }}
                </span>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6" style="text-align:center;padding:20px;color:#9ca3af;">Tidak ada data untuk filter yang dipilih</td>
        </tr>
        @endforelse
    </tbody>
</table>

<div class="footer">
    Laporan ini digenerate otomatis oleh sistem Pustaloka &bull; {{ \Carbon\Carbon::now()->format('d M Y') }}
</div>

</body>
</html>