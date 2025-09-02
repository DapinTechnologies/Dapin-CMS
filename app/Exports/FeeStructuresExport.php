<?php

namespace App\Exports;

use App\Models\FeeStructure;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class FeeStructuresExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Faculty',
            'Program',
            'Semester',
            'Fee Categories',
            'Total Amount',
            'Created At',
            'Updated At'
        ];
    }

    public function map($feeStructure): array
    {
        $categories = $feeStructure->items->map(function($item) {
            return $item->fee_category_title . ' (KES ' . number_format($item->amount, 2) . ')';
        })->implode(', ');

        return [
            $feeStructure->id,
            $feeStructure->faculty->title ?? 'N/A',
            $feeStructure->program->title ?? 'N/A',
            $feeStructure->semester,
            $categories,
            'KES ' . number_format($feeStructure->total_amount, 2),
            $feeStructure->created_at->format('d/m/Y H:i'),
            $feeStructure->updated_at->format('d/m/Y H:i')
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text
            1 => ['font' => ['bold' => true]],
            
            // Set column widths
            'A' => ['width' => 10],
            'B' => ['width' => 25],
            'C' => ['width' => 25],
            'D' => ['width' => 15],
            'E' => ['width' => 40],
            'F' => ['width' => 15],
            'G' => ['width' => 20],
            'H' => ['width' => 20],
        ];
    }

    public function title(): string
    {
        return 'Fee Structures';
    }
}