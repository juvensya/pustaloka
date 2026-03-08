@extends('layout.app')

@section('content')

<div id="bukti-wrap" style="background:#f9fafb;min-height:100vh;">
<div style="width:100%;max-width:640px;margin:0 auto;">

    {{-- HEADER --}}
    <div style="color:#8B0000;padding:36px 40px 28px;text-align:center;">
        <div style="font-size:11px;letter-spacing:0.2em;text-transform:uppercase;opacity:0.7;margin-bottom:8px;">Perpustakaan Digital</div>
        <div style="font-size:32px;font-weight:600;letter-spacing:0.05em;margin-bottom:6px;">PUSTALOKA</div>
        <div style="font-size:12px;opacity:0.6;letter-spacing:0.12em;text-transform:uppercase;">Bukti Peminjaman Buku</div>
    </div>

    {{-- ZIGZAG --}}
    <div style="width:100%;height:14px;background:repeating-linear-gradient(-45deg,#8B0000 0px,#8B0000 10px,#fff 10px,#fff 20px);"></div>

    {{-- BODY --}}
    <div style="background:#fff;padding:32px 40px;">

        {{-- BADGE --}}
        <div style="text-align:center;margin-bottom:20px;">
            <span style="display:inline-block;background:#f3f4f6;color:#374151;border:1px solid #d1d5db;border-radius:999px;padding:8px 28px;font-size:13px;font-weight:400;letter-spacing:0.04em;">
                Peminjaman Disetujui
            </span>
        </div>

        {{-- NO STRUK --}}
        <div style="text-align:center;font-size:12px;color:#aaa;margin-bottom:24px;letter-spacing:0.08em;">
            NO. #{{ str_pad($peminjaman->id, 6, '0', STR_PAD_LEFT) }}
            &nbsp;&middot;&nbsp;
            {{ \Carbon\Carbon::now('Asia/Jakarta')->format('d M Y, H:i') }} WIB
        </div>

        <hr style="border:none;border-top:1px dashed #e0c0c0;margin:0 0 20px;">

        {{-- INFO BUKU --}}
        <div style="font-size:10px;font-weight:400;text-transform:uppercase;letter-spacing:0.15em;color:#9e4a4a;margin-bottom:14px;">Informasi Buku</div>

        <div style="display:table;width:100%;margin-bottom:10px;">
            <span style="display:table-cell;font-size:13px;color:#9e6060;font-weight:400;width:45%;">Judul Buku</span>
            <span style="display:table-cell;font-size:13px;color:#ccc;width:5%;text-align:center;">:</span>
            <span style="display:table-cell;font-size:13px;font-weight:400;color:#1a0000;width:50%;text-align:right;">{{ $peminjaman->buku->judul }}</span>
        </div>
        <div style="display:table;width:100%;margin-bottom:10px;">
            <span style="display:table-cell;font-size:13px;color:#9e6060;font-weight:400;width:45%;">Penulis</span>
            <span style="display:table-cell;font-size:13px;color:#ccc;width:5%;text-align:center;">:</span>
            <span style="display:table-cell;font-size:13px;font-weight:400;color:#1a0000;width:50%;text-align:right;">{{ $peminjaman->buku->penulis }}</span>
        </div>
        <div style="display:table;width:100%;margin-bottom:10px;">
            <span style="display:table-cell;font-size:13px;color:#9e6060;font-weight:400;width:45%;">Penerbit</span>
            <span style="display:table-cell;font-size:13px;color:#ccc;width:5%;text-align:center;">:</span>
            <span style="display:table-cell;font-size:13px;font-weight:400;color:#1a0000;width:50%;text-align:right;">{{ $peminjaman->buku->penerbit ?? '-' }}</span>
        </div>
        <div style="display:table;width:100%;margin-bottom:10px;">
            <span style="display:table-cell;font-size:13px;color:#9e6060;font-weight:400;width:45%;">Tahun Terbit</span>
            <span style="display:table-cell;font-size:13px;color:#ccc;width:5%;text-align:center;">:</span>
            <span style="display:table-cell;font-size:13px;font-weight:400;color:#1a0000;width:50%;text-align:right;">{{ $peminjaman->buku->tahun_terbit ?? '-' }}</span>
        </div>

        <hr style="border:none;border-top:1px dashed #e0c0c0;margin:20px 0;">

        {{-- INFO PEMINJAM --}}
        <div style="font-size:10px;font-weight:400;text-transform:uppercase;letter-spacing:0.15em;color:#9e4a4a;margin-bottom:14px;">Informasi Peminjam</div>

        <div style="display:table;width:100%;margin-bottom:10px;">
            <span style="display:table-cell;font-size:13px;color:#9e6060;font-weight:400;width:45%;">Nama</span>
            <span style="display:table-cell;font-size:13px;color:#ccc;width:5%;text-align:center;">:</span>
            <span style="display:table-cell;font-size:13px;font-weight:400;color:#1a0000;width:50%;text-align:right;">{{ $peminjaman->user->name }}</span>
        </div>
        <div style="display:table;width:100%;margin-bottom:10px;">
            <span style="display:table-cell;font-size:13px;color:#9e6060;font-weight:400;width:45%;">Email</span>
            <span style="display:table-cell;font-size:13px;color:#ccc;width:5%;text-align:center;">:</span>
            <span style="display:table-cell;font-size:13px;font-weight:400;color:#1a0000;width:50%;text-align:right;">{{ $peminjaman->user->email }}</span>
        </div>

        <hr style="border:none;border-top:1px dashed #e0c0c0;margin:20px 0;">

        {{-- PERIODE --}}
        <div style="font-size:10px;font-weight:400;text-transform:uppercase;letter-spacing:0.15em;color:#9e4a4a;margin-bottom:14px;">Periode Peminjaman</div>

        <div style="background:#fef2f2;border:1px solid #fde8e8;border-radius:10px;padding:16px 20px;">
            <div style="display:table;width:100%;margin-bottom:8px;">
                <span style="display:table-cell;font-size:13px;color:#9e6060;font-weight:400;width:45%;">Tanggal Pinjam</span>
                <span style="display:table-cell;font-size:13px;color:#ccc;width:5%;text-align:center;">:</span>
                <span style="display:table-cell;font-size:13px;font-weight:400;color:#8B0000;width:50%;text-align:right;">{{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d M Y') }}</span>
            </div>
            <hr style="border:none;border-top:1px solid #f0e0e0;margin:8px 0;">
            <div style="display:table;width:100%;margin-bottom:8px;">
                <span style="display:table-cell;font-size:13px;color:#9e6060;font-weight:400;width:45%;">Batas Kembali</span>
                <span style="display:table-cell;font-size:13px;color:#ccc;width:5%;text-align:center;">:</span>
                <span style="display:table-cell;font-size:13px;font-weight:400;color:#8B0000;width:50%;text-align:right;">{{ \Carbon\Carbon::parse($peminjaman->tanggal_kembali)->format('d M Y') }}</span>
            </div>
            <hr style="border:none;border-top:1px solid #f0e0e0;margin:8px 0;">
            <div style="display:table;width:100%;">
                <span style="display:table-cell;font-size:13px;color:#9e6060;font-weight:400;width:45%;">Durasi</span>
                <span style="display:table-cell;font-size:13px;color:#ccc;width:5%;text-align:center;">:</span>
                <span style="display:table-cell;font-size:13px;font-weight:400;color:#8B0000;width:50%;text-align:right;">{{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->diffInDays($peminjaman->tanggal_kembali) }} hari</span>
            </div>
        </div>

        <hr style="border:none;border-top:1px dashed #e0c0c0;margin:20px 0;">

        {{-- PESAN --}}
        <p style="text-align:center;font-size:11px;color:#9e6060;line-height:1.7;margin:0;">
            Harap kembalikan buku tepat waktu.<br>
            Keterlambatan pengembalian akan dicatat dalam sistem.
        </p>
    </div>

    {{-- ZIGZAG BAWAH --}}
    <div style="width:100%;height:14px;background:repeating-linear-gradient(45deg,#8B0000 0px,#8B0000 10px,#fff 10px,#fff 20px);"></div>

    {{-- FOOTER --}}
    <div style="background:#fff;text-align:center;padding:18px 40px 24px;border-top:1px solid #fde8e8;">
        <p style="font-size:11px;color:#bbb;margin-bottom:3px;">Dicetak otomatis oleh sistem Pustaloka</p>
        <p style="font-size:11px;color:#bbb;">{{ \Carbon\Carbon::now('Asia/Jakarta')->format('d M Y, H:i') }} WIB</p>
        <div style="font-size:14px;font-weight:400;color:#8B0000;margin-top:10px;">Terima Kasih</div>
    </div>

</div>
</div>

<style>
    #bukti-wrap, #bukti-wrap * {
        font-family: Arial, sans-serif !important;
    }
    @media print {
        .no-print { display: none !important; }
        nav, header, .navbar, .sidebar { display: none !important; }
        body { margin: 0 !important; padding: 0 !important; }
    }
</style>

@endsection