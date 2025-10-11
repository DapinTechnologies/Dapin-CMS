<?php

namespace App\Exports;

use App\Models\Invoice;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class DefaultersExport implements FromCollection, WithHeadings, WithMapping
{
    protected $filters;

    public function __construct($filters)
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = Invoice::with([
                'studentEnroll.student', 
                'studentEnroll.program.faculty', 
                'studentEnroll.semester'
            ])
            ->where('payment_status', 'unpaid')
            ->where('amount_due', '>', 0);

        if ($this->filters['faculty']) {
            $query->whereHas('studentEnroll.program', function($q) {
                $q->where('faculty_id', $this->filters['faculty']);
            });
        }
        
        if ($this->filters['program']) {
            $query->whereHas('studentEnroll', function($q) {
                $q->where('program_id', $this->filters['program']);
            });
        }
        
        if ($this->filters['semester']) {
            $query->whereHas('studentEnroll', function($q) {
                $q->where('semester_id', $this->filters['semester']);
            });
        }
        
        if ($this->filters['search']) {
            $query->whereHas('studentEnroll.student', function($q) {
                $q->where('student_id', 'like', '%'.$this->filters['search'].'%')
                  ->orWhere('first_name', 'like', '%'.$this->filters['search'].'%')
                  ->orWhere('last_name', 'like', '%'.$this->filters['search'].'%');
            });
        }

        return $query->orderBy('due_date', 'asc')->get();
    }

    public function headings(): array
    {
        return [
            'Student ID',
            'Student Name',
            'Faculty',
            'Program',
            'Semester',
            'Invoice No',
            'Total Fee',
            'Amount Paid',
            'Amount Due',
            'Due Date',
            'Status'
        ];
    }

    public function map($invoice): array
    {
        return [
            $invoice->studentEnroll->student->student_id ?? '',
            ($invoice->studentEnroll->student->first_name ?? '') . ' ' . ($invoice->studentEnroll->student->last_name ?? ''),
            $invoice->studentEnroll->program->faculty->title ?? '',
            $invoice->studentEnroll->program->title ?? '',
            $invoice->studentEnroll->semester->title ?? '',
            $invoice->invoice_no,
            $invoice->total_fee,
            $invoice->amount_paid,
            $invoice->amount_due,
            $invoice->due_date,
            'Unpaid'
        ];
    }
}