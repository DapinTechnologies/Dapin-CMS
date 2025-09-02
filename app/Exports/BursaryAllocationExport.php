<?php

namespace App\Exports;

use App\Models\Payment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BursaryAllocationExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $filters;

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        return Payment::with(['invoice', 'studentEnroll.student', 'studentEnroll.program.faculty'])
            ->where('is_bursary', 1)
            ->when(isset($this->filters['bursary_type']), function($query) {
                $query->where('bursary_type', $this->filters['bursary_type']);
            })
            ->when(isset($this->filters['faculty']), function($query) {
                $query->whereHas('studentEnroll.program', function($q) {
                    $q->where('faculty_id', $this->filters['faculty']);
                });
            })
            ->when(isset($this->filters['program']), function($query) {
                $query->whereHas('studentEnroll', function($q) {
                    $q->where('program_id', $this->filters['program']);
                });
            })
            ->when(isset($this->filters['search']), function($query) {
                $query->where(function($q) {
                    $q->where('reference_number', 'like', '%'.$this->filters['search'].'%')
                      ->orWhereHas('studentEnroll.student', function($q) {
                          $q->where('name', 'like', '%'.$this->filters['search'].'%')
                            ->orWhere('student_id', 'like', '%'.$this->filters['search'].'%');
                      });
                });
            })
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Student ID',
            'Student Name',
            'Faculty',
            'Program',
            'Invoice Number',
            'Amount',
            'Excess Amount',
            'Bursary Type',
            'Allocated Date',
            'Allocated By',
            'Reconciliation Status',
            'Reconciled By',
            'Reconciled Date',
            'Notes'
        ];
    }

    public function map($payment): array
    {
        return [
            $payment->studentEnroll->student->student_id ?? 'N/A',
            $payment->studentEnroll->student->full_name ?? 'N/A',
            $payment->studentEnroll->program->faculty->title ?? 'N/A',
            $payment->studentEnroll->program->title ?? 'N/A',
            $payment->invoice->invoice_no ?? 'N/A',
            $payment->amount,
            $payment->excess_payment,
            $payment->bursary_type,
            $payment->bursary_allocated_at ? $payment->bursary_allocated_at->format('d M Y H:i') : 'N/A',
            $payment->bursary_allocated_by ?? 'System',
            $payment->is_reconciled === 1 ? 'Completed' : ($payment->is_reconciled === 2 ? 'To Check' : 'Pending'),
            $payment->reconciled_by ?? 'N/A',
            $payment->reconciled_at ? $payment->reconciled_at->format('d M Y H:i') : 'N/A',
            $payment->bursary_notes ?? ''
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}