<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Hutang;
use Carbon\Carbon;

class HutangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $krediturs = [
            ['PT Solar Indah', 'Solar', 15000000],
            ['PT Oli Jaya', 'Oli Mesin', 5000000],
            ['Bengkel Sinar Terang', 'Service DT 01', 3000000],
            ['CV Sparepart Makmur', 'Sparepart Crusher', 8000000],
            ['UD Kawat Las', 'Kawat Las', 2000000],
            ['Toko Bangunan Andalan', 'Material Kantor', 1500000],
            ['PLN', 'Tagihan Listrik', 2500000],
            ['PDAM', 'Tagihan Air', 500000],
            ['Vendor Keamanan', 'Jasa Keamanan', 4000000],
        ];
        
        $data = [];
        $startDate = Carbon::parse('2025-12-01');
        $endDate = Carbon::parse('2025-12-31');

        for ($date = $startDate; $date->lte($endDate); $date->addDays(rand(3, 5))) {
            $kreditur = $krediturs[array_rand($krediturs)];
            $nominal = $kreditur[2] * (rand(8, 12) / 10); // Variasi 80-120%
            
            // Status: 40% pending, 40% approved, 20% paid
            $statusRand = rand(1, 10);
            if ($statusRand <= 4) {
                $status = 'pending';
                $tanggalBayar = null;
                $cashBayar = null;
                $transferBayar = null;
            } elseif ($statusRand <= 8) {
                $status = 'approved';
                $tanggalBayar = null;
                $cashBayar = null;
                $transferBayar = null;
            } else {
                $status = 'paid';
                $tanggalBayar = $date->copy()->addDays(rand(5, 15));
                $cashBayar = rand(0, 1) ? $nominal : 0;
                $transferBayar = $cashBayar ? 0 : $nominal;
            }

            $tanggalJatuhTempo = $date->copy()->addDays(30);
            
            // Hitung over_due
            $overDue = 0;
            if (now() > $tanggalJatuhTempo && in_array($status, ['pending', 'approved'])) {
                $overDue = now()->diffInDays($tanggalJatuhTempo);
            }

            $data[] = [
                'tanggal' => $date->format('Y-m-d'),
                'nama_kreditur' => $kreditur[0],
                'jenis_transaksi' => $kreditur[1],
                'tanggal_invoice' => $date->format('Y-m-d'),
                'nomor_invoice' => 'INV-' . rand(1000, 9999),
                'nominal' => $nominal,
                'tanggal_jatuh_tempo' => $tanggalJatuhTempo,
                'over_due' => $overDue,
                'status' => $status,
                'tanggal_bayar' => $tanggalBayar,
                'cash_bayar' => $cashBayar,
                'transfer_bayar' => $transferBayar,
                'sisa' => $status == 'paid' ? 0 : $nominal - ($cashBayar ?? 0) - ($transferBayar ?? 0),
                'created_by' => 3, // Kasir
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Insert data
        Hutang::insert($data);

        $this->command->info(count($data) . ' data hutang berhasil dibuat!');
    }
}