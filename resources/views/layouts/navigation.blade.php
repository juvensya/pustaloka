<nav style="background: white; box-shadow: 0 2px 8px rgba(0,0,0,0.08); padding: 0 2.5rem; display: flex; align-items: center; justify-content: space-between; height: 64px; position: sticky; top: 0; left: 0; right: 0; z-index: 999; width: 100%; box-sizing: border-box;">

    {{-- Kiri: Logo --}}
    <div style="font-size: 1.5rem; font-weight: 800; color: #8B0000; letter-spacing: -0.5px;">
        Pustaloka
    </div>

    {{-- Tengah: Menu --}}
    <ul style="list-style: none; margin: 0; padding: 0; display: flex; align-items: center; gap: 2.5rem;">
        <li>
            <a href="{{ route('pengguna.index') }}"
               style="text-decoration: none; font-weight: 500; font-size: 0.95rem; transition: color 0.2s; color: {{ request()->routeIs('pengguna.index') ? '#8B0000' : '#333' }};"
               onmouseover="this.style.color='#8B0000'" onmouseout="this.style.color='{{ request()->routeIs('pengguna.index') ? '#8B0000' : '#333' }}'">
               Buku
            </a>
        </li>
        <li>
            <a href="{{ route('ulasan.index') }}"
               style="text-decoration: none; font-weight: 500; font-size: 0.95rem; transition: color 0.2s; color: {{ request()->routeIs('ulasan.*') ? '#8B0000' : '#333' }};"
               onmouseover="this.style.color='#8B0000'" onmouseout="this.style.color='{{ request()->routeIs('ulasan.*') ? '#8B0000' : '#333' }}'">
               Ulasan
            </a>
        </li>
        <li>
            <a href="{{ route('koleksi.index') }}"
               style="text-decoration: none; font-weight: 500; font-size: 0.95rem; transition: color 0.2s; color: {{ request()->routeIs('koleksi.*') ? '#8B0000' : '#333' }};"
               onmouseover="this.style.color='#8B0000'" onmouseout="this.style.color='{{ request()->routeIs('koleksi.*') ? '#8B0000' : '#333' }}'">
               Koleksi
            </a>
        </li>
        <li>
            <a href="{{ route('pinjam.index') }}"
               style="text-decoration: none; font-weight: 500; font-size: 0.95rem; transition: color 0.2s; color: {{ request()->routeIs('pinjam.*') ? '#8B0000' : '#333' }};"
               onmouseover="this.style.color='#8B0000'" onmouseout="this.style.color='{{ request()->routeIs('pinjam.*') ? '#8B0000' : '#333' }}'">
               Peminjaman
            </a>
        </li>
    </ul>

    {{-- Kanan: Profile + Logout --}}
    <div style="display: flex; align-items: center; gap: 10px;">

        <a href="#" style="display:flex;align-items:center;gap:8px;text-decoration:none;">
            <div style="width: 38px; height: 38px; border-radius: 50%; background: #fce8e8; display: flex; align-items: center; justify-content: center;">
                <svg xmlns="http://www.w3.org/2000/svg" style="width: 20px; height: 20px; color: #8B0000;" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/>
                </svg>
            </div>
            <span style="font-size: 0.9rem; font-weight: 600; color: #333;">{{ auth()->user()->name }}</span>
        </a>

        <form action="{{ route('logout') }}" method="POST" style="margin:0;">
            @csrf
            <button type="submit"
                style="background:none;border:1.5px solid #e9e9eb;border-radius:8px;padding:0.4rem 0.85rem;font-size:0.82rem;font-weight:600;color:#888;cursor:pointer;font-family:inherit;display:flex;align-items:center;gap:5px;"
                onmouseover="this.style.borderColor='#8B0000';this.style.color='#8B0000'"
                onmouseout="this.style.borderColor='#e9e9eb';this.style.color='#888'">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                Logout
            </button>
        </form>

    </div>

</nav>