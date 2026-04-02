<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transporter;

class TransporterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Data diambil dari semua nama transporter yang digunakan
     * di seeder TerimaRaw, Timbangan, KeluarMaterial, KeluarMaterialUtm.
     */
    public function run(): void
    {
        $transporters = [
            ['nama' => 'ANDRI', 'keterangan' => null],
            ['nama' => 'JAMBUL', 'keterangan' => null],
            ['nama' => 'UDIN', 'keterangan' => null],
            ['nama' => 'HENGKI', 'keterangan' => null],
            ['nama' => 'RINTO', 'keterangan' => null],
            ['nama' => 'BEY', 'keterangan' => null],
            ['nama' => 'DODI', 'keterangan' => null],
            ['nama' => 'ADI', 'keterangan' => null],
            ['nama' => 'ANTO', 'keterangan' => null],
            ['nama' => 'AAN', 'keterangan' => null],
            ['nama' => 'GALUNG', 'keterangan' => null],
        ];

        foreach ($transporters as $transporter) {
            Transporter::firstOrCreate(
                ['nama' => $transporter['nama']],
                ['keterangan' => $transporter['keterangan']]
            );
        }

        $this->command->info(count($transporters) . ' data transporter berhasil dibuat!');
    }
}
