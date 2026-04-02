<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KeluarMaterial;
use Carbon\Carbon;

class KeluarMaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = ['SYAHRIL', 'SAMSUIR', 'RIDWAN', 'BAMBANG', 'UTM/CIPTO'];
        $barang = ['SPLITE 1-2', 'SPLITE 1-1', 'SPLITE 2-3', 'BATU ABU', 'BASE AYAKAN'];
        $transporters = ['ANDRI', 'JAMBUL', 'UDIN', 'HENGKI', 'RINTO', 'BEY'];
        $nopols = ['BM 8959 JO', 'BM 8890 FU', 'BM 9016 ZU', 'BM 8084 BO', 'BM 9368 GU'];
        
        $data = [];
        $startDate = Carbon::parse('2025-12-01');
        $endDate = Carbon::parse('2025-12-31');
        $counter = 1;

        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            // Generate 3-8 transaksi per hari
            $transaksiPerHari = rand(3, 8);
            
            for ($i = 0; $i < $transaksiPerHari; $i++) {
                $gross = rand(1200, 4800) / 100;
                $tara = rand(300, 1400) / 100;
                $netto = $gross - $tara;
                
                $hargaSatuan = rand(170000, 200000);
                
                $data[] = [
                    'nomor_urut' => $counter++,
                    'hari' => $date->day,
                    'tanggal' => $date->format('Y-m-d'),
                    'nomor_tiket' => sprintf('KM%06d', rand(1000, 9999)),
                    'nopol' => $nopols[array_rand($nopols)],
                    'transporter' => $transporters[array_rand($transporters)],
                    'nama_customer' => $customers[array_rand($customers)],
                    'nama_barang' => $barang[array_rand($barang)],
                    'gross' => $gross,
                    'tara' => $tara,
                    'netto' => $netto,
                    'total_per_hari' => null,
                    'harga_satuan' => $hargaSatuan,
                    'total_harga' => $netto * $hargaSatuan,
                    'keterangan' => null,
                    'created_by' => 2, // Admin
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        foreach (array_chunk($data, 50) as $chunk) {
            KeluarMaterial::insert($chunk);
        }

        $this->command->info(count($data) . ' data keluar material berhasil dibuat!');
    }
}