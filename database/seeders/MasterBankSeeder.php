<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MasterBankSeeder extends Seeder
{
    public function run()
    {
        DB::table('master_banks')->insert([
            [
                'bank_name' => 'BCA',
                'account_number' => '1234567890',
                'account_holder' => 'Andi Setiawan',
                'cby' => 1,
                'mby' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'bank_name' => 'Mandiri',
                'account_number' => '9876543210',
                'account_holder' => 'Rina Putri',
                'cby' => 2,
                'mby' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
