<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;

use Illuminate\Http\Request;

class PenggunaController extends Controller
{
    public function index(Request $request)
    {
        $kategoris = Kategori::all();
        $kategoriAktif = $request->input('kategori');

        $bukuTerbaru = Buku::with('kategori')
            ->latest()
            ->take(5)
            ->get();

        $bukus = Buku::with('kategori')
            ->when($kategoriAktif, function ($query) use ($kategoriAktif) {
                $query->where('kategori_id', $kategoriAktif);
            })
            ->latest()
            ->paginate(10);

        return view('pengguna.index', compact('bukuTerbaru', 'bukus', 'kategoris', 'kategoriAktif'));
    }

        
    public function filter(Request $request)
    {
        $kategoriAktif = $request->input('kategori');

        $bukus = Buku::with('kategori')
            ->when($kategoriAktif, function ($query) use ($kategoriAktif) {
                $query->where('kategori_id', $kategoriAktif);
            })
            ->latest()
            ->paginate(10);

        return response()->json([
            'html' => view('pengguna.partials.grid-buku', compact('bukus'))->render()
        ]);
    }

  public function detail(Buku $buku)
{
    return view('pengguna.detail', compact('buku'));
}
}