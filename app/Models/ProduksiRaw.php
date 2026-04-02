<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class ProduksiRaw extends Model
{
    use HasFactory;

    protected $table = 'produksi_raw';

    protected $fillable = [
        'tanggal_produksi',
        'total_output',
        'jam_mulai',
        'jam_selesai',
        'total_jam_operasional',
        'produktivitas_per_jam',
        'keterangan',
        'created_by'
    ];

    protected $casts = [
        'tanggal_produksi' => 'date',
        'total_output' => 'decimal:2',
        'total_jam_operasional' => 'decimal:2',
        'produktivitas_per_jam' => 'decimal:2'
    ];

    // Relasi
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Accessor untuk format jam
    public function getJamMulaiFormattedAttribute()
    {
        return Carbon::parse($this->jam_mulai)->format('H:i');
    }

    public function getJamSelesaiFormattedAttribute()
    {
        return Carbon::parse($this->jam_selesai)->format('H:i');
    }

    // Mutator untuk auto calculate sebelum save
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($produksi) {
            $jamMulai = Carbon::parse($produksi->jam_mulai);
            $jamSelesai = Carbon::parse($produksi->jam_selesai);
            
            // Hitung total jam operasional (dalam jam, dengan desimal)
            $totalJam = $jamMulai->diffInMinutes($jamSelesai) / 60;
            $produksi->total_jam_operasional = round($totalJam, 2);
            
            // Hitung produktivitas per jam (ton/jam)
            if ($totalJam > 0) {
                $produksi->produktivitas_per_jam = round($produksi->total_output / $totalJam, 2);
            } else {
                $produksi->produktivitas_per_jam = 0;
            }
            
            // Set created_by jika belum diisi
            if (!$produksi->created_by && auth()->check()) {
                $produksi->created_by = auth()->id();
            }
        });

        static::updating(function ($produksi) {
            $jamMulai = Carbon::parse($produksi->jam_mulai);
            $jamSelesai = Carbon::parse($produksi->jam_selesai);
            
            $totalJam = $jamMulai->diffInMinutes($jamSelesai) / 60;
            $produksi->total_jam_operasional = round($totalJam, 2);
            
            if ($totalJam > 0) {
                $produksi->produktivitas_per_jam = round($produksi->total_output / $totalJam, 2);
            } else {
                $produksi->produktivitas_per_jam = 0;
            }
        });
    }
}