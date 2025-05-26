<?php

namespace Database\Seeders;

use App\Models\Obat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ObatsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $obats = [
            [
                'nama_obat' => 'Paracetamol',
                'kemasan' => 'Tablet 500mg',
                'harga' => 5000
            ],
            [
                'nama_obat' => 'Amoxicillin',
                'kemasan' => 'Kapsul 500mg',
                'harga' => 8000
            ],
            [
                'nama_obat' => 'Ibuprofen',
                'kemasan' => 'Tablet 400mg',
                'harga' => 7000
            ],
            [
                'nama_obat' => 'Cetirizine',
                'kemasan' => 'Tablet 10mg',
                'harga' => 6000
            ],
            [
                'nama_obat' => 'Omeprazole',
                'kemasan' => 'Kapsul 20mg',
                'harga' => 12000
            ],
            [
                'nama_obat' => 'Salbutamol',
                'kemasan' => 'Inhaler 100mcg',
                'harga' => 45000
            ],
            [
                'nama_obat' => 'Metformin',
                'kemasan' => 'Tablet 500mg',
                'harga' => 15000
            ],
            [
                'nama_obat' => 'Simvastatin',
                'kemasan' => 'Tablet 10mg',
                'harga' => 18000
            ],
            [
                'nama_obat' => 'Captopril',
                'kemasan' => 'Tablet 25mg',
                'harga' => 10000
            ],
            [
                'nama_obat' => 'Dexamethasone',
                'kemasan' => 'Tablet 0.5mg',
                'harga' => 9000
            ],
            [
                'nama_obat' => 'Vitamin B Complex',
                'kemasan' => 'Tablet',
                'harga' => 25000
            ],
            [
                'nama_obat' => 'OBH Combi',
                'kemasan' => 'Sirup 60ml',
                'harga' => 35000
            ]
        ];

        foreach ($obats as $obat) {
            Obat::create($obat);
        }
    }
}
