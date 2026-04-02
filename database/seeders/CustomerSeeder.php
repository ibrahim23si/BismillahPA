<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Data diambil dari semua nama customer yang digunakan
     * di seeder Timbangan, KeluarMaterial, KeluarMaterialUtm, JualMaterial.
     */
    public function run(): void
    {
        $customers = [
            ['name' => 'SYAHRIL', 'keterangan' => null],
            ['name' => 'SAMSUIR', 'keterangan' => null],
            ['name' => 'RIDWAN', 'keterangan' => null],
            ['name' => 'BAMBANG', 'keterangan' => null],
            ['name' => 'UTM/CIPTO', 'keterangan' => 'Customer UTM'],
            ['name' => 'AMI GROUP', 'keterangan' => null],
            ['name' => 'UTM/ARI', 'keterangan' => 'Customer UTM'],
            ['name' => 'UTM/SAMSUIR', 'keterangan' => 'Customer UTM'],
        ];

        foreach ($customers as $customer) {
            Customer::firstOrCreate(
                ['name' => $customer['name']],
                ['keterangan' => $customer['keterangan']]
            );
        }

        $this->command->info(count($customers) . ' data customer berhasil dibuat!');
    }
}
