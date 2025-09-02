<?php

namespace App\Exports;

use App\Models\Payment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BursaryExport implements FromCollection, WithHeadings, WithMapping
{
    protected $bursaries;

    public function __construct($bursaries)
    {
        $this->bursaries = $bursaries;
    }

    public function collection()
    {
        return $this->bursaries;
    }

    public function headings(): array
    {
        return [
            'Student ID',
            'Student Name',
            'Faculty',
            'Program',
            'Semester',
            'Amount',
            'Bursary Type',
            'Payment Date',
            'Reconciled',
            'Notes'
        ];
    }

    public function map($bursary): array
    {
        return [
            $bursary->student_id,
            $bursary->first_name . ' ' . $bursary->last_name,
            $bursary->faculty_title,
            $bursary->program_title,
            $bursary->semester_title,
            $bursary->amount,
            $bursary->bursary_type ?? 'N/A',
            $bursary->paid_at,
            $bursary->is_reconciled ? 'Yes' : 'No',
            $bursary->bursary_notes ?? 'N/A'
        ];
    }
}