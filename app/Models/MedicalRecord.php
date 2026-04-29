<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class MedicalRecord extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'patient_id',
        'patient_name',
        'employee_id',
        'employee_name',
        'complaint',
        'action_details',
        'total_cost',
        'treatment_date',
        'created_by',
        'updated_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'total_cost' => 'decimal:2',
            'treatment_date' => 'date',
        ];
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class)->withTrashed();
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'employee_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function getPatientDisplayNameAttribute(): string
    {
        return $this->patient?->name
            ?? $this->patient_name
            ?? '-';
    }

    public function getEmployeeDisplayNameAttribute(): string
    {
        return $this->employee?->name
            ?? $this->employee_name
            ?? '-';
    }
}
