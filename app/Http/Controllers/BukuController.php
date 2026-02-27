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
    
    $bukus = Buku::with('kategori')
        ->when($search, function($query, $search) {
            return $query->where('judul', 'like', "%{$search}%")
                        ->orWhere('penulis', 'like', "%{$search}%")
                        ->orWhere('penerbit', 'like', "%{$search}%")
                        ->orWhereHas('kategori', function($q) use ($search) {
                            $q->where('nama_kategori', 'like', "%{$search}%");
                        });
        })
        ->paginate(4); // Ubah dari ->get() jadi ->paginate(5)
        
    $kategoris = Kategori::all();

    return view('admin.buku.buku', compact('bukus', 'kategoris'));
}
    // form tambah buku
    public function create()
    {
        $kategoris = Kategori::all(); // ambil kategori lama
        return view('admin.buku.create', compact('kategoris'));
    }

    // simpan buku
   public function store(Request $request)
{
    // Validasi
    $validated = $request->validate([
        'kategori_id' => 'required',
        'judul' => 'required',
        'penulis' => 'required',
        'penerbit' => 'required',
        'tahun_terbit' => 'required|numeric',
        'stock' => 'required|numeric',
        'deskripsi' => 'required',
        'gambar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    // Upload gambar
    if ($request->hasFile('gambar')) {
        $file = $request->file('gambar');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/buku'), $filename);
        $validated['gambar'] = $filename;
    }

    // Simpan data
    Buku::create($validated);

    // PENTING: Redirect ke route buku.index
    return redirect()->route('buku.index')->with('success', 'Buku berhasil ditambahkan!');
}

public function update(Request $request, Buku $buku)
{
    $request->validate([
        'kategori_id'   => 'required|exists:kategoris,id',
        'judul'         => 'required',
        'penulis'       => 'required',
        'penerbit'      => 'required',
        'tahun_terbit'  => 'required|integer',
        'deskripsi'     => 'required',
        'stock'         => 'required|integer|min:0',
        'gambar'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $data = $request->all();

    // kalau upload gambar baru
    if ($request->hasFile('gambar')) {

        // hapus gambar lama kalau ada
        if ($buku->gambar && file_exists(public_path('uploads/buku/' . $buku->gambar))) {
            unlink(public_path('uploads/buku/' . $buku->gambar));
        }

        $file = $request->file('gambar');
        $namaFile = time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads/buku'), $namaFile);

        $data['gambar'] = $namaFile;
    }

    

    $buku->update($data);

    return redirect()->route('buku.index')->with('success', 'Buku berhasil diupdate');
}
// Tambahkan method ini di BukuController.php

public function edit($id)
{
    $buku = Buku::findOrFail($id);
    $kategoris = Kategori::all();
    
    return view('admin.buku.edit', compact('buku', 'kategoris'));
}
public function destroy(Buku $buku)
{
    // hapus gambar kalau ada
    if ($buku->gambar && file_exists(public_path('uploads/buku/' . $buku->gambar))) {
        unlink(public_path('uploads/buku/' . $buku->gambar));
    }

    $buku->delete();

    return redirect()->route('buku.index')
        ->with('success', 'Buku berhasil dihapus');
}

}
