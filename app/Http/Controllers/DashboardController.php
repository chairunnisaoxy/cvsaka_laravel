<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Karyawan;

class DashboardController extends Controller
{
    // Constructor kosong - kita handle authentication di method index

    public function index()
    {
        // 1. Cek apakah user sudah login dengan guard karyawan
        if (!Auth::guard('karyawan')->check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = Auth::guard('karyawan')->user();

        // Data untuk semua role
        $data = $this->getDashboardData($user);

        return view('dashboard.index', $data);
    }

    /**
     * Mengambil data dashboard berdasarkan role user
     */
    private function getDashboardData($user)
    {
        // Data umum untuk semua role
        $totalKaryawan = Karyawan::where('status_karyawan', 'aktif')->count();

        // Hadir Hari Ini
        $today = date('Y-m-d');
        $hadirHariIni = DB::table('t_absensi_karyawan as tak')
            ->join('m_absensi as a', 'tak.id_absensi', '=', 'a.id_absensi')
            ->whereDate('a.tanggal', $today)
            ->where('tak.status_absensi', 'hadir')
            ->distinct('tak.id_karyawan')
            ->count('tak.id_karyawan');

        // Total Produksi
        $totalProduksi = DB::table('t_produk_karyawan as pk')
            ->join('m_karyawan as k', 'pk.id_karyawan', '=', 'k.id_karyawan')
            ->select(DB::raw('COALESCE(SUM(pk.jml_aktual), 0) as total_aktual'))
            ->where('k.status_karyawan', 'aktif')
            ->where('k.jabatan', 'operator')
            ->first();
        $total_aktual = $totalProduksi->total_aktual ?? 0;

        // Inisialisasi variabel untuk SAW (hanya untuk pemilik)
        $top_saw = [];
        $saw_stats = [];
        $alternatives = [];

        // Hanya hitung SAW jika user adalah pemilik
        if ($user->jabatan == 'pemilik') {
            $sawData = $this->calculateSAW();
            $top_saw = $sawData['top_saw'] ?? [];
            $saw_stats = $sawData['stats'] ?? [];
            $alternatives = $sawData['alternatives'] ?? [];
        }

        // KPI: Ranking Produksi (hanya untuk pemilik dan supervisor)
        $rankingProduksi = collect();
        if (in_array($user->jabatan, ['pemilik', 'supervisor'])) {
            $rankingProduksi = DB::table('m_karyawan as k')
                ->leftJoin('t_produk_karyawan as pk', 'k.id_karyawan', '=', 'pk.id_karyawan')
                ->select(
                    'k.id_karyawan',
                    'k.nama_karyawan',
                    'k.jabatan',
                    DB::raw('COALESCE(SUM(pk.jml_aktual), 0) as total_aktual'),
                    DB::raw('COALESCE(SUM(pk.jml_keranjang), 0) as total_keranjang')
                )
                ->where('k.status_karyawan', 'aktif')
                ->where('k.jabatan', 'operator')
                ->groupBy('k.id_karyawan', 'k.nama_karyawan', 'k.jabatan')
                ->orderByDesc('total_aktual')
                ->limit(5)
                ->get();
        }

        // KPI: Top Kehadiran (14 Hari)
        $topKehadiran = collect();
        if (in_array($user->jabatan, ['pemilik', 'supervisor'])) {
            $duaMingguLalu = date('Y-m-d', strtotime('-14 days'));
            $topKehadiran = DB::table('m_karyawan as k')
                ->join('t_absensi_karyawan as tak', 'k.id_karyawan', '=', 'tak.id_karyawan')
                ->join('m_absensi as a', 'tak.id_absensi', '=', 'a.id_absensi')
                ->select(
                    'k.id_karyawan',
                    'k.nama_karyawan',
                    'k.jabatan',
                    DB::raw('COUNT(tak.id_absensi) as total_hadir')
                )
                ->where('k.status_karyawan', 'aktif')
                ->where('k.jabatan', 'operator')
                ->where('a.tanggal', '>=', $duaMingguLalu)
                ->where('tak.status_absensi', 'hadir')
                ->groupBy('k.id_karyawan', 'k.nama_karyawan', 'k.jabatan')
                ->orderByDesc('total_hadir')
                ->limit(5)
                ->get();
        }

        // PROGRESS TARGET PERUSAHAAN (hanya untuk pemilik dan supervisor)
        $total_target = 0;
        $total_aktual_target = 0;
        $persentase_selesai = 0;

        if (in_array($user->jabatan, ['pemilik', 'supervisor'])) {
            $targetProgress = DB::select('
                SELECT 
                    COUNT(*) as total_operator,
                    COALESCE(SUM(k.jml_target), 0) as total_target,
                    (
                        SELECT COALESCE(SUM(pk2.jml_aktual), 0)
                        FROM t_produk_karyawan pk2
                        JOIN m_karyawan k2 ON pk2.id_karyawan = k2.id_karyawan
                        WHERE k2.status_karyawan = "aktif" AND k2.jabatan = "operator"
                    ) as total_aktual,
                    CASE 
                        WHEN SUM(k.jml_target) > 0 THEN 
                            (
                                (
                                    SELECT COALESCE(SUM(pk2.jml_aktual), 0)
                                    FROM t_produk_karyawan pk2
                                    JOIN m_karyawan k2 ON pk2.id_karyawan = k2.id_karyawan
                                    WHERE k2.status_karyawan = "aktif" AND k2.jabatan = "operator"
                                ) / SUM(k.jml_target)
                            ) * 100 
                        ELSE 0 
                    END as persentase_selesai
                FROM m_karyawan k 
                WHERE k.status_karyawan = "aktif" AND k.jabatan = "operator"
            ');

            $targetProgress = $targetProgress[0] ?? null;
            $total_target = $targetProgress->total_target ?? 0;
            $total_aktual_target = $targetProgress->total_aktual ?? 0;
            $persentase_selesai = $targetProgress->persentase_selesai ?? 0;
        }

        // AKTIVITAS TERBARU (hanya untuk pemilik dan supervisor)
        $absensiTerbaru = collect();
        $produksiTerbaru = collect();

        if (in_array($user->jabatan, ['pemilik', 'supervisor'])) {
            // Absensi Terbaru
            $absensiTerbaru = DB::table('m_absensi as a')
                ->join('t_absensi_karyawan as tak', 'a.id_absensi', '=', 'tak.id_absensi')
                ->join('m_karyawan as k', 'tak.id_karyawan', '=', 'k.id_karyawan')
                ->select('a.*', 'k.nama_karyawan', 'tak.status_absensi')
                ->orderByDesc('a.tanggal')
                ->orderByDesc('a.id_absensi')
                ->limit(5)
                ->get();

            // Produksi Terbaru
            $produksiTerbaru = DB::table('t_produk_karyawan as pk')
                ->join('m_produk as p', 'pk.id_produk', '=', 'p.id_produk')
                ->join('m_karyawan as k', 'pk.id_karyawan', '=', 'k.id_karyawan')
                ->select('pk.*', 'p.nama_produk', 'k.nama_karyawan')
                ->orderByDesc('pk.jml_aktual')
                ->limit(5)
                ->get();
        }

        return [
            // User info
            'user' => $user,

            // Statistik dasar
            'totalKaryawan' => $totalKaryawan,
            'hadirHariIni' => $hadirHariIni,
            'total_aktual' => $total_aktual,

            // SAW Data (hanya untuk pemilik)
            'top_saw' => $top_saw,
            'saw_stats' => $saw_stats,
            'alternatives' => $alternatives,

            // KPI Data (hanya untuk pemilik dan supervisor)
            'rankingProduksi' => $rankingProduksi,
            'topKehadiran' => $topKehadiran,

            // Statistik Target (hanya untuk pemilik dan supervisor)
            'total_target' => $total_target,
            'total_aktual_target' => $total_aktual_target,
            'persentase_selesai' => $persentase_selesai,

            // Aktivitas Terbaru (hanya untuk pemilik dan supervisor)
            'absensiTerbaru' => $absensiTerbaru,
            'produksiTerbaru' => $produksiTerbaru,
        ];
    }

    /**
     * Menghitung SAW (Simple Additive Weighting)
     * HANYA untuk role pemilik
     */
    private function calculateSAW()
    {
        // Ambil data karyawan aktif dengan jabatan operator
        $sawData = DB::table('m_karyawan as k')
            ->leftJoin('t_produk_karyawan as pk', 'k.id_karyawan', '=', 'pk.id_karyawan')
            ->select(
                'k.id_karyawan',
                'k.nama_karyawan',
                'k.jml_target',
                DB::raw('COALESCE(SUM(pk.jml_aktual), 0) as total_produksi'),
                DB::raw('
                    (SELECT COUNT(DISTINCT a.tanggal)
                     FROM t_absensi_karyawan tak
                     JOIN m_absensi a ON tak.id_absensi = a.id_absensi
                     WHERE tak.id_karyawan = k.id_karyawan 
                     AND tak.status_absensi = "hadir"
                     AND a.tanggal >= DATE_SUB(CURDATE(), INTERVAL 14 DAY)) as jumlah_hadir
                ')
            )
            ->where('k.status_karyawan', 'aktif')
            ->where('k.jabatan', 'operator')
            ->groupBy('k.id_karyawan', 'k.nama_karyawan', 'k.jml_target')
            ->havingRaw('total_produksi > 0 OR jumlah_hadir > 0')
            ->get();

        if ($sawData->isEmpty()) {
            return [
                'alternatives' => [],
                'top_saw' => [],
                'stats' => []
            ];
        }

        // Inisialisasi array untuk perhitungan SAW
        $alternatives = [];
        $c1_produksi = [];
        $c2_kehadiran = [];

        // Mengumpulkan data alternatif
        foreach ($sawData as $row) {
            $alternatives[] = [
                'id' => $row->id_karyawan,
                'nama' => $row->nama_karyawan,
                'target' => $row->jml_target,
                'produksi' => $row->total_produksi,
                'kehadiran' => $row->jumlah_hadir
            ];

            $c1_produksi[] = $row->total_produksi;
            $c2_kehadiran[] = $row->jumlah_hadir;
        }

        // Bobot kriteria (Produksi: 60%, Kehadiran: 40%)
        $weight_produksi = 0.6;
        $weight_kehadiran = 0.4;

        // 1. Mencari nilai maksimum dan minimum
        $max_produksi = max($c1_produksi);
        $min_produksi = min($c1_produksi);
        $max_kehadiran = max($c2_kehadiran);
        $min_kehadiran = min($c2_kehadiran);

        $scores = [];

        // 2. Normalisasi dan hitung skor
        foreach ($alternatives as $index => $alt) {
            // Normalisasi Produksi
            if ($max_produksi != $min_produksi) {
                $normalized_produksi = ($alt['produksi'] - $min_produksi) / ($max_produksi - $min_produksi);
            } else {
                $normalized_produksi = 1;
            }

            // Normalisasi Kehadiran
            if ($max_kehadiran != $min_kehadiran) {
                $normalized_kehadiran = ($alt['kehadiran'] - $min_kehadiran) / ($max_kehadiran - $min_kehadiran);
            } else {
                $normalized_kehadiran = 1;
            }

            // 3. Hitung skor akhir
            $score = ($normalized_produksi * $weight_produksi) + ($normalized_kehadiran * $weight_kehadiran);

            $scores[] = [
                'id' => $alt['id'],
                'nama' => $alt['nama'],
                'produksi' => $alt['produksi'],
                'kehadiran' => $alt['kehadiran'],
                'target' => $alt['target'],
                'normalized_produksi' => round($normalized_produksi, 3),
                'normalized_kehadiran' => round($normalized_kehadiran, 3),
                'score' => round($score, 3),
                'percentage' => round($score * 100, 1)
            ];
        }

        // 4. Urutkan berdasarkan skor tertinggi
        usort($scores, function ($a, $b) {
            return $b['score'] <=> $a['score'];
        });

        // Ambil 5 terbaik
        $top_saw = array_slice($scores, 0, 5);

        // Hitung statistik SAW
        $avg_score = array_sum(array_column($scores, 'score')) / count($scores);
        $max_score = max(array_column($scores, 'score'));
        $min_score = min(array_column($scores, 'score'));

        return [
            'alternatives' => $alternatives,
            'top_saw' => $top_saw,
            'stats' => [
                'total_alternatives' => count($alternatives),
                'avg_score' => $avg_score,
                'max_score' => $max_score,
                'min_score' => $min_score,
            ]
        ];
    }
}
