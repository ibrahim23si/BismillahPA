<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use App\Http\Requests\SupplierRequest;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SupplierController extends Controller
{
    /**
     * Display a listing of suppliers.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Supplier::orderBy('nama', 'asc');

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="' . route('admin.master.suppliers.edit', $row->id) . '" class="inline-flex items-center px-3 py-1 bg-blue-500 text-white text-sm rounded-md hover:bg-blue-600 mr-1">Edit</a>';
                    $btn .= '<button onclick="deleteData(' . $row->id . ')" class="inline-flex items-center px-3 py-1 bg-red-500 text-white text-sm rounded-md hover:bg-red-600">Hapus</button>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.master.suppliers.index');
    }

    /**
     * Get list for Select2 dropdown.
     */
    public function getList(Request $request)
    {
        $search = $request->get('q', '');

        $data = Supplier::where('nama', 'like', '%' . $search . '%')
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
     * Show form for creating new supplier.
     */
    public function create()
    {
        return view('admin.master.suppliers.create');
    }

    /**
     * Store a newly created supplier.
     */
    public function store(SupplierRequest $request)
    {
        try {
            Supplier::create($request->validated());

            return redirect()->route('admin.master.suppliers.index')
                ->with('success', 'Data supplier berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Show form for editing supplier.
     */
    public function edit($id)
    {
        $supplier = Supplier::findOrFail($id);
        return view('admin.master.suppliers.edit', compact('supplier'));
    }

    /**
     * Update supplier.
     */
    public function update(SupplierRequest $request, $id)
    {
        try {
            $supplier = Supplier::findOrFail($id);
            $supplier->update($request->validated());

            return redirect()->route('admin.master.suppliers.index')
                ->with('success', 'Data supplier berhasil diupdate.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Delete supplier.
     */
    public function destroy($id)
    {
        try {
            $supplier = Supplier::findOrFail($id);
            $supplier->delete();

            return response()->json([
                'success' => true,
                'message' => 'Data supplier berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
