<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Variant extends Model
{
    use HasFactory;
    
    // Melindungi Mass-Assignment
    protected $fillable = [
        'name', 'description', 'processor', 
        'memory', 'storage', 'product_id'
    ];

    // Menandakan spesifikasi Varian ini merupakan milik 1 Produk mutlak
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
