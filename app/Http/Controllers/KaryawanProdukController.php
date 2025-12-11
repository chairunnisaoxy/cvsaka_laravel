<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Produk;
use App\Models\ProdukKaryawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class KaryawanProdukController extends Controller
{
    /**
     * Display produk karyawan page
     */
    public function produk(Karyawan $karyawan)
    {
        // Cek hak akses - hanya pemilik dan supervisor yang bisa akses
        if (!in_array(auth('karyawan')->user()->jabatan, ['pemilik', 'supervisor'])) {
            abort(403, 'Akses ditolak. Hanya pemilik dan supervisor yang dapat mengakses halaman ini.');
        }

        // Get data produk yang belum dimiliki karyawan (aktif saja)
        $produkBelumDimiliki = Produk::where('status_produk', 'aktif')
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
     * Get produk karyawan data for edit
     */
    public function getProdukKaryawan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_produk' => 'required|string',
            'id_karyawan' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal'
            ], 422);
        }

        try {
            $data = DB::table('t_produk_karyawan as tpk')
                ->join('m_produk as mp', 'tpk.id_produk', '=', 'mp.id_produk')
                ->select('tpk.*', 'mp.nama_produk')
                ->where('tpk.id_produk', $request->id_produk)
                ->where('tpk.id_karyawan', $request->id_karyawan)
                ->first();

            if ($data) {
                return response()->json([
                    'success' => true,
                    'data' => $data
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }
        } catch (\Exception $e) {
            \Log::error('Get produk karyawan error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store new produk karyawan
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_produk' => 'required|string|exists:m_produk,id_produk',
            'id_karyawan' => 'required|string|exists:m_karyawan,id_karyawan',
            'jml_aktual' => 'required|integer|min:1'
        ], [
            'id_produk.required' => 'Produk wajib dipilih',
            'id_produk.exists' => 'Produk tidak ditemukan',
            'jml_aktual.required' => 'Jumlah aktual wajib diisi',
            'jml_aktual.min' => 'Jumlah aktual harus lebih dari 0'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();

        try {
            // Cek apakah kombinasi sudah ada
            $existing = DB::table('t_produk_karyawan')
                ->where('id_produk', $request->id_produk)
                ->where('id_karyawan', $request->id_karyawan)
                ->exists();

            if ($existing) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data produk untuk karyawan ini sudah ada'
                ], 409);
            }

            // Cek apakah produk aktif
            $produkAktif = DB::table('m_produk')
                ->where('id_produk', $request->id_produk)
                ->where('status_produk', 'aktif')
                ->exists();

            if (!$produkAktif) {
                return response()->json([
                    'success' => false,
                    'message' => 'Produk tidak ditemukan atau tidak aktif'
                ], 404);
            }

            // Hitung jml_keranjang (ceil(jml_aktual / 500))
            $jml_keranjang = ceil($request->jml_aktual / 500);

            // Simpan data
            DB::table('t_produk_karyawan')->insert([
                'id_produk' => $request->id_produk,
                'id_karyawan' => $request->id_karyawan,
                'jml_aktual' => $request->jml_aktual,
                'jml_keranjang' => $jml_keranjang
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Data produk berhasil ditambahkan untuk karyawan'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Store produk karyawan error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update produk karyawan
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_produk' => 'required|string',
            'id_karyawan' => 'required|string',
            'jml_aktual' => 'required|integer|min:1'
        ], [
            'jml_aktual.required' => 'Jumlah aktual wajib diisi',
            'jml_aktual.min' => 'Jumlah aktual harus lebih dari 0'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();

        try {
            // Hitung jml_keranjang (ceil(jml_aktual / 500))
            $jml_keranjang = ceil($request->jml_aktual / 500);

            // Update data
            $updated = DB::table('t_produk_karyawan')
                ->where('id_produk', $request->id_produk)
                ->where('id_karyawan', $request->id_karyawan)
                ->update([
                    'jml_aktual' => $request->jml_aktual,
                    'jml_keranjang' => $jml_keranjang
                ]);

            if ($updated) {
                DB::commit();
                return response()->json([
                    'success' => true,
                    'message' => 'Data produk karyawan berhasil diubah'
                ]);
            } else {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Update produk karyawan error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengubah data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete produk karyawan
     */
    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_produk' => 'required|string',
            'id_karyawan' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal'
            ], 422);
        }

        DB::beginTransaction();

        try {
            $deleted = DB::table('t_produk_karyawan')
                ->where('id_produk', $request->id_produk)
                ->where('id_karyawan', $request->id_karyawan)
                ->delete();

            if ($deleted) {
                DB::commit();
                return response()->json([
                    'success' => true,
                    'message' => 'Data produk berhasil dihapus dari karyawan'
                ]);
            } else {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Delete produk karyawan error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus data: ' . $e->getMessage()
            ], 500);
        }
    }
}