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
<body class="bg-white text-gray-800">

    {{-- NAV --}}
    <nav class="fixed top-0 w-full bg-white/95 backdrop-blur z-50 border-b border-red-100">
        <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-3 text-red-900 font-bold text-2xl">
                <i class="fas fa-book-open"></i>
                <span>{{ config('app.name', 'PUSTALOKA') }}</span>
            </div>
            <div class="hidden md:flex gap-8 text-sm text-gray-600">
                
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
    <section class="pt-32 pb-20 px-6">
        <div class="max-w-3xl mx-auto text-center">
            <span class="text-xs font-semibold tracking-widest text-red-900 uppercase mb-4 block">Perpustakaan Digital</span>
            <h1 class="text-5xl md:text-6xl font-bold text-gray-900 leading-tight mb-6">
                Dunia Pengetahuan<br>Ada di Sini
            </h1>
            <p class="text-gray-500 text-lg mb-10 max-w-xl mx-auto">
                Ribuan koleksi buku digital, tersedia kapan saja dan di mana saja untuk mendukung perjalanan belajar Anda.
            </p>

        </div>
    </section>

    {{-- FEATURES --}}
    <section class="py-20 px-6" id="layanan">
        <div class="max-w-4xl mx-auto">
            <div class="mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-2">Layanan Kami</h2>
                <p class="text-gray-400">Kemudahan mengakses perpustakaan modern</p>
            </div>
            <div class="grid md:grid-cols-2 gap-5">

                <div class="p-7 rounded-xl border border-gray-100 hover:border-red-200 hover:bg-red-50/30 transition">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 bg-red-900 rounded-lg flex items-center justify-center shrink-0">
                            <i class="fas fa-laptop text-sm text-white"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900">Perpustakaan Digital</h3>
                    </div>
                    <p class="text-gray-500 text-sm leading-relaxed mb-4">Akses lebih dari 10.000 judul e-book, jurnal ilmiah, dan majalah digital dari berbagai bidang keilmuan. Koleksi diperbarui setiap bulan untuk memastikan konten selalu relevan dan terkini.</p>
                    <ul class="space-y-1.5 text-sm text-gray-400">
                        <li class="flex items-center gap-2"><i class="fas fa-check text-red-900 text-xs"></i> Tersedia dalam format PDF & ePub</li>
                        <li class="flex items-center gap-2"><i class="fas fa-check text-red-900 text-xs"></i> Dapat diakses dari semua perangkat</li>
                        <li class="flex items-center gap-2"><i class="fas fa-check text-red-900 text-xs"></i> Mode baca offline tersedia</li>
                    </ul>
                </div>

                <div class="p-7 rounded-xl border border-gray-100 hover:border-red-200 hover:bg-red-50/30 transition">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 bg-red-900 rounded-lg flex items-center justify-center shrink-0">
                            <i class="fas fa-bookmark text-sm text-white"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900">Sistem Peminjaman</h3>
                    </div>
                    <p class="text-gray-500 text-sm leading-relaxed mb-4">Pinjam dan kembalikan buku fisik maupun digital dengan mudah melalui platform kami. Sistem notifikasi otomatis akan mengingatkan Anda sebelum batas waktu pengembalian tiba.</p>
                    <ul class="space-y-1.5 text-sm text-gray-400">
                        <li class="flex items-center gap-2"><i class="fas fa-check text-red-900 text-xs"></i> Maksimal 5 buku per anggota</li>
                        <li class="flex items-center gap-2"><i class="fas fa-check text-red-900 text-xs"></i> Perpanjangan online tanpa antri</li>
                        <li class="flex items-center gap-2"><i class="fas fa-check text-red-900 text-xs"></i> Notifikasi via email & WhatsApp</li>
                    </ul>
                </div>

                <div class="p-7 rounded-xl border border-gray-100 hover:border-red-200 hover:bg-red-50/30 transition">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 bg-red-900 rounded-lg flex items-center justify-center shrink-0">
                            <i class="fas fa-search text-sm text-white"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900">Pencarian Cerdas</h3>
                    </div>
                    <p class="text-gray-500 text-sm leading-relaxed mb-4">Mesin pencari kami didukung teknologi AI yang memahami konteks permintaan Anda. Temukan buku yang tepat berdasarkan judul, pengarang, topik, atau bahkan cuplikan isi buku.</p>
                    <ul class="space-y-1.5 text-sm text-gray-400">
                        <li class="flex items-center gap-2"><i class="fas fa-check text-red-900 text-xs"></i> Pencarian berbasis kata kunci & topik</li>
                        <li class="flex items-center gap-2"><i class="fas fa-check text-red-900 text-xs"></i> Filter kategori, tahun, dan bahasa</li>
                        <li class="flex items-center gap-2"><i class="fas fa-check text-red-900 text-xs"></i> Rekomendasi buku personal</li>
                    </ul>
                </div>

                <div class="p-7 rounded-xl border border-gray-100 hover:border-red-200 hover:bg-red-50/30 transition">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 bg-red-900 rounded-lg flex items-center justify-center shrink-0">
                            <i class="fas fa-chalkboard-teacher text-sm text-white"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900">Program Literasi</h3>
                    </div>
                    <p class="text-gray-500 text-sm leading-relaxed mb-4">Tingkatkan budaya baca melalui berbagai program yang kami selenggarakan secara rutin. Mulai dari diskusi buku, bedah karya, hingga workshop penulisan kreatif bersama penulis ternama.</p>
                    <ul class="space-y-1.5 text-sm text-gray-400">
                        <li class="flex items-center gap-2"><i class="fas fa-check text-red-900 text-xs"></i> Workshop & diskusi bulanan</li>
                        <li class="flex items-center gap-2"><i class="fas fa-check text-red-900 text-xs"></i> Tersedia sesi online & offline</li>
                        <li class="flex items-center gap-2"><i class="fas fa-check text-red-900 text-xs"></i> Sertifikat keikutsertaan resmi</li>
                    </ul>
                </div>

            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="py-20 px-6 text-center">
        <div class="max-w-xl mx-auto">
            <h2 class="text-3xl font-bold text-gray-900 mb-3">Mulai Sekarang</h2>
            <p class="text-gray-400 mb-8">Daftar gratis dan akses ribuan koleksi buku digital.</p>
            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="bg-red-900 text-white px-8 py-3 rounded-full font-semibold inline-block hover:bg-red-800 transition">
                    Daftar Sekarang
                </a>
            @endif
        </div>
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