<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * Menerapkan filter keamanan tingkat tinggi.
     * Hanya field di bawah ini yang dapat dimanipulasi
     * melalui metode Model::create() atau update().
     * Mencegah injeksi manipulasi field secara tidak sah.
     */
    protected $fillable = [
        'name', 
        'price'
    ];
}
