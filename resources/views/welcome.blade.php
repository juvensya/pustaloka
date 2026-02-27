<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'PUSTALOKA') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>tailwind.config = { theme: { extend: { colors: { red: { 900: '#8B0000', 800: '#6B0000' } } } } }</script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body class="bg-gray-50 font-sans">

    {{-- NAV --}}
    <nav class="fixed top-0 w-full bg-white/95 backdrop-blur z-50 border-b border-red-100">
        <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-3 text-red-900 font-bold text-2xl">
                <i class="fas fa-book-open"></i>
                <span>{{ config('app.name', 'PUSTALOKA') }}</span>
            </div>
            <div class="hidden md:flex gap-8 text-sm text-gray-600">
                <a href="#koleksi" class="hover:text-red-900 transition">Koleksi</a>
                <a href="#layanan" class="hover:text-red-900 transition">Layanan</a>
                <a href="#kontak" class="hover:text-red-900 transition">Kontak</a>
            </div>
            @if (Route::has('login'))
                <div class="flex gap-2">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="bg-red-900 text-white px-5 py-2 rounded-full text-sm font-semibold hover:bg-red-800 transition">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="border border-red-900 text-red-900 px-5 py-2 rounded-full text-sm font-semibold hover:bg-red-900 hover:text-white transition">Masuk</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="bg-red-900 text-white px-5 py-2 rounded-full text-sm font-semibold hover:bg-red-800 transition">Daftar</a>
                        @endif
                    @endauth
                </div>
            @endif
        </div>
    </nav>

    {{-- HERO --}}
    <section class="bg-gradient-to-br from-red-900 to-red-700 pt-36 pb-24 px-6">
        <div class="max-w-6xl mx-auto grid md:grid-cols-2 gap-16 items-center">
            <div>
                <h1 class="text-5xl font-extrabold text-white leading-tight mb-6">
                    Jelajahi Dunia <span class="text-red-200">Pengetahuan</span> Tanpa Batas
                </h1>
                <p class="text-white/80 text-lg leading-relaxed mb-10">
                    PUSTALOKA menghadirkan ribuan koleksi buku digital untuk mendukung perjalanan belajar Anda. Akses kapan saja, di mana saja.
                </p>
                <div class="flex gap-4 flex-wrap">
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="bg-white text-red-900 px-8 py-4 rounded-full font-bold flex items-center gap-2 hover:-translate-y-1 transition">
                            <i class="fas fa-user-plus"></i> Daftar Gratis
                        </a>
                    @endif
                    <a href="#layanan" class="border-2 border-white text-white px-8 py-4 rounded-full font-bold flex items-center gap-2 hover:bg-white hover:text-red-900 transition">
                        <i class="fas fa-play-circle"></i> Pelajari Lebih
                    </a>
                </div>
            </div>
            <div class="flex justify-center">
                <svg class="w-80 animate-bounce" viewBox="0 0 500 500" xmlns="http://www.w3.org/2000/svg" style="animation: float 6s ease-in-out infinite">
                    <rect x="150" y="100" width="200" height="300" rx="10" fill="#fff" opacity="0.9"/>
                    <rect x="170" y="120" width="160" height="20" rx="5" fill="#8B0000"/>
                    <rect x="170" y="160" width="120" height="8" rx="4" fill="#ddd"/>
                    <rect x="170" y="180" width="140" height="8" rx="4" fill="#ddd"/>
                    <rect x="170" y="200" width="100" height="8" rx="4" fill="#ddd"/>
                    <circle cx="250" cy="300" r="50" fill="#8B0000" opacity="0.2"/>
                    <path d="M250 270L250 330M220 300L280 300" stroke="#8B0000" stroke-width="8" stroke-linecap="round"/>
                </svg>
            </div>
        </div>
    </section>

    {{-- STATS --}}
    <section class="bg-white py-12 px-6 -mt-10 relative z-10">
        <div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-lg grid grid-cols-2 md:grid-cols-4 gap-6 p-10 text-center">
            @foreach([['10K+','Koleksi Buku'],['5K+','Anggota Aktif'],['50+','Kategori'],['24/7','Akses Online']] as $s)
            <div>
                <div class="text-4xl font-extrabold text-red-900">{{ $s[0] }}</div>
                <div class="text-gray-500 mt-1 text-sm">{{ $s[1] }}</div>
            </div>
            @endforeach
        </div>
    </section>

    {{-- FEATURES --}}
    <section class="py-24 px-6 bg-gray-50" id="layanan">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-14">
                <h2 class="text-4xl font-extrabold text-gray-900 mb-3">Layanan Unggulan Kami</h2>
                <p class="text-gray-500">Nikmati berbagai kemudahan dalam mengakses perpustakaan</p>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                @foreach([
                    ['fa-laptop','Perpustakaan Digital','Akses ribuan e-book dan jurnal digital kapan saja dari perangkat Anda.'],
                    ['fa-bookmark','Sistem Peminjaman','Peminjaman mudah dengan notifikasi otomatis untuk pengingat pengembalian.'],
                    ['fa-users','Ruang Baca','Fasilitas modern, tenang, dilengkapi WiFi gratis untuk kenyamanan Anda.'],
                    ['fa-search','Pencarian Cerdas','Temukan buku dengan sistem pencarian berbasis AI yang canggih.'],
                    ['fa-mobile-alt','Aplikasi Mobile','Akses via aplikasi mobile yang user-friendly, tersedia iOS dan Android.'],
                    ['fa-chalkboard-teacher','Program Literasi','Ikuti workshop, diskusi buku, dan program literasi secara berkala.'],
                ] as $f)
                <div class="bg-white p-10 rounded-2xl border-2 border-transparent hover:border-red-900 hover:-translate-y-2 transition group">
                    <div class="w-16 h-16 bg-gradient-to-br from-red-900 to-red-600 rounded-xl flex items-center justify-center mb-6">
                        <i class="fas {{ $f[0] }} text-2xl text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">{{ $f[1] }}</h3>
                    <p class="text-gray-500 leading-relaxed">{{ $f[2] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- BOOKS --}}
    <section class="py-24 px-6 bg-white" id="koleksi">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-14">
                <h2 class="text-4xl font-extrabold text-gray-900 mb-3">Koleksi Populer</h2>
                <p class="text-gray-500">Buku-buku yang paling banyak dibaca bulan ini</p>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @foreach([
                    ['fa-book','Filosofi Teras','Henry Manampiring','Filsafat'],
                    ['fa-code','Clean Code','Robert C. Martin','Teknologi'],
                    ['fa-graduation-cap','Sapiens','Yuval Noah Harari','Sejarah'],
                    ['fa-lightbulb','Atomic Habits','James Clear','Self Help'],
                ] as $b)
                <div class="bg-gray-50 rounded-2xl p-6 hover:-translate-y-2 hover:shadow-lg transition cursor-pointer">
                    <div class="h-52 bg-gradient-to-br from-red-900 to-red-600 rounded-xl flex items-center justify-center text-5xl text-white mb-5">
                        <i class="fas {{ $b[0] }}"></i>
                    </div>
                    <div class="font-bold text-gray-900 mb-1">{{ $b[1] }}</div>
                    <div class="text-gray-400 text-sm mb-3">{{ $b[2] }}</div>
                    <span class="bg-red-100 text-red-900 text-xs font-semibold px-3 py-1 rounded-full">{{ $b[3] }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="bg-gradient-to-br from-red-900 to-red-700 py-24 px-6 text-center text-white">
        <h2 class="text-4xl font-extrabold mb-4">Mulai Perjalanan Literasi Anda</h2>
        <p class="text-white/70 text-lg mb-10">Daftar sekarang dan dapatkan akses gratis ke ribuan koleksi buku digital.</p>
        @if (Route::has('register'))
            <a href="{{ route('register') }}" class="bg-white text-red-900 px-10 py-4 rounded-full font-bold inline-flex items-center gap-2 hover:-translate-y-1 transition">
                <i class="fas fa-user-plus"></i> Daftar Sekarang
            </a>
        @endif
    </section>

    {{-- FOOTER --}}
    <footer class="bg-red-50 border-t border-red-100 py-16 px-6" id="kontak">
        <div class="max-w-6xl mx-auto grid md:grid-cols-4 gap-12 mb-10">
            <div>
                <div class="text-red-900 font-extrabold text-2xl mb-4">{{ config('app.name', 'PUSTALOKA') }}</div>
                <p class="text-gray-500 text-sm leading-relaxed mb-5">Perpustakaan modern yang menghadirkan akses mudah ke dunia pengetahuan.</p>
                <div class="flex gap-3">
                    @foreach(['fab fa-facebook-f','fab fa-instagram','fab fa-twitter','fab fa-youtube'] as $icon)
                    <a href="#" class="w-9 h-9 bg-red-900 rounded-full flex items-center justify-center text-white text-sm hover:bg-red-800 transition">
                        <i class="{{ $icon }}"></i>
                    </a>
                    @endforeach
                </div>
            </div>
            <div>
                <h4 class="font-bold text-gray-900 mb-4">Menu</h4>
                <ul class="space-y-3 text-sm text-gray-500">
                    <li><a href="#" class="hover:text-red-900 transition">Beranda</a></li>
                    <li><a href="#koleksi" class="hover:text-red-900 transition">Koleksi</a></li>
                    <li><a href="#layanan" class="hover:text-red-900 transition">Layanan</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold text-gray-900 mb-4">Layanan</h4>
                <ul class="space-y-3 text-sm text-gray-500">
                    <li><a href="#" class="hover:text-red-900 transition">Peminjaman Online</a></li>
                    <li><a href="#" class="hover:text-red-900 transition">E-Library</a></li>
                    <li><a href="#" class="hover:text-red-900 transition">Katalog Digital</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold text-gray-900 mb-4">Kontak</h4>
                <ul class="space-y-3 text-sm text-gray-500">
                    <li>info@pustaloka.id</li>
                    <li>(021) 1234-5678</li>
                    <li>Jl. Literasi No. 123, Jakarta</li>
                </ul>
            </div>
        </div>
        <div class="border-t border-red-100 pt-6 text-center text-sm text-gray-400">
            &copy; {{ date('Y') }} {{ config('app.name', 'PUSTALOKA') }}. All Rights Reserved.
        </div>
    </footer>

    <script>
        document.querySelectorAll('a[href^="#"]').forEach(a => {
            a.addEventListener('click', e => {
                e.preventDefault();
                document.querySelector(a.getAttribute('href'))?.scrollIntoView({ behavior: 'smooth' });
            });
        });
    </script>
</body>
</html>
