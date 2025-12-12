<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AbsensiKaryawan extends Model
{
    protected $table = 't_absensi_karyawan';
    protected $primaryKey = ['id_absensi', 'id_karyawan'];
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id_absensi',
        'id_karyawan',
        'status_absensi',
        'total_gaji',
        'bonus_lembur',
        'potongan'
    ];

    protected $casts = [
        'total_gaji' => 'decimal:2',
        'bonus_lembur' => 'decimal:2',
        'potongan' => 'decimal:2',
    ];

    public function absensi()
    {
        return $this->belongsTo(Absensi::class, 'id_absensi', 'id_absensi');
    }

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan', 'id_karyawan');
    }
}