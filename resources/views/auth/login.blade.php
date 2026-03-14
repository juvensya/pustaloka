@extends('layout.app')

@section('content')
<style>
    .inp {
        width: 100%; padding: 10px 14px; border-radius: 8px; font-size: 0.875rem;
        border: 1.5px solid #fbd5d5; background: #fffafa; outline: none; box-sizing: border-box;
        transition: border-color .2s, box-shadow .2s, background .2s;
    }
    .inp:focus {
        border-color: #8B0000;
        box-shadow: 0 0 0 3px rgba(139,0,0,0.08);
        background: #fff;
    }
</style>

<div style="min-height:100vh; display:flex; align-items:center; justify-content:center; padding:16px;
            background: linear-gradient(135deg, #fdf2f2, #f9f0f0, #fff5f5);">
    <div style="width:100%; max-width:440px;">

        {{-- Icon --}}
        <div style="text-align:center; margin-bottom:28px;">
            <svg width="52" height="52" fill="none" viewBox="0 0 24 24" stroke="#8B0000" stroke-width="1.5" style="display:block; margin:0 auto;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.966 8.966 0 00-6 2.292m0-14.25v14.25"/>
            </svg>
        </div>

        {{-- Card --}}
        <div style="background:#fff; border-radius:20px; padding:40px; border:1px solid #fde8e8;
                    box-shadow: 0 4px 24px rgba(139,0,0,0.07);">

            <div style="text-align:center; margin-bottom:28px;">
                <h1 style="font-size:1.3rem; font-weight:700; color:#111; margin:0 0 4px;">Selamat datang kembali</h1>
                <p style="font-size:0.875rem; color:#9CA3AF; margin:0;">Lanjutkan perjalanan membacamu.</p>
            </div>

            <x-auth-session-status class="mb-4 text-sm text-green-700 bg-green-50 border border-green-200 rounded-lg px-4 py-3" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" style="display:flex; flex-direction:column; gap:16px;">
                @csrf

                <div>
                    <label style="display:block; font-size:0.875rem; font-weight:500; color:#374151; margin-bottom:6px;">Alamat Email</label>
                    <input class="inp" type="email" name="email" value="{{ old('email') }}" placeholder="kamu@email.com" required autofocus autocomplete="username">
                    <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs text-red-600" />
                </div>

                <div>
                    <div style="display:flex; justify-content:space-between; margin-bottom:6px;">
                        <label style="font-size:0.875rem; font-weight:500; color:#374151;">Password</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" style="font-size:0.75rem; font-weight:500; color:#8B0000; text-decoration:none;">Lupa password?</a>
                        @endif
                    </div>
                    <div style="position:relative;">
                        <input class="inp" id="password" type="password" name="password" placeholder="••••••••" required autocomplete="current-password" style="padding-right:40px;">
                        <button type="button" onclick="togglePwd()" style="position:absolute; right:12px; top:50%; transform:translateY(-50%); background:none; border:none; cursor:pointer; color:#e9a0a0; padding:0;">
                            <svg id="eye-icon" width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-1 text-xs text-red-600" />
                </div>

                <div style="display:flex; align-items:center; gap:8px;">
                    <input type="checkbox" name="remember" id="remember_me" style="width:16px; height:16px; accent-color:#8B0000; cursor:pointer;">
                    <label for="remember_me" style="font-size:0.875rem; color:#6B7280; cursor:pointer;">Ingat saya selama 30 hari</label>
                </div>

                <button type="submit" style="padding:12px; border-radius:8px; border:none; cursor:pointer; font-size:0.875rem; font-weight:600; color:#fff; background:linear-gradient(135deg,#8B0000,#b91c1c);">
                    Masuk
                </button>

                <div style="display:flex; align-items:center; gap:12px;">
                    <div style="flex:1; height:1px; background:#fde8e8;"></div>
                    <span style="font-size:0.75rem; color:#f0b8b8;">atau</span>
                    <div style="flex:1; height:1px; background:#fde8e8;"></div>
                </div>

                @if (Route::has('register'))
                    <p style="text-align:center; font-size:0.875rem; color:#9CA3AF; margin:0;">
                        Belum punya akun? <a href="{{ route('register') }}" style="font-weight:600; color:#8B0000; text-decoration:none;">Daftar gratis</a>
                    </p>
                @endif

            </form>
        </div>

        <p style="margin-top:20px; text-align:center; font-size:0.75rem; color:#e9a0a0;">© {{ date('Y') }} Pustaka. Semua hak dilindungi.</p>
    </div>
</div>

<script>
    function togglePwd() {
        const input = document.getElementById('password');
        const icon  = document.getElementById('eye-icon');
        const isHidden = input.type === 'password';
        input.type = isHidden ? 'text' : 'password';
        icon.innerHTML = isHidden
            ? `<path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029"/>
               <path stroke-linecap="round" stroke-linejoin="round" d="M6.111 6.111A9.969 9.969 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.969 9.969 0 01-4.02 5.197"/>
               <path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18"/>`
            : `<path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
               <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>`;
    }
</script>
@endsection