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
    <strong>Arnanda Setya Nosa Putra</strong><br>
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
```
### 3.2 Lapisan Pengendali Keamanan (app/Http/Controllers/SiteController.php)
Memvalidasi masukan form login dengan standar eksekusi sistem bawaan (Auth Attempt).

```PHP
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SiteController extends Controller
{
    public function auth(Request $request)
    {
        // Limitasi input awal agar request tidak membebani memori
        $credentials = $request->validate([
            'email'    => 'required|email|max:150',
            'password' => 'required|string|min:6',
        ]);

        try {
            // Auth::attempt melakukan pencocokan hash Bcrypt di latar belakang
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                
                $request->session()->regenerate();
                
                // Menyimpan nama user ke session statis sebagai fallback/display
                session()->put('name', Auth::user()->name);
                
                return redirect()->intended('/product');
            }

            // Fallback apabila kredensial salah (tidak spesifik memberitahu mana yang salah)
            return redirect('/login')
                ->with('msg', 'Otentikasi gagal: Email atau Password tidak valid.');
                
        } catch (\Exception $e) {
            Log::error('Kesalahan Otentikasi Lintas Sistem: ' . $e->getMessage());
            return redirect('/login')->with('msg', 'Terjadi kesalahan internal server.');
        }
    }
}
```
### 3.3 Skema Migrasi Relasional (database/migrations/..._create_variants_table.php)
Membuat tabel detail produk yang dikunci secara struktural ke tabel induk.

```PHP
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
```
### 3.4 Representasi Model Relasional ORM
Model Product.php (Posisi Induk):

```PHP
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
```
Model Variant.php (Posisi Anak):

```PHP
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
```
### 3.5 Pembaruan Layout Template Induk (resources/views/template.blade.php)
Menggunakan directive Blade @auth untuk mendeteksi visibilitas menu berdasarkan sesi.

```HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link 
        href="[https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css](https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css)" 
        rel="stylesheet"
    >
</head>
<body class="bg-light" style="width: 95%; margin: 0 auto;">

    @auth
        <div class="row justify-content-end mt-4 mb-2">
            <div class="col-md-4 text-end">
                <span class="fw-bold me-3 text-secondary">
                    Selamat datang, {{ Auth::user()->name }}
                </span>
                <a href="{{ route('logout') }}" class="btn btn-sm btn-danger shadow-sm">
                    Logout Keamanan
                </a>
            </div>
        </div>
    @endauth

    <div class="row justify-content-center mt-3">
        @yield('content')
    </div>

    <script 
        src="[https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js](https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js)">
    </script>
</body>
</html>
```
### 3.6 Modifikasi Tampilan Tabel dengan Nested Data (resources/views/products/index.blade.php)
Menarik data relasional secara dinamis dari Model ke layar antarmuka pengguna.

```HTML
<table class="table table-hover table-bordered m-0 bg-white">
    <thead class="table-dark">
        <tr>
            <th>Nama Produk Utama</th>
            <th>Harga (Rp)</th>
            <th>Spesifikasi Varian Terkait</th>
            <th class="text-center">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($products as $d)
        <tr>
            <td class="align-middle fw-bold">{{ $d->name }}</td>
            <td class="align-middle">{{ number_format($d->price, 0, ',', '.') }}</td>
            
            <td class="align-middle">
                <ul class="mb-0 text-muted" style="font-size: 0.9em;">
                    @foreach ($d->variants as $var)
                        <li class="mb-2">
                            <strong class="text-dark">{{ $var->name }}</strong><br>
                            Processor: {{ $var->processor }} <br>
                            RAM: {{ $var->memory }} | Storage: {{ $var->storage }} <br>
                            <span class="fst-italic">{{ $var->description }}</span>
                        </li>
                    @endforeach
                </ul>
            </td>
            
            <td class="align-middle text-center">
                </td>
        </tr>
        @endforeach
    </tbody>
