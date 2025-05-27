<?php

namespace App\Http\Controllers;

use App\Models\JadwalPeriksa;
use App\Models\JanjiPeriksa;
use App\Models\Obat;
use App\Models\Periksa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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


    /*CRUD FOR JADWAL PERIKSA
     * */
    public function showJadwalDokter()
    {
        if (Auth::user()->role !== 'dokter') {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        $jadwalPeriksa = JadwalPeriksa::where('id_dokter', Auth::id())
            ->orderBy('jam_mulai', 'asc')
            ->get();

        $hariOptions = [
            'Senin' => 'Senin',
            'Selasa' => 'Selasa',
            'Rabu' => 'Rabu',
            'Kamis' => 'Kamis',
            'Jumat' => 'Jumat',
            'Sabtu' => 'Sabtu',
            'Minggu' => 'Minggu',
        ];

        // Mendapatkan jadwal yang sedang aktif
        $activeSchedule = JadwalPeriksa::where('id_dokter', Auth::id())
            ->where('status', 1)
            ->first();

        return view('dokter.jadwalPeriksa', compact('jadwalPeriksa', 'hariOptions', 'activeSchedule'));
    }

    public function storeJadwal(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'hari' => ['required', Rule::in(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'])],
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
            'status' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Cek bentrok jadwal pada hari yang sama
        $bentrok = JadwalPeriksa::where('id_dokter', Auth::id())
            ->where('hari', $request->hari)
            ->where(function ($query) use ($request) {
                $query->whereBetween('jam_mulai', [$request->jam_mulai, $request->jam_selesai])
                    ->orWhereBetween('jam_selesai', [$request->jam_mulai, $request->jam_selesai])
                    ->orWhere(function ($q) use ($request) {
                        $q->where('jam_mulai', '<=', $request->jam_mulai)
                            ->where('jam_selesai', '>=', $request->jam_selesai);
                    });
            })
            ->exists();

        if ($bentrok) {
            return redirect()->back()->withErrors(['jadwal' => 'Jadwal bentrok dengan jadwal yang sudah ada pada hari yang sama.'])->withInput();
        }

        // Jika status aktif, nonaktifkan semua jadwal lain
        if ($request->status == 1) {
            JadwalPeriksa::where('id_dokter', Auth::id())
                ->where('status', 1)
                ->update(['status' => 0]);
        }

        // Simpan jadwal
        JadwalPeriksa::create([
            'id_dokter' => Auth::id(),
            'hari' => $request->hari,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'status' => $request->status,
        ]);

        $message = 'Jadwal periksa berhasil ditambahkan.';
        if ($request->status == 1) {
            $message .= ' Jadwal lain yang sebelumnya aktif telah dinonaktifkan.';
        }

        return redirect()->route('dokter.jadwalPeriksa')->with('success', $message);
    }

    //GET DATA JADWAL UNTUK FORM EDIT
    public function editJadwal($id)
    {
        $jadwal = JadwalPeriksa::findOrFail($id);

        if ($jadwal->id_dokter !== auth()->id()) {
            return redirect()->route('dokter.jadwalPeriksa')->with('error', 'Akses tidak diizinkan.');
        }

        // Mendapatkan jadwal yang sedang aktif (selain jadwal yang sedang diedit)
        $activeSchedule = JadwalPeriksa::where('id_dokter', Auth::id())
            ->where('status', 1)
            ->where('id', '!=', $id)
            ->first();

        return view('dokter.jadwalPeriksaEdit', compact('jadwal', 'activeSchedule'));
    }

    //UPDATE JADWAL
    public function updateJadwal(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'hari' => ['required', Rule::in(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'])],
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
            'status' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $jadwal = JadwalPeriksa::findOrFail($id);

            // Check authorization
            if ($jadwal->id_dokter !== auth()->id()) {
                return redirect()->route('dokter.jadwalPeriksa')->with('error', 'Akses tidak diizinkan.');
            }

            // Check for schedule conflicts (exclude current schedule) pada hari yang sama
            $bentrok = JadwalPeriksa::where('id_dokter', Auth::id())
                ->where('hari', $request->hari)
                ->where('id', '!=', $id) // Exclude current schedule
                ->where(function ($query) use ($request) {
                    $query->whereBetween('jam_mulai', [$request->jam_mulai, $request->jam_selesai])
                        ->orWhereBetween('jam_selesai', [$request->jam_mulai, $request->jam_selesai])
                        ->orWhere(function ($q) use ($request) {
                            $q->where('jam_mulai', '<=', $request->jam_mulai)
                                ->where('jam_selesai', '>=', $request->jam_selesai);
                        });
                })
                ->exists();

            if ($bentrok) {
                return redirect()->back()->withErrors(['jadwal' => 'Jadwal bentrok dengan jadwal yang sudah ada pada hari yang sama.'])->withInput();
            }

            // Jika status diubah menjadi aktif, nonaktifkan semua jadwal lain
            $wasActive = $jadwal->status == 1;
            $willBeActive = $request->status == 1;

            if ($willBeActive && !$wasActive) {
                // Jadwal ini akan diaktifkan, nonaktifkan yang lain
                JadwalPeriksa::where('id_dokter', Auth::id())
                    ->where('id', '!=', $id)
                    ->where('status', 1)
                    ->update(['status' => 0]);
            }

            // Update the schedule
            $jadwal->update([
                'hari' => $request->hari,
                'jam_mulai' => $request->jam_mulai,
                'jam_selesai' => $request->jam_selesai,
                'status' => $request->status,
            ]);

            $message = 'Jadwal berhasil diperbarui.';
            if ($willBeActive && !$wasActive) {
                $message .= ' Jadwal lain yang sebelumnya aktif telah dinonaktifkan.';
            }

            return redirect()->route('dokter.jadwalPeriksa')->with('success', $message);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui jadwal.')->withInput();
        }
    }

    //HAPUS JADWAL
    public function deleteJadwal($id)
    {
        try {
            // Get the jadwal to delete
            $jadwal = JadwalPeriksa::findOrFail($id);

            // Ensure the doctor is authorized to delete the jadwal
            if ($jadwal->id_dokter !== auth()->user()->id) {
                return redirect()->route('dokter.jadwalPeriksa')->with('error', 'Akses tidak diizinkan.');
            }

            // Cek apakah jadwal yang akan dihapus sedang aktif
            $isActiveSchedule = $jadwal->status == 1;

            // Delete the jadwal
            $jadwal->delete();

            $message = 'Jadwal berhasil dihapus.';
            if ($isActiveSchedule) {
                $message .= ' Tidak ada jadwal aktif saat ini, silakan aktifkan jadwal lain jika diperlukan.';
            }

            return redirect()->route('dokter.jadwalPeriksa')->with('success', $message);

        } catch (\Exception $e) {
            return redirect()->route('dokter.jadwalPeriksa')->with('error', 'Terjadi kesalahan saat menghapus jadwal.');
        }
    }

    //FUNGSI UNTUK TOGGLE STATUS JADWAL (OPSIONAL - untuk kemudahan penggunaan)
    public function toggleStatusJadwal($id)
    {
        try {
            $jadwal = JadwalPeriksa::findOrFail($id);

            // Check authorization
            if ($jadwal->id_dokter !== auth()->id()) {
                return redirect()->route('dokter.jadwalPeriksa')->with('error', 'Akses tidak diizinkan.');
            }

            if ($jadwal->status == 0) {
                // Jika akan diaktifkan, nonaktifkan jadwal lain terlebih dahulu
                JadwalPeriksa::where('id_dokter', Auth::id())
                    ->where('id', '!=', $id)
                    ->where('status', 1)
                    ->update(['status' => 0]);

                // Aktifkan jadwal ini
                $jadwal->update(['status' => 1]);
                $message = 'Jadwal berhasil diaktifkan. Jadwal lain yang sebelumnya aktif telah dinonaktifkan.';
            } else {
                // Nonaktifkan jadwal ini
                $jadwal->update(['status' => 0]);
                $message = 'Jadwal berhasil dinonaktifkan.';
            }

            return redirect()->route('dokter.jadwalPeriksa')->with('success', $message);

        } catch (\Exception $e) {
            return redirect()->route('dokter.jadwalPeriksa')->with('error', 'Terjadi kesalahan saat mengubah status jadwal.');
        }
    }


    /*
     * */


}
