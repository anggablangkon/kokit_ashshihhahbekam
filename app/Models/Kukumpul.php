<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class Kukumpul extends Model
{
    use SoftDeletes;
    protected $table = 'kukumpul';
    protected $fillable = [
        'nama',
        'nohp',
        'invoice',
        'keterangan',
        'rupiah',
        'tanggal',
        'status',
        'provinsi_id',
        'cby',
        'mby'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'deleted_at' => 'datetime',
    ];

    // Tambahkan ini agar 'tanggal' auto-terisi saat create
    protected static function booted()
    {
        static::creating(function ($model) {
            if (empty($model->tanggal)) {
                $model->tanggal = Carbon::now();
            }
        });
    }
}
