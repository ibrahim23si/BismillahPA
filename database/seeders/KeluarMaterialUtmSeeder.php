<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KeluarMaterialUtm;
use Carbon\Carbon;

class KeluarMaterialUtmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = ['UTM/CIPTO', 'UTM/ARI', 'UTM/SAMSUIR'];
        $barang = ['KLAS S', 'SPLITE 2-3', 'SPLITE 1-2'];
        $transporters = ['UDIN', 'HENGKI', 'RINTO', 'DODI', 'ADI', 'AAN', 'GALUNG'];
        $nopols = ['BA 9711 PC', 'BM 9016 ZU', 'BM 8084 BO', 'BM 9192 QU', 'BH 8352 YV', 'B 9347 UVX', 'BA 8454 AO'];
        
        $data = [];
        $startDate = Carbon::parse('2025-12-01');
        $endDate = Carbon::parse('2025-12-31');
        $counter = 1;

        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            // Generate 1-4 transaksi per hari
            $transaksiPerHari = rand(1, 4);
            
            for ($i = 0; $i < $transaksiPerHari; $i++) {
                $gross = rand(2000, 5500) / 100;
                $tara = rand(400, 1500) / 100;
                $netto = $gross - $tara;
                
                $data[] = [
                    'nomor_urut' => $counter++,
                    'hari' => $date->day,
                    'tanggal' => $date->format('Y-m-d'),
                    'nomor_tiket' => sprintf('UTM%06d', rand(1000, 9999)),
                    'nopol' => $nopols[array_rand($nopols)],
                    'transporter' => $transporters[array_rand($transporters)],
                    'nama_customer' => $customers[array_rand($customers)],
                    'nama_barang' => $barang[array_rand($barang)],
                    'gross' => $gross,
                    'tara' => $tara,
                    'netto' => $netto,
                    'total_per_hari' => null,
                    'keterangan' => null,
                    'created_by' => 2, // Admin
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        foreach (array_chunk($data, 50) as $chunk) {
            KeluarMaterialUtm::insert($chunk);
        }

        $this->command->info(count($data) . ' data keluar material UTM berhasil dibuat!');
    }
}