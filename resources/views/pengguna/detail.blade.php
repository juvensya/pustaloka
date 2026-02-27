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
                            ⚠️ Kamu sudah memiliki 2 peminjaman aktif. Kembalikan buku terlebih dahulu untuk meminjam lagi.
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

                    <a href="{{ route('pengguna.index') }}" 
                       class="btn btn-outline-secondary mt-2">
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


{{-- ===================== MODAL KONFIRMASI PINJAM ===================== --}}
@if($buku->stock > 0 && $peminjamAktif < 2)
<div class="modal fade" id="modalPinjam" tabindex="-1" aria-labelledby="modalPinjamLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalPinjamLabel">
                    <i class="bi bi-book me-2"></i>Konfirmasi Peminjaman
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>

            <form action="{{ route('pinjam.store', $buku->id) }}" method="POST">
                @csrf

                <div class="modal-body">

                    {{-- Info Buku --}}
                    <div class="mb-3 p-3 bg-light rounded">
                        <h6 class="fw-bold text-primary mb-2">📚 Informasi Buku</h6>
                        <table class="table table-sm table-borderless mb-0">
                            <tr>
                                <td class="text-muted" style="width:35%">Judul</td>
                                <td>: <strong>{{ $buku->judul }}</strong></td>
                            </tr>
                            <tr>
                                <td class="text-muted">Penulis</td>
                                <td>: {{ $buku->penulis }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Penerbit</td>
                                <td>: {{ $buku->penerbit }}</td>
                            </tr>
                        </table>
                    </div>

                    {{-- Info Peminjam --}}
                    <div class="mb-3 p-3 bg-light rounded">
                        <h6 class="fw-bold text-primary mb-2">👤 Informasi Peminjam</h6>
                        <table class="table table-sm table-borderless mb-0">
                            <tr>
                                <td class="text-muted" style="width:35%">Nama</td>
                                <td>: <strong>{{ auth()->user()->name }}</strong></td>
                            </tr>
                            <tr>
                                <td class="text-muted">Email</td>
                                <td>: {{ auth()->user()->email }}</td>
                            </tr>
                        </table>
                    </div>

                    {{-- Tanggal --}}
                    <div class="mb-3 p-3 bg-light rounded">
                        <h6 class="fw-bold text-primary mb-2">📅 Tanggal Peminjaman</h6>

                        <div class="mb-2">
                            <label class="form-label text-muted small mb-1">Tanggal Pinjam</label>
                            <input type="text" 
                                   class="form-control form-control-sm bg-white" 
                                   value="{{ \Carbon\Carbon::now('Asia/Jakarta')->isoFormat('D MMMM YYYY') }}" 
                                   readonly disabled>
                            <input type="hidden" name="tanggal_pinjam" value="{{ $today }}">
                        </div>

                        <div>
                            <label for="tanggal_kembali" class="form-label text-muted small mb-1">
                                Tanggal Kembali <span class="text-danger">*</span>
                            </label>
                            <input type="date"
                                   id="tanggal_kembali"
                                   name="tanggal_kembali"
                                   class="form-control form-control-sm"
                                   min="{{ \Carbon\Carbon::now('Asia/Jakarta')->addDay(1)->format('Y-m-d') }}"
                                   max="{{ $maxKembali }}"
                                   value="{{ $maxKembali }}"
                                   required>
                            <div class="form-text text-muted" style="font-size:0.78rem;">
                                ⏳ Maksimal peminjaman <strong>14 hari</strong> dari hari ini (s/d {{ \Carbon\Carbon::now('Asia/Jakarta')->addDays(14)->isoFormat('D MMMM YYYY') }})
                            </div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-1"></i>Konfirmasi Pinjam
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>
@endif

@endsection