<?php

namespace Database\Seeders;

use App\Models\Timbangan;
use App\Models\Transporter;
use App\Models\Customer;
use App\Models\Barang;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TimbanganSeeder extends Seeder
{
    /**
     * Mapping nama transporter ke ID
     */
    protected $transporterMap = [];
    
    /**
     * Mapping nama customer ke ID
     */
    protected $customerMap = [];
    
    /**
     * Mapping nama barang ke ID
     */
    protected $barangMap = [];

    /**
     * Mapping nama hari ke angka (1-7)
     * 1 = Senin, 2 = Selasa, 3 = Rabu, 4 = Kamis, 5 = Jumat, 6 = Sabtu, 7 = Minggu
     */
    protected $dayMap = [
        'Monday' => 1,    // Senin
        'Tuesday' => 2,   // Selasa
        'Wednesday' => 3, // Rabu
        'Thursday' => 4,  // Kamis
        'Friday' => 5,    // Jumat
        'Saturday' => 6,  // Sabtu
        'Sunday' => 7,    // Minggu
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Memulai seeding data timbangan...');
        
        // Buat mapping data master terlebih dahulu
        $this->buildMaps();
        
        $data = $this->getTimbanganData();
        
        $progressBar = $this->command->getOutput()->createProgressBar(count($data));
        $progressBar->start();
        
        foreach ($data as $item) {
            try {
                // Cari ID berdasarkan nama
                $transporterId = $this->getTransporterId($item['transporter']);
                
                // Hitung hari dalam angka (1-7)
                $tanggal = Carbon::parse($item['tanggal']);
                $namaHariInggris = $tanggal->format('l'); // Monday, Tuesday, etc
                $hari = $this->dayMap[$namaHariInggris] ?? 0;
                
                // Konversi string dengan koma ke float
                $gross = is_string($item['gross']) ? floatval(str_replace(',', '.', $item['gross'])) : $item['gross'];
                $tara = is_string($item['tara']) ? floatval(str_replace(',', '.', $item['tara'])) : $item['tara'];
                $netto = is_string($item['netto']) ? floatval(str_replace(',', '.', $item['netto'])) : $item['netto'];
                
                // Buat record timbangan
                Timbangan::create([
                    'nomor_urut' => $item['nomor_urut'],
                    'hari' => $hari,
                    'tanggal' => $item['tanggal'],
                    'nomor_tiket' => $item['nomor_tiket'],
                    'nopol' => $item['nopol'],
                    'transporter' => $transporterId,
                    'nama_customer' => $item['customer'],
                    'nama_barang' => $item['barang'],
                    'gross' => $gross,
                    'tara' => $tara,
                    'netto' => $netto,
                    'status_jual' => $item['status_jual'],
                    'keterangan_lain' => $item['keterangan_lain'] ?? null,
                    'harga_satuan' => $item['harga_satuan'] ?? null,
                    'total_harga' => $item['total_harga'] ?? null,
                    'keterangan' => $item['keterangan'] ?? null,
                    'created_by' => 1, // Admin
                ]);
                
                $progressBar->advance();
                
            } catch (\Exception $e) {
                $this->command->error("\nError pada nomor urut {$item['nomor_urut']}: " . $e->getMessage());
            }
        }
        
        $progressBar->finish();
        $this->command->info("\nBerhasil menambahkan " . count($data) . " data timbangan!");
    }
    
    /**
     * Get all timbangan data
     */
    protected function getTimbanganData()
    {
        return [
            // DESEMBER 2025 - 01-12-2025
            ['nomor_urut' => 1, 'tanggal' => '2025-12-01', 'nomor_tiket' => '001080', 'nopol' => 'BM 8959 JO', 'transporter' => 'ANDRI', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-2', 'gross' => 44.88, 'tara' => 13.69, 'netto' => 31.19, 'status_jual' => true],
            ['nomor_urut' => 2, 'tanggal' => '2025-12-01', 'nomor_tiket' => '001081', 'nopol' => 'BM 8890 FU', 'transporter' => 'JAMBUL', 'customer' => 'SAMSUIR', 'barang' => 'BATU ABU', 'gross' => 35.28, 'tara' => 12.11, 'netto' => 23.17, 'status_jual' => true],
            ['nomor_urut' => 3, 'tanggal' => '2025-12-01', 'nomor_tiket' => '001082', 'nopol' => 'BM 8890 FU', 'transporter' => 'JAMBUL', 'customer' => 'SAMSUIR', 'barang' => 'SPLITE 1-1', 'gross' => 32.96, 'tara' => 11.11, 'netto' => 21.85, 'status_jual' => true],
            ['nomor_urut' => 4, 'tanggal' => '2025-12-01', 'nomor_tiket' => '001083', 'nopol' => 'BM 8890 FU', 'transporter' => 'JAMBUL', 'customer' => 'SAMSUIR', 'barang' => 'BATU ABU', 'gross' => 36.93, 'tara' => 11.11, 'netto' => 25.82, 'status_jual' => true],
            ['nomor_urut' => 5, 'tanggal' => '2025-12-01', 'nomor_tiket' => '001084', 'nopol' => 'BM 8959 JO', 'transporter' => 'ANDRI', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-1', 'gross' => 43.69, 'tara' => 13.57, 'netto' => 30.12, 'status_jual' => true],
            ['nomor_urut' => 6, 'tanggal' => '2025-12-01', 'nomor_tiket' => '001085', 'nopol' => 'BM 8890 FU', 'transporter' => 'JAMBUL', 'customer' => 'SAMSUIR', 'barang' => 'SPLITE 1-1', 'gross' => 33.41, 'tara' => 11.11, 'netto' => 22.30, 'status_jual' => true],
            ['nomor_urut' => 7, 'tanggal' => '2025-12-01', 'nomor_tiket' => '001086', 'nopol' => 'BM 8959 JO', 'transporter' => 'ANDRI', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 2-3', 'gross' => 45.46, 'tara' => 13.57, 'netto' => 31.89, 'status_jual' => true],
            ['nomor_urut' => 8, 'tanggal' => '2025-12-01', 'nomor_tiket' => '001087', 'nopol' => 'BA 9711 PC', 'transporter' => 'UDIN', 'customer' => 'UTM/CIPTO', 'barang' => 'KLAS S', 'gross' => 48.16, 'tara' => 12.16, 'netto' => 36.00, 'status_jual' => false, 'keterangan_lain' => '1'],
            ['nomor_urut' => 9, 'tanggal' => '2025-12-01', 'nomor_tiket' => '001088', 'nopol' => 'BM 9016 ZU', 'transporter' => 'HENGKI', 'customer' => 'UTM/CIPTO', 'barang' => 'KLAS S', 'gross' => 52.59, 'tara' => 12.15, 'netto' => 40.44, 'status_jual' => false, 'keterangan_lain' => '1'],
            ['nomor_urut' => 10, 'tanggal' => '2025-12-01', 'nomor_tiket' => '001089', 'nopol' => 'BM 8084 BO', 'transporter' => 'RINTO', 'customer' => 'UTM/ARI', 'barang' => 'SPLITE 1-2', 'gross' => 16.91, 'tara' => 4.88, 'netto' => 12.03, 'status_jual' => false, 'keterangan_lain' => '1'],
            ['nomor_urut' => 11, 'tanggal' => '2025-12-01', 'nomor_tiket' => '001090', 'nopol' => 'BM 8959 JO', 'transporter' => 'ANDRI', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-2', 'gross' => 44.24, 'tara' => 13.58, 'netto' => 30.66, 'status_jual' => true],
            ['nomor_urut' => 12, 'tanggal' => '2025-12-01', 'nomor_tiket' => '001091', 'nopol' => 'BM 9368 GU', 'transporter' => 'BEY', 'customer' => 'RIDWAN', 'barang' => 'SPLITE 1-2', 'gross' => 11.17, 'tara' => 4.40, 'netto' => 6.77, 'status_jual' => true],
            ['nomor_urut' => 13, 'tanggal' => '2025-12-01', 'nomor_tiket' => '001092', 'nopol' => 'BM 8959 JO', 'transporter' => 'ANDRI', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-2', 'gross' => 46.93, 'tara' => 13.56, 'netto' => 33.37, 'status_jual' => true],
            ['nomor_urut' => 14, 'tanggal' => '2025-12-01', 'nomor_tiket' => '001093', 'nopol' => 'BM 9192 QU', 'transporter' => 'DODI', 'customer' => 'UTM/CIPTO', 'barang' => 'KLAS S', 'gross' => 51.40, 'tara' => 12.13, 'netto' => 39.27, 'status_jual' => false, 'keterangan_lain' => '1'],
            
            // 02-12-2025
            ['nomor_urut' => 15, 'tanggal' => '2025-12-02', 'nomor_tiket' => '001094', 'nopol' => 'BH 83 52 YV', 'transporter' => 'ADI', 'customer' => 'UTM/CIPTO', 'barang' => 'SPLITE 2-3', 'gross' => 46.44, 'tara' => 13.38, 'netto' => 33.06, 'status_jual' => false, 'keterangan_lain' => '1'],
            ['nomor_urut' => 16, 'tanggal' => '2025-12-02', 'nomor_tiket' => '001095', 'nopol' => 'BM 9148 NO', 'transporter' => 'ANTO', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-2', 'gross' => 40.27, 'tara' => 12.18, 'netto' => 28.09, 'status_jual' => true],
            ['nomor_urut' => 17, 'tanggal' => '2025-12-02', 'nomor_tiket' => '001096', 'nopol' => 'BM 9672 CT', 'transporter' => 'INDRA', 'customer' => 'RIDWAN', 'barang' => 'SPLITE 1-2', 'gross' => 10.09, 'tara' => 4.58, 'netto' => 5.51, 'status_jual' => true],
            ['nomor_urut' => 18, 'tanggal' => '2025-12-02', 'nomor_tiket' => '001097', 'nopol' => 'BM 9148 NO', 'transporter' => 'ANTO', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-2', 'gross' => 38.80, 'tara' => 12.16, 'netto' => 26.64, 'status_jual' => true],
            ['nomor_urut' => 19, 'tanggal' => '2025-12-02', 'nomor_tiket' => '001098', 'nopol' => 'BM 8507 FE', 'transporter' => 'OZI', 'customer' => 'UTM/SAMSUIR', 'barang' => 'KLAS S', 'gross' => 42.51, 'tara' => 11.89, 'netto' => 30.62, 'status_jual' => false, 'keterangan_lain' => '1'],
            ['nomor_urut' => 20, 'tanggal' => '2025-12-02', 'nomor_tiket' => '001099', 'nopol' => 'B 9347 UVX', 'transporter' => 'AAN', 'customer' => 'UTM/CIPTO', 'barang' => 'SPLITE 2-3', 'gross' => 49.04, 'tara' => 14.14, 'netto' => 34.90, 'status_jual' => false, 'keterangan_lain' => '1'],
            ['nomor_urut' => 21, 'tanggal' => '2025-12-02', 'nomor_tiket' => '001100', 'nopol' => 'BA 8454 AO', 'transporter' => 'GALUNG', 'customer' => 'UTM/CIPTO', 'barang' => 'SPLITE 2-3', 'gross' => 45.90, 'tara' => 12.09, 'netto' => 33.81, 'status_jual' => false, 'keterangan_lain' => '1'],
            ['nomor_urut' => 22, 'tanggal' => '2025-12-02', 'nomor_tiket' => '001101', 'nopol' => 'BM 9148 NO', 'transporter' => 'ANTO', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-2', 'gross' => 40.47, 'tara' => 12.13, 'netto' => 28.34, 'status_jual' => true],
            
            // 03-12-2025
            ['nomor_urut' => 23, 'tanggal' => '2025-12-03', 'nomor_tiket' => '001102', 'nopol' => 'BM 8959 JO', 'transporter' => 'ANDRI', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-1', 'gross' => 48.83, 'tara' => 13.60, 'netto' => 35.23, 'status_jual' => true],
            ['nomor_urut' => 24, 'tanggal' => '2025-12-03', 'nomor_tiket' => '001103', 'nopol' => 'BM 8578 TU', 'transporter' => 'IYAN', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-1', 'gross' => 43.55, 'tara' => 11.39, 'netto' => 32.16, 'status_jual' => true],
            ['nomor_urut' => 25, 'tanggal' => '2025-12-03', 'nomor_tiket' => '001104', 'nopol' => 'BM 9148 NO', 'transporter' => 'ANTO', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 2-3', 'gross' => 40.97, 'tara' => 12.10, 'netto' => 28.87, 'status_jual' => true],
            ['nomor_urut' => 26, 'tanggal' => '2025-12-03', 'nomor_tiket' => '001105', 'nopol' => 'BM 8296 BO', 'transporter' => 'RIZAL', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-2', 'gross' => 40.68, 'tara' => 11.70, 'netto' => 28.98, 'status_jual' => true],
            ['nomor_urut' => 27, 'tanggal' => '2025-12-03', 'nomor_tiket' => '001106', 'nopol' => 'BM 8578 TU', 'transporter' => 'IYAN', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-1', 'gross' => 40.14, 'tara' => 11.37, 'netto' => 28.77, 'status_jual' => true],
            ['nomor_urut' => 28, 'tanggal' => '2025-12-03', 'nomor_tiket' => '001107', 'nopol' => 'B 9347 UVX', 'transporter' => 'AAN', 'customer' => 'UTM/CIPTO', 'barang' => 'KLAS S', 'gross' => 48.36, 'tara' => 14.16, 'netto' => 34.20, 'status_jual' => false, 'keterangan_lain' => '1'],
            ['nomor_urut' => 29, 'tanggal' => '2025-12-03', 'nomor_tiket' => '001108', 'nopol' => 'BM 9821 PB', 'transporter' => 'GERDI', 'customer' => 'RIDWAN', 'barang' => 'SPLITE 2-3', 'gross' => 11.92, 'tara' => 4.44, 'netto' => 7.48, 'status_jual' => true],
            ['nomor_urut' => 30, 'tanggal' => '2025-12-03', 'nomor_tiket' => '001109', 'nopol' => 'BL 8704 JH', 'transporter' => 'LUBIS', 'customer' => 'RIDWAN', 'barang' => 'SPLITE 1-2', 'gross' => 11.11, 'tara' => 4.44, 'netto' => 6.67, 'status_jual' => true],
            ['nomor_urut' => 31, 'tanggal' => '2025-12-03', 'nomor_tiket' => '001110', 'nopol' => 'BA 8454 AO', 'transporter' => 'GALUNG', 'customer' => 'UTM/CIPTO', 'barang' => 'KLAS S', 'gross' => 46.76, 'tara' => 12.02, 'netto' => 34.74, 'status_jual' => false, 'keterangan_lain' => '1'],
            ['nomor_urut' => 32, 'tanggal' => '2025-12-03', 'nomor_tiket' => '001111', 'nopol' => 'BM 8365 BU', 'transporter' => 'EKO', 'customer' => 'RIDWAN', 'barang' => 'SPLITE 1-2', 'gross' => 10.43, 'tara' => 4.78, 'netto' => 5.65, 'status_jual' => true],
            ['nomor_urut' => 33, 'tanggal' => '2025-12-03', 'nomor_tiket' => '001112', 'nopol' => 'BM 8352 YU', 'transporter' => 'ADI', 'customer' => 'SAMSUIR', 'barang' => 'BATU ABU/1-1', 'gross' => 28.94, 'tara' => 13.36, 'netto' => 15.58, 'status_jual' => true],
            ['nomor_urut' => 34, 'tanggal' => '2025-12-03', 'nomor_tiket' => '001113', 'nopol' => 'BM 8094 BO', 'transporter' => 'RINTO', 'customer' => 'UTM/ARI', 'barang' => 'SPLITE 1-2', 'gross' => 14.69, 'tara' => 4.68, 'netto' => 10.01, 'status_jual' => false, 'keterangan_lain' => '1'],
            ['nomor_urut' => 35, 'tanggal' => '2025-12-03', 'nomor_tiket' => '001114', 'nopol' => 'BH 83 52 YV', 'transporter' => 'ADI', 'customer' => 'UTM/CIPTO', 'barang' => 'KLAS S', 'gross' => 52.01, 'tara' => 13.36, 'netto' => 38.65, 'status_jual' => false, 'keterangan_lain' => '1'],
            ['nomor_urut' => 36, 'tanggal' => '2025-12-03', 'nomor_tiket' => '001115', 'nopol' => 'BM 9192 QU', 'transporter' => 'DODI', 'customer' => 'UTM/CIPTO', 'barang' => 'KLAS S', 'gross' => 51.13, 'tara' => 12.08, 'netto' => 39.05, 'status_jual' => false, 'keterangan_lain' => '1'],
            ['nomor_urut' => 37, 'tanggal' => '2025-12-03', 'nomor_tiket' => '001116', 'nopol' => 'BA 8959 JU', 'transporter' => 'RANDI', 'customer' => 'SAMSUIR', 'barang' => 'SPLITE 1-1', 'gross' => 38.14, 'tara' => 12.76, 'netto' => 25.38, 'status_jual' => true],
            ['nomor_urut' => 38, 'tanggal' => '2025-12-03', 'nomor_tiket' => '001117', 'nopol' => 'BA 8759 JU', 'transporter' => 'ANDRE', 'customer' => 'SAMSUIR', 'barang' => 'SPLITE 1-1', 'gross' => 42.20, 'tara' => 12.90, 'netto' => 29.30, 'status_jual' => true],
            ['nomor_urut' => 39, 'tanggal' => '2025-12-03', 'nomor_tiket' => '001118', 'nopol' => 'BK 8698 CL', 'transporter' => 'AGUNG', 'customer' => 'SAMSUIR', 'barang' => 'BATU ABU', 'gross' => 45.63, 'tara' => 12.93, 'netto' => 32.70, 'status_jual' => true],
            ['nomor_urut' => 40, 'tanggal' => '2025-12-03', 'nomor_tiket' => '001119', 'nopol' => 'BK 9318 SN', 'transporter' => 'ROMI', 'customer' => 'SAMSUIR', 'barang' => 'SPLITE 1-2', 'gross' => 38.59, 'tara' => 11.90, 'netto' => 26.69, 'status_jual' => true],
            ['nomor_urut' => 41, 'tanggal' => '2025-12-03', 'nomor_tiket' => '001120', 'nopol' => 'BM 8011 OU', 'transporter' => 'YANDRA', 'customer' => 'SAMSUIR', 'barang' => 'SPLITE 1-2', 'gross' => 38.60, 'tara' => 12.50, 'netto' => 26.10, 'status_jual' => true],
            ['nomor_urut' => 42, 'tanggal' => '2025-12-03', 'nomor_tiket' => '001121', 'nopol' => 'BA 8759 JU', 'transporter' => 'ANDRE', 'customer' => 'UTM/CIPTO', 'barang' => 'KLAS S', 'gross' => 54.20, 'tara' => 12.90, 'netto' => 41.30, 'status_jual' => false, 'keterangan_lain' => '1'],
            ['nomor_urut' => 43, 'tanggal' => '2025-12-03', 'nomor_tiket' => '001122', 'nopol' => 'BA 9859 JU', 'transporter' => 'RANDI', 'customer' => 'UTM/CIPTO', 'barang' => 'KLAS S', 'gross' => 53.84, 'tara' => 12.76, 'netto' => 41.08, 'status_jual' => false, 'keterangan_lain' => '1'],
            ['nomor_urut' => 44, 'tanggal' => '2025-12-03', 'nomor_tiket' => '001123', 'nopol' => 'BM 43.920', 'transporter' => 'YANDRA', 'customer' => 'UTM/CIPTO', 'barang' => 'KLAS S', 'gross' => 43.92, 'tara' => 12.50, 'netto' => 31.42, 'status_jual' => false, 'keterangan_lain' => '1'],
            ['nomor_urut' => 45, 'tanggal' => '2025-12-03', 'nomor_tiket' => '001124', 'nopol' => 'BK 8698 CL', 'transporter' => 'AGUNG', 'customer' => 'UTM/CIPTO', 'barang' => 'KLAS S', 'gross' => 49.42, 'tara' => 12.93, 'netto' => 36.49, 'status_jual' => false, 'keterangan_lain' => '1'],
            ['nomor_urut' => 46, 'tanggal' => '2025-12-03', 'nomor_tiket' => '001125', 'nopol' => 'BK 9318 SN', 'transporter' => 'ROMI', 'customer' => 'UTM/CIPTO', 'barang' => 'KLAS S', 'gross' => 47.21, 'tara' => 11.90, 'netto' => 35.31, 'status_jual' => false, 'keterangan_lain' => '1'],
            ['nomor_urut' => 47, 'tanggal' => '2025-12-03', 'nomor_tiket' => '001126', 'nopol' => 'BM 8849 RU', 'transporter' => 'GOVY', 'customer' => 'UTM/CIPTO', 'barang' => 'KLAS S', 'gross' => 41.96, 'tara' => 11.25, 'netto' => 30.71, 'status_jual' => false, 'keterangan_lain' => '1'],
            ['nomor_urut' => 48, 'tanggal' => '2025-12-03', 'nomor_tiket' => '001127', 'nopol' => 'BM 8850 RO', 'transporter' => 'DOBLE', 'customer' => 'UTM/CIPTO', 'barang' => 'KLAS S', 'gross' => 42.75, 'tara' => 11.38, 'netto' => 31.37, 'status_jual' => false, 'keterangan_lain' => '1'],
            
            // 04-12-2025
            ['nomor_urut' => 49, 'tanggal' => '2025-12-04', 'nomor_tiket' => '001128', 'nopol' => 'BM 8632 BO', 'transporter' => 'ROY', 'customer' => 'BAMBANG', 'barang' => 'SPLITE 2-3', 'gross' => 13.76, 'tara' => 4.22, 'netto' => 9.54, 'status_jual' => true],
            ['nomor_urut' => 50, 'tanggal' => '2025-12-04', 'nomor_tiket' => '001129', 'nopol' => 'BM 9351 MF', 'transporter' => 'RENDI', 'customer' => 'RIDWAN', 'barang' => 'SPLTE 1-2', 'gross' => 8.13, 'tara' => 3.88, 'netto' => 4.25, 'status_jual' => true],
            ['nomor_urut' => 51, 'tanggal' => '2025-12-04', 'nomor_tiket' => '001130', 'nopol' => 'BM 8566 BO', 'transporter' => 'ANTO', 'customer' => 'BAMBANG', 'barang' => 'SPLTE 1-2', 'gross' => 11.23, 'tara' => 3.90, 'netto' => 7.33, 'status_jual' => true],
            ['nomor_urut' => 52, 'tanggal' => '2025-12-04', 'nomor_tiket' => '001131', 'nopol' => 'BM 8959 JO', 'transporter' => 'ANDRI', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-1', 'gross' => 46.40, 'tara' => 13.56, 'netto' => 32.84, 'status_jual' => true],
            ['nomor_urut' => 53, 'tanggal' => '2025-12-04', 'nomor_tiket' => '001132', 'nopol' => 'BM 8566 BO', 'transporter' => 'ANTO', 'customer' => 'BAMBANG', 'barang' => 'SPLITE 2-3', 'gross' => 12.01, 'tara' => 3.90, 'netto' => 8.11, 'status_jual' => true],
            ['nomor_urut' => 54, 'tanggal' => '2025-12-04', 'nomor_tiket' => '001133', 'nopol' => 'BM 8632 BO', 'transporter' => 'ROY', 'customer' => 'BAMBANG', 'barang' => 'SPLITE 1-2', 'gross' => 12.33, 'tara' => 4.20, 'netto' => 8.13, 'status_jual' => true],
            ['nomor_urut' => 55, 'tanggal' => '2025-12-04', 'nomor_tiket' => '001134', 'nopol' => 'BA 8759 JU', 'transporter' => 'ANDRE', 'customer' => 'SAMSUIR', 'barang' => 'BATU ABU', 'gross' => 51.53, 'tara' => 12.90, 'netto' => 38.63, 'status_jual' => true],
            ['nomor_urut' => 56, 'tanggal' => '2025-12-04', 'nomor_tiket' => '001135', 'nopol' => 'BM 8011 OU', 'transporter' => 'YANDRA', 'customer' => 'SAMSUIR', 'barang' => 'SPLITE 1-1', 'gross' => 47.98, 'tara' => 12.50, 'netto' => 35.48, 'status_jual' => true],
            ['nomor_urut' => 57, 'tanggal' => '2025-12-04', 'nomor_tiket' => '001136', 'nopol' => 'BM 8011 OU', 'transporter' => 'YANDRA', 'customer' => 'SAMSUIR', 'barang' => 'SPLITE 1-2', 'gross' => 33.49, 'tara' => 12.50, 'netto' => 20.99, 'status_jual' => true],
            ['nomor_urut' => 58, 'tanggal' => '2025-12-04', 'nomor_tiket' => '001137', 'nopol' => 'BM 8011 OU', 'transporter' => 'YANDRA', 'customer' => 'SAMSUIR', 'barang' => 'SPLITE 1-2', 'gross' => 44.17, 'tara' => 12.50, 'netto' => 31.67, 'status_jual' => true],
            ['nomor_urut' => 59, 'tanggal' => '2025-12-04', 'nomor_tiket' => '001138', 'nopol' => 'BK 9318 SN', 'transporter' => 'ROMI', 'customer' => 'SAMSUIR', 'barang' => 'SPLITE 1-2', 'gross' => 40.08, 'tara' => 11.90, 'netto' => 28.18, 'status_jual' => true],
            ['nomor_urut' => 60, 'tanggal' => '2025-12-04', 'nomor_tiket' => '001139', 'nopol' => 'BK 8698 CL', 'transporter' => 'AGUNG', 'customer' => 'SAMSUIR', 'barang' => 'SPLITE 2-3', 'gross' => 32.18, 'tara' => 12.93, 'netto' => 19.25, 'status_jual' => true],
            ['nomor_urut' => 61, 'tanggal' => '2025-12-04', 'nomor_tiket' => '001140', 'nopol' => 'BA 8759 JU', 'transporter' => 'ANDRE', 'customer' => 'UTM/CIPTO', 'barang' => 'KLAS S', 'gross' => 48.53, 'tara' => 12.90, 'netto' => 35.63, 'status_jual' => false, 'keterangan_lain' => '1'],
            ['nomor_urut' => 62, 'tanggal' => '2025-12-04', 'nomor_tiket' => '001141', 'nopol' => 'BM 8011 OU', 'transporter' => 'YANDRA', 'customer' => 'UTM/CIPTO', 'barang' => 'KLAS S', 'gross' => 48.40, 'tara' => 12.50, 'netto' => 35.90, 'status_jual' => false, 'keterangan_lain' => '1'],
            ['nomor_urut' => 63, 'tanggal' => '2025-12-04', 'nomor_tiket' => '001142', 'nopol' => 'BA 9859 JU', 'transporter' => 'RANDI', 'customer' => 'UTM/CIPTO', 'barang' => 'KLAS S', 'gross' => 48.89, 'tara' => 12.76, 'netto' => 36.13, 'status_jual' => false, 'keterangan_lain' => '1'],
            ['nomor_urut' => 64, 'tanggal' => '2025-12-04', 'nomor_tiket' => '001143', 'nopol' => 'BK 9318 SN', 'transporter' => 'ROMI', 'customer' => 'UTM/CIPTO', 'barang' => 'KLAS S', 'gross' => 48.77, 'tara' => 11.90, 'netto' => 36.87, 'status_jual' => false, 'keterangan_lain' => '1'],
            ['nomor_urut' => 65, 'tanggal' => '2025-12-04', 'nomor_tiket' => '001144', 'nopol' => 'BK 8698 CL', 'transporter' => 'AGUNG', 'customer' => 'UTM/CIPTO', 'barang' => 'KLAS S', 'gross' => 49.39, 'tara' => 12.93, 'netto' => 36.46, 'status_jual' => false, 'keterangan_lain' => '1'],
            
            // 05-12-2025
            ['nomor_urut' => 66, 'tanggal' => '2025-12-05', 'nomor_tiket' => '001145', 'nopol' => 'BM 8566 BO', 'transporter' => 'ANTO', 'customer' => 'BAMBANG', 'barang' => 'SPLITE 1-2', 'gross' => 12.55, 'tara' => 3.93, 'netto' => 8.62, 'status_jual' => true],
            ['nomor_urut' => 67, 'tanggal' => '2025-12-05', 'nomor_tiket' => '001146', 'nopol' => 'BM 9672 CT', 'transporter' => 'INDRA', 'customer' => 'RIDWAN', 'barang' => 'SPLITE 1-2', 'gross' => 9.56, 'tara' => 4.56, 'netto' => 5.00, 'status_jual' => true],
            ['nomor_urut' => 68, 'tanggal' => '2025-12-05', 'nomor_tiket' => '001147', 'nopol' => 'BM 8632 BO', 'transporter' => 'ROY', 'customer' => 'BAMBANG', 'barang' => 'SPLITE 2-3', 'gross' => 12.91, 'tara' => 4.24, 'netto' => 8.67, 'status_jual' => true],
            ['nomor_urut' => 69, 'tanggal' => '2025-12-05', 'nomor_tiket' => '001148', 'nopol' => 'B 9347 UVX', 'transporter' => 'AAN', 'customer' => 'SAMSUIR', 'barang' => 'SPLITE 2-3', 'gross' => 46.77, 'tara' => 14.16, 'netto' => 32.61, 'status_jual' => true],
            ['nomor_urut' => 70, 'tanggal' => '2025-12-05', 'nomor_tiket' => '001149', 'nopol' => 'BA 8454 AO', 'transporter' => 'GALUNG', 'customer' => 'SAMSUIR', 'barang' => 'SPLITE 2-3', 'gross' => 45.50, 'tara' => 12.19, 'netto' => 33.31, 'status_jual' => true],
            ['nomor_urut' => 71, 'tanggal' => '2025-12-05', 'nomor_tiket' => '001150', 'nopol' => 'BM 8959 JO', 'transporter' => 'ANDRI', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-1', 'gross' => 47.24, 'tara' => 13.59, 'netto' => 33.65, 'status_jual' => true],
            ['nomor_urut' => 72, 'tanggal' => '2025-12-05', 'nomor_tiket' => '001151', 'nopol' => 'BM 8632 BO', 'transporter' => 'ROY', 'customer' => 'BAMBANG', 'barang' => 'SPLITE 2-3', 'gross' => 13.17, 'tara' => 4.22, 'netto' => 8.95, 'status_jual' => true],
            ['nomor_urut' => 73, 'tanggal' => '2025-12-05', 'nomor_tiket' => '001152', 'nopol' => 'BM 8566 BO', 'transporter' => 'ANTO', 'customer' => 'BAMBANG', 'barang' => 'SPLITE 1-2', 'gross' => 11.87, 'tara' => 3.94, 'netto' => 7.93, 'status_jual' => true],
            ['nomor_urut' => 74, 'tanggal' => '2025-12-05', 'nomor_tiket' => '001153', 'nopol' => 'BM 9637 GU', 'transporter' => 'HENGKI', 'customer' => 'RIDWAN', 'barang' => 'SPLITE 1-2', 'gross' => 11.77, 'tara' => 4.64, 'netto' => 7.13, 'status_jual' => true],
            ['nomor_urut' => 75, 'tanggal' => '2025-12-05', 'nomor_tiket' => '001154', 'nopol' => 'BM 9192 OU', 'transporter' => 'DODI', 'customer' => 'SAMSUIR', 'barang' => 'BATU ABU', 'gross' => 37.55, 'tara' => 12.07, 'netto' => 25.48, 'status_jual' => true],
            ['nomor_urut' => 76, 'tanggal' => '2025-12-05', 'nomor_tiket' => '001155', 'nopol' => 'BM 9192 OU', 'transporter' => 'DODI', 'customer' => 'SAMSUIR', 'barang' => 'BATU ABU', 'gross' => 18.90, 'tara' => 12.07, 'netto' => 6.83, 'status_jual' => true],
            ['nomor_urut' => 77, 'tanggal' => '2025-12-05', 'nomor_tiket' => '001156', 'nopol' => 'BM 9192 OU', 'transporter' => 'DODI', 'customer' => 'SAMSUIR', 'barang' => 'SPLITE 2-3', 'gross' => 33.66, 'tara' => 12.07, 'netto' => 21.59, 'status_jual' => true],
            ['nomor_urut' => 78, 'tanggal' => '2025-12-05', 'nomor_tiket' => '001157', 'nopol' => 'BM 9192 OU', 'transporter' => 'DODI', 'customer' => 'SAMSUIR', 'barang' => 'SPLITE 1--1', 'gross' => 52.07, 'tara' => 12.07, 'netto' => 40.00, 'status_jual' => true],
            ['nomor_urut' => 79, 'tanggal' => '2025-12-05', 'nomor_tiket' => '001158', 'nopol' => 'BM 9192 OU', 'transporter' => 'DODI', 'customer' => 'SAMSUIR', 'barang' => 'SPLITE 1-2', 'gross' => 35.63, 'tara' => 12.07, 'netto' => 23.56, 'status_jual' => true],
            ['nomor_urut' => 80, 'tanggal' => '2025-12-05', 'nomor_tiket' => '001159', 'nopol' => 'BH 8352 YV', 'transporter' => 'ADI', 'customer' => 'SAMSUIR', 'barang' => 'SPLITE 1-2', 'gross' => 35.93, 'tara' => 13.33, 'netto' => 22.60, 'status_jual' => true],
            ['nomor_urut' => 81, 'tanggal' => '2025-12-05', 'nomor_tiket' => '001160', 'nopol' => 'BM 9192 OU', 'transporter' => 'DODI', 'customer' => 'UTM/CIPTO', 'barang' => 'KLAS S', 'gross' => 49.72, 'tara' => 12.07, 'netto' => 37.65, 'status_jual' => false, 'keterangan_lain' => '1'],
            ['nomor_urut' => 82, 'tanggal' => '2025-12-05', 'nomor_tiket' => '001161', 'nopol' => 'BH 8352 YV', 'transporter' => 'ADI', 'customer' => 'UTM/CIPTO', 'barang' => 'KLAS S', 'gross' => 46.03, 'tara' => 13.33, 'netto' => 32.70, 'status_jual' => false, 'keterangan_lain' => '1'],
            
            // 06-12-2025
            ['nomor_urut' => 83, 'tanggal' => '2025-12-06', 'nomor_tiket' => '001162', 'nopol' => 'BA 8759 JU', 'transporter' => 'ANDRE', 'customer' => 'UTM/CIPTO', 'barang' => 'KLAS S', 'gross' => 49.96, 'tara' => 12.79, 'netto' => 37.17, 'status_jual' => true],
            ['nomor_urut' => 84, 'tanggal' => '2025-12-06', 'nomor_tiket' => '001163', 'nopol' => 'BM 8632 BO', 'transporter' => 'ROY', 'customer' => 'BAMBANG', 'barang' => 'SPLITE 1-2', 'gross' => 14.10, 'tara' => 4.21, 'netto' => 9.89, 'status_jual' => true],
            ['nomor_urut' => 85, 'tanggal' => '2025-12-06', 'nomor_tiket' => '001164', 'nopol' => 'BM 8498 EM', 'transporter' => 'JUNTAK', 'customer' => 'RIDWAN', 'barang' => 'SPLITE 1-2', 'gross' => 11.18, 'tara' => 4.41, 'netto' => 6.77, 'status_jual' => true],
            ['nomor_urut' => 86, 'tanggal' => '2025-12-06', 'nomor_tiket' => '001165', 'nopol' => 'BM 9148 NO', 'transporter' => 'ANTO', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-1', 'gross' => 42.74, 'tara' => 12.19, 'netto' => 30.55, 'status_jual' => true],
            ['nomor_urut' => 87, 'tanggal' => '2025-12-06', 'nomor_tiket' => '001166', 'nopol' => 'BM 9192 OU', 'transporter' => 'ANDRI', 'customer' => 'SYAHRIL', 'barang' => 'BATU ABU', 'gross' => 48.24, 'tara' => 13.55, 'netto' => 34.69, 'status_jual' => true],
            ['nomor_urut' => 88, 'tanggal' => '2025-12-06', 'nomor_tiket' => '001167', 'nopol' => 'BM 8127 GB', 'transporter' => 'DUWI', 'customer' => 'RIDWAN', 'barang' => 'SPLITE 2-3', 'gross' => 8.62, 'tara' => 4.10, 'netto' => 4.52, 'status_jual' => true],
            ['nomor_urut' => 89, 'tanggal' => '2025-12-06', 'nomor_tiket' => '001168', 'nopol' => 'BM 9906 BO', 'transporter' => 'AJI', 'customer' => 'BAMBANG', 'barang' => 'SPLITE 2-3', 'gross' => 14.60, 'tara' => 4.13, 'netto' => 10.47, 'status_jual' => true],
            ['nomor_urut' => 90, 'tanggal' => '2025-12-06', 'nomor_tiket' => '001169', 'nopol' => 'F 9502 FC', 'transporter' => 'IWIR', 'customer' => 'UTM/CIPTO', 'barang' => 'KLAS S', 'gross' => 47.24, 'tara' => 12.74, 'netto' => 34.50, 'status_jual' => false, 'keterangan_lain' => '1'],
            ['nomor_urut' => 91, 'tanggal' => '2025-12-06', 'nomor_tiket' => '001170', 'nopol' => 'BM 9672 CT', 'transporter' => 'INDRA', 'customer' => 'RIDWAN', 'barang' => 'SPLITE 1-2', 'gross' => 9.28, 'tara' => 4.61, 'netto' => 4.67, 'status_jual' => true],
            ['nomor_urut' => 92, 'tanggal' => '2025-12-06', 'nomor_tiket' => '001171', 'nopol' => 'BA 8061 PU', 'transporter' => 'MAN', 'customer' => 'RIDWAN', 'barang' => 'SPLITE 1-2', 'gross' => 11.73, 'tara' => 4.33, 'netto' => 7.40, 'status_jual' => true],
            ['nomor_urut' => 93, 'tanggal' => '2025-12-06', 'nomor_tiket' => '001172', 'nopol' => 'BM 8632 BO', 'transporter' => 'ROY', 'customer' => 'BAMBANG', 'barang' => 'SPLITE 1-2', 'gross' => 13.26, 'tara' => 4.18, 'netto' => 9.08, 'status_jual' => true],
            
            // 07-12-2025
            ['nomor_urut' => 94, 'tanggal' => '2025-12-07', 'nomor_tiket' => '001173', 'nopol' => 'BM 9906 BO', 'transporter' => 'AJI', 'customer' => 'BAMBANG', 'barang' => 'SPLITE 2-3', 'gross' => 15.19, 'tara' => 4.12, 'netto' => 11.07, 'status_jual' => true],
            ['nomor_urut' => 95, 'tanggal' => '2025-12-07', 'nomor_tiket' => '001174', 'nopol' => 'BM 8632 BO', 'transporter' => 'ROY', 'customer' => 'BAMBANG', 'barang' => 'SPLITE 2-3', 'gross' => 14.67, 'tara' => 4.18, 'netto' => 10.49, 'status_jual' => true],
            ['nomor_urut' => 96, 'tanggal' => '2025-12-07', 'nomor_tiket' => '001175', 'nopol' => 'BM 8390 GA', 'transporter' => 'IIN', 'customer' => 'RIDWAN', 'barang' => 'SPLITE 1-2', 'gross' => 10.16, 'tara' => 4.16, 'netto' => 6.00, 'status_jual' => true],
            ['nomor_urut' => 97, 'tanggal' => '2025-12-07', 'nomor_tiket' => '001176', 'nopol' => 'BM 9188 LB', 'transporter' => 'DEFRI', 'customer' => 'BAMBANG', 'barang' => 'SPLITE 2-3', 'gross' => 12.96, 'tara' => 4.17, 'netto' => 8.79, 'status_jual' => true],
            ['nomor_urut' => 98, 'tanggal' => '2025-12-07', 'nomor_tiket' => '001177', 'nopol' => 'BM 8540 BP', 'transporter' => 'BUDI', 'customer' => 'SAMSUIR', 'barang' => 'SPLITE 2-3', 'gross' => 15.80, 'tara' => 4.80, 'netto' => 11.00, 'status_jual' => true],
            ['nomor_urut' => 99, 'tanggal' => '2025-12-07', 'nomor_tiket' => '001178', 'nopol' => 'BM 8957 JO', 'transporter' => 'DANI', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 2-3', 'gross' => 45.60, 'tara' => 13.42, 'netto' => 32.18, 'status_jual' => true],
            ['nomor_urut' => 100, 'tanggal' => '2025-12-07', 'nomor_tiket' => '001179', 'nopol' => 'BM 9461 GU', 'transporter' => 'NAIDI', 'customer' => 'RIDWAN', 'barang' => 'SPLITE 1-2', 'gross' => 11.72, 'tara' => 4.54, 'netto' => 7.18, 'status_jual' => true],
            ['nomor_urut' => 101, 'tanggal' => '2025-12-07', 'nomor_tiket' => '001180', 'nopol' => 'BM 9188 LB', 'transporter' => 'DEFRI', 'customer' => 'BAMBANG', 'barang' => 'SPLITE 2-3', 'gross' => 13.47, 'tara' => 4.17, 'netto' => 9.30, 'status_jual' => true],
            ['nomor_urut' => 102, 'tanggal' => '2025-12-07', 'nomor_tiket' => '001181', 'nopol' => 'BM 9906 BU', 'transporter' => 'AJI', 'customer' => 'BAMBANG', 'barang' => 'SPLITE 2-3', 'gross' => 12.32, 'tara' => 4.10, 'netto' => 8.22, 'status_jual' => true],
            ['nomor_urut' => 103, 'tanggal' => '2025-12-07', 'nomor_tiket' => '001182', 'nopol' => 'BM 8390 GA', 'transporter' => 'IIN', 'customer' => 'RIDWAN', 'barang' => 'SPLITE 1-2', 'gross' => 12.14, 'tara' => 4.13, 'netto' => 8.01, 'status_jual' => true],
            
            // 08-12-2025
            ['nomor_urut' => 104, 'tanggal' => '2025-12-08', 'nomor_tiket' => '001183', 'nopol' => 'BM 8632 BO', 'transporter' => 'ROY', 'customer' => 'BAMBANG', 'barang' => 'SPLITE 2-3', 'gross' => 13.00, 'tara' => 4.10, 'netto' => 8.90, 'status_jual' => true],
            ['nomor_urut' => 105, 'tanggal' => '2025-12-08', 'nomor_tiket' => '001184', 'nopol' => 'BM 8566 BO', 'transporter' => 'ANTO', 'customer' => 'BAMBANG', 'barang' => 'SPLITE 1-2', 'gross' => 12.77, 'tara' => 3.90, 'netto' => 8.87, 'status_jual' => true],
            ['nomor_urut' => 106, 'tanggal' => '2025-12-08', 'nomor_tiket' => '001185', 'nopol' => 'BM 8565 BO', 'transporter' => 'GULTOM', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 2-3', 'gross' => 42.23, 'tara' => 11.82, 'netto' => 30.41, 'status_jual' => true],
            ['nomor_urut' => 107, 'tanggal' => '2025-12-08', 'nomor_tiket' => '001186', 'nopol' => 'BM 8957 JO', 'transporter' => 'DANI', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-2', 'gross' => 43.54, 'tara' => 13.31, 'netto' => 30.23, 'status_jual' => true],
            ['nomor_urut' => 108, 'tanggal' => '2025-12-08', 'nomor_tiket' => '001187', 'nopol' => 'BM 9906 BU', 'transporter' => 'AJI', 'customer' => 'BAMBANG', 'barang' => 'SPLITE 1-2', 'gross' => 15.00, 'tara' => 4.13, 'netto' => 10.87, 'status_jual' => true],
            ['nomor_urut' => 109, 'tanggal' => '2025-12-08', 'nomor_tiket' => '001188', 'nopol' => 'BM 8959 JO', 'transporter' => 'ANDRI', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-2', 'gross' => 45.48, 'tara' => 13.57, 'netto' => 31.91, 'status_jual' => true],
            ['nomor_urut' => 110, 'tanggal' => '2025-12-08', 'nomor_tiket' => '001189', 'nopol' => 'BM 9148 NO', 'transporter' => 'ANTO', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-2', 'gross' => 40.48, 'tara' => 12.11, 'netto' => 28.37, 'status_jual' => true],
            ['nomor_urut' => 111, 'tanggal' => '2025-12-08', 'nomor_tiket' => '001190', 'nopol' => 'BM 8853 AO', 'transporter' => 'UJANG', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-2', 'gross' => 42.46, 'tara' => 11.86, 'netto' => 30.60, 'status_jual' => true],
            ['nomor_urut' => 112, 'tanggal' => '2025-12-08', 'nomor_tiket' => '001191', 'nopol' => 'BH 8344 ML', 'transporter' => 'LUKAS', 'customer' => 'RIDWAN', 'barang' => 'SPLITE 1-2', 'gross' => 9.83, 'tara' => 4.76, 'netto' => 5.07, 'status_jual' => true],
            ['nomor_urut' => 113, 'tanggal' => '2025-12-08', 'nomor_tiket' => '001192', 'nopol' => 'BM 8568 BO', 'transporter' => 'GULTOM', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 2-3', 'gross' => 41.28, 'tara' => 11.77, 'netto' => 29.51, 'status_jual' => true],
            ['nomor_urut' => 114, 'tanggal' => '2025-12-08', 'nomor_tiket' => '001193', 'nopol' => 'BM 8566 BO', 'transporter' => 'ANTO', 'customer' => 'BAMBANG', 'barang' => 'SPLITE  1-2', 'gross' => 11.85, 'tara' => 3.88, 'netto' => 7.97, 'status_jual' => true],
            ['nomor_urut' => 115, 'tanggal' => '2025-12-08', 'nomor_tiket' => '001194', 'nopol' => 'BM 8632 BO', 'transporter' => 'ROY', 'customer' => 'BAMBANG', 'barang' => 'SPLITE 2-3', 'gross' => 11.49, 'tara' => 4.17, 'netto' => 7.32, 'status_jual' => true],
            
            // 09-12-2025
            ['nomor_urut' => 116, 'tanggal' => '2025-12-09', 'nomor_tiket' => '001195', 'nopol' => 'BM 8681 LQ', 'transporter' => 'DIAN', 'customer' => 'RIDWAN', 'barang' => 'SPLITE 1-2', 'gross' => 9.03, 'tara' => 4.38, 'netto' => 4.65, 'status_jual' => true],
            ['nomor_urut' => 117, 'tanggal' => '2025-12-09', 'nomor_tiket' => '001196', 'nopol' => 'BM 9148 NO', 'transporter' => 'ANTO', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 2-3', 'gross' => 41.73, 'tara' => 12.07, 'netto' => 29.66, 'status_jual' => true],
            ['nomor_urut' => 118, 'tanggal' => '2025-12-09', 'nomor_tiket' => '001197', 'nopol' => 'BM 8957 JO', 'transporter' => 'DANI', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 2-3', 'gross' => 41.50, 'tara' => 13.31, 'netto' => 28.19, 'status_jual' => true],
            ['nomor_urut' => 119, 'tanggal' => '2025-12-09', 'nomor_tiket' => '001198', 'nopol' => 'BM 8959 JO', 'transporter' => 'ANDRI', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 2-3', 'gross' => 44.26, 'tara' => 13.62, 'netto' => 30.64, 'status_jual' => true],
            ['nomor_urut' => 120, 'tanggal' => '2025-12-09', 'nomor_tiket' => '001199', 'nopol' => 'BM 8240 BP', 'transporter' => 'UCAN', 'customer' => 'RIDWAN', 'barang' => 'SPLITE 1-2', 'gross' => 12.62, 'tara' => 4.50, 'netto' => 8.12, 'status_jual' => true],
            ['nomor_urut' => 121, 'tanggal' => '2025-12-09', 'nomor_tiket' => '001200', 'nopol' => 'BM 8853 AO', 'transporter' => 'UJANG', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-2', 'gross' => 43.60, 'tara' => 12.01, 'netto' => 31.59, 'status_jual' => true],
            ['nomor_urut' => 122, 'tanggal' => '2025-12-09', 'nomor_tiket' => '001201', 'nopol' => 'BM 8390 GA', 'transporter' => 'IIN', 'customer' => 'RIDWAN', 'barang' => 'SPLITE 1-2', 'gross' => 12.49, 'tara' => 4.14, 'netto' => 8.35, 'status_jual' => true],
            ['nomor_urut' => 123, 'tanggal' => '2025-12-09', 'nomor_tiket' => '001202', 'nopol' => 'BM 9148 NO', 'transporter' => 'ANDRI', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-2', 'gross' => 45.01, 'tara' => 13.60, 'netto' => 31.41, 'status_jual' => true],
            ['nomor_urut' => 124, 'tanggal' => '2025-12-09', 'nomor_tiket' => '001203', 'nopol' => 'BM 8567 BO', 'transporter' => 'DANI', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-2', 'gross' => 44.59, 'tara' => 13.33, 'netto' => 31.26, 'status_jual' => true],
            ['nomor_urut' => 125, 'tanggal' => '2025-12-09', 'nomor_tiket' => '001204', 'nopol' => 'BM 9148 NO', 'transporter' => 'ANDRI', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-2', 'gross' => 46.12, 'tara' => 13.59, 'netto' => 32.53, 'status_jual' => true],
            ['nomor_urut' => 126, 'tanggal' => '2025-12-09', 'nomor_tiket' => '001205', 'nopol' => 'BM 8567 BO', 'transporter' => 'ROMA', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-2', 'gross' => 41.19, 'tara' => 12.03, 'netto' => 29.16, 'status_jual' => true],
            ['nomor_urut' => 127, 'tanggal' => '2025-12-09', 'nomor_tiket' => '001206', 'nopol' => 'BM 8853 AO', 'transporter' => 'UJANG', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-2', 'gross' => 40.60, 'tara' => 11.98, 'netto' => 28.62, 'status_jual' => true],
            ['nomor_urut' => 128, 'tanggal' => '2025-12-09', 'nomor_tiket' => '001207', 'nopol' => 'BM 8581 BP', 'transporter' => 'EEN', 'customer' => 'RIDWAN', 'barang' => 'SPLITE 1-2', 'gross' => 10.36, 'tara' => 4.33, 'netto' => 6.03, 'status_jual' => true],
            ['nomor_urut' => 129, 'tanggal' => '2025-12-09', 'nomor_tiket' => '001208', 'nopol' => 'BM 9310 CU', 'transporter' => 'UCOK', 'customer' => 'RIDWAN', 'barang' => 'SPLITE 2-3', 'gross' => 42.01, 'tara' => 12.39, 'netto' => 29.62, 'status_jual' => true],
            ['nomor_urut' => 130, 'tanggal' => '2025-12-09', 'nomor_tiket' => '001209', 'nopol' => 'BM 8853 AO', 'transporter' => 'UJANG', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-2', 'gross' => 41.75, 'tara' => 11.96, 'netto' => 29.79, 'status_jual' => true],
            ['nomor_urut' => 131, 'tanggal' => '2025-12-09', 'nomor_tiket' => '001210', 'nopol' => 'BM 8984 QO', 'transporter' => 'WAWAN', 'customer' => 'RIDWAN', 'barang' => 'SPLITE 2-3', 'gross' => 9.27, 'tara' => 4.26, 'netto' => 5.01, 'status_jual' => true],
            
            // 10-12-2025
            ['nomor_urut' => 132, 'tanggal' => '2025-12-10', 'nomor_tiket' => '001211', 'nopol' => 'BM 8957 JO', 'transporter' => 'DANI', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-2', 'gross' => 42.68, 'tara' => 13.34, 'netto' => 29.34, 'status_jual' => true],
            ['nomor_urut' => 133, 'tanggal' => '2025-12-10', 'nomor_tiket' => '001212', 'nopol' => 'BM 8957 JO', 'transporter' => 'DANI', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-2', 'gross' => 45.27, 'tara' => 13.33, 'netto' => 31.94, 'status_jual' => true],
            ['nomor_urut' => 134, 'tanggal' => '2025-12-10', 'nomor_tiket' => '001213', 'nopol' => 'BM 8957 JO', 'transporter' => 'DANI', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-1', 'gross' => 44.56, 'tara' => 13.39, 'netto' => 31.17, 'status_jual' => true],
            ['nomor_urut' => 135, 'tanggal' => '2025-12-10', 'nomor_tiket' => '001214', 'nopol' => 'BM 8957 JO', 'transporter' => 'DANI', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-1', 'gross' => 43.23, 'tara' => 13.39, 'netto' => 29.84, 'status_jual' => true],
            ['nomor_urut' => 136, 'tanggal' => '2025-12-10', 'nomor_tiket' => '001215', 'nopol' => 'BM 8390 GA', 'transporter' => 'IIN', 'customer' => 'RIDWAN', 'barang' => 'SPLITE 1-2', 'gross' => 11.36, 'tara' => 4.16, 'netto' => 7.20, 'status_jual' => true],
            ['nomor_urut' => 137, 'tanggal' => '2025-12-10', 'nomor_tiket' => '001216', 'nopol' => 'BM 8957 JO', 'transporter' => 'DANI', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-1', 'gross' => 43.64, 'tara' => 13.45, 'netto' => 30.19, 'status_jual' => true],
            ['nomor_urut' => 138, 'tanggal' => '2025-12-10', 'nomor_tiket' => '001217', 'nopol' => 'BM 8850 RU', 'transporter' => 'DOBLE', 'customer' => 'ADE', 'barang' => 'SPLITE 2-3', 'gross' => 42.26, 'tara' => 11.51, 'netto' => 30.75, 'status_jual' => true],
            ['nomor_urut' => 139, 'tanggal' => '2025-12-10', 'nomor_tiket' => '001218', 'nopol' => 'BM 8957 JO', 'transporter' => 'DANI', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-1', 'gross' => 45.52, 'tara' => 13.45, 'netto' => 32.07, 'status_jual' => true],
            ['nomor_urut' => 140, 'tanggal' => '2025-12-10', 'nomor_tiket' => '001219', 'nopol' => 'BM 8957 JO', 'transporter' => 'DANI', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-2', 'gross' => 43.93, 'tara' => 13.45, 'netto' => 30.48, 'status_jual' => true],
            ['nomor_urut' => 141, 'tanggal' => '2025-12-10', 'nomor_tiket' => '001220', 'nopol' => 'BM 8957 JO', 'transporter' => 'DANI', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-2', 'gross' => 43.45, 'tara' => 13.44, 'netto' => 30.01, 'status_jual' => true],
            ['nomor_urut' => 142, 'tanggal' => '2025-12-10', 'nomor_tiket' => '001221', 'nopol' => 'BM 8957 JO', 'transporter' => 'DANI', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-2', 'gross' => 42.39, 'tara' => 13.45, 'netto' => 28.94, 'status_jual' => true],
            ['nomor_urut' => 143, 'tanggal' => '2025-12-10', 'nomor_tiket' => '001222', 'nopol' => 'BM 9612 GU', 'transporter' => 'RAHMAN', 'customer' => 'RIDWAN', 'barang' => 'BASE AYAKAN', 'gross' => 11.78, 'tara' => 4.84, 'netto' => 6.94, 'status_jual' => true],
            
            // 11-12-2025
            ['nomor_urut' => 144, 'tanggal' => '2025-12-11', 'nomor_tiket' => '001223', 'nopol' => 'BM 8957 JO', 'transporter' => 'DANI', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-2', 'gross' => 43.39, 'tara' => 13.51, 'netto' => 29.88, 'status_jual' => true],
            ['nomor_urut' => 145, 'tanggal' => '2025-12-11', 'nomor_tiket' => '001224', 'nopol' => 'BM 9368 GU', 'transporter' => 'HARAHAP', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-2', 'gross' => 42.22, 'tara' => 11.84, 'netto' => 30.38, 'status_jual' => true],
            ['nomor_urut' => 146, 'tanggal' => '2025-12-11', 'nomor_tiket' => '001225', 'nopol' => 'BM 8957 JO', 'transporter' => 'DANI', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 2-3', 'gross' => 44.23, 'tara' => 13.42, 'netto' => 30.81, 'status_jual' => true],
            ['nomor_urut' => 147, 'tanggal' => '2025-12-11', 'nomor_tiket' => '001226', 'nopol' => 'BM 8957 JO', 'transporter' => 'DANI', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-2', 'gross' => 43.48, 'tara' => 13.49, 'netto' => 29.99, 'status_jual' => true],
            ['nomor_urut' => 148, 'tanggal' => '2025-12-11', 'nomor_tiket' => '001227', 'nopol' => 'BM 9612 GU', 'transporter' => 'IRUL', 'customer' => 'RIDWAN', 'barang' => 'SPLITE 1-2', 'gross' => 7.00, 'tara' => 4.35, 'netto' => 2.65, 'status_jual' => true],
            ['nomor_urut' => 149, 'tanggal' => '2025-12-11', 'nomor_tiket' => '001228', 'nopol' => 'BM 8957 JO', 'transporter' => 'DANI', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 2-3', 'gross' => 42.82, 'tara' => 13.50, 'netto' => 29.32, 'status_jual' => true],
            
            // 12-12-2025
            ['nomor_urut' => 150, 'tanggal' => '2025-12-12', 'nomor_tiket' => '001229', 'nopol' => 'BM 9340 BU', 'transporter' => 'SAMOSIR', 'customer' => 'RIDWAN', 'barang' => 'SPLITE 1-2', 'gross' => 9.28, 'tara' => 4.27, 'netto' => 5.01, 'status_jual' => true],
            ['nomor_urut' => 151, 'tanggal' => '2025-12-12', 'nomor_tiket' => '001230', 'nopol' => 'BM 8256 BU', 'transporter' => 'DIAN', 'customer' => 'RIDWAN', 'barang' => 'SPLITE 1-2', 'gross' => 10.34, 'tara' => 4.64, 'netto' => 5.70, 'status_jual' => true],
            ['nomor_urut' => 152, 'tanggal' => '2025-12-12', 'nomor_tiket' => '001231', 'nopol' => 'BM 9274 CT', 'transporter' => 'WAWAN', 'customer' => 'RIDWAN', 'barang' => 'BASE AYAKAN', 'gross' => 10.52, 'tara' => 4.64, 'netto' => 5.88, 'status_jual' => true],
            ['nomor_urut' => 153, 'tanggal' => '2025-12-12', 'nomor_tiket' => '001232', 'nopol' => 'BM 9353 GU', 'transporter' => 'JUL', 'customer' => 'RIDWAN', 'barang' => 'SPLITE 2-3', 'gross' => 10.35, 'tara' => 4.09, 'netto' => 6.26, 'status_jual' => true],
            ['nomor_urut' => 154, 'tanggal' => '2025-12-12', 'nomor_tiket' => '001233', 'nopol' => 'BM 9322 BU', 'transporter' => 'SAMAN', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 2-3', 'gross' => 43.53, 'tara' => 12.02, 'netto' => 31.51, 'status_jual' => true],
            ['nomor_urut' => 155, 'tanggal' => '2025-12-12', 'nomor_tiket' => '001234', 'nopol' => 'BM 9322 BU', 'transporter' => 'SAMAN', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 2-3', 'gross' => 44.80, 'tara' => 12.11, 'netto' => 32.69, 'status_jual' => true],
            ['nomor_urut' => 156, 'tanggal' => '2025-12-12', 'nomor_tiket' => '001235', 'nopol' => 'BM 8569 BO', 'transporter' => 'MANULANG', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 2-3', 'gross' => 42.93, 'tara' => 11.73, 'netto' => 31.20, 'status_jual' => true],
            ['nomor_urut' => 157, 'tanggal' => '2025-12-12', 'nomor_tiket' => '001236', 'nopol' => 'BM 9906 BU', 'transporter' => 'AJI', 'customer' => 'RIDWAN', 'barang' => 'BASE AYAKAN', 'gross' => 9.33, 'tara' => 4.12, 'netto' => 5.21, 'status_jual' => true],
            ['nomor_urut' => 158, 'tanggal' => '2025-12-12', 'nomor_tiket' => '001237', 'nopol' => 'BM 9274 CT', 'transporter' => 'WAWAN', 'customer' => 'RIDWAN', 'barang' => 'BASE AYAKAN', 'gross' => 8.92, 'tara' => 4.32, 'netto' => 4.60, 'status_jual' => true],
            ['nomor_urut' => 159, 'tanggal' => '2025-12-12', 'nomor_tiket' => '001238', 'nopol' => 'BM 9322 BU', 'transporter' => 'SAMAN', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 2-3', 'gross' => 41.72, 'tara' => 12.08, 'netto' => 29.64, 'status_jual' => true],
            ['nomor_urut' => 160, 'tanggal' => '2025-12-12', 'nomor_tiket' => '001239', 'nopol' => 'BM 8668 ZU', 'transporter' => 'ARDI', 'customer' => 'RIDWAN', 'barang' => 'BRONJONG', 'gross' => 8.26, 'tara' => 4.65, 'netto' => 3.61, 'status_jual' => true],
            ['nomor_urut' => 161, 'tanggal' => '2025-12-12', 'nomor_tiket' => '001240', 'nopol' => 'BM 8568 BO', 'transporter' => 'GULTOM', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 2-3', 'gross' => 41.11, 'tara' => 11.82, 'netto' => 29.29, 'status_jual' => true],
            ['nomor_urut' => 162, 'tanggal' => '2025-12-12', 'nomor_tiket' => '001241', 'nopol' => 'BM 9322 BU', 'transporter' => 'SAMAN', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 2-3', 'gross' => 42.70, 'tara' => 12.07, 'netto' => 30.63, 'status_jual' => true],
            ['nomor_urut' => 163, 'tanggal' => '2025-12-12', 'nomor_tiket' => '001242', 'nopol' => 'BM 8568 BO', 'transporter' => 'GULTOM', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 2-3', 'gross' => 41.34, 'tara' => 11.88, 'netto' => 29.46, 'status_jual' => true],
            ['nomor_urut' => 164, 'tanggal' => '2025-12-12', 'nomor_tiket' => '001243', 'nopol' => 'BM 9821 PB', 'transporter' => 'GERDI', 'customer' => 'RIDWAN', 'barang' => 'BRONJONG', 'gross' => 12.16, 'tara' => 4.39, 'netto' => 7.77, 'status_jual' => true],
            
            // 13-12-2025
            ['nomor_urut' => 165, 'tanggal' => '2025-12-13', 'nomor_tiket' => '001244', 'nopol' => 'BM 9322 BU', 'transporter' => 'SAMAN', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-2', 'gross' => 42.11, 'tara' => 12.15, 'netto' => 29.96, 'status_jual' => true],
            ['nomor_urut' => 166, 'tanggal' => '2025-12-13', 'nomor_tiket' => '001245', 'nopol' => 'BM 8956 JO', 'transporter' => 'JUNTAK', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 2-3', 'gross' => 42.77, 'tara' => 12.95, 'netto' => 29.82, 'status_jual' => true],
            ['nomor_urut' => 167, 'tanggal' => '2025-12-13', 'nomor_tiket' => '001246', 'nopol' => 'BM 9322 BU', 'transporter' => 'SAMAN', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-2', 'gross' => 44.11, 'tara' => 12.15, 'netto' => 31.96, 'status_jual' => true],
            ['nomor_urut' => 168, 'tanggal' => '2025-12-13', 'nomor_tiket' => '001247', 'nopol' => 'BM 9560 BO', 'transporter' => 'JABAT', 'customer' => 'RIDWAN', 'barang' => 'BASE AYAKAN', 'gross' => 11.99, 'tara' => 4.16, 'netto' => 7.83, 'status_jual' => true],
            ['nomor_urut' => 169, 'tanggal' => '2025-12-13', 'nomor_tiket' => '001248', 'nopol' => 'BM 8956 JO', 'transporter' => 'JUNTAK', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-2', 'gross' => 41.82, 'tara' => 12.94, 'netto' => 28.88, 'status_jual' => true],
            ['nomor_urut' => 170, 'tanggal' => '2025-12-13', 'nomor_tiket' => '001249', 'nopol' => 'BM 9322 BU', 'transporter' => 'SAMAN', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-2', 'gross' => 43.44, 'tara' => 12.15, 'netto' => 31.29, 'status_jual' => true],
            ['nomor_urut' => 171, 'tanggal' => '2025-12-13', 'nomor_tiket' => '001250', 'nopol' => 'BM 8956 JO', 'transporter' => 'JUNTAK', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-2', 'gross' => 43.11, 'tara' => 12.94, 'netto' => 30.17, 'status_jual' => true],
            ['nomor_urut' => 172, 'tanggal' => '2025-12-13', 'nomor_tiket' => '001251', 'nopol' => 'BM 9322 BU', 'transporter' => 'SAMAN', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-2', 'gross' => 42.26, 'tara' => 12.15, 'netto' => 30.11, 'status_jual' => true],
            ['nomor_urut' => 173, 'tanggal' => '2025-12-13', 'nomor_tiket' => '001252', 'nopol' => 'BM 8681 JU', 'transporter' => 'RIKO', 'customer' => 'BAMBANG', 'barang' => 'SPLITE 1-2', 'gross' => 6.81, 'tara' => 4.04, 'netto' => 2.77, 'status_jual' => true],
            ['nomor_urut' => 174, 'tanggal' => '2025-12-13', 'nomor_tiket' => '001253', 'nopol' => 'BM 9243 JU', 'transporter' => 'PUTRA', 'customer' => 'RIDWAN', 'barang' => 'BASE AYAKAN', 'gross' => 35.84, 'tara' => 12.23, 'netto' => 23.61, 'status_jual' => true],
            ['nomor_urut' => 175, 'tanggal' => '2025-12-13', 'nomor_tiket' => '001254', 'nopol' => 'BM 8456 BI', 'transporter' => 'SUTRISNO', 'customer' => 'RIDWAN', 'barang' => 'SPLITE 1-2', 'gross' => 3.15, 'tara' => 1.30, 'netto' => 1.85, 'status_jual' => true],
            ['nomor_urut' => 176, 'tanggal' => '2025-12-13', 'nomor_tiket' => '001255', 'nopol' => 'BM 8298 BO', 'transporter' => 'IFDAL', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-2', 'gross' => 40.99, 'tara' => 12.35, 'netto' => 28.64, 'status_jual' => true],
            ['nomor_urut' => 177, 'tanggal' => '2025-12-13', 'nomor_tiket' => '001256', 'nopol' => 'BM 8957 JO', 'transporter' => 'DANI', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-1', 'gross' => 42.60, 'tara' => 13.44, 'netto' => 29.16, 'status_jual' => true],
            ['nomor_urut' => 178, 'tanggal' => '2025-12-13', 'nomor_tiket' => '001257', 'nopol' => 'BM 9322 BU', 'transporter' => 'SAMAN', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-2', 'gross' => 41.80, 'tara' => 12.13, 'netto' => 29.67, 'status_jual' => true],
            ['nomor_urut' => 179, 'tanggal' => '2025-12-13', 'nomor_tiket' => '001258', 'nopol' => 'BM 8956 JO', 'transporter' => 'JUNTAK', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-2', 'gross' => 41.80, 'tara' => 12.91, 'netto' => 28.89, 'status_jual' => true],
            ['nomor_urut' => 180, 'tanggal' => '2025-12-13', 'nomor_tiket' => '001259', 'nopol' => 'BM 8578 TU', 'transporter' => 'IYAN', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-2', 'gross' => 39.26, 'tara' => 11.39, 'netto' => 27.87, 'status_jual' => true],
            ['nomor_urut' => 181, 'tanggal' => '2025-12-13', 'nomor_tiket' => '001260', 'nopol' => 'BM 8298 BO', 'transporter' => 'IFDAL', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-2', 'gross' => 41.05, 'tara' => 12.33, 'netto' => 28.72, 'status_jual' => true],
            ['nomor_urut' => 182, 'tanggal' => '2025-12-13', 'nomor_tiket' => '001261', 'nopol' => 'BM 9368 GU', 'transporter' => 'HARAHAP', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-2', 'gross' => 37.91, 'tara' => 11.96, 'netto' => 25.95, 'status_jual' => true],
            ['nomor_urut' => 183, 'tanggal' => '2025-12-13', 'nomor_tiket' => '001262', 'nopol' => 'BM 8957 JO', 'transporter' => 'DANI', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-2', 'gross' => 42.69, 'tara' => 13.50, 'netto' => 29.19, 'status_jual' => true],
            ['nomor_urut' => 184, 'tanggal' => '2025-12-13', 'nomor_tiket' => '001263', 'nopol' => 'BM 9322 BU', 'transporter' => 'SAMAN', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 2-3', 'gross' => 42.69, 'tara' => 12.03, 'netto' => 30.66, 'status_jual' => true],
            ['nomor_urut' => 185, 'tanggal' => '2025-12-13', 'nomor_tiket' => '001264', 'nopol' => 'BM 8956 JO', 'transporter' => 'JUNTAK', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 2-3', 'gross' => 43.61, 'tara' => 12.88, 'netto' => 30.73, 'status_jual' => true],
            ['nomor_urut' => 186, 'tanggal' => '2025-12-13', 'nomor_tiket' => '001265', 'nopol' => 'BM 8578 TU', 'transporter' => 'IYAN', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-2', 'gross' => 39.89, 'tara' => 11.37, 'netto' => 28.52, 'status_jual' => true],
            ['nomor_urut' => 187, 'tanggal' => '2025-12-13', 'nomor_tiket' => '001266', 'nopol' => 'BM 8298 BO', 'transporter' => 'IFDAL', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-2', 'gross' => 38.57, 'tara' => 12.32, 'netto' => 26.25, 'status_jual' => true],
            ['nomor_urut' => 188, 'tanggal' => '2025-12-13', 'nomor_tiket' => '001267', 'nopol' => 'BM 9732 DJ', 'transporter' => 'ARDI', 'customer' => 'RIDWAN', 'barang' => 'SPLITE 1-2', 'gross' => 12.58, 'tara' => 4.47, 'netto' => 8.11, 'status_jual' => true],
            ['nomor_urut' => 189, 'tanggal' => '2025-12-13', 'nomor_tiket' => '001268', 'nopol' => 'BM 9368 GU', 'transporter' => 'HARAHAP', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-2', 'gross' => 39.56, 'tara' => 11.96, 'netto' => 27.60, 'status_jual' => true],
            ['nomor_urut' => 190, 'tanggal' => '2025-12-13', 'nomor_tiket' => '001269', 'nopol' => 'BM 8569 BO', 'transporter' => 'MANULANG', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 2-3', 'gross' => 40.21, 'tara' => 11.82, 'netto' => 28.39, 'status_jual' => true],
            ['nomor_urut' => 191, 'tanggal' => '2025-12-13', 'nomor_tiket' => '001270', 'nopol' => 'BM 8297 BO', 'transporter' => 'GALUNG', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 2-3', 'gross' => 41.69, 'tara' => 11.74, 'netto' => 29.95, 'status_jual' => true],
            ['nomor_urut' => 192, 'tanggal' => '2025-12-13', 'nomor_tiket' => '001271', 'nopol' => 'BH 8344 ML', 'transporter' => 'LUKAS', 'customer' => 'RIDWAN', 'barang' => 'SPLITE 1-2', 'gross' => 9.64, 'tara' => 4.71, 'netto' => 4.93, 'status_jual' => true],
            ['nomor_urut' => 193, 'tanggal' => '2025-12-13', 'nomor_tiket' => '001272', 'nopol' => 'BM 8957 JO', 'transporter' => 'DANI', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-2', 'gross' => 44.08, 'tara' => 13.49, 'netto' => 30.59, 'status_jual' => true],
            ['nomor_urut' => 194, 'tanggal' => '2025-12-13', 'nomor_tiket' => '001273', 'nopol' => 'BM 9577 BU', 'transporter' => 'RANGGA', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-2', 'gross' => 41.71, 'tara' => 11.65, 'netto' => 30.06, 'status_jual' => true],
            ['nomor_urut' => 195, 'tanggal' => '2025-12-13', 'nomor_tiket' => '001274', 'nopol' => 'BM 8578 TU', 'transporter' => 'IYAN', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 2-3', 'gross' => 43.39, 'tara' => 11.38, 'netto' => 32.01, 'status_jual' => true],
            ['nomor_urut' => 196, 'tanggal' => '2025-12-13', 'nomor_tiket' => '001275', 'nopol' => 'BM 8298 BO', 'transporter' => 'IFDAL', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 2-3', 'gross' => 42.42, 'tara' => 12.33, 'netto' => 30.09, 'status_jual' => true],
            ['nomor_urut' => 197, 'tanggal' => '2025-12-13', 'nomor_tiket' => '001276', 'nopol' => 'BM 9248 JU', 'transporter' => 'PUTRA', 'customer' => 'RIDWAN', 'barang' => 'BASE AYAKAN', 'gross' => 37.01, 'tara' => 12.15, 'netto' => 24.86, 'status_jual' => true],
            
            // 14-12-2025
            ['nomor_urut' => 198, 'tanggal' => '2025-12-14', 'nomor_tiket' => '001277', 'nopol' => 'BM 8698 TR', 'transporter' => 'MINGAN', 'customer' => 'DAUS', 'barang' => 'SPLITE 2-3', 'gross' => 13.40, 'tara' => 4.49, 'netto' => 8.91, 'status_jual' => true],
            ['nomor_urut' => 199, 'tanggal' => '2025-12-14', 'nomor_tiket' => '001278', 'nopol' => 'BM 8254 HM', 'transporter' => 'TAMIM', 'customer' => 'RIDWAN', 'barang' => 'SPLITE 1-2', 'gross' => 10.98, 'tara' => 4.36, 'netto' => 6.62, 'status_jual' => true],
            ['nomor_urut' => 200, 'tanggal' => '2025-12-14', 'nomor_tiket' => '001279', 'nopol' => 'BM 8698 TR', 'transporter' => 'MINGAN', 'customer' => 'DAUS', 'barang' => 'SPLITE 2-3', 'gross' => 12.75, 'tara' => 4.51, 'netto' => 8.24, 'status_jual' => true],
            ['nomor_urut' => 201, 'tanggal' => '2025-12-14', 'nomor_tiket' => '001280', 'nopol' => 'BM 9893 AO', 'transporter' => 'RAHMAT', 'customer' => 'AMI GROUP', 'barang' => 'KLAS S', 'gross' => 40.63, 'tara' => 12.07, 'netto' => 28.56, 'status_jual' => true],
            ['nomor_urut' => 202, 'tanggal' => '2025-12-14', 'nomor_tiket' => '001281', 'nopol' => 'B 9710 PYT', 'transporter' => 'PERI', 'customer' => 'AMI GROUP', 'barang' => 'KLAS S', 'gross' => 46.87, 'tara' => 13.55, 'netto' => 33.32, 'status_jual' => true],
            ['nomor_urut' => 203, 'tanggal' => '2025-12-14', 'nomor_tiket' => '001282', 'nopol' => 'BM 9182 BO', 'transporter' => 'JEPRI', 'customer' => 'AMI GROUP', 'barang' => 'KLAS S', 'gross' => 41.88, 'tara' => 11.46, 'netto' => 30.42, 'status_jual' => true],
            ['nomor_urut' => 204, 'tanggal' => '2025-12-14', 'nomor_tiket' => '001283', 'nopol' => 'B 9836 SYV', 'transporter' => 'ARDI', 'customer' => 'AMI GROUP', 'barang' => 'KLAS S', 'gross' => 39.15, 'tara' => 12.76, 'netto' => 26.39, 'status_jual' => true],
            
            // 15-12-2025
            ['nomor_urut' => 205, 'tanggal' => '2025-12-15', 'nomor_tiket' => '001284', 'nopol' => 'BM 8681 LQ', 'transporter' => 'DIAN', 'customer' => 'RIDWAN', 'barang' => 'SPLITE 1-2', 'gross' => 9.26, 'tara' => 4.39, 'netto' => 4.87, 'status_jual' => true],
            ['nomor_urut' => 206, 'tanggal' => '2025-12-15', 'nomor_tiket' => '001285', 'nopol' => 'BM 9148 NO', 'transporter' => 'ANTO', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-2', 'gross' => 42.52, 'tara' => 12.19, 'netto' => 30.33, 'status_jual' => true],
            ['nomor_urut' => 207, 'tanggal' => '2025-12-15', 'nomor_tiket' => '001286', 'nopol' => 'BM 8569 BO', 'transporter' => 'MANULANG', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 2-3', 'gross' => 41.94, 'tara' => 11.88, 'netto' => 30.06, 'status_jual' => true],
            ['nomor_urut' => 208, 'tanggal' => '2025-12-15', 'nomor_tiket' => '001287', 'nopol' => 'BM 8567 BO', 'transporter' => 'ROMA', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 2-3', 'gross' => 42.04, 'tara' => 12.23, 'netto' => 29.81, 'status_jual' => true],
            ['nomor_urut' => 209, 'tanggal' => '2025-12-15', 'nomor_tiket' => '001288', 'nopol' => 'BM 8945 JO', 'transporter' => 'SIMAMORA', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 2-3', 'gross' => 42.98, 'tara' => 13.33, 'netto' => 29.65, 'status_jual' => true],
            ['nomor_urut' => 210, 'tanggal' => '2025-12-15', 'nomor_tiket' => '001289', 'nopol' => 'BM 8568 BO', 'transporter' => 'GULTOM', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 2-3', 'gross' => 41.84, 'tara' => 11.84, 'netto' => 30.00, 'status_jual' => true],
            ['nomor_urut' => 211, 'tanggal' => '2025-12-15', 'nomor_tiket' => '001290', 'nopol' => 'BM 8296 BO', 'transporter' => 'RIJAL', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 2-3', 'gross' => 42.00, 'tara' => 11.83, 'netto' => 30.17, 'status_jual' => true],
            ['nomor_urut' => 212, 'tanggal' => '2025-12-15', 'nomor_tiket' => '001291', 'nopol' => 'BM 8959 JO', 'transporter' => 'ANDRI', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-2', 'gross' => 46.22, 'tara' => 13.67, 'netto' => 32.55, 'status_jual' => true],
            ['nomor_urut' => 213, 'tanggal' => '2025-12-15', 'nomor_tiket' => '001292', 'nopol' => 'BM 9148 NO', 'transporter' => 'ANTO', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-2', 'gross' => 42.94, 'tara' => 12.20, 'netto' => 30.74, 'status_jual' => true],
            ['nomor_urut' => 214, 'tanggal' => '2025-12-15', 'nomor_tiket' => '001293', 'nopol' => 'BM 8567 BO', 'transporter' => 'ROMA', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 2-3', 'gross' => 42.68, 'tara' => 12.27, 'netto' => 30.41, 'status_jual' => true],
            ['nomor_urut' => 215, 'tanggal' => '2025-12-15', 'nomor_tiket' => '001294', 'nopol' => 'BM 8959 JO', 'transporter' => 'ANDRI', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-2', 'gross' => 45.36, 'tara' => 13.67, 'netto' => 31.69, 'status_jual' => true],
            ['nomor_urut' => 216, 'tanggal' => '2025-12-15', 'nomor_tiket' => '001295', 'nopol' => 'BM 8296 BO', 'transporter' => 'RIJAL', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 2-3', 'gross' => 41.00, 'tara' => 11.78, 'netto' => 29.22, 'status_jual' => true],
            ['nomor_urut' => 217, 'tanggal' => '2025-12-15', 'nomor_tiket' => '001296', 'nopol' => 'BM 8569 BO', 'transporter' => 'MANULANG', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-2', 'gross' => 41.80, 'tara' => 11.83, 'netto' => 29.97, 'status_jual' => true],
            ['nomor_urut' => 218, 'tanggal' => '2025-12-15', 'nomor_tiket' => '001297', 'nopol' => 'BM 8945 JO', 'transporter' => 'SIMAMORA', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-2', 'gross' => 42.81, 'tara' => 13.37, 'netto' => 29.44, 'status_jual' => true],
            ['nomor_urut' => 219, 'tanggal' => '2025-12-15', 'nomor_tiket' => '001298', 'nopol' => 'BM 8569 BO', 'transporter' => 'GULTOM', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 2-3', 'gross' => 41.49, 'tara' => 11.89, 'netto' => 29.60, 'status_jual' => true],
            ['nomor_urut' => 220, 'tanggal' => '2025-12-15', 'nomor_tiket' => '001299', 'nopol' => 'BM 9148 NO', 'transporter' => 'ANTO', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-2', 'gross' => 39.83, 'tara' => 12.24, 'netto' => 27.59, 'status_jual' => true],
            ['nomor_urut' => 221, 'tanggal' => '2025-12-15', 'nomor_tiket' => '001300', 'nopol' => 'B 9399 PYT', 'transporter' => 'HARI', 'customer' => 'RIDWAN', 'barang' => 'SPLITE 2-3', 'gross' => 38.72, 'tara' => 11.81, 'netto' => 26.91, 'status_jual' => true],
            ['nomor_urut' => 222, 'tanggal' => '2025-12-15', 'nomor_tiket' => '001301', 'nopol' => 'BM 8567 BO', 'transporter' => 'ROMA', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 2-3', 'gross' => 41.81, 'tara' => 12.24, 'netto' => 29.57, 'status_jual' => true],
            ['nomor_urut' => 223, 'tanggal' => '2025-12-15', 'nomor_tiket' => '001302', 'nopol' => 'BM 8566 BO', 'transporter' => 'ANTO', 'customer' => 'BAMBANG', 'barang' => 'SPLITE 1-2', 'gross' => 12.31, 'tara' => 3.94, 'netto' => 8.37, 'status_jual' => true],
            ['nomor_urut' => 224, 'tanggal' => '2025-12-15', 'nomor_tiket' => '001303', 'nopol' => 'BM 8632 BO', 'transporter' => 'ROY', 'customer' => 'BAMBANG', 'barang' => 'SPLITE 1-2', 'gross' => 13.38, 'tara' => 4.23, 'netto' => 9.15, 'status_jual' => true],
            ['nomor_urut' => 225, 'tanggal' => '2025-12-15', 'nomor_tiket' => '001304', 'nopol' => 'BM 8568 BO', 'transporter' => 'GULTOM', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 2-3', 'gross' => 41.28, 'tara' => 11.89, 'netto' => 29.39, 'status_jual' => true],
            ['nomor_urut' => 226, 'tanggal' => '2025-12-15', 'nomor_tiket' => '001305', 'nopol' => 'BM 8390 GA', 'transporter' => 'IIN', 'customer' => 'RIDWAN', 'barang' => 'SPLITE 1-2', 'gross' => 9.81, 'tara' => 4.05, 'netto' => 5.76, 'status_jual' => true],
            ['nomor_urut' => 227, 'tanggal' => '2025-12-15', 'nomor_tiket' => '001306', 'nopol' => 'BM 9182 BO', 'transporter' => 'JEFRI', 'customer' => 'AMI GROUP', 'barang' => 'BASE AYAKAN', 'gross' => 42.73, 'tara' => 11.58, 'netto' => 31.15, 'status_jual' => true],
            ['nomor_urut' => 228, 'tanggal' => '2025-12-15', 'nomor_tiket' => '001307', 'nopol' => 'BM 9893 AO', 'transporter' => 'RAHMAT', 'customer' => 'AMI GROUP', 'barang' => 'BASE AYAKAN', 'gross' => 43.07, 'tara' => 12.03, 'netto' => 31.04, 'status_jual' => true],
            ['nomor_urut' => 229, 'tanggal' => '2025-12-15', 'nomor_tiket' => '001308', 'nopol' => 'B 9836 SYV', 'transporter' => 'ARDI', 'customer' => 'AMI GROUP', 'barang' => 'BASE AYAKAN', 'gross' => 46.04, 'tara' => 12.74, 'netto' => 33.30, 'status_jual' => true],
            
            // 16-12-2025
            ['nomor_urut' => 230, 'tanggal' => '2025-12-16', 'nomor_tiket' => '001309', 'nopol' => 'BM 8569 BO', 'transporter' => 'MANULANG', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-2', 'gross' => 39.83, 'tara' => 11.90, 'netto' => 27.93, 'status_jual' => true],
            ['nomor_urut' => 231, 'tanggal' => '2025-12-16', 'nomor_tiket' => '001310', 'nopol' => 'BM 8956 JO', 'transporter' => 'JUNTAK', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-2', 'gross' => 44.50, 'tara' => 12.87, 'netto' => 31.63, 'status_jual' => true],
            ['nomor_urut' => 232, 'tanggal' => '2025-12-16', 'nomor_tiket' => '001311', 'nopol' => 'BM 9148 NO', 'transporter' => 'ANTO', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-2', 'gross' => 40.74, 'tara' => 12.17, 'netto' => 28.57, 'status_jual' => true],
            ['nomor_urut' => 233, 'tanggal' => '2025-12-16', 'nomor_tiket' => '001312', 'nopol' => 'BM 8945 JO', 'transporter' => 'SIMAMORA', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-2', 'gross' => 44.31, 'tara' => 12.40, 'netto' => 31.91, 'status_jual' => true],
            ['nomor_urut' => 234, 'tanggal' => '2025-12-16', 'nomor_tiket' => '001313', 'nopol' => 'BM 8897 MD', 'transporter' => 'MUSTAR', 'customer' => 'AMI GROUP', 'barang' => 'BASE AYAKAN', 'gross' => 10.64, 'tara' => 4.23, 'netto' => 6.41, 'status_jual' => true],
            ['nomor_urut' => 235, 'tanggal' => '2025-12-16', 'nomor_tiket' => '001314', 'nopol' => 'BM 9514 KB', 'transporter' => 'WAWAN', 'customer' => 'RIDWAN', 'barang' => 'SPLITE 1-2', 'gross' => 8.92, 'tara' => 4.19, 'netto' => 4.73, 'status_jual' => true],
            ['nomor_urut' => 236, 'tanggal' => '2025-12-16', 'nomor_tiket' => '001315', 'nopol' => 'BM 8569 BO', 'transporter' => 'MANULANG', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 2-3', 'gross' => 41.15, 'tara' => 11.82, 'netto' => 29.33, 'status_jual' => true],
            ['nomor_urut' => 237, 'tanggal' => '2025-12-16', 'nomor_tiket' => '001316', 'nopol' => 'BM 9182 BO', 'transporter' => 'JEPRI', 'customer' => 'AMI GROUP', 'barang' => 'BASE AYAKAN', 'gross' => 44.51, 'tara' => 11.00, 'netto' => 33.51, 'status_jual' => true],
            ['nomor_urut' => 238, 'tanggal' => '2025-12-16', 'nomor_tiket' => '001317', 'nopol' => 'BM 9893 AO', 'transporter' => 'RAHMAT', 'customer' => 'AMI GROUP', 'barang' => 'BASE AYAKAN', 'gross' => 47.84, 'tara' => 12.08, 'netto' => 35.76, 'status_jual' => true],
            ['nomor_urut' => 239, 'tanggal' => '2025-12-16', 'nomor_tiket' => '001318', 'nopol' => 'BM 8956 JO', 'transporter' => 'JUNTAK', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 2-3', 'gross' => 44.56, 'tara' => 13.02, 'netto' => 31.54, 'status_jual' => true],
            ['nomor_urut' => 240, 'tanggal' => '2025-12-16', 'nomor_tiket' => '001319', 'nopol' => 'BM 8632 BO', 'transporter' => 'ROY', 'customer' => 'BAMBANG', 'barang' => 'SPLITE 1-2', 'gross' => 12.77, 'tara' => 4.24, 'netto' => 8.53, 'status_jual' => true],
            ['nomor_urut' => 241, 'tanggal' => '2025-12-16', 'nomor_tiket' => '001320', 'nopol' => 'BM 8632 BO', 'transporter' => 'ROY', 'customer' => 'BAMBANG', 'barang' => 'SPLITE 2-3', 'gross' => 15.13, 'tara' => 4.23, 'netto' => 10.90, 'status_jual' => true],
            ['nomor_urut' => 242, 'tanggal' => '2025-12-16', 'nomor_tiket' => '001321', 'nopol' => 'B 8698 TR', 'transporter' => 'MINGAN', 'customer' => 'DAUS', 'barang' => 'SPLITE 1-2', 'gross' => 12.81, 'tara' => 4.50, 'netto' => 8.31, 'status_jual' => true],
            
            // 17-12-2025
            ['nomor_urut' => 243, 'tanggal' => '2025-12-17', 'nomor_tiket' => '001322', 'nopol' => 'BM 8406 GU', 'transporter' => 'ALI', 'customer' => 'RIDWAN', 'barang' => 'SPLITE 1-2', 'gross' => 10.39, 'tara' => 4.32, 'netto' => 6.07, 'status_jual' => true],
            ['nomor_urut' => 244, 'tanggal' => '2025-12-17', 'nomor_tiket' => '001323', 'nopol' => 'BM 8632 BO', 'transporter' => 'ROY', 'customer' => 'BAMBANG', 'barang' => 'SPLITE 2-3', 'gross' => 14.77, 'tara' => 4.22, 'netto' => 10.55, 'status_jual' => true],
            ['nomor_urut' => 245, 'tanggal' => '2025-12-17', 'nomor_tiket' => '001324', 'nopol' => 'BM 9368 GU', 'transporter' => 'ARAHAF', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-2', 'gross' => 42.60, 'tara' => 12.01, 'netto' => 30.59, 'status_jual' => true],
            ['nomor_urut' => 246, 'tanggal' => '2025-12-17', 'nomor_tiket' => '001325', 'nopol' => 'BM 8698 TR', 'transporter' => 'MINGAN', 'customer' => 'DAUS', 'barang' => 'SPLITE 2-3', 'gross' => 13.45, 'tara' => 4.50, 'netto' => 8.95, 'status_jual' => true],
            ['nomor_urut' => 247, 'tanggal' => '2025-12-17', 'nomor_tiket' => '001326', 'nopol' => 'BM 8569 BO', 'transporter' => 'MANULANG', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 2-3', 'gross' => 42.68, 'tara' => 11.86, 'netto' => 30.82, 'status_jual' => true],
            ['nomor_urut' => 248, 'tanggal' => '2025-12-17', 'nomor_tiket' => '001327', 'nopol' => 'BM 9182 BO', 'transporter' => 'JEPRI', 'customer' => 'AMI GROUP', 'barang' => 'BASE AYAKAN', 'gross' => 42.57, 'tara' => 11.47, 'netto' => 31.10, 'status_jual' => true],
            ['nomor_urut' => 249, 'tanggal' => '2025-12-17', 'nomor_tiket' => '001328', 'nopol' => 'BM 9893 AO', 'transporter' => 'RAHMAT', 'customer' => 'AMI GROUP', 'barang' => 'BASE AYAKAN', 'gross' => 49.53, 'tara' => 12.03, 'netto' => 37.50, 'status_jual' => true],
            ['nomor_urut' => 250, 'tanggal' => '2025-12-17', 'nomor_tiket' => '001329', 'nopol' => 'BM 8632 BO', 'transporter' => 'ROY', 'customer' => 'BAMBANG', 'barang' => 'SPLITE 1-2', 'gross' => 12.75, 'tara' => 4.22, 'netto' => 8.53, 'status_jual' => true],
            
            // 18-12-2025
            ['nomor_urut' => 251, 'tanggal' => '2025-12-18', 'nomor_tiket' => '001330', 'nopol' => 'BM 9906 BU', 'transporter' => 'AJI', 'customer' => 'RIDWAN', 'barang' => 'SPLITE 2-3', 'gross' => 5.40, 'tara' => 4.09, 'netto' => 1.31, 'status_jual' => true],
            ['nomor_urut' => 252, 'tanggal' => '2025-12-18', 'nomor_tiket' => '001331', 'nopol' => 'BM 8566 BO', 'transporter' => 'ANTO', 'customer' => 'BAMBANG', 'barang' => 'SPLITE 1-2', 'gross' => 13.38, 'tara' => 3.93, 'netto' => 9.45, 'status_jual' => true],
            ['nomor_urut' => 253, 'tanggal' => '2025-12-18', 'nomor_tiket' => '001332', 'nopol' => 'BM 8945 JO', 'transporter' => 'SIMAMORA', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-2', 'gross' => 43.55, 'tara' => 13.27, 'netto' => 30.28, 'status_jual' => true],
            ['nomor_urut' => 254, 'tanggal' => '2025-12-18', 'nomor_tiket' => '001333', 'nopol' => 'BM 9144 BD', 'transporter' => 'DODI', 'customer' => 'BAMBANG', 'barang' => 'SPLITE 2-3', 'gross' => 13.46, 'tara' => 4.25, 'netto' => 9.21, 'status_jual' => true],
            ['nomor_urut' => 255, 'tanggal' => '2025-12-18', 'nomor_tiket' => '001334', 'nopol' => 'BM 9577 BU', 'transporter' => 'RENGGA', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-2', 'gross' => 41.93, 'tara' => 11.75, 'netto' => 30.18, 'status_jual' => true],
            ['nomor_urut' => 256, 'tanggal' => '2025-12-18', 'nomor_tiket' => '001335', 'nopol' => 'BM 9906 BU', 'transporter' => 'AJI', 'customer' => 'BAMBANG', 'barang' => 'SPLITE 2-3', 'gross' => 14.29, 'tara' => 4.08, 'netto' => 10.21, 'status_jual' => true],
            ['nomor_urut' => 257, 'tanggal' => '2025-12-18', 'nomor_tiket' => '001336', 'nopol' => 'BM 8297 BO', 'transporter' => 'GALUNG', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-2', 'gross' => 40.23, 'tara' => 11.74, 'netto' => 28.49, 'status_jual' => true],
            ['nomor_urut' => 258, 'tanggal' => '2025-12-18', 'nomor_tiket' => '001337', 'nopol' => 'BM 9577 BU', 'transporter' => 'RENGGA', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-2', 'gross' => 40.85, 'tara' => 11.84, 'netto' => 29.01, 'status_jual' => true],
            ['nomor_urut' => 259, 'tanggal' => '2025-12-18', 'nomor_tiket' => '001338', 'nopol' => 'BM 9368 GU', 'transporter' => 'ARAHAF', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-2', 'gross' => 41.66, 'tara' => 12.00, 'netto' => 29.66, 'status_jual' => true],
            ['nomor_urut' => 260, 'tanggal' => '2025-12-18', 'nomor_tiket' => '001339', 'nopol' => 'BM 8578 TU', 'transporter' => 'DIAN', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-1', 'gross' => 43.53, 'tara' => 11.49, 'netto' => 32.04, 'status_jual' => true],
            ['nomor_urut' => 261, 'tanggal' => '2025-12-18', 'nomor_tiket' => '001340', 'nopol' => 'BH 8344 ML', 'transporter' => 'LUKAS', 'customer' => 'RIDWAN', 'barang' => 'SPLITE 1-2', 'gross' => 11.64, 'tara' => 4.74, 'netto' => 6.90, 'status_jual' => true],
            ['nomor_urut' => 262, 'tanggal' => '2025-12-18', 'nomor_tiket' => '001341', 'nopol' => 'BM 8945 JO', 'transporter' => 'SIMAMORA', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-2', 'gross' => 42.54, 'tara' => 13.25, 'netto' => 29.29, 'status_jual' => true],
            ['nomor_urut' => 263, 'tanggal' => '2025-12-18', 'nomor_tiket' => '001342', 'nopol' => 'BM 9906 BU', 'transporter' => 'AJI', 'customer' => 'BAMBANG', 'barang' => 'SPLITE 2-3', 'gross' => 15.11, 'tara' => 4.07, 'netto' => 11.04, 'status_jual' => true],
            ['nomor_urut' => 264, 'tanggal' => '2025-12-18', 'nomor_tiket' => '001343', 'nopol' => 'BG 8979 UI', 'transporter' => 'MARSONO', 'customer' => 'RIDWAN', 'barang' => 'SPLITE 2-3', 'gross' => 12.12, 'tara' => 4.39, 'netto' => 7.73, 'status_jual' => true],
            ['nomor_urut' => 265, 'tanggal' => '2025-12-18', 'nomor_tiket' => '001344', 'nopol' => 'BM 8632 BO', 'transporter' => 'ROY', 'customer' => 'BAMBANG', 'barang' => 'SPLITE 1-2', 'gross' => 14.40, 'tara' => 4.21, 'netto' => 10.19, 'status_jual' => true],
            ['nomor_urut' => 266, 'tanggal' => '2025-12-18', 'nomor_tiket' => '001345', 'nopol' => 'BM 8566 BO', 'transporter' => 'ANTO', 'customer' => 'BAMBANG', 'barang' => 'SPLITE 1-2', 'gross' => 13.90, 'tara' => 3.93, 'netto' => 9.97, 'status_jual' => true],
            ['nomor_urut' => 267, 'tanggal' => '2025-12-18', 'nomor_tiket' => '001346', 'nopol' => 'B 9836 SYV', 'transporter' => 'ARDI', 'customer' => 'AMI GROUP', 'barang' => 'BASE AYAKAN', 'gross' => 45.98, 'tara' => 12.73, 'netto' => 33.25, 'status_jual' => true],
            ['nomor_urut' => 268, 'tanggal' => '2025-12-18', 'nomor_tiket' => '001347', 'nopol' => 'BM 9182 BO', 'transporter' => 'JEPRI', 'customer' => 'AMI GROUP', 'barang' => 'BASE AYAKAN', 'gross' => 42.25, 'tara' => 11.45, 'netto' => 30.80, 'status_jual' => true],
            ['nomor_urut' => 269, 'tanggal' => '2025-12-18', 'nomor_tiket' => '001348', 'nopol' => 'BM 9893 AO', 'transporter' => 'RAHMAT', 'customer' => 'AMI GROUP', 'barang' => 'BASE AYAKAN', 'gross' => 42.65, 'tara' => 11.99, 'netto' => 30.66, 'status_jual' => true],
            ['nomor_urut' => 270, 'tanggal' => '2025-12-18', 'nomor_tiket' => '001349', 'nopol' => 'BM 8945 JO', 'transporter' => 'SIMAMORA', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-1', 'gross' => 42.11, 'tara' => 13.22, 'netto' => 28.89, 'status_jual' => true],
            
            // 19-12-2025
            ['nomor_urut' => 271, 'tanggal' => '2025-12-19', 'nomor_tiket' => '001350', 'nopol' => 'BM 9259 EO', 'transporter' => 'PUTRA', 'customer' => 'RIDWAN', 'barang' => 'SPLITE 2-3', 'gross' => 47.57, 'tara' => 13.48, 'netto' => 34.09, 'status_jual' => true],
            ['nomor_urut' => 272, 'tanggal' => '2025-12-19', 'nomor_tiket' => '001351', 'nopol' => 'BM 8569 BO', 'transporter' => 'MANULANG', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-2', 'gross' => 41.26, 'tara' => 11.89, 'netto' => 29.37, 'status_jual' => true],
            ['nomor_urut' => 273, 'tanggal' => '2025-12-19', 'nomor_tiket' => '001352', 'nopol' => 'BM 9148 NO', 'transporter' => 'ANTO', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-2', 'gross' => 40.48, 'tara' => 12.19, 'netto' => 28.29, 'status_jual' => true],
            ['nomor_urut' => 274, 'tanggal' => '2025-12-19', 'nomor_tiket' => '001353', 'nopol' => 'BM 8632 BO', 'transporter' => 'ROY', 'customer' => 'BAMBANG', 'barang' => 'SPLITE 2-3', 'gross' => 14.80, 'tara' => 4.20, 'netto' => 10.60, 'status_jual' => true],
            ['nomor_urut' => 275, 'tanggal' => '2025-12-19', 'nomor_tiket' => '001354', 'nopol' => 'BM 8297 BO', 'transporter' => 'GALUNG', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-2', 'gross' => 41.86, 'tara' => 11.70, 'netto' => 30.16, 'status_jual' => true],
            ['nomor_urut' => 276, 'tanggal' => '2025-12-19', 'nomor_tiket' => '001355', 'nopol' => 'BM 9144 BD', 'transporter' => 'DODI', 'customer' => 'BAMBANG', 'barang' => 'SPLITE 2-3', 'gross' => 14.14, 'tara' => 4.30, 'netto' => 9.84, 'status_jual' => true],
            ['nomor_urut' => 277, 'tanggal' => '2025-12-19', 'nomor_tiket' => '001356', 'nopol' => 'BM 8569 BO', 'transporter' => 'MANULANG', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-2', 'gross' => 41.03, 'tara' => 11.87, 'netto' => 29.16, 'status_jual' => true],
            ['nomor_urut' => 278, 'tanggal' => '2025-12-19', 'nomor_tiket' => '001357', 'nopol' => 'BM 9148 NO', 'transporter' => 'ANTO', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-2', 'gross' => 40.01, 'tara' => 12.17, 'netto' => 27.84, 'status_jual' => true],
            ['nomor_urut' => 279, 'tanggal' => '2025-12-19', 'nomor_tiket' => '001358', 'nopol' => 'BM 8079 GU', 'transporter' => 'ACOK', 'customer' => 'RIDWAN', 'barang' => 'SPLITE 1-2', 'gross' => 13.85, 'tara' => 4.46, 'netto' => 9.39, 'status_jual' => true],
            ['nomor_urut' => 280, 'tanggal' => '2025-12-19', 'nomor_tiket' => '001359', 'nopol' => 'BM 9247 PC', 'transporter' => 'WAWAN', 'customer' => 'RIDWAN', 'barang' => 'BASE AYAKAN', 'gross' => 9.36, 'tara' => 4.35, 'netto' => 5.01, 'status_jual' => true],
            ['nomor_urut' => 281, 'tanggal' => '2025-12-19', 'nomor_tiket' => '001360', 'nopol' => 'BL 8944 KC', 'transporter' => 'RENDI', 'customer' => 'RIDWAN', 'barang' => 'BASE AYAKAN', 'gross' => 12.55, 'tara' => 4.66, 'netto' => 7.89, 'status_jual' => true],
            ['nomor_urut' => 282, 'tanggal' => '2025-12-19', 'nomor_tiket' => '001361', 'nopol' => 'BM 8566 BO', 'transporter' => 'ANTO', 'customer' => 'BAMBANG', 'barang' => 'SPLITE 2-3', 'gross' => 12.77, 'tara' => 3.91, 'netto' => 8.86, 'status_jual' => true],
            ['nomor_urut' => 283, 'tanggal' => '2025-12-19', 'nomor_tiket' => '001362', 'nopol' => 'BM 8957 JO', 'transporter' => 'DANI', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-2', 'gross' => 43.80, 'tara' => 13.46, 'netto' => 30.34, 'status_jual' => true],
            ['nomor_urut' => 284, 'tanggal' => '2025-12-19', 'nomor_tiket' => '001363', 'nopol' => 'BM 8296 BO', 'transporter' => 'RIJAL', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-2', 'gross' => 42.09, 'tara' => 11.76, 'netto' => 30.33, 'status_jual' => true],
            ['nomor_urut' => 285, 'tanggal' => '2025-12-19', 'nomor_tiket' => '001364', 'nopol' => 'BM 8956 JO', 'transporter' => 'JUNTAK', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 2-3', 'gross' => 41.48, 'tara' => 12.93, 'netto' => 28.55, 'status_jual' => true],
            ['nomor_urut' => 286, 'tanggal' => '2025-12-19', 'nomor_tiket' => '001365', 'nopol' => 'BM 8454 ZU', 'transporter' => 'ROY', 'customer' => 'RIDWAN', 'barang' => 'SPLITE 1-2', 'gross' => 44.02, 'tara' => 11.43, 'netto' => 32.59, 'status_jual' => true],
            ['nomor_urut' => 287, 'tanggal' => '2025-12-19', 'nomor_tiket' => '001366', 'nopol' => 'BM 8296 BO', 'transporter' => 'RIJAL', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-2', 'gross' => 42.72, 'tara' => 11.80, 'netto' => 30.92, 'status_jual' => true],
            ['nomor_urut' => 288, 'tanggal' => '2025-12-19', 'nomor_tiket' => '001367', 'nopol' => 'BM 9247 PC', 'transporter' => 'WAWAN', 'customer' => 'RIDWAN', 'barang' => 'BASE AYAKAN', 'gross' => 9.45, 'tara' => 4.43, 'netto' => 5.02, 'status_jual' => true],
            ['nomor_urut' => 289, 'tanggal' => '2025-12-19', 'nomor_tiket' => '001368', 'nopol' => 'BM 9144 BD', 'transporter' => 'DODI', 'customer' => 'BAMBANG', 'barang' => 'SPLITE 1-2', 'gross' => 14.12, 'tara' => 4.23, 'netto' => 9.89, 'status_jual' => true],
            ['nomor_urut' => 290, 'tanggal' => '2025-12-19', 'nomor_tiket' => '001369', 'nopol' => 'B 9836 SYV', 'transporter' => 'ARDI', 'customer' => 'AMI GROUP', 'barang' => 'BASE AYAKAN', 'gross' => 46.84, 'tara' => 12.78, 'netto' => 34.06, 'status_jual' => true],
            ['nomor_urut' => 291, 'tanggal' => '2025-12-19', 'nomor_tiket' => '001370', 'nopol' => 'BM 9893 AO', 'transporter' => 'RAHMAT', 'customer' => 'AMI GROUP', 'barang' => 'BASE AYAKAN', 'gross' => 44.36, 'tara' => 11.98, 'netto' => 32.38, 'status_jual' => true],
            ['nomor_urut' => 292, 'tanggal' => '2025-12-19', 'nomor_tiket' => '001371', 'nopol' => 'BM 9893 AO', 'transporter' => 'JEPRI', 'customer' => 'AMI GROUP', 'barang' => 'BASE AYAKAN', 'gross' => 44.15, 'tara' => 11.98, 'netto' => 32.17, 'status_jual' => true],
            
            // 20-12-2025
            ['nomor_urut' => 293, 'tanggal' => '2025-12-20', 'nomor_tiket' => '001372', 'nopol' => 'BM 8957 JO', 'transporter' => 'DANI', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-2', 'gross' => 47.09, 'tara' => 13.57, 'netto' => 33.52, 'status_jual' => true],
            ['nomor_urut' => 294, 'tanggal' => '2025-12-20', 'nomor_tiket' => '001373', 'nopol' => 'BM 9906 BU', 'transporter' => 'AJI', 'customer' => 'BAMBANG', 'barang' => 'SPLITE 1-2', 'gross' => 14.89, 'tara' => 4.11, 'netto' => 10.78, 'status_jual' => true],
            ['nomor_urut' => 295, 'tanggal' => '2025-12-20', 'nomor_tiket' => '001374', 'nopol' => 'BI 8629 JK', 'transporter' => 'SLAMET', 'customer' => 'RIDWAN', 'barang' => 'SPLITE 1-2', 'gross' => 11.50, 'tara' => 4.43, 'netto' => 7.07, 'status_jual' => true],
            ['nomor_urut' => 296, 'tanggal' => '2025-12-20', 'nomor_tiket' => '001375', 'nopol' => 'BM 8454 ZU', 'transporter' => 'ROY', 'customer' => 'RIDWAN', 'barang' => 'SPLITE 2-3', 'gross' => 43.26, 'tara' => 11.43, 'netto' => 31.83, 'status_jual' => true],
            ['nomor_urut' => 297, 'tanggal' => '2025-12-20', 'nomor_tiket' => '001376', 'nopol' => 'BM 8566 BO', 'transporter' => 'ANTO', 'customer' => 'BAMBANG', 'barang' => 'SPLITE 1-2', 'gross' => 13.91, 'tara' => 3.93, 'netto' => 9.98, 'status_jual' => true],
            ['nomor_urut' => 298, 'tanggal' => '2025-12-20', 'nomor_tiket' => '001377', 'nopol' => 'BM 8296 BO', 'transporter' => 'RIJAL', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-2', 'gross' => 48.22, 'tara' => 11.82, 'netto' => 36.40, 'status_jual' => true],
            ['nomor_urut' => 299, 'tanggal' => '2025-12-20', 'nomor_tiket' => '001378', 'nopol' => 'BM 8578 TU', 'transporter' => 'IYAN', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-2', 'gross' => 43.97, 'tara' => 11.42, 'netto' => 32.55, 'status_jual' => true],
            ['nomor_urut' => 300, 'tanggal' => '2025-12-20', 'nomor_tiket' => '001379', 'nopol' => 'BM 8013 GC', 'transporter' => 'ASMIRA', 'customer' => 'RIDWAN', 'barang' => 'SPLITE 1-2', 'gross' => 3.80, 'tara' => 1.34, 'netto' => 2.46, 'status_jual' => true],
            ['nomor_urut' => 301, 'tanggal' => '2025-12-20', 'nomor_tiket' => '001380', 'nopol' => 'B 9836 SYV', 'transporter' => 'ARDI', 'customer' => 'AMI GROUP', 'barang' => 'BASE AYAKAN', 'gross' => 45.35, 'tara' => 12.73, 'netto' => 32.62, 'status_jual' => true],
            ['nomor_urut' => 302, 'tanggal' => '2025-12-20', 'nomor_tiket' => '001381', 'nopol' => 'BM 9906 BU', 'transporter' => 'AJI', 'customer' => 'BAMBANG', 'barang' => 'SPLITE 1-2', 'gross' => 15.08, 'tara' => 4.09, 'netto' => 10.99, 'status_jual' => true],
            ['nomor_urut' => 303, 'tanggal' => '2025-12-20', 'nomor_tiket' => '001382', 'nopol' => 'BM 9893 AO', 'transporter' => 'RAHMAT', 'customer' => 'AMI GROUP', 'barang' => 'BASE AYAKAN', 'gross' => 47.85, 'tara' => 11.98, 'netto' => 35.87, 'status_jual' => true],
            ['nomor_urut' => 304, 'tanggal' => '2025-12-20', 'nomor_tiket' => '001383', 'nopol' => 'BM 8957 JO', 'transporter' => 'DANI', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-2', 'gross' => 46.54, 'tara' => 13.55, 'netto' => 32.99, 'status_jual' => true],
            ['nomor_urut' => 305, 'tanggal' => '2025-12-20', 'nomor_tiket' => '001384', 'nopol' => 'BM 8569 BO', 'transporter' => 'MANULANG', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-2', 'gross' => 42.74, 'tara' => 11.77, 'netto' => 30.97, 'status_jual' => true],
            ['nomor_urut' => 306, 'tanggal' => '2025-12-20', 'nomor_tiket' => '001385', 'nopol' => 'BM 8955 JO', 'transporter' => 'SINAGA', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-2', 'gross' => 43.72, 'tara' => 12.81, 'netto' => 30.91, 'status_jual' => true],
            ['nomor_urut' => 307, 'tanggal' => '2025-12-20', 'nomor_tiket' => '001386', 'nopol' => 'BM 8566 BO', 'transporter' => 'ANTO', 'customer' => 'BAMBANG', 'barang' => 'SPLITE 1-2', 'gross' => 14.20, 'tara' => 3.91, 'netto' => 10.29, 'status_jual' => true],
            ['nomor_urut' => 308, 'tanggal' => '2025-12-20', 'nomor_tiket' => '001387', 'nopol' => 'BM 8569 BO', 'transporter' => 'MANULANG', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 2-3', 'gross' => 39.35, 'tara' => 11.81, 'netto' => 27.54, 'status_jual' => true],
            ['nomor_urut' => 309, 'tanggal' => '2025-12-20', 'nomor_tiket' => '001388', 'nopol' => 'BM 8955 JO', 'transporter' => 'SINAGA', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 2-3', 'gross' => 43.67, 'tara' => 12.90, 'netto' => 30.77, 'status_jual' => true],
            
            // 21-12-2025
            ['nomor_urut' => 310, 'tanggal' => '2025-12-21', 'nomor_tiket' => '001389', 'nopol' => 'BM 8632 BO', 'transporter' => 'ROY', 'customer' => 'BAMBANG', 'barang' => 'SPLITE 2-3', 'gross' => 13.97, 'tara' => 4.22, 'netto' => 9.75, 'status_jual' => true],
            ['nomor_urut' => 311, 'tanggal' => '2025-12-21', 'nomor_tiket' => '001390', 'nopol' => 'BM 8566 BO', 'transporter' => 'ANTO', 'customer' => 'BAMBANG', 'barang' => 'SPLITE 2-3', 'gross' => 14.11, 'tara' => 3.92, 'netto' => 10.19, 'status_jual' => true],
            ['nomor_urut' => 312, 'tanggal' => '2025-12-21', 'nomor_tiket' => '001391', 'nopol' => 'BM 9322 BU', 'transporter' => 'SAMAN', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 2-3', 'gross' => 44.57, 'tara' => 12.04, 'netto' => 32.53, 'status_jual' => true],
            ['nomor_urut' => 313, 'tanggal' => '2025-12-21', 'nomor_tiket' => '001392', 'nopol' => 'BI 8629 JK', 'transporter' => 'SLAMET', 'customer' => 'RIDWAN', 'barang' => 'SPLITE 1-2', 'gross' => 11.45, 'tara' => 4.43, 'netto' => 7.02, 'status_jual' => true],
            ['nomor_urut' => 314, 'tanggal' => '2025-12-21', 'nomor_tiket' => '001393', 'nopol' => 'BM 8957 JO', 'transporter' => 'DANI', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-2', 'gross' => 43.71, 'tara' => 13.55, 'netto' => 30.16, 'status_jual' => true],
            ['nomor_urut' => 315, 'tanggal' => '2025-12-21', 'nomor_tiket' => '001394', 'nopol' => 'BM 9587 BG', 'transporter' => 'UJEL', 'customer' => 'RIDWAN', 'barang' => 'SPLITE 1-2', 'gross' => 3.56, 'tara' => 1.47, 'netto' => 2.09, 'status_jual' => true],
            ['nomor_urut' => 316, 'tanggal' => '2025-12-21', 'nomor_tiket' => '001395', 'nopol' => 'BM 9247 PC', 'transporter' => 'WAWAN', 'customer' => 'RIDWAN', 'barang' => 'BASE AYAKAN', 'gross' => 9.40, 'tara' => 4.37, 'netto' => 5.03, 'status_jual' => true],
            ['nomor_urut' => 317, 'tanggal' => '2025-12-21', 'nomor_tiket' => '001396', 'nopol' => 'BM 9322 BU', 'transporter' => 'SAMAN', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-2', 'gross' => 42.77, 'tara' => 12.02, 'netto' => 30.75, 'status_jual' => true],
            ['nomor_urut' => 318, 'tanggal' => '2025-12-21', 'nomor_tiket' => '001397', 'nopol' => 'BM 8957 JO', 'transporter' => 'DANI', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-2', 'gross' => 45.32, 'tara' => 13.51, 'netto' => 31.81, 'status_jual' => true],
            ['nomor_urut' => 319, 'tanggal' => '2025-12-21', 'nomor_tiket' => '001398', 'nopol' => 'BM 9466 BU', 'transporter' => 'DATUK', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 2-3', 'gross' => 43.81, 'tara' => 12.44, 'netto' => 31.37, 'status_jual' => true],
            ['nomor_urut' => 320, 'tanggal' => '2025-12-21', 'nomor_tiket' => '001399', 'nopol' => 'BM 8899 BU', 'transporter' => 'ALFRI', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-2', 'gross' => 44.15, 'tara' => 13.51, 'netto' => 30.64, 'status_jual' => true],
            ['nomor_urut' => 321, 'tanggal' => '2025-12-21', 'nomor_tiket' => '001400', 'nopol' => 'BM 9893 AO', 'transporter' => 'RAHMAT', 'customer' => 'AMI GROUP', 'barang' => 'BASE AYAKAN', 'gross' => 42.44, 'tara' => 11.86, 'netto' => 30.58, 'status_jual' => true],
            ['nomor_urut' => 322, 'tanggal' => '2025-12-21', 'nomor_tiket' => '001401', 'nopol' => 'B 9836 SYV', 'transporter' => 'ARDI', 'customer' => 'AMI GROUP', 'barang' => 'BASE AYAKAN', 'gross' => 46.00, 'tara' => 12.82, 'netto' => 33.18, 'status_jual' => true],
            ['nomor_urut' => 323, 'tanggal' => '2025-12-21', 'nomor_tiket' => '001402', 'nopol' => 'BM 9182 BO', 'transporter' => 'JEFRI', 'customer' => 'AMI GROUP', 'barang' => 'BASE AYAKAN', 'gross' => 43.94, 'tara' => 11.43, 'netto' => 32.51, 'status_jual' => true],
            ['nomor_urut' => 324, 'tanggal' => '2025-12-21', 'nomor_tiket' => '001403', 'nopol' => 'BM 8958 JO', 'transporter' => 'HERMAN', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 2-3', 'gross' => 41.71, 'tara' => 12.74, 'netto' => 28.97, 'status_jual' => true],
            ['nomor_urut' => 325, 'tanggal' => '2025-12-21', 'nomor_tiket' => '001404', 'nopol' => 'BI 8629 JK', 'transporter' => 'SLAMET', 'customer' => 'RIDWAN', 'barang' => 'SPLITE 1-2', 'gross' => 11.29, 'tara' => 4.25, 'netto' => 7.04, 'status_jual' => true],
            ['nomor_urut' => 326, 'tanggal' => '2025-12-21', 'nomor_tiket' => '001405', 'nopol' => 'BM 8984 GU', 'transporter' => 'WAWAN', 'customer' => 'RIDWAN', 'barang' => 'SPLITE 2-3', 'gross' => 8.52, 'tara' => 4.25, 'netto' => 4.27, 'status_jual' => true],
            ['nomor_urut' => 327, 'tanggal' => '2025-12-21', 'nomor_tiket' => '001406', 'nopol' => 'BM 8855 BU', 'transporter' => 'YUDI', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-2', 'gross' => 46.42, 'tara' => 13.04, 'netto' => 33.38, 'status_jual' => true],
            ['nomor_urut' => 328, 'tanggal' => '2025-12-21', 'nomor_tiket' => '001407', 'nopol' => 'BM 9182 BO', 'transporter' => 'WAWAN', 'customer' => 'RIDWAN', 'barang' => 'BASE AYAKAN', 'gross' => 8.99, 'tara' => 4.50, 'netto' => 4.49, 'status_jual' => true],
            ['nomor_urut' => 329, 'tanggal' => '2025-12-21', 'nomor_tiket' => '001408', 'nopol' => 'BM 8279 BP', 'transporter' => 'PURA', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-2', 'gross' => 42.76, 'tara' => 12.37, 'netto' => 30.39, 'status_jual' => true],
            ['nomor_urut' => 330, 'tanggal' => '2025-12-21', 'nomor_tiket' => '001409', 'nopol' => 'BM 8276 BU', 'transporter' => 'AFDUL', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 2-3', 'gross' => 43.19, 'tara' => 12.40, 'netto' => 30.79, 'status_jual' => true],
            
            // 22-12-2025
            ['nomor_urut' => 331, 'tanggal' => '2025-12-22', 'nomor_tiket' => '001410', 'nopol' => 'BH 8344 ML', 'transporter' => 'LUKAS', 'customer' => 'RIDWAN', 'barang' => 'SPLITE 1-2', 'gross' => 8.90, 'tara' => 4.72, 'netto' => 4.18, 'status_jual' => true],
            ['nomor_urut' => 332, 'tanggal' => '2025-12-22', 'nomor_tiket' => '001411', 'nopol' => 'BM 8569 BO', 'transporter' => 'MANULANG', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-2', 'gross' => 45.15, 'tara' => 11.79, 'netto' => 33.36, 'status_jual' => true],
            ['nomor_urut' => 333, 'tanggal' => '2025-12-22', 'nomor_tiket' => '001412', 'nopol' => 'BM 8955 JO', 'transporter' => 'SINAGA', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-2', 'gross' => 47.51, 'tara' => 12.87, 'netto' => 34.64, 'status_jual' => true],
            ['nomor_urut' => 334, 'tanggal' => '2025-12-22', 'nomor_tiket' => '001413', 'nopol' => 'BM 8569 BO', 'transporter' => 'MANULANG', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-2', 'gross' => 43.08, 'tara' => 11.81, 'netto' => 31.27, 'status_jual' => true],
            ['nomor_urut' => 335, 'tanggal' => '2025-12-22', 'nomor_tiket' => '001414', 'nopol' => 'BM 8955 JO', 'transporter' => 'SINAGA', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-2', 'gross' => 46.15, 'tara' => 12.83, 'netto' => 33.32, 'status_jual' => true],
            ['nomor_urut' => 336, 'tanggal' => '2025-12-22', 'nomor_tiket' => '001415', 'nopol' => 'BM 8956 JO', 'transporter' => 'JUNTAK', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-2', 'gross' => 42.76, 'tara' => 12.99, 'netto' => 29.77, 'status_jual' => true],
            ['nomor_urut' => 337, 'tanggal' => '2025-12-22', 'nomor_tiket' => '001416', 'nopol' => 'BH 8344 ML', 'transporter' => 'LUKAS', 'customer' => 'RIDWAN', 'barang' => 'SPLITE 1-2', 'gross' => 11.36, 'tara' => 4.68, 'netto' => 6.68, 'status_jual' => true],
            ['nomor_urut' => 338, 'tanggal' => '2025-12-22', 'nomor_tiket' => '001417', 'nopol' => 'B 9347 UVX', 'transporter' => 'AAN', 'customer' => 'AMI GROUP', 'barang' => 'BASE AYAKAN', 'gross' => 50.85, 'tara' => 14.01, 'netto' => 36.84, 'status_jual' => true],
            ['nomor_urut' => 339, 'tanggal' => '2025-12-22', 'nomor_tiket' => '001418', 'nopol' => 'BA 8454 AO', 'transporter' => 'GALUNG', 'customer' => 'AMI GROUP', 'barang' => 'BASE AYAKAN', 'gross' => 48.70, 'tara' => 12.05, 'netto' => 36.65, 'status_jual' => true],
            ['nomor_urut' => 340, 'tanggal' => '2025-12-22', 'nomor_tiket' => '001419', 'nopol' => 'BH 8352 YV', 'transporter' => 'ADI', 'customer' => 'AMI GROUP', 'barang' => 'BASE AYAKAN', 'gross' => 48.47, 'tara' => 13.40, 'netto' => 35.07, 'status_jual' => true],
            ['nomor_urut' => 341, 'tanggal' => '2025-12-22', 'nomor_tiket' => '001420', 'nopol' => 'BM 8956 JO', 'transporter' => 'JUNTAK', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-2', 'gross' => 43.30, 'tara' => 12.96, 'netto' => 30.34, 'status_jual' => true],
            ['nomor_urut' => 342, 'tanggal' => '2025-12-22', 'nomor_tiket' => '001421', 'nopol' => 'BM 8632 BO', 'transporter' => 'ROY', 'customer' => 'BAMBANG', 'barang' => 'SPLITE 2-3', 'gross' => 14.32, 'tara' => 4.21, 'netto' => 10.11, 'status_jual' => true],
            ['nomor_urut' => 343, 'tanggal' => '2025-12-22', 'nomor_tiket' => '001422', 'nopol' => 'BM 9368 BU', 'transporter' => 'ARAHAF', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-2', 'gross' => 41.10, 'tara' => 11.90, 'netto' => 29.20, 'status_jual' => true],
            
            // 23-12-2025
            ['nomor_urut' => 344, 'tanggal' => '2025-12-23', 'nomor_tiket' => '001423', 'nopol' => 'BM 8581 BP', 'transporter' => 'EEN', 'customer' => 'RIDWAN', 'barang' => 'SPLITE 1-2', 'gross' => 12.65, 'tara' => 4.28, 'netto' => 8.37, 'status_jual' => true],
            ['nomor_urut' => 345, 'tanggal' => '2025-12-23', 'nomor_tiket' => '001424', 'nopol' => 'BM 8277 BP', 'transporter' => 'CANDRA', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-2', 'gross' => 41.61, 'tara' => 12.11, 'netto' => 29.50, 'status_jual' => true],
            ['nomor_urut' => 346, 'tanggal' => '2025-12-23', 'nomor_tiket' => '001425', 'nopol' => 'BM 9588 BU', 'transporter' => 'EDI', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-2', 'gross' => 45.47, 'tara' => 12.26, 'netto' => 33.21, 'status_jual' => true],
            ['nomor_urut' => 347, 'tanggal' => '2025-12-23', 'nomor_tiket' => '001426', 'nopol' => 'BM 8866 BU', 'transporter' => 'ARI', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 2-3', 'gross' => 42.59, 'tara' => 12.57, 'netto' => 30.02, 'status_jual' => true],
            ['nomor_urut' => 348, 'tanggal' => '2025-12-23', 'nomor_tiket' => '001427', 'nopol' => 'BM 8124 BU', 'transporter' => 'SUPRI', 'customer' => 'RIDWAN', 'barang' => 'SPLITE 2-3', 'gross' => 8.57, 'tara' => 3.98, 'netto' => 4.59, 'status_jual' => true],
            ['nomor_urut' => 349, 'tanggal' => '2025-12-23', 'nomor_tiket' => '001428', 'nopol' => 'BM 8899 BU', 'transporter' => 'ALFI', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 2-3', 'gross' => 41.53, 'tara' => 12.18, 'netto' => 29.35, 'status_jual' => true],
            ['nomor_urut' => 350, 'tanggal' => '2025-12-23', 'nomor_tiket' => '001429', 'nopol' => 'BM 8277 BP', 'transporter' => 'CANDRA', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 2-3', 'gross' => 41.68, 'tara' => 12.04, 'netto' => 29.64, 'status_jual' => true],
            ['nomor_urut' => 351, 'tanggal' => '2025-12-23', 'nomor_tiket' => '001430', 'nopol' => 'BM 8566 BO', 'transporter' => 'ANTO', 'customer' => 'BAMBANG', 'barang' => 'SPLITE 1-2/2-3', 'gross' => 12.94, 'tara' => 3.92, 'netto' => 9.02, 'status_jual' => true],
            ['nomor_urut' => 352, 'tanggal' => '2025-12-23', 'nomor_tiket' => '001431', 'nopol' => 'BM 9588 BU', 'transporter' => 'EDI', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-2', 'gross' => 41.47, 'tara' => 12.15, 'netto' => 29.32, 'status_jual' => true],
            ['nomor_urut' => 353, 'tanggal' => '2025-12-23', 'nomor_tiket' => '001432', 'nopol' => 'BM 8866 BU', 'transporter' => 'ARI', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-2', 'gross' => 39.59, 'tara' => 12.57, 'netto' => 27.02, 'status_jual' => true],
            ['nomor_urut' => 354, 'tanggal' => '2025-12-23', 'nomor_tiket' => '001433', 'nopol' => 'BM 8899 BU', 'transporter' => 'ALFI', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 2-3', 'gross' => 43.87, 'tara' => 12.16, 'netto' => 31.71, 'status_jual' => true],
            
            // 24-12-2025
            ['nomor_urut' => 355, 'tanggal' => '2025-12-24', 'nomor_tiket' => '001434', 'nopol' => 'BM 9037 BO', 'transporter' => 'BAGONG', 'customer' => 'RIDWAN', 'barang' => 'SPLITE 1-2', 'gross' => 12.23, 'tara' => 4.56, 'netto' => 7.67, 'status_jual' => true],
            ['nomor_urut' => 356, 'tanggal' => '2025-12-24', 'nomor_tiket' => '001435', 'nopol' => 'BM 8566 BO', 'transporter' => 'ANTO', 'customer' => 'BAMBANG', 'barang' => 'SPLITE 1-2', 'gross' => 11.87, 'tara' => 3.92, 'netto' => 7.95, 'status_jual' => true],
            ['nomor_urut' => 357, 'tanggal' => '2025-12-24', 'nomor_tiket' => '001436', 'nopol' => 'BM 9906 BU', 'transporter' => 'AJI', 'customer' => 'BAMBANG', 'barang' => 'SPLITE 1-2', 'gross' => 12.64, 'tara' => 4.05, 'netto' => 8.59, 'status_jual' => true],
            ['nomor_urut' => 358, 'tanggal' => '2025-12-24', 'nomor_tiket' => '001437', 'nopol' => 'BM 9672 CT', 'transporter' => 'INDRA', 'customer' => 'RIDWAN', 'barang' => 'SPLITE 1-2', 'gross' => 8.50, 'tara' => 4.52, 'netto' => 3.98, 'status_jual' => true],
            ['nomor_urut' => 359, 'tanggal' => '2025-12-24', 'nomor_tiket' => '001438', 'nopol' => 'BM 8629 JK', 'transporter' => 'SLAMET', 'customer' => 'RIDWAN', 'barang' => 'SPLITE 1-2', 'gross' => 11.81, 'tara' => 4.32, 'netto' => 7.49, 'status_jual' => true],
            ['nomor_urut' => 360, 'tanggal' => '2025-12-24', 'nomor_tiket' => '001439', 'nopol' => 'BM 8277 BP', 'transporter' => 'CANDRA', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 2-3', 'gross' => 40.65, 'tara' => 12.11, 'netto' => 28.54, 'status_jual' => true],
            ['nomor_urut' => 361, 'tanggal' => '2025-12-24', 'nomor_tiket' => '001440', 'nopol' => 'BM 8899 BU', 'transporter' => 'ALPI', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 2-3', 'gross' => 39.35, 'tara' => 12.06, 'netto' => 27.29, 'status_jual' => true],
            ['nomor_urut' => 362, 'tanggal' => '2025-12-24', 'nomor_tiket' => '001441', 'nopol' => 'BM 8866 BU', 'transporter' => 'ARI', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-2', 'gross' => 40.37, 'tara' => 12.58, 'netto' => 27.79, 'status_jual' => true],
            ['nomor_urut' => 363, 'tanggal' => '2025-12-24', 'nomor_tiket' => '001442', 'nopol' => 'BM 8899 BU', 'transporter' => 'ALPI', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-2', 'gross' => 42.72, 'tara' => 12.03, 'netto' => 30.69, 'status_jual' => true],
            ['nomor_urut' => 364, 'tanggal' => '2025-12-24', 'nomor_tiket' => '001443', 'nopol' => 'BL 8629 JK', 'transporter' => 'SLAMET', 'customer' => 'RIDWAN', 'barang' => 'SPLITE 1-2', 'gross' => 10.82, 'tara' => 4.25, 'netto' => 6.57, 'status_jual' => true],
            ['nomor_urut' => 365, 'tanggal' => '2025-12-24', 'nomor_tiket' => '001444', 'nopol' => 'BM 8277 BP', 'transporter' => 'CANDRA', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 2-3', 'gross' => 42.03, 'tara' => 12.09, 'netto' => 29.94, 'status_jual' => true],
            ['nomor_urut' => 366, 'tanggal' => '2025-12-24', 'nomor_tiket' => '001445', 'nopol' => 'BM 8866 BU', 'transporter' => 'ARI', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 2-3', 'gross' => 42.23, 'tara' => 12.55, 'netto' => 29.68, 'status_jual' => true],
            
            // 26-12-2025
            ['nomor_urut' => 367, 'tanggal' => '2025-12-26', 'nomor_tiket' => '001446', 'nopol' => 'BL 8629 JK', 'transporter' => 'SLAMET', 'customer' => 'RIDWAN', 'barang' => 'SPLITE 1-2', 'gross' => 11.21, 'tara' => 4.20, 'netto' => 7.01, 'status_jual' => true],
            ['nomor_urut' => 368, 'tanggal' => '2025-12-26', 'nomor_tiket' => '001447', 'nopol' => 'BM 8066 BQ', 'transporter' => 'JOSUA', 'customer' => 'RIDWAN', 'barang' => 'BASE AYAKAN', 'gross' => 9.44, 'tara' => 4.40, 'netto' => 5.04, 'status_jual' => true],
            ['nomor_urut' => 369, 'tanggal' => '2025-12-26', 'nomor_tiket' => '001448', 'nopol' => 'BM 8325 BO', 'transporter' => 'AGAIN', 'customer' => 'RIDWAN', 'barang' => 'BASE AYAKAN', 'gross' => 9.12, 'tara' => 4.20, 'netto' => 4.92, 'status_jual' => true],
            ['nomor_urut' => 370, 'tanggal' => '2025-12-26', 'nomor_tiket' => '001449', 'nopol' => 'BM 9050 GU', 'transporter' => 'RENO', 'customer' => 'RIDWAN', 'barang' => 'SPLITE 1-2', 'gross' => 12.68, 'tara' => 4.17, 'netto' => 8.51, 'status_jual' => true],
            ['nomor_urut' => 371, 'tanggal' => '2025-12-26', 'nomor_tiket' => '001450', 'nopol' => 'BH 8607 CU', 'transporter' => 'RAHMAT', 'customer' => 'BAMBANG', 'barang' => 'SPLITE 1-2', 'gross' => 14.28, 'tara' => 4.65, 'netto' => 9.63, 'status_jual' => true],
            ['nomor_urut' => 372, 'tanggal' => '2025-12-26', 'nomor_tiket' => '001451', 'nopol' => 'BM 8418 BO', 'transporter' => 'DEFRI', 'customer' => 'BAMBANG', 'barang' => 'SPLITE 1-2', 'gross' => 14.37, 'tara' => 4.18, 'netto' => 10.19, 'status_jual' => true],
            ['nomor_urut' => 373, 'tanggal' => '2025-12-26', 'nomor_tiket' => '001452', 'nopol' => 'BM 9906 BU', 'transporter' => 'AJI', 'customer' => 'BAMBANG', 'barang' => 'SPLITE 2-3', 'gross' => 13.74, 'tara' => 4.13, 'netto' => 9.61, 'status_jual' => true],
            ['nomor_urut' => 374, 'tanggal' => '2025-12-26', 'nomor_tiket' => '001453', 'nopol' => 'BM 9743 XX', 'transporter' => 'MAUL', 'customer' => 'BAMBANG', 'barang' => 'SPLITE 2-3', 'gross' => 14.97, 'tara' => 4.49, 'netto' => 10.48, 'status_jual' => true],
            ['nomor_urut' => 375, 'tanggal' => '2025-12-26', 'nomor_tiket' => '001454', 'nopol' => 'BM 8581 BP', 'transporter' => 'EEN', 'customer' => 'RIDWAN', 'barang' => 'SPLITE 2-3', 'gross' => 8.02, 'tara' => 4.26, 'netto' => 3.76, 'status_jual' => true],
            ['nomor_urut' => 376, 'tanggal' => '2025-12-26', 'nomor_tiket' => '001455', 'nopol' => 'BL 8629 JK', 'transporter' => 'SLAMET', 'customer' => 'RIDWAN', 'barang' => 'SPLITE 1-2', 'gross' => 11.28, 'tara' => 4.22, 'netto' => 7.06, 'status_jual' => true],
            ['nomor_urut' => 377, 'tanggal' => '2025-12-26', 'nomor_tiket' => '001456', 'nopol' => 'BM 8899 BU', 'transporter' => 'ALFI', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 2-3', 'gross' => 41.68, 'tara' => 12.16, 'netto' => 29.52, 'status_jual' => true],
            ['nomor_urut' => 378, 'tanggal' => '2025-12-26', 'nomor_tiket' => '001457', 'nopol' => 'BM 9329 CG', 'transporter' => 'KATIO', 'customer' => 'RIDWAN', 'barang' => 'SPLITE 1-2', 'gross' => 6.30, 'tara' => 4.12, 'netto' => 2.18, 'status_jual' => true],
            ['nomor_urut' => 379, 'tanggal' => '2025-12-26', 'nomor_tiket' => '001458', 'nopol' => 'BM 9466 BU', 'transporter' => 'DATUK', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 2-3', 'gross' => 41.85, 'tara' => 12.42, 'netto' => 29.43, 'status_jual' => true],
            ['nomor_urut' => 380, 'tanggal' => '2025-12-26', 'nomor_tiket' => '001459', 'nopol' => 'BM 9499 BU', 'transporter' => 'EDI.S', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 1-2', 'gross' => 43.32, 'tara' => 12.57, 'netto' => 30.75, 'status_jual' => true],
            ['nomor_urut' => 381, 'tanggal' => '2025-12-26', 'nomor_tiket' => '001460', 'nopol' => 'BL 8629 JK', 'transporter' => 'SLAMET', 'customer' => 'RIDWAN', 'barang' => 'SPLITE 1-2', 'gross' => 11.21, 'tara' => 4.20, 'netto' => 7.01, 'status_jual' => true],
            ['nomor_urut' => 382, 'tanggal' => '2025-12-26', 'nomor_tiket' => '001461', 'nopol' => 'BM 9587 BG', 'transporter' => 'UJEL', 'customer' => 'RIDWAN', 'barang' => 'SPLITE 1-2', 'gross' => 2.97, 'tara' => 1.46, 'netto' => 1.51, 'status_jual' => true],
            ['nomor_urut' => 383, 'tanggal' => '2025-12-26', 'nomor_tiket' => '001462', 'nopol' => 'BM 9499 BU', 'transporter' => 'EDI.S', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 2-3', 'gross' => 43.05, 'tara' => 12.45, 'netto' => 30.60, 'status_jual' => true],
            
            // 27-12-2025
            ['nomor_urut' => 384, 'tanggal' => '2025-12-27', 'nomor_tiket' => '001463', 'nopol' => 'BL 8629 BK', 'transporter' => 'SLAMET', 'customer' => 'RIDWAN', 'barang' => 'SPLITE 1-2', 'gross' => 11.37, 'tara' => 4.27, 'netto' => 7.10, 'status_jual' => true],
            ['nomor_urut' => 385, 'tanggal' => '2025-12-27', 'nomor_tiket' => '001464', 'nopol' => 'BM 8316 GU', 'transporter' => 'ZAINUDIN', 'customer' => 'RIDWAN', 'barang' => 'BASE AYAKAN', 'gross' => 9.34, 'tara' => 4.33, 'netto' => 5.01, 'status_jual' => true],
            ['nomor_urut' => 386, 'tanggal' => '2025-12-27', 'nomor_tiket' => '001465', 'nopol' => 'BM 9743 XX', 'transporter' => 'MAUL', 'customer' => 'BAMBANG', 'barang' => 'SPLITE 2-3', 'gross' => 14.65, 'tara' => 4.53, 'netto' => 10.12, 'status_jual' => true],
            ['nomor_urut' => 387, 'tanggal' => '2025-12-27', 'nomor_tiket' => '001466', 'nopol' => 'BL 8629 BK', 'transporter' => 'SLAMET', 'customer' => 'RIDWAN', 'barang' => 'SPLITE 1-2', 'gross' => 11.31, 'tara' => 4.25, 'netto' => 7.06, 'status_jual' => true],
            ['nomor_urut' => 388, 'tanggal' => '2025-12-27', 'nomor_tiket' => '001467', 'nopol' => 'BM 9906 BU', 'transporter' => 'AJI', 'customer' => 'BAMBANG', 'barang' => 'SPLITE 2-3', 'gross' => 13.43, 'tara' => 4.14, 'netto' => 9.29, 'status_jual' => true],
            ['nomor_urut' => 389, 'tanggal' => '2025-12-27', 'nomor_tiket' => '001468', 'nopol' => 'BM 9499 BU', 'transporter' => 'EDI.S', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 2-3', 'gross' => 42.39, 'tara' => 12.59, 'netto' => 29.80, 'status_jual' => true],
            ['nomor_urut' => 390, 'tanggal' => '2025-12-27', 'nomor_tiket' => '001469', 'nopol' => 'BM 8418 BO', 'transporter' => 'DEFRI', 'customer' => 'BAMBANG', 'barang' => 'SPLITE 1-2', 'gross' => 13.45, 'tara' => 4.16, 'netto' => 9.29, 'status_jual' => true],
            ['nomor_urut' => 391, 'tanggal' => '2025-12-27', 'nomor_tiket' => '001470', 'nopol' => 'BM 8681 LQ', 'transporter' => 'DIAN', 'customer' => 'BAMBANG', 'barang' => 'SPLITE 1-2', 'gross' => 13.65, 'tara' => 4.34, 'netto' => 9.31, 'status_jual' => true],
            ['nomor_urut' => 392, 'tanggal' => '2025-12-27', 'nomor_tiket' => '001471', 'nopol' => 'BM 8577 BO', 'transporter' => 'HENDRA', 'customer' => 'RIDWAN', 'barang' => 'SPLITE 1-2', 'gross' => 13.88, 'tara' => 4.25, 'netto' => 9.63, 'status_jual' => true],
            
            // 28-12-2025
            ['nomor_urut' => 393, 'tanggal' => '2025-12-28', 'nomor_tiket' => '001472', 'nopol' => 'BL 8629 JK', 'transporter' => 'SLAMET', 'customer' => 'RIDWAN', 'barang' => 'SPLITE 1-2', 'gross' => 11.34, 'tara' => 4.25, 'netto' => 7.09, 'status_jual' => true],
            ['nomor_urut' => 394, 'tanggal' => '2025-12-28', 'nomor_tiket' => '001473', 'nopol' => 'BM 8197 BU', 'transporter' => 'RIAN', 'customer' => 'BAMBANG', 'barang' => 'SPLITE 1-2', 'gross' => 14.71, 'tara' => 4.36, 'netto' => 10.35, 'status_jual' => true],
            ['nomor_urut' => 395, 'tanggal' => '2025-12-28', 'nomor_tiket' => '001474', 'nopol' => 'BM 8967 NY', 'transporter' => 'HENDRA', 'customer' => 'BAMBANG', 'barang' => 'SPLITE 2-3', 'gross' => 14.82, 'tara' => 4.53, 'netto' => 10.29, 'status_jual' => true],
            ['nomor_urut' => 396, 'tanggal' => '2025-12-28', 'nomor_tiket' => '001475', 'nopol' => 'BM 9672 CT', 'transporter' => 'INDRA', 'customer' => 'BAMBANG', 'barang' => 'SPLITE 2-3', 'gross' => 14.55, 'tara' => 4.58, 'netto' => 9.97, 'status_jual' => true],
            ['nomor_urut' => 397, 'tanggal' => '2025-12-28', 'nomor_tiket' => '001476', 'nopol' => 'BM 9499 BU', 'transporter' => 'EDI S', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 2-3', 'gross' => 42.73, 'tara' => 12.61, 'netto' => 30.12, 'status_jual' => true],
            
            // 29-12-2025
            ['nomor_urut' => 398, 'tanggal' => '2025-12-29', 'nomor_tiket' => '001477', 'nopol' => 'BL 8629 JK', 'transporter' => 'SLAMET', 'customer' => 'RIDWAN', 'barang' => 'SPLITE 1-2', 'gross' => 11.38, 'tara' => 4.27, 'netto' => 7.11, 'status_jual' => true],
            ['nomor_urut' => 399, 'tanggal' => '2025-12-29', 'nomor_tiket' => '001478', 'nopol' => 'BM 9499 BU', 'transporter' => 'EDI S', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 2-3', 'gross' => 45.62, 'tara' => 12.65, 'netto' => 32.97, 'status_jual' => true],
            ['nomor_urut' => 400, 'tanggal' => '2025-12-29', 'nomor_tiket' => '001479', 'nopol' => 'BM 9340 BU', 'transporter' => 'SAMOSIR', 'customer' => 'RIDWAN', 'barang' => 'SPLITE 1-2', 'gross' => 10.35, 'tara' => 4.21, 'netto' => 6.14, 'status_jual' => true],
            ['nomor_urut' => 401, 'tanggal' => '2025-12-29', 'nomor_tiket' => '001480', 'nopol' => 'BM 8577 BU', 'transporter' => 'HENDRA', 'customer' => 'RIDWAN', 'barang' => 'SPLITE 1-2', 'gross' => 14.01, 'tara' => 4.38, 'netto' => 9.63, 'status_jual' => true],
            ['nomor_urut' => 402, 'tanggal' => '2025-12-29', 'nomor_tiket' => '001481', 'nopol' => 'BM 9499 BU', 'transporter' => 'EDI S', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 2-3', 'gross' => 44.24, 'tara' => 12.65, 'netto' => 31.59, 'status_jual' => true],
            
            // 30-12-2025
            ['nomor_urut' => 403, 'tanggal' => '2025-12-30', 'nomor_tiket' => '001482', 'nopol' => 'BM 9499 BU', 'transporter' => 'EDI S', 'customer' => 'SYAHRIL', 'barang' => 'SPLITE 2-3', 'gross' => 45.50, 'tara' => 12.60, 'netto' => 32.90, 'status_jual' => true],
            ['nomor_urut' => 404, 'tanggal' => '2025-12-30', 'nomor_tiket' => '001483', 'nopol' => 'BL 8629 JK', 'transporter' => 'SLAMET', 'customer' => 'RIDWAN', 'barang' => 'SPLITE 1-2', 'gross' => 11.32, 'tara' => 4.28, 'netto' => 7.04, 'status_jual' => true],
            ['nomor_urut' => 405, 'tanggal' => '2025-12-30', 'nomor_tiket' => '001484', 'nopol' => 'BK 8311 GD', 'transporter' => 'BUDI', 'customer' => 'RIDWAN', 'barang' => 'SPLITE 1-2', 'gross' => 11.12, 'tara' => 4.06, 'netto' => 7.06, 'status_jual' => true],
            
            // 31-12-2025
            ['nomor_urut' => 406, 'tanggal' => '2025-12-31', 'nomor_tiket' => '001485', 'nopol' => 'BL 8629 JK', 'transporter' => 'SLAMET', 'customer' => 'RIDWAN', 'barang' => 'SPLITE 1-2', 'gross' => 11.37, 'tara' => 4.26, 'netto' => 7.11, 'status_jual' => true],
            ['nomor_urut' => 407, 'tanggal' => '2025-12-31', 'nomor_tiket' => '001486', 'nopol' => 'BM 9248 BO', 'transporter' => 'HENDRA', 'customer' => 'RIDWAN', 'barang' => 'SPLITE 1-2', 'gross' => 8.91, 'tara' => 4.23, 'netto' => 4.68, 'status_jual' => true],
        ];
    }
    
    /**
     * Build mapping untuk semua master data
     */
    protected function buildMaps()
    {
        // Mapping transporter
        $transporters = Transporter::all();
        foreach ($transporters as $t) {
            $this->transporterMap[$t->nama] = $t->id;
        }
        
        // Mapping customer
        $customers = Customer::all();
        foreach ($customers as $c) {
            $this->customerMap[$c->name] = $c->id;
        }
        
        // Mapping barang
        $barangs = Barang::all();
        foreach ($barangs as $b) {
            $this->barangMap[$b->nama] = $b->id;
        }
    }
    
    /**
     * Get transporter ID from name
     */
    protected function getTransporterId($name)
    {
        if (isset($this->transporterMap[$name])) {
            return $this->transporterMap[$name];
        }
        
        // Jika tidak ditemukan, buat baru
        $transporter = Transporter::create(['nama' => $name]);
        $this->transporterMap[$name] = $transporter->id;
        return $transporter->id;
    }
    
    /**
     * Get customer ID from name
     */
    protected function getCustomerId($name)
    {
        if (isset($this->customerMap[$name])) {
            return $this->customerMap[$name];
        }
        
        // Jika tidak ditemukan, buat baru
        $customer = Customer::create(['name' => $name]);
        $this->customerMap[$name] = $customer->id;
        return $customer->id;
    }
    
    /**
     * Get barang ID from name
     */
    protected function getBarangId($name)
    {
        if (isset($this->barangMap[$name])) {
            return $this->barangMap[$name];
        }
        
        // Jika tidak ditemukan, buat baru
        $barang = Barang::create(['nama' => $name]);
        $this->barangMap[$name] = $barang->id;
        return $barang->id;
    }
}