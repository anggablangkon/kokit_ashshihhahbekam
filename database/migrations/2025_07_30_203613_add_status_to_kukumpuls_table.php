<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToKukumpulsTable extends Migration
{
    public function up()
    {
        Schema::table('kukumpul', function (Blueprint $table) {
            $table->enum('status', ['proses', 'tolak', 'sukses'])
                  ->default('proses')
                  ->after('tanggal'); // ganti 'tanggal' kalau nama kolom aslinya berbeda
        });
    }

    public function down()
    {
        Schema::table('kukumpul', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
