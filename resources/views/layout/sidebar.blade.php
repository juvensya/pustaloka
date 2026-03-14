<!-- Sidebar Component -->
<div style="width:280px;min-height:100vh;height:100vh;position:sticky;top:0;background:#7B0000;display:flex;flex-direction:column;box-shadow:4px 0 20px rgba(0,0,0,0.3);flex-shrink:0;">

    <!-- Header -->
    <div style="padding:1.75rem 1.25rem;border-bottom:2px solid #6B0000;">
        <a href="{{ route('admin.index') }}" style="display:flex;align-items:center;justify-content:center;gap:12px;text-decoration:none;color:white;" onmouseover="this.style.opacity='0.85'" onmouseout="this.style.opacity='1'">
            <i class="bi bi-book-fill" style="font-size:2rem;"></i>
            <div style="text-align:left;">
                <div style="font-size:1.4rem;font-weight:700;letter-spacing:0.5px;">Pustaloka</div>
                <div style="font-size:0.7rem;color:rgba(255,255,255,0.6);text-transform:uppercase;letter-spacing:1px;font-weight:500;">Admin Panel</div>
            </div>
        </a>
    </div>

    <!-- Menu -->
    <div style="flex:1;padding:1.25rem 0.75rem;overflow-y:auto;">

        <!-- Dashboard -->
        <div style="margin-bottom:6px;">
            <a href="{{ route('admin.index') }}"
               style="display:flex;align-items:center;padding:0.85rem 1rem;color:rgba(255,255,255,0.9);text-decoration:none;border-radius:12px;transition:all 0.25s;font-weight:600;"
               onmouseover="this.style.background='#6B0000';this.style.paddingLeft='1.35rem'" onmouseout="this.style.background='transparent';this.style.paddingLeft='1rem'">
                <i class="bi bi-speedometer2" style="font-size:1.2rem;width:32px;"></i>
                <span>Dashboard</span>
            </a>
        </div>

       
        <!-- Kelola Akun Dropdown -->
<div style="margin-bottom:6px;">
    <button onclick="toggleMenu('menu-akun', 'arrow-akun')"
            style="width:100%;display:flex;align-items:center;justify-content:space-between;padding:0.85rem 1rem;color:rgba(255,255,255,0.9);background:transparent;border:none;border-radius:12px;cursor:pointer;transition:all 0.25s;font-weight:600;font-family:inherit;"
            onmouseover="this.style.background='#6B0000';this.style.paddingLeft='1.35rem'" onmouseout="this.style.background='transparent';this.style.paddingLeft='1rem'">
        <div style="display:flex;align-items:center;">
            <i class="bi bi-people-fill" style="font-size:1.2rem;width:32px;"></i>
            <span>Kelola Akun</span>
        </div>
        <i id="arrow-akun" class="bi bi-chevron-right" style="font-size:0.8rem;transition:transform 0.3s;"></i>
    </button>
    <div id="menu-akun" style="display:none;margin-left:2rem;margin-top:4px;padding-left:1rem;border-left:2px solid #6B0000;">

        {{-- Hanya admin yang bisa lihat Data Petugas --}}
        @if(auth()->user()->role === 'admin')
        <a href="{{ route('petugas.index') }}"
           style="display:flex;align-items:center;padding:0.6rem 1rem;color:rgba(255,255,255,0.8);text-decoration:none;border-radius:8px;font-size:0.9rem;transition:all 0.2s;"
           onmouseover="this.style.background='#6B0000';this.style.color='white';this.style.paddingLeft='1.35rem'" onmouseout="this.style.background='transparent';this.style.color='rgba(255,255,255,0.8)';this.style.paddingLeft='1rem'">
            Data Petugas
        </a>
        @endif

        <a href="{{ route('admin.users.index') }}"
           style="display:flex;align-items:center;padding:0.6rem 1rem;color:rgba(255,255,255,0.8);text-decoration:none;border-radius:8px;font-size:0.9rem;transition:all 0.2s;"
           onmouseover="this.style.background='#6B0000';this.style.color='white';this.style.paddingLeft='1.35rem'" onmouseout="this.style.background='transparent';this.style.color='rgba(255,255,255,0.8)';this.style.paddingLeft='1rem'">
            Data Pengguna
        </a>
    </div>
