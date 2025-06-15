<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\JanjiPeriksa;
use Illuminate\Http\Request;

class ChatPasienController extends Controller
{


    public function index()
    {
        // MENAMPILKAN DATA YG BELUM DIPERIKSA
        $daftarChat = JanjiPeriksa::with(['jadwalPeriksa', 'pasien'])
            ->whereDoesntHave('periksa')
            ->where('id_pasien', auth()->id()) // ambil berdasarkan pasien yang login
            ->get();

        return view('pasien.Chat.index', compact('daftarChat'));
    }

    // MENAMPILKAN CHAT  PASIEN ke DOKTER KE
    public function chatDetail($id_dokter)
    {
        // Ambil chat yang terkait dengan dokter login dan pasien tertentu
        $chats = Chat::with(['pasien', 'dokter'])
            ->where('pasien_id', auth()->id())
            ->where('dokter_id', $id_dokter) // ambil berdasarkan parameter function
            ->orderBy('created_at', 'desc')
            ->get();

//        dd($chats);

        return view('pasien.Chat.detail', compact('chats', 'id_dokter'));
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
        return redirect()->route('pasien.Chat.detail', $validated['dokter_id'])
            ->with('success', 'Pesan berhasil dikirim.');
    }

    public function update(Request $request, $id)
    {
        $chat = Chat::findOrFail($id);

        if ($chat->pasien_id !== auth()->id()) {
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
        return redirect()->route('pasien.Chat.detail', $chat->dokter_id)
            ->with('success', 'Pesan berhasil diperbarui.');
    }


    public function destroy($id)
    {
        $chat = Chat::findOrFail($id);

        // Pastikan hanya dokter yang login yang bisa hapus pesannya sendiri
        if ($chat->pasien_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Anda tidak berhak menghapus pesan ini.');
        }

        $dokter_id = $chat->dokter_id; // simpan dulu sebelum dihapus
        $chat->delete();

        return redirect()->route('pasien.Chat.detail', $dokter_id)
            ->with('success', 'Pesan berhasil dihapus.');
    }
}
