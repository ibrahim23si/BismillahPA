<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UmLembur;
use Carbon\Carbon;

class UmLemburSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Periode Desember 2025
        $periode = Carbon::create(2025, 12, 1)->format('Y-m-d');

        // Data karyawan berdasarkan Excel
        $dataKaryawan = [
            [
                'nama' => 'TONGHUI',
                'jabatan' => 'MP',
                'hari' => [], // Tidak ada lembur
                'total_jam' => 0,
                'total_upah' => 0,
            ],
            [
                'nama' => 'ROPINA',
                'jabatan' => 'Admin',
                'hari' => [
                    1 => 2, 2 => 1, 3 => 2, 4 => 1.5, 5 => 1, 6 => 1, 7 => 1,
                    8 => 1, 9 => 1, 10 => 1, 11 => 2, 12 => 1, 13 => 2, 14 => 2,
                    15 => 2, 16 => 1, 17 => 2, 18 => 1.5, 19 => 1, 20 => 1, 21 => 1,
                    22 => 1, 23 => 1, 24 => 1, 27 => 2,
                ],
                'total_jam' => 34,
                'total_upah' => 680000,
            ],
            [
                'nama' => 'REZA PAHLEPI',
                'jabatan' => 'Timbangan',
                'hari' => [
                    1 => 1, 2 => 1, 3 => 4, 4 => 2.5, 5 => 3, 6 => 1, 7 => 2,
                    9 => 2.5, 10 => 0.5, 11 => 0.5, 12 => 0.5, 13 => 3.5, 14 => 2,
                    15 => 2, 16 => 3.5, 17 => 1.5, 18 => 1.5, 19 => 2.5, 20 => 1,
                    21 => 1, 22 => 1, 23 => 1, 27 => 4.5, 28 => 1,
                ],
                'total_jam' => 45,
                'total_upah' => 890000,
            ],
            [
                'nama' => 'SENDI PRANATA',
                'jabatan' => 'Security',
                'hari' => [26 => 8],
                'total_jam' => 8,
                'total_upah' => 160000,
            ],
            [
                'nama' => 'WALMUDJRI',
                'jabatan' => 'Security',
                'hari' => [26 => 8],
                'total_jam' => 8,
                'total_upah' => 160000,
            ],
            [
                'nama' => 'JOKO',
                'jabatan' => 'Umum',
                'hari' => [
                    9 => 1, 12 => 0.5, 13 => 2, 14 => 1, 15 => 1,
                    17 => 1, 18 => 1, 19 => 1.5, 20 => 0.5, 23 => 2.5, 27 => 1,
                ],
                'total_jam' => 13,
                'total_upah' => 260000,
            ],
            [
                'nama' => 'IIP SUPRIATNA',
                'jabatan' => 'Ayakan',
                'hari' => [
                    16 => 1, 17 => 2, 18 => 7, 19 => 1, 20 => 1,
                    21 => 4, 22 => 6, 23 => 6, 24 => 4, 25 => 1, 26 => 4, 27 => 1,
                ],
                'total_jam' => 38,
                'total_upah' => 760000,
            ],
            [
                'nama' => 'MARDIUS',
                'jabatan' => 'PRIMARY',
                'hari' => [
                    1 => 1, 3 => 1, 5 => 1, 6 => 2, 7 => 1.5, 8 => 1.5,
                    9 => 1, 11 => 1, 12 => 1, 13 => 2, 16 => 1, 17 => 1,
                    18 => 1.5, 19 => 1, 20 => 1, 23 => 2, 24 => 4, 25 => 1,
                ],
                'total_jam' => 26,
                'total_upah' => 510000,
            ],
            [
                'nama' => 'AMLIANTO',
                'jabatan' => 'Helper Primary',
                'hari' => [
                    2 => 1, 3 => 1, 6 => 1, 8 => 1, 10 => 1,
                    14 => 1, 15 => 1, 16 => 1, 17 => 7, 18 => 1,
                    19 => 1, 23 => 2, 24 => 4, 25 => 1,
                ],
                'total_jam' => 24,
                'total_upah' => 480000,
            ],
            [
                'nama' => 'AGUS SURYA',
                'jabatan' => 'Electrik',
                'hari' => [
                    1 => 1, 3 => 1, 4 => 3, 5 => 1, 7 => 1, 9 => 1,
                    11 => 1, 13 => 1, 16 => 2, 17 => 3, 18 => 2,
                    19 => 3, 20 => 3, 21 => 4, 22 => 1, 23 => 6,
                    24 => 2, 25 => 1, 26 => 12,
                ],
                'total_jam' => 49,
                'total_upah' => 980000,
            ],
            [
                'nama' => 'PEKI SAPUTRA',
                'jabatan' => 'Helper 1',
                'hari' => [
                    1 => 1, 2 => 1, 3 => 2, 4 => 1, 5 => 1, 6 => 2,
                    7 => 1, 8 => 1.5, 10 => 1, 12 => 1, 13 => 2,
                    14 => 1, 15 => 1, 16 => 1, 17 => 7, 18 => 1,
                    21 => 4, 22 => 6, 25 => 1,
                ],
                'total_jam' => 36,
                'total_upah' => 710000,
            ],
            [
                'nama' => 'ROPIONAL',
                'jabatan' => 'Helper 2',
                'hari' => [
                    2 => 1, 3 => 1, 6 => 1, 8 => 1, 10 => 1,
                    12 => 1, 13 => 2, 14 => 1, 15 => 1, 16 => 1,
                    20 => 1, 21 => 4, 22 => 6, 23 => 6, 25 => 1, 26 => 12,
                ],
                'total_jam' => 41,
                'total_upah' => 820000,
            ],
            [
                'nama' => 'ZULMAN',
                'jabatan' => 'Helper 3',
                'hari' => [
                    1 => 1, 3 => 1, 5 => 1, 6 => 2, 7 => 1.5,
                    8 => 1.5, 9 => 1, 11 => 1, 12 => 1, 13 => 2,
                    16 => 1, 17 => 1, 18 => 7, 19 => 1, 20 => 1,
                    21 => 5, 22 => 2, 23 => 2, 24 => 4, 25 => 1,
                ],
                'total_jam' => 38,
                'total_upah' => 760000,
            ],
            [
                'nama' => 'BAYU',
                'jabatan' => 'Welder',
                'hari' => [
                    1 => 1, 3 => 1, 16 => 1, 17 => 1, 18 => 7,
                    19 => 1, 20 => 1, 21 => 2,
                ],
                'total_jam' => 15,
                'total_upah' => 300000,
            ],
            [
                'nama' => 'HERU GUNAWAN',
                'jabatan' => 'Welder',
                'hari' => [23 => 6, 24 => 4, 25 => 2, 26 => 12],
                'total_jam' => 24,
                'total_upah' => 480000,
            ],
            [
                'nama' => 'DEDEN AHYUDIN',
                'jabatan' => 'Welder',
                'hari' => [23 => 6, 24 => 4, 25 => 2, 26 => 12],
                'total_jam' => 24,
                'total_upah' => 480000,
            ],
        ];

        $upahPerJam = 20000;

        foreach ($dataKaryawan as $karyawan) {
            $data = [
                'periode' => $periode,
                'nama' => $karyawan['nama'],
                'jabatan' => $karyawan['jabatan'],
                'upah_per_jam' => $upahPerJam,
                'total_jam' => $karyawan['total_jam'],
                'total_upah' => $karyawan['total_upah'],
                'created_by' => 1, // Super Admin
                'created_at' => now(),
                'updated_at' => now(),
            ];

            // Set nilai default 0 untuk semua hari (1-31)
            for ($i = 1; $i <= 31; $i++) {
                $data["hari_$i"] = 0;
            }

            // Isi nilai hari yang ada lembur - PERBAIKAN DI SINI!
            foreach ($karyawan['hari'] as $hari => $jam) {
                if ($hari >= 1 && $hari <= 31) {
                    $data["hari_$hari"] = $jam; // Gunakan $hari, bukan $i!
                }
            }

            UmLembur::create($data);
        }

        $this->command->info('Data UM & Lembur untuk Desember 2025 berhasil diimport!');
        $this->command->info('Total ' . count($dataKaryawan) . ' karyawan.');
    }
}