</table>
```

HASIL TAMPILAN WEB (OUTPUT)
Berikut adalah dokumentasi tangkapan layar (screenshot) implementasi operasi keamanan logikal dan pemanggilan kerangka data berelasi (Database Relational Mapping):

1. Tampilan Halaman Login (Proteksi Awal)
Deskripsi: Menampilkan form masuk yang wajib diisi. Apabila URL /product dipaksa diakses tanpa sesi, pengguna akan selalu terpantul ke halaman ini oleh Middleware.
<img width="1330" height="602" alt="Screenshot 2026-04-25 142259" src="https://github.com/user-attachments/assets/1ddd46d0-ccfa-4f40-80bc-09fabfe28919" />


2. Tampilan Header Auth di Layout Global
Deskripsi: Visualisasi directive @auth yang berhasil mengidentifikasi nama user yang sedang login beserta ketersediaan tombol eksekusi "Logout Keamanan".
<img width="606" height="160" alt="Screenshot 2026-04-25 142249" src="https://github.com/user-attachments/assets/80c1c6db-a1eb-4505-babc-fde25cdc37a9" />

3. Tampilan Halaman Daftar Produk & Varian (One-to-Many Output)
Deskripsi: Visualisasi dari arsitektur Object-Relational Mapping yang merender kumpulan atribut turunan variants langsung berdampingan dengan entitas induk products secara struktural.
<img width="1836" height="770" alt="Screenshot 2026-04-25 142213" src="https://github.com/user-attachments/assets/5eea1a00-80e9-44b6-a1d8-a4c118fc9db5" />


# TUGAS PERTEMUAN 8
1. jelaskan tentang git branch 
 - apa itu git branch 
- buatlah git branch dengan 2 akun berbeda dan hubungkan dengan project yang di buat di tugas 2 ( bisa dengan antar teman kelas 
- kalian jelaskan apa saja fungsi nya dan apa keuntungan git branch 
- buat juga output dan input apa saja yang dapat kalian lakukan mengunakan git branch
2. buatlah website ( bisa mengunakan website yang di gunnakan dalam tubes ) , lalu tambahkan database yang terhubung dengan local house 
## JAWAB
### 1. git branch

  - Git branch adalah fitur dalam Git yang berfungsi menciptakan ruang kerja terpisah (cabang) dari repositori utama (main/master). Ini memungkinkan pengembang bereksperimen, memperbaiki     bug, atau menambahkan fitur baru tanpa memengaruhi kode utama yang stabil. Branch bertindak sebagai pointer ringan yang bergerak otomatis setiap ada commit.

    ### MEMBUAT GIT BRANCH DENGAN 2 AKUN BERBEDA
  <img width="589" height="349" alt="Screenshot 2026-04-27 005946" src="https://github.com/user-attachments/assets/acacfba8-6521-4e6d-9ca0-61025ef824ca" />

  - Fungsi dan Keuntungan Git Branch
    - Fungsi Utama:
  Isolasi Kode: Memisahkan pekerjaan yang sedang berjalan dari kode utama yang sudah stabil (production-ready).
  Kolaborasi Tim: Memungkinkan banyak developer mengerjakan fitur yang berbeda-beda di dalam satu proyek yang sama pada waktu yang bersamaan.
  Manajemen Rilis: Memisahkan versi aplikasi (misalnya: branch untuk development, testing, dan production).

    - Keuntungan Menggunakan Git Branch:
    Aman dari Error Fatal: Jika kodingan di branch baru ternyata error atau berantakan, kode di branch utama (main) tidak akan terpengaruh sama sekali.
    Pengembangan Paralel: Kamu dan temanmu bisa bekerja di detik yang sama, mengedit file yang sama, tanpa harus saling tunggu.
    Code Review Lebih Rapi: Memudahkan proses pengecekan kode sebelum digabungkan (biasanya melalui proses Pull Request / Merge Request).
    Mudah Berpindah Konteks: Kamu bisa lompat dari mengerjakan "Fitur A" ke "Perbaikan Bug B" hanya dengan berganti branch, tanpa perlu membuat folder project baru di laptop.
    
  - ### 1. Input (Perintah & Argumen)
Input merujuk pada variasi perintah yang dimasukkan melalui terminal untuk mengelola percabangan:
| Perintah | Deskripsi |
| :--- | :--- |
| `git branch <nama_branch>` | Membuat branch baru sebagai jalur pengembangan terpisah. |
| `git branch` | Menampilkan daftar semua branch yang ada di lokal. |
| `git branch -d <nama_branch>` | Menghapus branch yang sudah tidak digunakan (setelah di-merge). |
| `git branch -m <nama_baru>` | Mengubah nama branch yang sedang aktif. |
| `git branch -a` | Melihat semua branch, termasuk yang ada di server remote (GitHub). |
| `git branch -v` | Menampilkan daftar branch beserta detail commit terakhirnya. |
### 2. Output (Hasil Pengoperasian)
Output adalah hasil atau informasi yang ditampilkan oleh Git setelah perintah dijalankan:
*   **Daftar Nama Branch**: Menampilkan teks daftar branch, di mana branch yang aktif ditandai dengan tanda bintang (`*`) dan warna hijau.
*   **Pemisahan Kode (Isolasi)**: Secara fungsional, kode di dalam folder project akan "terpisah". Perubahan di satu branch tidak akan memengaruhi branch lainnya sampai dilakukan proses merging.
*   **Konfirmasi Status**: Pesan sistem yang memberikan informasi sukses (seperti *"Deleted branch..."*) atau pesan error (seperti *"branch not merged"*).
*   **Visualisasi Sejarah (Graph)**: Jika digabung dengan perintah `git log --graph`, outputnya berupa bagan alur yang menunjukkan sejarah percabangan dan penggabungan kode.
### 2. Website
# 🔥 Sistem Manajemen Inventaris Gudang Sembako (Tugas 8)

Proyek ini dibangun menggunakan **Laravel 11** dan ditujukan untuk mengimplementasikan manajemen basis data relasional (MySQL) dengan skema autentikasi komprehensif dari bawaan **Laravel Breeze**. 

Aplikasi ini dikhususkan untuk toko retail/gudang dan telah di-desain menggunakan **Tailwind CSS** untuk menawarkan *User Experience* (UX) premium melalui desain *Glassmorphism*, palet gradien profesional, dan visualisasi *Dashboard* interaktif.

## 🚀 Fitur Unggulan
1. **Keamanan Ekstra (Laravel Breeze):** Sistem pendataan terkunci sepenuhnya; orang tak dikenal tidak dapat mengintip stok barang jika tidak melakukan otentikasi login terlebih dahulu.
2. **Dashboard HUD (Heads-up Display):** Menampilkan rekapitulasi Total Produk, Kalkulasi Nilai Estimasi Aset Rupiah, dan Batas Stok Minimum.
3. **Peringatan Kondisi Stok Menipis:** Jika unit sembako berada di bawah batas tertentu (<10 barang), indikator merah berkedip peringatan krisis langsung menyala.
4. **Antarmuka Kosmetik Premium:** Desain khusus dengan manipulasi grid asimetris Tailwind, *backdrop-blur*, kompilasi kelas terenkapsulasi oleh Vite, hingga manipulasi kartu barang animasi.

---

## 💻 Source Code Inti Sistem
*Berikut adalah representasi kode esensial (MVC) yang digunakan di dalam `modul-13/tugas-8`.*

### 1. File Konfigurasi Lintas Server (`.env`)
Diatur pada modul ini agar merujuk ke layanan **MySQL Laragon** dengan basis data `sembako_db`.

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sembako_db
DB_USERNAME=root
DB_PASSWORD=cilacap
```
### 2. Algoritme Pengendali Rute (routes/web.php)
Mengarahkan tamu aplikasi langsung ke landing page, sementara kontrol manajemen dilindungi berlapis oleh alias validasi auth.

