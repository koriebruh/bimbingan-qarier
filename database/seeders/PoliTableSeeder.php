<?php

namespace Database\Seeders;

use App\Models\Poli;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PoliTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Poli::create(['name' => 'Poli Umum']);
        Poli::create(['name' => 'Poli Gigi']);
        Poli::create(['name' => 'Poli Anak']);
        Poli::create(['name' => 'Poli Mata']);
    }
}
