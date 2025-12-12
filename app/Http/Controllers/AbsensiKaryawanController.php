<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\AbsensiKaryawan;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AbsensiKaryawanController extends Controller
{
    /**
     * Display karyawan in absensi
     */
    public function karyawan(Absensi $absensi)
    {
        // Cek hak akses
        if (!in_array(auth('karyawan')->user()->jabatan, ['pemilik', 'supervisor'])) {
            abort(403, 'Akses ditolak. Hanya pemilik dan supervisor yang dapat mengakses halaman ini.');
        }

        // Get karyawan yang belum ada di absensi ini
        $karyawanBelumDitambahkan = Karyawan::where('status_karyawan', 'aktif')
            ->whereNotIn('id_karyawan', function ($query) use ($absensi) {
                $query->select('id_karyawan')
                    ->from('t_absensi_karyawan')
                    ->where('id_absensi', $absensi->id_absensi);
            })
            ->orderBy('nama_karyawan')
            ->get();

        // Get karyawan yang sudah ada di absensi ini
        $karyawanAbsensi = DB::table('t_absensi_karyawan as tak')
            ->join('m_karyawan as mk', 'tak.id_karyawan', '=', 'mk.id_karyawan')
            ->select(
                'tak.*',
                'mk.nama_karyawan',
                'mk.jabatan',
                DB::raw('(tak.total_gaji + tak.bonus_lembur - tak.potongan) as total_bersih')
            )
            ->where('tak.id_absensi', $absensi->id_absensi)
            ->orderBy('mk.nama_karyawan')
            ->get();

        return view('absensi.karyawan', compact(
            'absensi',
            'karyawanBelumDitambahkan',
            'karyawanAbsensi'
        ));
    }

    /**
     * Get absensi karyawan data for edit
     */
    public function getData(Request $request)
    {
        $request->validate([
            'id_karyawan' => 'required|string',
            'id_absensi' => 'required|string'
        ]);

        try {
            $data = DB::table('t_absensi_karyawan as tak')
                ->join('m_karyawan as mk', 'tak.id_karyawan', '=', 'mk.id_karyawan')
                ->select('tak.*', 'mk.nama_karyawan')
                ->where('tak.id_karyawan', $request->id_karyawan)
                ->where('tak.id_absensi', $request->id_absensi)
                ->first();

            if ($data) {
                return response()->json([
                    'success' => true,
                    'data' => $data
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        } catch (\Exception $e) {
            Log::error('Error getting absensi karyawan: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store new absensi karyawan
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_karyawan' => 'required|string|exists:m_karyawan,id_karyawan',
            'id_absensi' => 'required|string|exists:m_absensi,id_absensi',
            'status_absensi' => 'required|in:hadir,tidak hadir,cuti',
            'total_gaji' => 'required|numeric|min:0',
            'bonus_lembur' => 'nullable|numeric|min:0',
            'potongan' => 'nullable|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
            // Cek apakah kombinasi sudah ada
            $existing = DB::table('t_absensi_karyawan')
                ->where('id_karyawan', $request->id_karyawan)
                ->where('id_absensi', $request->id_absensi)
                ->exists();

            if ($existing) {
                return response()->json([
                    'success' => false,
                    'message' => 'Karyawan sudah ada di absensi ini'
                ], 409);
            }

            // Cek apakah karyawan aktif
            $karyawanAktif = DB::table('m_karyawan')
                ->where('id_karyawan', $request->id_karyawan)
                ->where('status_karyawan', 'aktif')
                ->exists();

            if (!$karyawanAktif) {
                return response()->json([
                    'success' => false,
                    'message' => 'Karyawan tidak aktif'
                ], 404);
            }

            // Simpan data
            DB::table('t_absensi_karyawan')->insert([
                'id_karyawan' => $request->id_karyawan,
                'id_absensi' => $request->id_absensi,
                'status_absensi' => $request->status_absensi,
                'total_gaji' => $request->total_gaji,
                'bonus_lembur' => $request->bonus_lembur ?? 0,
                'potongan' => $request->potongan ?? 0,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Data karyawan berhasil ditambahkan ke absensi'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error storing absensi karyawan: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update absensi karyawan
     */
    public function update(Request $request)
    {
        $request->validate([
            'id_karyawan' => 'required|string',
            'id_absensi' => 'required|string',
            'status_absensi' => 'required|in:hadir,tidak hadir,cuti',
            'total_gaji' => 'required|numeric|min:0',
            'bonus_lembur' => 'nullable|numeric|min:0',
            'potongan' => 'nullable|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
            $updated = DB::table('t_absensi_karyawan')
                ->where('id_karyawan', $request->id_karyawan)
                ->where('id_absensi', $request->id_absensi)
                ->update([
                    'status_absensi' => $request->status_absensi,
                    'total_gaji' => $request->total_gaji,
                    'bonus_lembur' => $request->bonus_lembur ?? 0,
                    'potongan' => $request->potongan ?? 0,
                ]);

            if ($updated) {
                DB::commit();
                return response()->json([
                    'success' => true,
                    'message' => 'Data absensi karyawan berhasil diubah'
                ]);
            }

            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating absensi karyawan: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengubah data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete absensi karyawan
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'id_karyawan' => 'required|string',
            'id_absensi' => 'required|string'
        ]);

        DB::beginTransaction();

        try {
            $deleted = DB::table('t_absensi_karyawan')
                ->where('id_karyawan', $request->id_karyawan)
                ->where('id_absensi', $request->id_absensi)
                ->delete();

            if ($deleted) {
                DB::commit();
                return response()->json([
                    'success' => true,
                    'message' => 'Data karyawan berhasil dihapus dari absensi'
                ]);
            }

            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deleting absensi karyawan: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus data: ' . $e->getMessage()
            ], 500);
        }
    }
}