<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            // Cek hak akses
            $user = auth('karyawan')->user();
            if (!$user) {
                return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
            }
            
            if (!in_array($user->jabatan, ['pemilik', 'supervisor'])) {
                abort(403, 'Akses ditolak. Hanya pemilik dan supervisor yang dapat mengakses halaman ini.');
            }

            $search = $request->get('search');
            
            // Gunakan model Produk
            $query = Produk::query();
            
            if ($search) {
                $query->where(function($q) use ($search) {
                    $q->where('id_produk', 'like', "%{$search}%")
                      ->orWhere('nama_produk', 'like', "%{$search}%")
                      ->orWhere('satuan', 'like', "%{$search}%");
                });
            }

            $produk = $query->orderBy('id_produk')->get();

            return view('produk.index', compact('produk', 'search'));
            
        } catch (\Exception $e) {
            \Log::error('ProdukController@index Error: ' . $e->getMessage());
            
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        
        try {
            // Validasi
            $validator = Validator::make($request->all(), [
                'id_produk' => 'required|unique:m_produk,id_produk|regex:/^[A-Z0-9]+$/|max:20',
                'nama_produk' => 'required|string|max:255',
                'satuan' => 'required|string|max:50',
                'status_produk' => 'required|in:aktif,nonaktif',
            ], [
                'id_produk.required' => 'ID Produk wajib diisi',
                'id_produk.unique' => 'ID Produk sudah digunakan',
                'id_produk.regex' => 'ID Produk hanya boleh mengandung huruf kapital dan angka',
                'nama_produk.required' => 'Nama Produk wajib diisi',
                'satuan.required' => 'Satuan wajib diisi',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Buat produk
            $produk = Produk::create([
                'id_produk' => strtoupper($request->id_produk),
                'nama_produk' => $request->nama_produk,
                'satuan' => $request->satuan,
                'status_produk' => $request->status_produk,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil ditambahkan',
                'data' => $produk
            ], 201);

        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();
            
            $errorCode = $e->errorInfo[1];
            
            if ($errorCode == 1062) {
                return response()->json([
                    'success' => false,
                    'message' => 'ID Produk sudah ada dalam database'
                ], 409);
            }
            
            \Log::error('ProdukController@store Database Error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan database'
            ], 500);
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            \Log::error('ProdukController@store Error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $produk = Produk::findOrFail($id);
            
            return response()->json([
                'success' => true,
                'data' => $produk
            ]);
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            \Log::error('Produk not found: ' . $id);
            
            return response()->json([
                'success' => false,
                'message' => 'Produk tidak ditemukan'
            ], 404);
            
        } catch (\Exception $e) {
            \Log::error('ProdukController@edit Error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan'
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        
        try {
            $produk = Produk::findOrFail($id);
            
            $validator = Validator::make($request->all(), [
                'nama_produk' => 'required|string|max:255',
                'satuan' => 'required|string|max:50',
                'status_produk' => 'required|in:aktif,nonaktif',
            ], [
                'nama_produk.required' => 'Nama Produk wajib diisi',
                'satuan.required' => 'Satuan wajib diisi',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }

            $produk->update([
                'nama_produk' => $request->nama_produk,
                'satuan' => $request->satuan,
                'status_produk' => $request->status_produk,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Data produk berhasil diubah'
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Produk tidak ditemukan'
            ], 404);
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            \Log::error('ProdukController@update Error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        
        try {
            $produk = Produk::findOrFail($id);
            $nama_produk = $produk->nama_produk;
            
            // Cek apakah produk digunakan
            $used = DB::table('t_produk_karyawan')
                    ->where('id_produk', $id)
                    ->exists();
                    
            if ($used) {
                return response()->json([
                    'success' => false,
                    'message' => 'Produk tidak dapat dihapus karena masih digunakan oleh karyawan'
                ], 422);
            }
            
            $produk->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Produk "' . $nama_produk . '" berhasil dihapus'
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Produk tidak ditemukan'
            ], 404);
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            \Log::error('ProdukController@destroy Error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Nonaktifkan produk
     */
    public function nonaktifkan($id)
    {
        DB::beginTransaction();
        
        try {
            $produk = Produk::findOrFail($id);
            $produk->update(['status_produk' => 'nonaktif']);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Produk "' . $produk->nama_produk . '" berhasil dinonaktifkan'
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Produk tidak ditemukan'
            ], 404);
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            \Log::error('ProdukController@nonaktifkan Error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan'
            ], 500);
        }
    }

    /**
     * Aktifkan produk
     */
    public function aktifkan($id)
    {
        DB::beginTransaction();
        
        try {
            $produk = Produk::findOrFail($id);
            $produk->update(['status_produk' => 'aktif']);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Produk "' . $produk->nama_produk . '" berhasil diaktifkan'
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Produk tidak ditemukan'
            ], 404);
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            \Log::error('ProdukController@aktifkan Error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan'
            ], 500);
        }
    }
}