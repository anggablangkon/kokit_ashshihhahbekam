<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('kukumpul', function (Blueprint $table) {
            $table->id();
            $table->integer('provinsi_id');
            $table->string('nama');
            $table->string('nohp');
            $table->text('keterangan')->nullable();
            $table->decimal('rupiah', 15, 2)->default(0);
            $table->string('tanggal')->nullable(); // tangal transfer
            $table->string('cby')->nullable(); // created by
            $table->string('mby')->nullable(); // modified by
            $table->timestamp('cdate')->nullable(); // created date
            $table->timestamp('mdate')->nullable(); // modified date
            $table->softDeletes(); // for isdelete / deleted_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kukumpul');
    }
};
