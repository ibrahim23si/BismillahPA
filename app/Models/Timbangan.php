<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Timbangan extends Model
{
    use HasFactory;

    protected $table = 'timbangan';

    protected $fillable = [
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
        'status_jual',
        'keterangan_lain',
        'harga_satuan',
        'total_harga',
        'keterangan',
        'created_by'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'gross' => 'decimal:2',
        'tara' => 'decimal:2',
        'netto' => 'decimal:2',
        'harga_satuan' => 'decimal:2',
        'total_harga' => 'decimal:2',
        'status_jual' => 'boolean'
    ];

    // Relasi
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Boot method
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($timbangan) {
            // Auto calculate netto
            $timbangan->netto = $timbangan->gross - $timbangan->tara;
            
            // Auto calculate total harga jika ada harga satuan
            if ($timbangan->harga_satuan && $timbangan->netto) {
                $timbangan->total_harga = $timbangan->harga_satuan * $timbangan->netto;
            }
            
            // Set created_by
            if (!$timbangan->created_by && auth()->check()) {
                $timbangan->created_by = auth()->id();
            }
        });

        static::updating(function ($timbangan) {
            $timbangan->netto = $timbangan->gross - $timbangan->tara;
            
            if ($timbangan->harga_satuan && $timbangan->netto) {
                $timbangan->total_harga = $timbangan->harga_satuan * $timbangan->netto;
            }
        });
    }
}