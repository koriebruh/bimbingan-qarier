<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\JadwalPeriksa;
use App\Models\JanjiPeriksa;
use App\Models\Obat;
use App\Models\Periksa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MemeriksaController extends Controller
{
    function index()
    {
        $UnPeriksa = JanjiPeriksa::with([
            'jadwalPeriksa',
            'pasien',
        ])->whereDoesntHave('periksa')
//           UN HIDEN NANTI, INI SOALNYA MAELS ISI DATA WKWK
            ->whereHas('jadwalPeriksa', function ($query) {
                $query->where('id_dokter', auth()->user()->id);
            })
            ->get();

        return view('dokter.Memeriksa.index', compact('UnPeriksa'));
    }

    function destroy($id)
    {
        $janjiPeriksa = JanjiPeriksa::findOrFail($id);

        $janjiPeriksa->delete();

        return redirect()->route('dokter.Memeriksa.index')->with('success', 'Janji Periksa berhasil dihapus.');
    }

    /*CREATE Aka Memeriksa Pasien
     * */

    function create($id)
    {
        // Ambil data janji periksa berdasarkan ID
        $janjiPeriksa = JanjiPeriksa::with(['jadwalPeriksa.dokter', 'pasien'])->findOrFail($id);

        // Ambil daftar obat untuk dropdown
        $obatList = Obat::all();

//        dd($janjiPeriksa, $obatList);
        // Tampilkan halaman edit dengan data janji periksa dan daftar obat
        return view('dokter.Memeriksa.create', compact('janjiPeriksa', 'obatList'));
    }


    public function store(Request $request,  $janjiPeriksaId)
    {
        $request->validate([
            'tgl_periksa' => 'required|date',
            'catatan' => 'nullable|string',
            'obat' => 'required|array',
            'obat.*' => 'exists:obats,id',
        ]);

        // Tidak perlu findOrFail lagi karena sudah di-inject via model binding
        $janjiPeriksa = JanjiPeriksa::findOrFail($janjiPeriksaId);
        $janjiPeriksa->load(['jadwalPeriksa.dokter', 'pasien']);

        // Menghitung total harga obat yang dipilih
        $totalHargaObat = Obat::whereIn('id', $request->obat)->sum('harga');
        $biayaPeriksa = $totalHargaObat + 150000;

        try {
            DB::beginTransaction();

            $periksa = Periksa::create([
                'id_pasien' => $janjiPeriksa->id_pasien,
                'id_janji_periksa' => $janjiPeriksa->id,
                'tgl_periksa' => $request->tgl_periksa,
                'catatan' => $request->catatan,
                'biaya_periksa' => $biayaPeriksa,
            ]);

            $periksa->obats()->sync($request->obat);

            DB::commit();

            return redirect()->route('dokter.Memeriksa.index')->with('success', 'Pemeriksaan berhasil disimpan.');

        } catch (\Exception $e) {
            DB::rollback();
            Log::error("Error creating periksa: " . $e->getMessage());
            return redirect()->route('dokter.Memeriksa.index')->with('error', 'Terjadi kesalahan saat menyimpan pemeriksaan.');
        }
    }

}
