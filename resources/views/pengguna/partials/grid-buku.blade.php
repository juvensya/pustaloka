@forelse($bukus as $buku)
<div style="background:transparent;border-radius:14px;overflow:hidden;transition:transform 0.2s;"
    onmouseover="this.style.transform='translateY(-4px)'"
    onmouseout="this.style.transform='translateY(0)'">

    {{-- COVER --}}
    <div style="position:relative;border-radius:14px;overflow:hidden;">
        @if($buku->gambar)
            <img src="{{ asset('uploads/buku/' . $buku->gambar) }}" alt="{{ $buku->judul }}"
                 style="width:100%;aspect-ratio:2/3;object-fit:cover;display:block;">
        @else
            <div style="width:100%;aspect-ratio:2/3;background:#f0e6e6;display:flex;align-items:center;justify-content:center;font-size:3rem;">📖</div>
        @endif

        <div style="position:absolute;bottom:0;left:0;right:0;background:linear-gradient(to top, rgba(0,0,0,0.85), transparent);padding:1rem 0.875rem 0.875rem;">
            <h5 style="font-size:0.9rem;font-weight:700;color:white;margin:0;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">{{ $buku->judul }}</h5>
            <p style="font-size:0.78rem;color:rgba(255,255,255,0.8);margin:2px 0 0;">{{ $buku->penulis }}</p>
            <span style="font-size:0.72rem;color:rgba(255,255,255,0.6);">{{ $buku->kategori->nama_kategori }}</span>
        </div>

        <a href="{{ route('pengguna.buku.detail', $buku->id) }}"
            style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;background:rgba(139,0,0,0);transition:background 0.2s;text-decoration:none;"
            onmouseover="this.style.background='rgba(139,0,0,0.5)'; this.querySelector('span').style.opacity='1'"
            onmouseout="this.style.background='rgba(139,0,0,0)'; this.querySelector('span').style.opacity='0'">
            <span style="opacity:0;background:#8B0000;color:white;padding:10px 20px;border-radius:8px;font-weight:600;font-size:0.875rem;transition:opacity 0.2s;">Lihat Detail</span>
        </a>
    </div>

    {{-- RATING --}}
    <div style="padding:0.5rem 0.25rem 0;background:transparent;">
        @php
            $avgRating = $buku->ulasans->avg('rating') ?? 0;
            $totalUlasan = $buku->ulasans->count();
        @endphp
        <div style="display:flex;align-items:center;gap:1px;">
            @for($i = 1; $i <= 5; $i++)
                @if($i <= round($avgRating))
                    <span style="color:#e8a000;font-size:1.4rem;line-height:1;">★</span>
                @else
                    <span style="color:#ddd;font-size:1.4rem;line-height:1;">★</span>
                @endif
            @endfor
            <span style="font-size:0.7rem;color:#aaa;margin-left:4px;">({{ $totalUlasan }})</span>
        </div>
    </div>

</div>
@empty
<div style="grid-column: span 5; text-align: center; padding: 60px 20px;">
    <div style="font-size: 4rem;">📭</div>
    <p style="font-size: 1.1rem; color: #6c757d; font-weight: 500; margin-top: 1rem;">Tidak ada buku di kategori ini</p>
</div>
@endforelse