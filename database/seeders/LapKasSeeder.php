<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LapKas;
use App\Models\JualMaterial;
use App\Models\AjuKas;
use Carbon\Carbon;

class LapKasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hapus data lama
        LapKas::truncate();
        
        $data = [];
        $saldo = 10000000; // Saldo awal 10 juta
        $counter = 1;
        
        // Saldo awal
        $data[] = [
            'tanggal' => '2025-12-01',
            'nomor_bukti' => 'SALDO-AWAL',
            'keterangan' => 'Saldo Kas Awal',
            'debet' => $saldo,
            'kredit' => 0,
            'saldo' => $saldo,
            'jual_material_id' => null,
            'aju_kas_id' => null,
            'created_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        // Ambil semua jual material yang sudah approved (cash)
        $jualCash = JualMaterial::where('status', 'approved')
            ->where('jenis_bayar', 'cash')
            ->orderBy('tanggal')
            ->get();

        foreach ($jualCash as $jual) {
            $saldo += $jual->total_harga;
            
            $data[] = [
                'tanggal' => $jual->tanggal,
                'nomor_bukti' => 'LK/' . Carbon::parse($jual->tanggal)->format('Ym') . '/' . str_pad($counter++, 4, '0', STR_PAD_LEFT),
                'keterangan' => "Penjualan {$jual->nama_barang} ke {$jual->nama_customer} (Cash)",
                'debet' => $jual->total_harga,
                'kredit' => 0,
                'saldo' => $saldo,
                'jual_material_id' => $jual->id,
                'aju_kas_id' => null,
                'created_by' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Ambil semua aju kas yang sudah approved
        $ajuApproved = AjuKas::where('status', 'approved')
            ->orderBy('tanggal')
            ->get();

        foreach ($ajuApproved as $aju) {
            $saldo -= $aju->nominal;
            
            $data[] = [
                'tanggal' => $aju->tanggal,
                'nomor_bukti' => 'LK/' . Carbon::parse($aju->tanggal)->format('Ym') . '/' . str_pad($counter++, 4, '0', STR_PAD_LEFT),
                'keterangan' => "Pengajuan Kas: " . substr($aju->keterangan, 0, 50),
                'debet' => 0,
                'kredit' => $aju->nominal,
                'saldo' => $saldo,
                'jual_material_id' => null,
                'aju_kas_id' => $aju->id,
                'created_by' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Insert data berurutan berdasarkan tanggal
        $data = collect($data)->sortBy('tanggal')->values()->all();
        
        // Hitung ulang saldo berurutan
        $runningSaldo = 10000000;
        foreach ($data as $index => &$item) {
            if ($index == 0) continue; // Saldo awal sudah benar
            
            $runningSaldo = $runningSaldo + $item['debet'] - $item['kredit'];
            $item['saldo'] = $runningSaldo;
        }

        // Insert data
        foreach (array_chunk($data, 50) as $chunk) {
            LapKas::insert($chunk);
        }

        $this->command->info(count($data) . ' data lap kas berhasil dibuat!');
    }
}