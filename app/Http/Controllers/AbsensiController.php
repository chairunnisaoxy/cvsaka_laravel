<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AbsensiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Cek hak akses
        if (!in_array(auth('karyawan')->user()->jabatan, ['pemilik', 'supervisor'])) {
            abort(403, 'Akses ditolak. Hanya pemilik dan supervisor yang dapat mengakses halaman ini.');
        }

        $search = $request->get('search');
        $query = Absensi::query();

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('id_absensi', 'like', "%{$search}%")
                  ->orWhere('tanggal', 'like', "%{$search}%");
            });
        }

        $absensi = $query->orderBy('tanggal', 'desc')
                        ->orderBy('id_absensi')
                        ->paginate(20);

        return view('absensi.index', compact('absensi', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('absensi.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_absensi' => 'required|unique:m_absensi,id_absensi|regex:/^[A-Za-z0-9]+$/',
            'tanggal' => 'required|date',
            'jam_keluar' => 'nullable|date_format:H:i',
        ], [
            'jam_keluar.after' => 'Jam keluar harus setelah jam masuk (07:00)',
        ]);

        try {
            // Validasi jam keluar > 07:00
            if ($request->jam_keluar && $request->jam_keluar <= '07:00') {
                return response()->json([
                    'success' => false,
                    'message' => 'Jam keluar harus setelah jam masuk (07:00)'
                ]);
            }

            $data = $request->all();
            $data['jam_masuk'] = '07:00'; // Default jam masuk

            Absensi::create($data);

            return response()->json([
                'success' => true,
                'message' => 'Data absensi berhasil ditambahkan'
            ]);
        } catch (\Exception $e) {
            Log::error('Error creating absensi: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan data absensi: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Absensi $absensi)
    {
        // Tidak digunakan karena detail ada di karyawan.blade.php
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Absensi $absensi)
    {
        return response()->json([
            'success' => true,
            'data' => $absensi
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Absensi $absensi)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'jam_keluar' => 'nullable|date_format:H:i',
        ], [
            'jam_keluar.after' => 'Jam keluar harus setelah jam masuk (07:00)',
        ]);

        try {
            // Validasi jam keluar > 07:00
            if ($request->jam_keluar && $request->jam_keluar <= '07:00') {
                return response()->json([
                    'success' => false,
                    'message' => 'Jam keluar harus setelah jam masuk (07:00)'
                ]);
            }

            $absensi->update([
                'tanggal' => $request->tanggal,
                'jam_keluar' => $request->jam_keluar
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Data absensi berhasil diubah'
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating absensi: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengubah data absensi: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Absensi $absensi)
    {
        try {
            $absensi->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Data absensi berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            Log::error('Error deleting absensi: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus data absensi: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Get absensi data for AJAX
     */
    public function getAbsensi($id)
    {
        $absensi = Absensi::find($id);
        
        if (!$absensi) {
            return response()->json([
                'success' => false,
                'message' => 'Data absensi tidak ditemukan'
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => $absensi
        ]);
    }
}