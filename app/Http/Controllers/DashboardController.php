<?php

namespace App\Http\Controllers;

use App\Models\MedicalRecord;
use App\Models\MedicalRecordItem;
use App\Models\Patient;
use App\Models\User;
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
    $currentYear = date('Y');
    $currentMonth = date('m'); // Tambahkan baris ini agar variabel tersedia

    // 1. DATA GRAFIK OMZET PER BULAN (Line Chart)
    $monthlyRevenue = MedicalRecord::select(
            DB::raw('MONTH(treatment_date) as month'),
            DB::raw('SUM(total_cost) as total')
        )
        ->whereYear('treatment_date', $currentYear)
        ->groupBy('month')
        ->orderBy('month')
        ->get()
        ->pluck('total', 'month')
        ->toArray();

    $dataOmzet = [];
    for ($i = 1; $i <= 12; $i++) {
        $dataOmzet[] = $monthlyRevenue[$i] ?? 0;
    }

    // 2. DATA PIE CHART (Populer Layanan)
    $popularTreatments = MedicalRecordItem::select('treatment_name as name', DB::raw('count(*) as value'))
        ->groupBy('treatment_name')
        ->orderBy('value', 'desc')
        ->take(5)
        ->get();

    // 3. DATA PASIEN (Status)
    $pasienBaru = Patient::whereMonth('created_at', $currentMonth)
        ->whereYear('created_at', $currentYear)
        ->count();
    $totalPasien = Patient::count();

    // 4. STATS (Kartu Informasi)
    $totalOmzet = MedicalRecord::whereYear('treatment_date', $currentYear)->sum('total_cost');
    $totalKunjungan = MedicalRecord::whereYear('treatment_date', $currentYear)->count();
    
    // Estimasi Gaji berdasarkan kolom komisi yang baru dibuat
    $estimasiGaji = MedicalRecordItem::whereHas('medicalRecord', function($q) use ($currentMonth, $currentYear) {
            $q->whereMonth('treatment_date', $currentMonth)
              ->whereYear('treatment_date', $currentYear);
        })
        ->sum(DB::raw('qty * commission'));

    return response()->json([
        "labels" => ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
        "data"   => $dataOmzet,

        "pie_data" => $popularTreatments,

        "pasien_data" => [
            ["value" => $totalPasien - $pasienBaru, "name" => "Lama"],
            ["value" => $pasienBaru, "name" => "Baru"]
        ],

        "pegawai_data" => [
            ["value" => User::count(), "name" => "Total Pegawai"],
        ],

        "stats" => [
            "total_omzet"     => "Rp " . number_format($totalOmzet, 0, ',', '.'),
            "pasien_baru"     => (string)$pasienBaru,
            "total_kunjungan" => (string)$totalKunjungan,
            "estimasi_gaji"   => "Rp " . number_format($estimasiGaji, 0, ',', '.')
        ]
    ]);
}


}
