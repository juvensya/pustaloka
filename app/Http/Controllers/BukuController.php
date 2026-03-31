<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;

class BukuController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->input('search');

        $bukus = Buku::with('kategoris')
            ->when($search, function ($query, $search) {
                return $query->where('judul', 'like', "%{$search}%")
                    ->orWhere('penulis', 'like', "%{$search}%")
                    ->orWhere('penerbit', 'like', "%{$search}%")
                    ->orWhereHas('kategoris', function ($q) use ($search) {
                        $q->where('nama_kategori', 'like', "%{$search}%");
                    });
            })
            ->paginate(4);

        $kategoris = Kategori::all();

        return view('admin.buku.buku', compact('bukus', 'kategoris'));
    }

    public function show($id)
    {
    $buku = Buku::with(['kategoris', 'ulasans.user'])->findOrFail($id);
    return view('admin.buku.detail-buku', compact('buku'));
    }

    public function create()
    {
        $kategoris = Kategori::all();
        return view('admin.buku.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategori_ids'  => 'required|array|min:1',
            'kategori_ids.*'=> 'exists:kategoris,id',
            'judul'         => 'required',
            'penulis'       => 'required',
            'penerbit'      => 'required',
            'tahun_terbit'  => 'required|numeric',
            'stock'         => 'required|numeric',
            'deskripsi'     => 'required',
            'gambar'        => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Upload gambar
        if ($request->hasFile('gambar')) {
            $file     = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/buku'), $filename);
            $validated['gambar'] = $filename;
        }

        // Simpan buku (tanpa kategori_ids)
        $buku = Buku::create(collect($validated)->except('kategori_ids')->toArray());

        // Hubungkan kategori lewat pivot
        $buku->kategoris()->sync($request->kategori_ids);

        return redirect()->route('buku.index')->with('success', 'Buku berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $buku      = Buku::with('kategoris')->findOrFail($id);
        $kategoris = Kategori::all();

        return view('admin.buku.edit', compact('buku', 'kategoris'));
    }

    public function update(Request $request, Buku $buku)
    {
        $request->validate([
            'kategori_ids'  => 'required|array|min:1',
            'kategori_ids.*'=> 'exists:kategoris,id',
            'judul'         => 'required',
            'penulis'       => 'required',
            'penerbit'      => 'required',
            'tahun_terbit'  => 'required|integer',
            'deskripsi'     => 'required',
            'stock'         => 'required|integer|min:0',
            'gambar'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->except(['kategori_ids', '_token', '_method']);

        // Upload gambar baru kalau ada
        if ($request->hasFile('gambar')) {
            if ($buku->gambar && file_exists(public_path('uploads/buku/' . $buku->gambar))) {
                unlink(public_path('uploads/buku/' . $buku->gambar));
            }
            $file        = $request->file('gambar');
            $namaFile    = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/buku'), $namaFile);
            $data['gambar'] = $namaFile;
        }

        $buku->update($data);

        // Update relasi kategori
        $buku->kategoris()->sync($request->kategori_ids);

        return redirect()->route('buku.index')->with('success', 'Buku berhasil diupdate');
    }

    public function destroy(Buku $buku)
    {
        if ($buku->gambar && file_exists(public_path('uploads/buku/' . $buku->gambar))) {
            unlink(public_path('uploads/buku/' . $buku->gambar));
        }

        // Hapus relasi pivot dulu
        $buku->kategoris()->detach();
        $buku->delete();

        return redirect()->route('buku.index')->with('success', 'Buku berhasil dihapus');
    }
}