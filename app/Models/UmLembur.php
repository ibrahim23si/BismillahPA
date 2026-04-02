<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UmLembur extends Model
{
    use HasFactory;

    protected $table = 'um_lemburs';

    protected $fillable = [
        'periode',
        'nama',
        'jabatan',
        'hari_1', 'hari_2', 'hari_3', 'hari_4', 'hari_5', 'hari_6', 'hari_7',
        'hari_8', 'hari_9', 'hari_10', 'hari_11', 'hari_12', 'hari_13', 'hari_14',
        'hari_15', 'hari_16', 'hari_17', 'hari_18', 'hari_19', 'hari_20',
        'hari_21', 'hari_22', 'hari_23', 'hari_24', 'hari_25', 'hari_26',
        'hari_27', 'hari_28', 'hari_29', 'hari_30', 'hari_31',
        'total_jam',
        'upah_per_jam',
        'total_upah',
        'keterangan',
        'created_by'
    ];

    protected $casts = [
        'periode' => 'date',
        'hari_1' => 'decimal:2',
        'hari_2' => 'decimal:2',
        'hari_3' => 'decimal:2',
        'hari_4' => 'decimal:2',
        'hari_5' => 'decimal:2',
        'hari_6' => 'decimal:2',
        'hari_7' => 'decimal:2',
        'hari_8' => 'decimal:2',
        'hari_9' => 'decimal:2',
        'hari_10' => 'decimal:2',
        'hari_11' => 'decimal:2',
        'hari_12' => 'decimal:2',
        'hari_13' => 'decimal:2',
        'hari_14' => 'decimal:2',
        'hari_15' => 'decimal:2',
        'hari_16' => 'decimal:2',
        'hari_17' => 'decimal:2',
        'hari_18' => 'decimal:2',
        'hari_19' => 'decimal:2',
        'hari_20' => 'decimal:2',
        'hari_21' => 'decimal:2',
        'hari_22' => 'decimal:2',
        'hari_23' => 'decimal:2',
        'hari_24' => 'decimal:2',
        'hari_25' => 'decimal:2',
        'hari_26' => 'decimal:2',
        'hari_27' => 'decimal:2',
        'hari_28' => 'decimal:2',
        'hari_29' => 'decimal:2',
        'hari_30' => 'decimal:2',
        'hari_31' => 'decimal:2',
        'total_jam' => 'decimal:2',
        'upah_per_jam' => 'decimal:2',
        'total_upah' => 'decimal:2',
    ];

    // Relasi ke user pembuat
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Accessor untuk mendapatkan total jam dalam format jam
    public function getTotalJamFormattedAttribute()
    {
        return number_format($this->total_jam, 2) . ' jam';
    }

    // Accessor untuk total upah dalam rupiah
    public function getTotalUpahFormattedAttribute()
    {
        return 'Rp ' . number_format($this->total_upah, 0, ',', '.');
    }

    // Accessor untuk periode dalam format Bulan Tahun
    public function getPeriodeFormattedAttribute()
    {
        return $this->periode->format('F Y');
    }

    // Method untuk menghitung total jam dari semua hari
    public function hitungTotalJam()
    {
        $total = 0;
        for ($i = 1; $i <= 31; $i++) {
            $hari = 'hari_' . $i;
            $total += (float) $this->$hari;
        }
        return $total;
    }

    // Method untuk menghitung total upah
    public function hitungTotalUpah()
    {
        return $this->total_jam * $this->upah_per_jam;
    }

    // Boot method untuk auto calculate sebelum save
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($umLembur) {
            // Hitung total jam
            $totalJam = 0;
            for ($i = 1; $i <= 31; $i++) {
                $hari = 'hari_' . $i;
                $totalJam += (float) $umLembur->$hari;
            }
            $umLembur->total_jam = $totalJam;
            
            // Hitung total upah
            $umLembur->total_upah = $totalJam * $umLembur->upah_per_jam;
        });

        static::creating(function ($umLembur) {
            if (!$umLembur->created_by && auth()->check()) {
                $umLembur->created_by = auth()->id();
            }
        });
    }
}