<?php

namespace App\Http\Controllers\ReadOnly;

use App\Http\Controllers\Controller;
use App\Models\KeluarMaterial;
use App\Exports\KeluarMaterialExport;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Maatwebsite\Excel\Facades\Excel;

class KeluarMaterialViewController extends Controller
{
    /**
     * Display a listing of keluar material (read only).
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = KeluarMaterial::with('user')
                ->select('keluar_material.*')
                ->orderBy('tanggal', 'desc')
                ->orderBy('nomor_urut', 'desc');
                
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('tanggal', function($row) {
                    return $row->tanggal->format('d/m/Y');
                })
                ->editColumn('netto', function($row) {
                    return Helper::formatDesimal($row->netto) . ' ton';
                })
                ->editColumn('total_harga', function($row) {
                    return $row->total_harga ? Helper::formatRupiah($row->total_harga) : '-';
                })
                ->addColumn('created_by_name', function($row) {
                    return $row->user ? $row->user->name : '-';
                })
                ->addColumn('action', function($row) {
                    return '<a href="'.route('readonly.keluar-material.show', $row->id).'" class="inline-flex items-center px-3 py-1 bg-gray-500 text-white text-sm rounded-md hover:bg-gray-600">Detail</a>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        
        return view('readonly.keluar-material.index');
    }
    
    /**
     * Display the specified keluar material.
     */
    public function show($id)
    {
        $material = KeluarMaterial::with('user')->findOrFail($id);
        return view('readonly.keluar-material.show', compact('material'));
    }

    public function export(Request $request)
    {
        $startDate = $request->get('start_date', date('Y-m-01'));
        $endDate = $request->get('end_date', date('Y-m-d'));
        $fileName = 'Keluar_Material_' . date('d-m-Y', strtotime($startDate)) . '_sd_' . date('d-m-Y', strtotime($endDate)) . '.xlsx';
        return Excel::download(new KeluarMaterialExport($startDate, $endDate), $fileName);
    }
}