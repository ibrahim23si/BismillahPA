<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Piutang extends Model
{
    use HasFactory;

    protected $table = 'piutang';

    protected $fillable = [
        'tanggal',
        'nama_debitur',
        'jenis_transaksi',
        'tanggal_invoice',
        'nomor_invoice',
        'nominal',
        'tanggal_jatuh_tempo',
        'over_due',
        'status',
        'tanggal_bayar',
        'cash_bayar',
        'transfer_bayar',
        'sisa',
        'jual_material_id',
        'created_by'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'tanggal_invoice' => 'date',
        'tanggal_jatuh_tempo' => 'date',
        'tanggal_bayar' => 'date',
        'nominal' => 'decimal:2',
        'cash_bayar' => 'decimal:2',
        'transfer_bayar' => 'decimal:2',
        'sisa' => 'decimal:2',
        'over_due' => 'integer'
    ];

    // Relasi
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function jualMaterial()
    {
        return $this->belongsTo(JualMaterial::class);
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

    public function isPaid()
    {
        return $this->status === 'paid';
    }

    // Scope
    public function scopeBelumLunas($query)
    {
        return $query->whereIn('status', ['pending', 'approved']);
    }

    public function scopeLunas($query)
    {
        return $query->where('status', 'paid');
    }

    public function scopeJatuhTempo($query)
    {
        return $query->whereDate('tanggal_jatuh_tempo', '<', now())
                     ->whereIn('status', ['pending', 'approved']);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($piutang) {
            // Hitung sisa awal
            $piutang->sisa = $piutang->nominal;
            
            // Hitung over_due jika ada tanggal jatuh tempo
            if ($piutang->tanggal_jatuh_tempo) {
                $jatuhTempo = \Carbon\Carbon::parse($piutang->tanggal_jatuh_tempo);
                $sekarang = \Carbon\Carbon::parse($piutang->tanggal ?: now());
                
                if ($sekarang > $jatuhTempo) {
                    $piutang->over_due = $sekarang->diffInDays($jatuhTempo);
                }
            }
            
            // Set created_by
            if (!$piutang->created_by && auth()->check()) {
                $piutang->created_by = auth()->id();
            }
        });

        static::updating(function ($piutang) {
            // Hitung sisa setelah pembayaran
            $totalBayar = ($piutang->cash_bayar ?? 0) + ($piutang->transfer_bayar ?? 0);
            $piutang->sisa = $piutang->nominal - $totalBayar;
            
            // Update status jika sudah lunas
            if ($piutang->sisa <= 0) {
                $piutang->status = 'paid';
            }
            
            // Update over_due
            if ($piutang->tanggal_jatuh_tempo) {
                $jatuhTempo = \Carbon\Carbon::parse($piutang->tanggal_jatuh_tempo);
                $sekarang = \Carbon\Carbon::parse($piutang->tanggal_bayar ?: now());
                
                if ($sekarang > $jatuhTempo) {
                    $piutang->over_due = $sekarang->diffInDays($jatuhTempo);
                } else {
                    $piutang->over_due = 0;
                }
            }
        });
    }
}