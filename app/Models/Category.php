<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'category';

    protected $fillable = ['name'];

    // Satu Category memiliki banyak Product
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // Hitung total product
    public function totalProduct()
    {
        return $this->products()->count();
    }
}
