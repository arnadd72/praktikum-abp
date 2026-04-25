<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Pendefinisian skema dengan tipe data presisi 
        // untuk mencegah anomali data
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            
            // Limitasi panjang karakter string (VARCHAR)
            $table->string('name', 150);
            
            // Integer default unsigned jika tidak ada harga negatif
            $table->unsignedInteger('price');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
