<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\JadwalPeriksa;
use App\Models\JanjiPeriksa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class JanjiPeriksaController extends Controller
{
    /* GET DATA JAANJI PERIKSA YG DI LAKUKAN PASIEN
     * */
    public function index()
    {
        $janjiPeriksa = JanjiPeriksa::with(['jadwalPeriksa.dokter', 'pasien'])
            ->where('id_pasien', Auth::id())
            ->whereDoesntHave('periksa') // Hanya ambil janji yang belum diperiksa
            ->orderBy('created_at', 'desc')
            ->get();

//        dd($janjiPeriksa);

        return view('pasien.JanjiPeriksa.index', compact('janjiPeriksa'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Hanya pasien yang bisa membuat janji periksa
        if (Auth::user()->role !== 'pasien') {
            abort(403, 'Unauthorized action.');
        }

        /* SHOW JADWAL YG DI OPEN DOKTER
         * */
        $jadwalPeriksa = JadwalPeriksa::with('dokter')
            ->where('status', true)
            ->get();

//        dd($jadwalPeriksa);

        return view('pasien.JanjiPeriksa.create', compact('jadwalPeriksa'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Hanya pasien yang bisa membuat janji periksa
        if (Auth::user()->role !== 'pasien') {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'id_jadwal' => 'required|exists:jadwal_periksas,id',
            'keluhan' => 'required|string|max:500',
        ]);

        DB::beginTransaction();

        try {
            // Generate nomor antrian
            $lastAntrian = JanjiPeriksa::whereHas('jadwalPeriksa', function ($query) use ($request) {
                $query->where('id', $request->id_jadwal);
            })->whereDate('created_at', today())->max('no_antrian');

            $noAntrian = $lastAntrian ? $lastAntrian + 1 : 1;

            // Buat janji periksa baru
            $janjiPeriksa = JanjiPeriksa::create([
                'id_pasien' => Auth::id(),
                'id_jadwal' => $request->id_jadwal,
                'keluhan' => $request->keluhan,
                'no_antrian' => $noAntrian,
            ]);

            DB::commit();

            return redirect()->route('pasien.JanjiPeriksa.index')
                ->with('success', 'Janji periksa berhasil dibuat dengan nomor antrian: ' . $noAntrian);

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Gagal membuat janji periksa: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JanjiPeriksa $janjiPeriksa)
    {
        // Hanya pasien pemilik janji yang bisa mengedit dan hanya jika belum diperiksa
        if (Auth::user()->role !== 'pasien' ||
            $janjiPeriksa->id_pasien != Auth::id() ||
            $janjiPeriksa->periksa) {
            abort(403, 'Unauthorized action.');
        }

        $jadwalPeriksa = JadwalPeriksa::with('dokter')
            ->where('status', true)
            ->get();

        return view('pasien.JanjiPeriksa.edit', compact('janjiPeriksa', 'jadwalPeriksa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JanjiPeriksa $janjiPeriksa)
    {
        // Hanya pasien pemilik janji yang bisa mengedit dan hanya jika belum diperiksa
        if (Auth::user()->role !== 'pasien' ||
            $janjiPeriksa->id_pasien != Auth::id() ||
            $janjiPeriksa->periksa) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'id_jadwal' => 'required|exists:jadwal_periksas,id',
            'keluhan' => 'required|string|max:500',
        ]);

        DB::beginTransaction();

        try {
            // Jika jadwal berubah, generate ulang nomor antrian
            if ($janjiPeriksa->id_jadwal != $request->id_jadwal) {
                $lastAntrian = JanjiPeriksa::whereHas('jadwalPeriksa', function ($query) use ($request) {
                    $query->where('id', $request->id_jadwal);
                })->whereDate('created_at', today())->max('no_antrian');

                $noAntrian = $lastAntrian ? $lastAntrian + 1 : 1;
            } else {
                $noAntrian = $janjiPeriksa->no_antrian;
            }

            $janjiPeriksa->update([
                'id_jadwal' => $request->id_jadwal,
                'keluhan' => $request->keluhan,
                'no_antrian' => $noAntrian,
            ]);

            DB::commit();

            return redirect()->route('pasien.JanjiPeriksa.index')
                ->with('success', 'Janji periksa berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Gagal memperbarui janji periksa: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JanjiPeriksa $janjiPeriksa)
    {
        // Hanya admin atau pasien pemilik janji yang bisa menghapus
        if (Auth::user()->role == 'pasien' && $janjiPeriksa->id_pasien != Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Tidak bisa dihapus jika sudah diperiksa
        if ($janjiPeriksa->periksa) {
            return redirect()->back()
                ->with('error', 'Janji periksa yang sudah diperiksa tidak dapat dihapus.');
        }

        try {
            $janjiPeriksa->delete();
            return redirect()->route('pasien.JanjiPeriksa.index')
                ->with('success', 'Janji periksa berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus janji periksa: ' . $e->getMessage());
        }
    }
}
