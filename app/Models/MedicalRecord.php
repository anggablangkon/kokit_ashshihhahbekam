<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class MedicalRecord extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'patient_id',
        'employee_id',
        'complaint',
        'invoice_number',
        'action_details',
        'total_cost',
        'treatment_date',
        'created_by',
        'updated_by',
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            // 1. Logika Auto-Generate Invoice Number
            // Menggunakan ?? 0 untuk menangani kondisi jika tabel masih kosong
            $latestId = static::max('id') ?? 0;
            $nextId = $latestId + 1;
            
            // Format: INV/202605/0001
            $model->invoice_number = 'INV/' . date('Ym') . '/' . str_pad($nextId, 4, '0', STR_PAD_LEFT);
            
            // 2. Otomatisasi Audit Trail
            if (auth()->check()) {
                $model->created_by = auth()->id();
                $model->updated_by = auth()->id();
            }
        });

        static::updating(function ($model) {
            // Update user yang mengubah data
            if (auth()->check()) {
                $model->updated_by = auth()->id();
            }
        });
    }

    protected function casts(): array
    {
        return [
            'total_cost' => 'decimal:2',
            'treatment_date' => 'date',
        ];
    }

    /**
     * Relasi ke detail item layanan
     */
    public function items(): HasMany
    {
        return $this->hasMany(MedicalRecordItem::class);
    }

    /**
     * Relasi ke Data Pasien
     */
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class)->withTrashed();
    }

    /**
     * Relasi ke Pegawai (Terapis)
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'employee_id');
    }

    /**
     * Accessor untuk mempermudah pemanggilan nama di Blade
     */
    public function getPatientDisplayNameAttribute(): string
    {
        return $this->patient?->name ?? '-';
    }

    public function getEmployeeDisplayNameAttribute(): string
    {
        return $this->employee?->name ?? '-';
    }
}