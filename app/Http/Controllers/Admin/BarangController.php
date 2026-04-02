<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Http\Requests\BarangRequest;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BarangController extends Controller
{
    /**
     * Display a listing of barangs.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Barang::orderBy('nama', 'asc');

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="' . route('admin.master.barangs.edit', $row->id) . '" class="inline-flex items-center px-3 py-1 bg-blue-500 text-white text-sm rounded-md hover:bg-blue-600 mr-1">Edit</a>';
                    $btn .= '<button onclick="deleteData(' . $row->id . ')" class="inline-flex items-center px-3 py-1 bg-red-500 text-white text-sm rounded-md hover:bg-red-600">Hapus</button>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.master.barangs.index');
    }

    /**
     * Get list for Select2 dropdown.
     */
    public function getList(Request $request)
    {
        $search = $request->get('q', '');

        $data = Barang::where('nama', 'like', '%' . $search . '%')
            ->orderBy('nama', 'asc')
            ->limit(20)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->nama,
                    'text' => $item->nama,
                ];
            });

        return response()->json($data);
    }

    /**
     * Show form for creating new barang.
     */
    public function create()
    {
        return view('admin.master.barangs.create');
    }

    /**
     * Store a newly created barang.
     */
    public function store(BarangRequest $request)
    {
        try {
            Barang::create($request->validated());

            return redirect()->route('admin.master.barangs.index')
                ->with('success', 'Data barang berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Show form for editing barang.
     */
    public function edit($id)
    {
        $barang = Barang::findOrFail($id);
        return view('admin.master.barangs.edit', compact('barang'));
    }

    /**
     * Update barang.
     */
    public function update(BarangRequest $request, $id)
    {
        try {
            $barang = Barang::findOrFail($id);
            $barang->update($request->validated());

            return redirect()->route('admin.master.barangs.index')
                ->with('success', 'Data barang berhasil diupdate.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Delete barang.
     */
    public function destroy($id)
    {
        try {
            $barang = Barang::findOrFail($id);
            $barang->delete();

            return response()->json([
                'success' => true,
                'message' => 'Data barang berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
