<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class MedicalRecordItem extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'medical_record_id',
        'treatment_id',
        'treatment_name',
        'qty',
        'price',
        'discount',
        'commission',
        'subtotal',
        'created_by',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'discount' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    public function medicalRecord(): BelongsTo
    {
        return $this->belongsTo(MedicalRecord::class);
    }
}