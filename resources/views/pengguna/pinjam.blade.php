@extends('layouts.app')

@section('content')

<div style="font-family:'Plus Jakarta Sans',sans-serif;min-height:100vh;background:#f9fafb;padding:2.5rem 1.5rem;">
<div style="max-width:1100px;margin:0 auto;">

    {{-- Header --}}
    <div style="display:flex;align-items:center;gap:1rem;margin-bottom:2rem;">
        <div>
            <h1 style="font-size:1.6rem;font-weight:700;color:#1a0000;margin:0;line-height:1.2;">Daftar Peminjaman Saya</h1>
            <p style="font-size:0.85rem;color:#9e4a4a;margin:2px 0 0;">Riwayat & status peminjaman buku Anda</p>
        </div>
    </div>

    {{-- ALERT SUCCESS --}}
    @if(session('success'))
    <div id="alert-success" style="display:flex;align-items:center;gap:0.75rem;padding:0.9rem 1.2rem;border-radius:12px;font-size:0.875rem;font-weight:500;margin-bottom:1.25rem;background:#f0fdf4;border:1px solid #bbf7d0;color:#15803d;transition:opacity 0.5s ease;">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        {{ session('success') }}
    </div>
    @endif

    {{-- ALERT ERROR --}}
    @if(session('error'))
    <div id="alert-error" style="display:flex;align-items:center;gap:0.75rem;padding:0.9rem 1.2rem;border-radius:12px;font-size:0.875rem;font-weight:500;margin-bottom:1.25rem;background:#fef2f2;border:1px solid #fecaca;color:#8B0000;transition:opacity 0.5s ease;">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
        {{ session('error') }}
    </div>
    @endif

    @php
        $aktif   = $data->whereIn('status', ['menunggu', 'disetujui', 'menunggu_kembali', 'terlambat']);
        $riwayat = $data->whereIn('status', ['dikembalikan', 'ditolak']);
    @endphp

    {{-- TAB FILTER --}}
    <div style="display:flex;gap:0.5rem;margin-bottom:1.5rem;">
        <button onclick="switchTab('aktif')" id="tab-aktif"
            style="padding:0.55rem 1.4rem;border-radius:999px;font-size:0.85rem;font-weight:600;cursor:pointer;border:none;background:#8B0000;color:#fff;font-family:inherit;">
            Peminjaman Aktif
            <span style="background:rgba(255,255,255,0.25);font-size:0.7rem;padding:0.1rem 0.45rem;border-radius:999px;margin-left:4px;">{{ $aktif->count() }}</span>
        </button>
        <button onclick="switchTab('riwayat')" id="tab-riwayat"
            style="padding:0.55rem 1.4rem;border-radius:999px;font-size:0.85rem;font-weight:600;cursor:pointer;border:1px solid #e5e7eb;background:#fff;color:#6b7280;font-family:inherit;">
            Riwayat
            <span style="background:#f3f4f6;font-size:0.7rem;padding:0.1rem 0.45rem;border-radius:999px;margin-left:4px;">{{ $riwayat->count() }}</span>
        </button>
    </div>

    {{-- TABEL PEMINJAMAN AKTIF --}}
    <div id="section-aktif">
    <div style="margin-bottom:0.75rem;display:flex;align-items:center;gap:0.5rem;">
        <span style="font-size:0.95rem;font-weight:700;color:#1a0000;">Peminjaman Aktif</span>
        <span style="background:#8B0000;color:#fff;font-size:0.7rem;font-weight:700;padding:0.15rem 0.55rem;border-radius:999px;">{{ $aktif->count() }}</span>
    </div>

    <div style="background:#fff;border-radius:18px;overflow:hidden;border:1px solid #fde8e8;margin-bottom:2rem;">
        @if($aktif->count() == 0)
            <div style="text-align:center;padding:2.5rem 2rem;">
                <p style="font-size:0.875rem;color:#c08080;margin:0;">Tidak ada peminjaman aktif saat ini.</p>
            </div>
        @else
            <table style="width:100%;border-collapse:collapse;">
                <thead>
                    <tr style="background:linear-gradient(135deg,#8B0000,#a80000);">
                        <th style="padding:1rem 1.25rem;text-align:left;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.07em;color:rgba(255,255,255,0.8);">Buku</th>
                        <th style="padding:1rem 1.25rem;text-align:left;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.07em;color:rgba(255,255,255,0.8);">Status</th>
                        <th style="padding:1rem 1.25rem;text-align:left;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.07em;color:rgba(255,255,255,0.8);">Tanggal Pinjam</th>
                        <th style="padding:1rem 1.25rem;text-align:left;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.07em;color:rgba(255,255,255,0.8);">Tanggal Kembali</th>
                        <th style="padding:1rem 1.25rem;text-align:left;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.07em;color:rgba(255,255,255,0.8);">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($aktif as $pinjam)
                    <tr style="border-bottom:1px solid #fde8e8;background:{{ $pinjam->status == 'terlambat' ? '#fff8f5' : 'white' }};">

                        {{-- BUKU --}}
                        <td style="padding:0.85rem 1.25rem;font-size:0.875rem;vertical-align:middle;">
                            <div style="display:flex;align-items:center;gap:0.85rem;">
                                @if($pinjam->buku->gambar)
                                    <img src="{{ asset('uploads/buku/' . $pinjam->buku->gambar) }}"
                                         alt="{{ $pinjam->buku->judul }}"
                                         style="width:42px;height:58px;object-fit:cover;border-radius:6px;box-shadow:0 2px 8px rgba(139,0,0,0.2);flex-shrink:0;">
                                @else
                                    <div style="width:42px;height:58px;background:linear-gradient(135deg,#fde8e8,#fcd0d0);border-radius:6px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#8B0000" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                                    </div>
                                @endif
                                <span style="font-weight:600;color:#1a0000;">{{ $pinjam->buku->judul }}</span>
                            </div>
                        </td>

                        {{-- STATUS --}}
                        <td style="padding:0.85rem 1.25rem;vertical-align:middle;">
                            @if($pinjam->status == 'menunggu')
                                <span style="display:inline-flex;align-items:center;gap:0.35rem;padding:0.3rem 0.75rem;border-radius:999px;font-size:0.75rem;font-weight:600;background:#fefce8;color:#a16207;">
                                    <span style="width:6px;height:6px;border-radius:50%;background:currentColor;opacity:0.7;display:inline-block;"></span>Menunggu
                                </span>
                            @elseif($pinjam->status == 'disetujui')
                                <span style="display:inline-flex;align-items:center;gap:0.35rem;padding:0.3rem 0.75rem;border-radius:999px;font-size:0.75rem;font-weight:600;background:#f0fdf4;color:#15803d;">
                                    <span style="width:6px;height:6px;border-radius:50%;background:currentColor;opacity:0.7;display:inline-block;"></span>Disetujui
                                </span>
                            @elseif($pinjam->status == 'terlambat')
                                <span style="display:inline-flex;align-items:center;gap:0.35rem;padding:0.3rem 0.75rem;border-radius:999px;font-size:0.75rem;font-weight:600;background:#fff7ed;color:#c2410c;">
                                    <span style="width:6px;height:6px;border-radius:50%;background:currentColor;opacity:0.7;display:inline-block;"></span>Terlambat
                                </span>
                            @elseif($pinjam->status == 'menunggu_kembali')
                                <span style="display:inline-flex;align-items:center;gap:0.35rem;padding:0.3rem 0.75rem;border-radius:999px;font-size:0.75rem;font-weight:600;background:#eff6ff;color:#1d4ed8;">
                                    <span style="width:6px;height:6px;border-radius:50%;background:currentColor;opacity:0.7;display:inline-block;"></span>Menunggu Konfirmasi Kembali
                                </span>
                            @endif
                        </td>

                        {{-- TANGGAL PINJAM --}}
                        <td style="padding:0.85rem 1.25rem;font-size:0.8rem;color:#9e4a4a;vertical-align:middle;">
                            {{ $pinjam->tanggal_pinjam ?? '-' }}
                        </td>

                        {{-- TANGGAL KEMBALI --}}
                        <td style="padding:0.85rem 1.25rem;font-size:0.8rem;vertical-align:middle;">
                            <span style="color:{{ $pinjam->status == 'terlambat' ? '#c2410c' : '#9e4a4a' }};font-weight:{{ $pinjam->status == 'terlambat' ? '700' : '400' }};">
                                {{ $pinjam->tanggal_kembali ?? '-' }}
                            </span>
                        </td>

                        {{-- AKSI --}}
                        <td style="padding:0.85rem 1.25rem;vertical-align:middle;">
                            <div style="display:flex;flex-direction:column;gap:0.4rem;">

                                {{-- Disetujui: Bukti (pudar) + Kembalikan --}}
                                @if($pinjam->status == 'disetujui')
                                    <button onclick="showBukti(
                                        '{{ addslashes($pinjam->buku->judul) }}',
                                        '{{ addslashes($pinjam->buku->penulis) }}',
                                        '{{ addslashes($pinjam->user->name) }}',
                                        '{{ $pinjam->tanggal_pinjam ?? '-' }}',
                                        '{{ $pinjam->tanggal_kembali ?? '-' }}',
                                        {{ $pinjam->id }}
                                    )" style="display:inline-flex;align-items:center;gap:0.4rem;padding:0.45rem 1rem;border-radius:8px;font-size:0.8rem;font-weight:600;border:1px solid #f5c6c6;cursor:pointer;background:#fef2f2;color:#8B0000;font-family:inherit;width:100px;">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                                        Bukti
                                    </button>
                                    <form action="{{ route('peminjaman.requestKembali', $pinjam->id) }}" method="POST" style="width:100%;">
                                        @csrf @method('PATCH')
                                        <button type="submit" onclick="return confirm('Yakin ingin mengajukan pengembalian buku ini?')"
                                            style="display:inline-flex;align-items:center;gap:0.4rem;padding:0.45rem 1rem;border-radius:8px;font-size:0.8rem;font-weight:600;cursor:pointer;background:#eff6ff;color:#1d4ed8;border:1px solid #bfdbfe;font-family:inherit;width:100px;">
                                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-3.87"/></svg>
                                            Kembalikan
                                        </button>
                                    </form>
                                @endif

                                {{-- Terlambat: Kembalikan --}}
                                @if($pinjam->status == 'terlambat')
                                    <form action="{{ route('peminjaman.requestKembali', $pinjam->id) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <button type="submit" onclick="return confirm('Yakin ingin mengajukan pengembalian buku ini?')"
                                            style="display:inline-flex;align-items:center;gap:0.3rem;padding:0.3rem 0.65rem;border-radius:6px;font-size:0.75rem;font-weight:600;cursor:pointer;background:#fff7ed;color:#c2410c;border:1px solid #fed7aa;font-family:inherit;">
                                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-3.87"/></svg>
                                            Kembalikan
                                        </button>
                                    </form>
                                @endif

                                {{-- Menunggu kembali: info saja --}}
                                @if($pinjam->status == 'menunggu_kembali')
                                    <span style="font-size:0.78rem;color:#1d4ed8;font-style:italic;">Menunggu konfirmasi admin...</span>
                                @endif

                                {{-- Menunggu: bisa hapus --}}
                                @if($pinjam->status == 'menunggu')
                                    <form action="{{ route('peminjaman.destroy', $pinjam->id) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button type="submit" onclick="return confirm('Yakin ingin menghapus peminjaman ini?')"
                                            style="display:inline-flex;align-items:center;gap:0.3rem;padding:0.3rem 0.65rem;border-radius:6px;font-size:0.75rem;font-weight:600;cursor:pointer;background:#fff0f0;color:#8B0000;border:1px solid #fecaca;font-family:inherit;">
                                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                                            Hapus
                                        </button>
                                    </form>
                                @endif

                            </div>
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
    </div>{{-- end section-aktif --}}

    {{-- TABEL RIWAYAT --}}
    <div id="section-riwayat" style="display:none;">
    <div style="margin-bottom:0.75rem;display:flex;align-items:center;gap:0.5rem;">
        <span style="font-size:0.95rem;font-weight:700;color:#1a0000;">Riwayat Peminjaman</span>
        <span style="background:#6b7280;color:#fff;font-size:0.7rem;font-weight:700;padding:0.15rem 0.55rem;border-radius:999px;">{{ $riwayat->count() }}</span>
    </div>

    <div style="background:#fff;border-radius:18px;overflow:hidden;border:1px solid #ede8e8;">
        @if($riwayat->count() == 0)
            <div style="text-align:center;padding:2.5rem 2rem;">
                <p style="font-size:0.875rem;color:#c08080;margin:0;">Belum ada riwayat peminjaman.</p>
            </div>
        @else
            <table style="width:100%;border-collapse:collapse;">
                <thead>
                    <tr style="background:#f5f0f0;">
                        <th style="padding:1rem 1.25rem;text-align:left;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.07em;color:#9e4a4a;">Buku</th>
                        <th style="padding:1rem 1.25rem;text-align:left;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.07em;color:#9e4a4a;">Status</th>
                        <th style="padding:1rem 1.25rem;text-align:left;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.07em;color:#9e4a4a;">Tanggal Pinjam</th>
                        <th style="padding:1rem 1.25rem;text-align:left;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.07em;color:#9e4a4a;">Tanggal Kembali</th>
                        <th style="padding:1rem 1.25rem;text-align:left;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.07em;color:#9e4a4a;">Tanggal Dikembalikan</th>
                        <th style="padding:1rem 1.25rem;text-align:left;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.07em;color:#9e4a4a;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($riwayat as $pinjam)
                    <tr style="border-bottom:1px solid #f5eeee;opacity:0.85;">

                        <td style="padding:0.85rem 1.25rem;font-size:0.875rem;vertical-align:middle;">
                            <div style="display:flex;align-items:center;gap:0.85rem;">
                                @if($pinjam->buku->gambar)
                                    <img src="{{ asset('uploads/buku/' . $pinjam->buku->gambar) }}"
                                         alt="{{ $pinjam->buku->judul }}"
                                         style="width:42px;height:58px;object-fit:cover;border-radius:6px;filter:grayscale(30%);flex-shrink:0;">
                                @else
                                    <div style="width:42px;height:58px;background:#f0eded;border-radius:6px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#c0a0a0" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                                    </div>
                                @endif
                                <span style="font-weight:600;color:#4a2020;">{{ $pinjam->buku->judul }}</span>
                            </div>
                        </td>

                        <td style="padding:0.85rem 1.25rem;vertical-align:middle;">
                            @if($pinjam->status == 'dikembalikan')
                                @php
                                    $terlambatHari = 0;
                                    if($pinjam->tanggal_dikembalikan && $pinjam->tanggal_kembali) {
                                        $d = \Carbon\Carbon::parse($pinjam->tanggal_dikembalikan);
                                        $s = \Carbon\Carbon::parse($pinjam->tanggal_kembali);
                                        if($d->greaterThan($s)) $terlambatHari = $s->diffInDays($d);
                                    }
                                @endphp
                                <span style="display:inline-flex;align-items:center;gap:0.35rem;padding:0.3rem 0.75rem;border-radius:999px;font-size:0.75rem;font-weight:600;background:#eff6ff;color:#1d4ed8;">
                                    <span style="width:6px;height:6px;border-radius:50%;background:currentColor;opacity:0.7;display:inline-block;"></span>Dikembalikan
                                </span>
                                @if($terlambatHari > 0)
                                    <div style="margin-top:4px;font-size:0.72rem;font-weight:600;color:#c2410c;">Terlambat {{ $terlambatHari }} hari</div>
                                @else
                                    <div style="margin-top:4px;font-size:0.72rem;font-weight:600;color:#15803d;">Tepat waktu</div>
                                @endif
                            @elseif($pinjam->status == 'ditolak')
                                <span style="display:inline-flex;align-items:center;gap:0.35rem;padding:0.3rem 0.75rem;border-radius:999px;font-size:0.75rem;font-weight:600;background:#fef2f2;color:#8B0000;">
                                    <span style="width:6px;height:6px;border-radius:50%;background:currentColor;opacity:0.7;display:inline-block;"></span>Ditolak
                                </span>
                            @endif
                        </td>

                        <td style="padding:0.85rem 1.25rem;font-size:0.8rem;color:#9e6060;vertical-align:middle;">{{ $pinjam->tanggal_pinjam ?? '-' }}</td>
                        <td style="padding:0.85rem 1.25rem;font-size:0.8rem;color:#9e6060;vertical-align:middle;">{{ $pinjam->tanggal_kembali ?? '-' }}</td>
                        <td style="padding:0.85rem 1.25rem;font-size:0.8rem;color:#9e6060;vertical-align:middle;">{{ $pinjam->tanggal_dikembalikan ?? '-' }}</td>

                        {{-- AKSI RIWAYAT --}}
                        <td style="padding:0.85rem 1.25rem;vertical-align:middle;">
                            @if($pinjam->status == 'dikembalikan')
                                <a href="{{ route('ulasan.create', $pinjam->buku_id) }}"
                                   style="display:inline-flex;align-items:center;gap:0.3rem;padding:0.3rem 0.65rem;border-radius:6px;font-size:0.75rem;font-weight:600;cursor:pointer;background:#fef9ec;color:#a16207;border:1px solid #fde68a;text-decoration:none;">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                                    Review
                                </a>
                            @endif
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
    </div>{{-- end section-riwayat --}}

