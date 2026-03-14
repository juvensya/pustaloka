<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        $totalBuku         = Buku::count();
        $totalPeminjaman   = Peminjaman::count();
        $totalDikembalikan = Peminjaman::where('status', 'dikembalikan')->count();
        $totalTerlambat    = Peminjaman::where('status', 'terlambat')->count();

        return view('admin.laporan.laporan', compact(
            'totalBuku',
            'totalPeminjaman',
            'totalDikembalikan',
            'totalTerlambat'
        ));
    }

    public function pdfBuku()
    {
        $buku = Buku::with('kategori')->orderBy('judul')->get();

        $pdf = Pdf::loadView('admin.laporan.pdf-buku', compact('buku'))
                  ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-buku.pdf');
    }

    public function pdfPeminjaman(Request $request)
    {
        $query = Peminjaman::with(['user', 'buku'])
            ->whereIn('status', ['menunggu', 'disetujui', 'terlambat', 'menunggu_kembali']);

        if ($request->tgl_mulai) {
            $query->whereDate('tanggal_pinjam', '>=', $request->tgl_mulai);
        }
        if ($request->tgl_akhir) {
            $query->whereDate('tanggal_pinjam', '<=', $request->tgl_akhir);
        }
        if ($request->bulan) {
            $query->whereMonth('tanggal_pinjam', $request->bulan);
        }
        if ($request->tahun) {
            $query->whereYear('tanggal_pinjam', $request->tahun);
        }

        $peminjaman = $query->orderByDesc('tanggal_pinjam')->get();

        $filter = [
            'tgl_mulai' => $request->tgl_mulai,
            'tgl_akhir' => $request->tgl_akhir,
            'bulan'     => $request->bulan,
            'tahun'     => $request->tahun,
        ];

        $pdf = Pdf::loadView('admin.laporan.pdf-peminjaman', compact('peminjaman', 'filter'))
                  ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-peminjaman.pdf');
    }

    public function pdfPengembalian(Request $request)
    {
        $query = Peminjaman::with(['user', 'buku'])
            ->where('status', 'dikembalikan');

        if ($request->tgl_mulai) {
            $query->whereDate('tanggal_dikembalikan', '>=', $request->tgl_mulai);
        }
        if ($request->tgl_akhir) {
            $query->whereDate('tanggal_dikembalikan', '<=', $request->tgl_akhir);
        }
        if ($request->bulan) {
            $query->whereMonth('tanggal_dikembalikan', $request->bulan);
        }
        if ($request->tahun) {
            $query->whereYear('tanggal_dikembalikan', $request->tahun);
        }

        $pengembalian = $query->orderByDesc('tanggal_dikembalikan')->get();

        $filter = [
            'tgl_mulai' => $request->tgl_mulai,
            'tgl_akhir' => $request->tgl_akhir,
            'bulan'     => $request->bulan,
            'tahun'     => $request->tahun,
        ];

        $pdf = Pdf::loadView('admin.laporan.pdf-pengembalian', compact('pengembalian', 'filter'))
                  ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-pengembalian.pdf');
    }
}