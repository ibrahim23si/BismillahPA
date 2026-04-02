<?php

namespace App\Http\Controllers\ReadOnly;

use App\Http\Controllers\Controller;
use App\Models\JualMaterial;
use App\Exports\JualMaterialExport;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Maatwebsite\Excel\Facades\Excel;

class JualMaterialViewController extends Controller
{
    /**
     * Display a listing of jual material (read only).
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = JualMaterial::with(['creator', 'approver'])
                ->select('jual_material.*')
                ->orderBy('tanggal', 'desc')
                ->orderBy('created_at', 'desc');
                
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('tanggal', function($row) {
                    return $row->tanggal->format('d/m/Y');
                })
                ->editColumn('netto', function($row) {
                    return Helper::formatDesimal($row->netto) . ' ton';
                })
                ->editColumn('total_harga', function($row) {
                    return Helper::formatRupiah($row->total_harga);
                })
                ->editColumn('jenis_bayar', function($row) {
                    $badge = $row->jenis_bayar == 'cash' 
                        ? '<span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Cash</span>'
                        : '<span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">Invoice</span>';
                    return $badge;
                })
                ->editColumn('status', function($row) {
                    return Helper::getStatusBadge($row->status);
                })
                ->addColumn('created_by_name', function($row) {
                    return $row->creator ? $row->creator->name : '-';
                })
                ->addColumn('approved_by_name', function($row) {
                    return $row->approver ? $row->approver->name : '-';
                })
                ->addColumn('action', function($row) {
                    return '<a href="'.route('readonly.jual-material.show', $row->id).'" class="inline-flex items-center px-3 py-1 bg-gray-500 text-white text-sm rounded-md hover:bg-gray-600">Detail</a>';
                })
                ->rawColumns(['jenis_bayar', 'status', 'action'])
                ->make(true);
        }
        
        return view('readonly.jual-material.index');
    }
    
    /**
     * Display the specified jual material.
     */
    public function show($id)
    {
        $jual = JualMaterial::with(['creator', 'approver', 'piutang'])->findOrFail($id);
        return view('readonly.jual-material.show', compact('jual'));
    }

    public function export(Request $request)
    {
        $startDate = $request->get('start_date', date('Y-m-01'));
        $endDate = $request->get('end_date', date('Y-m-d'));
        $fileName = 'Jual_Material_' . date('d-m-Y', strtotime($startDate)) . '_sd_' . date('d-m-Y', strtotime($endDate)) . '.xlsx';
        return Excel::download(new JualMaterialExport($startDate, $endDate), $fileName);
    }
}