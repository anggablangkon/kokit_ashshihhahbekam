<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kedatangan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'kedatangan'; // Nama tabel

    protected $fillable = [
        'produk_klien_id',
        'qty',
        'tanggal_kedatangan',
        'keterangan',
        'cby',
    ];

    // Jika kolom tanggal_kedatangan ingin otomatis di-cast ke Carbon instance
    protected $dates = ['tanggal_kedatangan', 'deleted_at'];

    // Relasi ke produk klien
    public function produkKlien()
    {
        return $this->belongsTo(ProdukKlien::class, 'produk_klien_id');
    }
}
