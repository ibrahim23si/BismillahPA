<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AjuKas extends Model
{
    use HasFactory;

    protected $table = 'aju_kas';

    protected $fillable = [
        'nomor_pengajuan',
        'tanggal',
        'keterangan',
        'nominal',
        'status',
        'created_by',
        'approved_by',
        'approved_at',
        'catatan_reject',
        'tanggal_refund',
        'nominal_refund'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'tanggal_refund' => 'date',
        'approved_at' => 'datetime',
        'nominal' => 'decimal:2',
        'nominal_refund' => 'decimal:2'
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

    public function lapKas()
    {
        return $this->hasOne(LapKas::class, 'aju_kas_id');
    }

    // Helper
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

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($aju) {
            $aju->nomor_pengajuan = self::generateNomorPengajuan();
            
            if (!$aju->status) {
                $aju->status = 'pending';
            }
            
            if (!$aju->created_by && auth()->check()) {
                $aju->created_by = auth()->id();
            }
        });
    }

    private static function generateNomorPengajuan()
    {
        $tahun = date('Y');
        $bulan = date('m');
        $lastPengajuan = self::whereYear('created_at', $tahun)
                            ->whereMonth('created_at', $bulan)
                            ->orderBy('id', 'desc')
                            ->first();

        if ($lastPengajuan) {
            $lastNumber = intval(substr($lastPengajuan->nomor_pengajuan, -4));
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '0001';
        }

        return "AK/{$tahun}{$bulan}/{$newNumber}";
    }
}