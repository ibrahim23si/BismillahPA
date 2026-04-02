<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Target extends Model
{
    use HasFactory;

    protected $table = 'targets';

    protected $fillable = [
        'tipe',
        'periode',
        'tonase_target',
        'tanggal_mulai',
        'tanggal_selesai',
        'keterangan',
        'created_by'
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'tonase_target' => 'decimal:2'
    ];

    // Relasi
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Scope helper
    public function scopeProduksi($query)
    {
        return $query->where('tipe', 'produksi');
    }

    public function scopePenjualan($query)
    {
        return $query->where('tipe', 'penjualan');
    }

    public function scopeHarian($query)
    {
        return $query->where('periode', 'harian');
    }

    public function scopeMingguan($query)
    {
        return $query->where('periode', 'mingguan');
    }

    public function scopeBulanan($query)
    {
        return $query->where('periode', 'bulanan');
    }

    // Cek apakah target aktif untuk tanggal tertentu
    public function isActiveForDate($date)
    {
        return $date >= $this->tanggal_mulai && $date <= $this->tanggal_selesai;
    }
}