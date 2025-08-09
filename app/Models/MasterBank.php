<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterBank extends Model
{
    use SoftDeletes;

    protected $table = 'master_banks';

    protected $fillable = [
        'bank_name',
        'account_number',
        'account_holder',
        'cby',
        'mby',
    ];

    protected $dates = ['deleted_at'];
}
