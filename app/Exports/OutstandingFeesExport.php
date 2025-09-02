<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class OutstandingFeesExport implements FromCollection, WithHeadings, WithMapping
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return collect($this->data);
    }

    public function headings(): array
    {
        return [
            'Faculty',
            'Program',
            'Semester',
            'Fee Category',
            'Amount Invoiced',
            'Outstanding Amount',
            'Percentage Remaining'
        ];
    }

    public function map($row): array
    {
        return [
            $row['faculty'],
            $row['program'],
            $row['semester'],
            $row['fee_category'],
            $row['amount_invoiced'],
            $row['outstanding_amount'],
            $row['percentage_remaining'] . '%'
        ];
    }
}