<div align="center">
  <br />

  <h1>LAPORAN PRAKTIKUM <br>
  APLIKASI BERBASIS PLATFORM
  </h1>

  <br />

  <h3>MODUL - 12<br>
  LARAVEL: DATABASE 1 (CRUD)
  </h3>

  <br />

  <img width="250" alt="Logo Tel-U" src="https://github.com/user-attachments/assets/22ae9b17-5e73-48a6-b5dd-281e6c70613e" />

  <br />
  <br />
  <br />

  <h3>Disusun Oleh :</h3>

  <p>
    <strong>Arnanda setya nosa putra</strong><br>
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
Pada praktikum modul 12 ini, mahasiswa ditugaskan untuk mengimplementasikan fungsionalitas manajemen *database* secara dinamis menggunakan *framework* Laravel. Praktikum ini berfokus pada penerapan sistem CRUD (*Create, Read, Update, Delete*) melalui arsitektur MVC (*Model-View-Controller*). Sebagai studi kasus, aplikasi yang dibangun merupakan simulasi manajemen katalog *e-commerce*, di mana mahasiswa melakukan manipulasi data secara langsung terhadap tabel entitas `products` dengan standar keamanan *form validation* dan operasi *database* berbasis *Object-Relational Mapping* (ORM).

# Dasar Teori

## 1.1 Konfigurasi Database & Skema
Langkah pertama agar aplikasi web dapat terhubung ke *Database Management System* (DBMS) adalah melalui pengaturan konfigurasi di berkas *environment* (`.env`). Laravel memusatkan kredensial sensitif di luar *source code* utama. Selain itu, Laravel menggunakan fitur *Migration* sebagai *version control* untuk skema *database*, yang memungkinkan pembuatan dan modifikasi tabel secara terstruktur lewat kode PHP tanpa harus mengeksekusi SQL manual.

## 1.2 Model & Eloquent ORM
Laravel menyediakan tiga opsi interaksi *database*: *Raw SQL*, *Query Builder*, dan *Eloquent ORM*. Eloquent adalah ORM bawaan yang memetakan tabel *database* menjadi objek PHP (*Model*). Eloquent memiliki fitur keamanan bawaan bernama *Mass Assignment Protection*. Mekanisme ini mewajibkan pengembang mendefinisikan *property* `$fillable` untuk menentukan secara eksplisit kolom mana saja yang diizinkan menerima *input* dari *user*, sehingga mencegah manipulasi kolom sensitif (seperti `id` atau `role_admin`).

## 1.3 Controller
Dalam arsitektur MVC Laravel, *Controller* menangani alur logika mulai dari penerimaan HTTP *Request*, validasi *input* data (termasuk tipe data dan restriksi panjang karakter), berinteraksi dengan *Model* untuk pengolahan *database*, hingga memberikan balikan data (*Response*) ke tampilan antarmuka. 

## 1.4 View & Templating (Blade)
*View* merupakan lapisan representasi antarmuka yang menggunakan *engine* **Blade**. Blade memiliki kemampuan *templating* menggunakan *directive* seperti `@extends`, `@section`, dan `@yield`. Pendekatan ini memungkinkan pembuatan satu struktur *layout* utama yang dapat digunakan kembali (*reusable*) oleh halaman lain, sehingga kode HTML menjadi efisien dan mudah dikelola.

---

# PENGERJAAN & IMPLEMENTASI SISTEM

Pada proyek ini, dibangun antarmuka manajemen produk *e-commerce* dengan keamanan ketat untuk menangkis celah kerentanan seperti *SQL Injection*, *Cross-Site Scripting* (XSS), dan *Cross-Site Request Forgery* (CSRF).

## 2.1 Arsitektur Data & Alur
Aplikasi menggunakan tabel `products` dengan atribut relasional `name` (string) dan `price` (integer). 

| Tahapan Operasi | Keterangan Implementasi |
| --- | --- |
| **Koneksi Database** | Mengubah parameter `DB_DATABASE`, `DB_USERNAME`, dan `DB_PASSWORD` pada `.env`. |
| **Migration** | Menjalankan `php artisan make:migration create_products_table` dan mendefinisikan struktur kolom. |
| **Model Security** | Menambahkan `protected $fillable = ['name', 'price'];` di dalam kelas `Product`. |
| **Validasi & CRUD** | `ProductController` memastikan input telah dibersihkan sebelum disimpan ke *database*, menggunakan validasi bawaan HTTP *Request*. |
| **Blade Templating** | Menyusun struktur hierarki antara `template.blade.php`, `index.blade.php`, dan `form.blade.php`. Mengimplementasikan `@csrf` di setiap *form*. |

