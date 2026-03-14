@extends('layout.app')

@section('content')

<div class="container-fluid">
    <div class="row">
        @include('layout.sidebar')

        <div class="col p-4" style="background:#f8f9fa;min-height:100vh;">

            <!-- Header -->
            <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem;margin-bottom:1.5rem;">
                <div style="display:flex;align-items:center;gap:12px;">
                    <div style="width:4px;height:40px;background:#8B0000;border-radius:2px;"></div>
                    <div>
                        <h2 style="font-size:1.75rem;font-weight:800;color:#141516;margin:0;letter-spacing:-0.5px;">Data Pengguna</h2>
                        <p style="color:#666;font-size:0.875rem;margin:0;">Total <strong>{{ $users->total() }}</strong> pengguna terdaftar</p>
                    </div>
                </div>
                <form action="{{ route('admin.users.index') }}" method="GET">
                    <div style="position:relative;">
                        <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari nama atau email..."
                            style="padding:10px 44px 10px 16px;border:2px solid #e9ecef;border-radius:10px;font-size:0.875rem;outline:none;width:270px;"
                            onfocus="this.style.borderColor='#8B0000'" onblur="this.style.borderColor='#e9ecef'">
                        <button type="submit" style="position:absolute;right:10px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:#8B0000;display:flex;">
                            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        </button>
                    </div>
                </form>
            </div>

            @if(isset($search) && $search)
                <div style="margin-bottom:1rem;font-size:0.85rem;color:#666;">
                    Hasil: <strong>"{{ $search }}"</strong> ({{ $users->total() }} data) —
                    <a href="{{ route('admin.users.index') }}" style="color:#8B0000;font-weight:600;text-decoration:none;">✕ Hapus filter</a>
                </div>
            @endif

            @if(session('success'))
                <div id="alert-s" style="background:#f0fdf4;color:#15803d;padding:13px 18px;border-radius:10px;margin-bottom:1rem;border:1px solid #bbf7d0;font-size:0.875rem;font-weight:500;">
                    ✓ {{ session('success') }}
                </div>
            @endif

            <!-- Table -->
            <div style="background:white;border-radius:16px;overflow:hidden;box-shadow:0 2px 12px rgba(0,0,0,0.07);border:1px solid #f0f0f0;">
                <div style="overflow-x:auto;">
                    <table style="width:100%;border-collapse:collapse;">
                        <thead>
                            <tr style="background:#f8f9fa;border-bottom:2px solid #e9ecef;">
                                <th style="padding:1.1rem 1.5rem;text-align:left;font-size:0.85rem;font-weight:700;text-transform:uppercase;letter-spacing:0.07em;color:#6c757d;">No</th>
                                <th style="padding:1.1rem 1.5rem;text-align:left;font-size:0.85rem;font-weight:700;text-transform:uppercase;letter-spacing:0.07em;color:#6c757d;">Pengguna</th>
                                <th style="padding:1.1rem 1.5rem;text-align:left;font-size:0.85rem;font-weight:700;text-transform:uppercase;letter-spacing:0.07em;color:#6c757d;">Alamat</th>
                                <th style="padding:1.1rem 1.5rem;text-align:left;font-size:0.85rem;font-weight:700;text-transform:uppercase;letter-spacing:0.07em;color:#6c757d;">Tanggal Daftar</th>
                                <th style="padding:1.1rem 1.5rem;text-align:center;font-size:0.85rem;font-weight:700;text-transform:uppercase;letter-spacing:0.07em;color:#6c757d;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $i => $user)
                            <tr style="border-bottom:1px solid #f5f5f5;background:white;"
                                onmouseover="this.style.background='#fafafa'" onmouseout="this.style.background='white'">

                                <td style="padding:1.1rem 1.5rem;color:#aaa;font-size:0.9rem;vertical-align:middle;">{{ $users->firstItem() + $i }}</td>

                                <!-- Pengguna -->
                                <td style="padding:1.1rem 1.5rem;vertical-align:middle;">
                                    <div style="display:flex;align-items:center;gap:0.65rem;">
                                        @if(!empty($user->foto))
                                            <img src="{{ asset('uploads/users/'.$user->foto) }}" style="width:38px;height:38px;border-radius:50%;object-fit:cover;border:2px solid #fde8e8;flex-shrink:0;">
                                        @else
                                            <div style="width:38px;height:38px;border-radius:50%;background:linear-gradient(135deg,#8B0000,#c0392b);display:flex;align-items:center;justify-content:center;color:white;font-size:0.9rem;font-weight:700;flex-shrink:0;">
                                                {{ strtoupper(substr($user->name,0,1)) }}
                                            </div>
                                        @endif
                                        <div>
                                            <div style="font-weight:700;color:#1a0000;font-size:1.02rem;">{{ $user->name }}</div>
                                            <div style="font-size:0.9rem;color:#9e6060;">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Alamat -->
                                <td style="padding:1.1rem 1.5rem;vertical-align:middle;max-width:220px;">
                                    <div style="font-size:0.875rem;color:#555;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;line-height:1.5;">
                                        {{ $user->alamat ?? '-' }}
                                    </div>
                                </td>

                                <!-- Tanggal Daftar -->
                                <td style="padding:1.1rem 1.5rem;font-size:0.95rem;color:#666;vertical-align:middle;white-space:nowrap;">
                                    {{ $user->created_at->format('d F Y') }}
                                </td>

                                <!-- Aksi -->
                                <td style="padding:1.1rem 1.5rem;text-align:center;vertical-align:middle;">
                                    <button onclick="toggleDD(event,'dd{{$user->id}}')"
                                        style="background:none;border:none;cursor:pointer;color:#888;padding:4px 8px;border-radius:6px;font-size:1.1rem;line-height:1;">&#8942;</button>

                                    <div id="dd{{$user->id}}" style="display:none;position:fixed;background:white;border:1px solid #e9ecef;border-radius:10px;box-shadow:0 8px 24px rgba(0,0,0,0.13);min-width:160px;z-index:9999;overflow:hidden;">
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Hapus pengguna ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" style="width:100%;text-align:left;padding:10px 14px;background:none;border:none;font-size:0.88rem;font-weight:600;color:#8B0000;cursor:pointer;display:flex;align-items:center;gap:8px;">
                                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4h6v2"/></svg> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>

                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" style="padding:60px;text-align:center;color:#9e6060;font-size:0.95rem;">
                                    {{ isset($search) && $search ? '🔍 Tidak ada hasil untuk "'.$search.'"' : '📭 Belum ada data pengguna' }}
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($users->hasPages())
                <div style="padding:1.25rem 1.5rem;border-top:1px solid #f5f5f5;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:0.75rem;">
                    <span style="color:#888;font-size:0.85rem;">{{ $users->firstItem() }}–{{ $users->lastItem() }} dari {{ $users->total() }} data</span>
                    <div style="display:flex;gap:6px;flex-wrap:wrap;">
                        @if(!$users->onFirstPage())
                            <a href="{{ $users->previousPageUrl() }}" style="padding:7px 14px;background:#f8f9fa;color:#666;border-radius:7px;text-decoration:none;font-weight:600;font-size:0.85rem;">← Prev</a>
                        @endif
                        @foreach(range(1,$users->lastPage()) as $page)
                            <a href="{{ $users->url($page) }}" style="padding:7px 12px;background:{{ $page==$users->currentPage()?'#8B0000':'#f8f9fa' }};color:{{ $page==$users->currentPage()?'white':'#666' }};border-radius:7px;text-decoration:none;font-weight:600;font-size:0.85rem;">{{ $page }}</a>
                        @endforeach
                        @if($users->hasMorePages())
                            <a href="{{ $users->nextPageUrl() }}" style="padding:7px 14px;background:#f8f9fa;color:#666;border-radius:7px;text-decoration:none;font-weight:600;font-size:0.85rem;">Next →</a>
                        @endif
                    </div>
                </div>
                @endif
            </div>

        </div>
    </div>
</div>

<script>
function toggleDD(e, id) {
    e.stopPropagation();
    const btn = e.currentTarget;
    const dd = document.getElementById(id);
    const isOpen = dd.style.display === 'block';
    document.querySelectorAll('[id^="dd"]').forEach(el => el.style.display = 'none');
    if (!isOpen) {
        const rect = btn.getBoundingClientRect();
        dd.style.display = 'block';
        dd.style.top = (rect.bottom + window.scrollY + 4) + 'px';
        dd.style.left = (rect.right + window.scrollX - 160) + 'px';
    }
}
document.addEventListener('click', () => {
    document.querySelectorAll('[id^="dd"]').forEach(el => el.style.display = 'none');
});
document.addEventListener('DOMContentLoaded', () => {
    const el = document.getElementById('alert-s');
    if (el) setTimeout(() => { el.style.transition='opacity 0.5s'; el.style.opacity='0'; setTimeout(()=>el.style.display='none',500); }, 4000);
});
</script>

@endsection