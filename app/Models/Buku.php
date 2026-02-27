<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Kategori;

class Buku extends Model
{
    protected $table = 'bukus';

    protected $fillable = [
        'kategori_id',
        'judul',
        'penulis',
        'penerbit',
        'tahun_terbit',
        'deskripsi',
        'gambar',
        'stock',
    ];
public function detail(Buku $buku)
{
    return view('pengguna.detail', compact('buku'));
}
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
        
    }

    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class);
    }
}
