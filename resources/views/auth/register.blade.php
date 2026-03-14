@extends('layout.app')

@section('content')
<style>
    .inp {
        width: 100%; padding: 8px 12px; border-radius: 8px; font-size: 0.82rem;
        border: 1.5px solid #fbd5d5; background: #fffafa; outline: none; box-sizing: border-box;
        transition: border-color .2s, box-shadow .2s, background .2s;
    }
    .inp:focus {
        border-color: #8B0000;
        box-shadow: 0 0 0 3px rgba(139,0,0,0.08);
        background: #fff;
    }
</style>

<div style="height:100vh; display:flex; align-items:center; justify-content:center; padding:16px;
            background: linear-gradient(135deg, #fdf2f2, #f9f0f0, #fff5f5);">
    <div style="width:100%; max-width:520px;">

        {{-- Icon --}}
        <div style="text-align:center; margin-bottom:14px;">
            <svg width="38" height="38" fill="none" viewBox="0 0 24 24" stroke="#8B0000" stroke-width="1.5" style="display:block; margin:0 auto;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.966 8.966 0 00-6 2.292m0-14.25v14.25"/>
            </svg>
        </div>

        {{-- Card --}}
        <div style="background:#fff; border-radius:20px; padding:24px 32px; border:1px solid #fde8e8;">

            <div style="text-align:center; margin-bottom:16px;">
                <h1 style="font-size:1.1rem; font-weight:700; color:#111; margin:0 0 2px;">Buat akun baru</h1>
                <p style="font-size:0.8rem; color:#9CA3AF; margin:0;">Mulai perjalanan membacamu hari ini.</p>
            </div>

            <form method="POST" action="{{ route('register') }}" style="display:flex; flex-direction:column; gap:10px;">
                @csrf

                {{-- Nama --}}
                <div>
                    <label style="display:block; font-size:0.8rem; font-weight:500; color:#374151; margin-bottom:4px;">Nama</label>
                    <input class="inp" type="text" name="name" value="{{ old('name') }}" placeholder="Nama lengkap" required autofocus autocomplete="name">
                    <x-input-error :messages="$errors->get('name')" class="mt-1 text-xs text-red-600" />
                </div>

                {{-- Email --}}
                <div>
                    <label style="display:block; font-size:0.8rem; font-weight:500; color:#374151; margin-bottom:4px;">Alamat Email</label>
                    <input class="inp" type="email" name="email" value="{{ old('email') }}" placeholder="kamu@email.com" required autocomplete="username">
                    <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs text-red-600" />
                </div>

                {{-- Alamat --}}
                <div>
                    <label style="display:block; font-size:0.8rem; font-weight:500; color:#374151; margin-bottom:4px;">Alamat</label>
                    <textarea class="inp" name="alamat" rows="2" required placeholder="Jl. Contoh No. 1, Kota" style="resize:none;">{{ old('alamat') }}</textarea>
                    <x-input-error :messages="$errors->get('alamat')" class="mt-1 text-xs text-red-600" />
                </div>

                {{-- Password --}}
                <div>
                    <label style="display:block; font-size:0.8rem; font-weight:500; color:#374151; margin-bottom:4px;">Password</label>
                    <div style="position:relative;">
                        <input class="inp" id="password" type="password" name="password" placeholder="••••••••" required autocomplete="new-password" style="padding-right:36px;">
                        <button type="button" onclick="togglePwd('password','eye-1')" style="position:absolute; right:10px; top:50%; transform:translateY(-50%); background:none; border:none; cursor:pointer; color:#e9a0a0; padding:0;">
                            <svg id="eye-1" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-1 text-xs text-red-600" />
                </div>

                {{-- Konfirmasi Password --}}
                <div>
                    <label style="display:block; font-size:0.8rem; font-weight:500; color:#374151; margin-bottom:4px;">Konfirmasi Password</label>
                    <div style="position:relative;">
                        <input class="inp" id="password_confirmation" type="password" name="password_confirmation" placeholder="••••••••" required autocomplete="new-password" style="padding-right:36px;">
                        <button type="button" onclick="togglePwd('password_confirmation','eye-2')" style="position:absolute; right:10px; top:50%; transform:translateY(-50%); background:none; border:none; cursor:pointer; color:#e9a0a0; padding:0;">
                            <svg id="eye-2" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-xs text-red-600" />
                </div>

                {{-- Submit --}}
                <button type="submit" style="padding:10px; border-radius:8px; border:none; cursor:pointer; font-size:0.875rem; font-weight:600; color:#fff; background:linear-gradient(135deg,#8B0000,#b91c1c);">
                    Daftar
                </button>

                <div style="display:flex; align-items:center; gap:12px;">
                    <div style="flex:1; height:1px; background:#fde8e8;"></div>
                    <span style="font-size:0.75rem; color:#f0b8b8;">atau</span>
                    <div style="flex:1; height:1px; background:#fde8e8;"></div>
                </div>

                <p style="text-align:center; font-size:0.82rem; color:#9CA3AF; margin:0;">
                    Sudah punya akun? <a href="{{ route('login') }}" style="font-weight:600; color:#8B0000; text-decoration:none;">Masuk</a>
                </p>

            </form>
        </div>

        <p style="margin-top:12px; text-align:center; font-size:0.72rem; color:#e9a0a0;">© {{ date('Y') }} Pustaka. Semua hak dilindungi.</p>
    </div>
</div>

<script>
    function togglePwd(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon  = document.getElementById(iconId);
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