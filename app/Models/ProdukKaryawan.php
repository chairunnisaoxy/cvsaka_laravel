<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdukKaryawan extends Model
{
    use HasFactory;

    protected $table = 't_produk_karyawan';
    protected $primaryKey = ['id_produk', 'id_karyawan'];
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id_produk',
        'id_karyawan',
        'jml_aktual',
        'jml_keranjang',
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id_produk');
    }

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan', 'id_karyawan');
    }
}