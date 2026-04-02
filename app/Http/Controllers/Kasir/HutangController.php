<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Hutang;
use App\Http\Requests\HutangRequest;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class HutangController extends Controller
{
    /**
     * Display a listing of hutang.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Hutang::with('user')
                ->select('hutang.*')
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
                ->addColumn('action', function($row) {
                    $btn = '<a href="'.route('kasir.hutang.edit', $row->id).'" class="inline-flex items-center px-3 py-1 bg-blue-500 text-white text-sm rounded-md hover:bg-blue-600 mr-1">Bayar/Edit</a>';
                    $btn .= '<button onclick="deleteData('.$row->id.')" class="inline-flex items-center px-3 py-1 bg-red-500 text-white text-sm rounded-md hover:bg-red-600">Hapus</button>';
                    return $btn;
                })
                ->rawColumns(['status', 'over_due', 'action'])
                ->make(true);
        }
        
        // Ringkasan hutang
        $totalHutang = Hutang::whereIn('status', ['pending', 'approved'])->sum('sisa');
        $totalHutangJatuhTempo = Hutang::whereIn('status', ['pending', 'approved'])
            ->whereDate('tanggal_jatuh_tempo', '<', now())
            ->sum('sisa');
        
        return view('kasir.hutang.index', compact('totalHutang', 'totalHutangJatuhTempo'));
    }
    
    /**
     * Show form for creating new hutang.
     */
    public function create()
    {
        return view('kasir.hutang.create');
    }
    
    /**
     * Store a newly created hutang.
     */
    public function store(HutangRequest $request)
    {
        try {
            $data = $request->validated();
            $data['created_by'] = auth()->id();
            $data['status'] = 'pending';
            
            Hutang::create($data);
            
            return redirect()->route('kasir.hutang.index')
                ->with('success', 'Data hutang berhasil ditambahkan.');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    
    /**
     * Show form for editing hutang.
     */
    public function edit($id)
    {
        $hutang = Hutang::findOrFail($id);
        return view('kasir.hutang.edit', compact('hutang'));
    }
    
    /**
     * Update hutang.
     */
    public function update(HutangRequest $request, $id)
    {
        try {
            $hutang = Hutang::findOrFail($id);
            $hutang->update($request->validated());
            
            return redirect()->route('kasir.hutang.index')
                ->with('success', 'Data hutang berhasil diupdate.');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    
    /**
     * Delete hutang.
     */
    public function destroy($id)
    {
        try {
            $hutang = Hutang::findOrFail($id);
            
            if ($hutang->isPaid()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Hutang yang sudah lunas tidak dapat dihapus.'
                ], 400);
            }
            
            $hutang->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil dihapus.'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}