<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportHistory extends Model
{
    use HasFactory;

    protected $table = 'import_histories';

    protected $fillable = [
        'filename',
        'original_filename',
        'file_path',
        'status', // pending, processing, completed, failed
        'imported_count',
        'failed_count',
        'error_message',
        'started_at',
        'completed_at',
        'created_by'
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'completed_at' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}