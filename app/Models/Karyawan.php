<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Karyawan extends Authenticatable
{
    use HasFactory;

    protected $table = 'm_karyawan';
    protected $primaryKey = 'id_karyawan';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id_karyawan',
        'nama_karyawan',
        'email',
        'password',
        'jabatan',
        'status_karyawan',
        'gaji_harian',
        'no_telp',
        'alamat',
        'jml_target',
        'total_hadir'
    ];

    protected $hidden = [
        'password',
    ];

    // Get auth identifier name
    public function getAuthIdentifierName()
    {
        return 'id_karyawan';
    }

    // Get auth identifier
    public function getAuthIdentifier()
    {
        return $this->id_karyawan;
    }

    // Get auth password
    public function getAuthPassword()
    {
        return $this->password;
    }

    // Check if user is pemilik
    public function isPemilik()
    {
        return $this->jabatan === 'pemilik';
    }

    // Check if user is supervisor
    public function isSupervisor()
    {
        return $this->jabatan === 'supervisor';
    }

    // Check if user is operator
    public function isOperator()
    {
        return $this->jabatan === 'operator';
    }

    // Check if user is active
    public function isActive()
    {
        return $this->status_karyawan === 'aktif';
    }
}