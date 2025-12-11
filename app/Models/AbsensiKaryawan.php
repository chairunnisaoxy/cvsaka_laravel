<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbsensiKaryawan extends Model
{
    use HasFactory;

    protected $table = 't_absensi_karyawan';

    // Composite primary key
    protected $primaryKey = ['id_karyawan', 'id_absensi'];
    public $incrementing = false;

    protected $fillable = [
        'id_karyawan',
        'id_absensi',
        'total_gaji',
        'bonus_lembur',
        'potongan',
        'total_aktual',
        'status_absensi'
    ];

    protected $casts = [
        'total_gaji' => 'decimal:2',
        'bonus_lembur' => 'decimal:2',
        'potongan' => 'decimal:2',
        'total_aktual' => 'integer'
    ];

    public $timestamps = false;

    // Relationships
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan', 'id_karyawan');
    }

    public function absensi()
    {
        return $this->belongsTo(Absensi::class, 'id_absensi', 'id_absensi');
    }

    // Helper methods
    public function getTotalBersihAttribute()
    {
        return (float) $this->total_gaji + (float) $this->bonus_lembur - (float) $this->potongan;
    }

    public function isHadir()
    {
        return $this->status_absensi === 'hadir';
    }
}
