@extends('layouts.app')

@section('content')

<style>
    .notif-auto {
        animation: fadeOut 0.5s ease 3s forwards;
    }
    @keyframes fadeOut {
        to { opacity: 0; height: 0; padding: 0; margin: 0; overflow: hidden; }
    }
    .buku-overlay { opacity: 0; transition: opacity 0.2s; }
    .buku-cover:hover .buku-overlay { opacity: 1; }
    .buku-cover:hover .buku-bg { background: rgba(139,0,0,0.5) !important; }
    .buku-bg { background: rgba(139,0,0,0); transition: background 0.2s; }
</style>

<div style="background:#f8f8f9;min-height:100vh;padding:2rem 0;">
<div style="max-width:1100px;margin:0 auto;padding:0 1rem;">

    {{-- NOTIF --}}
    @if(session('success'))
        <div class="notif-auto" style="background:#f0fdf4;border:1px solid #bbf7d0;border-left:4px solid #16a34a;border-radius:10px;padding:0.85rem 1.2rem;margin-bottom:1.25rem;font-size:0.875rem;color:#15803d;display:flex;align-items:center;gap:0.6rem;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="notif-auto" style="background:#fff8f8;border:1px solid #fcd0d0;border-left:4px solid #8B0000;border-radius:10px;padding:0.85rem 1.2rem;margin-bottom:1.25rem;font-size:0.875rem;color:#8B0000;display:flex;align-items:center;gap:0.6rem;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#8B0000" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            {{ session('error') }}
        </div>
    @endif

    {{-- HEADER --}}
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.75rem;">
        <div style="display:flex;align-items:center;gap:12px;">
            <div style="width:4px;height:32px;background:#8B0000;border-radius:2px;"></div>
            <div>
                <h2 style="font-size:1.5rem;font-weight:800;color:#141516;margin:0;letter-spacing:-0.5px;">Koleksi Saya</h2>
                <p style="color:#999;font-size:0.8rem;margin:0;">Buku-buku yang kamu simpan</p>
            </div>
        </div>
        @if($koleksi->count() > 0)
            <span style="background:#fff0f0;color:#8B0000;font-size:0.75rem;font-weight:700;padding:0.3rem 0.75rem;border-radius:20px;">{{ $koleksi->count() }} Buku</span>
        @endif
    </div>

    {{-- GRID --}}
    @if($koleksi->count() > 0)

        <div style="display:grid;grid-template-columns:repeat(4,240px);gap:1.25rem;justify-content:start;">
        @forelse($koleksi as $buku)

            <div style="background:transparent;border-radius:12px;overflow:hidden;display:flex;flex-direction:column;">

                {{-- COVER + HOVER OVERLAY --}}
                <div class="buku-cover" style="position:relative;border-radius:12px;overflow:hidden;">
                    <img src="{{ asset('uploads/buku/' . $buku->gambar) }}"
                         alt="{{ $buku->judul }}"
                         style="width:100%;aspect-ratio:2/3;display:block;object-fit:cover;object-position:top;">

                    {{-- Stok badge --}}
                    <div style="position:absolute;top:7px;right:7px;">
                        @if($buku->stock > 0)
                            <span style="background:rgba(240,253,244,0.95);color:#16a34a;font-size:0.6rem;font-weight:700;padding:0.18rem 0.5rem;border-radius:20px;border:1px solid #bbf7d0;">Tersedia</span>
                        @else
                            <span style="background:rgba(255,248,248,0.95);color:#c0392b;font-size:0.6rem;font-weight:700;padding:0.18rem 0.5rem;border-radius:20px;border:1px solid #fcd0d0;">Habis</span>
                        @endif
                    </div>

                    {{-- Hover overlay --}}
                    <div class="buku-bg buku-overlay" style="position:absolute;inset:0;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:8px;">
                        <a href="{{ route('pengguna.buku.detail', $buku->id) }}"
                           style="background:#8B0000;color:#fff;padding:8px 20px;border-radius:8px;font-size:0.8rem;font-weight:700;text-decoration:none;">
                            Detail
                        </a>
                        <form action="{{ route('koleksi.destroy', $buku->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                onclick="return confirm('Hapus buku ini dari koleksi?')"
                                style="background:#fff;color:#c0392b;border:1.5px solid #fcd0d0;padding:8px 20px;border-radius:8px;font-size:0.8rem;font-weight:700;cursor:pointer;font-family:inherit;">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>

                {{-- INFO --}}
                <div style="padding:0.5rem 0.2rem 0.35rem;display:flex;flex-direction:column;gap:0.12rem;">
                    <div style="font-size:0.82rem;font-weight:800;color:#141516;line-height:1.25;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">{{ $buku->judul }}</div>
                    <div style="font-size:0.7rem;color:#aaa;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $buku->penulis }}</div>

                    {{-- Kategori --}}
                    <div style="display:flex;flex-wrap:wrap;gap:3px;margin-top:2px;">
                        @foreach($buku->kategoris as $kat)
                            <span style="background:#fff0f0;color:#8B0000;font-size:0.62rem;font-weight:700;padding:0.15rem 0.5rem;border-radius:20px;">
                                {{ $kat->nama_kategori }}
                            </span>
                        @endforeach
                    </div>

                    {{-- RATING --}}
                    @php
                        $avgRating   = $buku->ulasans->avg('rating') ?? 0;
                        $totalUlasan = $buku->ulasans->count();
                    @endphp
                    <div style="display:flex;align-items:center;gap:1px;">
                        @for($i = 1; $i <= 5; $i++)
                            <span style="color:{{ $i <= round($avgRating) ? '#e8a000' : '#ddd' }};font-size:1.15rem;line-height:1;">★</span>
                        @endfor
                        <span style="font-size:0.68rem;color:#aaa;margin-left:3px;">({{ $totalUlasan }})</span>
                    </div>
                </div>

            </div>

        @empty
        @endforelse
        </div>

    @else

        <div style="background:#fff;border-radius:16px;border:1px solid #e9e9eb;padding:3rem;text-align:center;">
            <div style="width:56px;height:56px;background:#fff0f0;border-radius:14px;display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#8B0000" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
            </div>
            <div style="font-size:0.95rem;font-weight:700;color:#141516;margin-bottom:4px;">Koleksi masih kosong</div>
            <p style="font-size:0.83rem;color:#aaa;margin:0 0 1.25rem;">Tambahkan buku favoritmu agar mudah ditemukan.</p>
            <a href="{{ route('pengguna.index') }}"
               style="display:inline-flex;align-items:center;padding:0.65rem 1.4rem;background:#8B0000;color:#fff;border-radius:9px;font-size:0.84rem;font-weight:700;text-decoration:none;">
                Jelajahi Buku
            </a>
        </div>

    @endif

</div>
</div>

@endsection