<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Buku;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class PeminjamanController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | USER AREA
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $data = Peminjaman::where('user_id', auth()->id())
            ->with('buku')
            ->latest()
            ->get();

        return view('pengguna.pinjam', compact('data'));
    }

    public function store(Request $request, $id)
    {
        $buku = Buku::findOrFail($id);

        // Cek stok
        if ($buku->stock <= 0) {
            return back()->with('error', 'Stok buku habis.');
        }

        // Cek batas peminjaman aktif
        $peminjamAktif = auth()->user()->peminjamans()
            ->where(function($q) {
                $q->whereIn('status', ['menunggu', 'disetujui', 'terlambat'])
                  ->orWhere(function($q2) {
                      $q2->where('status', 'disetujui')
                         ->where('tanggal_kembali', '<', now('Asia/Jakarta')->format('Y-m-d'));
                  });
            })->count();

        if ($peminjamAktif >= 2) {
            return back()->with('error', 'Kamu sudah memiliki 2 peminjaman aktif.');
        }

        // Simpan peminjaman
        Peminjaman::create([
            'user_id'         => auth()->id(),
            'buku_id'         => $buku->id,
            'tanggal_pinjam'  => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali,
            'status'          => 'menunggu',
        ]);

        // Kurangi stok saat menunggu
        $buku->decrement('stock');

        return back()->with('success', 'Permintaan peminjaman berhasil dikirim.');
    }

    // User batalkan peminjaman (hanya saat status menunggu)
    public function cancel(Peminjaman $peminjaman)
    {
        // Pastikan milik user sendiri
        if ($peminjaman->user_id !== auth()->id()) {
            return back()->with('error', 'Akses tidak diizinkan.');
        }

        // Hanya bisa batalkan jika masih menunggu
        if ($peminjaman->status !== 'menunggu') {
            return back()->with('error', 'Peminjaman tidak bisa dibatalkan.');
        }

        // Kembalikan stok
        $peminjaman->buku->increment('stock');

        $peminjaman->delete();

        return back()->with('success', 'Peminjaman berhasil dibatalkan.');
    }

    // User mengajukan request pengembalian buku
    public function requestKembali(Peminjaman $peminjaman)
    {
        if ($peminjaman->user_id !== auth()->id()) {
            return back()->with('error', 'Akses tidak diizinkan.');
        }

        if (!in_array($peminjaman->status, ['disetujui', 'terlambat'])) {
            return back()->with('error', 'Status tidak memungkinkan untuk dikembalikan.');
        }

        $peminjaman->status = 'menunggu_kembali';
        $peminjaman->save();

        return back()->with('success', 'Permintaan pengembalian berhasil dikirim! Silakan kembalikan buku ke perpustakaan.');
    }

    public function downloadBukti(Peminjaman $peminjaman)
    {
        if ($peminjaman->user_id !== auth()->id()) {
            abort(403);
        }

        $pdf = Pdf::loadView('pengguna.bukti-pdf', compact('peminjaman'));
        return $pdf->download('bukti-peminjaman.pdf');
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN AREA
    |--------------------------------------------------------------------------
    */

    public function indexAdmin(Request $request)
{
    $search = $request->input('search');

    $query = Peminjaman::with(['user', 'buku'])
        ->where('status', '!=', 'dikembalikan')
        ->latest();

    if ($search) {
        $query->where(function ($q) use ($search) {
            $q->whereHas('user', function ($u) use ($search) {
                $u->where('name', 'like', "%$search%");
            })->orWhereHas('buku', function ($b) use ($search) {
                $b->where('judul', 'like', "%$search%");
            });
        });
    }

    $data = $query->paginate(10)->withQueryString();

    // Cek terlambat
    foreach ($data as $pinjam) {
        if (
            $pinjam->status == 'disetujui' &&
            $pinjam->tanggal_kembali &&
            now()->greaterThan($pinjam->tanggal_kembali)
        ) {
            $pinjam->status = 'terlambat';
            $pinjam->save();
        }
    }

    return view('admin.peminjaman.peminjaman', compact('data', 'search'));
}

    public function approve(Peminjaman $peminjaman)
    {
        if ($peminjaman->status !== 'menunggu') {
            return back()->with('error', 'Peminjaman sudah diproses.');
        }

        // Stok TIDAK berubah (sudah dikurangi saat menunggu)
        $peminjaman->status = 'disetujui';
        $peminjaman->save();

        return redirect()->route('admin.peminjaman.index')
            ->with('success', 'Peminjaman berhasil disetujui.');
    }

    public function reject(Peminjaman $peminjaman)
    {
        if ($peminjaman->status !== 'menunggu') {
            return back()->with('error', 'Peminjaman sudah diproses.');
        }

        $peminjaman->status = 'ditolak';
        $peminjaman->save();

        // Kembalikan stok karena ditolak saat masih menunggu
        $peminjaman->buku->increment('stock');

        return redirect()->route('admin.peminjaman.index')
            ->with('success', 'Peminjaman berhasil ditolak.');
    }

    // Admin update status — termasuk konfirmasi pengembalian dari user
    public function updateStatus(Request $request, Peminjaman $peminjaman)
    {
        if (!in_array($peminjaman->status, ['menunggu', 'disetujui', 'menunggu_kembali', 'terlambat'])) {
            return back()->with('error', 'Status tidak bisa diubah.');
        }

        $request->validate([
            'status' => 'required|in:disetujui,ditolak,dikembalikan'
        ]);

        $statusLama = $peminjaman->status;

        $peminjaman->status = $request->status;

        if ($request->status === 'dikembalikan') {
            $peminjaman->tanggal_dikembalikan = now();
            // Kembalikan stok saat buku dikembalikan
            $peminjaman->buku->increment('stock');
        }

        // Jika admin ubah status ke ditolak dari menunggu via updateStatus
        if ($request->status === 'ditolak' && $statusLama === 'menunggu') {
            $peminjaman->buku->increment('stock');
        }

        $peminjaman->save();

        return back()->with('success', 'Status berhasil diperbarui.');
    }

    // Admin hapus data peminjaman
    public function destroy(Peminjaman $peminjaman)
    {
        // Kalau masih menunggu dan dihapus, kembalikan stok
        if ($peminjaman->status === 'menunggu') {
            $peminjaman->buku->increment('stock');
        }

        $peminjaman->delete();

        return back()->with('success', 'Data peminjaman berhasil dihapus.');
    }

    public function pengembalian(Request $request)
    {
        $search = $request->input('search');

        $query = Peminjaman::with(['user', 'buku'])
            ->where('status', 'dikembalikan')
            ->latest();

        if ($search) {
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%$search%");
            })->orWhereHas('buku', function ($q) use ($search) {
                $q->where('judul', 'like', "%$search%");
            });
        }

        $data = $query->paginate(10)->withQueryString();

        return view('admin.peminjaman.pengembalian', compact('data', 'search'));
    }
}