<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    protected $table = 'm_absensi';
    protected $primaryKey = 'id_absensi';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id_absensi',
        'tanggal',
        'jam_masuk',
        'jam_keluar',
        'lokasi',
        'catatan',
        'status_absensi'
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function karyawan()
    {
        return $this->belongsToMany(Karyawan::class, 't_absensi_karyawan', 'id_absensi', 'id_karyawan')
            ->withPivot('total_gaji', 'bonus_lembur', 'potongan', 'status_absensi')
            ->using(AbsensiKaryawan::class);
    }

    public function absensiKaryawan()
    {
        return $this->hasMany(AbsensiKaryawan::class, 'id_absensi', 'id_absensi');
    }
}