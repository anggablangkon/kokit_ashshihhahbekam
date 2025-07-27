<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProdukKlien extends Model
{
    use SoftDeletes;

    protected $table = 'produk_klien';  // Nama tabel

    protected $fillable = [
        'no_po',
        'nama_klien',
        'jenis_produk',
        'qty',
        'qty_terkirim',
        'keterangan',
        'cby',
        'mby',
    ];

    // Jika ingin otomatis cast tipe data tertentu (optional)
    protected $casts = [
        'qty' => 'integer',
        'cby' => 'integer',
        'mby' => 'integer',
    ];

    public function kedatangan()
    {
        return $this->hasMany(\App\Models\Kedatangan::class, 'produk_klien_id');
    }

    public function getQtyTerkirimAktifAttribute()
    {
        return $this->kedatangan()->whereNull('deleted_at')->sum('qty');
    }
}
