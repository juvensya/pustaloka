@extends('layout.app')

@section('content')
<div class="container-fluid">
<div class="row">
@include('layout.sidebar')
<div class="col p-4" style="background:#f8f9fa;min-height:100vh;">

    {{-- Header --}}
    <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem;margin-bottom:1.5rem;">
        <div style="display:flex;align-items:center;gap:12px;">
            <div style="width:4px;height:40px;background:#8B0000;border-radius:2px;"></div>
            <div>
                <h2 style="font-size:1.75rem;font-weight:800;color:#141516;margin:0;letter-spacing:-0.5px;">Data Ulasan Pengguna</h2>
                <p style="color:#666;font-size:0.875rem;margin:0;">Kelola semua ulasan dan rating dari pengguna</p>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div id="alert-s" style="background:#f0fdf4;color:#15803d;padding:13px 18px;border-radius:10px;margin-bottom:1rem;border:1px solid #bbf7d0;font-size:0.875rem;font-weight:500;">
            ✓ {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div id="alert-e" style="background:#fef2f2;color:#8B0000;padding:13px 18px;border-radius:10px;margin-bottom:1rem;border:1px solid #fecaca;font-size:0.875rem;font-weight:500;">
            {{ session('error') }}
        </div>
    @endif

    {{-- FORM HAPUS — di luar tabel, dipanggil via JS --}}
    @foreach($ulasans as $ulasan)
    <form id="form-hapus-{{ $ulasan->id }}"
          action="{{ route('admin.ulasan.destroy', $ulasan->id) }}"
          method="POST"
          style="display:none;">
        @csrf
        @method('DELETE')
    </form>
    @endforeach

    {{-- Table --}}
    <div style="background:white;border-radius:16px;overflow:hidden;box-shadow:0 2px 12px rgba(0,0,0,0.07);border:1px solid #f0f0f0;">
        <div style="overflow-x:auto;">
            <table style="width:100%;border-collapse:collapse;">
                <thead>
                    <tr style="background:#f8f9fa;border-bottom:2px solid #e9ecef;">
                        <th style="padding:0.9rem 1.25rem;text-align:left;font-size:0.85rem;font-weight:700;text-transform:uppercase;letter-spacing:0.07em;color:#6c757d;">No</th>
                        <th style="padding:0.9rem 1.25rem;text-align:left;font-size:0.85rem;font-weight:700;text-transform:uppercase;letter-spacing:0.07em;color:#6c757d;">Pengguna</th>
                        <th style="padding:0.9rem 1.25rem;text-align:left;font-size:0.85rem;font-weight:700;text-transform:uppercase;letter-spacing:0.07em;color:#6c757d;">Buku</th>
                        <th style="padding:0.9rem 1.25rem;text-align:left;font-size:0.85rem;font-weight:700;text-transform:uppercase;letter-spacing:0.07em;color:#6c757d;">Rating</th>
                        <th style="padding:0.9rem 1.25rem;text-align:left;font-size:0.85rem;font-weight:700;text-transform:uppercase;letter-spacing:0.07em;color:#6c757d;">Ulasan</th>
                        <th style="padding:0.9rem 1.25rem;text-align:left;font-size:0.85rem;font-weight:700;text-transform:uppercase;letter-spacing:0.07em;color:#6c757d;">Tanggal</th>
                        <th style="padding:0.9rem 1.25rem;text-align:center;font-size:0.85rem;font-weight:700;text-transform:uppercase;letter-spacing:0.07em;color:#6c757d;"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ulasans as $ulasan)
                    <tr style="border-bottom:1px solid #f5f5f5;background:white;"
                        onmouseover="this.style.background='#fafafa'" onmouseout="this.style.background='white'">

                        {{-- NO --}}
                        <td style="padding:1.1rem 1.5rem;color:#aaa;font-size:0.9rem;vertical-align:middle;">
                            {{ $loop->iteration }}
                        </td>

                        {{-- PENGGUNA --}}
                        <td style="padding:1.1rem 1.5rem;vertical-align:middle;">
                            <div style="display:flex;align-items:center;gap:0.65rem;">
                                @php
                                    $nama    = $ulasan->user->name;
                                    $inisial = strtoupper(substr($nama, 0, 1));
                                    $colors  = ['#8B0000','#b91c1c','#c2410c','#b45309','#15803d','#1d4ed8','#7e22ce','#be185d'];
                                    $color   = $colors[ord($inisial) % count($colors)];
                                @endphp
                                <div style="width:36px;height:36px;border-radius:50%;background:{{ $color }};display:flex;align-items:center;justify-content:center;color:white;font-size:0.85rem;font-weight:700;flex-shrink:0;">
                                    {{ $inisial }}
                                </div>
                                <div>
                                    <div style="font-weight:700;color:#1a0000;font-size:1.02rem;">{{ $ulasan->user->name }}</div>
                                    <div style="font-size:0.9rem;color:#9e6060;">{{ $ulasan->user->email }}</div>
                                </div>
                            </div>
                        </td>

                        {{-- BUKU --}}
                        <td style="padding:1.1rem 1.5rem;vertical-align:middle;">
                            <div style="font-size:1rem;color:#2c3e50;">{{ $ulasan->buku->judul }}</div>
                            <div style="font-size:0.9rem;color:#9e6060;">{{ $ulasan->buku->penulis }}</div>
                        </td>

                        {{-- RATING --}}
                        <td style="padding:1.1rem 1.5rem;vertical-align:middle;">
                            <div style="display:flex;align-items:center;gap:2px;">
                                @for($i = 1; $i <= 5; $i++)
                                    <span style="font-size:1rem;color:{{ $i <= $ulasan->rating ? '#f59e0b' : '#e5e7eb' }};">&#9733;</span>
                                @endfor
                            </div>
                            <div style="font-size:0.78rem;color:#9e6060;margin-top:2px;">{{ $ulasan->rating }}/5</div>
                        </td>

                        {{-- ULASAN --}}
                        <td style="padding:1.1rem 1.5rem;vertical-align:middle;max-width:300px;">
                            <p style="font-size:0.95rem;color:#4a2020;margin:0;line-height:1.6;word-break:break-word;white-space:normal;">
                                {{ $ulasan->komentar }}
                            </p>
                        </td>

                        {{-- TANGGAL --}}
                        <td style="padding:1.1rem 1.5rem;font-size:0.95rem;color:#666;vertical-align:middle;white-space:nowrap;">
                            {{ $ulasan->created_at->format('d M Y') }}
                        </td>

                        {{-- AKSI DROPDOWN --}}
                        <td style="padding:1.1rem 1.5rem;text-align:center;vertical-align:middle;">
                            <button onclick="toggleDD(event,'dd{{ $ulasan->id }}')"
                                style="background:none;border:none;cursor:pointer;color:#888;padding:4px 8px;border-radius:6px;font-size:1.1rem;line-height:1;"
                                title="Aksi">&#8942;</button>

                            <div id="dd{{ $ulasan->id }}" style="display:none;position:fixed;background:white;border:1px solid #e9ecef;border-radius:10px;box-shadow:0 8px 24px rgba(0,0,0,0.13);min-width:160px;z-index:9999;overflow:hidden;">
                                <button type="button"
                                    onclick="hapusUlasan({{ $ulasan->id }})"
                                    style="width:100%;text-align:left;padding:10px 14px;background:none;border:none;font-size:0.95rem;font-weight:600;color:#8B0000;cursor:pointer;display:flex;align-items:center;gap:8px;">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                                    Hapus
                                </button>
                            </div>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="padding:60px;text-align:center;color:#9e6060;font-size:1.02rem;">
                            📭 Belum ada ulasan dari pengguna
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
</div>
</div>

<script>
function hapusUlasan(id) {
    if (!confirm('Yakin ingin menghapus ulasan ini?')) return;
    document.getElementById('form-hapus-' + id).submit();
}

function toggleDD(e, id) {
    e.stopPropagation();
    const btn    = e.currentTarget;
    const dd     = document.getElementById(id);
    const isOpen = dd.style.display === 'block';

    document.querySelectorAll('[id^="dd"]').forEach(el => el.style.display = 'none');

    if (!isOpen) {
        const rect = btn.getBoundingClientRect();
        dd.style.display = 'block';
        dd.style.top  = (rect.bottom + window.scrollY + 4) + 'px';
        dd.style.left = (rect.right + window.scrollX - 160) + 'px';
    }
}

document.addEventListener('click', () => {
    document.querySelectorAll('[id^="dd"]').forEach(el => el.style.display = 'none');
});

document.addEventListener('DOMContentLoaded', () => {
    ['alert-s','alert-e'].forEach(id => {
        const el = document.getElementById(id);
        if (el) setTimeout(() => {
            el.style.transition = 'opacity 0.5s';
            el.style.opacity    = '0';
            setTimeout(() => el.style.display = 'none', 500);
        }, 4000);
    });
});
</script>

@endsection