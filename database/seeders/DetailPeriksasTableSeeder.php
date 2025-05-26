<?php

namespace Database\Seeders;

use App\Models\DetailPeriksa;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DetailPeriksasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data detail periksa (relasi periksa dengan obat)
        $detailPeriksas = [
            // Periksa ID 1 (Demam) - Paracetamol, Ibuprofen, Vitamin B
            ['id_periksa' => 1, 'id_obat' => 1], // Paracetamol
            ['id_periksa' => 1, 'id_obat' => 3], // Ibuprofen
            ['id_periksa' => 1, 'id_obat' => 11], // Vitamin B Complex

            // Periksa ID 2 (ISPA anak) - Paracetamol, OBH Combi, Vitamin B
            ['id_periksa' => 2, 'id_obat' => 1], // Paracetamol
            ['id_periksa' => 2, 'id_obat' => 12], // OBH Combi
            ['id_periksa' => 2, 'id_obat' => 11], // Vitamin B Complex

            // Periksa ID 3 (Gastritis) - Omeprazole, Paracetamol
            ['id_periksa' => 3, 'id_obat' => 5], // Omeprazole
            ['id_periksa' => 3, 'id_obat' => 1], // Paracetamol

            // Periksa ID 4 (Kehamilan) - Vitamin B Complex
            ['id_periksa' => 4, 'id_obat' => 11], // Vitamin B Complex

            // Tambahan data untuk testing
            // Periksa ID 1 - Amoxicillin (jika ada infeksi)
            ['id_periksa' => 1, 'id_obat' => 2], // Amoxicillin

            // Periksa ID 2 - Cetirizine (untuk alergi)
            ['id_periksa' => 2, 'id_obat' => 4], // Cetirizine

            // Periksa ID 3 - Dexamethasone (anti inflamasi)
            ['id_periksa' => 3, 'id_obat' => 10], // Dexamethasone
        ];

        foreach ($detailPeriksas as $detail) {
            DetailPeriksa::create($detail);
        }
    }
}
