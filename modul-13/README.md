<div align="center">
  <br />

  <h1>LAPORAN PRAKTIKUM <br>
  APLIKASI BERBASIS PLATFORM
  </h1>

  <br />

  <h3>MODUL - 13<br>
  LARAVEL: DATABASE 2 (AUTH, MIDDLEWARE & RELATIONS)
  </h3>

  <br />

  <img width="250" alt="Logo Tel-U" src="https://github.com/user-attachments/assets/22ae9b17-5e73-48a6-b5dd-281e6c70613e" />

  <br />
  <br />
  <br />

  <h3>Disusun Oleh :</h3>

  <p>
    <strong>Yasvin Syahgana</strong><br>
    <strong>2311102180</strong><br>
    <strong>S1 IF-11-04</strong>
  </p>

  <br />

  <h3>Dosen Pengampu :</h3>

  <p>
    <strong>Cahyo Prihantoro, S.Kom., M.Eng.</strong>
  </p>
  
  <br />

  <h3>LABORATORIUM HIGH PERFORMANCE
  <br>FAKULTAS INFORMATIKA <br>UNIVERSITAS TELKOM PURWOKERTO <br>2026</h3>
</div>

<hr>

# Dasar Praktikum
Pada praktikum modul 13 ini, fokus pengembangan bergeser menuju eskalasi keamanan akses dan perancangan arsitektur *database* yang lebih kompleks. Mahasiswa ditugaskan untuk mengimplementasikan sistem *Authentication* (Login/Logout), manajemen sesi (*Session*), pembatasan akses (*Middleware*), serta menghubungkan antar-entitas data menggunakan skema relasi *One-to-Many* melalui Eloquent ORM di *framework* Laravel.

# Dasar Teori

## 1.1 Manajemen Session
*Session* adalah mekanisme penyimpanan data sementara di sisi server yang terikat pada interaksi pengguna tertentu. Laravel mendukung dua tipe sesi:
* **Session Reguler:** Bertahan selama sesi peramban aktif atau hingga waktu kedaluwarsa habis (misal: menyimpan status login, nama *user*).
* **Session Flash:** Hanya bertahan untuk satu siklus *HTTP Request* berikutnya sebelum otomatis terhapus (misal: notifikasi *success/error* saat *redirect*).

## 1.2 Keamanan Berlapis via Middleware & Auth
*Middleware* berfungsi sebagai pos pemeriksaan (*checkpoint*) yang menyaring setiap *HTTP Request* yang masuk. Jika suatu *route* diproteksi *Middleware Auth*, pengguna yang belum melalui proses otentikasi akan otomatis ditolak dan diarahkan ke halaman *Login*. Proses validasi kredensial sendiri difasilitasi oleh `Auth` *facade*, sebuah pustaka terintegrasi Laravel yang memvalidasi *email* dan *password* yang telah terenkripsi (di-*hash* menggunakan algoritma *Bcrypt*).

## 1.3 Model Relasi (Eloquent Relationships)
Aplikasi tingkat lanjut tidak mungkin berdiri hanya dengan tabel-tabel terisolasi. Laravel Eloquent menyederhanakan *Join* antar tabel menggunakan *Object-Oriented syntax*. Konsep *One-to-Many* (Satu-ke-Banyak) diterapkan di sini; di mana satu objek `Product` dapat memiliki banyak objek `Variant` (dikendalikan dengan `hasMany`), sedangkan setiap `Variant` dipastikan hanya merujuk pada satu `Product` secara spesifik (dikendalikan dengan `belongsTo`). 

---

# PENGERJAAN & IMPLEMENTASI SISTEM

Penerapan pada modul ini menitikberatkan pada perancangan logika keamanan di sisi server dan interkoneksi entitas data agar tetap solid meski diakses oleh berbagai profil *user*.

## 2.1 Skema Autentikasi
Akses ke menu pengelolaan produk kini dikunci sepenuhnya. 

| Komponen | Implementasi Logika |
| --- | --- |
| **Routing** | URL `/product` disematkan `->middleware('auth')`. Pemanggilan *route* login diberi nama alias `name('login')` sebagai rujukan standar *Middleware*. |
| **Pengecekan (Auth::check)** | Jika *user* sudah masuk, URL `/login` akan langsung memantulkannya ke *dashboard* produk untuk mencegah *bypass* logika. |
| **Otentikasi (Auth::attempt)** | Membandingkan secara aman *input* *form* dengan *hash Bcrypt* yang tersimpan di basis data tanpa perlu mendeskripsi *password* secara paksa. |

## 2.2 Relasi Entitas Database (One-to-Many)
Tabel pendukung `variants` dibuat dengan menjaga integritas data menggunakan `foreignId` yang dirangkai dengan `constrained()`. Parameter ini memastikan pada level RDBMS bahwa *ID* produk yang disematkan ke dalam varian benar-benar ada di tabel referensi. Pemanggilan data varian ke antarmuka juga dieksekusi secara efisien menggunakan pendekatan hierarki objek di Blade.

---

## 3. Source Code Praktikum

> **Catatan Engineer:** Desain sistem relasional dan autentikasi wajib mematuhi standar *Clean Architecture*. Kode di bawah memastikan proteksi ketat pada *route*, penggunaan koneksi *database* secara bijak, dan limitasi penulisan sintaks agar ramah pada monitor portabel (14 inci).

### 3.1 Perlindungan Rute (Routing - `routes/web.php`)
Pengaturan alur lalu lintas *request*, mendaftarkan fungsi otentikasi, serta memberikan tameng *middleware* pada rute esensial.

```php
<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\ProductController;

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