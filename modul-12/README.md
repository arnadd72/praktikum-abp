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

> **Catatan Engineer:** Seluruh kode di bawah disusun dengan standar level industri, memperhatikan batasan lebar layar (*line breaks*), validasi presisi tinggi, penerapan standar operasional error (*Try-Catch*), dan proteksi celah eksploitasi.

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
