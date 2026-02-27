@extends('layout.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        @include('layout.sidebar')
        
        <!-- Main Content Area -->
        <div class="col p-4" style="background: #f8f9fa; min-height: 100vh;">

            <!-- Header -->
            <div style="margin-bottom: 2rem;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <div style="width: 4px; height: 40px; background: #8B0000; border-radius: 2px;"></div>
                    <div>
                        <h2 style="font-size: 1.75rem; font-weight: 800; color: #141516; margin: 0; letter-spacing: -0.5px;">Kategori</h2>
                        <p style="color: #666; font-size: 0.95rem; margin: 0;">Total: {{ $kategoris->count() }} Kategori</p>
                    </div>
                </div>
            </div>

            {{-- Success Alert --}}
            @if (session('success'))
                <div id="success-alert" style="background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%); color: #155724; padding: 15px 20px; border-radius: 10px; margin-bottom: 25px; display: flex; align-items: center; gap: 12px; border-left: 4px solid #28a745; animation: slideDown 0.4s ease; font-weight: 500;">
                    <span style="font-size: 1.5rem; background: #28a745; color: white; width: 30px; height: 30px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">✓</span>
                    {{ session('success') }}
                </div>
            @endif

            {{-- Button Tambah & Search --}}
            <div style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center; gap: 1rem;">
                <a href="{{ route('kategori.create') }}"
                    style="background: #8B0000; color: white; padding: 12px 24px; border-radius: 8px; text-decoration: none; font-weight: 600; white-space: nowrap; transition: all 0.3s;"
                    onmouseover="this.style.background='#6B0000'" onmouseout="this.style.background='#8B0000'">
                    Tambah Kategori
                </a>

                <div style="flex: 1; max-width: 400px;">
                    <form action="{{ route('kategori.index') }}" method="GET">
                        <div style="position: relative;">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kategori..."
                                style="width: 100%; padding: 12px 80px 12px 20px; border: 2px solid #e9ecef; border-radius: 10px; font-size: 0.95rem; outline: none;"
                                onfocus="this.style.borderColor='#8B0000'" onblur="this.style.borderColor='#e9ecef'">
                            <button type="submit"
                                style="position: absolute; right: 8px; top: 50%; transform: translateY(-50%); background: #8B0000; color: white; border: none; padding: 8px 16px; border-radius: 6px; cursor: pointer; font-weight: 600;">
                                Cari
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Search Result Info --}}
            @if(request('search'))
                <div style="margin-bottom: 1rem; display: flex; align-items: center; gap: 10px;">
                    <span style="color: #666; font-size: 0.9rem;">
                        Hasil pencarian: <strong>"{{ request('search') }}"</strong> ({{ $kategoris->count() }} kategori)
                    </span>
                    <a href="{{ route('kategori.index') }}" style="color: #8B0000; text-decoration: none; font-size: 0.9rem; font-weight: 600;">
                        ✕ Hapus filter
                    </a>
                </div>
            @endif

            {{-- Table Card --}}
            <div style="background: white; border-radius: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.06);">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead style="background: #f8f9fa; border-bottom: 2px solid #e9ecef;">
                        <tr>
                            <th style="padding: 1rem 1.5rem; text-align: left; font-size: 0.75rem; font-weight: 700; color: #6c757d; text-transform: uppercase; border-radius: 16px 0 0 0;">#</th>
                            <th style="padding: 1rem 1.5rem; text-align: left; font-size: 0.75rem; font-weight: 700; color: #6c757d; text-transform: uppercase;">Nama Kategori</th>
                            <th style="padding: 1rem 1.5rem; text-align: center; font-size: 0.75rem; font-weight: 700; color: #6c757d; text-transform: uppercase; border-radius: 0 16px 0 0;">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @if ($kategoris->count() > 0)
                            @foreach ($kategoris as $index => $kategori)
                            <tr style="border-bottom: 1px solid #f0f0f0;" onmouseover="this.style.background='#f8f9fa'" onmouseout="this.style.background='white'">
                                <td style="padding: 1rem 1.5rem; color: #6c757d; font-size: 0.9rem;">{{ $index + 1 }}</td>
                                <td style="padding: 1rem 1.5rem;">
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <span style="font-size: 1.3rem;">🏷️</span>
                                        <span style="font-weight: 600; color: #2c3e50;">{{ $kategori->nama_kategori }}</span>
                                    </div>
                                </td>
                                <td style="padding: 1rem 1.5rem; text-align: center;">
                                    <div style="position: relative; display: inline-block;">
                                        <button onclick="toggleDropdown({{ $kategori->id }})"
                                            style="background: #f8f9fa; border: 0px solid #e9ecef; cursor: pointer; padding: 6px 12px; border-radius: 6px; color: #b80303; font-size: 1.1rem; line-height: 1;">
                                            ⋮
                                        </button>
                                        <div id="dropdown-{{ $kategori->id }}"
                                            style="display: none; position: fixed; background: white; border-radius: 8px; box-shadow: 0 4px 16px rgba(0,0,0,0.15); min-width: 140px; z-index: 9999; overflow: hidden;">
                                            <a href="{{ route('kategori.edit', $kategori->id) }}"
                                                style="display: flex; align-items: center; gap: 8px; padding: 10px 16px; color: #2c3e50; text-decoration: none; font-size: 0.875rem;"
                                                onmouseover="this.style.background='#f8f9fa'" onmouseout="this.style.background='white'">
                                                ✏️ Edit
                                            </a>
                                            <form action="{{ route('kategori.destroy', $kategori->id) }}" method="POST"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    style="display: flex; align-items: center; gap: 8px; width: 100%; padding: 10px 16px; color: #dc3545; background: none; border: none; cursor: pointer; font-size: 0.875rem; font-family: inherit;"
                                                    onmouseover="this.style.background='#fff5f5'" onmouseout="this.style.background='white'">
                                                    🗑️ Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="3" style="padding: 60px 20px; text-align: center;">
                                    <div style="font-size: 4rem;">{{ request('search') ? '🔍' : '📭' }}</div>
                                    <p style="font-size: 1.1rem; color: #6c757d; font-weight: 500; margin-top: 20px;">
                                        {{ request('search') ? 'Tidak ada kategori yang ditemukan' : 'Belum ada kategori' }}
                                    </p>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<style>
    @keyframes slideDown { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const alert = document.getElementById('success-alert');
        if (alert) {
            setTimeout(function() {
                alert.style.opacity = '0';
                alert.style.transform = 'translateY(-10px)';
                setTimeout(function() { alert.style.display = 'none'; }, 400);
            }, 3000);
        }
    });

    function toggleDropdown(id) {
        // Tutup semua dropdown lain
        document.querySelectorAll('[id^="dropdown-"]').forEach(d => {
            if (d.id !== 'dropdown-' + id) d.style.display = 'none';
        });

        const dropdown = document.getElementById('dropdown-' + id);
        const btn = dropdown.previousElementSibling;
        const rect = btn.getBoundingClientRect();

        if (dropdown.style.display === 'none' || dropdown.style.display === '') {
            dropdown.style.display = 'block';
            // Posisi dropdown ikut posisi tombol
            dropdown.style.top = (rect.bottom + window.scrollY + 4) + 'px';
            dropdown.style.left = (rect.right + window.scrollX - 140) + 'px';
        } else {
            dropdown.style.display = 'none';
        }
    }

    document.addEventListener('click', function(e) {
        if (!e.target.closest('[id^="dropdown-"]') && !e.target.closest('button[onclick]')) {
            document.querySelectorAll('[id^="dropdown-"]').forEach(d => d.style.display = 'none');
        }
    });
</script>
@endsection