</div>
</div>

{{-- MODAL BUKTI --}}
<div id="modal-bukti" style="display:none;position:fixed;inset:0;z-index:9999;background:rgba(0,0,0,0.5);align-items:center;justify-content:center;">
    <div style="background:#fff;border-radius:20px;width:100%;max-width:440px;margin:1rem;box-shadow:0 20px 60px rgba(0,0,0,0.3);overflow:hidden;">

        <div style="padding:1.75rem;">
            <div style="display:flex;justify-content:flex-end;margin-bottom:0.5rem;">
                <button onclick="closeBukti()" style="background:#f3f4f6;border:none;color:#6b7280;width:30px;height:30px;border-radius:50%;cursor:pointer;font-size:1rem;display:flex;align-items:center;justify-content:center;">✕</button>
            </div>

            <div style="text-align:center;margin-bottom:1.5rem;">
                <div style="display:inline-flex;align-items:center;justify-content:center;width:60px;height:60px;background:linear-gradient(135deg,#fde8e8,#fcd0d0);border-radius:16px;margin-bottom:0.5rem;">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#8B0000" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                </div>
                <h5 style="font-size:1rem;font-weight:700;color:#1a0000;margin:0 0 2px;">Bukti Peminjaman</h5>
                <p style="font-size:0.75rem;color:#9e4a4a;margin:0;font-weight:600;text-transform:uppercase;letter-spacing:0.05em;">Pustaloka Library</p>
            </div>

            <div style="display:flex;flex-direction:column;gap:0.75rem;">
                <div style="display:flex;justify-content:space-between;align-items:flex-start;padding:0.75rem 1rem;background:#f9fafb;border-radius:10px;">
                    <span style="font-size:0.8rem;color:#9e4a4a;font-weight:600;">Judul Buku</span>
                    <span id="bukti-judul" style="font-size:0.85rem;color:#1a0000;font-weight:700;text-align:right;max-width:55%;"></span>
                </div>
                <div style="display:flex;justify-content:space-between;align-items:center;padding:0.75rem 1rem;background:#f9fafb;border-radius:10px;">
                    <span style="font-size:0.8rem;color:#9e4a4a;font-weight:600;">Penulis</span>
                    <span id="bukti-penulis" style="font-size:0.85rem;color:#1a0000;font-weight:600;"></span>
                </div>
                <div style="display:flex;justify-content:space-between;align-items:center;padding:0.75rem 1rem;background:#f9fafb;border-radius:10px;">
                    <span style="font-size:0.8rem;color:#9e4a4a;font-weight:600;">Nama Peminjam</span>
                    <span id="bukti-nama" style="font-size:0.85rem;color:#1a0000;font-weight:600;"></span>
                </div>
                <div style="display:flex;justify-content:space-between;align-items:center;padding:0.75rem 1rem;background:#fef2f2;border-radius:10px;border:1px solid #fde8e8;">
                    <span style="font-size:0.8rem;color:#9e4a4a;font-weight:600;">Tanggal Pinjam</span>
                    <span id="bukti-tgl-pinjam" style="font-size:0.85rem;color:#8B0000;font-weight:700;"></span>
                </div>
                <div style="display:flex;justify-content:space-between;align-items:center;padding:0.75rem 1rem;background:#fef2f2;border-radius:10px;border:1px solid #fde8e8;">
                    <span style="font-size:0.8rem;color:#9e4a4a;font-weight:600;">Batas Kembali</span>
                    <span id="bukti-tgl-kembali" style="font-size:0.85rem;color:#8B0000;font-weight:700;"></span>
                </div>
            </div>

            <div style="text-align:center;margin-top:1.25rem;">
                <span style="display:inline-flex;align-items:center;gap:0.4rem;padding:0.4rem 1rem;border-radius:999px;font-size:0.75rem;font-weight:700;background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0;">
                    <span style="width:7px;height:7px;border-radius:50%;background:#15803d;display:inline-block;"></span>
                    Peminjaman Disetujui
                </span>
            </div>
        </div>

        <div style="padding:0 1.75rem 1.5rem;text-align:center;display:flex;justify-content:center;gap:0.5rem;">
            <a id="bukti-pdf-link" href="#"
               style="padding:0.6rem 1.5rem;background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0;border-radius:10px;font-size:0.875rem;font-weight:600;cursor:pointer;font-family:inherit;text-decoration:none;display:inline-flex;align-items:center;gap:0.4rem;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                Download PDF
            </a>
        </div>

    </div>
