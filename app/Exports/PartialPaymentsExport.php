<?php

namespace App\Exports;

use App\Models\Payment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PartialPaymentsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $filters;

    public function __construct(array $filters)
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = Payment::with([
                'studentEnroll.student', 
                'studentEnroll.program.faculty', 
                'studentEnroll.semester',
                'invoice'
            ])
            ->where('status', 'partial');

        // Apply filters
        if (!empty($this->filters['faculty'])) {
            $query->whereHas('studentEnroll.program', function($q) {
                $q->where('faculty_id', $this->filters['faculty']);
            });
        }
        
        if (!empty($this->filters['program'])) {
            $query->whereHas('studentEnroll', function($q) {
                $q->where('program_id', $this->filters['program']);
            });
        }
        
        if (!empty($this->filters['semester'])) {
            $query->whereHas('studentEnroll', function($q) {
                $q->where('semester_id', $this->filters['semester']);
            });
        }
        
        if (!empty($this->filters['search'])) {
            $query->whereHas('studentEnroll.student', function($q) {
                $q->where('student_id', 'like', '%'.$this->filters['search'].'%')
                  ->orWhere('first_name', 'like', '%'.$this->filters['search'].'%')
                  ->orWhere('last_name', 'like', '%'.$this->filters['search'].'%');
            });
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            '#',
            'Student ID',
            'Student Name',
            'Program',
            'Faculty',
            'Semester',
            'Invoice No',
            'Amount Paid',
            'Payment Method',
            'Reference Number',
            'Transaction ID',
            'Payment Date',
            'Status'
        ];
    }

    public function map($payment): array
    {
        static $i = 1;
        
        return [
            $i++,
            $payment->studentEnroll->student->student_id ?? '',
            ($payment->studentEnroll->student ? 
                $payment->studentEnroll->student->first_name.' '.$payment->studentEnroll->student->last_name : ''),
            $payment->studentEnroll->program->title ?? '',
            $payment->studentEnroll->program->faculty->title ?? '',
            $payment->studentEnroll->semester->title ?? '',
            $payment->invoice->invoice_no ?? 'N/A',
            number_format($payment->amount, 2),
            $payment->payment_method ?? 'N/A',
            $payment->reference_number ?? 'N/A',
            $payment->transaction_id ?? 'N/A',
            $payment->paid_at ? date('d M, Y', strtotime($payment->paid_at)) : 'N/A',
            'Partial Payment'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text
            1 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => ['argb' => 'FFD9D9D9']
                ]
            ],
            // Set alignment for all cells
            'A:L' => [
                'alignment' => [
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
            ],
        ];
    }
}