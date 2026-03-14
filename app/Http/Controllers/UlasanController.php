<?php

namespace App\Http\Controllers;

use App\Models\Ulasan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UlasanController extends Controller
{

    public function index()
    {
       $ulasans = Ulasan::with('buku')
        ->where('user_id', auth()->id())
        ->latest()
        ->get();

    return view('pengguna.ulasan.ulasan', compact('ulasans'));
    }
    
    public function create($buku_id)
    {
        return view('pengguna.ulasan.tambahUlasan', compact('buku_id'));
    }

    public function store(Request $request)
    {
        Ulasan::create([
            'user_id' => Auth::id(),
            'buku_id' => $request->buku_id,
            'rating' => $request->rating,
            'komentar' => $request->komentar
        ]);

        return back();
    }

    public function destroy($id)
    {
        $ulasan = Ulasan::findOrFail($id);

        $ulasan->delete();

        return redirect()->back()->with('success', 'Ulasan berhasil dihapus');
    }

    public function edit($id)
    {
        $ulasan = Ulasan::findOrFail($id);

        return view('pengguna.ulasan.editUlasan',compact('ulasan'));
    }

    public function update(Request $request,$id)
    {
        $ulasan = Ulasan::findOrFail($id);

        $ulasan->update([
            'rating'=>$request->rating,
            'komentar'=>$request->komentar
        ]);

        return redirect()->route('ulasan.index')
            ->with('success','Ulasan berhasil diperbarui');
    }

    public function adminIndex()
{
    $ulasans = Ulasan::with(['user','buku'])
        ->latest()
        ->get();

    return view('admin.ulasan.ulasan', compact('ulasans'));
}
public function adminDestroy($id)
{
    $ulasan = Ulasan::findOrFail($id);
    $ulasan->delete();
    return redirect()->back()->with('success', 'Ulasan berhasil dihapus');
}
}