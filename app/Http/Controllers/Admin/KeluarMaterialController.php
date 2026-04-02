<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KeluarMaterial;
use App\Http\Requests\KeluarMaterialRequest;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class KeluarMaterialController extends Controller
{
    /**
     * Display a listing of keluar material.
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
                ->editColumn('created_at', function($row) {
                    return $row->created_at->format('d/m/Y H:i');
                })
                ->addColumn('action', function($row) {
                    $btn = '<a href="'.route('admin.keluar-material.edit', $row->id).'" class="inline-flex items-center px-3 py-1 bg-blue-500 text-white text-sm rounded-md hover:bg-blue-600 mr-1">Edit</a>';
                    $btn .= '<button onclick="deleteData('.$row->id.')" class="inline-flex items-center px-3 py-1 bg-red-500 text-white text-sm rounded-md hover:bg-red-600">Hapus</button>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        
        return view('admin.keluar-material.index');
    }
    
    /**
     * Show form for creating new keluar material.
     */
    public function create()
    {
        return view('admin.keluar-material.create');
    }
    
    /**
     * Store a newly created keluar material.
     */
    public function store(KeluarMaterialRequest $request)
    {
        try {
            $data = $request->validated();
            $data['created_by'] = auth()->id();
            
            KeluarMaterial::create($data);
            
            return redirect()->route('admin.keluar-material.index')
                ->with('success', 'Data keluar material berhasil ditambahkan.');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    
    /**
     * Show form for editing keluar material.
     */
    public function edit($id)
    {
        $material = KeluarMaterial::findOrFail($id);
        return view('admin.keluar-material.edit', compact('material'));
    }
    
    /**
     * Update keluar material.
     */
    public function update(KeluarMaterialRequest $request, $id)
    {
        try {
            $material = KeluarMaterial::findOrFail($id);
            $material->update($request->validated());
            
            return redirect()->route('admin.keluar-material.index')
                ->with('success', 'Data keluar material berhasil diupdate.');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    
    /**
     * Delete keluar material.
     */
    public function destroy($id)
    {
        try {
            $material = KeluarMaterial::findOrFail($id);
            $material->delete();
            
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