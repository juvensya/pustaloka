@extends('layout.app')

@section('content')

<div class="container-fluid">
    <div class="row">
        @include('layout.sidebar')

        <div class="col p-4" style="background:#f8f9fa;min-height:100vh;">

            <!-- Header -->
            <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem;margin-bottom:1.5rem;">
                <div style="display:flex;align-items:center;gap:12px;">
                    <div style="width:4px;height:40px;background:#8B0000;border-radius:2px;"></div>
                    <div>
                        <h2 style="font-size:1.75rem;font-weight:800;color:#141516;margin:0;letter-spacing:-0.5px;">Data Peminjaman</h2>
                        <p style="color:#666;font-size:0.875rem;margin:0;">Total <strong>{{ $data->total() }}</strong> peminjaman aktif</p>
                    </div>
                </div>
                <form action="{{ route('admin.peminjaman.index') }}" method="GET">
                    <div style="position:relative;">
                        <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari peminjam atau buku..."
                            style="padding:10px 44px 10px 16px;border:2px solid #e9ecef;border-radius:10px;font-size:0.875rem;outline:none;width:270px;"
                            onfocus="this.style.borderColor='#8B0000'" onblur="this.style.borderColor='#e9ecef'">
                        <button type="submit" style="position:absolute;right:10px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:#8B0000;display:flex;">
                            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        </button>
                    </div>
                </form>
            </div>

            @if($search)
                <div style="margin-bottom:1rem;font-size:0.85rem;color:#666;">
                    Hasil: <strong>"{{ $search }}"</strong> ({{ $data->total() }} data) —
                    <a href="{{ route('admin.peminjaman.index') }}" style="color:#8B0000;font-weight:600;text-decoration:none;">✕ Hapus filter</a>
                </div>
            @endif

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

            <!-- Table -->
            <div style="background:white;border-radius:16px;overflow:hidden;box-shadow:0 2px 12px rgba(0,0,0,0.07);border:1px solid #f0f0f0;">
                <div style="overflow-x:auto;">
                    <table style="width:100%;border-collapse:collapse;">
                        <thead>
                            <tr style="background:#f8f9fa;border-bottom:2px solid #e9ecef;">
                                @foreach(['No','Peminjam','Buku','Tgl Pinjam','Tgl Kembali','Status',''] as $h)
                                <th style="padding:0.9rem 1.25rem;text-align:{{ $loop->last ? 'center' : 'left' }};font-size:0.85rem;font-weight:700;text-transform:uppercase;letter-spacing:0.07em;color:#6c757d;">{{ $h }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data as $i => $p)
                            @php
                                $bg = match($p->status) {
                                    'terlambat' => '#fff5f5',
                                    'menunggu_kembali' => '#eff6ff',
                                    'menunggu' => '#fffdf0',
                                    default => 'white'
                                };
                            @endphp
                            <tr style="border-bottom:1px solid #f5f5f5;background:{{ $bg }};"
                                onmouseover="this.style.background='#fafafa'" onmouseout="this.style.background='{{ $bg }}'">

                                <td style="padding:1.1rem 1.5rem;color:#aaa;font-size:0.9rem;vertical-align:middle;">{{ $data->firstItem() + $i }}</td>

                                <!-- Peminjam -->
                                <td style="padding:1.1rem 1.5rem;vertical-align:middle;">
                                    <div style="display:flex;align-items:center;gap:0.65rem;">
                                        @if(!empty($p->user->foto))
                                            <img src="{{ asset('uploads/users/'.$p->user->foto) }}" style="width:36px;height:36px;border-radius:50%;object-fit:cover;border:2px solid #fde8e8;flex-shrink:0;">
                                        @else
                                            <div style="width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,#8B0000,#c0392b);display:flex;align-items:center;justify-content:center;color:white;font-size:0.85rem;font-weight:700;flex-shrink:0;">
                                                {{ strtoupper(substr($p->user->name,0,1)) }}
                                            </div>
                                        @endif
                                        <div>
                                            <div style="font-weight:700;color:#1a0000;font-size:1.02rem;">{{ $p->user->name }}</div>
                                            <div style="font-size:0.9rem;color:#9e6060;">{{ $p->user->email }}</div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Buku -->
                                <td style="padding:1.1rem 1.5rem;vertical-align:middle;">
                                    <div style="font-size:1rem;font-weight:600;color:#2c3e50;">{{ $p->buku->judul }}</div>
                                    <div style="font-size:0.9rem;color:#9e6060;">{{ $p->buku->penerbit ?? '-' }}</div>
                                </td>

                                <td style="padding:1.1rem 1.5rem;font-size:0.95rem;color:#666;vertical-align:middle;white-space:nowrap;">{{ $p->tanggal_pinjam ?? '-' }}</td>

                                <td style="padding:1.1rem 1.5rem;font-size:0.95rem;vertical-align:middle;white-space:nowrap;">
                                    @if($p->tanggal_kembali)
                                        @php $late = \Carbon\Carbon::now('Asia/Jakarta')->greaterThan($p->tanggal_kembali); @endphp
                                        <span style="color:{{ $late ? '#8B0000' : '#666' }};font-weight:{{ $late ? '700' : '400' }};">{{ $p->tanggal_kembali }}</span>
                                    @else
                                        <span style="color:#aaa;">-</span>
                                    @endif
                                </td>

                                <!-- Status -->
                                <td style="padding:1.1rem 1.5rem;vertical-align:middle;">
                                    @php
                                        $badges = [
                                            'menunggu'         => ['#fefce8','#a16207','Menunggu'],
                                            'disetujui'        => ['#f0fdf4','#15803d','Disetujui'],
                                            'menunggu_kembali' => ['#dbeafe','#1e40af','Pengembalian'],
                                            'terlambat'        => ['#fff7ed','#c2410c','Terlambat'],
                                            'dikembalikan'     => ['#dbeafe','#1e40af','Dikembalikan'],
                                            'ditolak'          => ['#fef2f2','#8B0000','Ditolak'],
                                        ];
                                        [$sbg, $sc, $sl] = $badges[$p->status] ?? ['#f3f4f6','#666','—'];
                                    @endphp
                                    <span style="display:inline-flex;align-items:center;gap:0.3rem;background:{{ $sbg }};color:{{ $sc }};padding:4px 11px;border-radius:999px;font-size:0.9rem;font-weight:700;">
                                        <span style="width:6px;height:6px;border-radius:50%;background:currentColor;display:inline-block;"></span>{{ $sl }}
                                    </span>
                                </td>

                                <!-- Aksi Dropdown -->
                                <td style="padding:1.1rem 1.5rem;text-align:center;vertical-align:middle;position:relative;">
                                    <button onclick="toggleDD(event,'dd{{$p->id}}')"
                                        style="background:none;border:none;cursor:pointer;color:#888;padding:4px 8px;border-radius:6px;font-size:1.1rem;line-height:1;"
                                        title="Aksi">&#8942;</button>

                                    <div id="dd{{$p->id}}" style="display:none;position:fixed;background:white;border:1px solid #e9ecef;border-radius:10px;box-shadow:0 8px 24px rgba(0,0,0,0.13);min-width:180px;z-index:9999;overflow:hidden;">

                                        @if($p->status == 'menunggu')
                                            <form action="{{ route('admin.peminjaman.updateStatus',$p->id) }}" method="POST">
                                                @csrf @method('PUT')
                                                <input type="hidden" name="status" value="disetujui">
                                                <button type="submit" onclick="return confirm('Setujui peminjaman ini?')" style="width:100%;text-align:left;padding:10px 14px;background:none;border:none;font-size:0.95rem;font-weight:600;color:#15803d;cursor:pointer;display:flex;align-items:center;gap:8px;">
                                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg> Setujui
                                                </button>
                                            </form>
                                            <div style="height:1px;background:#f5f5f5;"></div>
                                            <form action="{{ route('admin.peminjaman.updateStatus',$p->id) }}" method="POST">
                                                @csrf @method('PUT')
                                                <input type="hidden" name="status" value="ditolak">
                                                <button type="submit" onclick="return confirm('Tolak peminjaman ini?')" style="width:100%;text-align:left;padding:10px 14px;background:none;border:none;font-size:0.95rem;font-weight:600;color:#8B0000;cursor:pointer;display:flex;align-items:center;gap:8px;">
                                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg> Tolak
                                                </button>
                                            </form>
                                            <div style="height:1px;background:#f5f5f5;"></div>
                                        @endif

                                        @if($p->status == 'menunggu_kembali')
                                            <form action="{{ route('admin.peminjaman.updateStatus',$p->id) }}" method="POST">
                                                @csrf @method('PUT')
                                                <input type="hidden" name="status" value="dikembalikan">
                                                <button type="submit" onclick="return confirm('Konfirmasi buku sudah diterima?')" style="width:100%;text-align:left;padding:10px 14px;background:none;border:none;font-size:0.95rem;font-weight:600;color:#1e40af;cursor:pointer;display:flex;align-items:center;gap:8px;">
                                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg> Konfirmasi Diterima
                                                </button>
                                            </form>
                                            <div style="height:1px;background:#f5f5f5;"></div>
                                        @endif

                                        @if($p->status == 'terlambat')
                                            <form action="{{ route('admin.peminjaman.updateStatus',$p->id) }}" method="POST">
                                                @csrf @method('PUT')
                                                <input type="hidden" name="status" value="dikembalikan">
                                                <button type="submit" onclick="return confirm('Konfirmasi buku sudah diterima?')" style="width:100%;text-align:left;padding:10px 14px;background:none;border:none;font-size:0.95rem;font-weight:600;color:#c2410c;cursor:pointer;display:flex;align-items:center;gap:8px;">
                                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg> Dikembalikan
                                                </button>
                                            </form>
                                            <div style="height:1px;background:#f5f5f5;"></div>
                                        @endif

                                        <form action="{{ route('admin.peminjaman.destroy',$p->id) }}" method="POST" onsubmit="return confirm('Hapus data ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" style="width:100%;text-align:left;padding:10px 14px;background:none;border:none;font-size:0.95rem;font-weight:600;color:#8B0000;cursor:pointer;display:flex;align-items:center;gap:8px;">
                                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4h6v2"/></svg> Hapus
                                            </button>
                                        </form>

                                    </div>
                                </td>

                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" style="padding:60px;text-align:center;color:#9e6060;font-size:1.02rem;">
                                    {{ $search ? '🔍 Tidak ada hasil untuk "'.$search.'"' : '📭 Belum ada data peminjaman' }}
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($data->hasPages())
                <div style="padding:1.25rem 1.5rem;border-top:1px solid #f5f5f5;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:0.75rem;">
                    <span style="color:#888;font-size:0.85rem;">{{ $data->firstItem() }}–{{ $data->lastItem() }} dari {{ $data->total() }} data</span>
                    <div style="display:flex;gap:6px;flex-wrap:wrap;">
                        @if(!$data->onFirstPage())
                            <a href="{{ $data->previousPageUrl() }}" style="padding:7px 14px;background:#f8f9fa;color:#666;border-radius:7px;text-decoration:none;font-weight:600;font-size:0.85rem;">← Prev</a>
                        @endif
                        @foreach(range(1,$data->lastPage()) as $page)
                            <a href="{{ $data->url($page) }}" style="padding:7px 12px;background:{{ $page==$data->currentPage()?'#8B0000':'#f8f9fa' }};color:{{ $page==$data->currentPage()?'white':'#666' }};border-radius:7px;text-decoration:none;font-weight:600;font-size:0.85rem;">{{ $page }}</a>
                        @endforeach
                        @if($data->hasMorePages())
                            <a href="{{ $data->nextPageUrl() }}" style="padding:7px 14px;background:#f8f9fa;color:#666;border-radius:7px;text-decoration:none;font-weight:600;font-size:0.85rem;">Next →</a>
                        @endif
                    </div>
                </div>
                @endif
            </div>

        </div>
    </div>
</div>

<script>
function toggleDD(e, id) {
    e.stopPropagation();
    const btn = e.currentTarget;
    const dd = document.getElementById(id);
    const isOpen = dd.style.display === 'block';

    // Tutup semua
    document.querySelectorAll('[id^="dd"]').forEach(el => el.style.display = 'none');

    if (!isOpen) {
        const rect = btn.getBoundingClientRect();
        dd.style.display = 'block';
        // Posisi di bawah tombol, rata kanan
        dd.style.top = (rect.bottom + window.scrollY + 4) + 'px';
        dd.style.left = (rect.right + window.scrollX - 180) + 'px';
    }
}

document.addEventListener('click', () => {
    document.querySelectorAll('[id^="dd"]').forEach(el => el.style.display = 'none');
});

document.addEventListener('DOMContentLoaded', () => {
    ['alert-s','alert-e'].forEach(id => {
        const el = document.getElementById(id);
        if (el) setTimeout(() => { el.style.transition='opacity 0.5s'; el.style.opacity='0'; setTimeout(()=>el.style.display='none',500); }, 4000);
    });
});
</script>

@endsection