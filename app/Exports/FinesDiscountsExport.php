<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class FinesDiscountsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $invoices;

    public function __construct($invoices)
    {
        $this->invoices = $invoices;
    }

    public function collection()
    {
        return $this->invoices;
    }

    public function headings(): array
    {
        return [
            'Invoice No',
            'Student ID',
            'Student Name',
            'Faculty',
            'Program',
            'Semester',
            'Total Fee',
            'Discount Amount',
            'Fine Amount',
            'Adjustment Type',
            'Notes',
            'Date'
        ];
    }

    public function map($invoice): array
    {
        return [
            $invoice->invoice_no,
            $invoice->student_id,
            $invoice->first_name . ' ' . $invoice->last_name,
            $invoice->faculty_title,
            $invoice->program_title,
            $invoice->semester_title,
            $invoice->total_fee,
            $invoice->discount_amount,
            $invoice->fine_amount,
            $invoice->adjustment_type ?? 'N/A',
            $invoice->adjustment_notes ?? 'N/A',
            $invoice->assign_date
        ];
    }
}