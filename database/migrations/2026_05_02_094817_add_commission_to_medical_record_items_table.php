<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::table('medical_record_items', function (Blueprint $table) {
        // Menambahkan kolom komisi setelah kolom price
        $table->decimal('commission', 15, 2)->default(0)->after('price');
    });
}

public function down(): void
{
    Schema::table('medical_record_items', function (Blueprint $table) {
        $table->dropColumn('commission');
    });
}
};
