<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Akademik Terpadu</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI",
                         Roboto, Helvetica, Arial, sans-serif;
            background-color: #f3f4f6;
            margin: 0; padding: 40px 20px;
            color: #1f2937;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
        }
        .header-title {
            text-align: center;
            margin-bottom: 30px;
        }
        .btn-fetch {
            display: block; width: 100%; max-width: 250px;
            margin: 0 auto 30px; padding: 12px 20px;
            background-color: #2563eb; color: white;
            border: none; border-radius: 8px; font-weight: 600;
            cursor: pointer; transition: background-color 0.2s;
        }
        .btn-fetch:hover { background-color: #1d4ed8; }
        .grid-cards {
            display: grid; gap: 20px;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        }
        .card {
            background: white; padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            border-top: 4px solid #2563eb;
        }
        .card h3 { margin: 0 0 10px 0; color: #111827; }
        .card p { margin: 5px 0; font-size: 14px; color: #4b5563; }
        .badge {
            display: inline-block; padding: 4px 8px;
            background-color: #dbeafe; color: #1e40af;
            border-radius: 9999px; font-size: 12px; font-weight: 600;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1 class="header-title">Data Mahasiswa Aktif</h1>

        <button id="btnTampilkan" class="btn-fetch">Tampilkan Data</button>

        <div id="resultArea" class="grid-cards"></div>
    </div>

    <script>
        document.getElementById('btnTampilkan').addEventListener('click', async function() {
            const resultArea = document.getElementById('resultArea');
            const btn = this;

            // Ubah state tombol saat proses fetch
            btn.textContent = 'Mengambil Data...';
            btn.disabled = true;
            resultArea.innerHTML = '';

            try {
                // Request AJAX ke endpoint Laravel
                const response = await fetch('{{ url("/api/mahasiswa") }}', {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                if (!response.ok) {
                    throw new Error('Terjadi kesalahan jaringan atau server.');
                }

                const jsonResponse = await response.json();

                if (jsonResponse.status === 'success') {
                    // Loop data menggunakan pendekatan DOM Manipulation yang aman
                    jsonResponse.data.forEach(mhs => {
                        const card = document.createElement('div');
                        card.className = 'card';

                        // Mencegah XSS dengan menggunakan textContent
                        const nama = document.createElement('h3');
                        nama.textContent = mhs.nama;

                        const nim = document.createElement('p');
                        nim.textContent = `NIM: ${mhs.nim}`;

                        const prodi = document.createElement('p');
                        prodi.textContent = `Program Studi: ${mhs.prodi}`;

                        const wrapperKelas = document.createElement('div');
                        wrapperKelas.style.marginTop = '10px';

                        const kelas = document.createElement('span');
                        kelas.className = 'badge';
                        kelas.textContent = `Kelas ${mhs.kelas}`;

                        wrapperKelas.appendChild(kelas);

                        // Rangkai elemen ke dalam card
                        card.append(nama, nim, prodi, wrapperKelas);
                        resultArea.appendChild(card);
                    });
                }
            } catch (error) {
                // Tampilkan error yang aman bagi pengguna
                resultArea.innerHTML = `
                    <div style="color: red; text-align: center; width: 100%;">
                        Gagal memuat data. Pastikan server berjalan dengan baik.
                    </div>
                `;
            } finally {
                // Kembalikan state tombol
                btn.textContent = 'Tampilkan Data';
                btn.disabled = false;
            }
        });
    </script>
</body>
</html>
