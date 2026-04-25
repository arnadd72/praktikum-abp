<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return redirect('/product');
});

// Rute Tampilan Login dengan pengecekan sesi aktif
Route::get('/login', function () {
    if (Auth::check()) {
        return redirect('/product');
    }
    return view('login');
})->name('login');

// Rute Eksekusi Login (Submit Form)
Route::post('/login', [SiteController::class, 'auth'])->name('login.post');

// Rute Pemusnahan Sesi (Logout)
Route::get('/logout', function () {
    Auth::logout();
    
    // Invalidate sesi secara total guna memitigasi Session Fixation Attack
    session()->invalidate();
    session()->regenerateToken();
    
    return redirect('/login');
})->name('logout');

// Rute CRUD Product diproteksi penuh oleh Middleware Auth
Route::resource('product', ProductController::class)->middleware('auth');
