<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Barang;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Data diambil dari semua nama barang yang digunakan
     * di seeder TerimaRaw, Timbangan, KeluarMaterial, KeluarMaterialUtm.
     */
    public function run(): void
    {
        $barangs = [
            // Dari TerimaRaw
            ['nama' => 'BATU KASAR', 'satuan' => 'Ton', 'keterangan' => 'Bahan baku raw'],
            ['nama' => 'BATU HALUS', 'satuan' => 'Ton', 'keterangan' => 'Bahan baku raw'],
            ['nama' => 'BATU CAMPUR', 'satuan' => 'Ton', 'keterangan' => 'Bahan baku raw'],
            ['nama' => 'MATERIAL RAW', 'satuan' => 'Ton', 'keterangan' => 'Bahan baku raw'],
            // Dari Timbangan & KeluarMaterial
            ['nama' => 'SPLITE 1-2', 'satuan' => 'Ton', 'keterangan' => 'Produk olahan'],
            ['nama' => 'SPLITE 1-1', 'satuan' => 'Ton', 'keterangan' => 'Produk olahan'],
            ['nama' => 'SPLITE 2-3', 'satuan' => 'Ton', 'keterangan' => 'Produk olahan'],
            ['nama' => 'BATU ABU', 'satuan' => 'Ton', 'keterangan' => 'Produk olahan'],
            ['nama' => 'KLAS S', 'satuan' => 'Ton', 'keterangan' => 'Produk olahan'],
            ['nama' => 'BASE AYAKAN', 'satuan' => 'Ton', 'keterangan' => 'Produk olahan'],
        ];

        foreach ($barangs as $barang) {
            Barang::firstOrCreate(
                ['nama' => $barang['nama']],
                [
                    'satuan' => $barang['satuan'],
                    'keterangan' => $barang['keterangan'],
                ]
            );
        }

        $this->command->info(count($barangs) . ' data barang berhasil dibuat!');
    }
}
