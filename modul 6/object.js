// 1. Membuat Object Kosong (Modul 6.3.1)
var objek_kosong = {};

// 2. Membuat Object dengan Properti (Object Literal)
var mobil = {
    "warna-badan": "merah",
    "nomor-polisi": "BK1234AB",
    "jumlah_roda": 4
};

// 3. Membuat Object Bersarang (Nested Object)
var jadwal = {
    platform: 34,
    tujuan: {
        kode_kota: "JKT",
        nama_kota: "Jakarta"
    }
};

// Menampilkan data object ke terminal
console.log("Warna Mobil: " + mobil["warna-badan"]);
console.log("Kota Tujuan: " + jadwal.tujuan.nama_kota);