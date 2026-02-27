<nav style="background: white; box-shadow: 0 2px 8px rgba(0,0,0,0.08); padding: 0 2.5rem; display: flex; align-items: center; justify-content: space-between; height: 64px; position: sticky; top: 0; left: 0; right: 0; z-index: 999; width: 100%; box-sizing: border-box;">
    {{-- Kiri: Logo --}}
    <div style="font-size: 1.5rem; font-weight: 800; color: #8B0000; letter-spacing: -0.5px;">
        Pustaloka
    </div>

    {{-- Tengah: Menu --}}
    <ul style="list-style: none; margin: 0; padding: 0; display: flex; align-items: center; gap: 2.5rem;">
        <li><a href="#" style="text-decoration: none; color: #333; font-weight: 500; font-size: 0.95rem; transition: color 0.2s;" onmouseover="this.style.color='#8B0000'" onmouseout="this.style.color='#333'">Kategori</a></li>
        <li><a href="#" style="text-decoration: none; color: #333; font-weight: 500; font-size: 0.95rem; transition: color 0.2s;" onmouseover="this.style.color='#8B0000'" onmouseout="this.style.color='#333'">Koleksi</a></li>
        <li><a href="#" style="text-decoration: none; color: #333; font-weight: 500; font-size: 0.95rem; transition: color 0.2s;" onmouseover="this.style.color='#8B0000'" onmouseout="this.style.color='#333'">Peminjaman</a></li>
    </ul>

    {{-- Kanan: Profile --}}
    <div style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
        <div style="width: 38px; height: 38px; border-radius: 50%; background: #fce8e8; display: flex; align-items: center; justify-content: center;">
            <svg xmlns="http://www.w3.org/2000/svg" style="width: 20px; height: 20px; color: #8B0000;" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/>
            </svg>
        </div>
        <span style="font-size: 0.9rem; font-weight: 500; color: #333;">Profile</span>
    </div>

</nav>