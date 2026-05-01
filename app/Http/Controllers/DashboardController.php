<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kukumpul;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    // Method untuk menampilkan semua data produk_klien
    public function index()
    {
        return view('admin.dashboard.index');
        
    }


    public function grafikdashboard()
    {
        return response()->json([
            "labels" => ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
            "data" => [1200000, 2100000, 1500000, 3000000, 2400000, 4000000, 3500000, 4200000, 4800000, 4500000, 5500000, 6800000],

            "pie_data" => [
                ["value" => 40, "name" => "Bekam"],
                ["value" => 30, "name" => "Pijat"],
                ["value" => 30, "name" => "Lainnya"]
            ],

            "pasien_data" => [
                ["value" => 100, "name" => "Aktif"],
                ["value" => 20, "name" => "Baru"]
            ],

            "pegawai_data" => [
                ["value" => 10, "name" => "Terapis"],
                ["value" => 3, "name" => "Admin"]
            ],

            "stats" => [
                "total_omzet" => "Rp 6.800.000",
                "pasien_baru" => "20",
                "total_kunjungan" => "120",
                "estimasi_gaji" => "Rp 1.500.000"
            ]
        ]);
    }


}
