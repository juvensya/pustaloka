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

    public function store(Request $request, $bukuId)
    {
        $request->validate([
            'tanggal_kembali' => [
                'required',
                'date',
                'after:today',
                'before_or_equal:' . now()->addDays(14)->format('Y-m-d'),
            ],
        ]);

        $aktif = auth()->user()->peminjamans()
            ->whereIn('status', ['menunggu', 'disetujui'])
            ->count();

        if ($aktif >= 2) {
            return back()->with('error', 'Kamu sudah memiliki 2 peminjaman aktif.');
        }

        $buku = Buku::findOrFail($bukuId);

        if ($buku->stock <= 0) {
            return back()->with('error', 'Stok buku habis.');
        }

        Peminjaman::create([
            'user_id'         => auth()->id(),
            'buku_id'         => $bukuId,
            'tanggal_pinjam'  => now()->toDateString(),
            'tanggal_kembali' => $request->tanggal_kembali,
            'status'          => 'menunggu',
        ]);

        return redirect()->route('pinjam.index')
            ->with('success', 'Permintaan peminjaman berhasil dikirim! Silakan tunggu konfirmasi admin.');
    }

    // User mengajukan request pengembalian buku
    public function requestKembali(Peminjaman $peminjaman)
    {
        if ($peminjaman->user_id !== auth()->id()) {
            return back()->with('error', 'Akses tidak diizinkan.');
        }

        if (!in_array($peminjaman->status, ['disetujui', 'terlambat'])) {
        
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
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%$search%");
            })->orWhereHas('buku', function ($q) use ($search) {
                $q->where('judul', 'like', "%$search%");
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

        $peminjaman->status = $request->status;

        if ($request->status == 'dikembalikan') {
            $peminjaman->tanggal_dikembalikan = now();
        }

        $peminjaman->save();

        return back()->with('success', 'Status berhasil diperbarui.');
    }

    public function destroy(Peminjaman $peminjaman)
    {
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