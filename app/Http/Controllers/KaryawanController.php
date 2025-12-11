<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class KaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Cek hak akses - hanya pemilik dan supervisor yang bisa akses
        if (!in_array(auth('karyawan')->user()->jabatan, ['pemilik', 'supervisor'])) {
            abort(403, 'Akses ditolak. Hanya pemilik dan supervisor yang dapat mengakses halaman ini.');
        }

        $search = $request->get('search');
        $query = Karyawan::query();

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('id_karyawan', 'like', "%{$search}%")
                  ->orWhere('nama_karyawan', 'like', "%{$search}%")
                  ->orWhere('jabatan', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('status_karyawan', 'like', "%{$search}%");
            });
        }

        // Hitung total hadir dan status untuk setiap karyawan
        $karyawan = $query->orderBy('id_karyawan')->get();
        
        foreach ($karyawan as $k) {
            $this->checkAndArchiveIfNeeded($k->id_karyawan);
            $this->updateTotalHadir($k->id_karyawan);
        }

        return view('karyawan.index', compact('karyawan', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('karyawan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_karyawan' => 'required|unique:m_karyawan,id_karyawan|regex:/^[A-Za-z0-9]+$/',
            'nama_karyawan' => 'required',
            'jabatan' => 'required|in:pemilik,supervisor,operator',
            'gaji_harian' => 'nullable|numeric|min:0',
            'email' => 'nullable|email',
            'password' => 'nullable|min:6',
            'no_telp' => 'nullable',
            'alamat' => 'nullable',
            'status_karyawan' => 'required|in:aktif,nonaktif',
            'jml_target' => 'nullable|integer|min:0',
        ]);

        try {
            $data = $request->all();
            
            // Hash password jika diisi untuk pemilik/supervisor
            if (in_array($data['jabatan'], ['pemilik', 'supervisor']) && !empty($data['password'])) {
                $data['password'] = bcrypt($data['password']);
            } else {
                $data['password'] = null;
            }

            // Set default values
            $data['gaji_harian'] = $data['gaji_harian'] ?? 100000;
            $data['jml_target'] = $data['jml_target'] ?? 500;
            $data['total_hadir'] = 0;

            Karyawan::create($data);

            return response()->json([
                'success' => true,
                'message' => 'Data karyawan berhasil ditambahkan'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan data karyawan: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Karyawan $karyawan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Karyawan $karyawan)
    {
        // Hitung total hadir untuk karyawan ini
        $totalHadir = $this->updateTotalHadir($karyawan->id_karyawan);
        
        return response()->json([
            'success' => true,
            'data' => $karyawan,
            'total_hadir' => $totalHadir
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Karyawan $karyawan)
    {
        $request->validate([
            'nama_karyawan' => 'required',
            'jabatan' => 'required|in:pemilik,supervisor,operator',
            'gaji_harian' => 'nullable|numeric|min:0',
            'email' => 'nullable|email',
            'password' => 'nullable|min:6',
            'no_telp' => 'nullable',
            'alamat' => 'nullable',
            'status_karyawan' => 'required|in:aktif,nonaktif',
            'jml_target' => 'nullable|integer|min:0',
        ]);

        try {
            $data = $request->except('id_karyawan');
            $oldJabatan = $karyawan->jabatan;
            $newJabatan = $data['jabatan'];

            // Handle password update
            if (in_array($newJabatan, ['pemilik', 'supervisor'])) {
                if (!empty($data['password'])) {
                    $data['password'] = bcrypt($data['password']);
                } elseif (!in_array($oldJabatan, ['pemilik', 'supervisor']) || empty($karyawan->password)) {
                    // Jika berubah dari operator ke pemilik/supervisor, buat password default
                    $data['password'] = bcrypt('123456');
                } else {
                    // Tetap pemilik/supervisor, password tidak diubah
                    unset($data['password']);
                }
            } else {
                // Jabatan operator - set password ke null
                $data['password'] = null;
            }

            $karyawan->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Data karyawan berhasil diubah'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengubah data karyawan: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Karyawan $karyawan)
    {
        try {
            $karyawan->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Data karyawan berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus data karyawan: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Cetak slip gaji
     */
    public function cetakSlip(Karyawan $karyawan)
    {
        $this->checkAndArchiveIfNeeded($karyawan->id_karyawan);
        
        // Ambil data absensi aktif untuk 14 hari terakhir
        $dataAbsensi = DB::table('t_absensi_karyawan as tak')
            ->join('m_absensi as ma', 'tak.id_absensi', '=', 'ma.id_absensi')
            ->select(
                'tak.id_absensi',
                'tak.total_gaji',
                'tak.bonus_lembur',
                'tak.potongan',
                'ma.tanggal',
                DB::raw('(tak.total_gaji + tak.bonus_lembur - tak.potongan) as total_bersih'),
                DB::raw('DAYNAME(ma.tanggal) as nama_hari')
            )
            ->where('tak.id_karyawan', $karyawan->id_karyawan)
            ->where('tak.status_absensi', 'hadir')
            ->orderBy('ma.tanggal', 'desc')
            ->limit(14)
            ->get()
            ->reverse()
            ->values();

        // Hitung totals
        $totalGaji = $dataAbsensi->sum('total_gaji');
        $totalBonus = $dataAbsensi->sum('bonus_lembur');
        $totalPotongan = $dataAbsensi->sum('potongan');
        $totalBersih = $dataAbsensi->sum('total_bersih');
        $jumlahHari = $dataAbsensi->count();

        // Hitung total hadir aktif
        $totalHadirAktif = DB::table('t_absensi_karyawan')
            ->where('id_karyawan', $karyawan->id_karyawan)
            ->where('status_absensi', 'hadir')
            ->count();

        // Tentukan periode
        if ($dataAbsensi->isNotEmpty()) {
            $periodeStart = $dataAbsensi->first()->tanggal;
            $periodeEnd = $dataAbsensi->last()->tanggal;
        } else {
            $periodeStart = $periodeEnd = now()->format('Y-m-d');
        }

        // Hitung total hadir keseluruhan
        $totalHadirKeseluruhan = $this->updateTotalHadir($karyawan->id_karyawan);

        return view('karyawan.slip', compact(
            'karyawan',
            'dataAbsensi',
            'totalGaji',
            'totalBonus',
            'totalPotongan',
            'totalBersih',
            'jumlahHari',
            'totalHadirAktif',
            'periodeStart',
            'periodeEnd',
            'totalHadirKeseluruhan'
        ));
    }

    /**
     * Halaman detail produk karyawan
     */
    public function produk(Karyawan $karyawan)
    {
        // Cek hak akses
        if (!in_array(auth('karyawan')->user()->jabatan, ['pemilik', 'supervisor'])) {
            abort(403, 'Akses ditolak. Hanya pemilik dan supervisor yang dapat mengakses halaman ini.');
        }
        
        // Panggil method produk dari ProdukKaryawanController
        // Atau implementasi sederhana tanpa controller terpisah:
        return $this->produkDetail($karyawan);
    }

    /**
     * Implementasi sederhana untuk produk detail
     */
    private function produkDetail(Karyawan $karyawan)
    {
        // Get data produk yang belum dimiliki karyawan (aktif saja)
        $produkBelumDimiliki = \App\Models\Produk::where('status_produk', 'aktif')
            ->whereNotIn('id_produk', function ($query) use ($karyawan) {
                $query->select('id_produk')
                    ->from('t_produk_karyawan')
                    ->where('id_karyawan', $karyawan->id_karyawan);
            })
            ->orderBy('nama_produk')
            ->get();

        // Get data produk yang sudah dimiliki karyawan
        $produkKaryawan = DB::table('t_produk_karyawan as tpk')
            ->join('m_produk as mp', 'tpk.id_produk', '=', 'mp.id_produk')
            ->select(
                'tpk.id_produk',
                'tpk.id_karyawan',
                'tpk.jml_aktual',
                'tpk.jml_keranjang',
                'mp.nama_produk',
                'mp.satuan'
            )
            ->where('tpk.id_karyawan', $karyawan->id_karyawan)
            ->orderBy('mp.nama_produk')
            ->get();

        return view('karyawan.produk', compact(
            'karyawan',
            'produkBelumDimiliki',
            'produkKaryawan'
        ));
    }

    /**
     * Get data karyawan by ID (for AJAX request)
     */
    public function getKaryawan($id)
    {
        $karyawan = Karyawan::find($id);
        
        if (!$karyawan) {
            return response()->json([
                'success' => false,
                'message' => 'Data karyawan tidak ditemukan'
            ]);
        }

        // Hitung total hadir
        $totalHadir = $this->updateTotalHadir($karyawan->id_karyawan);

        return response()->json([
            'success' => true,
            'data' => $karyawan,
            'total_hadir' => $totalHadir
        ]);
    }

    /**
     * Calculate total hadir for karyawan
     */
    public function calculateTotalHadir($id)
    {
        $totalHadir = $this->updateTotalHadir($id);
        
        return response()->json([
            'success' => true,
            'total_hadir' => $totalHadir
        ]);
    }

    // ================================================
    // SISTEM PENGGAJIAN DENGAN RESET 14 HARI
    // ================================================

    private function checkAndArchiveIfNeeded($idKaryawan)
    {
        $totalHadirAktif = DB::table('t_absensi_karyawan')
            ->where('id_karyawan', $idKaryawan)
            ->where('status_absensi', 'hadir')
            ->count();

        if ($totalHadirAktif >= 14) {
            $this->laporanPenggajian($idKaryawan);
        }

        return false;
    }

    private function laporanPenggajian($idKaryawan)
    {
        // Ambil data 14 hari pertama (terlama)
        $dataLaporan = DB::table('t_absensi_karyawan as tak')
            ->join('m_absensi as ma', 'tak.id_absensi', '=', 'ma.id_absensi')
            ->join('m_karyawan as mk', 'tak.id_karyawan', '=', 'mk.id_karyawan')
            ->select('tak.*', 'ma.tanggal', 'mk.nama_karyawan', 'mk.jabatan')
            ->where('tak.id_karyawan', $idKaryawan)
            ->where('tak.status_absensi', 'hadir')
            ->orderBy('ma.tanggal', 'asc')
            ->limit(14)
            ->get();

        $jumlahData = $dataLaporan->count();

        // Hanya arsipkan jika TEPAT 14 hari
        if ($jumlahData == 14) {
            $periodeStart = $dataLaporan->first()->tanggal;
            $periodeEnd = $dataLaporan->last()->tanggal;

            // Hitung totals
            $totalGaji = $dataLaporan->sum('total_gaji');
            $totalBonus = $dataLaporan->sum('bonus_lembur');
            $totalPotongan = $dataLaporan->sum('potongan');
            $totalBersih = $totalGaji + $totalBonus - $totalPotongan;

            // Generate ID laporan
            $idLaporan = 'LAP-' . now()->format('Ymd-His') . '-' . $idKaryawan;
            $jumlahHari = 14;

            // Simpan ke laporan_penggajian
            DB::table('laporan_penggajian')->insert([
                'id_laporan' => $idLaporan,
                'id_karyawan' => $idKaryawan,
                'periode_start' => $periodeStart,
                'periode_end' => $periodeEnd,
                'total_gaji' => $totalGaji,
                'total_bonus' => $totalBonus,
                'total_potongan' => $totalPotongan,
                'total_bersih' => $totalBersih,
                'jumlah_hari' => $jumlahHari,
                'created_at' => now(),
            ]);

            // Hapus data yang sudah diarsipkan
            DB::table('t_absensi_karyawan as tak')
                ->join('m_absensi as ma', 'tak.id_absensi', '=', 'ma.id_absensi')
                ->where('tak.id_karyawan', $idKaryawan)
                ->where('ma.tanggal', '>=', $periodeStart)
                ->where('ma.tanggal', '<=', $periodeEnd)
                ->where('tak.status_absensi', 'hadir')
                ->delete();

            // Update total hadir
            $this->updateTotalHadir($idKaryawan);

            return true;
        }

        return false;
    }

    private function updateTotalHadir($idKaryawan)
    {
        // Hitung dari absensi aktif
        $totalHadirAktif = DB::table('t_absensi_karyawan')
            ->where('id_karyawan', $idKaryawan)
            ->where('status_absensi', 'hadir')
            ->count();

        // Hitung dari laporan yang sudah diarsipkan
        $totalHadirArsip = DB::table('laporan_penggajian')
            ->where('id_karyawan', $idKaryawan)
            ->sum('jumlah_hari');

        // Total keseluruhan
        $totalHadir = $totalHadirAktif + $totalHadirArsip;

        // Update total_hadir di m_karyawan
        DB::table('m_karyawan')
            ->where('id_karyawan', $idKaryawan)
            ->update(['total_hadir' => $totalHadir]);

        return $totalHadir;
    }

    private function checkAllKaryawanForArchive()
    {
        $karyawanIds = Karyawan::where('status_karyawan', 'aktif')
            ->pluck('id_karyawan');

        $totalArchived = 0;
        foreach ($karyawanIds as $id) {
            if ($this->checkAndArchiveIfNeeded($id)) {
                $totalArchived++;
            }
        }

        Log::info("Auto-archive selesai: {$totalArchived} karyawan diarsipkan");
        return $totalArchived;
    }

    private function updateAllTotalHadir()
    {
        $karyawanIds = Karyawan::pluck('id_karyawan');
        foreach ($karyawanIds as $id) {
            $this->updateTotalHadir($id);
        }
    }
}