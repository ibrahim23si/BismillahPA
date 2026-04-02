<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\AjuKas;
use App\Http\Requests\AjuKasRequest;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AjuKasController extends Controller
{
    /**
     * Display a listing of aju kas.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = AjuKas::with('creator')
                ->select('aju_kas.*')
                ->orderBy('tanggal', 'desc')
                ->orderBy('created_at', 'desc');
                
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('tanggal', function($row) {
                    return $row->tanggal->format('d/m/Y');
                })
                ->editColumn('nominal', function($row) {
                    return Helper::formatRupiah($row->nominal);
                })
                ->editColumn('status', function($row) {
                    return Helper::getStatusBadge($row->status);
                })
                ->addColumn('action', function($row) {
                    if ($row->isPending()) {
                        $btn = '<a href="'.route('kasir.aju-kas.edit', $row->id).'" class="inline-flex items-center px-3 py-1 bg-blue-500 text-white text-sm rounded-md hover:bg-blue-600 mr-1">Edit</a>';
                        $btn .= '<button onclick="deleteData('.$row->id.')" class="inline-flex items-center px-3 py-1 bg-red-500 text-white text-sm rounded-md hover:bg-red-600">Hapus</button>';
                    } else {
                        $btn = '<a href="'.route('kasir.aju-kas.show', $row->id).'" class="inline-flex items-center px-3 py-1 bg-gray-500 text-white text-sm rounded-md hover:bg-gray-600">Detail</a>';
                    }
                    return $btn;
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }
        
        return view('kasir.aju-kas.index');
    }
    
    /**
     * Show form for creating new aju kas.
     */
    public function create()
    {
        return view('kasir.aju-kas.create');
    }
    
    /**
     * Store a newly created aju kas.
     */
    public function store(AjuKasRequest $request)
    {
        try {
            $data = $request->validated();
            $data['created_by'] = auth()->id();
            $data['status'] = 'pending';
            
            AjuKas::create($data);
            
            return redirect()->route('kasir.aju-kas.index')
                ->with('success', 'Pengajuan kas berhasil ditambahkan dan menunggu approval.');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    
    /**
     * Display the specified aju kas.
     */
    public function show($id)
    {
        $aju = AjuKas::with(['creator', 'approver'])->findOrFail($id);
        return view('kasir.aju-kas.show', compact('aju'));
    }
    
    /**
     * Show form for editing aju kas.
     */
    public function edit($id)
    {
        $aju = AjuKas::findOrFail($id);
        
        if (!$aju->isPending()) {
            return redirect()->route('kasir.aju-kas.index')
                ->with('error', 'Pengajuan yang sudah diproses tidak dapat diedit.');
        }
        
        return view('kasir.aju-kas.edit', compact('aju'));
    }
    
    /**
     * Update aju kas.
     */
    public function update(AjuKasRequest $request, $id)
    {
        try {
            $aju = AjuKas::findOrFail($id);
            
            if (!$aju->isPending()) {
                return redirect()->route('kasir.aju-kas.index')
                    ->with('error', 'Pengajuan yang sudah diproses tidak dapat diedit.');
            }
            
            $aju->update($request->validated());
            
            return redirect()->route('kasir.aju-kas.index')
                ->with('success', 'Pengajuan kas berhasil diupdate.');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    
    /**
     * Delete aju kas.
     */
    public function destroy($id)
    {
        try {
            $aju = AjuKas::findOrFail($id);
            
            if (!$aju->isPending()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pengajuan yang sudah diproses tidak dapat dihapus.'
                ], 400);
            }
            
            $aju->delete();
            
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