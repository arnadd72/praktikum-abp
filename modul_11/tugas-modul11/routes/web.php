<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MahasiswaController;

// Route untuk menampilkan halaman web
Route::get('/', [MahasiswaController::class, 'index']);

// Route API internal untuk mengambil data dengan AJAX
Route::get('/api/mahasiswa', [MahasiswaController::class, 'getMahasiswa']);
