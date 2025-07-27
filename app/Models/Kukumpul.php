<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kukumpul extends Model
{
    use SoftDeletes;

    protected $table = 'kukumpuls';

    protected $fillable = [
        'nama',
        'nohp',
        'keterangan',
        'rupiah',
        'cby',
        'mby'
    ];

    protected $dates = ['deleted_at']; // untuk soft delete
}
