@extends('layouts.app')

@section('content')

<style>
    .notif-auto {
        animation: fadeOut 0.5s ease 3s forwards;
    }
    @keyframes fadeOut {
        to { opacity: 0; height: 0; padding: 0; margin: 0; overflow: hidden; }
    }
</style>

<div style="background:#f8f8f9;min-height:100vh;padding:2rem 0;">
<div style="max-width:1050px;margin:0 auto;padding:0 2rem;">

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
                <h2 style="font-size:1.5rem;font-weight:800;color:#141516;margin:0;letter-spacing:-0.5px;">Ulasan Saya</h2>
                <p style="color:#999;font-size:0.8rem;margin:0;">{{ $ulasans->count() }} ulasan ditulis</p>
            </div>
        </div>
    </div>

    {{-- LIST --}}
    @if($ulasans->count() > 0)

        <div style="display:flex;flex-direction:column;gap:1rem;">
        @foreach($ulasans as $ulasan)

            <div style="background:#fff;border-radius:16px;border:1px solid #e9e9eb;display:flex;align-items:center;overflow:hidden;">

                {{-- COVER --}}
                <div style="flex-shrink:0;padding:1rem;">
                    @if($ulasan->buku->gambar)
                        <img src="{{ asset('uploads/buku/'.$ulasan->buku->gambar) }}"
                             alt="{{ $ulasan->buku->judul }}"
                             style="width:70px;height:100px;object-fit:cover;border-radius:8px;display:block;">
                    @else
                        <div style="width:70px;height:100px;background:#fff0f0;border-radius:8px;display:flex;align-items:center;justify-content:center;">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#8B0000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                        </div>
                    @endif
                </div>

                {{-- INFO --}}
                <div style="flex:1;padding:1rem 0.5rem;min-width:0;">
                    <div style="font-size:0.95rem;font-weight:800;color:#141516;margin-bottom:2px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $ulasan->buku->judul }}</div>
                    <div style="font-size:0.78rem;color:#999;margin-bottom:0.5rem;">
                        {{ $ulasan->buku->penerbit }} &nbsp;·&nbsp; {{ $ulasan->buku->tahun_terbit }}
                    </div>

                    {{-- RATING --}}
                    <div style="margin-bottom:0.5rem;">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $ulasan->rating)
                                <span style="color:#e8a000;font-size:0.95rem;">★</span>
                            @else
                                <span style="color:#ddd;font-size:0.95rem;">★</span>
                            @endif
                        @endfor
                        <span style="font-size:0.75rem;color:#aaa;margin-left:3px;">{{ $ulasan->rating }}/5</span>
                    </div>

                    {{-- KOMENTAR --}}
                    <p style="font-size:0.82rem;color:#555;margin:0;line-height:1.55;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">{{ $ulasan->komentar }}</p>
                </div>

                {{-- AKSI --}}
                <div style="display:flex;flex-direction:column;gap:0.5rem;padding:1rem 1.25rem;flex-shrink:0;">
                    <a href="{{ route('ulasan.edit', $ulasan->id) }}"
                       style="display:inline-flex;align-items:center;justify-content:center;gap:5px;padding:0.5rem 1.1rem;background:#8B0000;color:#fff;border-radius:8px;font-size:0.78rem;font-weight:700;text-decoration:none;white-space:nowrap;">
                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        Edit
                    </a>
                    <form action="{{ route('ulasan.destroy', $ulasan->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            onclick="return confirm('Hapus ulasan ini?')"
                            style="width:100%;display:inline-flex;align-items:center;justify-content:center;gap:5px;padding:0.5rem 1.1rem;background:#fff8f8;color:#c0392b;border:1.5px solid #fcd0d0;border-radius:8px;font-size:0.78rem;font-weight:700;cursor:pointer;font-family:inherit;white-space:nowrap;">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                            Hapus
                        </button>
                    </form>
                </div>

            </div>

        @endforeach
        </div>

    @else

        <div style="background:#fff;border-radius:16px;border:1px solid #e9e9eb;padding:3rem;text-align:center;">
            <div style="width:56px;height:56px;background:#fff0f0;border-radius:14px;display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#8B0000" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
            </div>
            <div style="font-size:0.95rem;font-weight:700;color:#141516;margin-bottom:4px;">Belum ada ulasan</div>
            <p style="font-size:0.83rem;color:#aaa;margin:0;">Kamu belum menulis ulasan untuk buku apapun.</p>
        </div>

    @endif

</div>
</div>

@endsection