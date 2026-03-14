<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $fillable = ['nama_kategori'];
    
    public function bukus() {
    return $this->belongsToMany(Buku::class, 'kategori_relasi', 'kategori_id', 'buku_id');
}
}
