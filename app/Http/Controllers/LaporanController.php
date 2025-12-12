<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search', '');

        // Query laporan penggajian
        $query = DB::table('laporan_penggajian as lp')
            ->join('m_karyawan as mk', 'lp.id_karyawan', '=', 'mk.id_karyawan')
            ->select('lp.*', 'mk.nama_karyawan', 'mk.jabatan')
            ->orderBy('lp.created_at', 'desc');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('lp.id_laporan', 'like', "%{$search}%")
                    ->orWhere('mk.nama_karyawan', 'like', "%{$search}%")
                    ->orWhere('mk.id_karyawan', 'like', "%{$search}%");
            });
        }

        $laporan = $query->paginate(10);

        // Data karyawan untuk filter
        $karyawan = DB::table('m_karyawan')
            ->select('id_karyawan', 'nama_karyawan')
            ->orderBy('nama_karyawan')
            ->get();

        return view('laporan.index', compact('laporan', 'karyawan', 'search'));
    }

    public function cetakDetail($id)
    {
        $laporan = DB::table('laporan_penggajian as lp')
            ->join('m_karyawan as mk', 'lp.id_karyawan', '=', 'mk.id_karyawan')
            ->select('lp.*', 'mk.nama_karyawan', 'mk.jabatan')
            ->where('lp.id_laporan', $id)
            ->first();

        if (!$laporan) {
            abort(404, 'Laporan tidak ditemukan');
        }

        return view('laporan.cetak-detail', compact('laporan'));
    }

    public function cetakSemua(Request $request)
    {
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $id_karyawan = $request->input('id_karyawan');

        // Query laporan dengan filter
        $query = DB::table('laporan_penggajian as lp')
            ->join('m_karyawan as mk', 'lp.id_karyawan', '=', 'mk.id_karyawan')
            ->select('lp.*', 'mk.nama_karyawan', 'mk.jabatan');

        if ($start_date && $end_date) {
            $query->where('lp.periode_start', '>=', $start_date)
                ->where('lp.periode_end', '<=', $end_date);
        }

        if ($id_karyawan) {
            $query->where('lp.id_karyawan', $id_karyawan);
        }

        $laporan = $query->orderBy('lp.periode_start', 'desc')
            ->orderBy('mk.nama_karyawan', 'asc')
            ->get();

        // Hitung total
        $total_gaji_keseluruhan = $laporan->sum('total_gaji');
        $total_bonus_keseluruhan = $laporan->sum('total_bonus');
        $total_potongan_keseluruhan = $laporan->sum('total_potongan');
        $total_bersih_keseluruhan = $laporan->sum('total_bersih');
        $jumlah_karyawan = $laporan->groupBy('id_karyawan')->count();

        // Group by karyawan
        $karyawan_data = [];
        foreach ($laporan as $item) {
            $id_karyawan = $item->id_karyawan;
            if (!isset($karyawan_data[$id_karyawan])) {
                $karyawan_data[$id_karyawan] = [
                    'nama' => $item->nama_karyawan,
                    'jabatan' => $item->jabatan,
                    'total_laporan' => 0,
                    'total_gaji' => 0,
                    'total_bonus' => 0,
                    'total_potongan' => 0,
                    'total_bersih' => 0,
                    'total_hari' => 0,
                    'laporan_detail' => []
                ];
            }

            $karyawan_data[$id_karyawan]['total_laporan']++;
            $karyawan_data[$id_karyawan]['total_gaji'] += $item->total_gaji;
            $karyawan_data[$id_karyawan]['total_bonus'] += $item->total_bonus;
            $karyawan_data[$id_karyawan]['total_potongan'] += $item->total_potongan;
            $karyawan_data[$id_karyawan]['total_bersih'] += $item->total_bersih;
            $karyawan_data[$id_karyawan]['total_hari'] += $item->jumlah_hari;
            $karyawan_data[$id_karyawan]['laporan_detail'][] = $item;
        }

        return view('laporan.cetak-semua', compact(
            'laporan',
            'karyawan_data',
            'total_gaji_keseluruhan',
            'total_bonus_keseluruhan',
            'total_potongan_keseluruhan',
            'total_bersih_keseluruhan',
            'jumlah_karyawan',
            'start_date',
            'end_date',
            'id_karyawan'
        ));
    }
}
