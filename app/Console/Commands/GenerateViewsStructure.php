<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class GenerateViewsStructure extends Command
{
    protected $signature = 'make:views-structure';
    protected $description = 'Generate custom blade view structure without replacing existing files';

    public function handle()
    {
        $basePath = resource_path('views');

        $views = [

            // Dashboard
            'dashboard/super-admin.blade.php',
            'dashboard/admin.blade.php',
            'dashboard/kasir.blade.php',

            // Super Admin
            'super-admin/approvals/index.blade.php',
            'super-admin/approvals/partials/jual-material-table.blade.php',
            'super-admin/approvals/partials/aju-kas-table.blade.php',
            'super-admin/users/index.blade.php',
            'super-admin/users/create.blade.php',
            'super-admin/users/edit.blade.php',

            // Admin
            'admin/produksi-raw/index.blade.php',
            'admin/produksi-raw/create.blade.php',
            'admin/produksi-raw/edit.blade.php',
            'admin/timbangan/index.blade.php',
            'admin/timbangan/create.blade.php',
            'admin/timbangan/edit.blade.php',
            'admin/terima-raw/index.blade.php',
            'admin/terima-raw/create.blade.php',
            'admin/terima-raw/edit.blade.php',
            'admin/keluar-material/index.blade.php',
            'admin/keluar-material/create.blade.php',
            'admin/keluar-material/edit.blade.php',
            'admin/keluar-material-utm/index.blade.php',
            'admin/keluar-material-utm/create.blade.php',
            'admin/keluar-material-utm/edit.blade.php',

            // Kasir
            'kasir/jual-material/index.blade.php',
            'kasir/jual-material/create.blade.php',
            'kasir/jual-material/edit.blade.php',
            'kasir/jual-material/show.blade.php',

            'kasir/aju-kas/index.blade.php',
            'kasir/aju-kas/create.blade.php',
            'kasir/aju-kas/edit.blade.php',
            'kasir/aju-kas/show.blade.php',

            'kasir/lap-kas/index.blade.php',
            'kasir/lap-kas/create.blade.php',
            'kasir/lap-kas/partials/summary-cards.blade.php',

            'kasir/hutang/index.blade.php',
            'kasir/hutang/create.blade.php',
            'kasir/hutang/edit.blade.php',

            'kasir/piutang/index.blade.php',
            'kasir/piutang/create.blade.php',
            'kasir/piutang/edit.blade.php',

            // Readonly
            'readonly/produksi-raw/index.blade.php',
            'readonly/produksi-raw/show.blade.php',
            'readonly/timbangan/index.blade.php',
            'readonly/timbangan/show.blade.php',
            'readonly/terima-raw/index.blade.php',
            'readonly/terima-raw/show.blade.php',
            'readonly/keluar-material/index.blade.php',
            'readonly/keluar-material/show.blade.php',
            'readonly/keluar-material-utm/index.blade.php',
            'readonly/keluar-material-utm/show.blade.php',
            'readonly/jual-material/index.blade.php',
            'readonly/jual-material/show.blade.php',
            'readonly/hutang/index.blade.php',
            'readonly/hutang/show.blade.php',
            'readonly/piutang/index.blade.php',
            'readonly/piutang/show.blade.php',

            // Components
            'components/modal/delete-modal.blade.php',
            'components/modal/approval-modal.blade.php',
            'components/charts/produksi-chart.blade.php',
            'components/charts/target-chart.blade.php',
            'components/cards/stat-card.blade.php',
            'components/cards/info-card.blade.php',
        ];

        foreach ($views as $view) {

            $fullPath = $basePath . '/' . $view;
            $directory = dirname($fullPath);

            // Buat folder jika belum ada
            if (!File::exists($directory)) {
                File::makeDirectory($directory, 0755, true);
                $this->info("Folder created: $directory");
            }

            // Cek kalau file belum ada
            if (!File::exists($fullPath)) {

                File::put($fullPath, $this->defaultBladeTemplate($view));

                $this->info("Created: $view");
            } else {
                $this->warn("Skipped (already exists): $view");
            }
        }

        $this->info('View structure generation completed.');
    }

    protected function defaultBladeTemplate($view)
    {
        return <<<BLADE
@extends('layouts.app')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold">
        {$view}
    </h1>
</div>
@endsection
BLADE;
    }
}