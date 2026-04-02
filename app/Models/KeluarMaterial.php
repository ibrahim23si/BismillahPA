<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KeluarMaterial extends Model
{
    use HasFactory;

    protected $table = 'keluar_material';

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
        'total_per_hari',
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
        'total_harga' => 'decimal:2'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($material) {
            $material->netto = $material->gross - $material->tara;
            
            if ($material->harga_satuan && $material->netto) {
                $material->total_harga = $material->harga_satuan * $material->netto;
            }
            
            if (!$material->created_by && auth()->check()) {
                $material->created_by = auth()->id();
            }
        });

        static::updating(function ($material) {
            $material->netto = $material->gross - $material->tara;
            
            if ($material->harga_satuan && $material->netto) {
                $material->total_harga = $material->harga_satuan * $material->netto;
            }
        });
    }
}