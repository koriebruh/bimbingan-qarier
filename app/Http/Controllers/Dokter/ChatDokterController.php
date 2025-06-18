<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\JanjiPeriksa;
use Illuminate\Http\Request;

class ChatDokterController extends Controller
{
    /* MENAMPILKAN CHAT DOKTER KE PASIEN BUT dengan syarta sudah membnuat Janji dengan dokter
     * */


    // KAYA BERANDA YG MENAMPILKAN NAMA ORAGAN YANG BELUM DIPERIKSA TAPI ADA NGECHAT
    public function index()
    {
        // MENAMPILKAN DATA YG BELUM DIPERIKSA
        $daftarChat = JanjiPeriksa::with(['jadwalPeriksa', 'pasien'])
            ->whereDoesntHave('periksa')
            ->whereHas('jadwalPeriksa', function ($query) {
                $query->where('id_dokter', auth()->user()->id);
            })
            ->get();

        return view('dokter.Chat.index', compact('daftarChat'));
    }
    

    // MENAMPILKAN CHAT DOKTER KE PASIEN or sebalik nya
    public function chatDetail($id_pasien)
    {
        // Ambil chat yang terkait dengan dokter login dan pasien tertentu
        $chats = Chat::with(['pasien', 'dokter'])
            ->where('dokter_id', auth()->id())
            ->where('pasien_id', $id_pasien) // ambil berdasarkan parameter function
            ->orderBy('created_at', 'desc')
            ->get();

        return view('dokter.Chat.detail', compact('chats', 'id_pasien'));
    }



    public function store(Request $request)
    {
        $validated = $request->validate([
            'pasien_id' => 'required|exists:users,id',
            'dokter_id' => 'required|exists:users,id',
            'message' => 'required|string',
            'sender_role' => 'required|in:dokter,pasien',
        ]);

        $chat = Chat::create($validated);

        // Redirect kembali ke detail chat dengan parameter pasien_id
        return redirect()->route('dokter.Chat.detail', $validated['pasien_id'])
            ->with('success', 'Pesan berhasil dikirim.');
    }

    public function update(Request $request, $id)
    {
        $chat = Chat::findOrFail($id);

        // Pastikan hanya dokter yang login yang bisa edit pesannya sendiri
        if ($chat->dokter_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Anda tidak berhak mengedit pesan ini.');
        }

        $validated = $request->validate([
            'message' => 'required|string',
        ]);

        $chat->update([
            'message' => $validated['message'],
            'is_edited' => true,
        ]);

        // Redirect kembali ke detail chat
        return redirect()->route('dokter.Chat.detail', $chat->pasien_id)
            ->with('success', 'Pesan berhasil diperbarui.');
    }


    public function destroy($id)
    {
        $chat = Chat::findOrFail($id);

        // Pastikan hanya dokter yang login yang bisa hapus pesannya sendiri
        if ($chat->dokter_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Anda tidak berhak menghapus pesan ini.');
        }

        $pasien_id = $chat->pasien_id; // simpan dulu sebelum dihapus
        $chat->delete();

        // Redirect kembali ke detail chat
        return redirect()->route('dokter.Chat.detail', $pasien_id)
            ->with('success', 'Pesan berhasil dihapus.');
    }

}
