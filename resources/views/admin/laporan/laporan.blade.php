@extends('layout.app')

@section('content')
<div class="container-fluid">
<div class="row">
@include('layout.sidebar')
<div class="col p-4" style="background:#f4f4f5;min-height:100vh;">

    {{-- Header --}}
    <div style="display:flex;align-items:center;gap:12px;margin-bottom:2rem;">
        <div style="width:4px;height:40px;background:#8B0000;border-radius:2px;"></div>
        <div>
            <h2 style="font-size:1.75rem;font-weight:800;color:#141516;margin:0;letter-spacing:-0.5px;">Laporan</h2>
            <p style="color:#888;font-size:0.875rem;margin:0;">Unduh laporan data perpustakaan dalam format PDF</p>
        </div>
    </div>

    {{-- Stat Cards --}}
    <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:1rem;margin-bottom:2rem;">

        <div style="background:#fff;border-radius:14px;padding:1.25rem 1.5rem;border:1px solid #e9e9eb;display:flex;align-items:center;gap:1rem;">
            <div style="width:44px;height:44px;background:#fff0f0;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8B0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
            </div>
            <div>
                <div style="font-size:1.6rem;font-weight:800;color:#141516;line-height:1;">{{ $totalBuku }}</div>
                <div style="font-size:0.75rem;color:#999;margin-top:2px;">Total Buku</div>
            </div>
        </div>

        <div style="background:#fff;border-radius:14px;padding:1.25rem 1.5rem;border:1px solid #e9e9eb;display:flex;align-items:center;gap:1rem;">
            <div style="width:44px;height:44px;background:#fff0f0;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8B0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-3.87"/></svg>
            </div>
            <div>
                <div style="font-size:1.6rem;font-weight:800;color:#141516;line-height:1;">{{ $totalPeminjaman }}</div>
                <div style="font-size:0.75rem;color:#999;margin-top:2px;">Total Peminjaman</div>
            </div>
        </div>

        <div style="background:#fff;border-radius:14px;padding:1.25rem 1.5rem;border:1px solid #e9e9eb;display:flex;align-items:center;gap:1rem;">
            <div style="width:44px;height:44px;background:#fff0f0;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8B0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
            <div>
                <div style="font-size:1.6rem;font-weight:800;color:#141516;line-height:1;">{{ $totalDikembalikan }}</div>
                <div style="font-size:0.75rem;color:#999;margin-top:2px;">Dikembalikan</div>
            </div>
        </div>

        <div style="background:#8B0000;border-radius:14px;padding:1.25rem 1.5rem;display:flex;align-items:center;gap:1rem;">
            <div style="width:44px;height:44px;background:rgba(255,255,255,0.15);border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            </div>
            <div>
                <div style="font-size:1.6rem;font-weight:800;color:#fff;line-height:1;">{{ $totalTerlambat }}</div>
                <div style="font-size:0.75rem;color:rgba(255,255,255,0.7);margin-top:2px;">Terlambat</div>
            </div>
        </div>

    </div>

    {{-- Filter --}}
    <div style="background:#fff;border-radius:14px;border:1px solid #e9e9eb;padding:1.25rem 1.5rem;margin-bottom:1.75rem;">
        <div style="display:flex;align-items:center;gap:0.5rem;margin-bottom:1rem;">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#8B0000" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg>
            <span style="font-size:0.82rem;font-weight:700;color:#141516;">Filter Laporan</span>
            <span style="font-size:0.75rem;color:#bbb;margin-left:2px;">— berlaku untuk Peminjaman &amp; Pengembalian</span>
        </div>
        <div style="display:flex;align-items:flex-end;gap:0.75rem;flex-wrap:wrap;">

            <div style="display:flex;flex-direction:column;gap:0.3rem;">
                <label style="font-size:0.72rem;font-weight:600;color:#999;text-transform:uppercase;letter-spacing:0.05em;">Tanggal Mulai</label>
                <input type="date" id="tgl-mulai"
                    style="padding:0.52rem 0.85rem;border:1.5px solid #e9e9eb;border-radius:8px;font-size:0.85rem;color:#141516;outline:none;background:#fff;font-family:inherit;"
                    onfocus="this.style.borderColor='#8B0000'" onblur="this.style.borderColor='#e9e9eb'">
            </div>

            <div style="display:flex;flex-direction:column;gap:0.3rem;">
                <label style="font-size:0.72rem;font-weight:600;color:#999;text-transform:uppercase;letter-spacing:0.05em;">Tanggal Akhir</label>
                <input type="date" id="tgl-akhir"
                    style="padding:0.52rem 0.85rem;border:1.5px solid #e9e9eb;border-radius:8px;font-size:0.85rem;color:#141516;outline:none;background:#fff;font-family:inherit;"
                    onfocus="this.style.borderColor='#8B0000'" onblur="this.style.borderColor='#e9e9eb'">
            </div>

            <div style="display:flex;flex-direction:column;gap:0.3rem;">
                <label style="font-size:0.72rem;font-weight:600;color:#999;text-transform:uppercase;letter-spacing:0.05em;">Bulan</label>
                <select id="filter-bulan"
                    style="padding:0.52rem 0.85rem;border:1.5px solid #e9e9eb;border-radius:8px;font-size:0.85rem;color:#141516;outline:none;background:#fff;cursor:pointer;font-family:inherit;"
                    onfocus="this.style.borderColor='#8B0000'" onblur="this.style.borderColor='#e9e9eb'">
                    <option value="">Semua Bulan</option>
                    <option value="01">Januari</option><option value="02">Februari</option>
                    <option value="03">Maret</option><option value="04">April</option>
                    <option value="05">Mei</option><option value="06">Juni</option>
                    <option value="07">Juli</option><option value="08">Agustus</option>
                    <option value="09">September</option><option value="10">Oktober</option>
                    <option value="11">November</option><option value="12">Desember</option>
                </select>
            </div>

            <div style="display:flex;flex-direction:column;gap:0.3rem;">
                <label style="font-size:0.72rem;font-weight:600;color:#999;text-transform:uppercase;letter-spacing:0.05em;">Tahun</label>
                <select id="filter-tahun"
                    style="padding:0.52rem 0.85rem;border:1.5px solid #e9e9eb;border-radius:8px;font-size:0.85rem;color:#141516;outline:none;background:#fff;cursor:pointer;font-family:inherit;"
                    onfocus="this.style.borderColor='#8B0000'" onblur="this.style.borderColor='#e9e9eb'">
                    <option value="">Semua Tahun</option>
                    @for($y = now()->year; $y >= now()->year - 5; $y--)
                        <option value="{{ $y }}">{{ $y }}</option>
                    @endfor
                </select>
            </div>

            <button onclick="resetFilter()"
                style="padding:0.52rem 1rem;border:1.5px solid #e9e9eb;background:#fff;color:#999;border-radius:8px;font-size:0.82rem;font-weight:600;cursor:pointer;font-family:inherit;display:flex;align-items:center;gap:0.35rem;"
                onmouseover="this.style.borderColor='#8B0000';this.style.color='#8B0000'"
                onmouseout="this.style.borderColor='#e9e9eb';this.style.color='#999'">
                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-3.87"/></svg>
                Reset
            </button>

        </div>
    </div>

    {{-- Laporan Cards --}}
    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:1.25rem;">

        {{-- Laporan Buku --}}
        <div style="background:#fff;border-radius:16px;border:1px solid #e9e9eb;padding:1.5rem;display:flex;flex-direction:column;gap:1.25rem;">
            <div style="display:flex;align-items:center;gap:0.85rem;">
                <div style="width:44px;height:44px;background:#fff0f0;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8B0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                </div>
                <div>
                    <div style="font-size:0.95rem;font-weight:700;color:#141516;">Data Buku</div>
                    <div style="font-size:0.76rem;color:#999;margin-top:1px;">Seluruh koleksi perpustakaan</div>
                </div>
            </div>
            <div style="height:1px;background:#f0f0f0;"></div>
            <div style="display:flex;flex-direction:column;gap:0.4rem;">
                <div style="font-size:0.8rem;color:#666;display:flex;align-items:center;gap:8px;">
                    <span style="width:5px;height:5px;border-radius:50%;background:#8B0000;flex-shrink:0;"></span>Judul, penulis &amp; penerbit
                </div>
                <div style="font-size:0.8rem;color:#666;display:flex;align-items:center;gap:8px;">
                    <span style="width:5px;height:5px;border-radius:50%;background:#8B0000;flex-shrink:0;"></span>Kategori &amp; tahun terbit
                </div>
                <div style="font-size:0.8rem;color:#666;display:flex;align-items:center;gap:8px;">
                    <span style="width:5px;height:5px;border-radius:50%;background:#8B0000;flex-shrink:0;"></span>Stok tersedia
                </div>
            </div>
            <a href="{{ route('admin.laporan.buku.pdf') }}"
               style="display:flex;align-items:center;justify-content:center;gap:7px;padding:0.7rem;background:#8B0000;color:#fff;border-radius:9px;font-size:0.83rem;font-weight:700;text-decoration:none;margin-top:auto;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                Download PDF
            </a>
        </div>

        {{-- Laporan Peminjaman --}}
        <div style="background:#fff;border-radius:16px;border:1px solid #e9e9eb;padding:1.5rem;display:flex;flex-direction:column;gap:1.25rem;">
            <div style="display:flex;align-items:center;gap:0.85rem;">
                <div style="width:44px;height:44px;background:#fff0f0;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8B0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-3.87"/></svg>
                </div>
                <div>
                    <div style="font-size:0.95rem;font-weight:700;color:#141516;">Peminjaman</div>
                    <div style="font-size:0.76rem;color:#999;margin-top:1px;">Data peminjaman aktif</div>
                </div>
            </div>
            <div style="height:1px;background:#f0f0f0;"></div>
            <div style="display:flex;flex-direction:column;gap:0.4rem;">
                <div style="font-size:0.8rem;color:#666;display:flex;align-items:center;gap:8px;">
                    <span style="width:5px;height:5px;border-radius:50%;background:#8B0000;flex-shrink:0;"></span>Nama peminjam &amp; judul buku
                </div>
                <div style="font-size:0.8rem;color:#666;display:flex;align-items:center;gap:8px;">
                    <span style="width:5px;height:5px;border-radius:50%;background:#8B0000;flex-shrink:0;"></span>Tanggal pinjam &amp; batas kembali
                </div>
                <div style="font-size:0.8rem;color:#666;display:flex;align-items:center;gap:8px;">
                    <span style="width:5px;height:5px;border-radius:50%;background:#8B0000;flex-shrink:0;"></span>Status peminjaman
                </div>
            </div>
            <a id="btn-peminjaman" href="{{ route('admin.laporan.peminjaman.pdf') }}"
               style="display:flex;align-items:center;justify-content:center;gap:7px;padding:0.7rem;background:#8B0000;color:#fff;border-radius:9px;font-size:0.83rem;font-weight:700;text-decoration:none;margin-top:auto;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                Download PDF
            </a>
        </div>

        {{-- Laporan Pengembalian --}}
        <div style="background:#fff;border-radius:16px;border:1px solid #e9e9eb;padding:1.5rem;display:flex;flex-direction:column;gap:1.25rem;">
            <div style="display:flex;align-items:center;gap:0.85rem;">
                <div style="width:44px;height:44px;background:#fff0f0;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8B0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                </div>
                <div>
                    <div style="font-size:0.95rem;font-weight:700;color:#141516;">Pengembalian</div>
                    <div style="font-size:0.76rem;color:#999;margin-top:1px;">Riwayat buku dikembalikan</div>
                </div>
            </div>
            <div style="height:1px;background:#f0f0f0;"></div>
            <div style="display:flex;flex-direction:column;gap:0.4rem;">
                <div style="font-size:0.8rem;color:#666;display:flex;align-items:center;gap:8px;">
                    <span style="width:5px;height:5px;border-radius:50%;background:#8B0000;flex-shrink:0;"></span>Nama peminjam &amp; judul buku
                </div>
                <div style="font-size:0.8rem;color:#666;display:flex;align-items:center;gap:8px;">
                    <span style="width:5px;height:5px;border-radius:50%;background:#8B0000;flex-shrink:0;"></span>Tanggal kembali &amp; dikembalikan
                </div>
                <div style="font-size:0.8rem;color:#666;display:flex;align-items:center;gap:8px;">
                    <span style="width:5px;height:5px;border-radius:50%;background:#8B0000;flex-shrink:0;"></span>Tepat waktu / terlambat
                </div>
            </div>
            <a id="btn-pengembalian" href="{{ route('admin.laporan.pengembalian.pdf') }}"
               style="display:flex;align-items:center;justify-content:center;gap:7px;padding:0.7rem;background:#8B0000;color:#fff;border-radius:9px;font-size:0.83rem;font-weight:700;text-decoration:none;margin-top:auto;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                Download PDF
            </a>
        </div>

    </div>

