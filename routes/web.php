<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KoleksiController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\AkunController;
use App\Http\Controllers\UlasanController;
use App\Http\Controllers\LaporanController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| ROUTE PUBLIC
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});


/*
|--------------------------------------------------------------------------
| DASHBOARD REDIRECT BERDASARKAN ROLE
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {

    $role = auth()->user()->role;

    if ($role === 'admin' || $role === 'petugas') {
        return redirect()->route('admin.index');
    } elseif ($role === 'pengguna') {
        return redirect()->route('pengguna.index');
    }

    return redirect('/'); // fallback kalau role aneh

})->middleware(['auth'])->name('dashboard');


/*
|--------------------------------------------------------------------------
| PROFILE
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

});

/*
|--------------------------------------------------------------------------
| ROUTE PENGGUNA
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:pengguna'])->group(function () {

    Route::get('/pengguna', [PenggunaController::class, 'index'])->name('pengguna.index');
    Route::get('/pengguna/buku/filter', [PenggunaController::class, 'filter'])->name('pengguna.filter');
    Route::get('/pengguna/buku/{buku}', [PenggunaController::class, 'detail'])->name('pengguna.buku.detail');

    // KOLEKSI
    Route::post('/pengguna/koleksi/{buku}', [KoleksiController::class, 'store'])->name('koleksi.store');
    Route::delete('/pengguna/koleksi/{buku}', [KoleksiController::class, 'destroy'])->name('koleksi.destroy');
    Route::get('/pengguna/koleksi', [KoleksiController::class, 'index'])->name('koleksi.index');

    // PEMINJAMAN
    Route::post('/pengguna/pinjam/{id}', [PeminjamanController::class, 'store'])->name('pinjam.store');
    Route::get('/pengguna/peminjaman-saya', [PeminjamanController::class, 'index'])->name('pinjam.index');
    Route::patch('/peminjaman/{peminjaman}/kembali', [PeminjamanController::class, 'requestKembali'])->name('peminjaman.requestKembali');
    Route::delete('/pengguna/peminjaman/{peminjaman}', [PeminjamanController::class, 'destroy'])->name('peminjaman.destroy');
    Route::delete('/peminjaman/{id}/cancel', [PinjamController::class, 'cancel'])->name('pinjam.cancel');
    Route::get('/peminjaman/{peminjaman}/bukti-pdf', [PeminjamanController::class, 'downloadBukti'])->name('peminjaman.buktiPdf');



/* halaman tulis ulasan */
Route::get('/ulasan/{buku_id}', [UlasanController::class, 'create'])->name('ulasan.create');

/* simpan ulasan */
Route::post('/ulasan', [UlasanController::class, 'store'])->name('ulasan.store');

/* daftar ulasan user */
Route::get('/pengguna/ulasan', [UlasanController::class, 'index'])->name('ulasan.index');

/* edit ulasan */
Route::get('/pengguna/ulasan/{ulasan}/edit', [UlasanController::class, 'edit'])->name('ulasan.edit');

/* UPDATE ULASAN (INI YANG KAMU BELUM ADA) */
Route::put('/pengguna/ulasan/{ulasan}', [UlasanController::class, 'update'])->name('ulasan.update');

/* hapus ulasan */
Route::delete('/pengguna/ulasan/{ulasan}', [UlasanController::class, 'destroy'])->name('ulasan.destroy');
});


/*
|--------------------------------------------------------------------------
| ROUTE ADMIN & PETUGAS
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin,petugas'])->group(function () {

    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');

    // KATEGORI
    Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');
    Route::get('/kategori/create', [KategoriController::class, 'create'])->name('kategori.create');
    Route::post('/kategori', [KategoriController::class, 'store'])->name('kategori.store');
    Route::get('/kategori/{kategori}/edit', [KategoriController::class, 'edit'])->name('kategori.edit');
    Route::put('/kategori/{kategori}', [KategoriController::class, 'update'])->name('kategori.update');
    Route::delete('/kategori/{kategori}', [KategoriController::class, 'destroy'])->name('kategori.destroy');

    // BUKU
    Route::get('/buku', [BukuController::class, 'index'])->name('buku.index');
    Route::get('/buku/create', [BukuController::class, 'create'])->name('buku.create');
    Route::post('/buku', [BukuController::class, 'store'])->name('buku.store');
    Route::get('/buku/{buku}/edit', [BukuController::class, 'edit'])->name('buku.edit');
    Route::put('/buku/{buku}', [BukuController::class, 'update'])->name('buku.update');
    Route::delete('/buku/{buku}', [BukuController::class, 'destroy'])->name('buku.destroy');

    // PETUGAS (hanya admin yang idealnya bisa kelola ini, tapi taruh di sini dulu)
    Route::get('/petugas', [AdminController::class, 'listPetugas'])->name('petugas.index');
    Route::get('/petugas/create', [AdminController::class, 'createPetugas'])->name('petugas.create');
    Route::post('/petugas/store', [AdminController::class, 'storePetugas'])->name('petugas.store');
    Route::get('/petugas/{id}/edit', [AdminController::class, 'editPetugas'])->name('petugas.edit');
    Route::put('/petugas/{id}', [AdminController::class, 'updatePetugas'])->name('petugas.update');
    Route::delete('/petugas/{id}', [AdminController::class, 'destroyPetugas'])->name('petugas.destroy');


    
    // PEMINJAMAN (untuk lihat semua data pengajuan)
   Route::get('/admin/peminjaman', [PeminjamanController::class, 'indexAdmin'])
    ->name('admin.peminjaman.index');

    Route::put('/admin/peminjaman/{peminjaman}/approve', [PeminjamanController::class, 'approve'])
    ->name('admin.peminjaman.approve');


Route::put('/admin/peminjaman/{peminjaman}/reject', [PeminjamanController::class, 'reject'])
    ->name('admin.peminjaman.reject');

    Route::put('/admin/peminjaman/{peminjaman}/status',
    [PeminjamanController::class, 'updateStatus'])
    ->name('admin.peminjaman.updateStatus');

Route::delete('/admin/peminjaman/{peminjaman}',
    [PeminjamanController::class, 'destroy'])
    ->name('admin.peminjaman.destroy');
    
    Route::get('/admin/peminjaman',
    [PeminjamanController::class, 'indexAdmin'])
    ->name('admin.peminjaman.index');

Route::get('/admin/pengembalian',
    [PeminjamanController::class, 'pengembalian'])
    ->name('admin.peminjaman.pengembalian');

    

Route::get('/admin/pengguna', [AkunController::class, 'index'])->name('admin.users.index');
Route::delete('/admin/pengguna/{user}', [AkunController::class, 'destroy'])->name('admin.users.destroy');

Route::get('/admin/ulasan', [UlasanController::class, 'adminIndex'])->name('admin.ulasan');
// ULASAN (admin)
Route::delete('/admin/ulasan/{id}', [UlasanController::class, 'adminDestroy'])->name('admin.ulasan.destroy');


Route::get('/admin/laporan', [LaporanController::class, 'index'])->name('admin.laporan.index');
Route::get('/admin/laporan/buku/pdf', [LaporanController::class, 'pdfBuku'])->name('admin.laporan.buku.pdf');
Route::get('/admin/laporan/peminjaman/pdf', [LaporanController::class, 'pdfPeminjaman'])->name('admin.laporan.peminjaman.pdf');
Route::get('/admin/laporan/pengembalian/pdf', [LaporanController::class, 'pdfPengembalian'])->name('admin.laporan.pengembalian.pdf');

});


require __DIR__.'/auth.php';
