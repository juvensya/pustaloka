<?php

namespace App\Http\Controllers;

use App\Models\Ulasan;
use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;

class PenggunaController extends Controller
{
    public function index(Request $request)
    {
        $kategoris     = Kategori::all();
        $kategoriAktif = $request->input('kategori');

        $bukuTerbaru = Buku::with('kategoris')
            ->latest()
            ->take(5)
            ->get();

        $bukus = Buku::with('kategoris')
            ->when($kategoriAktif, function ($query) use ($kategoriAktif) {
                $query->whereHas('kategoris', function ($q) use ($kategoriAktif) {
                    $q->where('kategoris.id', $kategoriAktif);
                });
            })
            ->latest()
            ->paginate(10);

        return view('pengguna.index', compact('bukuTerbaru', 'bukus', 'kategoris', 'kategoriAktif'));
    }

    public function filter(Request $request)
    {
        $kategoriAktif = $request->input('kategori');

        $bukus = Buku::with('kategoris')
            ->when($kategoriAktif, function ($query) use ($kategoriAktif) {
                $query->whereHas('kategoris', function ($q) use ($kategoriAktif) {
                    $q->where('kategoris.id', $kategoriAktif);
                });
            })
            ->latest()
            ->paginate(10);

        return response()->json([
            'html' => view('pengguna.partials.grid-buku', compact('bukus'))->render()
        ]);
    }

    public function detail(Buku $buku)
    {
    $buku->load('kategoris');
    $rating      = Ulasan::where('buku_id', $buku->id)->avg('rating') ?? 0;
    $totalUlasan = Ulasan::where('buku_id', $buku->id)->count();
    $ulasans     = Ulasan::with('user')->where('buku_id', $buku->id)->latest()->get();
    $diKoleksi   = auth()->user()->bukuKoleksi()->where('buku_id', $buku->id)->exists();

    return view('pengguna.detail', compact('buku', 'rating', 'totalUlasan', 'ulasans', 'diKoleksi'));
    }
}