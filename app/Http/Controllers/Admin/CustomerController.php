<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Http\Requests\CustomerRequest;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CustomerController extends Controller
{
    /**
     * Display a listing of customers.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Customer::orderBy('name', 'asc');

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="' . route('admin.master.customers.edit', $row->id) . '" class="inline-flex items-center px-3 py-1 bg-blue-500 text-white text-sm rounded-md hover:bg-blue-600 mr-1">Edit</a>';
                    $btn .= '<button onclick="deleteData(' . $row->id . ')" class="inline-flex items-center px-3 py-1 bg-red-500 text-white text-sm rounded-md hover:bg-red-600">Hapus</button>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.master.customers.index');
    }

    /**
     * Get list for Select2 dropdown.
     */
    public function getList(Request $request)
    {
        $search = $request->get('q', '');

        $data = Customer::where('name', 'like', '%' . $search . '%')
            ->orderBy('name', 'asc')
            ->limit(20)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->name,
                    'text' => $item->name,
                ];
            });

        return response()->json($data);
    }

    /**
     * Show form for creating new customer.
     */
    public function create()
    {
        return view('admin.master.customers.create');
    }

    /**
     * Store a newly created customer.
     */
    public function store(CustomerRequest $request)
    {
        try {
            Customer::create($request->validated());

            return redirect()->route('admin.master.customers.index')
                ->with('success', 'Data customer berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Show form for editing customer.
     */
    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        return view('admin.master.customers.edit', compact('customer'));
    }

    /**
     * Update customer.
     */
    public function update(CustomerRequest $request, $id)
    {
        try {
            $customer = Customer::findOrFail($id);
            $customer->update($request->validated());

            return redirect()->route('admin.master.customers.index')
                ->with('success', 'Data customer berhasil diupdate.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Delete customer.
     */
    public function destroy($id)
    {
        try {
            $customer = Customer::findOrFail($id);
            $customer->delete();

            return response()->json([
                'success' => true,
                'message' => 'Data customer berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
