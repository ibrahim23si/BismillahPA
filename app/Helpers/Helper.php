<?php

namespace App\Helpers;

use Carbon\Carbon;

class Helper
{
    /**
     * Format angka ke format rupiah
     * 
     * @param float|int $angka
     * @return string
     */
    public static function formatRupiah($angka)
    {
        if ($angka === null || $angka === '') {
            return 'Rp 0';
        }

        return 'Rp ' . number_format($angka, 0, ',', '.');
    }

    /**
     * Format angka desimal dengan 2 digit di belakang koma
     * 
     * @param float|int $angka
     * @return string
     */
    public static function formatDesimal($angka)
    {
        if ($angka === null || $angka === '') {
            return '0,00';
        }

        return number_format($angka, 2, ',', '.');
    }

    /**
     * Hitung produktivitas per jam (ton/jam)
     * 
     * @param float $totalOutput
     * @param float $totalJam
     * @return float
     */
    public static function hitungProduktivitas($totalOutput, $totalJam)
    {
        if ($totalJam <= 0 || $totalOutput <= 0) {
            return 0;
        }

        return round($totalOutput / $totalJam, 2);
    }

    /**
     * Hitung persentase pencapaian target
     * 
     * @param float $realisasi
     * @param float $target
     * @return float
     */
    public static function hitungPersentaseTarget($realisasi, $target)
    {
        if ($target <= 0) {
            return 0;
        }

        return round(($realisasi / $target) * 100, 2);
    }

    /**
     * Generate nomor transaksi otomatis
     * 
     * @param string $prefix (JM=Jual Material, AK=Aju Kas, LK=Lap Kas)
     * @param string $model (nama class model)
     * @return string
     */
    public static function generateNomorTransaksi($prefix, $model)
    {
        $tahun = date('Y');
        $bulan = date('m');

        // Cari transaksi terakhir dengan prefix yang sama di bulan ini
        $lastTransaksi = $model::whereYear('created_at', $tahun)
            ->whereMonth('created_at', $bulan)
            ->orderBy('id', 'desc')
            ->first();

        if ($lastTransaksi) {
            // Ambil 4 digit terakhir dari nomor transaksi
            $lastNumber = (int) substr($lastTransaksi->nomor_transaksi ?? $lastTransaksi->nomor_pengajuan ?? $lastTransaksi->nomor_bukti, -4);
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '0001';
        }

        return "{$prefix}/{$tahun}{$bulan}/{$newNumber}";
    }

    /**
     * Hitung selisih jam antara dua waktu
     * 
     * @param string $jamMulai (format H:i)
     * @param string $jamSelesai (format H:i)
     * @return float
     */
    public static function hitungSelisihJam($jamMulai, $jamSelesai)
    {
        $mulai = Carbon::parse($jamMulai);
        $selesai = Carbon::parse($jamSelesai);

        // Jika jam selesai lebih kecil dari jam mulai (misal: kerja lembur sampai besok)
        if ($selesai < $mulai) {
            $selesai->addDay();
        }

        $totalMenit = $mulai->diffInMinutes($selesai);
        return round($totalMenit / 60, 2);
    }

    /**
     * Get nama bulan dalam bahasa Indonesia
     * 
     * @param int $bulan (1-12)
     * @return string
     */
    public static function getNamaBulan($bulan)
    {
        $daftarBulan = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];

        return $daftarBulan[$bulan] ?? '';
    }

    /**
     * Get nama hari dalam bahasa Indonesia
     * 
     * @param string $tanggal (format Y-m-d)
     * @return string
     */
    public static function getNamaHari($tanggal)
    {
        $hari = Carbon::parse($tanggal)->dayOfWeek;

        $daftarHari = [
            0 => 'Minggu',
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu'
        ];

        return $daftarHari[$hari] ?? '';
    }

    /**
     * Cek apakah user memiliki role tertentu
     * 
     * @param string $role
     * @return bool
     */
    public static function hasRole($role)
    {
        if (!auth()->check()) {
            return false;
        }

        if (is_array($role)) {
            return in_array(auth()->user()->role, $role);
        }

        return auth()->user()->role === $role;
    }

    /**
     * Get status badge HTML
     * 
     * @param string $status (pending, approved, rejected, paid)
     * @return string
     */
    public static function getStatusBadge($status)
    {
        $badges = [
            'pending' => '<span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">Pending</span>',
            'approved' => '<span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Approved</span>',
            'rejected' => '<span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">Rejected</span>',
            'paid' => '<span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">Lunas</span>',
        ];

        return $badges[$status] ?? '<span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800">' . ucfirst($status) . '</span>';
    }
}