<?php

namespace App\Http\Controllers\ReadOnly;

use App\Http\Controllers\Controller;
use App\Models\Timbangan;
use App\Exports\TimbanganExport;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Maatwebsite\Excel\Facades\Excel;

class TimbanganViewController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Timbangan::with('user')
                ->select('timbangan.*')
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
                ->editColumn('status_jual', function($row) {
                    return $row->status_jual ? 'Jual' : 'Lainnya';
                })
                ->editColumn('total_harga', function($row) {
                    return $row->total_harga ? Helper::formatRupiah($row->total_harga) : '-';
                })
                ->addColumn('created_by_name', function($row) {
                    return $row->user ? $row->user->name : '-';
                })
                ->addColumn('action', function($row) {
                    return '<a href="'.route('readonly.timbangan.show', $row->id).'" class="inline-flex items-center px-3 py-1 bg-gray-500 text-white text-sm rounded-md hover:bg-gray-600">Detail</a>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        
        return view('readonly.timbangan.index');
    }
    
    public function show($id)
    {
        $timbangan = Timbangan::with('user')->findOrFail($id);
        return view('readonly.timbangan.show', compact('timbangan'));
    }

    public function export(Request $request)
    {
        $startDate = $request->get('start_date', date('Y-m-01'));
        $endDate = $request->get('end_date', date('Y-m-d'));
        $fileName = 'Timbangan_' . date('d-m-Y', strtotime($startDate)) . '_sd_' . date('d-m-Y', strtotime($endDate)) . '.xlsx';
        return Excel::download(new TimbanganExport($startDate, $endDate), $fileName);
    }
}