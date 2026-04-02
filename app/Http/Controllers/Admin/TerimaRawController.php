<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TerimaRaw;
use App\Http\Requests\TerimaRawRequest;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TerimaRawController extends Controller
{
    /**
     * Display a listing of terima raw.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = TerimaRaw::with('user')
                ->select('terima_raw.*')
                ->orderBy('tanggal', 'desc')
                ->orderBy('nomor_urut', 'desc');
                
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('tanggal', function($row) {
                    return $row->tanggal->format('d/m/Y');
                })
                ->editColumn('gross', function($row) {
                    return Helper::formatDesimal($row->gross) . ' ton';
                })
                ->editColumn('tara', function($row) {
                    return Helper::formatDesimal($row->tara) . ' ton';
                })
                ->editColumn('netto', function($row) {
                    return Helper::formatDesimal($row->netto) . ' ton';
                })
                ->editColumn('created_at', function($row) {
                    return $row->created_at->format('d/m/Y H:i');
                })
                ->addColumn('action', function($row) {
                    $btn = '<a href="'.route('admin.terima-raw.edit', $row->id).'" class="inline-flex items-center px-3 py-1 bg-blue-500 text-white text-sm rounded-md hover:bg-blue-600 mr-1">Edit</a>';
                    $btn .= '<button onclick="deleteData('.$row->id.')" class="inline-flex items-center px-3 py-1 bg-red-500 text-white text-sm rounded-md hover:bg-red-600">Hapus</button>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        
        return view('admin.terima-raw.index');
    }
    
    /**
     * Show form for creating new terima raw.
     */
    public function create()
    {
        return view('admin.terima-raw.create');
    }
    
    /**
     * Store a newly created terima raw.
     */
    public function store(TerimaRawRequest $request)
    {
        try {
            $data = $request->validated();
            $data['created_by'] = auth()->id();
            
            TerimaRaw::create($data);
            
            return redirect()->route('admin.terima-raw.index')
                ->with('success', 'Data terima raw berhasil ditambahkan.');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    
    /**
     * Show form for editing terima raw.
     */
    public function edit($id)
    {
        $terima = TerimaRaw::findOrFail($id);
        return view('admin.terima-raw.edit', compact('terima'));
    }
    
    /**
     * Update terima raw.
     */
    public function update(TerimaRawRequest $request, $id)
    {
        try {
            $terima = TerimaRaw::findOrFail($id);
            $terima->update($request->validated());
            
            return redirect()->route('admin.terima-raw.index')
                ->with('success', 'Data terima raw berhasil diupdate.');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    
    /**
     * Delete terima raw.
     */
    public function destroy($id)
    {
        try {
            $terima = TerimaRaw::findOrFail($id);
            $terima->delete();
            
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