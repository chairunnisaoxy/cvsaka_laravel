<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Karyawan;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Cari karyawan berdasarkan email dari database
        $karyawan = Karyawan::where('email', $request->email)->first();

        // Validasi 1: Email ada di database
        if (!$karyawan) {
            return back()->withErrors([
                'email' => 'Email tidak terdaftar dalam sistem.',
            ])->withInput();
        }

        // Validasi 2: Karyawan memiliki password di database
        if (empty($karyawan->password)) {
            return back()->withErrors([
                'email' => 'Akun ini belum diaktifkan untuk login. Hubungi administrator.',
            ])->withInput();
        }

        // Validasi 3: Password cocok dengan hash di database
        if (!\Illuminate\Support\Facades\Hash::check($request->password, $karyawan->password)) {
            return back()->withErrors([
                'email' => 'Password yang dimasukkan salah.',
            ])->withInput();
        }

        // Validasi 4: Hanya pemilik/supervisor yang boleh login
        if (!in_array($karyawan->jabatan, ['pemilik', 'supervisor'])) {
            return back()->withErrors([
                'email' => 'Hak akses terbatas. Hanya pemilik dan supervisor yang dapat login.',
            ])->withInput();
        }

        // Validasi 5: Status aktif
        if ($karyawan->status_karyawan !== 'aktif') {
            return back()->withErrors([
                'email' => 'Akun ini tidak aktif.',
            ])->withInput();
        }

        // Login berhasil - gunakan data dari database
        if (Auth::guard('karyawan')->login($karyawan)) {
            $request->session()->regenerate();

            // Redirect berdasarkan jabatan
            if ($karyawan->jabatan == 'pemilik') {
                return redirect()->route('dashboard')->with(
                    'success',
                    'Selamat datang, Pemilik ' . $karyawan->nama_karyawan . '!'
                );
            } else {
                return redirect()->route('dashboard')->with(
                    'success',
                    'Selamat datang, Supervisor ' . $karyawan->nama_karyawan . '!'
                );
            }
        }

        // Fallback error
        return back()->withErrors([
            'email' => 'Terjadi kesalahan saat login. Silakan coba lagi.',
        ])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::guard('karyawan')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('landing')->with('success', 'Anda telah logout.');
    }
}
