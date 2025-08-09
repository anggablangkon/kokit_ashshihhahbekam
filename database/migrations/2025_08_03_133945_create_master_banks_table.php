<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterBanksTable extends Migration
{
    public function up()
    {
        Schema::create('master_banks', function (Blueprint $table) {
            $table->id();
            $table->string('bank_name');         // Nama bank, contoh: BCA
            $table->string('account_number');    // Nomor rekening
            $table->string('account_holder');    // Atas nama
            $table->unsignedBigInteger('cby')->nullable(); // Created by user ID
            $table->unsignedBigInteger('mby')->nullable(); // Modified by user ID
            $table->timestamps();                // created_at dan updated_at
            $table->softDeletes();               // deleted_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('master_banks');
    }
}
