<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TerimaRaw extends Model
{
    use HasFactory;

    protected $table = 'terima_raw';

    protected $fillable = [
        'nomor_urut',
        'hari',
        'tanggal',
        'nomor_tiket',
        'nopol',
        'transporter',
        'nama_supplier',
        'nama_barang',
        'gross',
        'tara',
        'netto',
        'total_per_hari',
        'created_by'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'gross' => 'decimal:2',
        'tara' => 'decimal:2',
        'netto' => 'decimal:2',
        'total_per_hari' => 'decimal:2'
    ];

    // Relasi
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($terima) {
            $terima->netto = $terima->gross - $terima->tara;
            
            if (!$terima->created_by && auth()->check()) {
                $terima->created_by = auth()->id();
            }
        });

        static::updating(function ($terima) {
            $terima->netto = $terima->gross - $terima->tara;
        });
    }
}