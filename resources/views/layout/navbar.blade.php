{{-- resources/views/layout/navbar.blade.php --}}

<nav style="
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 29px;
    height: 70px;
    background: #fff;
    border-bottom: 2px solid #eee;
    position: sticky;
    top: 0;
    z-index: 100;
">

    {{-- LEFT: Hamburger + Title --}}
    <div style="display:flex; align-items:center; gap:12px;">
        <button onclick="toggleSidebar()" style="background:none; border:none; cursor:pointer; padding:4px; color:#555; display:flex; align-items:center;">
            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
        <span style="font-size:16px; font-weight:700; color:#111;">Welcome</span>
    </div>

    <!-- {{-- CENTER: Search --}}
    <div style="display:flex; align-items:center; gap:8px; background:#f5f5f5; border-radius:999px; padding:8px 16px; width:260px;">
        <svg width="15" height="15" fill="none" stroke="#aaa" stroke-width="2" viewBox="0 0 24 24">
            <circle cx="11" cy="11" r="6"/><path stroke-linecap="round" d="M21 21l-4-4"/>
        </svg>
        <input type="text" placeholder="Search here" style="
            background:none; border:none; outline:none;
            font-size:13px; color:#555; width:100%;
        "/>
    </div> -->

    {{-- RIGHT: User dropdown --}}
    <div style="position:relative;">
        <button onclick="toggleDropdown()" style="
            display:flex; align-items:center; gap:8px;
            background:none; border:none; cursor:pointer;
            padding:6px 10px; border-radius:10px;
            transition: background .15s;
        " onmouseover="this.style.background='#f5f5f5'" onmouseout="this.style.background='none'">

            {{-- Initial avatar --}}
            <!-- <div style="
                width:32px; height:32px; border-radius:50%;
                background:#8B0000; color:#fff;
                display:flex; align-items:center; justify-content:center;
                font-size:13px; font-weight:700; flex-shrink:0;
            ">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div> -->

            {{-- Name & role --}}
            <div style="text-align:left;">
                <div style="font-size:13px; font-weight:700; color:#111; line-height:1.3;">{{ Auth::user()->name }}</div>
                <div style="font-size:11px; color:#aaa; line-height:1.3;">{{ Auth::user()->role ?? 'Admin' }}</div>
            </div>

            {{-- Chevron --}}
            <svg id="nav-chevron" width="14" height="14" fill="none" stroke="#aaa" stroke-width="2" viewBox="0 0 24 24" style="transition:transform .2s;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>

        {{-- Dropdown --}}
        <div id="nav-dropdown" style="
            display:none;
            position:absolute; right:0; top:calc(100% + 6px);
            width:200px; background:#fff;
            border:1px solid #eee; border-radius:12px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.1);
            overflow:hidden; z-index:200;
        ">
            {{-- Header --}}
            <div style="padding:12px 16px; border-bottom:1px solid #f0f0f0;">
                <div style="font-size:13px; font-weight:600; color:#111;">{{ Auth::user()->name }}</div>
                <div style="font-size:11px; color:#aaa; margin-top:1px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">{{ Auth::user()->email }}</div>
            </div>

            {{-- Edit Profile --}}
          <a href="{{ route('profile.edit') }}" style="display:flex; align-items:center; gap:10px; padding:10px 16px; font-size:13px; color:#333; text-decoration:none;"
               onmouseover="this.style.background='#f9f9f9'" onmouseout="this.style.background='none'">
                <svg width="15" height="15" fill="none" stroke="#888" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 1 1-8 0 4 4 0 0 1 8 0zM12 14a7 7 0 0 0-7 7h14a7 7 0 0 0-7-7z"/>
                </svg>
                Edit Profile
            </a>

            <div style="border-top:1px solid #f0f0f0;">
                {{-- Logout --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" style="
                        display:flex; align-items:center; gap:10px;
                        width:100%; padding:10px 16px;
                        background:none; border:none; cursor:pointer;
                        font-size:13px; color:#e03131; text-align:left;
                    " onmouseover="this.style.background='#fff5f5'" onmouseout="this.style.background='none'">
                        <svg width="15" height="15" fill="none" stroke="#e03131" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3V7a3 3 0 0 1 3-3h4a3 3 0 0 1 3 3v1"/>
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>

<script>
    function toggleDropdown() {
        const dd = document.getElementById('nav-dropdown');
        const chevron = document.getElementById('nav-chevron');
        const isOpen = dd.style.display === 'block';
        dd.style.display = isOpen ? 'none' : 'block';
        chevron.style.transform = isOpen ? 'rotate(0deg)' : 'rotate(180deg)';
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        const dd = document.getElementById('nav-dropdown');
        if (dd && !e.target.closest('[onclick="toggleDropdown()"]') && !dd.contains(e.target)) {
            dd.style.display = 'none';
            document.getElementById('nav-chevron').style.transform = 'rotate(0deg)';
        }
    });
</script>