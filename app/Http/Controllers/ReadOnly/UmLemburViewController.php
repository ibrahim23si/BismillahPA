<?php

namespace App\Http\Controllers\ReadOnly;

use App\Http\Controllers\Controller;
use App\Models\UmLembur;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UmLemburViewController extends Controller
{
    /**
     * Display a listing of um lembur (read only).
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = UmLembur::with('creator')
                ->select('um_lemburs.*')
                ->orderBy('periode', 'desc')
                ->orderBy('nama', 'asc');
                
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('periode', function($row) {
                    return $row->periode->format('F Y');
                })
                ->editColumn('total_jam', function($row) {
                    return number_format($row->total_jam, 2) . ' jam';
                })
                ->editColumn('total_upah', function($row) {
                    return Helper::formatRupiah($row->total_upah);
                })
                ->addColumn('created_by_name', function($row) {
                    return $row->creator ? $row->creator->name : '-';
                })
                ->addColumn('action', function($row) {
                    return '<a href="'.route('readonly.um-lembur.show', $row->id).'" class="inline-flex items-center px-3 py-1 bg-gray-500 text-white text-sm rounded-md hover:bg-gray-600">Detail</a>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        
        return view('readonly.um-lembur.index');
    }

    /**
     * Display the specified um lembur.
     */
    public function show($id)
    {
        $umLembur = UmLembur::with('creator')->findOrFail($id);
        return view('readonly.um-lembur.show', compact('umLembur'));
    }
}