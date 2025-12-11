<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Produk extends Model
{
    // SET TABLE NAME KE m_produk
    protected $table = 'm_produk';
    
    protected $primaryKey = 'id_produk';
    public $incrementing = false;
    protected $keyType = 'string';
    
    protected $fillable = [
        'id_produk',
        'nama_produk',
        'satuan',
        'status_produk'
    ];
    
    // Nonaktifkan timestamps
    public $timestamps = false;

    // Accessor untuk status
    public function getStatusLabelAttribute()
    {
        return $this->status_produk === 'aktif' ? 'Aktif' : 'Nonaktif';
    }

    // Scope untuk produk aktif
    public function scopeAktif($query)
    {
        return $query->where('status_produk', 'aktif');
    }

    // Scope untuk produk nonaktif
    public function scopeNonaktif($query)
    {
        return $query->where('status_produk', 'nonaktif');
    }
    
    // Method untuk cek apakah digunakan
    public function isUsed()
    {
        return DB::table('t_produk_karyawan')
            ->where('id_produk', $this->id_produk)
            ->exists();
    }
}