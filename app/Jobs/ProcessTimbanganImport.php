<?php

namespace App\Jobs;

use App\Imports\TimbanganImport;
use App\Models\ImportHistory;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ProcessTimbanganImport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $filePath;
    protected $userId;
    protected $importHistoryId;

    public $timeout = 1200;
    public $tries = 1;

    public function __construct($filePath, $userId, $importHistoryId)
    {
        $this->filePath = $filePath;
        $this->userId = $userId;
        $this->importHistoryId = $importHistoryId;
    }

    public function handle(): void
    {
        $importHistory = ImportHistory::find($this->importHistoryId);
        
        try {
            $importHistory->update([
                'status' => 'processing',
                'started_at' => now()
            ]);

            $import = new TimbanganImport($this->userId);
            
            Excel::import($import, Storage::path($this->filePath));

            // Ambil errors dari import
            $errors = $import->getErrors();
            $errorMessage = !empty($errors) ? implode("\n", array_slice($errors, 0, 50)) : null;

            $importHistory->update([
                'status' => 'completed',
                'completed_at' => now(),
                'imported_count' => $import->getImportedCount(),
                'failed_count' => $import->getFailedCount(),
                'error_message' => $errorMessage
            ]);

            // Hapus file setelah selesai
            if (Storage::exists($this->filePath)) {
                Storage::delete($this->filePath);
            }

        } catch (\Exception $e) {
            Log::error('Import failed: ' . $e->getMessage());
            
            $importHistory->update([
                'status' => 'failed',
                'completed_at' => now(),
                'error_message' => $e->getMessage()
            ]);

            if (Storage::exists($this->filePath)) {
                Storage::delete($this->filePath);
            }

            throw $e;
        }
    }

    public function failed(\Throwable $exception): void
    {
        $importHistory = ImportHistory::find($this->importHistoryId);
        
        if ($importHistory) {
            $importHistory->update([
                'status' => 'failed',
                'completed_at' => now(),
                'error_message' => $exception->getMessage()
            ]);
        }

        if (Storage::exists($this->filePath)) {
            Storage::delete($this->filePath);
        }
    }
}