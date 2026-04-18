<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestimonialsTable extends Migration
{
    public function up()
    {
        Schema::create('testimonial', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100);
            $table->string('foto')->nullable();
            $table->tinyInteger('rating'); // 1-5
            $table->string('judul');
            $table->text('pesan');
            $table->unsignedBigInteger('cby')->nullable(); // Created by user ID
            $table->unsignedBigInteger('mby')->nullable(); // Modified by user ID
            $table->timestamps();
            $table->softDeletes();               // deleted_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('testimonial');
    }
}
