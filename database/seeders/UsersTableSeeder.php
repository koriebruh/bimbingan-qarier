<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data Dokter
        $dokters = [
            [
                'role' => 'dokter',
                'name' => 'Dr. Ahmad Santoso, Sp.PD',
                'email' => 'ahmad.santoso@klinik.com',
                'password' => Hash::make('password123'),
                'alamat' => 'Jl. Sudirman No. 123, Jakarta',
                'no_ktp' => '3171234567890001',
                'no_hp' => '081234567890',
                'poli' => 'Poli Umum'
            ],
            [
                'role' => 'dokter',
                'name' => 'Dr. Sarah Wijaya, Sp.A',
                'email' => 'sarah.wijaya@klinik.com',
                'password' => Hash::make('password123'),
                'alamat' => 'Jl. Thamrin No. 456, Jakarta',
                'no_ktp' => '3171234567890002',
                'no_hp' => '081234567891',
                'poli' => 'Poli Anak'
            ],
            [
                'role' => 'dokter',
                'name' => 'Dr. Budi Hartono, Sp.OG',
                'email' => 'budi.hartono@klinik.com',
                'password' => Hash::make('password123'),
                'alamat' => 'Jl. Gatot Subroto No. 789, Jakarta',
                'no_ktp' => '3171234567890003',
                'no_hp' => '081234567892',
                'poli' => 'Poli Kandungan'
            ],
            [
                'role' => 'dokter',
                'name' => 'Dr. Maya Sari, Sp.M',
                'email' => 'maya.sari@klinik.com',
                'password' => Hash::make('password123'),
                'alamat' => 'Jl. Kuningan No. 321, Jakarta',
                'no_ktp' => '3171234567890004',
                'no_hp' => '081234567893',
                'poli' => 'Poli Mata'
            ]
        ];

        foreach ($dokters as $dokter) {
            User::create($dokter);
        }

        // Data Pasien
        $pasiens = [
            [
                'role' => 'pasien',
                'name' => 'Andi Pratama',
                'email' => 'andi.pratama@email.com',
                'password' => Hash::make('password123'),
                'alamat' => 'Jl. Kebon Jeruk No. 12, Jakarta Barat',
                'no_ktp' => '3171234567890101',
                'no_hp' => '082345678901',
                'poli' => null
            ],
            [
                'role' => 'pasien',
                'name' => 'Siti Nurhaliza',
                'email' => 'siti.nurhaliza@email.com',
                'password' => Hash::make('password123'),
                'alamat' => 'Jl. Cempaka Putih No. 34, Jakarta Pusat',
                'no_ktp' => '3171234567890102',
                'no_hp' => '082345678902',
                'poli' => null
            ],
            [
                'role' => 'pasien',
                'name' => 'Bambang Susilo',
                'email' => 'bambang.susilo@email.com',
                'password' => Hash::make('password123'),
                'alamat' => 'Jl. Tanah Abang No. 56, Jakarta Pusat',
                'no_ktp' => '3171234567890103',
                'no_hp' => '082345678903',
                'poli' => null
            ],
            [
                'role' => 'pasien',
                'name' => 'Dewi Lestari',
                'email' => 'dewi.lestari@email.com',
                'password' => Hash::make('password123'),
                'alamat' => 'Jl. Menteng No. 78, Jakarta Pusat',
                'no_ktp' => '3171234567890104',
                'no_hp' => '082345678904',
                'poli' => null
            ],
            [
                'role' => 'pasien',
                'name' => 'Rudi Setiawan',
                'email' => 'rudi.setiawan@email.com',
                'password' => Hash::make('password123'),
                'alamat' => 'Jl. Kemang No. 90, Jakarta Selatan',
                'no_ktp' => '3171234567890105',
                'no_hp' => '082345678905',
                'poli' => null
            ]
        ];

        foreach ($pasiens as $pasien) {
            User::create($pasien);
        }
    }
}
