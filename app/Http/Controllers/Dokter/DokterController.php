<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\JadwalPeriksa;
use App\Models\JanjiPeriksa;
use App\Models\Obat;
use App\Models\Periksa;
use Illuminate\Http\Request;

class DokterController extends Controller
{
    public function dashboardDokter()
    {
        $totalJadwal = JadwalPeriksa::with(['dokter'])->where('id_dokter', auth()->user()->id)
            ->orderBy('hari', 'asc')
            ->orderBy('jam_mulai', 'asc')
            ->get()->count();

        $totalPeriksa = JanjiPeriksa::with(['jadwalPeriksa'])
            ->whereHas('jadwalPeriksa', function ($query) {
                $query->where('id_dokter', auth()->user()->id);
            })
            ->count();

        $totalBelumDiperiksa = JanjiPeriksa::with(['jadwalPeriksa'])
            ->whereHas('jadwalPeriksa', function ($query) {
                $query->where('id_dokter', auth()->user()->id);
            })
            ->whereDoesntHave('periksa')
            ->count();

        $totalObats = Obat::all()->count();

        return view('dokter.dashboard', compact('totalJadwal', 'totalPeriksa'
            , 'totalBelumDiperiksa', 'totalObats'));
    }

    public function historyPeriksa()
    {
        $historyPeriksa = Periksa::with([
            'janjiPeriksa.jadwalPeriksa.dokter',
            'janjiPeriksa.pasien',
            'detailPeriksas.obat' => function ($query) {
                // Jika menggunakan soft delete, tambahkan withTrashed()
                $query->withTrashed();
            }
        ])->whereHas('janjiPeriksa.jadwalPeriksa', function ($query) {
            $query->where('id_dokter', auth()->id());
        })
            ->orderBy('created_at', 'desc')
            ->get();

//        dd($historyPeriksa);

        return view('dokter.HistoryPeriksa.index', compact('historyPeriksa'));
    }
}