</div>

<script>
    function switchTab(tab) {
        const isAktif = tab === 'aktif';
        document.getElementById('section-aktif').style.display  = isAktif ? 'block' : 'none';
        document.getElementById('section-riwayat').style.display = isAktif ? 'none' : 'block';

        const btnAktif   = document.getElementById('tab-aktif');
        const btnRiwayat = document.getElementById('tab-riwayat');

        btnAktif.style.background  = isAktif ? '#8B0000' : '#fff';
        btnAktif.style.color       = isAktif ? '#fff' : '#6b7280';
        btnAktif.style.border      = isAktif ? 'none' : '1px solid #e5e7eb';

        btnRiwayat.style.background  = isAktif ? '#fff' : '#8B0000';
        btnRiwayat.style.color       = isAktif ? '#6b7280' : '#fff';
        btnRiwayat.style.border      = isAktif ? '1px solid #e5e7eb' : 'none';
    }

    ['alert-success','alert-error'].forEach(function(id) {
        var el = document.getElementById(id);
        if (el) {
            setTimeout(function() {
                el.style.opacity = '0';
                setTimeout(function() { el.style.display = 'none'; }, 500);
            }, 4000);
        }
    });

    function showBukti(judul, penulis, nama, tglPinjam, tglKembali, pinjamId) {
        document.getElementById('bukti-judul').textContent      = judul;
        document.getElementById('bukti-penulis').textContent    = penulis;
        document.getElementById('bukti-nama').textContent       = nama;
        document.getElementById('bukti-tgl-pinjam').textContent = tglPinjam;
        document.getElementById('bukti-tgl-kembali').textContent= tglKembali;
        document.getElementById('bukti-pdf-link').href          = '/peminjaman/' + pinjamId + '/bukti-pdf';
        const modal = document.getElementById('modal-bukti');
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function closeBukti() {
        document.getElementById('modal-bukti').style.display = 'none';
        document.body.style.overflow = '';
    }

    document.getElementById('modal-bukti').addEventListener('click', function(e) {
        if (e.target === this) closeBukti();
    });
</script>

@endsection