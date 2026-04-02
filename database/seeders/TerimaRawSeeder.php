<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TerimaRaw;
use Carbon\Carbon;

class TerimaRawSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $suppliers = ['TAMBANG ANDALAN', 'TAMBANG SUMBER ALAM', 'TAMBANG BARU', 'TAMBANG LAMA'];
        $barang = ['BATU KASAR', 'BATU HALUS', 'BATU CAMPUR', 'MATERIAL RAW'];
        $transporters = ['ANDRI', 'JAMBUL', 'UDIN', 'HENGKI', 'RINTO', 'BEY'];
        $nopols = ['BM 8959 JO', 'BM 8890 FU', 'BA 9711 PC', 'BM 9016 ZU', 'BM 8084 BO', 'BM 9368 GU'];
        
        $data = [];
        $startDate = Carbon::parse('2025-12-01');
        $endDate = Carbon::parse('2025-12-31');
        $counter = 1;

        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            // Generate 2-8 transaksi per hari
            $transaksiPerHari = rand(2, 8);
            
            for ($i = 0; $i < $transaksiPerHari; $i++) {
                $gross = rand(2000, 6000) / 100; // 20-60 ton
                $tara = rand(400, 1800) / 100; // 4-18 ton
                $netto = $gross - $tara;
                
                $data[] = [
                    'nomor_urut' => $counter++,
                    'hari' => $date->day,
                    'tanggal' => $date->format('Y-m-d'),
                    'nomor_tiket' => sprintf('TR%06d', rand(1000, 9999)),
                    'nopol' => $nopols[array_rand($nopols)],
                    'transporter' => $transporters[array_rand($transporters)],
                    'nama_supplier' => $suppliers[array_rand($suppliers)],
                    'nama_barang' => $barang[array_rand($barang)],
                    'gross' => $gross,
                    'tara' => $tara,
                    'netto' => $netto,
                    'total_per_hari' => null,
                    'created_by' => 2, // Admin
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Insert data
        foreach (array_chunk($data, 50) as $chunk) {
            TerimaRaw::insert($chunk);
        }

        $this->command->info(count($data) . ' data terima raw berhasil dibuat!');
    }
}