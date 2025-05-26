<?php

namespace Database\Seeders;

use App\Models\JadwalPeriksa;
use App\Models\JanjiPeriksa;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JanjiPeriksasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pasiens = User::where('role', 'pasien')->get();
        $jadwals = JadwalPeriksa::all();

        $janjiPeriksas = [
            [
                'id_pasien' => $pasiens[0]->id, // Andi Pratama
                'id_jadwal' => $jadwals[0]->id, // Dr. Ahmad - Senin
                'keluhan' => 'Demam dan sakit kepala sejak 2 hari',
                'no_antrian' => 1
            ],
            [
                'id_pasien' => $pasiens[1]->id, // Siti Nurhaliza
                'id_jadwal' => $jadwals[3]->id, // Dr. Sarah - Selasa
                'keluhan' => 'Anak batuk pilek tidak sembuh-sembuh',
                'no_antrian' => 1
            ],
            [
                'id_pasien' => $pasiens[2]->id, // Bambang Susilo
                'id_jadwal' => $jadwals[0]->id, // Dr. Ahmad - Senin
                'keluhan' => 'Nyeri perut dan mual',
                'no_antrian' => 2
            ],
            [
                'id_pasien' => $pasiens[3]->id, // Dewi Lestari
                'id_jadwal' => $jadwals[6]->id, // Dr. Budi - Senin
                'keluhan' => 'Kontrol kehamilan rutin',
                'no_antrian' => 1
            ],
            [
                'id_pasien' => $pasiens[4]->id, // Rudi Setiawan
                'id_jadwal' => $jadwals[9]->id, // Dr. Maya - Selasa
                'keluhan' => 'Mata merah dan berair',
                'no_antrian' => 1
            ],
            [
                'id_pasien' => $pasiens[0]->id, // Andi Pratama
                'id_jadwal' => $jadwals[1]->id, // Dr. Ahmad - Rabu
                'keluhan' => 'Kontrol tekanan darah',
                'no_antrian' => 1
            ],
            [
                'id_pasien' => $pasiens[2]->id, // Bambang Susilo
                'id_jadwal' => $jadwals[4]->id, // Dr. Sarah - Kamis
                'keluhan' => 'Konsultasi vaksin untuk anak',
                'no_antrian' => 1
            ]
        ];

        foreach ($janjiPeriksas as $janji) {
            JanjiPeriksa::create($janji);
        }
    }
}