</div>
        <!-- Kelola Buku Dropdown -->
        <div style="margin-bottom:6px;">
            <button onclick="toggleMenu('menu-buku', 'arrow-buku')"
                    style="width:100%;display:flex;align-items:center;justify-content:space-between;padding:0.85rem 1rem;color:rgba(255,255,255,0.9);background:transparent;border:none;border-radius:12px;cursor:pointer;transition:all 0.25s;font-weight:600;font-family:inherit;"
                    onmouseover="this.style.background='#6B0000';this.style.paddingLeft='1.35rem'" onmouseout="this.style.background='transparent';this.style.paddingLeft='1rem'">
                <div style="display:flex;align-items:center;">
                    <i class="bi bi-book" style="font-size:1.2rem;width:32px;"></i>
                    <span>Kelola Buku</span>
                </div>
                <i id="arrow-buku" class="bi bi-chevron-right" style="font-size:0.8rem;transition:transform 0.3s;"></i>
            </button>
            <div id="menu-buku" style="display:none;margin-left:2rem;margin-top:4px;padding-left:1rem;border-left:2px solid #6B0000;">
                <a href="{{ route('buku.index') }}"
                   style="display:flex;align-items:center;padding:0.6rem 1rem;color:rgba(255,255,255,0.8);text-decoration:none;border-radius:8px;font-size:0.9rem;transition:all 0.2s;"
                   onmouseover="this.style.background='#6B0000';this.style.color='white';this.style.paddingLeft='1.35rem'" onmouseout="this.style.background='transparent';this.style.color='rgba(255,255,255,0.8)';this.style.paddingLeft='1rem'">
                    Daftar Buku
                </a>
                <a href="{{ route('kategori.index') }}"
                   style="display:flex;align-items:center;padding:0.6rem 1rem;color:rgba(255,255,255,0.8);text-decoration:none;border-radius:8px;font-size:0.9rem;transition:all 0.2s;"
                   onmouseover="this.style.background='#6B0000';this.style.color='white';this.style.paddingLeft='1.35rem'" onmouseout="this.style.background='transparent';this.style.color='rgba(255,255,255,0.8)';this.style.paddingLeft='1rem'">
                    Kategori Buku
                </a>
                <a href="{{ route('admin.ulasan') }}"
                   style="display:flex;align-items:center;padding:0.6rem 1rem;color:rgba(255,255,255,0.8);text-decoration:none;border-radius:8px;font-size:0.9rem;transition:all 0.2s;"
                   onmouseover="this.style.background='#6B0000';this.style.color='white';this.style.paddingLeft='1.35rem'" onmouseout="this.style.background='transparent';this.style.color='rgba(255,255,255,0.8)';this.style.paddingLeft='1rem'">
                    Ulasan Buku
                </a>
            </div>
        </div>

        <!-- Peminjaman Dropdown -->
        <div style="margin-bottom:6px;">
            <button onclick="toggleMenu('menu-pinjam', 'arrow-pinjam')"
                    style="width:100%;display:flex;align-items:center;justify-content:space-between;padding:0.85rem 1rem;color:rgba(255,255,255,0.9);background:transparent;border:none;border-radius:12px;cursor:pointer;transition:all 0.25s;font-weight:600;font-family:inherit;"
                    onmouseover="this.style.background='#6B0000';this.style.paddingLeft='1.35rem'" onmouseout="this.style.background='transparent';this.style.paddingLeft='1rem'">
                <div style="display:flex;align-items:center;">
                    <i class="bi bi-arrow-left-right" style="font-size:1.2rem;width:32px;"></i>
                    <span>Peminjaman</span>
                </div>
                <i id="arrow-pinjam" class="bi bi-chevron-right" style="font-size:0.8rem;transition:transform 0.3s;"></i>
            </button>
            <div id="menu-pinjam" style="display:none;margin-left:2rem;margin-top:4px;padding-left:1rem;border-left:2px solid #6B0000;">
                <a href="{{ route('admin.peminjaman.index') }}"
                   style="display:flex;align-items:center;padding:0.6rem 1rem;color:rgba(255,255,255,0.8);text-decoration:none;border-radius:8px;font-size:0.9rem;transition:all 0.2s;"
                   onmouseover="this.style.background='#6B0000';this.style.color='white';this.style.paddingLeft='1.35rem'" onmouseout="this.style.background='transparent';this.style.color='rgba(255,255,255,0.8)';this.style.paddingLeft='1rem'">
                    Daftar Peminjaman
                </a>
                <a href="{{ route('admin.peminjaman.pengembalian') }}"
                   style="display:flex;align-items:center;padding:0.6rem 1rem;color:rgba(255,255,255,0.8);text-decoration:none;border-radius:8px;font-size:0.9rem;transition:all 0.2s;"
                   onmouseover="this.style.background='#6B0000';this.style.color='white';this.style.paddingLeft='1.35rem'" onmouseout="this.style.background='transparent';this.style.color='rgba(255,255,255,0.8)';this.style.paddingLeft='1rem'">
                    Pengembalian
                </a>
            </div>
        </div>

        <!-- Laporan -->
        <div style="margin-bottom:6px;">
            <a href="#"
               style="display:flex;align-items:center;padding:0.85rem 1rem;color:rgba(255,255,255,0.9);text-decoration:none;border-radius:12px;transition:all 0.25s;font-weight:600;"
               onmouseover="this.style.background='#6B0000';this.style.paddingLeft='1.35rem'" onmouseout="this.style.background='transparent';this.style.paddingLeft='1rem'">
                <i class="bi bi-file-earmark-bar-graph" style="font-size:1.2rem;width:32px;"></i>
                <span>Laporan</span>
            </a>
        </div>

    </div>

    

</div>

<script>
function toggleMenu(menuId, arrowId) {
    const menu  = document.getElementById(menuId);
    const arrow = document.getElementById(arrowId);
    const isOpen = menu.style.display === 'block';
    menu.style.display  = isOpen ? 'none' : 'block';
    arrow.style.transform = isOpen ? 'rotate(0deg)' : 'rotate(90deg)';
}
</script>