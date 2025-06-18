<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\JadwalPeriksa;
use App\Models\Periksa;
use Illuminate\Http\Request;

class PasienController extends Controller
{
    public function dashboardPasien()
    {
        $jadwalPeriksa = JadwalPeriksa::where('status', 'open')->get();
        return view('pasien.dashboard', ['jadwalPeriksa' => $jadwalPeriksa]);
    }


    public function historyPeriksa()
    {
        $historyPeriksa = Periksa::with([
            'janjiPeriksa.jadwalPeriksa.dokter',
            'detailPeriksas.obat' => function ($query) {
                // Jika menggunakan soft delete, tambahkan withTrashed()
                $query->withTrashed();
            }
        ])->whereHas('janjiPeriksa', function ($query) {
                $query->where('id_pasien', auth()->id());
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pasien.HistoryPeriksa.index', compact('historyPeriksa'));
    }

}
