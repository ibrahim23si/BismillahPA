<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessTimbanganImport;
use App\Models\ImportHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class TimbanganImportController extends Controller
{
    public function index()
    {
        $imports = ImportHistory::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.timbangan.import.index', compact('imports'));
    }

    public function create()
    {
        return view('admin.timbangan.import.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|file|mimes:xlsx,xls,csv|max:10240', // max 10MB
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('imports/timbangan', $filename);

            // Simpan history import
            $importHistory = ImportHistory::create([
                'filename' => $filename,
                'original_filename' => $file->getClientOriginalName(),
                'file_path' => $path,
                'status' => 'pending',
                'created_by' => auth()->id()
            ]);

            // Dispatch job ke queue
            ProcessTimbanganImport::dispatch($path, auth()->id(), $importHistory->id);

            return redirect()->route('admin.timbangan.import.index')
                ->with('success', 'File import berhasil diupload dan sedang diproses. Anda akan mendapat notifikasi setelah selesai.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal mengupload file: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $import = ImportHistory::with('user')->findOrFail($id);
        return view('admin.timbangan.import.show', compact('import'));
    }

    public function downloadTemplate()
    {
        $headers = [
            'date',
            'ticket_number',
            'plate_number',
            'transporter_id',
            'customer_id',
            'product_id',
            'gross_weight',
            'tare_weight',
            'net_weight',
            'status_sale',
            'status_other',
            'price_per_unit',
            'total_price',
            'notes'
        ];

        $filename = 'template_import_timbangan.xlsx';
        
        return response()->stream(function() use ($headers) {
            $file = fopen('php://output', 'w');
            
            // Header
            fputcsv($file, $headers, ';');
            
            // Contoh data
            fputcsv($file, [
                '2025-12-01',
                '001080',
                'BM 8959 JO',
                '13',
                '7',
                '9',
                '44.88',
                '13.69',
                '31.19',
                '1',
                '',
                '',
                '',
                ''
            ], ';');
            
            fclose($file);
        }, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }
}