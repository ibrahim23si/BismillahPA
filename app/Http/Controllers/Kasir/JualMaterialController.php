<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\JualMaterial;
use App\Http\Requests\JualMaterialRequest;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class JualMaterialController extends Controller
{
    /**
     * Display a listing of jual material.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = JualMaterial::with('creator')
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
                ->addColumn('action', function($row) {
                    if ($row->isPending()) {
                        $btn = '<a href="'.route('kasir.jual-material.edit', $row->id).'" class="inline-flex items-center px-3 py-1 bg-blue-500 text-white text-sm rounded-md hover:bg-blue-600 mr-1">Edit</a>';
                        $btn .= '<button onclick="deleteData('.$row->id.')" class="inline-flex items-center px-3 py-1 bg-red-500 text-white text-sm rounded-md hover:bg-red-600">Hapus</button>';
                    } else {
                        $btn = '<a href="'.route('kasir.jual-material.show', $row->id).'" class="inline-flex items-center px-3 py-1 bg-gray-500 text-white text-sm rounded-md hover:bg-gray-600">Detail</a>';
                    }
                    return $btn;
                })
                ->rawColumns(['jenis_bayar', 'status', 'action'])
                ->make(true);
        }
        
        return view('kasir.jual-material.index');
    }
    
    /**
     * Show form for creating new jual material.
     */
    public function create()
    {
        return view('kasir.jual-material.create');
    }
    
    /**
     * Store a newly created jual material.
     */
    public function store(JualMaterialRequest $request)
    {
        try {
            $data = $request->validated();
            $data['created_by'] = auth()->id();
            $data['status'] = 'pending'; // Butuh approval
            
            JualMaterial::create($data);
            
            return redirect()->route('kasir.jual-material.index')
                ->with('success', 'Transaksi penjualan berhasil ditambahkan dan menunggu approval.');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    
    /**
     * Display the specified jual material.
     */
    public function show($id)
    {
        $jual = JualMaterial::with(['creator', 'approver'])->findOrFail($id);
        return view('kasir.jual-material.show', compact('jual'));
    }
    
    /**
     * Show form for editing jual material.
     */
    public function edit($id)
    {
        $jual = JualMaterial::findOrFail($id);
        
        // Cek apakah masih bisa diedit
        if (!$jual->isPending()) {
            return redirect()->route('kasir.jual-material.index')
                ->with('error', 'Transaksi yang sudah diproses tidak dapat diedit.');
        }
        
        return view('kasir.jual-material.edit', compact('jual'));
    }
    
    /**
     * Update jual material.
     */
    public function update(JualMaterialRequest $request, $id)
    {
        try {
            $jual = JualMaterial::findOrFail($id);
            
            if (!$jual->isPending()) {
                return redirect()->route('kasir.jual-material.index')
                    ->with('error', 'Transaksi yang sudah diproses tidak dapat diedit.');
            }
            
            $jual->update($request->validated());
            
            return redirect()->route('kasir.jual-material.index')
                ->with('success', 'Transaksi penjualan berhasil diupdate.');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    
    /**
     * Delete jual material.
     */
    public function destroy($id)
    {
        try {
            $jual = JualMaterial::findOrFail($id);
            
            if (!$jual->isPending()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Transaksi yang sudah diproses tidak dapat dihapus.'
                ], 400);
            }
            
            $jual->delete();
            
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