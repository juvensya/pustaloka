@extends('layouts.app')

@section('content')

<style>
    body.modal-open {
        overflow: hidden !important;
        padding-right: 0 !important;
    }
    .notif-auto {
        animation: fadeOut 0.5s ease 3s forwards;
    }
    @keyframes fadeOut {
        to { opacity: 0; height: 0; padding: 0; margin: 0; overflow: hidden; }
    }
</style>

@php
    $peminjamAktif = auth()->user()->peminjamans()
        ->where(function($q) {
            $q->whereIn('status', ['menunggu', 'disetujui', 'terlambat'])
              ->orWhere(function($q2) {
                  $q2->where('status', 'disetujui')
                     ->where('tanggal_kembali', '<', \Carbon\Carbon::now('Asia/Jakarta')->format('Y-m-d'));
              });
        })->count();

    $today      = \Carbon\Carbon::now('Asia/Jakarta')->format('Y-m-d');
    $maxKembali = \Carbon\Carbon::now('Asia/Jakarta')->addDays(14)->format('Y-m-d');
@endphp

<div style="background:#f8f8f9;min-height:100vh;padding:2rem 0;">
<div class="container">

    {{-- NOTIF SUCCESS --}}
    @if(session('success'))
        <div class="notif-auto" style="background:#f0fdf4;border:1px solid #bbf7d0;border-left:4px solid #16a34a;border-radius:10px;padding:0.85rem 1.2rem;margin-bottom:1.25rem;font-size:0.875rem;color:#15803d;display:flex;align-items:center;gap:0.6rem;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- NOTIF ERROR --}}
    @if(session('error'))
        <div class="notif-auto" style="background:#fff8f8;border:1px solid #fcd0d0;border-left:4px solid #8B0000;border-radius:10px;padding:0.85rem 1.2rem;margin-bottom:1.25rem;font-size:0.875rem;color:#8B0000;display:flex;align-items:center;gap:0.6rem;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#8B0000" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            {{ session('error') }}
        </div>
    @endif

    {{-- BACK --}}
    <a href="{{ route('pengguna.index') }}" style="display:inline-flex;align-items:center;gap:6px;font-size:0.82rem;font-weight:600;color:#888;text-decoration:none;margin-bottom:1.25rem;">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
        Kembali
    </a>

    <div class="row g-4">

        {{-- COVER --}}
        <div class="col-md-4">
            <div style="background:#fff;border-radius:16px;border:1px solid #e9e9eb;overflow:hidden;">
                @if($buku->gambar)
                    <img src="{{ asset('uploads/buku/' . $buku->gambar) }}"
                         style="width:100%;display:block;object-fit:contain;background:#fafafa;"
                         alt="Cover Buku">
                @else
                    <img src="{{ asset('images/no-image.png') }}"
                         style="width:100%;display:block;object-fit:contain;background:#fafafa;"
                         alt="Tidak ada gambar">
                @endif

                <div style="padding:1rem 1.25rem;border-top:1px solid #f0f0f0;display:flex;align-items:center;justify-content:space-between;">
                    <span style="font-size:0.78rem;font-weight:600;color:#888;">Stok Tersedia</span>
                    @if($buku->stock > 0)
                        <span style="background:#fff0f0;color:#8B0000;font-size:0.82rem;font-weight:700;padding:0.3rem 0.75rem;border-radius:20px;">{{ $buku->stock }} buku</span>
                    @else
                        <span style="background:#f4f4f5;color:#999;font-size:0.82rem;font-weight:700;padding:0.3rem 0.75rem;border-radius:20px;">Habis</span>
                    @endif
                </div>
            </div>
        </div>

        {{-- DETAIL --}}
        <div class="col-md-8">
            <div style="background:#fff;border-radius:16px;border:1px solid #e9e9eb;padding:2rem;">

                {{-- Kategori Badge --}}
                <div style="display:flex;flex-wrap:wrap;gap:6px;margin-bottom:0.75rem;">
                    @forelse($buku->kategoris as $kat)
                        <span style="background:#fff0f0;color:#8B0000;font-size:0.72rem;font-weight:700;padding:0.3rem 0.75rem;border-radius:20px;text-transform:uppercase;letter-spacing:0.05em;">
                            {{ $kat->nama_kategori }}
                        </span>
                    @empty
                        <span style="background:#f4f4f5;color:#999;font-size:0.72rem;font-weight:700;padding:0.3rem 0.75rem;border-radius:20px;text-transform:uppercase;letter-spacing:0.05em;">
                            Tidak ada kategori
                        </span>
                    @endforelse
                </div>

                <h3 style="font-size:1.6rem;font-weight:800;color:#141516;margin:0 0 0.25rem;letter-spacing:-0.5px;">{{ $buku->judul }}</h3>
                <p style="color:#888;font-size:0.9rem;margin:0 0 1rem;">{{ $buku->penulis }}</p>

                {{-- RATING --}}
                <div style="display:flex;align-items:center;gap:6px;margin-bottom:1.25rem;">
                    <div>
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= round($rating))
                                <span style="color:#e8a000;font-size:1rem;">★</span>
                            @else
                                <span style="color:#ddd;font-size:1rem;">★</span>
                            @endif
                        @endfor
                    </div>
                    <span style="font-size:0.8rem;font-weight:700;color:#141516;">{{ number_format($rating,1) }}</span>
                    <span style="font-size:0.8rem;color:#aaa;">/ 5 &nbsp;·&nbsp; {{ $totalUlasan }} ulasan</span>
                </div>

                {{-- META --}}
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:0.6rem;margin-bottom:1.5rem;">
                    <div style="background:#f8f8f9;border-radius:10px;padding:0.75rem 1rem;">
                        <div style="font-size:0.68rem;font-weight:600;color:#aaa;text-transform:uppercase;letter-spacing:0.06em;margin-bottom:3px;">Penerbit</div>
                        <div style="font-size:0.85rem;font-weight:600;color:#141516;">{{ $buku->penerbit }}</div>
                    </div>
                    <div style="background:#f8f8f9;border-radius:10px;padding:0.75rem 1rem;">
                        <div style="font-size:0.68rem;font-weight:600;color:#aaa;text-transform:uppercase;letter-spacing:0.06em;margin-bottom:3px;">Tahun Terbit</div>
                        <div style="font-size:0.85rem;font-weight:600;color:#141516;">{{ $buku->tahun_terbit }}</div>
                    </div>
                </div>

                {{-- DESKRIPSI --}}
                <div style="margin-bottom:1.5rem;">
                    <div style="font-size:0.78rem;font-weight:700;text-transform:uppercase;letter-spacing:0.07em;color:#aaa;margin-bottom:0.5rem;">Deskripsi</div>
                    <p style="font-size:0.88rem;color:#555;line-height:1.75;text-align:justify;margin:0;">{{ $buku->deskripsi }}</p>
                </div>

                <div style="height:1px;background:#f0f0f0;margin-bottom:1.25rem;"></div>

                {{-- ACTIONS --}}
                <div style="display:flex;flex-direction:column;gap:0.75rem;">

                    @if($peminjamAktif >= 2)
                        <div style="background:#fff8f8;border:1px solid #fcd0d0;border-radius:8px;padding:0.65rem 0.9rem;font-size:0.8rem;color:#c0392b;display:flex;align-items:center;gap:7px;">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                            Kamu masih punya 2 peminjaman aktif. Kembalikan dulu sebelum meminjam lagi.
                        </div>
                    @endif

                    <div style="display:flex;flex-wrap:wrap;gap:0.75rem;align-items:center;">

                        @if($peminjamAktif >= 2)
                            <button disabled style="display:inline-flex;align-items:center;gap:7px;padding:0.7rem 1.4rem;background:#e9e9eb;color:#aaa;border:none;border-radius:9px;font-size:0.85rem;font-weight:700;cursor:not-allowed;">
                                Batas Peminjaman Tercapai
                            </button>
                        @elseif($buku->stock > 0)
                            <button type="button"
                                data-bs-toggle="modal" data-bs-target="#modalPinjam"
                                style="display:inline-flex;align-items:center;gap:7px;padding:0.7rem 1.4rem;background:#8B0000;color:#fff;border:none;border-radius:9px;font-size:0.85rem;font-weight:700;cursor:pointer;">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                                Pinjam Buku
                            </button>
                        @else
                            <button disabled style="display:inline-flex;align-items:center;gap:7px;padding:0.7rem 1.4rem;background:#e9e9eb;color:#aaa;border:none;border-radius:9px;font-size:0.85rem;font-weight:700;cursor:not-allowed;">
                                Stok Habis
                            </button>
                        @endif

                        {{-- Tombol Koleksi --}}
                        @if($diKoleksi)
                            <form action="{{ route('koleksi.destroy', $buku->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    style="display:inline-flex;align-items:center;gap:7px;padding:0.7rem 1.4rem;background:#fff8f8;color:#c0392b;border:1.5px solid #fcd0d0;border-radius:9px;font-size:0.85rem;font-weight:700;cursor:pointer;">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"/><line x1="9" y1="10" x2="15" y2="10"/></svg>
                                    Hapus dari Koleksi
                                </button>
                            </form>
                        @else
                            <form action="{{ route('koleksi.store', $buku->id) }}" method="POST">
                                @csrf
                                <button type="submit"
                                    style="display:inline-flex;align-items:center;gap:7px;padding:0.7rem 1.4rem;background:#fff;color:#8B0000;border:1.5px solid #8B0000;border-radius:9px;font-size:0.85rem;font-weight:700;cursor:pointer;">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"/></svg>
                                    Simpan ke Koleksi
                                </button>
                            </form>
                        @endif

                    </div>

                </div>

            </div>
        </div>

    </div>

    {{-- MODAL PINJAM --}}
    @if($buku->stock > 0 && $peminjamAktif < 2)
    <div class="modal fade" id="modalPinjam" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width:480px;">
            <div class="modal-content" style="border-radius:16px;border:none;overflow:hidden;box-shadow:0 20px 60px rgba(0,0,0,0.12);">

                <div style="background:#8B0000;padding:1.25rem 1.5rem;display:flex;align-items:center;justify-content:space-between;">
                    <div>
                        <div style="font-size:1rem;font-weight:800;color:#fff;">Konfirmasi Peminjaman</div>
                        <div style="font-size:0.75rem;color:rgba(255,255,255,0.6);margin-top:2px;">Pastikan tanggal kembali sudah benar</div>
                    </div>
                    <button type="button" data-bs-dismiss="modal"
                        style="background:rgba(255,255,255,0.15);border:none;border-radius:8px;width:32px;height:32px;display:flex;align-items:center;justify-content:center;cursor:pointer;flex-shrink:0;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    </button>
                </div>

                <form action="{{ route('pinjam.store', $buku->id) }}" method="POST">
                    @csrf
                    <div style="padding:1.5rem;">

                        <div style="background:#f8f8f9;border-radius:10px;padding:0.85rem 1rem;margin-bottom:1.25rem;display:flex;align-items:center;gap:0.75rem;">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#8B0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                            <span style="font-size:0.88rem;font-weight:700;color:#141516;">{{ $buku->judul }}</span>
                        </div>

                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:0.75rem;margin-bottom:1rem;">
                            <div>
                                <label style="font-size:0.72rem;font-weight:600;color:#aaa;text-transform:uppercase;letter-spacing:0.05em;display:block;margin-bottom:5px;">Tanggal Pinjam</label>
                                <input type="text"
                                    value="{{ \Carbon\Carbon::parse($today)->translatedFormat('d M Y') }}"
                                    disabled
                                    style="width:100%;padding:0.55rem 0.85rem;border:1.5px solid #e9e9eb;border-radius:8px;font-size:0.84rem;color:#888;background:#f9f9f9;font-family:inherit;">
                                <input type="hidden" name="tanggal_pinjam" value="{{ $today }}">
                            </div>
                            <div>
                                <label style="font-size:0.72rem;font-weight:600;color:#aaa;text-transform:uppercase;letter-spacing:0.05em;display:block;margin-bottom:5px;">Tanggal Kembali</label>
                                <input type="date"
                                    name="tanggal_kembali"
                                    min="{{ $today }}"
                                    max="{{ $maxKembali }}"
                                    required
                                    style="width:100%;padding:0.55rem 0.85rem;border:1.5px solid #e9e9eb;border-radius:8px;font-size:0.84rem;color:#141516;background:#fff;font-family:inherit;outline:none;"
                                    onfocus="this.style.borderColor='#8B0000'" onblur="this.style.borderColor='#e9e9eb'">
                            </div>
                        </div>

                        <div style="background:#fff8f8;border-radius:8px;padding:0.65rem 0.9rem;font-size:0.78rem;color:#8B0000;display:flex;align-items:center;gap:7px;">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                            Maksimal peminjaman 14 hari. Keterlambatan akan dicatat.
                        </div>

                    </div>

                    <div style="padding:1rem 1.5rem;border-top:1px solid #f0f0f0;display:flex;gap:0.75rem;justify-content:flex-end;">
                        <button type="button" data-bs-dismiss="modal"
                            style="padding:0.65rem 1.25rem;background:#fff;border:1.5px solid #e9e9eb;border-radius:9px;font-size:0.84rem;font-weight:600;color:#888;cursor:pointer;font-family:inherit;">
                            Batal
                        </button>
                        <button type="submit"
                            style="padding:0.65rem 1.25rem;background:#8B0000;border:none;border-radius:9px;font-size:0.84rem;font-weight:700;color:#fff;cursor:pointer;font-family:inherit;display:flex;align-items:center;gap:6px;">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                            Konfirmasi Pinjam
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
    @endif

    {{-- ULASAN --}}
    <div style="margin-top:2.5rem;">

        <div style="display:flex;align-items:center;gap:12px;margin-bottom:1.25rem;">
            <div style="width:4px;height:28px;background:#8B0000;border-radius:2px;"></div>
            <h5 style="font-size:1.1rem;font-weight:800;color:#141516;margin:0;">Ulasan Pembaca</h5>
            <span style="background:#fff0f0;color:#8B0000;font-size:0.75rem;font-weight:700;padding:0.25rem 0.65rem;border-radius:20px;">{{ $totalUlasan }}</span>
        </div>

        @if($ulasans->count() > 0)
            <div style="display:flex;flex-direction:column;gap:0.75rem;">
                @foreach($ulasans as $ulasan)
                    <div style="background:#fff;border-radius:14px;border:1px solid #e9e9eb;padding:1.25rem 1.5rem;">
                        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:0.6rem;">
                            <div style="display:flex;align-items:center;gap:0.65rem;">
                                <div style="width:34px;height:34px;background:#fff0f0;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:0.85rem;font-weight:800;color:#8B0000;flex-shrink:0;">
                                    {{ strtoupper(substr($ulasan->user->name, 0, 1)) }}
                                </div>
                                <span style="font-size:0.88rem;font-weight:700;color:#141516;">{{ $ulasan->user->name }}</span>
                            </div>
                            <div>
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= $ulasan->rating)
                                        <span style="color:#e8a000;font-size:0.9rem;">★</span>
                                    @else
                                        <span style="color:#ddd;font-size:0.9rem;">★</span>
                                    @endif
                                @endfor
                            </div>
                        </div>
                        <p style="font-size:0.85rem;color:#555;margin:0;line-height:1.65;">{{ $ulasan->komentar }}</p>
                    </div>
                @endforeach
            </div>
        @else
            <div style="background:#fff;border-radius:14px;border:1px solid #e9e9eb;padding:2.5rem;text-align:center;">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#ddd" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom:0.75rem;"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                <p style="font-size:0.85rem;color:#bbb;margin:0;">Belum ada ulasan untuk buku ini.</p>
            </div>
        @endif

    </div>

</div>
</div>

@endsection