<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Koleksi extends Model
{
    protected $fillable = ['user_id', 'buku_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }

    public function koleksis()
    {
        return $this->hasMany(Koleksi::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'koleksis');
    }
}
