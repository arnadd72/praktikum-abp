void main() {
  print('=== EKSEKUSI MODUL 3: PENGENALAN DART ===\n');

  demonstrasiVariabel();
  demonstrasiStatementControl(85);
  demonstrasiLooping();
  demonstrasiList();

  // 5. FUNGSI
  int targetAngka = 6;
  int hasilFaktorial = hitungFaktorialSafe(targetAngka);
  print('Hasil faktorial dari $targetAngka adalah: $hasilFaktorial');
  print('===========================================\n');
}

// 1. VARIABEL
void demonstrasiVariabel() {
  print('--- 1. VARIABEL ---');

  final String nama = "Arnanda Setya Nosa Putra";
  int umur = 20;
  double ipk = 3.85;
  bool isMahasiswa = true;

  print('Nama: $nama');
  print('Umur: $umur tahun');
  print('IPK: $ipk');
  print('Status Mahasiswa: $isMahasiswa\n');
}

// 2. STATEMENT CONTROL
void demonstrasiStatementControl(int nilaiUjian) {
  print('--- 2. STATEMENT CONTROL ---');

  print('>> Pengecekan Nilai If-Else:');
  if (nilaiUjian >= 85) {
    print('Grade A - Lulus dengan sangat baik');
  } else if (nilaiUjian >= 70) {
    print('Grade B - Lulus');
  } else {
    print('Grade C - Perlu perbaikan');
  }

  print('>> Pengecekan Status Switch Case:');
  String statusServer = "OK";
  switch (statusServer) {
    case "OK":
      print('Sistem berjalan normal dan aman.');
      break;
    case "ERROR":
      print('PERINGATAN: Terjadi kebocoran memori!');
      break;
    default:
      print('Status tidak dikenali.');
      break;
  }
  print('');
}

// 3. LOOPING
void demonstrasiLooping() {
  print('--- 3. LOOPING ---');

  print('>> For Loop (Iterasi Terukur):');
  for (int i = 1; i <= 3; i++) {
    print('Proses enkripsi blok ke-$i selesai');
  }

  print('>> While Loop (Dengan Safety Counter):');
  int counter = 0;
  int batasMaksimal = 3;
  while (counter < batasMaksimal) {
    print('Mencoba menyambung ke database... Percobaan ${counter + 1}');
    counter++;
  }
  print('');
}

// 4. LIST (ARRAY)
void demonstrasiList() {
  print('--- 4. LIST ---');

  final List<int> fixedList = List.filled(3, 0);
  fixedList[0] = 12;
  fixedList[1] = 13;
  fixedList[2] = 11;
  print('Fixed List: $fixedList');

  final List<String> logKeamanan = [];
  logKeamanan.add("Login berhasil");
  logKeamanan.add("Akses file sistem ditolak");
  print('Growable List Log: $logKeamanan\n');
}

// 5. FUNGSI
int hitungFaktorialSafe(int number) {
  if (number < 0) {
    print('[ERROR] Sistem menolak input negatif pada faktorial!');
    return 0;
  }

  if (number == 0 || number == 1) {
    return 1;
  } else {
    return (number * hitungFaktorialSafe(number - 1));
  }
}