```php
<?php
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
Route::get('/', function () {
    return view('welcome');
});
// Alias masuk dasbor dialihkan langsung otomatis ke Menu Sembako
Route::get('/dashboard', function () {
    return redirect()->route('product.index');
})->middleware(['auth', 'verified'])->name('dashboard');
// CRUD Products dikunci Auth Session
Route::middleware('auth')->group(function () {
    Route::resource('product', ProductController::class);
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
require __DIR__.'/auth.php';
```
### 3. Migrasi DDL Database (database/migrations/..._create_products_table.php)
Mendefinisikan skema kolom pendataan barang sembako langsung ke MariaDB/MySQL.

```php
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('category');
            $table->integer('price');
            $table->integer('stock');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
```
### 4. Pelindung Mass-Assignment (app/Models/Product.php)
Entitas objek model yang bertanggung jawab memvalidasi field mana saja yang diizinkan mendapat perintah Create massal.

```php
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'category',
        'price',
        'stock',
        'description'
    ];
}
```
### 5. Controller Logika Bisnis (app/Http/Controllers/ProductController.php)
Menghubungkan Interface (Views) dengan basis data melalui penguraian input form yang kokoh (validated request).

```php
<?php
namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;
class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->get();
        return view('product.index', compact('products'));
    }
    public function create()
    {
        return view('product.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'category' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'description' => 'nullable',
        ]);
        Product::create($request->all());
        return redirect()->route('product.index')->with('success', 'Pencatatan inventaris sembako berhasil diterapkan!');
    }
    public function edit(Product $product)
    {
        return view('product.edit', compact('product'));
    }
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required',
            'category' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'description' => 'nullable',
        ]);
        $product->update($request->all());
        return redirect()->route('product.index')->with('success', 'Data harga/stok berhasil diselaraskan dengan server.');
    }
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('product.index')->with('success', 'Barang terkait berhasil diturunkan dari etalase gudang.');
    }
}
```
### 6. Tampilan Tabel Dasbor Premium (resources/views/product/index.blade.php)
Visualisasi terpadu perihal statistik gudang lengkap dengan badge list unik Tailwind CSS. (Karena terlalu panjang, ini adalah ringkasan inti visualnya)

