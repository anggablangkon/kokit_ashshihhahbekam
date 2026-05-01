<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            // Hubungan ke tabel users (opsional, jika karyawan bisa login)
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            
            $table->string('employee_code')->unique(); // ID Karyawan
            $table->string('name');
            $table->string('phone');
            $table->string('specialization')->nullable(); // Contoh: Bekam, Pijat, atau Admin
            $table->decimal('base_salary', 15, 2)->default(0); 
            $table->string('bank_name')->nullable();
            $table->string('bank_account_number')->nullable();
            $table->date('join_date');
            $table->boolean('is_active')->default(true);

            // Audit & SoftDeletes
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps(); // cdate & mdate
            $table->softDeletes(); // softdelete
        });
    }

    public function down(): void {
        Schema::dropIfExists('employees');
    }
};