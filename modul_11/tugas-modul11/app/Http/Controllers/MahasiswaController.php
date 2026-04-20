<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class MahasiswaController extends Controller
{
    // Menampilkan halaman utama
    public function index()
    {
        return view('mahasiswa');
    }

    public function getMahasiswa()
    {
        $path = storage_path('app/data_mahasiswa.json');

        if (!file_exists($path)) {
            return response()->json([
                'status' => 'error',
                'message' => 'PHP mencari file di alamat ini tapi tidak ada: ' . $path
            ], 404);
        }

        $jsonString = file_get_contents($path);
        $data = json_decode($jsonString, true);

        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }
}
