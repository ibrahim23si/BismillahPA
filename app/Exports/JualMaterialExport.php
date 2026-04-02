<?php

namespace App\Exports;

use App\Models\JualMaterial;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class JualMaterialExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle, WithEvents, ShouldAutoSize
{
    protected $startDate, $endDate, $rowNumber = 0;

    public function __construct($startDate, $endDate) { $this->startDate = $startDate; $this->endDate = $endDate; }

    public function collection()
    {
        return JualMaterial::whereBetween('tanggal', [$this->startDate, $this->endDate])
            ->orderBy('tanggal', 'asc')->orderBy('nomor_urut', 'asc')->get();
    }

    public function headings(): array
    {
        return ['No', 'No. Transaksi', 'Tanggal', 'No. Tiket', 'Nopol', 'Customer', 'Nama Barang', 'Gross (Ton)', 'Tara (Ton)', 'Netto (Ton)', 'Harga Satuan', 'Total Harga', 'Jenis Bayar', 'Status'];
    }

    public function map($row): array
    {
        $this->rowNumber++;
        return [
            $this->rowNumber,
            $row->nomor_transaksi,
            $row->tanggal->format('d/m/Y'),
            $row->nomor_tiket,
            $row->nopol,
            $row->nama_customer,
            $row->nama_barang,
            $row->gross,
            $row->tara,
            $row->netto,
            $row->harga_satuan > 0 ? $row->harga_satuan : '',
            $row->total_harga > 0 ? $row->total_harga : '',
            ucfirst($row->jenis_bayar),
            ucfirst($row->status),
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [1 => ['font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 11], 'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '2563EB']], 'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]]];
    }

    public function title(): string { return 'Jual Material'; }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $lastRow = $sheet->getHighestRow(); $lastCol = 'N';
                $sheet->getStyle("A1:{$lastCol}{$lastRow}")->applyFromArray(['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'D1D5DB']]]]);
                $sheet->getStyle("H2:J{$lastRow}")->getNumberFormat()->setFormatCode('#,##0.00');
                $sheet->getStyle("K2:L{$lastRow}")->getNumberFormat()->setFormatCode('#,##0');
                $sheet->getStyle("A2:A{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle("C2:C{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle("M2:N{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                for ($row = 2; $row <= $lastRow; $row++) { if ($row % 2 === 0) { $sheet->getStyle("A{$row}:{$lastCol}{$row}")->applyFromArray(['fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'F3F4F6']]]); } }
                $sheet->insertNewRowBefore(1, 3);
                $sheet->setCellValue('A1', 'DATA JUAL MATERIAL'); $sheet->mergeCells("A1:{$lastCol}1");
                $sheet->getStyle('A1')->applyFromArray(['font' => ['bold' => true, 'size' => 16, 'color' => ['rgb' => '1F2937']], 'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]]);
                $sheet->getRowDimension(1)->setRowHeight(30);
                $sheet->setCellValue('A2', 'Periode: ' . \Carbon\Carbon::parse($this->startDate)->format('d/m/Y') . ' - ' . \Carbon\Carbon::parse($this->endDate)->format('d/m/Y'));
                $sheet->mergeCells("A2:{$lastCol}2");
                $sheet->getStyle('A2')->applyFromArray(['font' => ['italic' => true, 'size' => 11, 'color' => ['rgb' => '6B7280']], 'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]]);
                $sheet->getRowDimension(3)->setRowHeight(8); $sheet->freezePane('A5');
            },
        ];
    }
}
