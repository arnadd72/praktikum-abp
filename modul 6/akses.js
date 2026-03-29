var mobil = {
    "warna-badan": "merah",
    "nomor-polisi": "BK1234AB",
    "jumlah_roda": 4
};

// 1. Menggunakan Kurung Siku [] (Wajib untuk nama properti ilegal/pakai spasi)
console.log("Warna: " + mobil["warna-badan"]); // [cite: 148-149, 155]

// 2. Menggunakan Tanda Titik . (Cara paling umum/legal)
console.log("Roda: " + mobil.jumlah_roda); // [cite: 150-151, 166]

// 3. Mengakses properti yang tidak ada (Hasilnya Undefined)
console.log("Kursi: " + mobil.nomor_kursi); // [cite: 159-160]

// 4. Mengubah atau menambah nilai properti secara dinamis
mobil.bahan_bakar = "Bensin"; // [cite: 164-165, 167]
console.log("Bahan Bakar: " + mobil.bahan_bakar);