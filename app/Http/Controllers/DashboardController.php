<?php

namespace App\Http\Controllers;

use App\Models\ProdukKlien;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // Method untuk menampilkan semua data produk_klien
    public function index()
    {
        return view('admin.dashboard.index');
        
    }
}
