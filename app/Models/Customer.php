<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customers';

    protected $fillable = [
        'name',
        'keterangan'
    ];

    // Relasi dengan timbangan
    public function timbangan()
    {
        return $this->hasMany(Timbangan::class, 'nama_customer', 'name');
    }
}