// 1. Membuat array dengan kurung siku (Modul 6.2.3)
var data = ["satu", 2, true]; // Isi array bisa beda tipe data

// 2. Mengakses elemen array menggunakan indeks (Dimulai dari 0)
console.log("Elemen indeks ke-0: " + data[0]); // Output: satu
console.log("Elemen indeks ke-1: " + data[1]); // Output: 2

// 3. Menambah data baru ke akhir array (Method push)
data.push("baru");
console.log("Setelah push: " + data);

// 4. Menghapus data terakhir (Method pop)
data.pop();
console.log("Setelah pop: " + data);

// 5. Array dua dimensi (Array di dalam Array)
var arr2 = [["satu", "dua"], ["tiga", "empat"]];
console.log("Akses array 2D: " + arr2[0][1]); // Output: dua