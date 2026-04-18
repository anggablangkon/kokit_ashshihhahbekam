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


    public function grafikdashboard(){

        $year = now()->year;

        $data = Kukumpul::select(
            DB::raw('MONTH(created_at) as bulan'),
            DB::raw('SUM(rupiah) as total')
        )
        ->whereYear('created_at', $year)
        ->where('status', 'sukses')
        ->groupBy(DB::raw('MONTH(created_at)'))
        ->pluck('total', 'bulan')
        ->toArray();

        $labels = [];
        $grafik = [];
        for ($i = 0; $i <= 12; $i++) {
            $labels[] = Carbon::create(null, $i)->locale('id')->translatedFormat('F');
            $grafik[] = $data[$i] ?? 0;
        }

        return response()->json([
            'labels' => $labels,
            'data'   => $grafik,
        ]);
    }


}
