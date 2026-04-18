<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Testimonial extends Model
{
    use SoftDeletes;

    protected $table = 'testimonial'; // nama tabel sesuai yang ada di database

    protected $fillable = [
        'nama',
        'foto',
        'rating',
        'judul',
        'pesan',
        'cby',
        'mby',
    ];
}
