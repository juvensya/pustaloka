@extends('layout.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        {{-- Sidebar --}}
        @include('layout.sidebar')

        {{-- Main Content --}}
        <div class="col p-0" style="background: #f8f9fa; min-height: 100vh;">

            

            {{-- Content area --}}
            <div style="padding:1.5rem;">

                <!-- Header -->
                <div style="margin-bottom: 1rem;">
                    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 0.5rem;">
                        <div style="width: 4px; height: 40px; background: #8B0000; border-radius: 2px;"></div>
                        <div>
                            <h2 style="font-size: 1.75rem; font-weight: 800; color: #141516; margin: 0; letter-spacing: -0.5px;">Buku</h2>
                            <p style="color: #666; font-size: 0.95rem; margin: 0;">Total: {{ $bukus->total() }} Buku</p>
                        </div>
                    </div>
                </div>

                {{-- Success Alert --}}
                @if(session('success'))
                    <div id="success-alert" style="background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%); color: #155724; padding: 15px 20px; border-radius: 10px; margin-bottom: 25px; display: flex; align-items: center; gap: 12px; border-left: 4px solid #28a745; animation: slideDown 0.4s ease; font-weight: 500;">
                        <span style="font-size: 1.5rem; background: #28a745; color: white; width: 30px; height: 30px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">✓</span>
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Button Tambah Buku & Search Bar --}}
                <div style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center; gap: 1rem;">
                    <a href="{{ route('buku.create') }}" style="background: #8B0000; color: white; padding: 12px 24px; border-radius: 8px; text-decoration: none; font-weight: 600; transition: all 0.3s;"
                        onmouseover="this.style.background='#6B0000'" onmouseout="this.style.background='#8B0000'">
                        Tambah Buku
                    </a>

                    <div style="flex: 1; max-width: 500px;">
                        <form action="{{ route('buku.index') }}" method="GET">
                            <div style="position: relative;">
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari buku"
                                    style="width: 100%; padding: 12px 80px 12px 20px; border: 2px solid #e9ecef; border-radius: 10px; font-size: 0.95rem; outline: none;"
                                    onfocus="this.style.borderColor='#8B0000'" onblur="this.style.borderColor='#e9ecef'">
                                <button type="submit" style="position: absolute; right: 8px; top: 50%; transform: translateY(-50%); background: #8B0000; color: white; border: none; padding: 8px 16px; border-radius: 6px; cursor: pointer; font-weight: 600;">
                                    Cari
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Search Result Info --}}
                @if(request('search'))
                    <div style="margin-bottom: 1.5rem; display: flex; align-items: center; gap: 10px;">
                        <span style="color: #666; font-size: 0.9rem;">
                            Hasil pencarian: <strong>"{{ request('search') }}"</strong> ({{ $bukus->total() }} buku)
                        </span>
                        <a href="{{ route('buku.index') }}" style="color: #8B0000; text-decoration: none; font-size: 0.9rem; font-weight: 600;">
                            ✕ Hapus filter
                        </a>
                    </div>
                @endif

                {{-- Table Card --}}
                <div style="background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.06);">
                    <div style="overflow-x: auto;">
                        <table style="width: 100%; border-collapse: collapse;">
                            <thead style="background: #f8f9fa; border-bottom: 2px solid #e9ecef;">
                                <tr>
                                    <th style="padding: 1rem 1.5rem; text-align: left; font-size: 0.75rem; font-weight: 700; color: #6c757d; text-transform: uppercase;">Cover</th>
                                    <th style="padding: 1rem 1.5rem; text-align: left; font-size: 0.75rem; font-weight: 700; color: #6c757d; text-transform: uppercase;">Judul Buku</th>
                                    <th style="padding: 1rem 1.5rem; text-align: left; font-size: 0.75rem; font-weight: 700; color: #6c757d; text-transform: uppercase;">Penulis</th>
                                    <th style="padding: 1rem 1.5rem; text-align: left; font-size: 0.75rem; font-weight: 700; color: #6c757d; text-transform: uppercase;">Penerbit</th>
                                    <th style="padding: 1rem 1.5rem; text-align: left; font-size: 0.75rem; font-weight: 700; color: #6c757d; text-transform: uppercase;">Tahun</th>
                                    <th style="padding: 1rem 1.5rem; text-align: left; font-size: 0.75rem; font-weight: 700; color: #6c757d; text-transform: uppercase;">Kategori</th>
                                    <th style="padding: 1rem 1.5rem; text-align: center; font-size: 0.75rem; font-weight: 700; color: #6c757d; text-transform: uppercase;">Stock</th>
                                    <th style="padding: 1rem 1.5rem; text-align: center; font-size: 0.75rem; font-weight: 700; color: #6c757d; text-transform: uppercase;">Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($bukus as $buku)
                                <tr style="border-bottom: 1px solid #f0f0f0;" onmouseover="this.style.background='#f8f9fa'" onmouseout="this.style.background='white'">
                                    <td style="padding: 1rem 1.5rem;">
                                        @if ($buku->gambar)
                                            <img src="{{ asset('uploads/buku/' . $buku->gambar) }}" alt="{{ $buku->judul }}" style="width: 64px; height: 80px; object-fit: cover; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                                        @else
                                            <div style="width: 64px; height: 80px; background: #e9ecef; border-radius: 8px; display: flex; align-items: center; justify-content: center;">📖</div>
                                        @endif
                                    </td>
                                    <td style="padding: 1rem 1.5rem; font-weight: 600; color: #2c3e50;">{{ $buku->judul }}</td>
                                    <td style="padding: 1rem 1.5rem; color: #666;">{{ $buku->penulis }}</td>
                                    <td style="padding: 1rem 1.5rem; color: #666;">{{ $buku->penerbit }}</td>
                                    <td style="padding: 1rem 1.5rem; color: #666;">{{ $buku->tahun_terbit }}</td>
                                    <td style="padding: 1rem 1.5rem;">
                                        <span style="background: #ffe5e5; color: #8B0000; padding: 4px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 600;">
                                            {{ $buku->kategori->nama_kategori ?? 'Tidak ada' }}
                                        </span>
                                    </td>
                                    <td style="padding: 1rem 1.5rem; text-align: center;">
                                        <span style="background: {{ $buku->stock > 0 ? '#d4edda' : '#f8d7da' }}; color: {{ $buku->stock > 0 ? '#155724' : '#721c24' }}; padding: 6px 14px; border-radius: 20px; font-size: 0.85rem; font-weight: 700;">
                                            {{ $buku->stock ?? 0 }}
                                        </span>
                                    </td>
                                    <td style="padding: 1rem 1.5rem; text-align: center;">
                                        <div class="dropdown" style="position: relative; display: inline-block;">
                                            <button onclick="toggleDropdown({{ $buku->id }})" style="background: none; border: none; cursor: pointer; font-size: 1.5rem; color: #6c757d; padding: 4px 8px;">⋮</button>
                                            <div id="dropdown-{{ $buku->id }}" class="dropdown-menu" style="display: none; position: absolute; right: 0; background: white; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); min-width: 140px; z-index: 100;">
                                                <a href="{{ route('buku.edit', $buku->id) }}" style="display: block; padding: 10px 16px; color: #2c3e50; text-decoration: none; font-size: 0.875rem;" onmouseover="this.style.background='#f8f9fa'" onmouseout="this.style.background='white'">
                                                    Edit
                                                </a>
                                                <form action="{{ route('buku.destroy', $buku->id) }}" method="POST" onsubmit="return confirm('Hapus buku ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" style="width: 100%; text-align: left; padding: 10px 16px; color: #dc3545; background: none; border: none; cursor: pointer; font-size: 0.875rem;" onmouseover="this.style.background='#fff5f5'" onmouseout="this.style.background='white'">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" style="padding: 60px 20px; text-align: center;">
                                        <div style="font-size: 4rem;">{{ request('search') ? '🔍' : '📭' }}</div>
                                        <p style="font-size: 1.1rem; color: #6c757d; font-weight: 500; margin-top: 20px;">
                                            {{ request('search') ? 'Tidak ada buku yang ditemukan' : 'Belum ada data buku' }}
                                        </p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    @if($bukus->hasPages())
                        <div style="padding: 1.5rem; border-top: 1px solid #f0f0f0; display: flex; justify-content: space-between; align-items: center;">
                            <div style="color: #666; font-size: 0.9rem;">
                                {{ $bukus->firstItem() }} - {{ $bukus->lastItem() }} dari {{ $bukus->total() }} buku
                            </div>
                            <div style="display: flex; gap: 8px;">
                                @if (!$bukus->onFirstPage())
                                    <a href="{{ $bukus->previousPageUrl() }}" style="padding: 8px 16px; background: #f8f9fa; color: #666; border-radius: 6px; text-decoration: none; font-weight: 600;">← Sebelumnya</a>
                                @endif
                                @foreach(range(1, $bukus->lastPage()) as $page)
                                    <a href="{{ $bukus->url($page) }}" style="padding: 8px 14px; background: {{ $page == $bukus->currentPage() ? '#8B0000' : '#f8f9fa' }}; color: {{ $page == $bukus->currentPage() ? 'white' : '#666' }}; border-radius: 6px; text-decoration: none; font-weight: 600;">
                                        {{ $page }}
                                    </a>
                                @endforeach
                                @if ($bukus->hasMorePages())
                                    <a href="{{ $bukus->nextPageUrl() }}" style="padding: 8px 16px; background: #f8f9fa; color: #666; border-radius: 6px; text-decoration: none; font-weight: 600;">Selanjutnya →</a>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>

            </div>{{-- end padding --}}
        </div>{{-- end col --}}
    </div>
</div>

<style>
    @keyframes slideDown { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const alert = document.getElementById('success-alert');
        if (alert) setTimeout(() => { alert.style.display = 'none'; }, 7000);
    });

    function toggleDropdown(id) {
        document.querySelectorAll('.dropdown-menu').forEach(d => d.style.display = 'none');
        const dropdown = document.getElementById('dropdown-' + id);
        dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
    }

    document.addEventListener('click', function(e) {
        if (!e.target.closest('.dropdown')) {
            document.querySelectorAll('.dropdown-menu').forEach(d => d.style.display = 'none');
        }
    });
</script>
@endsection