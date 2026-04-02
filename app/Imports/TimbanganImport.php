<?php

namespace App\Imports;

use App\Models\Timbangan;
use App\Models\Customer;
use App\Models\Barang;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TimbanganImport implements ToCollection, WithHeadingRow, WithMultipleSheets
{
    protected $userId;
    protected $importedCount = 0;
    protected $failedCount = 0;
    protected $errors = [];
    protected $lastValidDate = null;
    protected $currentTicketNumber = null;
    protected $currentPlateNumber = null;
    protected $currentTransporterId = null;
    protected $currentCustomerId = null;
    protected $currentProductId = null;

    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    /**
     * Tentukan sheet mana yang akan diproses
     */
    public function sheets(): array
    {
        return [
            // Hanya proses sheet dengan nama 'weighings' atau index 0
            0 => $this,
            'weighings' => $this,
        ];
    }

    public function collection(Collection $rows)
    {
        DB::beginTransaction();
        
        try {
            $rowNumber = 1; // Untuk log, mulai dari 1 (setelah header)
            
            foreach ($rows as $index => $row) {
                $rowNumber = $index + 2; // +2 karena index 0 adalah header, baris pertama data adalah index 1 = row 2
                
                try {
                    // Log raw data untuk debugging
                    Log::info("Processing row {$rowNumber}", $row->toArray());

                    // Skip jika semua kolom kosong
                    if ($row->filter()->isEmpty()) {
                        Log::info("Row {$rowNumber} is empty, skipping");
                        continue;
                    }

                    // ========== PARSING TANGGAL (PERBAIKAN) ==========
                    $tanggal = null;
                    $dateValue = $row['date'] ?? null;
                    
                    if (!empty($dateValue)) {
                        // Jika berupa angka (Excel serial)
                        if (is_numeric($dateValue)) {
                            // Excel serial date: 1 Jan 1900 = 1
                            // Untuk Windows Excel, 1 Jan 1900 = 1, 2 Jan 1900 = 2
                            // Konversi ke Unix timestamp (1 Jan 1970)
                            // Excel serial 25569 = 1 Jan 1970
                            $unix = ($dateValue - 25569) * 86400;
                            $tanggal = date('Y-m-d', $unix);
                            $this->lastValidDate = $tanggal;
                            Log::info("Row {$rowNumber}: Converted Excel serial {$dateValue} to {$tanggal}");
                        } 
                        // Jika berupa string dengan format "2025-12-01 00:00:00"
                        else {
                            try {
                                $dateStr = trim($dateValue);
                                // Ambil hanya bagian tanggal jika ada waktu
                                if (strpos($dateStr, ' ') !== false) {
                                    $dateStr = substr($dateStr, 0, strpos($dateStr, ' '));
                                }
                                $tanggal = Carbon::parse($dateStr)->format('Y-m-d');
                                $this->lastValidDate = $tanggal;
                                Log::info("Row {$rowNumber}: Parsed date string {$dateValue} to {$tanggal}");
                            } catch (\Exception $e) {
                                // Jika gagal parse, gunakan last valid date
                                if ($this->lastValidDate) {
                                    $tanggal = $this->lastValidDate;
                                    Log::warning("Row {$rowNumber}: Failed to parse date '{$dateValue}', using last valid date: {$tanggal}");
                                } else {
                                    throw new \Exception("Could not parse date: {$dateValue}");
                                }
                            }
                        }
                    } else {
                        // Jika date kosong, gunakan last valid date
                        if ($this->lastValidDate) {
                            $tanggal = $this->lastValidDate;
                            Log::info("Row {$rowNumber}: Date empty, using last valid date: {$tanggal}");
                        } else {
                            $this->failedCount++;
                            $this->errors[] = "Row {$rowNumber}: Date is empty and no previous valid date";
                            continue;
                        }
                    }

                    // Validasi data wajib
                    if (empty($row['ticket_number'])) {
                        $this->failedCount++;
                        $this->errors[] = "Row {$rowNumber}: ticket_number is empty";
                        continue;
                    }

                    if (empty($row['plate_number'])) {
                        $this->failedCount++;
                        $this->errors[] = "Row {$rowNumber}: plate_number is empty";
                        continue;
                    }

                    // Parse angka (ganti koma dengan titik)
                    $gross = !empty($row['gross_weight']) ? floatval(str_replace(',', '.', $row['gross_weight'])) : 0;
                    $tara = !empty($row['tare_weight']) ? floatval(str_replace(',', '.', $row['tare_weight'])) : 0;
                    
                    // Cari customer name
                    $namaCustomer = null;
                    if (!empty($row['customer_id'])) {
                        $customer = Customer::find(intval($row['customer_id']));
                        if ($customer) {
                            $namaCustomer = $customer->name;
                        } else {
                            Log::warning("Row {$rowNumber}: Customer ID {$row['customer_id']} not found");
                        }
                    }

                    // Cari barang name
                    $namaBarang = null;
                    if (!empty($row['product_id'])) {
                        $barang = Barang::find(intval($row['product_id']));
                        if ($barang) {
                            $namaBarang = $barang->nama;
                        } else {
                            Log::warning("Row {$rowNumber}: Product ID {$row['product_id']} not found");
                        }
                    }

                    // Siapkan data untuk insert
                    $data = [
                        'nomor_urut' => $this->generateNomorUrut($tanggal),
                        'hari' => $tanggal ? Carbon::parse($tanggal)->locale('id')->dayName : null,
                        'tanggal' => $tanggal,
                        'nomor_tiket' => $row['ticket_number'],
                        'nopol' => $row['plate_number'],
                        'transporter' => !empty($row['transporter_id']) ? intval($row['transporter_id']) : null,
                        'nama_customer' => $namaCustomer,
                        'nama_barang' => $namaBarang,
                        'gross' => $gross,
                        'tara' => $tara,
                        'netto' => $gross - $tara,
                        'status_jual' => isset($row['status_sale']) ? ($row['status_sale'] == 1 || $row['status_sale'] === '1') : false,
                        'keterangan_lain' => $row['status_other'] ?? null,
                        'harga_satuan' => !empty($row['price_per_unit']) ? floatval(str_replace(',', '.', $row['price_per_unit'])) : null,
                        'total_harga' => !empty($row['total_price']) ? floatval(str_replace(',', '.', $row['total_price'])) : null,
                        'keterangan' => $row['notes'] ?? null,
                        'created_by' => $this->userId
                    ];

                    // Buat data timbangan
                    Timbangan::create($data);

                    $this->importedCount++;
                    Log::info("Row {$rowNumber}: Successfully imported");
                    
                } catch (\Exception $e) {
                    $this->failedCount++;
                    $errorMsg = "Row {$rowNumber}: " . $e->getMessage();
                    $this->errors[] = $errorMsg;
                    Log::error('Error inserting row ' . $rowNumber . ': ' . $e->getMessage());
                }
            }

            DB::commit();

            Log::info('Import completed', [
                'imported' => $this->importedCount,
                'failed' => $this->failedCount,
                'errors' => $this->errors
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Import transaction failed: ' . $e->getMessage());
            throw $e;
        }
    }

    public function headingRow(): int
    {
        return 1; // Baris pertama adalah header
    }

    protected function generateNomorUrut($tanggal)
    {
        if (!$tanggal) {
            return 1;
        }

        $count = Timbangan::whereDate('tanggal', $tanggal)->count();
        return $count + 1;
    }

    public function getImportedCount()
    {
        return $this->importedCount;
    }

    public function getFailedCount()
    {
        return $this->failedCount;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}