<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JualMaterial;
use Carbon\Carbon;

class JualMaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = ['SYAHRIL', 'SAMSUIR', 'RIDWAN', 'BAMBANG', 'AMI GROUP'];
        $barang = ['SPLITE 1-2', 'SPLITE 1-1', 'SPLITE 2-3', 'BATU ABU', 'BASE AYAKAN'];
        $transporters = ['ANDRI', 'JAMBUL', 'UDIN', 'HENGKI', 'RINTO', 'BEY', 'DODI'];
        $nopols = ['BM 8959 JO', 'BM 8890 FU', 'BM 9016 ZU', 'BM 8084 BO', 'BM 9368 GU', 'BM 9192 QU'];
        
        $data = [];
        $startDate = Carbon::parse('2025-12-01');
        $endDate = Carbon::parse('2025-12-31');
        $counter = 1;

        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            // Generate 3-10 transaksi per hari
            $transaksiPerHari = rand(3, 10);
            
            for ($i = 0; $i < $transaksiPerHari; $i++) {
                $gross = rand(1500, 5500) / 100; // 15-55 ton
                $tara = rand(350, 1600) / 100; // 3.5-16 ton
                $netto = $gross - $tara;
                $hargaSatuan = rand(170000, 200000);
                $totalHarga = $netto * $hargaSatuan;
                
                // 70% cash, 30% invoice
                $jenisBayar = rand(1, 10) <= 7 ? 'cash' : 'invoice';
                
                // Status: 60% approved, 30% pending, 10% rejected
                $statusRand = rand(1, 10);
                if ($statusRand <= 6) {
                    $status = 'approved';
                    $approvedBy = 1; // Super Admin
                    $approvedAt = $date->copy()->addHours(rand(1, 24));
                } elseif ($statusRand <= 9) {
                    $status = 'pending';
                    $approvedBy = null;
                    $approvedAt = null;
                } else {
                    $status = 'rejected';
                    $approvedBy = 1;
                    $approvedAt = $date->copy()->addHours(rand(1, 24));
                }

                $data[] = [
                    'nomor_transaksi' => 'JM/' . $date->format('Ym') . '/' . str_pad($counter, 4, '0', STR_PAD_LEFT),
                    'nomor_urut' => $counter++,
                    'hari' => $date->day,
                    'tanggal' => $date->format('Y-m-d'),
                    'nomor_tiket' => sprintf('JM%06d', rand(1000, 9999)),
                    'nopol' => $nopols[array_rand($nopols)],
                    'transporter' => $transporters[array_rand($transporters)],
                    'nama_customer' => $customers[array_rand($customers)],
                    'nama_barang' => $barang[array_rand($barang)],
                    'gross' => $gross,
                    'tara' => $tara,
                    'netto' => $netto,
                    'total_per_hari' => null,
                    'harga_satuan' => $hargaSatuan,
                    'total_harga' => $totalHarga,
                    'jenis_bayar' => $jenisBayar,
                    'nomor_bmk' => $jenisBayar == 'invoice' ? 'BMK-' . rand(100, 999) : null,
                    'tanggal_bmk' => $jenisBayar == 'invoice' ? $date->format('Y-m-d') : null,
                    'nominal_bmk' => $jenisBayar == 'invoice' ? $totalHarga : null,
                    'tanggal_jatuh_tempo' => $jenisBayar == 'invoice' ? $date->copy()->addDays(30)->format('Y-m-d') : null,
                    'nominal_tempo' => $jenisBayar == 'invoice' ? $totalHarga : null,
                    'status' => $status,
                    'created_by' => 3, // Kasir
                    'approved_by' => $approvedBy,
                    'approved_at' => $approvedAt,
                    'catatan_reject' => $status == 'rejected' ? 'Data tidak lengkap' : null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Insert data
        foreach (array_chunk($data, 50) as $chunk) {
            JualMaterial::insert($chunk);
        }

        $this->command->info(count($data) . ' data jual material berhasil dibuat!');
    }
}