<?php

namespace App\Http\Controllers\ReadOnly;

use App\Http\Controllers\Controller;
use App\Models\ProduksiRaw;
use App\Exports\ProduksiRawExport;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Maatwebsite\Excel\Facades\Excel;

class ProduksiRawViewController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = ProduksiRaw::with('user')
                ->select('produksi_raw.*')
                ->orderBy('tanggal_produksi', 'desc');
                
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('tanggal_produksi', function($row) {
                    return $row->tanggal_produksi->format('d/m/Y');
                })
                ->editColumn('total_output', function($row) {
                    return Helper::formatDesimal($row->total_output) . ' ton';
                })
                ->editColumn('jam_mulai', function($row) {
                    return $row->jam_mulai_formatted;
                })
                ->editColumn('jam_selesai', function($row) {
                    return $row->jam_selesai_formatted;
                })
                ->editColumn('total_jam_operasional', function($row) {
                    return Helper::formatDesimal($row->total_jam_operasional) . ' jam';
                })
                ->editColumn('produktivitas_per_jam', function($row) {
                    return Helper::formatDesimal($row->produktivitas_per_jam) . ' ton/jam';
                })
                ->addColumn('created_by_name', function($row) {
                    return $row->user ? $row->user->name : '-';
                })
                ->addColumn('action', function($row) {
                    return '<a href="' . route('readonly.produksi-raw.show', $row->id) . '" class="inline-flex items-center px-3 py-1 bg-green-500 text-white text-sm rounded-md hover:bg-green-600">Detail</a>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        
        return view('readonly.produksi-raw.index');
    }
    
    public function show($id)
    {
        $produksi = ProduksiRaw::with('user')->findOrFail($id);
        return view('readonly.produksi-raw.show', compact('produksi'));
    }

    public function export(Request $request)
    {
        $startDate = $request->get('start_date', date('Y-m-01'));
        $endDate = $request->get('end_date', date('Y-m-d'));
        $fileName = 'Produksi_Raw_' . date('d-m-Y', strtotime($startDate)) . '_sd_' . date('d-m-Y', strtotime($endDate)) . '.xlsx';
        return Excel::download(new ProduksiRawExport($startDate, $endDate), $fileName);
    }
}