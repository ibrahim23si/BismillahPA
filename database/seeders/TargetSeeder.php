<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Target;
use Carbon\Carbon;

class TargetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Target Produksi Harian - Bulan Desember 2025
        Target::create([
            'tipe' => 'produksi',
            'periode' => 'harian',
            'tonase_target' => 100,
            'tanggal_mulai' => '2025-12-01',
            'tanggal_selesai' => '2025-12-31',
            'keterangan' => 'Target produksi harian bulan Desember 2025',
            'created_by' => 1, // Super Admin
        ]);

        // Target Produksi Mingguan
        Target::create([
            'tipe' => 'produksi',
            'periode' => 'mingguan',
            'tonase_target' => 700,
            'tanggal_mulai' => '2025-12-01',
            'tanggal_selesai' => '2025-12-07',
            'keterangan' => 'Target produksi minggu 1 Desember 2025',
            'created_by' => 1,
        ]);

        Target::create([
            'tipe' => 'produksi',
            'periode' => 'mingguan',
            'tonase_target' => 700,
            'tanggal_mulai' => '2025-12-08',
            'tanggal_selesai' => '2025-12-14',
            'keterangan' => 'Target produksi minggu 2 Desember 2025',
            'created_by' => 1,
        ]);

        // Target Produksi Bulanan
        Target::create([
            'tipe' => 'produksi',
            'periode' => 'bulanan',
            'tonase_target' => 3000,
            'tanggal_mulai' => '2025-12-01',
            'tanggal_selesai' => '2025-12-31',
            'keterangan' => 'Target produksi bulan Desember 2025',
            'created_by' => 1,
        ]);

        // Target Penjualan Bulanan
        Target::create([
            'tipe' => 'penjualan',
            'periode' => 'bulanan',
            'tonase_target' => 2800,
            'tanggal_mulai' => '2025-12-01',
            'tanggal_selesai' => '2025-12-31',
            'keterangan' => 'Target penjualan bulan Desember 2025',
            'created_by' => 1,
        ]);

        $this->command->info('5 target berhasil dibuat!');
    }
}