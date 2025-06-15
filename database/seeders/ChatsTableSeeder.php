<?php

namespace Database\Seeders;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ChatsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil semua pasien dan dokter
        $pasiens = User::where('role', 'pasien')->get();
        $dokters = User::where('role', 'dokter')->get();

        // Cek jika datanya cukup
        if ($pasiens->count() > 0 && $dokters->count() > 0) {

            foreach ($pasiens as $pasien) {
                // Pasien ini akan chat dengan random 2 dokter
                $randomDokters = $dokters->random(min(2, $dokters->count()));

                foreach ($randomDokters as $dokter) {
                    // Insert 3-5 chat random antara pasien dan dokter
                    $totalChat = rand(3, 5);
                    $sender = 'pasien'; // mulai dari pasien

                    for ($i = 0; $i < $totalChat; $i++) {
                        Chat::create([
                            'pasien_id'   => $pasien->id,
                            'dokter_id'   => $dokter->id,
                            'message'     => $this->generateRandomMessage($sender),
                            'sender_role' => $sender,
                            'is_edited'   => (bool)rand(0, 1), // random edited atau tidak
                        ]);

                        // Tukar pengirim
                        $sender = $sender === 'pasien' ? 'dokter' : 'pasien';
                    }
                }
            }
        }
    }

    /**
     * Generate random message sesuai sender.
     */
    private function generateRandomMessage($sender)
    {
        $pasienMessages = [
            'Halo dok, saya mau tanya.',
            'Perut saya sakit sejak kemarin.',
            'Obat apa ya yang cocok dok?',
            'Saya sudah minum obat tapi belum sembuh.',
            'Terima kasih dok!'
        ];

        $dokterMessages = [
            'Halo, keluhannya apa?',
            'Sejak kapan dirasakan?',
            'Coba istirahat dulu ya.',
            'Kalau makin parah segera datang ke klinik.',
            'Jangan lupa minum obat sesuai aturan.'
        ];

        return $sender === 'pasien'
            ? $pasienMessages[array_rand($pasienMessages)]
            : $dokterMessages[array_rand($dokterMessages)];
    }
}
