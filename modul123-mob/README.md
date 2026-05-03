<div align="center">
  <br />

  <h1>LAPORAN PRAKTIKUM <br>
  APLIKASI BERBASIS PLATFORM
  </h1>

  <br />

  <h3>MODUL - 1,2,3<br>
    Pengenalan Flutter dan Dart
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

---

# 1. Dasar Teori

Flutter adalah framework open-source yang dikembangkan oleh Google untuk 
membangun aplikasi lintas platform seperti mobile, web, dan desktop hanya dengan 
satu codebase. Flutter menggunakan bahasa pemrograman Dart serta didukung oleh 
Skia Graphics Engine untuk merender tampilan secara langsung ke layar tanpa 
bergantung pada komponen native. Salah satu keunggulan utama Flutter adalah 
fitur hot reload yang memungkinkan developer melihat perubahan kode secara 
langsung tanpa harus melakukan build ulang aplikasi, sehingga proses 
pengembangan menjadi lebih cepat dan efisien.

Dalam pengembangan antarmuka, Flutter menggunakan konsep widget tree, yaitu 
struktur hierarkis di mana seluruh elemen UI dibangun dari widget. Widget ini 
terbagi menjadi dua jenis utama, yaitu stateless widget yang tidak memiliki 
state (data tidak berubah) dan stateful widget yang memiliki state yang dapat 
berubah selama aplikasi berjalan. Struktur dasar aplikasi Flutter biasanya 
dimulai dari MaterialApp sebagai root aplikasi, kemudian Scaffold sebagai 
kerangka utama layout yang menyediakan komponen seperti AppBar dan body, serta 
widget lain seperti Text dan Center untuk menampilkan dan mengatur posisi konten.

Untuk pengelolaan arsitektur, Flutter mendukung berbagai pendekatan, salah 
satunya adalah BLoC (Business Logic Component). Pola ini bertujuan untuk 
memisahkan logika bisnis dari tampilan dengan menggunakan konsep event dan 
state, sehingga aplikasi menjadi lebih terstruktur, mudah dikembangkan, 
scalable, dan lebih mudah untuk diuji. Sebagai langkah awal pembelajaran, 
biasanya developer membuat aplikasi sederhana seperti “Hello World” untuk 
memahami struktur dasar Flutter dan cara kerja widget dalam membangun 
tampilan aplikasi.

---

# 2. Screenshot Tampilan Environment & Hasil

## Verifikasi SDK Android Studio
*(Penjelasan: Screenshot SDK Manager untuk memastikan build tools aman)*
<p>
<img src="assets/Verifikasi_Android_Studio.jpeg" width="800">
</p>

## Struktur Proyek Baru
*(Penjelasan: Screenshot struktur direktori proyek Flutter di IDE)*
<p>
<img src="assets/ProjectHelloWorld_Structure.jpeg" width="800">
</p>

## Verifikasi Instalasi Flutter (Flutter Doctor)
*(Penjelasan: Screenshot terminal hasil `flutter doctor -v` untuk memastikan 
seluruh dependensi terinstal dengan benar dan aman dari celah environment)*
<p>
<img src="assets/Flutter_Doctor.jpeg" width="800">
</p>

## Hasil Running Hello World
<p>
<img src="assets/Hello_World.jpeg" width="1500">
</p>

### Referensi

- Flutter Docs: [https://docs.flutter.dev](https://docs.flutter.dev)
- Modul 1 dan 2 Praktikum Aplikasi Berbasis Platform