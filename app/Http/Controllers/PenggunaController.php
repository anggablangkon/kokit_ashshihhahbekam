<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PenggunaController extends Controller
{
    
    public function index()
    {
        return view('home.welcome');
        
    }

    public function profil(){
        return view('home.profil');
    }

    public function teknis(){
        return view('home.teknis');
    }

    
}
