<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Piutang;
use App\Models\LapKas;
use App\Http\Requests\PiutangRequest;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

class PiutangController extends Controller
{
    /**
     * Display a listing of piutang.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Piutang::with(['user', 'jualMaterial'])
                ->select('piutang.*')
                ->orderBy('tanggal', 'desc')
                ->orderBy('created_at', 'desc');
                
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('tanggal', function($row) {
                    return $row->tanggal->format('d/m/Y');
                })
                ->editColumn('tanggal_invoice', function($row) {
                    return $row->tanggal_invoice->format('d/m/Y');
                })
                ->editColumn('tanggal_jatuh_tempo', function($row) {
                    return $row->tanggal_jatuh_tempo ? $row->tanggal_jatuh_tempo->format('d/m/Y') : '-';
                })
                ->editColumn('nominal', function($row) {
                    return Helper::formatRupiah($row->nominal);
                })
                ->editColumn('sisa', function($row) {
                    return Helper::formatRupiah($row->sisa);
                })
                ->editColumn('status', function($row) {
                    return Helper::getStatusBadge($row->status);
                })
                ->editColumn('over_due', function($row) {
                    if ($row->over_due > 0) {
                        return '<span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">'.$row->over_due.' hari</span>';
                    }
                    return '-';
                })
                ->addColumn('action', function($row) {
                    $btn = '<a href="'.route('kasir.piutang.edit', $row->id).'" class="inline-flex items-center px-3 py-1 bg-blue-500 text-white text-sm rounded-md hover:bg-blue-600 mr-1">Bayar/Edit</a>';
                    
                    if ($row->isPending() || $row->isApproved()) {
                        $btn .= '<button onclick="deleteData('.$row->id.')" class="inline-flex items-center px-3 py-1 bg-red-500 text-white text-sm rounded-md hover:bg-red-600">Hapus</button>';
                    }
                    
                    return $btn;
                })
                ->rawColumns(['status', 'over_due', 'action'])
                ->make(true);
        }
        
        // Ringkasan piutang
        $totalPiutang = Piutang::whereIn('status', ['pending', 'approved'])->sum('sisa');
        $totalPiutangJatuhTempo = Piutang::whereIn('status', ['pending', 'approved'])
            ->whereDate('tanggal_jatuh_tempo', '<', now())
            ->sum('sisa');
        
        return view('kasir.piutang.index', compact('totalPiutang', 'totalPiutangJatuhTempo'));
    }
    
    /**
     * Show form for creating new piutang (manual entry).
     */
    public function create()
    {
        return view('kasir.piutang.create');
    }
    
    /**
     * Store a newly created piutang.
     */
    public function store(PiutangRequest $request)
    {
        try {
            DB::beginTransaction();
            
            $data = $request->validated();
            $data['created_by'] = auth()->id();
            $data['status'] = 'approved'; // Manual entry langsung approved
            
            Piutang::create($data);
            
            DB::commit();
            
            return redirect()->route('kasir.piutang.index')
                ->with('success', 'Data piutang berhasil ditambahkan.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    
    /**
     * Show form for editing piutang (untuk pembayaran).
     */
    public function edit($id)
    {
        $piutang = Piutang::findOrFail($id);
        return view('kasir.piutang.edit', compact('piutang'));
    }
    
    /**
     * Update piutang (pembayaran).
     */
    public function update(PiutangRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            
            $piutang = Piutang::findOrFail($id);
            $oldStatus = $piutang->status;
            
            $piutang->update($request->validated());
            
            // Jika baru lunas, catat ke LapKas
            if ($oldStatus != 'paid' && $piutang->isPaid() && $piutang->tanggal_bayar) {
                LapKas::create([
                    'tanggal' => $piutang->tanggal_bayar,
                    'nomor_bukti' => Helper::generateNomorTransaksi('LK', LapKas::class),
                    'keterangan' => "Pembayaran piutang dari {$piutang->nama_debitur}",
                    'debet' => ($piutang->cash_bayar ?? 0) + ($piutang->transfer_bayar ?? 0),
                    'kredit' => 0,
                    'created_by' => auth()->id()
                ]);
            }
            
            DB::commit();
            
            return redirect()->route('kasir.piutang.index')
                ->with('success', 'Data piutang berhasil diupdate.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    
    /**
     * Delete piutang.
     */
    public function destroy($id)
    {
        try {
            $piutang = Piutang::findOrFail($id);
            
            if ($piutang->isPaid()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Piutang yang sudah lunas tidak dapat dihapus.'
                ], 400);
            }
            
            $piutang->delete();
            
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