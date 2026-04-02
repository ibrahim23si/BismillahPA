<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProduksiRaw;
use App\Http\Requests\ProduksiRawRequest;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ProduksiRawController extends Controller
{
    /**
     * Display a listing of produksi raw.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = ProduksiRaw::with('user')
                ->select('produksi_raw.*')
                ->orderBy('tanggal_produksi', 'desc');

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('tanggal_produksi', function ($row) {
                    return $row->tanggal_produksi->format('d/m/Y');
                })
                ->editColumn('total_output', function ($row) {
                    return Helper::formatDesimal($row->total_output) . ' ton';
                })
                ->editColumn('produktivitas_per_jam', function ($row) {
                    return Helper::formatDesimal($row->produktivitas_per_jam) . ' ton/jam';
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->format('d/m/Y H:i');
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="' . route('admin.produksi-raw.edit', $row->id) . '" class="inline-flex items-center px-3 py-1 bg-blue-500 text-white text-sm rounded-md hover:bg-blue-600 mr-1">Edit</a>';
                    $btn .= '<button onclick="deleteData(' . $row->id . ')" class="inline-flex items-center px-3 py-1 bg-red-500 text-white text-sm rounded-md hover:bg-red-600">Hapus</button>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.produksi-raw.index');
    }

    /**
     * Show form for creating new produksi raw.
     */
    public function create()
    {
        return view('admin.produksi-raw.create');
    }

    /**
     * Store a newly created produksi raw.
     */
    public function store(ProduksiRawRequest $request)
    {
        try {
            $data = $request->validated();
            $data['created_by'] = auth()->id();

            ProduksiRaw::create($data);

            return redirect()->route('admin.produksi-raw.index')
                ->with('success', 'Data produksi raw berhasil ditambahkan.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Show form for editing produksi raw.
     */
    public function edit($id)
    {
        $produksi = ProduksiRaw::findOrFail($id);
        return view('admin.produksi-raw.edit', compact('produksi'));
    }

    /**
     * Update produksi raw.
     */
    public function update(ProduksiRawRequest $request, $id)
    {
        try {
            $produksi = ProduksiRaw::findOrFail($id);
            $produksi->update($request->validated());

            return redirect()->route('admin.produksi-raw.index')
                ->with('success', 'Data produksi raw berhasil diupdate.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Delete produksi raw.
     */
    public function destroy($id)
    {
        try {
            $produksi = ProduksiRaw::findOrFail($id);
            $produksi->delete();

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