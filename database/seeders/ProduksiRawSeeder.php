<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProduksiRaw;
use Carbon\Carbon;

class ProduksiRawSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [];
        $startDate = Carbon::parse('2025-12-01');
        $endDate = Carbon::parse('2025-12-31');

        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            // Skip hari Minggu untuk variasi
            if ($date->dayOfWeek == 0) {
                continue;
            }

            // Variasi output produksi (antara 80-120 ton)
            $totalOutput = rand(85, 115);
            
            // Variasi jam operasional
            $jamMulai = '07:00';
            $jamSelesai = '16:00';
            
            if (rand(1, 10) > 7) {
                // Kadang ada lembur
                $jamSelesai = '18:00';
            }

            $data[] = [
                'tanggal_produksi' => $date->format('Y-m-d'),
                'total_output' => $totalOutput,
                'jam_mulai' => $jamMulai,
                'jam_selesai' => $jamSelesai,
                'total_jam_operasional' => 0, // Akan dihitung otomatis oleh model
                'produktivitas_per_jam' => 0, // Akan dihitung otomatis oleh model
                'keterangan' => rand(1, 10) > 8 ? 'Ada downtime 1 jam karena perbaikan' : null,
                'created_by' => 2, // Admin
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Insert data
        foreach (array_chunk($data, 10) as $chunk) {
            ProduksiRaw::insert($chunk);
        }

        $this->command->info(count($data) . ' data produksi raw berhasil dibuat!');
    }
}