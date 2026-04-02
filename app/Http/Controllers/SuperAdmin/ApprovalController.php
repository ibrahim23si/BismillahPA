<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\JualMaterial;
use App\Models\AjuKas;
use App\Models\LapKas;
use App\Models\Piutang;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApprovalController extends Controller
{
    /**
     * Display a listing of pending approvals.
     */
    public function index()
    {
        $jualPending = JualMaterial::with('creator')
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'jual_page');
            
        $ajuPending = AjuKas::with('creator')
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'aju_page');
            
        return view('super-admin.approvals.index', compact('jualPending', 'ajuPending'));
    }
    
    /**
     * Approve Jual Material.
     */
    public function approveJual(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            
            $jual = JualMaterial::findOrFail($id);
            
            // Cek apakah masih pending
            if (!$jual->isPending()) {
                return redirect()->back()
                    ->with('error', 'Transaksi ini sudah diproses sebelumnya.');
            }
            
            // Update status
            $jual->status = 'approved';
            $jual->approved_by = auth()->id();
            $jual->approved_at = now();
            $jual->save();
            
            // Proses berdasarkan jenis bayar
            if ($jual->jenis_bayar == 'cash') {
                // Cash: langsung masuk ke LapKas
                LapKas::create([
                    'tanggal' => $jual->tanggal,
                    'nomor_bukti' => Helper::generateNomorTransaksi('LK', \App\Models\LapKas::class),
                    'keterangan' => "Penjualan {$jual->nama_barang} ke {$jual->nama_customer} (Tunai)",
                    'debet' => $jual->total_harga,
                    'kredit' => 0,
                    'jual_material_id' => $jual->id,
                    'created_by' => auth()->id()
                ]);
            } else {
                // Invoice: masuk ke Piutang
                Piutang::create([
                    'tanggal' => $jual->tanggal,
                    'nama_debitur' => $jual->nama_customer,
                    'jenis_transaksi' => $jual->nama_barang,
                    'tanggal_invoice' => $jual->tanggal_bmk ?? $jual->tanggal,
                    'nomor_invoice' => $jual->nomor_bmk,
                    'nominal' => $jual->total_harga,
                    'tanggal_jatuh_tempo' => $jual->tanggal_jatuh_tempo,
                    'status' => 'approved',
                    'jual_material_id' => $jual->id,
                    'created_by' => auth()->id()
                ]);
            }
            
            DB::commit();
            
            return redirect()->route('super-admin.approvals.index')
                ->with('success', 'Transaksi penjualan berhasil disetujui.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    
    /**
     * Reject Jual Material.
     */
    public function rejectJual(Request $request, $id)
    {
        $request->validate([
            'catatan_reject' => 'required|string|max:500'
        ]);
        
        try {
            $jual = JualMaterial::findOrFail($id);
            
            if (!$jual->isPending()) {
                return redirect()->back()
                    ->with('error', 'Transaksi ini sudah diproses sebelumnya.');
            }
            
            $jual->status = 'rejected';
            $jual->catatan_reject = $request->catatan_reject;
            $jual->approved_by = auth()->id();
            $jual->approved_at = now();
            $jual->save();
            
            return redirect()->route('super-admin.approvals.index')
                ->with('success', 'Transaksi penjualan ditolak.');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    
    /**
     * Approve Aju Kas.
     */
    public function approveAju(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            
            $aju = AjuKas::findOrFail($id);
            
            if (!$aju->isPending()) {
                return redirect()->back()
                    ->with('error', 'Pengajuan ini sudah diproses sebelumnya.');
            }
            
            $aju->status = 'approved';
            $aju->approved_by = auth()->id();
            $aju->approved_at = now();
            $aju->save();
            
            // Masuk ke LapKas sebagai kredit (uang keluar)
            LapKas::create([
                'tanggal' => $aju->tanggal,
                'nomor_bukti' => Helper::generateNomorTransaksi('LK', \App\Models\LapKas::class),
                'keterangan' => "Pengajuan Kas: " . substr($aju->keterangan, 0, 50),
                'debet' => 0,
                'kredit' => $aju->nominal,
                'aju_kas_id' => $aju->id,
                'created_by' => auth()->id()
            ]);
            
            DB::commit();
            
            return redirect()->route('super-admin.approvals.index')
                ->with('success', 'Pengajuan kas berhasil disetujui.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    
    /**
     * Reject Aju Kas.
     */
    public function rejectAju(Request $request, $id)
    {
        $request->validate([
            'catatan_reject' => 'required|string|max:500'
        ]);
        
        try {
            $aju = AjuKas::findOrFail($id);
            
            if (!$aju->isPending()) {
                return redirect()->back()
                    ->with('error', 'Pengajuan ini sudah diproses sebelumnya.');
            }
            
            $aju->status = 'rejected';
            $aju->catatan_reject = $request->catatan_reject;
            $aju->approved_by = auth()->id();
            $aju->approved_at = now();
            $aju->save();
            
            return redirect()->route('super-admin.approvals.index')
                ->with('success', 'Pengajuan kas ditolak.');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}