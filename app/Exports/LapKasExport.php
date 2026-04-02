<?php

namespace App\Exports;

use App\Models\LapKas;
use App\Helpers\Helper;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class LapKasExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths, WithTitle, WithEvents, ShouldAutoSize
{
    protected $startDate;
    protected $endDate;
    protected $rowNumber = 0;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    /**
     * Query data laporan kas
     */
    public function collection()
    {
        return LapKas::whereBetween('tanggal', [$this->startDate, $this->endDate])
            ->orderBy('tanggal', 'asc')
            ->orderBy('id', 'asc')
            ->get();
    }

    /**
     * Header kolom
     */
    public function headings(): array
    {
        return [
            'No',
            'Tanggal',
            'No. Bukti',
            'Keterangan',
            'Debet (Masuk)',
            'Kredit (Keluar)',
            'Saldo',
        ];
    }

    /**
     * Mapping data per baris
     */
    public function map($row): array
    {
        $this->rowNumber++;

        return [
            $this->rowNumber,
            $row->tanggal->format('d/m/Y'),
            $row->nomor_bukti,
            $row->keterangan,
            $row->debet > 0 ? $row->debet : '',
            $row->kredit > 0 ? $row->kredit : '',
            $row->saldo,
        ];
    }

    /**
     * Style untuk worksheet
     */
    public function styles(Worksheet $sheet): array
    {
        return [
            // Header row bold
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 11],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '2563EB'],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ],
        ];
    }

    /**
     * Lebar kolom
     */
    public function columnWidths(): array
    {
        return [
            'A' => 6,
            'B' => 14,
            'C' => 20,
            'D' => 45,
            'E' => 18,
            'F' => 18,
            'G' => 20,
        ];
    }

    /**
     * Nama sheet
     */
    public function title(): string
    {
        return 'Laporan Kas';
    }

    /**
     * Events untuk styling tambahan
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $lastRow = $sheet->getHighestRow();
                $lastCol = 'G';

                // Border untuk semua data
                $sheet->getStyle("A1:{$lastCol}{$lastRow}")->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['rgb' => 'D1D5DB'],
                        ],
                    ],
                ]);

                // Alignment untuk kolom angka (rata kanan)
                $sheet->getStyle("E2:G{$lastRow}")->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_RIGHT);

                // Format angka dengan separator ribuan
                $sheet->getStyle("E2:G{$lastRow}")->getNumberFormat()
                    ->setFormatCode('#,##0');

                // Alignment center untuk No dan Tanggal
                $sheet->getStyle("A2:B{$lastRow}")->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER);

                // Alternating row colors
                for ($row = 2; $row <= $lastRow; $row++) {
                    if ($row % 2 === 0) {
                        $sheet->getStyle("A{$row}:{$lastCol}{$row}")->applyFromArray([
                            'fill' => [
                                'fillType' => Fill::FILL_SOLID,
                                'startColor' => ['rgb' => 'F3F4F6'],
                            ],
                        ]);
                    }
                }

                // Baris total di paling bawah
                $totalRow = $lastRow + 1;
                $sheet->setCellValue("D{$totalRow}", 'TOTAL');
                $sheet->setCellValue("E{$totalRow}", "=SUM(E2:E{$lastRow})");
                $sheet->setCellValue("F{$totalRow}", "=SUM(F2:F{$lastRow})");

                // Style total row
                $sheet->getStyle("A{$totalRow}:{$lastCol}{$totalRow}")->applyFromArray([
                    'font' => ['bold' => true, 'size' => 11],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'DBEAFE'],
                    ],
                    'borders' => [
                        'top' => [
                            'borderStyle' => Border::BORDER_MEDIUM,
                            'color' => ['rgb' => '2563EB'],
                        ],
                        'bottom' => [
                            'borderStyle' => Border::BORDER_MEDIUM,
                            'color' => ['rgb' => '2563EB'],
                        ],
                    ],
                ]);

                $sheet->getStyle("D{$totalRow}")->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_RIGHT);
                $sheet->getStyle("E{$totalRow}:G{$totalRow}")->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_RIGHT);
                $sheet->getStyle("E{$totalRow}:G{$totalRow}")->getNumberFormat()
                    ->setFormatCode('#,##0');

                // Header row height
                $sheet->getRowDimension(1)->setRowHeight(25);

                // Freeze first row
                $sheet->freezePane('A2');

                // Title rows (insert before data)
                $sheet->insertNewRowBefore(1, 3);

                // Title
                $sheet->setCellValue('A1', 'LAPORAN KAS');
                $sheet->mergeCells('A1:G1');
                $sheet->getStyle('A1')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 16, 'color' => ['rgb' => '1F2937']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);
                $sheet->getRowDimension(1)->setRowHeight(30);

                // Period
                $period = 'Periode: ' . \Carbon\Carbon::parse($this->startDate)->format('d/m/Y') . ' - ' . \Carbon\Carbon::parse($this->endDate)->format('d/m/Y');
                $sheet->setCellValue('A2', $period);
                $sheet->mergeCells('A2:G2');
                $sheet->getStyle('A2')->applyFromArray([
                    'font' => ['italic' => true, 'size' => 11, 'color' => ['rgb' => '6B7280']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);
                $sheet->getRowDimension(2)->setRowHeight(22);

                // Empty row separator
                $sheet->getRowDimension(3)->setRowHeight(8);
            },
        ];
    }
}
