<?php

namespace Database\Seeders;

use App\Models\JanjiPeriksa;
use App\Models\Periksa;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class PeriksasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $janjiPeriksas = JanjiPeriksa::take(4)->get(); // Ambil 4 janji periksa pertama

        $periksas = [
            [
                'id_janji_periksa' => $janjiPeriksas[0]->id,
                'tgl_periksa' => Carbon::now()->subDays(3),
                'catatan' => 'Pasien mengalami demam tinggi. Diberikan obat penurun panas dan antibiotik. Istirahat yang cukup dan banyak minum air putih.',
                'biaya_periksa' => 150000
            ],
            [
                'id_janji_periksa' => $janjiPeriksas[1]->id,
                'tgl_periksa' => Carbon::now()->subDays(2),
                'catatan' => 'Anak mengalami ISPA ringan. Diberikan obat batuk dan vitamin. Kontrol kembali jika tidak membaik dalam 3 hari.',
                'biaya_periksa' => 120000
            ],
            [
                'id_janji_periksa' => $janjiPeriksas[2]->id,
                'tgl_periksa' => Carbon::now()->subDays(1),
                'catatan' => 'Gastritis akut. Diberikan obat maag dan anjuran diet. Hindari makanan pedas dan asam.',
                'biaya_periksa' => 175000
            ],
            [
                'id_janji_periksa' => $janjiPeriksas[3]->id,
                'tgl_periksa' => Carbon::now(),
                'catatan' => 'Kehamilan normal, janin sehat. Diberikan vitamin dan asam folat. Kontrol rutin sebulan lagi.',
                'biaya_periksa' => 200000
            ]
        ];

        foreach ($periksas as $periksaData) {
            Periksa::create($periksaData);
        }

    }
}
