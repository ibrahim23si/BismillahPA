<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JualMaterial extends Model
{
    use HasFactory;

    protected $table = 'jual_material';

    protected $fillable = [
        'nomor_transaksi',
        'nomor_urut',
        'hari',
        'tanggal',
        'nomor_tiket',
        'nopol',
        'transporter',
        'nama_customer',
        'nama_barang',
        'gross',
        'tara',
        'netto',
        'total_per_hari',
        'harga_satuan',
        'total_harga',
        'jenis_bayar',
        'nomor_bmk',
        'tanggal_bmk',
        'nominal_bmk',
        'tanggal_jatuh_tempo',
        'nominal_tempo',
        'status',
        'created_by',
        'approved_by',
        'approved_at',
        'catatan_reject'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'tanggal_bmk' => 'date',
        'tanggal_jatuh_tempo' => 'date',
        'approved_at' => 'datetime',
        'gross' => 'decimal:2',
        'tara' => 'decimal:2',
        'netto' => 'decimal:2',
        'harga_satuan' => 'decimal:2',
        'total_harga' => 'decimal:2',
        'nominal_bmk' => 'decimal:2',
        'nominal_tempo' => 'decimal:2'
    ];

    // Relasi
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function piutang()
    {
        return $this->hasOne(Piutang::class, 'jual_material_id');
    }

    public function lapKas()
    {
        return $this->hasOne(LapKas::class, 'jual_material_id');
    }

    // Helper untuk cek status
    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isApproved()
    {
        return $this->status === 'approved';
    }

    public function isRejected()
    {
        return $this->status === 'rejected';
    }

    // Scope
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeCash($query)
    {
        return $query->where('jenis_bayar', 'cash');
    }

    public function scopeInvoice($query)
    {
        return $query->where('jenis_bayar', 'invoice');
    }

    // Boot method
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($jual) {
            // Auto generate nomor transaksi
            $jual->nomor_transaksi = self::generateNomorTransaksi();
            
            // Hitung netto
            $jual->netto = $jual->gross - $jual->tara;
            
            // Hitung total harga
            if ($jual->harga_satuan && $jual->netto) {
                $jual->total_harga = $jual->harga_satuan * $jual->netto;
            }
            
            // Set default status
            if (!$jual->status) {
                $jual->status = 'pending';
            }
            
            // Set created_by
            if (!$jual->created_by && auth()->check()) {
                $jual->created_by = auth()->id();
            }
        });

        static::updating(function ($jual) {
            $jual->netto = $jual->gross - $jual->tara;
            
            if ($jual->harga_satuan && $jual->netto) {
                $jual->total_harga = $jual->harga_satuan * $jual->netto;
            }
        });
    }

    // Helper untuk generate nomor transaksi
    private static function generateNomorTransaksi()
    {
        $tahun = date('Y');
        $bulan = date('m');
        $lastTransaksi = self::whereYear('created_at', $tahun)
                            ->whereMonth('created_at', $bulan)
                            ->orderBy('id', 'desc')
                            ->first();

        if ($lastTransaksi) {
            $lastNumber = intval(substr($lastTransaksi->nomor_transaksi, -4));
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '0001';
        }

        return "JM/{$tahun}{$bulan}/{$newNumber}";
    }
}