<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function index()
    {
        // Pastikan nama file view sesuai dengan letak file blade kamu
        return view('auth.login');
    }

    public function proses_login(Request $request)
    {
        // Validasi input username dan password
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ], [
            'username.required' => 'Username wajib diisi.',
            'password.required' => 'Password wajib diisi.'
        ]);

        // Proses autentikasi berbasis username menggunakan Laravel Auth
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->route('dashboard');
        }

        // Jika gagal, kembalikan ke halaman login dengan pesan error gantung
        return back()->withErrors([
            'login_error' => 'Username atau password salah.',
        ])->withInput($request->only('username'));
    }
    
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}