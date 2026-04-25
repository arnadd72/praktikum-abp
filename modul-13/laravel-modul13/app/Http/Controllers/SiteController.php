<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SiteController extends Controller
{
    public function auth(Request $request)
    {
        // Limitasi input awal agar request tidak membebani memori
        $credentials = $request->validate([
            'email'    => 'required|email|max:150',
            'password' => 'required|string|min:6',
        ]);

        try {
            // Auth::attempt melakukan pencocokan hash Bcrypt di latar belakang
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                
                $request->session()->regenerate();
                
                // Menyimpan nama user ke session statis sebagai fallback/display
                session()->put('name', Auth::user()->name);
                
                return redirect()->intended('/product');
            }

            // Fallback apabila kredensial salah (tidak spesifik memberitahu mana yang salah)
            return redirect('/login')
                ->with('msg', 'Otentikasi gagal: Email atau Password tidak valid.');
                
        } catch (\Exception $e) {
            Log::error('Kesalahan Otentikasi Lintas Sistem: ' . $e->getMessage());
            return redirect('/login')->with('msg', 'Terjadi kesalahan internal server.');
        }
    }
}
