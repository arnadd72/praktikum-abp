<?php

// Set header agar browser tahu ini adalah data JSON
header('Content-Type: application/json');

// Data sederhana (simulasi database)
$data = [
    ['nama' => 'Arnanda', 'pekerjaan' => 'AI Engineer', 'lokasi' => 'Purwokerto'],
    ['nama' => 'Zidane', 'pekerjaan' => 'Anggota DPR Komisi IV', 'lokasi' => 'Cilacap'],
    ['nama' => 'Andika', 'pekerjaan' => 'Ketua Umum Partai', 'lokasi' => 'Kroya']
];

// Ubah array menjadi JSON dan tampilkan
echo json_encode($data);
