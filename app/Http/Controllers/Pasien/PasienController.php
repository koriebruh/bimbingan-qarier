<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\JadwalPeriksa;
use Illuminate\Http\Request;

class PasienController extends Controller
{
    public function dashboardPasien()
    {
        $jadwalPeriksa = JadwalPeriksa::where('status', 'open')->get();
        return view('pasien.dashboard', ['jadwalPeriksa' => $jadwalPeriksa]);
    }
}
