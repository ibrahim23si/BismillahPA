<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->command->info('=================================');
        $this->command->info('MEMULAI SEEDING DATABASE...');
        $this->command->info('=================================');

        // Panggil semua seeder secara berurutan

        // 1. User & Target
        $this->call(UserSeeder::class);
        $this->call(TargetSeeder::class);

        // 2. Data Master (harus sebelum transaksi)
        $this->call(TransporterSeeder::class);
        $this->call(BarangSeeder::class);
        $this->call(SupplierSeeder::class);
        $this->call(CustomerSeeder::class);

        // 3. Data Transaksi
        $this->call(ProduksiRawSeeder::class);
        $this->call(TimbanganSeeder::class);
        $this->call(TerimaRawSeeder::class);
        $this->call(KeluarMaterialSeeder::class);
        $this->call(KeluarMaterialUtmSeeder::class);
        $this->call(JualMaterialSeeder::class);
        $this->call(AjuKasSeeder::class);
        $this->call(LapKasSeeder::class);
        $this->call(HutangSeeder::class);
        $this->call(PiutangSeeder::class);
        $this->call(UmLemburSeeder::class); // Tambahkan ini

        $this->command->info('=================================');
        $this->command->info('SEEDING DATABASE SELESAI! ✅');
        $this->command->info('=================================');
    }
}