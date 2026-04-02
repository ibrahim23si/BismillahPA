<?php

namespace App\Http\Controllers\ReadOnly;

use App\Http\Controllers\Controller;
use App\Models\TerimaRaw;
use App\Exports\TerimaRawExport;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Maatwebsite\Excel\Facades\Excel;

class TerimaRawViewController extends Controller
{
    /**
     * Display a listing of terima raw (read only).
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = TerimaRaw::with('user')
                ->select('terima_raw.*')
                ->orderBy('tanggal', 'desc')
                ->orderBy('nomor_urut', 'desc');
                
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('tanggal', function($row) {
                    return $row->tanggal->format('d/m/Y');
                })
                ->editColumn('gross', function($row) {
                    return Helper::formatDesimal($row->gross) . ' ton';
                })
                ->editColumn('tara', function($row) {
                    return Helper::formatDesimal($row->tara) . ' ton';
                })
                ->editColumn('netto', function($row) {
                    return Helper::formatDesimal($row->netto) . ' ton';
                })
                ->addColumn('created_by_name', function($row) {
                    return $row->user ? $row->user->name : '-';
                })
                ->addColumn('action', function($row) {
                    return '<a href="'.route('readonly.terima-raw.show', $row->id).'" class="inline-flex items-center px-3 py-1 bg-gray-500 text-white text-sm rounded-md hover:bg-gray-600">Detail</a>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        
        return view('readonly.terima-raw.index');
    }
    
    /**
     * Display the specified terima raw.
     */
    public function show($id)
    {
        $terima = TerimaRaw::with('user')->findOrFail($id);
        return view('readonly.terima-raw.show', compact('terima'));
    }

    public function export(Request $request)
    {
        $startDate = $request->get('start_date', date('Y-m-01'));
        $endDate = $request->get('end_date', date('Y-m-d'));
        $fileName = 'Terima_Raw_' . date('d-m-Y', strtotime($startDate)) . '_sd_' . date('d-m-Y', strtotime($endDate)) . '.xlsx';
        return Excel::download(new TerimaRawExport($startDate, $endDate), $fileName);
    }
}