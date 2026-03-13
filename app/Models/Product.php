<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['user_id', 'name', 'qty', 'price'];

    // Relasi ke User (Satu Product dimiliki oleh satu User)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Kategori (Satu Product bisa punya banyak Kategori)
    public function kategoris()
    {
        return $this->hasMany(Kategori::class);
    }
}
