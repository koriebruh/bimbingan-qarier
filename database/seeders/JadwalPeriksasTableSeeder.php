<?php

namespace Database\Seeders;

use App\Models\JadwalPeriksa;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JadwalPeriksasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dokters = User::where('role', 'dokter')->get();

        $jadwals = [
            // Dr. Ahmad Santoso (Poli Umum)
            [
                'id_dokter' => $dokters[0]->id,
                'hari' => 'Senin',
                'jam_mulai' => '08:00:00',
                'jam_selesai' => '12:00:00'
            ],
            [
                'id_dokter' => $dokters[0]->id,
                'hari' => 'Rabu',
                'jam_mulai' => '14:00:00',
                'jam_selesai' => '18:00:00'
            ],
            [
                'id_dokter' => $dokters[0]->id,
                'hari' => 'Jumat',
                'jam_mulai' => '08:00:00',
                'jam_selesai' => '12:00:00'
            ],

            // Dr. Sarah Wijaya (Poli Anak)
            [
                'id_dokter' => $dokters[1]->id,
                'hari' => 'Selasa',
                'jam_mulai' => '09:00:00',
                'jam_selesai' => '13:00:00'
            ],
            [
                'id_dokter' => $dokters[1]->id,
                'hari' => 'Kamis',
                'jam_mulai' => '15:00:00',
                'jam_selesai' => '19:00:00'
            ],
            [
                'id_dokter' => $dokters[1]->id,
                'hari' => 'Sabtu',
                'jam_mulai' => '08:00:00',
                'jam_selesai' => '12:00:00'
            ],

            // Dr. Budi Hartono (Poli Kandungan)
            [
                'id_dokter' => $dokters[2]->id,
                'hari' => 'Senin',
                'jam_mulai' => '14:00:00',
                'jam_selesai' => '18:00:00'
            ],
            [
                'id_dokter' => $dokters[2]->id,
                'hari' => 'Rabu',
                'jam_mulai' => '08:00:00',
                'jam_selesai' => '12:00:00'
            ],
            [
                'id_dokter' => $dokters[2]->id,
                'hari' => 'Jumat',
                'jam_mulai' => '14:00:00',
                'jam_selesai' => '18:00:00'
            ],

            // Dr. Maya Sari (Poli Mata)
            [
                'id_dokter' => $dokters[3]->id,
                'hari' => 'Selasa',
                'jam_mulai' => '14:00:00',
                'jam_selesai' => '18:00:00'
            ],
            [
                'id_dokter' => $dokters[3]->id,
                'hari' => 'Kamis',
                'jam_mulai' => '08:00:00',
                'jam_selesai' => '12:00:00'
            ],
            [
                'id_dokter' => $dokters[3]->id,
                'hari' => 'Sabtu',
                'jam_mulai' => '14:00:00',
                'jam_selesai' => '18:00:00'
            ]
        ];

        foreach ($jadwals as $jadwal) {
            JadwalPeriksa::create($jadwal);
        }
    }
}