## 2.2 Standardisasi Keamanan (Security Best Practices)
* **CSRF Protection:** Laravel secara otomatis mengamankan permintaan jenis POST/PUT/DELETE melalui token rahasia (directive `@csrf`).
* **XSS Protection:** Penggunaan `{{ $data }}` pada Blade secara otomatis mengeksekusi fungsi *htmlentities()*, mengamankan tampilan dari injeksi *script* berbahaya.
* **Input Validation:** Validasi di lapis *Controller* secara ketat (`required|min|max`) sebelum data menembus *Model*.

---

## 3. Source Code Praktikum


### 3.1 Konfigurasi *Environment* (`.env`)
Modifikasi pada bagian koneksi ke MySQL/MariaDB:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ecommerce
DB_USERNAME=root
DB_PASSWORD=
DB_CHARSET=utf8mb4
DB_COLLATION=utf8mb4_unicode_ci
```
### 3.2 File Migration (database/migrations/..._create_products_table.php)
Mendefinisikan skema secara aman.

```PHP
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
```
### 3.3 Model Eloquent (app/Models/Product.php)
Penentuan perlindungan Mass Assignment.

```PHP
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
```
### 3.4 Controller (app/Http/Controllers/ProductController.php)
Diimplementasikan pembatasan validasi ketat, pengelolaan respons, dan penulisan baris yang ramah baca pada layar kecil.

```PHP
<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function index()
    {
        // Mengambil keseluruhan data dari database secara aman
        $products = Product::all();
        
        return view('products.index', [
            'products' => $products
        ]);
    }

    public function create()
    {
        return view('products.form', [
            'title'   => 'Tambah',
            'product' => new Product(),
            'route'   => route('products.store'),
            'method'  => 'POST',
        ]);
    }

    public function store(Request $request)
    {
        // Proteksi Lapis Pertama: Filter validasi input ekstensif
        $validated = $request->validate([
            'name'  => 'required|string|min:4|max:100',
            'price' => 'required|integer|min:1000000',
        ]);

        try {
            // Proteksi Lapis Kedua: Mass-assignment berbasis fillable
            Product::create($validated);

            return redirect()
                ->route('products.index')
                ->with('success', 'Produk berhasil ditambahkan.');
                
        } catch (\Exception $e) {
            // Log ke sistem, jangan melempar SQL trace ke sisi client
            Log::error('Product creation failed: ' . $e->getMessage());
            
            return back()
                ->withInput()
                ->with('error', 'Terjadi kegagalan sistem penyimpanan.');
        }
    }

    public function edit(Product $product)
    {
        // Data binding Eloquent akan otomatis mencari objek
        // berdasarkan parameter ID pada URI.
        return view('products.form', [
            'title'   => 'Edit',
            'product' => $product,
            'route'   => route('products.update', $product),
            'method'  => 'PUT',
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name'  => 'required|string|min:4|max:100',
            'price' => 'required|integer|min:1000000',
        ]);

        try {
            $product->update($validated);

            return redirect()
                ->route('products.index')
                ->with('success', 'Produk berhasil diperbarui.');
                
        } catch (\Exception $e) {
            Log::error('Product update failed: ' . $e->getMessage());
            
            return back()
                ->withInput()
                ->with('error', 'Pembaruan data produk gagal.');
        }
    }

    public function destroy(Product $product)
    {
        try {
            $product->delete();

            return redirect()
                ->route('products.index')
                ->with('success', 'Produk berhasil dihapus permanen.');
                
        } catch (\Exception $e) {
            Log::error('Product deletion failed: ' . $e->getMessage());
            
            return redirect()
                ->route('products.index')
                ->with('error', 'Data tidak dapat dihapus.');
        }
    }
}
```
### 3.5 Layout Template Induk (resources/views/template.blade.php)
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

    @yield('content')

    <script 
        src="[https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js](https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js)">
    </script>
</body>
</html>
```
### 3.6 Tampilan Daftar Produk (resources/views/products/index.blade.php)
```HTML
@extends('template')

@section('title', 'Daftar Produk')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            @if (session('success'))
                <div class="alert alert-success shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="m-0 text-secondary">Manajemen Produk</h4>
                <a 
                    href="{{ route('products.create') }}" 
                    class="btn btn-primary shadow-sm"
                >
                    + Tambah Data
                </a>
            </div>

            <div class="card shadow-sm border-0">
                <table class="table table-hover table-striped m-0">
                    <thead class="table-dark">
                        <tr>
                            <th>Nama Produk</th>
                            <th>Harga (Rp)</th>
                            <th class="text-center">Aksi Manajemen</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                        <tr>
                            <td class="align-middle">{{ $product->name }}</td>
                            <td class="align-middle">{{ $product->price }}</td>
                            <td class="text-center">
                                <a 
                                    href="{{ route('products.edit', $product->id) }}" 
                                    class="btn btn-sm btn-outline-primary"
                                >
                                    Ubah
                                </a>
                                
                                <form 
                                    method="POST" 
                                    action="{{ route('products.destroy', $product->id) }}" 
                                    style="display: inline;" 
                                    onsubmit="return confirm('Hapus permanen produk ini?')"
                                >
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
@endsection
```
### 3.7 Tampilan Form Terpadu (resources/views/products/form.blade.php)
```HTML
@extends('template')

@section('title', 'Form ' . $title . ' Produk')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow border-0">
                <div class="card-header bg-dark text-white">
                    <h5 class="m-0">Form {{ $title }} Produk Utama</h5>
                </div>
                <div class="card-body">
                    
                    <form method="POST" action="{{ $route }}">
                        @csrf
                        
                        @if ($method === 'PUT')
                            @method('PUT')
                        @endif

                        <div class="mb-3">
                            <label for="name" class="form-label fw-bold">
                                Nama Produk
                            </label>
                            <input 
                                type="text" 
                                name="name" 
                                id="name" 
                                class="form-control @error('name') is-invalid @enderror" 
                                value="{{ old('name', $product->name) }}"
                                autocomplete="off"
                            >
                            @error('name')
                                <div class="invalid-feedback fw-semibold">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="price" class="form-label fw-bold">
                                Harga Kompetitif (Rupiah)
                            </label>
                            <input 
                                type="number" 
                                name="price" 
                                id="price" 
                                class="form-control @error('price') is-invalid @enderror" 
                                value="{{ old('price', $product->price) }}"
                            >
                            @error('price')
                                <div class="invalid-feedback fw-semibold">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success fw-bold">
                                {{ $title == 'Tambah' ? 'Simpan Baru' : 'Perbarui Data' }}
                            </button>
                            <a 
                                href="{{ route('products.index') }}" 
                                class="btn btn-outline-secondary"
                            >
                                Kembali
                            </a>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
```

