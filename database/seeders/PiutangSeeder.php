<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Piutang;
use App\Models\JualMaterial;
use Carbon\Carbon;

class PiutangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil semua jual material invoice yang sudah approved
        $jualInvoice = JualMaterial::where('status', 'approved')
            ->where('jenis_bayar', 'invoice')
            ->get();

        $data = [];

        foreach ($jualInvoice as $jual) {
            // 70% belum lunas, 30% lunas
            $lunas = rand(1, 10) <= 3;
            
            if ($lunas) {
                $tanggalBayar = Carbon::parse($jual->tanggal)->addDays(rand(10, 25));
                $status = 'paid';
                $cashBayar = rand(0, 1) ? $jual->total_harga : 0;
                $transferBayar = $cashBayar ? 0 : $jual->total_harga;
                $sisa = 0;
            } else {
                $tanggalBayar = null;
                $status = 'approved';
                $cashBayar = null;
                $transferBayar = null;
                $sisa = $jual->total_harga;
            }

            $tanggalJatuhTempo = $jual->tanggal_jatuh_tempo ?? Carbon::parse($jual->tanggal)->addDays(30);
            
            // Hitung over_due
            $overDue = 0;
            if (now() > $tanggalJatuhTempo && $status != 'paid') {
                $overDue = now()->diffInDays($tanggalJatuhTempo);
            }

            $data[] = [
                'tanggal' => $jual->tanggal,
                'nama_debitur' => $jual->nama_customer,
                'jenis_transaksi' => $jual->nama_barang,
                'tanggal_invoice' => $jual->tanggal_bmk ?? $jual->tanggal,
                'nomor_invoice' => $jual->nomor_bmk ?? 'INV-' . rand(1000, 9999),
                'nominal' => $jual->total_harga,
                'tanggal_jatuh_tempo' => $tanggalJatuhTempo,
                'over_due' => $overDue,
                'status' => $status,
                'tanggal_bayar' => $tanggalBayar,
                'cash_bayar' => $cashBayar,
                'transfer_bayar' => $transferBayar,
                'sisa' => $sisa,
                'jual_material_id' => $jual->id,
                'created_by' => 3, // Kasir
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Insert data
        if (!empty($data)) {
            Piutang::insert($data);
        }

        $this->command->info(count($data) . ' data piutang berhasil dibuat!');
    }
}