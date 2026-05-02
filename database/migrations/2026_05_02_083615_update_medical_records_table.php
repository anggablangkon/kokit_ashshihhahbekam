<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('medical_records', function (Blueprint $table) {
            // 1. Menghapus kolom nama yang redundan
            $columnsToDrop = array_filter(['patient_name', 'employee_name'], function (string $column) {
                return Schema::hasColumn('medical_records', $column);
            });

            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }

            // 2. Memastikan total_cost menggunakan tipe data yang tepat
            $table->decimal('total_cost', 15, 2)->change();

            // 3. Menambahkan SoftDeletes & Audit Columns
            if (!Schema::hasColumn('medical_records', 'deleted_at')) {
                $table->softDeletes(); 
            }
            
            // Kolom pelacakan user (Foreign Key ke tabel users)
            if (!Schema::hasColumn('medical_records', 'created_by')) {
                $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            }

            if (!Schema::hasColumn('medical_records', 'updated_by')) {
                $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            }
            
            // Memastikan treatment_date ada dan bertipe date
            $table->date('treatment_date')->change();
        });
    }

    public function down(): void
    {
        Schema::table('medical_records', function (Blueprint $table) {
            $table->string('patient_name')->nullable();
            $table->string('employee_name')->nullable();

            if (Schema::hasColumn('medical_records', 'deleted_at')) {
                $table->dropSoftDeletes();
            }

            $columnsToDrop = array_filter(['created_by', 'updated_by'], function (string $column) {
                return Schema::hasColumn('medical_records', $column);
            });

            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }
        });
    }
};
