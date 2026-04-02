<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Supplier;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Data diambil dari semua nama supplier yang digunakan
     * di seeder TerimaRaw.
     */
    public function run(): void
    {
        $suppliers = [
            ['nama' => 'TAMBANG ANDALAN', 'alamat' => 'Jl. Tambang Raya No. 1', 'telepon' => '081200001111', 'keterangan' => 'Supplier batu kasar & halus'],
            ['nama' => 'TAMBANG SUMBER ALAM', 'alamat' => 'Jl. Sumber Alam No. 5', 'telepon' => '081200002222', 'keterangan' => 'Supplier material raw'],
            ['nama' => 'TAMBANG BARU', 'alamat' => 'Jl. Tambang Baru No. 10', 'telepon' => '081200003333', 'keterangan' => 'Supplier batu campur'],
            ['nama' => 'TAMBANG LAMA', 'alamat' => 'Jl. Tambang Lama No. 15', 'telepon' => '081200004444', 'keterangan' => 'Supplier batu kasar'],
        ];

        foreach ($suppliers as $supplier) {
            Supplier::firstOrCreate(
                ['nama' => $supplier['nama']],
                [
                    'alamat' => $supplier['alamat'],
                    'telepon' => $supplier['telepon'],
                    'keterangan' => $supplier['keterangan'],
                ]
            );
        }

        $this->command->info(count($suppliers) . ' data supplier berhasil dibuat!');
    }
}
