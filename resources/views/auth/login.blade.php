<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk — {{ config('app.name', 'Pustaka') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: { DEFAULT: '#8B0000', dark: '#7c0707', light: '#f9f0f0' },
                        gold: '#C9962A',
                    },
                    fontFamily: {
                        sans: ['DM Sans', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        * { font-family: 'DM Sans', sans-serif; }
        .brand-input {
            width: 100%;
            border: 1.5px solid #E5E7EB;
            border-radius: 10px;
            padding: 11px 16px;
            font-size: 0.875rem;
            color: #111827;
            background: #FAFAFA;
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
            outline: none;
        }
        .brand-input:focus {
            border-color: #8B0000;
            box-shadow: 0 0 0 3px rgba(139,0,0,0.08);
            background: #fff;
        }
        .brand-input::placeholder { color: #9CA3AF; }
        .btn-brand {
            width: 100%;
            background: #8B0000;
            color: #fff;
            font-size: 0.875rem;
            font-weight: 600;
            padding: 12px;
            border-radius: 10px;
            border: none;
            cursor: pointer;
            letter-spacing: 0.01em;
            transition: background 0.2s, transform 0.1s;
        }
        .btn-brand:hover  { background: #7c0707; }
        .btn-brand:active { transform: scale(0.985); }
    </style>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body class="bg-white font-sans overflow-hidden">

<div class="h-screen grid grid-cols-1 lg:grid-cols-2">

    {{-- ── KIRI: FORM ── --}}
    <div class="flex flex-col justify-center items-center px-6 lg:px-16 xl:px-24 overflow-y-auto">
        <div class="w-full max-w-[380px] py-10">

            {{-- Logo --}}
            <a href="/" class="inline-flex items-center gap-2 mb-12 no-underline group">
                <span class="w-8 h-8 rounded-md bg-brand flex items-center justify-center">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="2.2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.966 8.966 0 00-6 2.292m0-14.25v14.25"/>
                    </svg>
                </span>
                <span class="text-xl font-bold text-brand tracking-tight">Pustaka</span>
            </a>

            {{-- Heading --}}
            <div class="mb-8">
                <h1 class="text-[1.75rem] font-bold text-gray-900 leading-tight mb-1">Selamat datang kembali</h1>
                <p class="text-sm text-gray-400">Lanjutkan perjalanan membacamu.</p>
            </div>

            <x-auth-session-status class="mb-5 text-sm text-green-700 bg-green-50 border border-green-200 rounded-lg px-4 py-3" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Alamat Email</label>
                    <input id="email" type="email" name="email"
                           value="{{ old('email') }}"
                           placeholder="kamu@email.com"
                           required autofocus autocomplete="username"
                           class="brand-input">
                    <x-input-error :messages="$errors->get('email')" class="mt-1.5 text-xs text-red-600" />
                </div>

                {{-- Password --}}
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}"
                               class="text-xs text-brand hover:text-brand-dark transition-colors no-underline font-medium">
                                Lupa password?
                            </a>
                        @endif
                    </div>
                    <div class="relative">
                        <input id="password" type="password" name="password"
                               placeholder="••••••••"
                               required autocomplete="current-password"
                               class="brand-input pr-11">
                        {{-- Toggle show/hide --}}
                        <button type="button" onclick="togglePwd()"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors">
                            <svg id="eye-icon" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-1.5 text-xs text-red-600" />
                </div>

                {{-- Remember me --}}
                <div class="flex items-center gap-2.5">
                    <input id="remember_me" type="checkbox" name="remember"
                           class="w-4 h-4 rounded border-gray-300 accent-brand cursor-pointer">
                    <label for="remember_me" class="text-sm text-gray-500 cursor-pointer select-none">
                        Ingat saya selama 30 hari
                    </label>
                </div>

                {{-- Submit --}}
                <button type="submit" class="btn-brand mt-1">
                    Masuk
                </button>

                {{-- Divider --}}
                <div class="relative flex items-center gap-3 py-1">
                    <div class="flex-1 h-px bg-gray-100"></div>
                    <span class="text-xs text-gray-300 font-medium">atau</span>
                    <div class="flex-1 h-px bg-gray-100"></div>
                </div>

                {{-- Register link --}}
                @if (Route::has('register'))
                <p class="text-center text-sm text-gray-400">
                    Belum punya akun?
                    <a href="{{ route('register') }}"
                       class="text-brand font-semibold hover:text-brand-dark transition-colors no-underline">
                        Daftar gratis
                    </a>
                </p>
                @endif
            </form>

            {{-- Footer note --}}
            <p class="mt-10 text-center text-xs text-gray-300">
                © {{ date('Y') }} Pustaka. Semua hak dilindungi.
            </p>
        </div>
    </div>

    {{-- ── KANAN: GAMBAR ── --}}
    <div class="relative hidden lg:block bg-white">
        {{-- Border warna sama dengan bg (white), rounded, shadow halus --}}
        <div class="absolute inset-6 rounded-2xl overflow-hidden"
             style="box-shadow: 0 0 0 0px white, 0 0px 0px;">
            <img
                src="{{ asset('image/login2.jpeg') }}"
                alt="Cover"
                class="absolute inset-0 w-full h-full object-cover"
            >
            {{-- Overlay --}}
            <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-black/10 to-transparent"></div>

            {{-- Caption --}}
            <div class="absolute bottom-8 left-8 right-8">
                <p class="font-medium italic text-white/90 text-base leading-snug drop-shadow">
                    "Membaca adalah petualangan tanpa batas."
                </p>
                <span class="text-white/50 text-xs tracking-widest uppercase mt-1 block">— Pramoedya Ananta Toer</span>
            </div>
        </div>
    </div>

</div>

<script>
function togglePwd() {
    const input = document.getElementById('password');
    const icon  = document.getElementById('eye-icon');
    if (input.type === 'password') {
        input.type = 'text';
        icon.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029"/>
            <path stroke-linecap="round" stroke-linejoin="round" d="M6.111 6.111A9.969 9.969 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.969 9.969 0 01-4.02 5.197"/>
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18"/>`;
    } else {
        input.type = 'password';
        icon.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>`;
    }
}
</script>

</body>
</html>