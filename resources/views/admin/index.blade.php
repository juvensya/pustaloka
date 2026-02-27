@extends('layout.app')

@section('content')
<div class="container-fluid" style="font-family:'Plus Jakarta Sans',sans-serif;">
    <div class="row">
        <!-- Sidebar -->
        @include('layout.sidebar')
 
        <!-- Main Content -->
        <div class="col p-3" style="background:#f8f9fa;min-height:100vh;">

            @include('layout.navbar')

            <!-- Header -->
            <div style="margin-bottom:2rem;">
                
                <div style="display:flex;align-items:center;gap:12px;">
                    <div style="width:4px;height:40px;background:#8B0000;border-radius:2px;"></div>
                    <div>
                        <p style="font-size:0.8rem;font-weight:700;text-transform:uppercase;letter-spacing:0.15em;color:#8B0000;margin:0 0 2px;">Selamat datang, {{ auth()->user()->name }}</p>
                        <h2 style="font-size:1.75rem;font-weight:800;color:#141516;margin:0;letter-spacing:-0.5px;">Dashboard</h2>
                    </div>
                </div>
            </div>

            {{-- Stat Cards --}}
            <div class="row g-3 mb-4">

                <div class="col-md-3">
                    <div class="dash-card">
                        <div style="display:flex;justify-content:space-between;align-items:flex-start;">
                            <div>
                                <p class="dash-label">Total Buku</p>
                                <h2 class="dash-number">{{ $totalBuku }}</h2>
                            </div>
                            <div class="dash-icon" style="background:linear-gradient(135deg,#8B0000,#5C0000);">
                                <i class="bi bi-book-fill"></i>
                            </div>
                        </div>
                        <div style="margin-top:1rem;height:3px;background:#f0ece8;border-radius:2px;">
                            <div style="height:100%;width:70%;background:linear-gradient(90deg,#8B0000,#c0392b);border-radius:2px;"></div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="dash-card">
                        <div style="display:flex;justify-content:space-between;align-items:flex-start;">
                            <div>
                                <p class="dash-label">Kategori</p>
                                <h2 class="dash-number">{{ $totalKategori }}</h2>
                            </div>
                            <div class="dash-icon" style="background:linear-gradient(135deg,#a83240,#7B0000);">
                                <i class="bi bi-folder-fill"></i>
                            </div>
                        </div>
                        <div style="margin-top:1rem;height:3px;background:#f0ece8;border-radius:2px;">
                            <div style="height:100%;width:50%;background:linear-gradient(90deg,#a83240,#7B0000);border-radius:2px;"></div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="dash-card">
                        <div style="display:flex;justify-content:space-between;align-items:flex-start;">
                            <div>
                                <p class="dash-label">Anggota Aktif</p>
                                <h2 class="dash-number">{{ $totalAnggota }}</h2>
                            </div>
                            <div class="dash-icon" style="background:linear-gradient(135deg,#c0392b,#e74c3c);">
                                <i class="bi bi-people-fill"></i>
                            </div>
                        </div>
                        <div style="margin-top:1rem;height:3px;background:#f0ece8;border-radius:2px;">
                            <div style="height:100%;width:80%;background:linear-gradient(90deg,#c0392b,#e74c3c);border-radius:2px;"></div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="dash-card">
                        <div style="display:flex;justify-content:space-between;align-items:flex-start;">
                            <div>
                                <p class="dash-label">Peminjaman Aktif</p>
                                <h2 class="dash-number">{{ $totalPeminjaman }}</h2>
                            </div>
                            <div class="dash-icon" style="background:linear-gradient(135deg,#922b21,#f1948a);">
                                <i class="bi bi-arrow-repeat"></i>
                            </div>
                        </div>
                        <div style="margin-top:1rem;height:3px;background:#f0ece8;border-radius:2px;">
                            <div style="height:100%;width:60%;background:linear-gradient(90deg,#922b21,#f1948a);border-radius:2px;"></div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Bottom Section --}}
            <div class="row g-3">

                {{-- Aktivitas Terbaru --}}
                <div class="col-md-7">
                    <div class="dash-panel">
                        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem;">
                            <h5 style="font-size:1rem;font-weight:700;color:#141516;margin:0;">Aktivitas Terbaru</h5>
                            <a href="{{ route('admin.peminjaman.index') }}" style="font-size:0.8rem;color:#8B0000;text-decoration:none;font-weight:600;">Lihat semua →</a>
                        </div>

                        @forelse($aktivitas as $item)
                        <div style="display:flex;align-items:center;gap:1rem;padding:0.85rem 0;border-bottom:1px solid #f5f0ee;">
                            <div style="width:38px;height:38px;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:1rem;
                                @if($item->status == 'menunggu') background:#fefce8;color:#a16207;
                                @elseif($item->status == 'disetujui') background:#f0fdf4;color:#15803d;
                                @elseif($item->status == 'dikembalikan') background:#eff6ff;color:#1d4ed8;
                                @elseif($item->status == 'terlambat') background:#fff5f5;color:#8B0000;
                                @elseif($item->status == 'ditolak') background:#f3f4f6;color:#6b7280;
                                @endif">
                                <i class="bi
                                    @if($item->status == 'menunggu') bi-clock
                                    @elseif($item->status == 'disetujui') bi-check-lg
                                    @elseif($item->status == 'dikembalikan') bi-arrow-counterclockwise
                                    @elseif($item->status == 'terlambat') bi-exclamation-triangle
                                    @elseif($item->status == 'ditolak') bi-x-lg
                                    @endif">
                                </i>
                            </div>

                            <div style="flex:1;min-width:0;">
                                <p style="margin:0;font-size:0.875rem;font-weight:600;color:#1a0000;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                    {{ $item->user->name }}
                                    <span style="font-weight:400;color:#6b7280;">—</span>
                                    {{ $item->buku->judul }}
                                </p>
                                <p style="margin:0;font-size:0.75rem;color:#9e6060;">{{ $item->created_at->diffForHumans() }}</p>
                            </div>

                            <span style="flex-shrink:0;font-size:0.7rem;font-weight:700;padding:0.25rem 0.65rem;border-radius:999px;
                                @if($item->status == 'menunggu') background:#fefce8;color:#a16207;
                                @elseif($item->status == 'disetujui') background:#f0fdf4;color:#15803d;
                                @elseif($item->status == 'dikembalikan') background:#eff6ff;color:#1d4ed8;
                                @elseif($item->status == 'terlambat') background:#fff5f5;color:#8B0000;
                                @elseif($item->status == 'ditolak') background:#f3f4f6;color:#6b7280;
                                @endif">
                                {{ ucfirst($item->status) }}
                            </span>
                        </div>
                        @empty
                        <div style="text-align:center;padding:3rem 0;color:#c0a0a0;">
                            <i class="bi bi-inbox" style="font-size:2rem;"></i>
                            <p style="margin-top:0.5rem;font-size:0.875rem;">Belum ada aktivitas</p>
                        </div>
                        @endforelse
                    </div>
                </div>

                {{-- Buku Terpopuler --}}
                <div class="col-md-5">
                    <div class="dash-panel">
                        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem;">
                            <h5 style="font-size:1rem;font-weight:700;color:#141516;margin:0;">Buku Terpopuler</h5>
                            <a href="{{ route('buku.index') }}" style="font-size:0.8rem;color:#8B0000;text-decoration:none;font-weight:600;">Lihat semua →</a>
                        </div>

                        @forelse($bukuPopuler as $index => $buku)
                        @php
                            $barColors = ['#8B0000','#a83240','#c0392b','#922b21','#e57373'];
                            $barColor  = $barColors[$index % count($barColors)];
                            $persen    = $maxPinjam > 0 ? round(($buku->peminjamans_count / $maxPinjam) * 100) : 0;
                        @endphp
                        <div style="margin-bottom:1.25rem;">
                            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:0.4rem;">
                                <span style="font-size:0.85rem;font-weight:600;color:#1a0000;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:65%;">{{ $buku->judul }}</span>
                                <span style="font-size:0.75rem;font-weight:700;color:{{ $barColor }};">{{ $buku->peminjamans_count }}x</span>
                            </div>
                            <div style="height:6px;background:#f0ece8;border-radius:999px;overflow:hidden;">
                                <div style="height:100%;width:{{ $persen }}%;background:{{ $barColor }};border-radius:999px;"></div>
                            </div>
                        </div>
                        @empty
                        <div style="text-align:center;padding:3rem 0;color:#c0a0a0;">
                            <i class="bi bi-book" style="font-size:2rem;"></i>
                            <p style="margin-top:0.5rem;font-size:0.875rem;">Belum ada data peminjaman</p>
                        </div>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

.dash-card {
    background: white;
    border-radius: 16px;
    padding: 1.5rem;
    border: 1px solid #f0ece8;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.dash-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 24px rgba(139,0,0,0.08);
}
.dash-label {
    font-size: 0.8rem;
    font-weight: 600;
    color: #9e6060;
    margin: 0 0 6px;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}
.dash-number {
    font-size: 2.2rem;
    font-weight: 800;
    color: #141516;
    margin: 0;
    letter-spacing: -1px;
}
.dash-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.3rem;
    color: white;
    flex-shrink: 0;
}
.dash-panel {
    background: white;
    border-radius: 16px;
    padding: 1.5rem;
    border: 1px solid #f0ece8;
    height: 100%;
}
</style>

@endsection