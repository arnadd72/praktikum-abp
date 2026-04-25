<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('variants', function (Blueprint $table) {
            $table->id();
            
            // Atribut Variabel
            $table->string('name', 100);
            $table->text('description')->nullable();
            $table->string('processor', 100);
            $table->string('memory', 50);
            $table->string('storage', 50);
            
            // Relasi Foreign Key dengan referensi tabel `products`
            // onDelete('cascade') opsional: jika produk dihapus, variannya terhapus otomatis
            $table->foreignId('product_id')
                  ->constrained('products')
                  ->onDelete('cascade');
                  
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('variants');
    }
};