</div>
</div>
</div>

<script>
const basePeminjaman   = "{{ route('admin.laporan.peminjaman.pdf') }}";
const basePengembalian = "{{ route('admin.laporan.pengembalian.pdf') }}";

function updateLinks() {
    const params = new URLSearchParams();
    const tglMulai = document.getElementById('tgl-mulai').value;
    const tglAkhir = document.getElementById('tgl-akhir').value;
    const bulan    = document.getElementById('filter-bulan').value;
    const tahun    = document.getElementById('filter-tahun').value;
    if (tglMulai) params.set('tgl_mulai', tglMulai);
    if (tglAkhir) params.set('tgl_akhir', tglAkhir);
    if (bulan)    params.set('bulan', bulan);
    if (tahun)    params.set('tahun', tahun);
    const q = params.toString() ? '?' + params.toString() : '';
    document.getElementById('btn-peminjaman').href   = basePeminjaman + q;
    document.getElementById('btn-pengembalian').href = basePengembalian + q;
}

function resetFilter() {
    ['tgl-mulai','tgl-akhir','filter-bulan','filter-tahun'].forEach(id => document.getElementById(id).value = '');
    updateLinks();
}

['tgl-mulai','tgl-akhir','filter-bulan','filter-tahun'].forEach(id => {
    document.getElementById(id).addEventListener('change', updateLinks);
});
</script>

@endsection