HASIL TAMPILAN WEB (OUTPUT)
Berikut adalah dokumentasi tangkapan layar (screenshot) implementasi operasi keamanan lapis database dan manipulasi UI menggunakan fungsionalitas CRUD di framework Laravel:

1. Tampilan Halaman View (Awal)
Deskripsi: Menampilkan struktur tabel produk utama dengan status direktori kosong sebelum diisi data. Rute URI: http://localhost:8000/products.


2. Tampilan Halaman Form Tambah Produk
Deskripsi: Antarmuka terproteksi CSRF untuk memasukkan entitas data "Laptop" beserta limitasi harganya. Terdapat indikator peringatan divalidasi langsung oleh Controller. Rute URI: http://localhost:8000/products/create.

3. Tampilan Halaman View Setelah Tambah Data
Deskripsi: Visualisasi tabel merender balikan data baru ke antarmuka dengan injeksi notifikasi session flash data "berhasil ditambahkan". Rute URI: http://localhost:8000/products.

4. Tampilan Halaman Form Edit Produk
Deskripsi: Form dengan repopulasi data Eloquent secara otomatis. Parameter method spoofing PUT diaktifkan agar integrasi pembaruan dikenali oleh Laravel Routing. Rute URI: http://localhost:8000/products/[id]/edit.
