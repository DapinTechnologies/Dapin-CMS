<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExternalFeesExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $data;
    protected $categories;

    public function __construct($chartData, $categories)
    {
        $this->data = $chartData;
        $this->categories = $categories;
    }

    public function collection()
    {
        return collect($this->data['categoryAmounts']);
    }

    public function headings(): array
    {
        return [
            'Fee Category',
            'Type',
            'Amount',
            'Expected Total',
            'Collected Fee',
            'Balance',
            'Collection Rate'
        ];
    }

    public function map($categoryData): array
    {
        $category = $this->categories->find($categoryData['id'] ?? null);
        $balance = $categoryData['expected'] - $categoryData['collected'];
        $rate = $categoryData['expected'] > 0 ? ($categoryData['collected'] / $categoryData['expected']) * 100 : 0;

        return [
            $categoryData['name'],
            $category ? ucfirst($category->fee_type) : '',
            'KES ' . number_format($category ? $category->amount : 0, 2),
            'KES ' . number_format($categoryData['expected'], 2),
            'KES ' . number_format($categoryData['collected'], 2),
            'KES ' . number_format($balance, 2),
            number_format($rate, 2) . '%'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text
            1 => ['font' => ['bold' => true]],
        ];
    }
}