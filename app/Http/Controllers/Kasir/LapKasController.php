<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\LapKas;
use App\Helpers\Helper;
use App\Exports\LapKasExport;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Maatwebsite\Excel\Facades\Excel;

class LapKasController extends Controller
{
    /**
     * Display a listing of lap kas.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = LapKas::with('creator')
                ->select('lap_kas.*')
                ->orderBy('tanggal', 'asc')
                ->orderBy('id', 'asc');

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('tanggal', function ($row) {
                    return $row->tanggal->format('d/m/Y');
                })
                ->editColumn('debet', function ($row) {
                    return $row->debet > 0 ? Helper::formatRupiah($row->debet) : '-';
                })
                ->editColumn('kredit', function ($row) {
                    return $row->kredit > 0 ? Helper::formatRupiah($row->kredit) : '-';
                })
                ->editColumn('saldo', function ($row) {
                    return Helper::formatRupiah($row->saldo);
                })
                ->make(true);
        }

        // Get saldo awal dan akhir untuk ringkasan
        $saldoAwal = LapKas::orderBy('tanggal', 'asc')->orderBy('id', 'asc')->first()->saldo ?? 0;
        $saldoAkhir = LapKas::orderBy('tanggal', 'desc')->orderBy('id', 'desc')->first()->saldo ?? 0;

        $totalDebet = LapKas::sum('debet');
        $totalKredit = LapKas::sum('kredit');

        return view('kasir.lap-kas.index', compact('saldoAwal', 'saldoAkhir', 'totalDebet', 'totalKredit'));
    }

    /**
     * Show form for creating new lap kas (manual entry).
     */
    public function create()
    {
        return view('kasir.lap-kas.create');
    }

    /**
     * Store manual entry lap kas.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'keterangan' => 'required|string|max:255',
            'debet' => 'nullable|numeric|min:0',
            'kredit' => 'nullable|numeric|min:0',
        ]);

        // Validasi custom: hanya salah satu yang boleh diisi
        if ($request->debet > 0 && $request->kredit > 0) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Hanya boleh mengisi salah satu: Debet atau Kredit, tidak keduanya!');
        }

        if ($request->debet == 0 && $request->kredit == 0) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Harap isi Debet atau Kredit!');
        }

        try {
            $data = [
                'tanggal' => $request->tanggal,
                'keterangan' => $request->keterangan,
                'debet' => $request->debet ?: 0,
                'kredit' => $request->kredit ?: 0,
                'created_by' => auth()->id(),
            ];

            $data['nomor_bukti'] = Helper::generateNomorTransaksi('LK', LapKas::class);

            LapKas::create($data);

            return redirect()->route('kasir.lap-kas.index')
                ->with('success', 'Entri kas berhasil ditambahkan.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Export laporan kas ke Excel.
     */
    public function export(Request $request)
    {
        $startDate = $request->get('start_date', date('Y-m-01'));
        $endDate = $request->get('end_date', date('Y-m-d'));

        $fileName = 'Laporan_Kas_' . date('d-m-Y', strtotime($startDate)) . '_sd_' . date('d-m-Y', strtotime($endDate)) . '.xlsx';

        return Excel::download(new LapKasExport($startDate, $endDate), $fileName);
    }
}