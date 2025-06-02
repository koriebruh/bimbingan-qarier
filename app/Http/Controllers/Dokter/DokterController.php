<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\JadwalPeriksa;
use App\Models\JanjiPeriksa;
use App\Models\Obat;
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

    public function historyPemeriksaan()
    {
        $id_dokter = auth()->user()->id;
        $periksas = JanjiPeriksa::with(['jadwalPeriksa', 'periksa'])
            ->whereHas('jadwalPeriksa', function ($query) use ($id_dokter) {
                $query->where('id_dokter', $id_dokter);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('dokter.historyPeriksa', compact('periksas'));
    }


}
