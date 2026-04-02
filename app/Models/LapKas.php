<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LapKas extends Model
{
    use HasFactory;

    protected $table = 'lap_kas';

    protected $fillable = [
        'tanggal',
        'nomor_bukti',
        'keterangan',
        'debet',
        'kredit',
        'saldo',
        'jual_material_id',
        'aju_kas_id',
        'created_by'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'debet' => 'decimal:2',
        'kredit' => 'decimal:2',
        'saldo' => 'decimal:2'
    ];

    // Relasi
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function jualMaterial()
    {
        return $this->belongsTo(JualMaterial::class);
    }

    public function ajuKas()
    {
        return $this->belongsTo(AjuKas::class);
    }

    // Scope untuk laporan
    public function scopeBetween($query, $startDate, $endDate)
    {
        return $query->whereBetween('tanggal', [$startDate, $endDate]);
    }

    // Helper untuk menghitung saldo
    public static function getSaldoTerakhir()
    {
        $lastRecord = self::orderBy('tanggal', 'desc')
                         ->orderBy('id', 'desc')
                         ->first();
        
        return $lastRecord ? $lastRecord->saldo : 0;
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($lapKas) {
            // Auto generate nomor bukti jika kosong
            if (!$lapKas->nomor_bukti) {
                $lapKas->nomor_bukti = self::generateNomorBukti();
            }
            
            // Hitung saldo berjalan
            $saldoTerakhir = self::getSaldoTerakhir();
            $lapKas->saldo = $saldoTerakhir + $lapKas->debet - $lapKas->kredit;
            
            // Set created_by
            if (!$lapKas->created_by && auth()->check()) {
                $lapKas->created_by = auth()->id();
            }
        });

        static::updating(function ($lapKas) {
            // WARNING: Jangan update saldo manual karena akan merusak running balance
            // Untuk keamanan, kita bisa throw exception atau handle dengan hati-hati
            if ($lapKas->isDirty(['debet', 'kredit', 'tanggal'])) {
                throw new \Exception('Tidak bisa mengubah nominal transaksi kas. Gunakan sistem reversal.');
            }
        });
    }

    private static function generateNomorBukti()
    {
        $tahun = date('Y');
        $bulan = date('m');
        $lastBukti = self::whereYear('created_at', $tahun)
                        ->whereMonth('created_at', $bulan)
                        ->orderBy('id', 'desc')
                        ->first();

        if ($lastBukti && preg_match('/LK\/(\d{4})(\d{2})\/(\d{4})/', $lastBukti->nomor_bukti, $matches)) {
            $lastNumber = intval($matches[3]);
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '0001';
        }

        return "LK/{$tahun}{$bulan}/{$newNumber}";
    }
}