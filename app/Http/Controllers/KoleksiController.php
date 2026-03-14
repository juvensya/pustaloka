<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Koleksi;
use App\Models\Buku;
use Illuminate\Support\Facades\Auth;

class KoleksiController extends Controller
{
    

    public function store($buku_id)
    {
    $user = Auth::user();
    $sudahAda = Koleksi::where('user_id', $user->id)->where('buku_id', $buku_id)->exists();
    if (!$sudahAda) {
        Koleksi::create(['user_id' => $user->id, 'buku_id' => $buku_id]);
        return back()->with('success', 'Buku berhasil ditambahkan ke koleksi!');
    }
    return back()->with('error', 'Buku sudah ada di koleksi kamu.');
    }

    public function destroy($buku_id)
    {
        Koleksi::where('user_id', Auth::id())
            ->where('buku_id', $buku_id)
            ->delete();

        return back();
    }

    public function index()
    {
        $koleksi = auth()->user()->bukuKoleksi()->with('kategoris')->get();
        return view('pengguna.koleksi', compact('koleksi'));
    }
}