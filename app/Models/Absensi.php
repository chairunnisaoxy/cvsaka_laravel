<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    protected $table = 'm_absensi';
    protected $primaryKey = 'id_absensi';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_absensi',
        'tanggal',
        'jam_masuk',
        'jam_keluar'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jam_masuk' => 'datetime:H:i:s',
        'jam_keluar' => 'datetime:H:i:s'
    ];

    public $timestamps = false;

    public function karyawans()
    {
        return $this->belongsToMany(Karyawan::class, 't_absensi_karyawan', 'id_absensi', 'id_karyawan')
            ->withPivot('total_gaji', 'bonus_lembur', 'potongan', 'total_aktual', 'status_absensi');
    }

    public function absensiKaryawan()
    {
        return $this->hasMany(AbsensiKaryawan::class, 'id_absensi', 'id_absensi');
    }

    // Scope untuk tanggal
    public function scopeBulanIni($query)
    {
        return $query->whereMonth('tanggal', date('m'))
            ->whereYear('tanggal', date('Y'));
    }

    public function scopePeriode($query, $start, $end)
    {
        return $query->whereBetween('tanggal', [$start, $end]);
    }
}
