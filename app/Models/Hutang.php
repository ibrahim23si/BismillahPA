<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Hutang extends Model
{
    use HasFactory;

    protected $table = 'hutang';

    protected $fillable = [
        'tanggal',
        'nama_kreditur',
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
        'tanggal_giro',
        'bank_giro',
        'sisa',
        'created_by'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'tanggal_invoice' => 'date',
        'tanggal_jatuh_tempo' => 'date',
        'tanggal_bayar' => 'date',
        'tanggal_giro' => 'date',
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

        static::creating(function ($hutang) {
            // Hitung sisa awal
            $hutang->sisa = $hutang->nominal;
            
            // Hitung over_due jika ada tanggal jatuh tempo
            if ($hutang->tanggal_jatuh_tempo) {
                $jatuhTempo = \Carbon\Carbon::parse($hutang->tanggal_jatuh_tempo);
                $sekarang = \Carbon\Carbon::parse($hutang->tanggal ?: now());
                
                if ($sekarang > $jatuhTempo) {
                    $hutang->over_due = $sekarang->diffInDays($jatuhTempo);
                }
            }
            
            // Set created_by
            if (!$hutang->created_by && auth()->check()) {
                $hutang->created_by = auth()->id();
            }
        });

        static::updating(function ($hutang) {
            // Hitung sisa setelah pembayaran
            $totalBayar = ($hutang->cash_bayar ?? 0) + ($hutang->transfer_bayar ?? 0);
            $hutang->sisa = $hutang->nominal - $totalBayar;
            
            // Update status jika sudah lunas
            if ($hutang->sisa <= 0) {
                $hutang->status = 'paid';
            }
            
            // Update over_due
            if ($hutang->tanggal_jatuh_tempo) {
                $jatuhTempo = \Carbon\Carbon::parse($hutang->tanggal_jatuh_tempo);
                $sekarang = \Carbon\Carbon::parse($hutang->tanggal_bayar ?: now());
                
                if ($sekarang > $jatuhTempo) {
                    $hutang->over_due = $sekarang->diffInDays($jatuhTempo);
                } else {
                    $hutang->over_due = 0;
                }
            }
        });
    }
}