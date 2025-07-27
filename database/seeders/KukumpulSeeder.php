<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class KukumpulSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('kukumpul')->insert([
            [
                'provinsi_id'      => '1',
                'nama'      => 'Angga Blangkon',
                'nohp'      => '081234567890',
                'keterangan'=> 'Transfer iuran bulanan',
                'rupiah'    => 100000,
                'tanggal'   => '2025-07-27',
                'cby'       => 'admin',
                'mby'       => 'admin',
                'cdate'     => Carbon::now(),
                'mdate'     => Carbon::now(),
                'deleted_at'=> null,
            ],
            [
                'provinsi_id'      => '2',
                'nama'      => 'Dewi Lestari',
                'nohp'      => '089876543210',
                'keterangan'=> 'Donasi acara komunitas',
                'rupiah'    => 250000,
                'tanggal'   => '2025-07-26',
                'cby'       => 'admin',
                'mby'       => 'admin',
                'cdate'     => Carbon::now(),
                'mdate'     => Carbon::now(),
                'deleted_at'=> null,
            ],
        ]);
    }
}