```html
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                📦 Manajemen Inventaris Sembako
            </h2>
            <a href="{{ route('product.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-emerald-600 to-green-500 rounded-xl text-white font-medium shadow-xl hover:scale-105">
                Tambah Produk
            </a>
        </div>
    </x-slot>
    <div class="py-8 max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        <!-- Summary Cards Layout -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-2xl p-6 flex items-center gap-4">
                <p>Total Produk: <strong>{{ count($products) }} Items</strong></p>
            </div>
            <div class="bg-white rounded-2xl p-6 flex items-center gap-4">
                <p>Estimasi Aset: <strong>Rp{{ number_format((float)($products->sum(function($p) { return $p->price * $p->stock; })), 0, ',', '.') }}</strong></p>
            </div>
        </div>
        <!-- Tabel Render Area -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
            <table class="min-w-full divide-y divide-gray-100">
                <thead class="bg-gray-50/50">
                    <tr>
                        <th>NAMA BARANG</th>
                        <th>KATEGORI</th>
                        <th>HARGA</th>
                        <th>STOK</th>
                        <th>AKSI</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-50">
                    @forelse ($products as $p)
                        <tr class="hover:bg-emerald-50/30">
                            <td>{{ $p->name }} <br> <small>{{ $p->description }}</small></td>
                            <td><span class="badge {{ $p->category }}">{{ $p->category }}</span></td>
                            <td>Rp {{ number_format($p->price, 0, ',', '.') }}</td>
                            <td>
                                <span class="{{ $p->stock < 10 ? 'text-red-500' : 'text-emerald-600' }}">{{ $p->stock }}</span>
                                @if($p->stock < 10) <small class="text-red-500 animate-pulse">Limit</small> @endif
                            </td>
                            <td>
                                <a href="{{ route('product.edit', $p->id) }}">Edit</a>
                                <form action="{{ route('product.destroy', $p->id) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="submit">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center">Inventaris Sembako Kosong.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
```

## OUTPUT WEBSITE (SS)
### 1. landing page
<img width="1787" height="950" alt="Screenshot 2026-04-25 150524" src="https://github.com/user-attachments/assets/e3df95bb-8660-4b70-95ff-8f0abb327bb6" />

### 2. Register
<img width="1290" height="952" alt="Screenshot 2026-04-25 150551" src="https://github.com/user-attachments/assets/c2e39fbb-9f27-4337-8d19-a540bc55fb87" />

### 3. Login
<img width="1304" height="847" alt="Screenshot 2026-04-25 150540" src="https://github.com/user-attachments/assets/a3e77e5c-27b3-4452-b093-40b90ea39e46" />

### 4. Dashboard admin
<img width="1426" height="962" alt="Screenshot 2026-04-25 150928" src="https://github.com/user-attachments/assets/d72102e5-bffe-4e89-82e2-f3fc829c587a" />

### 5. Tambah Data
<img width="1534" height="973" alt="Screenshot 2026-04-25 150627" src="https://github.com/user-attachments/assets/9f8c1938-c906-43d0-8415-e085da4d85e3" />

### 6. Edit Data
<img width="1300" height="970" alt="Screenshot 2026-04-25 150942" src="https://github.com/user-attachments/assets/653dc574-71e1-4dc2-b5b8-bf5fc05c4bbb" />
