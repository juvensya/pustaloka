@extends('layouts.app')

@section('content')

<div class="max-w-4xl mx-auto px-4 py-10">

    {{-- Header --}}
    <div class="bg-[#8B0000] rounded-xl px-7 py-4 mb-6 flex items-center justify-between flex-wrap gap-3">
        <div>
            <h3 class="text-white font-bold text-lg tracking-tight m-0">Koleksi Saya</h3>
            <p class="text-white/60 text-xs mt-0.5 mb-0">Buku-buku yang kamu simpan</p>
        </div>
        @if($koleksi->count() > 0)
            <span class="bg-white text-[#8B0000] text-xs font-bold px-3 py-1 rounded-full">
                {{ $koleksi->count() }} Buku
            </span>
        @endif
    </div>

    {{-- List --}}
    @forelse($koleksi as $buku)

        <div class="bg-white border border-gray-100 rounded-2xl mb-3 flex items-center overflow-hidden transition-all duration-200 hover:shadow-lg hover:border-gray-200 hover:-translate-y-0.5">

            {{-- Cover --}}
            <div class="p-4 shrink-0 w-40">
                <div class="rounded-xl overflow-hidden aspect-[2/3] bg-gray-100">
                    <img src="{{ asset('uploads/buku/' . $buku->gambar) }}"
                         alt="{{ $buku->judul }}"
                         class="w-full h-full object-cover transition-transform duration-300 hover:scale-105">
                </div>
            </div>

            {{-- Info --}}
            <div class="flex-1 px-3 py-5 min-w-0">
                <span class="inline-block bg-red-50 text-[#8B0000] border border-red-200 text-[0.7rem] font-semibold px-2.5 py-0.5 rounded-full uppercase tracking-wide mb-2">
                    {{ $buku->kategori->nama_kategori ?? 'Tanpa Kategori' }}
                </span>
                <div class="font-bold text-gray-900 text-base leading-snug mb-1 truncate">{{ $buku->judul }}</div>
                <div class="text-sm text-gray-400 mb-2">Penulis: <span class="text-gray-600 font-medium">{{ $buku->penulis }}</span></div>
                @if($buku->stock > 0)
                    <span class="inline-flex items-center gap-1 bg-green-50 text-green-700 border border-green-200 text-xs font-semibold px-2.5 py-0.5 rounded-full">
                        ✓ Stok tersedia ({{ $buku->stock }})
                    </span>
                @else
                    <span class="inline-flex items-center gap-1 bg-red-50 text-red-600 border border-red-200 text-xs font-semibold px-2.5 py-0.5 rounded-full">
                        ✕ Stok habis
                    </span>
                @endif
            </div>

            {{-- Aksi --}}
            <div class="flex flex-col items-center gap-2 px-5 py-5 shrink-0">
                <a href="{{ route('pengguna.buku.detail', $buku->id) }}"
                   class="bg-[#8B0000] hover:bg-[#7c0707] text-white text-xs font-semibold px-5 py-2 rounded-lg transition-colors duration-200 no-underline text-center w-24 flex items-center justify-center">
                    Detail
                </a>
                <form action="{{ route('koleksi.destroy', $buku->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            onclick="return confirm('Hapus buku ini dari koleksi?')"
                            class="w-24 flex items-center justify-center border border-gray-200 hover:border-red-400 hover:text-red-500 hover:bg-red-50 text-gray-400 text-xs font-semibold px-5 py-2 rounded-lg transition-all duration-200 cursor-pointer bg-white">
                        Hapus
                    </button>
                </form>
            </div>

        </div>

    @empty

        <div class="text-center py-20 bg-gray-50 rounded-2xl border-2 border-dashed border-gray-200">
            <h5 class="font-bold text-gray-700 mb-1">Koleksi masih kosong</h5>
            <p class="text-gray-400 text-sm mb-5">Tambahkan buku favoritmu agar mudah ditemukan.</p>
            <a href="{{ route('pengguna.buku.index') }}"
               class="bg-[#8B0000] hover:bg-[#7c0707] text-white text-sm font-semibold px-5 py-2.5 rounded-lg transition-colors duration-200 no-underline inline-block">
                Jelajahi Buku
            </a>
        </div>

    @endforelse

</div>

@endsection