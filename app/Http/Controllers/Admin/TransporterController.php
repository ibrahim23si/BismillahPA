<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transporter;
use App\Http\Requests\TransporterRequest;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TransporterController extends Controller
{
    /**
     * Display a listing of transporters.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Transporter::orderBy('nama', 'asc');

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="' . route('admin.master.transporters.edit', $row->id) . '" class="inline-flex items-center px-3 py-1 bg-blue-500 text-white text-sm rounded-md hover:bg-blue-600 mr-1">Edit</a>';
                    $btn .= '<button onclick="deleteData(' . $row->id . ')" class="inline-flex items-center px-3 py-1 bg-red-500 text-white text-sm rounded-md hover:bg-red-600">Hapus</button>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.master.transporters.index');
    }

    /**
     * Get list for Select2 dropdown.
     */
    public function getList(Request $request)
    {
        $search = $request->get('q', '');

        $data = Transporter::where('nama', 'like', '%' . $search . '%')
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
     * Show form for creating new transporter.
     */
    public function create()
    {
        return view('admin.master.transporters.create');
    }

    /**
     * Store a newly created transporter.
     */
    public function store(TransporterRequest $request)
    {
        try {
            Transporter::create($request->validated());

            return redirect()->route('admin.master.transporters.index')
                ->with('success', 'Data transporter berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Show form for editing transporter.
     */
    public function edit($id)
    {
        $transporter = Transporter::findOrFail($id);
        return view('admin.master.transporters.edit', compact('transporter'));
    }

    /**
     * Update transporter.
     */
    public function update(TransporterRequest $request, $id)
    {
        try {
            $transporter = Transporter::findOrFail($id);
            $transporter->update($request->validated());

            return redirect()->route('admin.master.transporters.index')
                ->with('success', 'Data transporter berhasil diupdate.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Delete transporter.
     */
    public function destroy($id)
    {
        try {
            $transporter = Transporter::findOrFail($id);
            $transporter->delete();

            return response()->json([
                'success' => true,
                'message' => 'Data transporter berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
