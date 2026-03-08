@extends('layouts.app')

@section('content')

<div class="container py-4">

    <h3 class="mb-4">Detail Buku</h3>

    {{-- NOTIF --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @php
        $peminjamAktif = auth()->user()->peminjamans()
            ->whereIn('status', ['menunggu', 'disetujui'])
            ->count();
        
        $today      = \Carbon\Carbon::now('Asia/Jakarta')->format('Y-m-d');
        $maxKembali = \Carbon\Carbon::now('Asia/Jakarta')->addDays(14)->format('Y-m-d');
    @endphp

    <div class="row">

        {{-- COVER --}}
        <div class="col-md-4">
            <div class="card shadow-sm">
                @if($buku->gambar)
                    <img src="{{ asset('uploads/buku/' . $buku->gambar) }}" 
                         class="card-img-top"
                         style="height: 400px; object-fit: cover;"
                         alt="Cover Buku">
                @else
                    <img src="{{ asset('images/no-image.png') }}" 
                         class="card-img-top"
                         style="height: 400px; object-fit: cover;"
                         alt="Tidak ada gambar">
                @endif
            </div>
        </div>

        {{-- DETAIL --}}
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body">

                    <h4 class="mb-3">{{ $buku->judul }}</h4>

                    {{-- RATING --}}
                    <div class="mb-2">
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= round($rating))
                                <span style="color:gold;">★</span>
                            @else
                                <span style="color:#ccc;">★</span>
                            @endif
                        @endfor

                        <small class="text-muted">
                            ({{ number_format($rating,1) }} / 5 dari {{ $totalUlasan }} ulasan)
                        </small>
                    </div>

                    <p>
                        <strong>Penulis:</strong> {{ $buku->penulis }} <br>
                        <strong>Penerbit:</strong> {{ $buku->penerbit }} <br>
                        <strong>Tahun Terbit:</strong> {{ $buku->tahun_terbit }} <br>
                        <strong>Kategori:</strong> {{ $buku->kategori->nama_kategori ?? '-' }} <br>
                        <strong>Stok:</strong>
                        @if($buku->stock > 0)
                            <span class="text-success">{{ $buku->stock }}</span>
                        @else
                            <span class="text-danger">Habis</span>
                        @endif
                    </p>

                    <hr>

                    <h6>Deskripsi</h6>
                    <p style="text-align: justify;">
                        {{ $buku->deskripsi }}
                    </p>

                    <hr>

                    {{-- BUTTON PINJAM --}}
                    @if($peminjamAktif >= 2)
                        <button class="btn btn-secondary" disabled>
                            Batas Peminjaman Tercapai
                        </button>
                        <div class="alert alert-warning mt-2" style="font-size:0.85rem;">
                            ⚠️ Kamu sudah memiliki 2 peminjaman aktif.
                        </div>
                    @elseif($buku->stock > 0)
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalPinjam">
                            Pinjam Buku
                        </button>
                    @else
                        <button class="btn btn-secondary" disabled>
                            Stok Habis
                        </button>
                    @endif

                    <a href="{{ route('pengguna.index') }}" class="btn btn-outline-secondary mt-2">
                        Kembali
                    </a>
                    
                    <form action="{{ route('koleksi.store', $buku->id) }}" method="POST" class="mt-2">
                        @csrf
                        <button type="submit" class="btn btn-success">
                            Tambahkan ke Koleksi
                        </button>
                    </form>

                </div>
            </div>
        </div>

    </div>

</div>

{{-- ===================== MODAL PINJAM ===================== --}}
@if($buku->stock > 0 && $peminjamAktif < 2)
<div class="modal fade" id="modalPinjam">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Konfirmasi Peminjaman</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('pinjam.store', $buku->id) }}" method="POST">
                @csrf

                <div class="modal-body">

                    <strong>{{ $buku->judul }}</strong>

                    <div class="mt-3">
                        <label>Tanggal Kembali</label>
                        <input type="date"
                               name="tanggal_kembali"
                               class="form-control"
                               max="{{ $maxKembali }}"
                               required>
                    </div>

                    <input type="hidden" name="tanggal_pinjam" value="{{ $today }}">

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        Konfirmasi Pinjam
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>
@endif


{{-- ===================== ULASAN PEMBACA ===================== --}}
<div class="container mt-4">

<h5 class="mb-3">Ulasan Pembaca</h5>

@if($ulasans->count() > 0)

    @foreach($ulasans as $ulasan)

        <div class="card mb-3 shadow-sm">
            <div class="card-body">

                <strong>{{ $ulasan->user->name }}</strong>

                <div>
                    @for ($i = 1; $i <= 5; $i++)
                        @if ($i <= $ulasan->rating)
                            <span style="color:gold;">★</span>
                        @else
                            <span style="color:#ccc;">★</span>
                        @endif
                    @endfor
                </div>

                <p class="mt-2 mb-0">
                    {{ $ulasan->komentar }}
                </p>

            </div>
        </div>

    @endforeach

@else

<p class="text-muted">Belum ada ulasan untuk buku ini.</p>

@endif

</div>

@endsection