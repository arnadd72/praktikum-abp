// 1. Function Declaration (Cara Umum) - Modul 6.4
function tambah(a, b) {
    var hasil = a + b;
    return hasil; // Mengembalikan nilai
}

// 2. Function Expression (Fungsi Anonim/Lambda)
var naikkan = function(n) {
    return n + 10; // Langsung mengembalikan ekspresi
};

// 3. Pemanggilan Fungsi
console.log("Hasil Tambah: " + tambah(3, 5)); // Output: 8
console.log("Hasil Naikkan: " + naikkan(5));   // Output: 15