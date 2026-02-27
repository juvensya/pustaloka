<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    // Dashboard Admin
    public function index()
    {
        // Stat cards
        $totalBuku        = Buku::count();
        $totalKategori    = Kategori::count();
        $totalAnggota     = User::where('role', 'pengguna')->count();
        $totalPeminjaman  = Peminjaman::whereIn('status', ['menunggu', 'disetujui'])->count();

        // Aktivitas terbaru (10 peminjaman terakhir)
        $aktivitas = Peminjaman::with(['user', 'buku'])
            ->latest()
            ->take(5)
            ->get();

        // Buku terpopuler berdasarkan jumlah peminjaman
        $bukuPopuler = Buku::withCount('peminjamans')
            ->orderByDesc('peminjamans_count')
            ->take(5)
            ->get();

        $maxPinjam = $bukuPopuler->max('peminjamans_count') ?: 1;

        return view('admin.index', compact(
            'totalBuku',
            'totalKategori',
            'totalAnggota',
            'totalPeminjaman',
            'aktivitas',
            'bukuPopuler',
            'maxPinjam'
        ));
    }

    // =========================
    // LIST PETUGAS
    // =========================
    public function listPetugas(Request $request)
    {
        $petugas = User::where('role', 'petugas')
            ->when($request->search, function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->search . '%')
                      ->orWhere('email', 'like', '%' . $request->search . '%');
                });
            })
            ->paginate(3)
            ->withQueryString();

        return view('admin.petugas.petugas', compact('petugas'));
    }

    // =========================
    // FORM TAMBAH PETUGAS
    // =========================
    public function createPetugas()
    {
        return view('admin.petugas.create');
    }

    // =========================
    // SIMPAN PETUGAS
    // =========================
    public function storePetugas(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'petugas',
        ]);

        return redirect()->route('petugas.index')
            ->with('success', 'Petugas berhasil ditambahkan');
    }

    // =========================
    // FORM EDIT PETUGAS
    // =========================
    public function editPetugas($id)
    {
        $petugas = User::findOrFail($id);
        return view('admin.petugas.edit', compact('petugas'));
    }

    // =========================
    // UPDATE PETUGAS
    // =========================
    public function updatePetugas(Request $request, $id)
    {
        $petugas = User::findOrFail($id);

        $request->validate([
            'name'  => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
        ]);

        $petugas->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('petugas.index')
            ->with('success', 'Petugas berhasil diupdate');
    }

    // =========================
    // HAPUS PETUGAS
    // =========================
    public function destroyPetugas($id)
    {
        $petugas = User::findOrFail($id);
        $petugas->delete();

        return redirect()->route('petugas.index')
            ->with('success', 'Petugas berhasil dihapus');
    }
}