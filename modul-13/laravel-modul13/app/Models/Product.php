<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    
    protected $fillable = ['name', 'price'];

    // Menandakan 1 Produk berhak memiliki banyak Varian
    public function variants()
    {
        return $this->hasMany(Variant::class);
    }
}
