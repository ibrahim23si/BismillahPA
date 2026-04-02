<?php

namespace App\Http\Controllers\Shared;

use App\Http\Controllers\Controller;
use App\Models\ProduksiRaw;
use App\Models\JualMaterial;
use App\Models\Target;
use App\Models\AjuKas;
use App\Models\LapKas;
use App\Models\Piutang;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display dashboard berdasarkan role user.
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $periode = $request->get('periode', 7); // default 7 hari
        
        // Validation: ensure periode is between 1 and 365
        if (!is_numeric($periode) || $periode < 1 || $periode > 365) {
            $periode = 7; // fallback to default
        }
        
        $periode = (int) $periode; // ensure it's integer

        // Data umum untuk semua role
        $data = [
            'totalProduksiHariIni' => $this->getTotalProduksiHariIni(),
            'totalPenjualanHariIni' => $this->getTotalPenjualanHariIni(),
            'produktivitasRataRata' => $this->getProduktivitasRataRata($periode),
            'capaianTargetProduksi' => $this->getCapaianTargetProduksi(),
            'grafikData' => $this->getGrafikData($periode),
            'produktivitasPerJam' => $this->getProduktivitasPerJam($periode),
            'periode' => $periode,
        ];

        // Data khusus berdasarkan role
        if ($user->isSuperAdmin()) {
            $data['pendingApprovals'] = $this->getPendingApprovals();
            return view('dashboard.super-admin', $data);
        }

        if ($user->isAdmin()) {
            return view('dashboard.admin', $data);
        }

        if ($user->isKasir()) {
            $data['saldoKas'] = $this->getSaldoKas();
            $data['piutangJatuhTempo'] = $this->getPiutangJatuhTempo();
            $data['totalDebet'] = LapKas::sum('debet');
            $data['totalKredit'] = LapKas::sum('kredit');
            $data['totalPiutang'] = Piutang::whereIn('status', ['pending', 'approved'])->sum('sisa');
            return view('dashboard.kasir', $data);
        }

        return view('dashboard', $data);
    }

    /**
     * Get total produksi hari ini.
     */
    private function getTotalProduksiHariIni()
    {
        return ProduksiRaw::whereDate('tanggal_produksi', today())
            ->sum('total_output') ?? 0;
    }

    /**
     * Get total penjualan hari ini.
     */
    private function getTotalPenjualanHariIni()
    {
        return JualMaterial::whereDate('tanggal', today())
            ->where('status', 'approved')
            ->sum('total_harga') ?? 0;
    }

    /**
     * Get rata-rata produktivitas berdasarkan periode.
     */
    private function getProduktivitasRataRata($periode = 7)
    {
        return ProduksiRaw::where('tanggal_produksi', '>=', now()->subDays($periode))
            ->avg('produktivitas_per_jam') ?? 0;
    }

    /**
     * Get data produktivitas per jam berdasarkan periode.
     */
    private function getProduktivitasPerJam($periode = 7)
    {
        $data = [];
        for ($i = $periode - 1; $i >= 0; $i--) {
            $tanggal = now()->subDays($i)->format('Y-m-d');
            $produksi = ProduksiRaw::whereDate('tanggal_produksi', $tanggal)->first();
            $data[] = $produksi ? $produksi->produktivitas_per_jam : 0;
        }
        return $data;
    }

    /**
     * Get capaian target produksi bulan ini.
     */
    private function getCapaianTargetProduksi()
    {
        $targetBulanan = Target::where('tipe', 'produksi')
            ->where('periode', 'bulanan')
            ->whereYear('tanggal_mulai', now()->year)
            ->whereMonth('tanggal_mulai', now()->month)
            ->first();

        if (!$targetBulanan) {
            return ['persentase' => 0, 'realisasi' => 0, 'target' => 0];
        }

        $realisasi = ProduksiRaw::whereYear('tanggal_produksi', now()->year)
            ->whereMonth('tanggal_produksi', now()->month)
            ->sum('total_output') ?? 0;

        $persentase = $targetBulanan->tonase_target > 0
            ? round(($realisasi / $targetBulanan->tonase_target) * 100, 2)
            : 0;

        return [
            'persentase' => $persentase,
            'realisasi' => $realisasi,
            'target' => $targetBulanan->tonase_target
        ];
    }

    /**
     * Get data untuk grafik berdasarkan periode.
     */
    private function getGrafikData($periode = 7)
    {
        $labels = [];
        $targetData = [];
        $realisasiData = [];

        for ($i = $periode - 1; $i >= 0; $i--) {
            $tanggal = now()->subDays($i)->format('Y-m-d');
            
            // Format label berbeda untuk periode panjang
            if ($periode <= 7) {
                $labels[] = now()->subDays($i)->format('d M');
            } elseif ($periode <= 30) {
                // Untuk 30 hari, tampilkan tanggal setiap 3 hari
                if ($i % 3 == 0) {
                    $labels[] = now()->subDays($i)->format('d M');
                } else {
                    $labels[] = '';
                }
            } else {
                // Untuk periode lebih panjang, tampilkan tanggal setiap 7 hari
                if ($i % 7 == 0) {
                    $labels[] = now()->subDays($i)->format('d M');
                } else {
                    $labels[] = '';
                }
            }

            // Realisasi produksi
            $realisasi = ProduksiRaw::whereDate('tanggal_produksi', $tanggal)
                ->sum('total_output') ?? 0;
            $realisasiData[] = round($realisasi, 2);

            // Target harian (ambil dari target terdekat)
            $target = Target::where('tipe', 'produksi')
                ->where('periode', 'harian')
                ->whereDate('tanggal_mulai', '<=', $tanggal)
                ->whereDate('tanggal_selesai', '>=', $tanggal)
                ->first();
            $targetData[] = $target ? round($target->tonase_target, 2) : 0;
        }

        return [
            'labels' => $labels,
            'target' => $targetData,
            'realisasi' => $realisasiData
        ];
    }

    /**
     * Get pending approvals (khusus super admin).
     */
    private function getPendingApprovals()
    {
        $jualPending = JualMaterial::with('creator')
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $ajuPending = AjuKas::with('creator')
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return [
            'jual' => $jualPending,
            'aju' => $ajuPending,
            'total' => $jualPending->count() + $ajuPending->count()
        ];
    }

    /**
     * Get saldo kas terakhir.
     */
    private function getSaldoKas()
    {
        $lastLapKas = LapKas::orderBy('tanggal', 'desc')
            ->orderBy('id', 'desc')
            ->first();

        return $lastLapKas ? $lastLapKas->saldo : 0;
    }

    /**
     * Get piutang jatuh tempo (7 hari ke depan).
     */
    private function getPiutangJatuhTempo()
    {
        return Piutang::whereIn('status', ['pending', 'approved'])
            ->whereDate('tanggal_jatuh_tempo', '<=', now()->addDays(7))
            ->orderBy('tanggal_jatuh_tempo', 'asc')
            ->take(5)
            ->get();
    }

    /**
     * Update dashboard data via AJAX.
     */
    public function updateData(Request $request)
    {
        $periode = $request->get('periode', 7);
        
        // Validation: ensure periode is between 1 and 365
        if (!is_numeric($periode) || $periode < 1 || $periode > 365) {
            return response()->json(['error' => 'Periode harus antara 1-365 hari'], 400);
        }
        
        $periode = (int) $periode;
        
        $data = [
            'produktivitasRataRata' => $this->getProduktivitasRataRata($periode),
            'grafikData' => $this->getGrafikData($periode),
            'produktivitasPerJam' => $this->getProduktivitasPerJam($periode),
        ];

        return response()->json($data);
    }
}