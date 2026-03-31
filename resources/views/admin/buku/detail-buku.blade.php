@extends('layout.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('layout.sidebar')

        <div class="col p-0" style="background:#f8f9fa;min-height:100vh;">
            @include('layout.navbar')

            @php
                $avgRating   = $buku->ulasans->avg('rating');
                $totalUlasan = $buku->ulasans->count();
            @endphp

            <div style="padding:2rem 2.5rem;">

                <!-- Back + Header -->
                <div style="margin-bottom:1.75rem;">
                    <a href="{{ route('buku.index') }}" style="display:inline-flex;align-items:center;gap:5px;color:#8B0000;text-decoration:none;font-size:0.8rem;font-weight:600;margin-bottom:1rem;">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
                        Kembali ke Daftar Buku
                    </a>
                    <div style="display:flex;align-items:center;gap:12px;">
                        <div style="width:4px;height:36px;background:#8B0000;border-radius:2px;flex-shrink:0;"></div>
                        <div>
                            <h2 style="font-size:1.5rem;font-weight:800;color:#141516;margin:0;letter-spacing:-0.4px;">Detail Buku</h2>
                            <p style="color:#888;font-size:0.8rem;margin:0;">Informasi lengkap & ulasan pembaca</p>
                        </div>
                    </div>
                </div>

                <!-- Card Utama -->
                <div style="background:white;border-radius:16px;border:1px solid #ebebeb;box-shadow:0 1px 8px rgba(0,0,0,0.05);padding:2rem;margin-bottom:1.5rem;">
                    <div style="display:flex;gap:2.5rem;align-items:flex-start;">

                        <!-- Cover -->
                        <div style="flex-shrink:0;">
                            @if($buku->gambar)
                                <img src="{{ asset('uploads/buku/'.$buku->gambar) }}" alt="{{ $buku->judul }}"
                                    style="width:150px;height:215px;object-fit:cover;border-radius:10px;box-shadow:0 8px 24px rgba(0,0,0,0.13);">
                            @else
                                <div style="width:150px;height:215px;background:#f5f0f0;border-radius:10px;display:flex;align-items:center;justify-content:center;border:1px solid #ebe0e0;">
                                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#c9a0a0" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                                </div>
                            @endif
                        </div>

                        <!-- Info -->
                        <div style="flex:1;min-width:0;">

                            <!-- Judul -->
                            <h3 style="font-size:1.4rem;font-weight:800;color:#1a0000;margin:0 0 0.6rem;line-height:1.3;">{{ $buku->judul }}</h3>

                            <!-- Kategori -->
                            <div style="display:flex;flex-wrap:wrap;gap:5px;margin-bottom:0.85rem;">
                                @forelse($buku->kategoris as $kat)
                                    <span style="background:#fdf0f0;color:#8B0000;padding:3px 11px;border-radius:999px;font-size:0.7rem;font-weight:700;letter-spacing:0.03em;">{{ $kat->nama_kategori }}</span>
                                @empty
                                    <span style="color:#ccc;font-size:0.8rem;">Tidak ada kategori</span>
                                @endforelse
                            </div>

                            <!-- Rating -->
                            @if($totalUlasan > 0)
                                <div style="display:flex;align-items:center;gap:6px;margin-bottom:1.5rem;">
                                    <div style="display:flex;gap:1px;">
                                        @for($s = 1; $s <= 5; $s++)
                                            <span style="font-size:0.9rem;color:{{ $s <= round($avgRating) ? '#f59e0b' : '#e2e2e2' }};">★</span>
                                        @endfor
                                    </div>
                                    <span style="font-size:0.82rem;font-weight:700;color:#333;">{{ number_format($avgRating, 1) }}</span>
                                    <span style="font-size:0.78rem;color:#bbb;">· {{ $totalUlasan }} ulasan</span>
                                </div>
                            @else
                                <div style="margin-bottom:1.5rem;">
                                    <span style="font-size:0.78rem;color:#ccc;">Belum ada ulasan</span>
                                </div>
                            @endif

                            <!-- Penulis & Penerbit (sejajar) -->
                            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem 2rem;margin-bottom:1rem;">
                                <div>
                                    <div style="font-size:0.68rem;font-weight:700;color:#c0c0c0;text-transform:uppercase;letter-spacing:0.07em;margin-bottom:3px;">Penulis</div>
                                    <div style="font-size:0.875rem;font-weight:600;color:#2c2c2c;">{{ $buku->penulis }}</div>
                                </div>
                                <div>
                                    <div style="font-size:0.68rem;font-weight:700;color:#c0c0c0;text-transform:uppercase;letter-spacing:0.07em;margin-bottom:3px;">Penerbit</div>
                                    <div style="font-size:0.875rem;font-weight:600;color:#2c2c2c;">{{ $buku->penerbit }}</div>
                                </div>
                            </div>

                            <!-- Tahun Terbit & Stok (sejajar) -->
                            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem 2rem;margin-bottom:1.5rem;">
                                <div>
                                    <div style="font-size:0.68rem;font-weight:700;color:#c0c0c0;text-transform:uppercase;letter-spacing:0.07em;margin-bottom:3px;">Tahun Terbit</div>
                                    <div style="font-size:0.875rem;font-weight:600;color:#2c2c2c;">{{ $buku->tahun_terbit }}</div>
                                </div>
                                <div>
                                    <div style="font-size:0.68rem;font-weight:700;color:#c0c0c0;text-transform:uppercase;letter-spacing:0.07em;margin-bottom:3px;">Stok</div>
                                    <div style="font-size:0.875rem;font-weight:700;color:{{ $buku->stock > 0 ? '#16a34a' : '#8B0000' }};">
                                        {{ $buku->stock }} buku{{ $buku->stock == 0 ? ' · Habis' : '' }}
                                    </div>
                                </div>
                            </div>

                            <!-- Deskripsi -->
                            @if($buku->deskripsi)
                                <div style="padding-top:1.25rem;border-top:1px solid #f2f2f2;">
                                    <div style="font-size:0.68rem;font-weight:700;color:#c0c0c0;text-transform:uppercase;letter-spacing:0.07em;margin-bottom:0.6rem;">Deskripsi</div>
                                    <p style="font-size:0.875rem;color:#555;line-height:1.85;margin:0;white-space:pre-line;">{{ $buku->deskripsi }}</p>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>

                <!-- Card Ulasan -->
                <div style="background:white;border-radius:16px;border:1px solid #ebebeb;box-shadow:0 1px 8px rgba(0,0,0,0.05);overflow:hidden;margin-bottom:2rem;">

                    <!-- Header Ulasan -->
                    <div style="padding:1.25rem 2rem;border-bottom:1px solid #f2f2f2;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem;">
                        <div style="display:flex;align-items:center;gap:10px;">
                            <span style="font-size:0.9rem;font-weight:800;color:#1a0000;">Ulasan Pembaca</span>
                            <span style="background:#fdf0f0;color:#8B0000;padding:2px 10px;border-radius:999px;font-size:0.72rem;font-weight:700;">{{ $totalUlasan }}</span>
                        </div>

                        @if($totalUlasan > 0)
                        <div style="display:flex;align-items:center;gap:1.5rem;">
                            <div style="text-align:center;line-height:1;">
                                <div style="font-size:2rem;font-weight:800;color:#1a0000;">{{ number_format($avgRating, 1) }}</div>
                                <div style="display:flex;gap:2px;justify-content:center;margin:4px 0 2px;">
                                    @for($s = 1; $s <= 5; $s++)
                                        <span style="font-size:0.72rem;color:{{ $s <= round($avgRating) ? '#f59e0b' : '#e2e2e2' }};">★</span>
                                    @endfor
                                </div>
                                <span style="font-size:0.65rem;color:#ccc;">dari 5</span>
                            </div>
                            <div style="display:flex;flex-direction:column;gap:5px;">
                                @for($r = 5; $r >= 1; $r--)
                                    @php
                                        $cnt = $buku->ulasans->where('rating', $r)->count();
                                        $pct = $totalUlasan > 0 ? ($cnt / $totalUlasan * 100) : 0;
                                    @endphp
                                    <div style="display:flex;align-items:center;gap:6px;">
                                        <span style="font-size:0.65rem;color:#bbb;width:8px;text-align:right;">{{ $r }}</span>
                                        <span style="font-size:0.6rem;color:#f59e0b;">★</span>
                                        <div style="width:100px;height:4px;background:#f2f2f2;border-radius:2px;overflow:hidden;">
                                            <div style="width:{{ $pct }}%;height:100%;background:#f59e0b;border-radius:2px;"></div>
                                        </div>
                                        <span style="font-size:0.65rem;color:#ccc;width:14px;">{{ $cnt }}</span>
                                    </div>
                                @endfor
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- List Ulasan -->
                    @forelse($buku->ulasans()->with('user')->latest()->get() as $ulasan)
                        <div style="padding:1.4rem 2rem;border-bottom:1px solid #fafafa;display:flex;gap:1rem;">
                            @if(!empty($ulasan->user->foto))
                                <img src="{{ asset('uploads/users/'.$ulasan->user->foto) }}"
                                    style="width:36px;height:36px;border-radius:50%;object-fit:cover;flex-shrink:0;margin-top:2px;">
                            @else
                                <div style="width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,#8B0000,#c0392b);display:flex;align-items:center;justify-content:center;color:white;font-size:0.8rem;font-weight:700;flex-shrink:0;margin-top:2px;">
                                    {{ strtoupper(substr($ulasan->user->name ?? '?', 0, 1)) }}
                                </div>
                            @endif
                            <div style="flex:1;">
                                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:5px;flex-wrap:wrap;gap:4px;">
                                    <div style="display:flex;align-items:center;gap:8px;">
                                        <span style="font-weight:700;color:#1a0000;font-size:0.875rem;">{{ $ulasan->user->name ?? 'Pengguna' }}</span>
                                        <div style="display:flex;gap:1px;">
                                            @for($s = 1; $s <= 5; $s++)
                                                <span style="font-size:0.72rem;color:{{ $s <= $ulasan->rating ? '#f59e0b' : '#e2e2e2' }};">★</span>
                                            @endfor
                                        </div>
                                    </div>
                                    <span style="font-size:0.72rem;color:#ccc;">{{ $ulasan->created_at->translatedFormat('d M Y') }}</span>
                                </div>
                                @if($ulasan->komentar)
                                    <p style="font-size:0.875rem;color:#555;line-height:1.65;margin:0;">{{ $ulasan->komentar }}</p>
                                @else
                                    <p style="font-size:0.8rem;color:#ccc;font-style:italic;margin:0;">Tidak ada komentar.</p>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div style="padding:3.5rem 2rem;text-align:center;">
                            <p style="font-size:0.875rem;color:#ccc;margin:0;">Belum ada ulasan untuk buku ini.</p>
                        </div>
                    @endforelse

                </div>

            </div>
        </div>
    </div>
</div>
@endsection