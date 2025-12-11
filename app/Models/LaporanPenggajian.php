<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanPenggajian extends Model
{
    use HasFactory;

    protected $table = 'laporan_penggajian';
    protected $primaryKey = 'id_laporan';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_laporan',
        'id_karyawan',
        'periode_start',
        'periode_end',
        'total_gaji',
        'total_bonus',
        'total_potongan',
        'total_bersih',
        'jumlah_hari',
        'created_at'
    ];

    protected $casts = [
        'periode_start' => 'date',
        'periode_end' => 'date',
        'total_gaji' => 'decimal:2',
        'total_bonus' => 'decimal:2',
        'total_potongan' => 'decimal:2',
        'total_bersih' => 'decimal:2',
        'jumlah_hari' => 'integer',
        'created_at' => 'datetime'
    ];

    public $timestamps = false;

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan', 'id_karyawan');
    }

    // Scope untuk periode
    public function scopePeriode($query, $start, $end)
    {
        return $query->whereBetween('periode_start', [$start, $end])
            ->orWhereBetween('periode_end', [$start, $end]);
    }

    public function scopeBulanIni($query)
    {
        $now = now();
        return $query->whereMonth('periode_start', $now->month)
            ->whereYear('periode_start', $now->year);
    }

    // Helper untuk format ID laporan
    public static function generateId()
    {
        $prefix = 'LAP-' . date('Ymd') . '-';
        $lastId = self::where('id_laporan', 'like', $prefix . '%')
            ->orderBy('id_laporan', 'desc')
            ->first();

        if ($lastId) {
            $lastNumber = intval(substr($lastId->id_laporan, -3));
            $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '001';
        }

        return $prefix . $newNumber;
    }
}
