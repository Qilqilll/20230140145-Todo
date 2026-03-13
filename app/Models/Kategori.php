<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $fillable = ['product_id', 'name'];

    // Relasi ke Product (Satu Kategori dimiliki oleh satu Product)
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
