<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medical_record_items', function (Blueprint $table) {
            $table->id();
            // Relasi ke header
            $table->foreignId('medical_record_id')
                  ->constrained('medical_records')
                  ->onDelete('cascade');
            
            // Relasi ke master treatment (nullable untuk input bebas)
            $table->foreignId('treatment_id')->nullable()->constrained('treatments');
            $table->string('treatment_name'); // Nama layanan saat transaksi
            
            $table->integer('qty')->default(1);
            $table->decimal('price', 15, 2);
            $table->decimal('discount', 15, 2)->default(0);
            $table->decimal('subtotal', 15, 2);
            
            // Audit & SoftDeletes
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medical_record_items');
    }
};