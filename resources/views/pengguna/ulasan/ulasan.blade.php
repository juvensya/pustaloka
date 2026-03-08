@extends('layouts.app')

@section('content')

<div class="container py-4">

<h3 class="mb-4">Ulasan Saya</h3>

@if($ulasans->count() > 0)

@foreach($ulasans as $ulasan)

<div class="card mb-3 p-3 shadow-sm">

    <div class="row align-items-center">

        {{-- COVER BUKU --}}
        <div class="col-md-2">

            @if($ulasan->buku->gambar)

            <img src="{{ asset('uploads/buku/'.$ulasan->buku->gambar) }}"
                 alt="{{ $ulasan->buku->judul }}"
                 class="img-fluid rounded"
                 style="height:120px; object-fit:cover;">

            @else

            <img src="{{ asset('images/no-book.png') }}"
                 class="img-fluid rounded"
                 style="height:120px; object-fit:cover;">

            @endif

        </div>

        {{-- INFO BUKU --}}
        <div class="col-md-7">

            <h5 class="fw-bold mb-1">
                {{ $ulasan->buku->judul }}
            </h5>

            <p class="text-muted mb-1">
                Penerbit : {{ $ulasan->buku->penerbit }}
            </p>

            <p class="text-muted mb-2">
                Tahun Terbit : {{ $ulasan->buku->tahun_terbit }}
            </p>

            {{-- RATING BINTANG --}}
            <div class="mb-2">

            @for($i = 1; $i <= 5; $i++)

                @if($i <= $ulasan->rating)
                    <span style="color:gold; font-size:18px;">★</span>
                @else
                    <span style="color:#ccc; font-size:18px;">★</span>
                @endif

            @endfor

            </div>

            {{-- KOMENTAR --}}
            <p class="mb-0">
                {{ $ulasan->komentar }}
            </p>

        </div>

        {{-- ACTION --}}
        <div class="col-md-3 text-end">

            <div class="dropdown">

                <button class="btn btn-sm btn-secondary dropdown-toggle"
                        type="button"
                        data-bs-toggle="dropdown">
                    Aksi
                </button>

                <ul class="dropdown-menu">

                    {{-- EDIT --}}
                    <li>
                        <a class="dropdown-item"
                           href="{{ route('ulasan.edit',$ulasan->id) }}">
                            Edit
                        </a>
                    </li>

                    {{-- HAPUS --}}
                    <li>
                        <form action="{{ route('ulasan.destroy',$ulasan->id) }}"
                              method="POST">

                            @csrf
                            @method('DELETE')

                            <button class="dropdown-item text-danger"
                                    onclick="return confirm('Hapus ulasan ini?')">
                                Hapus
                            </button>

                        </form>
                    </li>

                </ul>

            </div>

        </div>

    </div>

</div>

@endforeach

@else

<div class="alert alert-info">
    Kamu belum membuat ulasan.
</div>

@endif

</div>

@endsection