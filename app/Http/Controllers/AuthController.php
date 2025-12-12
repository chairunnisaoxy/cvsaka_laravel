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

    /**
     * Show logout confirmation page
     */
    public function showLogoutConfirm(Request $request)
    {
        // Validasi apakah user sudah login
        if (!Auth::guard('karyawan')->check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
        }

        return view('auth.logout', [
            'karyawan' => Auth::guard('karyawan')->user()
        ]);
    }

    /**
     * Handle logout - PERBAIKAN DI SINI
     */
    public function logout(Request $request)
    {
        if (Auth::guard('karyawan')->check()) {
            $nama_karyawan = Auth::guard('karyawan')->user()->nama_karyawan;

            // Cara 1: Manual logout untuk guard custom
            $request->session()->forget('karyawan_id');
            $request->session()->forget('authenticated');

            // Cara 2: Invalidate session sepenuhnya
            Auth::guard('karyawan')->logout(); // Ini seharusnya berhasil jika guard dikonfigurasi dengan benar

            // Cara 3: Clear session data
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')
                ->with('success', "Logout berhasil! Sampai jumpa, $nama_karyawan");
        }

        return redirect()->route('login');
    }

    /**
     * Alternative logout method jika yang di atas masih error
     */
    public function logoutAlternative(Request $request)
    {
        $nama_karyawan = '';

        // Simpan nama karyawan sebelum logout
        if (Auth::guard('karyawan')->check()) {
            $nama_karyawan = Auth::guard('karyawan')->user()->nama_karyawan;
        }

        // Clear semua session data karyawan
        $request->session()->forget([
            'karyawan_id',
            'karyawan_nama',
            'karyawan_jabatan',
            'authenticated',
            'bypass'
        ]);

        // Invalidate session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Clear cookie jika ada
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time() - 3600, '/');
        }

        if (!empty($nama_karyawan)) {
            return redirect()->route('login')
                ->with('success', "Logout berhasil! Sampai jumpa, $nama_karyawan");
        }

        return redirect()->route('login');
    }
}
