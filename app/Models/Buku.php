<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Kategori;

class Buku extends Model
{
    protected $table = 'bukus';

    protected $fillable = [
        'judul',
        'penulis',
        'penerbit',
        'tahun_terbit',
        'deskripsi',
        'gambar',
        'stock',
    ];

    public function kategoris()
    {
        return $this->belongsToMany(Kategori::class, 'kategori_relasi', 'buku_id', 'kategori_id');
    }

    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class);
    }

    public function ulasans()
    {
        return $this->hasMany(Ulasan::class);
    }
}