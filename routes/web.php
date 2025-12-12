<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\KaryawanProdukController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\AbsensiKaryawanController;


Route::middleware(['auth.karyawan'])->group(function () {
    Route::resource('produk', ProdukController::class);

    // Optional: route khusus nonaktif & aktif
    Route::put('/produk/{produk}/nonaktifkan', [ProdukController::class, 'nonaktifkan'])->name('produk.nonaktifkan');
    Route::put('/produk/{produk}/aktifkan', [ProdukController::class, 'aktifkan'])->name('produk.aktifkan');
});


// ==============================================
// FIX ROUTES - Tanpa \Artisan, \Schema, \DB
// ==============================================

Route::get('/simple-fix', function () {
    echo "<h3>🔧 SIMPLE FIX - Tanpa Artisan/DB Class</h3>";

    try {
        // 1. Koneksi database manual (pure PHP)
        $host = env('DB_HOST', '127.0.0.1');
        $port = env('DB_PORT', '3306');
        $database = env('DB_DATABASE', 'newcvsakapratama');
        $username = env('DB_USERNAME', 'root');
        $password = env('DB_PASSWORD', '');

        // Coba koneksi
        $mysqli = new mysqli($host, $username, $password, $database, $port);

        if ($mysqli->connect_error) {
            throw new Exception("Koneksi database gagal: " . $mysqli->connect_error);
        }

        echo "✅ Koneksi database OK<br>";

        // 2. Drop tabel sessions jika ada
        $mysqli->query("DROP TABLE IF EXISTS sessions");
        echo "✅ Tabel sessions lama dihapus<br>";

        // 3. Buat tabel sessions baru TANPA user_id
        $sql = "CREATE TABLE IF NOT EXISTS `sessions` (
            `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
            `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            `user_agent` text COLLATE utf8mb4_unicode_ci,
            `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
            `last_activity` int NOT NULL,
            PRIMARY KEY (`id`),
            KEY `sessions_last_activity_index` (`last_activity`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

        if ($mysqli->query($sql)) {
            echo "✅ Tabel sessions baru dibuat (tanpa user_id)<br>";
        } else {
            throw new Exception("Gagal buat tabel: " . $mysqli->error);
        }

        $mysqli->close();

        // 4. Hapus file cache secara manual
        $cacheFiles = [
            // Framework cache
            storage_path('framework/cache/data/*'),
            storage_path('framework/sessions/*'),
            storage_path('framework/views/*'),

            // Bootstrap cache
            base_path('bootstrap/cache/*.php'),

            // Compiled files
            storage_path('framework/compiled.php'),
            storage_path('framework/services.php'),
        ];

        $deletedCount = 0;
        foreach ($cacheFiles as $pattern) {
            $files = glob($pattern);
            foreach ($files as $file) {
                if (is_file($file) && unlink($file)) {
                    $deletedCount++;
                }
            }
        }
        echo "✅ {$deletedCount} file cache dihapus<br>";

        // 5. Update .env untuk session file
        $envPath = base_path('.env');
        if (file_exists($envPath)) {
            $content = file_get_contents($envPath);

            // Ubah SESSION_DRIVER ke file
            $content = preg_replace('/SESSION_DRIVER=.*/', 'SESSION_DRIVER=file', $content);

            // Matikan SESSION_ENCRYPT
            $content = preg_replace('/SESSION_ENCRYPT=.*/', 'SESSION_ENCRYPT=false', $content);

            file_put_contents($envPath, $content);
            echo "✅ File .env diperbarui<br>";
        }

        // 6. Hapus session lama dari browser
        echo "<script>
            // Hapus semua cookies
            var cookies = document.cookie.split(';');
            for (var i = 0; i < cookies.length; i++) {
                var cookie = cookies[i];
                var eqPos = cookie.indexOf('=');
                var name = eqPos > -1 ? cookie.substr(0, eqPos).trim() : cookie.trim();
                document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
            }
            
            // Hapus localStorage
            localStorage.clear();
            
            // Hapus sessionStorage  
            sessionStorage.clear();
            
            console.log('Browser storage cleared');
        </script>";
        echo "✅ Browser storage dibersihkan<br>";

        // 7. Hapus session file yang ada
        $sessionFiles = glob(storage_path('framework/sessions/*'));
        foreach ($sessionFiles as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
        echo "✅ File session di server dibersihkan<br>";

        // 8. Tampilkan hasil
        echo "<br><div style='background: #d4edda; padding: 20px; border-radius: 5px;'>";
        echo "<h4 style='color: #155724; margin: 0;'>✅ PERBAIKAN SELESAI!</h4>";
        echo "<p style='margin: 10px 0 0 0;'>Sistem siap untuk login.</p>";
        echo "</div>";

        // 9. Redirect otomatis ke login
        echo "<script>
            setTimeout(function() {
                window.location.href = '/login';
            }, 2000);
        </script>";
    } catch (Exception $e) {
        echo "<div style='background: #f8d7da; padding: 20px; border-radius: 5px;'>";
        echo "<h4 style='color: #721c24; margin: 0;'>❌ ERROR:</h4>";
        echo "<p style='margin: 10px 0 0 0;'>{$e->getMessage()}</p>";
        echo "</div>";

        echo "<br><p>Coba alternatif:</p>";
        echo "<ul>";
        echo "<li><a href='/manual-fix'>Manual Fix</a></li>";
        echo "<li><a href='/login'>Coba login langsung</a></li>";
        echo "<li>Restart server: <code>php artisan serve</code></li>";
        echo "</ul>";
    }
});

Route::get('/manual-fix', function () {
    echo "<h3>📝 MANUAL FIX - Instruksi Manual</h3>";

    echo "<div style='background: #fff3cd; padding: 20px; border-radius: 5px; margin-bottom: 20px;'>";
    echo "<h4 style='color: #856404;'>Langkah-langkah Manual:</h4>";
    echo "<ol>";
    echo "<li><strong>Buka phpMyAdmin</strong></li>";
    echo "<li><strong>Pilih database: newcvsakapratama</strong></li>";
    echo "<li><strong>Jalankan SQL ini:</strong>";
    echo "<pre style='background: #f8f9fa; padding: 10px; border-radius: 3px;'>
DROP TABLE IF EXISTS sessions;

CREATE TABLE `sessions` (
    `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `user_agent` text COLLATE utf8mb4_unicode_ci,
    `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
    `last_activity` int NOT NULL,
    PRIMARY KEY (`id`),
    KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        </pre></li>";
    echo "<li><strong>Edit file .env</strong> dan ubah:<br>";
    echo "<code>SESSION_DRIVER=file</code><br>";
    echo "<code>SESSION_ENCRYPT=false</code></li>";
    echo "<li><strong>Hapus folder:</strong><br>";
    echo "- storage/framework/cache/*<br>";
    echo "- storage/framework/sessions/*<br>";
    echo "- storage/framework/views/*<br>";
    echo "- bootstrap/cache/*.php</li>";
    echo "<li><strong>Restart browser</strong> (clear cookies)</li>";
    echo "<li><strong>Restart Laravel:</strong> php artisan serve</li>";
    echo "</ol>";
    echo "</div>";

    echo "<a href='/login' style='
        display: inline-block;
        padding: 10px 20px;
        background: #28a745;
        color: white;
        text-decoration: none;
        border-radius: 5px;
    '>⇨ Coba Login Sekarang</a>";
});

Route::get('/check-simple', function () {
    echo "<h3>✅ STATUS SISTEM</h3>";

    // Cek koneksi database sederhana
    try {
        $mysqli = new mysqli(
            env('DB_HOST', '127.0.0.1'),
            env('DB_USERNAME', 'root'),
            env('DB_PASSWORD', ''),
            env('DB_DATABASE', 'newcvsakapratama'),
            env('DB_PORT', '3306')
        );

        if ($mysqli->connect_error) {
            echo "❌ Database: Tidak terhubung<br>";
        } else {
            echo "✅ Database: Terhubung<br>";

            // Cek tabel sessions
            $result = $mysqli->query("SHOW TABLES LIKE 'sessions'");
            if ($result->num_rows > 0) {
                echo "✅ Tabel sessions: Ada<br>";

                // Cek kolom
                $columns = $mysqli->query("DESCRIBE sessions");
                $hasUserId = false;
                while ($row = $columns->fetch_assoc()) {
                    if ($row['Field'] == 'user_id') {
                        $hasUserId = true;
                    }
                }

                if ($hasUserId) {
                    echo "⚠️ Kolom user_id: Masih ada (perlu dihapus)<br>";
                } else {
                    echo "✅ Kolom user_id: Tidak ada (baik)<br>";
                }
            } else {
                echo "⚠️ Tabel sessions: Tidak ada<br>";
            }

            $mysqli->close();
        }
    } catch (Exception $e) {
        echo "❌ Database check error: " . $e->getMessage() . "<br>";
    }

    // Cek .env
    $envPath = base_path('.env');
    if (file_exists($envPath)) {
        $content = file_get_contents($envPath);
        if (strpos($content, 'SESSION_DRIVER=file') !== false) {
            echo "✅ .env SESSION_DRIVER: file<br>";
        } else {
            echo "⚠️ .env SESSION_DRIVER: Bukan file<br>";
        }
    }

    echo "<br><a href='/simple-fix'>⇨ Jalankan Simple Fix</a>";
});

// ==============================================
// LOGIN BYPASS ROUTES (Jika tetap error)
// ==============================================

Route::get('/direct-login/{id}', function ($id) {
    // Login langsung tanpa middleware
    session()->put('karyawan_id', $id);
    session()->put('authenticated', true);
    session()->put('bypass', 'yes');

    // Cari nama karyawan
    try {
        $mysqli = new mysqli(
            env('DB_HOST', '127.0.0.1'),
            env('DB_USERNAME', 'root'),
            env('DB_PASSWORD', ''),
            env('DB_DATABASE', 'newcvsakapratama'),
            env('DB_PORT', '3306')
        );

        $stmt = $mysqli->prepare("SELECT nama_karyawan, jabatan FROM m_karyawan WHERE id_karyawan = ?");
        $stmt->bind_param('s', $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            session()->put('karyawan_nama', $row['nama_karyawan']);
            session()->put('karyawan_jabatan', $row['jabatan']);
        }

        $mysqli->close();
    } catch (Exception $e) {
        // Skip jika error
    }

    return redirect('/dashboard')->with('success', 'Login langsung berhasil!');
});

Route::get('/quick-setup', function () {
    echo "<h3>⚡ QUICK SETUP</h3>";
    echo "<p>Pilih akun untuk login langsung:</p>";

    try {
        $mysqli = new mysqli(
            env('DB_HOST', '127.0.0.1'),
            env('DB_USERNAME', 'root'),
            env('DB_PASSWORD', ''),
            env('DB_DATABASE', 'newcvsakapratama'),
            env('DB_PORT', '3306')
        );

        $result = $mysqli->query("
            SELECT id_karyawan, nama_karyawan, email, jabatan 
            FROM m_karyawan 
            WHERE jabatan IN ('pemilik', 'supervisor') 
            AND status_karyawan = 'aktif'
            ORDER BY jabatan
        ");

        echo "<ul style='list-style: none; padding: 0;'>";
        while ($row = $result->fetch_assoc()) {
            echo "<li style='margin: 10px 0; padding: 10px; background: #f8f9fa; border-radius: 5px;'>";
            echo "<strong>{$row['nama_karyawan']}</strong> ({$row['jabatan']})<br>";
            echo "<small>{$row['email']}</small><br>";
            echo "<a href='/direct-login/{$row['id_karyawan']}' style='color: #007bff;'>⇨ Login sebagai ini</a>";
            echo "</li>";
        }
        echo "</ul>";

        $mysqli->close();
    } catch (Exception $e) {
        echo "<p style='color: red;'>Gagal mengambil data: {$e->getMessage()}</p>";
    }

    echo "<br><a href='/simple-fix'>⇨ Kembali ke Simple Fix</a>";
});

// ==============================================
// MAIN APPLICATION ROUTES (Tetap sama)
// ==============================================

// Landing Page Route
Route::get('/', [LandingController::class, 'index'])->name('landing');

// Login routes
Route::middleware('guest:karyawan')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware(['auth:karyawan'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Logout routes dengan konfirmasi
    Route::get('/logout-confirm', [AuthController::class, 'showLogoutConfirm'])->name('logout.confirm');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Produk routes menggunakan resource (semua method otomatis)
    Route::resource('produk', ProdukController::class);

    // Route khusus untuk status
    Route::post('/produk/{produk}/nonaktifkan', [ProdukController::class, 'nonaktifkan'])
        ->name('produk.nonaktifkan');
    Route::post('/produk/{produk}/aktifkan', [ProdukController::class, 'aktifkan'])
        ->name('produk.aktifkan');
});

// Karyawan routes
Route::resource('karyawan', KaryawanController::class);
Route::get('/karyawan/{karyawan}/cetak-slip', [KaryawanController::class, 'cetakSlip'])->name('karyawan.cetak-slip');
Route::get('/karyawan/{karyawan}/produk', [KaryawanController::class, 'produk'])->name('karyawan.produk');

// Untuk AJAX requests
Route::get('/karyawan/{karyawan}/get', [KaryawanController::class, 'getKaryawan'])->name('karyawan.get');
Route::get('/karyawan/{karyawan}/calculate-total-hadir', [KaryawanController::class, 'calculateTotalHadir'])->name('karyawan.calculate-total-hadir');

// Karyawan produk routes
Route::prefix('karyawan/{karyawan}')->group(function () {
    // Halaman produk
    Route::get('/produk', [KaryawanController::class, 'produk'])->name('karyawan.produk');

    // AJAX routes untuk produk
    Route::get('/produk/{produk}', [KaryawanController::class, 'getProdukKaryawan'])->name('karyawan.get-produk');
    Route::post('/produk', [KaryawanController::class, 'storeProduk'])->name('karyawan.store-produk');
    Route::put('/produk/{produk}', [KaryawanController::class, 'updateProduk'])->name('karyawan.update-produk');
    Route::post('/produk/{produk}/delete', [KaryawanController::class, 'destroyProduk'])->name('karyawan.destroy-produk');
});

// Produk routes
Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');

// Additional routes for produk
Route::post('/produk/{produk}/nonaktifkan', [ProdukController::class, 'nonaktifkan'])->name('produk.nonaktifkan');
Route::post('/produk/{produk}/aktifkan', [ProdukController::class, 'aktifkan'])->name('produk.aktifkan');

Route::get('/karyawan/{karyawan}/produk-karyawan', [KaryawanProdukController::class, 'produk'])->name('karyawan.produk-karyawan');

// Route untuk AJAX:
Route::prefix('produk-karyawan')->group(function () {
    Route::post('/store', [KaryawanProdukController::class, 'store'])->name('produk-karyawan.store');
    Route::post('/update', [KaryawanProdukController::class, 'update'])->name('produk-karyawan.update');
    Route::post('/destroy', [KaryawanProdukController::class, 'destroy'])->name('produk-karyawan.destroy');
    Route::get('/get-data', [KaryawanProdukController::class, 'getProdukKaryawan'])->name('produk-karyawan.get-data');
});

// ==============================================
// ABSENSI ROUTES (TAMBAHAN BARU DI BAWAH INI)
// ==============================================

Route::middleware(['auth:karyawan'])->group(function () {
    // Absensi resource routes
    Route::resource('absensi', AbsensiController::class);

    // Absensi Karyawan Detail Routes
    Route::prefix('absensi')->name('absensi.')->group(function () {
        // Detail karyawan dalam absensi
        Route::get('/{absensi}/karyawan', [AbsensiKaryawanController::class, 'karyawan'])->name('karyawan');

        // AJAX routes
        Route::get('/karyawan/get-data', [AbsensiKaryawanController::class, 'getData'])->name('karyawan.get-data');
        Route::post('/karyawan/store', [AbsensiKaryawanController::class, 'store'])->name('karyawan.store');
        Route::post('/karyawan/update', [AbsensiKaryawanController::class, 'update'])->name('karyawan.update');
        Route::post('/karyawan/destroy', [AbsensiKaryawanController::class, 'destroy'])->name('karyawan.destroy');
    });
});
