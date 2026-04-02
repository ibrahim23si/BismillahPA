<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Timbangan;
use App\Http\Requests\TimbanganRequest;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TimbanganController extends Controller
{
    /**
     * Display a listing of timbangan.
     */
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
                ->editColumn('netto', function($row) {
                    return Helper::formatDesimal($row->netto) . ' ton';
                })
                ->editColumn('status_jual', function($row) {
                    return $row->status_jual ? 'Jual' : 'Lainnya';
                })
                ->editColumn('total_harga', function($row) {
                    return $row->total_harga ? Helper::formatRupiah($row->total_harga) : '-';
                })
                ->addColumn('action', function($row) {
                    $btn = '<a href="'.route('admin.timbangan.edit', $row->id).'" class="inline-flex items-center px-3 py-1 bg-blue-500 text-white text-sm rounded-md hover:bg-blue-600 mr-1">Edit</a>';
                    $btn .= '<button onclick="deleteData('.$row->id.')" class="inline-flex items-center px-3 py-1 bg-red-500 text-white text-sm rounded-md hover:bg-red-600">Hapus</button>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        
        return view('admin.timbangan.index');
    }
    
    /**
     * Show form for creating new timbangan.
     */
    public function create()
    {
        return view('admin.timbangan.create');
    }
    
    /**
     * Store a newly created timbangan.
     */
    public function store(TimbanganRequest $request)
    {
        try {
            $data = $request->validated();
            $data['created_by'] = auth()->id();
            
            Timbangan::create($data);
            
            return redirect()->route('admin.timbangan.index')
                ->with('success', 'Data timbangan berhasil ditambahkan.');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    
    /**
     * Show form for editing timbangan.
     */
    public function edit($id)
    {
        $timbangan = Timbangan::findOrFail($id);
        return view('admin.timbangan.edit', compact('timbangan'));
    }
    
    /**
     * Update timbangan.
     */
    public function update(TimbanganRequest $request, $id)
    {
        try {
            $timbangan = Timbangan::findOrFail($id);
            $timbangan->update($request->validated());
            
            return redirect()->route('admin.timbangan.index')
                ->with('success', 'Data timbangan berhasil diupdate.');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    
    /**
     * Delete timbangan.
     */
    public function destroy($id)
    {
        try {
            $timbangan = Timbangan::findOrFail($id);
            $timbangan->delete();
            
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