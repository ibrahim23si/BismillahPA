<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UmLembur;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class UmLemburController extends Controller
{
    /**
     * Display a listing of um lembur.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = UmLembur::with('creator')
                ->select('um_lemburs.*')
                ->orderBy('periode', 'desc')
                ->orderBy('nama', 'asc');
                
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('periode', function($row) {
                    return $row->periode->format('F Y');
                })
                ->editColumn('total_jam', function($row) {
                    return number_format($row->total_jam, 2) . ' jam';
                })
                ->editColumn('total_upah', function($row) {
                    return Helper::formatRupiah($row->total_upah);
                })
                ->editColumn('created_at', function($row) {
                    return $row->created_at->format('d/m/Y H:i');
                })
                ->addColumn('action', function($row) {
                    $btn = '<a href="'.route('admin.um-lembur.edit', $row->id).'" class="inline-flex items-center px-3 py-1 bg-blue-500 text-white text-sm rounded-md hover:bg-blue-600 mr-1">Edit</a>';
                    $btn .= '<button onclick="deleteData('.$row->id.')" class="inline-flex items-center px-3 py-1 bg-red-500 text-white text-sm rounded-md hover:bg-red-600">Hapus</button>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        
        return view('admin.um-lembur.index');
    }

    /**
     * Show form for creating new um lembur.
     */
    public function create()
    {
        // Daftar karyawan tetap (bisa diambil dari database atau hardcoded)
        $karyawan = [
            ['nama' => 'TONGHUI', 'jabatan' => 'MP'],
            ['nama' => 'ROPINA', 'jabatan' => 'Admin'],
            ['nama' => 'REZA PAHLEPI', 'jabatan' => 'Timbangan'],
            ['nama' => 'SENDI PRANATA', 'jabatan' => 'Security'],
            ['nama' => 'WALMUDJRI', 'jabatan' => 'Security'],
            ['nama' => 'JOKO', 'jabatan' => 'Umum'],
            ['nama' => 'IIP SUPRIATNA', 'jabatan' => 'Ayakan'],
            ['nama' => 'MARDIUS', 'jabatan' => 'PRIMARY'],
            ['nama' => 'AMLIANTO', 'jabatan' => 'Helper Primary'],
            ['nama' => 'AGUS SURYA', 'jabatan' => 'Electrik'],
            ['nama' => 'PEKI SAPUTRA', 'jabatan' => 'Helper 1'],
            ['nama' => 'ROPIONAL', 'jabatan' => 'Helper 2'],
            ['nama' => 'ZULMAN', 'jabatan' => 'Helper 3'],
            ['nama' => 'BAYU', 'jabatan' => 'Welder'],
            ['nama' => 'HERU GUNAWAN', 'jabatan' => 'Welder'],
            ['nama' => 'DEDEN AHYUDIN', 'jabatan' => 'Welder'],
        ];
        
        return view('admin.um-lembur.create', compact('karyawan'));
    }

    /**
     * Store a newly created um lembur.
     */
    public function store(Request $request)
    {
        $request->validate([
            'periode' => 'required|date',
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'upah_per_jam' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string|max:500',
        ]);

        // Validasi untuk hari 1-31
        for ($i = 1; $i <= 31; $i++) {
            $hari = 'hari_' . $i;
            $request->validate([
                $hari => 'nullable|numeric|min:0|max:24',
            ]);
        }

        try {
            $data = $request->all();
            $data['created_by'] = auth()->id();
            
            // Set default 0 untuk hari yang tidak diisi
            for ($i = 1; $i <= 31; $i++) {
                $hari = 'hari_' . $i;
                if (!isset($data[$hari]) || $data[$hari] === '') {
                    $data[$hari] = 0;
                }
            }
            
            UmLembur::create($data);
            
            return redirect()->route('admin.um-lembur.index')
                ->with('success', 'Data UM & Lembur berhasil ditambahkan.');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Show form for editing um lembur.
     */
    public function edit($id)
    {
        $umLembur = UmLembur::findOrFail($id);
        return view('admin.um-lembur.edit', compact('umLembur'));
    }

    /**
     * Update um lembur.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'periode' => 'required|date',
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'upah_per_jam' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string|max:500',
        ]);

        // Validasi untuk hari 1-31
        for ($i = 1; $i <= 31; $i++) {
            $hari = 'hari_' . $i;
            $request->validate([
                $hari => 'nullable|numeric|min:0|max:24',
            ]);
        }

        try {
            $umLembur = UmLembur::findOrFail($id);
            
            $data = $request->all();
            
            // Set default 0 untuk hari yang tidak diisi
            for ($i = 1; $i <= 31; $i++) {
                $hari = 'hari_' . $i;
                if (!isset($data[$hari]) || $data[$hari] === '') {
                    $data[$hari] = 0;
                }
            }
            
            $umLembur->update($data);
            
            return redirect()->route('admin.um-lembur.index')
                ->with('success', 'Data UM & Lembur berhasil diupdate.');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Delete um lembur.
     */
    public function destroy($id)
    {
        try {
            $umLembur = UmLembur::findOrFail($id);
            $umLembur->delete();
            
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

    /**
     * Generate data for a new month (copy from previous month or create empty)
     */
    public function generate(Request $request)
    {
        $request->validate([
            'periode' => 'required|date',
        ]);

        try {
            $periode = Carbon::parse($request->periode);
            $bulan = $periode->format('Y-m');
            
            // Cek apakah sudah ada data untuk periode ini
            $existing = UmLembur::whereYear('periode', $periode->year)
                ->whereMonth('periode', $periode->month)
                ->exists();
                
            if ($existing) {
                return redirect()->route('admin.um-lembur.index')
                    ->with('warning', 'Data untuk periode ' . $periode->format('F Y') . ' sudah ada.');
            }
            
            // Ambil data dari bulan sebelumnya sebagai template
            $previousPeriode = Carbon::parse($periode)->subMonth();
            $previousData = UmLembur::whereYear('periode', $previousPeriode->year)
                ->whereMonth('periode', $previousPeriode->month)
                ->get();
                
            if ($previousData->isNotEmpty()) {
                // Copy data dari bulan sebelumnya
                foreach ($previousData as $data) {
                    $newData = $data->replicate();
                    $newData->periode = $periode->startOfMonth()->format('Y-m-d');
                    $newData->created_by = auth()->id();
                    
                    // Reset jam lembur
                    for ($i = 1; $i <= 31; $i++) {
                        $hari = 'hari_' . $i;
                        $newData->$hari = 0;
                    }
                    
                    $newData->total_jam = 0;
                    $newData->total_upah = 0;
                    $newData->save();
                }
                
                return redirect()->route('admin.um-lembur.index')
                    ->with('success', 'Data untuk periode ' . $periode->format('F Y') . ' berhasil digenerate dari bulan sebelumnya.');
            } else {
                return redirect()->route('admin.um-lembur.create', ['periode' => $periode->format('Y-m-d')])
                    ->with('info', 'Tidak ada data bulan sebelumnya. Silakan input manual.');
            }
            
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}