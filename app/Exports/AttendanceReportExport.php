<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AttendanceReportExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{
    protected $exportData;

    public function __construct($exportData)
    {
        $this->exportData = $exportData;
    }

    public function collection()
    {
        return collect($this->exportData);
    }

    public function headings(): array
    {
        // We don't need to define headings separately as they're included in $exportData
        return [];
    }

    public function styles(Worksheet $sheet)
    {
        $lastRow = count($this->exportData);
        $lastColumn = 'E'; // Assuming you have 5 columns (A to E)

        return [
            // Style the report title
            1 => ['font' => ['bold' => true, 'size' => 14]],
            
            // Style the summary rows
            '2:3' => ['font' => ['bold' => true]],
            
            // Style the main data header row
            5 => ['font' => ['bold' => true]],
            
            // Add borders to all cells
            'A1:' . $lastColumn . $lastRow => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => '000000'],
                    ],
                ],
            ],
        ];
    }
}