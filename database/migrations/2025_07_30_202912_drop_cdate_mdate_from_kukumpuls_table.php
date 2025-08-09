<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('kukumpul', function (Blueprint $table) {
            $table->dropColumn(['cdate', 'mdate']);
        });
    }

    public function down()
    {
        Schema::table('kukumpul', function (Blueprint $table) {
            $table->timestamp('cdate')->nullable();
            $table->timestamp('mdate')->nullable();
        });
    }
};
