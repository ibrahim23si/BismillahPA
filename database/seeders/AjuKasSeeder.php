<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AjuKas;
use Carbon\Carbon;

class AjuKasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pengajuan = [
            ['Pembelian solar untuk DT 01', 2000000],
            ['Pembelian solar untuk DT 02', 2000000],
            ['Pembelian solar untuk DT 03', 2000000],
            ['Pembelian oli mesin', 1500000],
            ['Service rutin crusher', 3000000],
            ['Pembelian sparepart conveyor', 5000000],
            ['Gaji lembur karyawan', 2500000],
            ['Pembelian alat safety', 1000000],
            ['Biaya operasional kantor', 500000],
            ['Pembelian kawat las', 800000],
        ];
        
        $data = [];
        $startDate = Carbon::parse('2025-12-01');
        $endDate = Carbon::parse('2025-12-31');
        $counter = 1;

        for ($date = $startDate; $date->lte($endDate); $date->addDays(rand(2, 4))) {
            // Ambil random pengajuan
            $index = array_rand($pengajuan);
            
            // Status: 70% approved, 20% pending, 10% rejected
            $statusRand = rand(1, 10);
            if ($statusRand <= 7) {
                $status = 'approved';
                $approvedBy = 1; // Super Admin
                $approvedAt = $date->copy()->addHours(rand(1, 48));
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
                'nomor_pengajuan' => 'AK/' . $date->format('Ym') . '/' . str_pad($counter++, 4, '0', STR_PAD_LEFT),
                'tanggal' => $date->format('Y-m-d'),
                'keterangan' => $pengajuan[$index][0],
                'nominal' => $pengajuan[$index][1],
                'status' => $status,
                'created_by' => 3, // Kasir
                'approved_by' => $approvedBy,
                'approved_at' => $approvedAt,
                'catatan_reject' => $status == 'rejected' ? 'Anggaran tidak mencukupi' : null,
                'tanggal_refund' => null,
                'nominal_refund' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Insert data
        AjuKas::insert($data);

        $this->command->info(count($data) . ' data aju kas berhasil dibuat!');
    }
}