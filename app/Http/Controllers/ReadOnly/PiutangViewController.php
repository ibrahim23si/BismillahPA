<?php

namespace App\Http\Controllers\ReadOnly;

use App\Http\Controllers\Controller;
use App\Models\Piutang;
use App\Exports\PiutangExport;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Maatwebsite\Excel\Facades\Excel;

class PiutangViewController extends Controller
{
    /**
     * Display a listing of piutang (read only).
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Piutang::with(['user', 'jualMaterial'])
                ->select('piutang.*')
                ->orderBy('tanggal', 'desc')
                ->orderBy('created_at', 'desc');
                
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('tanggal', function($row) {
                    return $row->tanggal->format('d/m/Y');
                })
                ->editColumn('tanggal_invoice', function($row) {
                    return $row->tanggal_invoice->format('d/m/Y');
                })
                ->editColumn('tanggal_jatuh_tempo', function($row) {
                    return $row->tanggal_jatuh_tempo ? $row->tanggal_jatuh_tempo->format('d/m/Y') : '-';
                })
                ->editColumn('nominal', function($row) {
                    return Helper::formatRupiah($row->nominal);
                })
                ->editColumn('sisa', function($row) {
                    return Helper::formatRupiah($row->sisa);
                })
                ->editColumn('status', function($row) {
                    return Helper::getStatusBadge($row->status);
                })
                ->editColumn('over_due', function($row) {
                    if ($row->over_due > 0) {
                        return '<span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">'.$row->over_due.' hari</span>';
                    }
                    return '-';
                })
                ->addColumn('created_by_name', function($row) {
                    return $row->user ? $row->user->name : '-';
                })
                ->addColumn('action', function($row) {
                    return '<a href="'.route('readonly.piutang.show', $row->id).'" class="inline-flex items-center px-3 py-1 bg-gray-500 text-white text-sm rounded-md hover:bg-gray-600">Detail</a>';
                })
                ->rawColumns(['status', 'over_due', 'action'])
                ->make(true);
        }
        
        return view('readonly.piutang.index');
    }
    
    /**
     * Display the specified piutang.
     */
    public function show($id)
    {
        $piutang = Piutang::with(['user', 'jualMaterial'])->findOrFail($id);
        return view('readonly.piutang.show', compact('piutang'));
    }

    public function export(Request $request)
    {
        $startDate = $request->get('start_date', date('Y-m-01'));
        $endDate = $request->get('end_date', date('Y-m-d'));
        $fileName = 'Piutang_' . date('d-m-Y', strtotime($startDate)) . '_sd_' . date('d-m-Y', strtotime($endDate)) . '.xlsx';
        return Excel::download(new PiutangExport($startDate, $endDate), $fileName);
    }
}