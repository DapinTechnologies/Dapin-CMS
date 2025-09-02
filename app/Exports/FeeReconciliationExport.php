<?php

namespace App\Exports;

use App\Models\Payment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class FeeReconciliationExport implements FromCollection, WithHeadings, WithMapping
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        return Payment::with(['invoice', 'studentEnroll.student', 'studentEnroll.program.faculty', 'studentEnroll.semester'])
            ->when($this->request->filled('payment_method'), function($query) {
                $query->where('payment_method', $this->request->payment_method);
            })
            ->when($this->request->filled('status'), function($query) {
                $query->where('status', $this->request->status);
            })
            ->when($this->request->filled('reconciled'), function($query) {
                if ($this->request->reconciled == 'yes') {
                    $query->where('is_reconciled', true);
                } else {
                    $query->where('is_reconciled', false);
                }
            })
            ->when($this->request->filled('faculty'), function($query) {
                $query->whereHas('studentEnroll.program', function($q) {
                    $q->where('faculty_id', $this->request->faculty);
                });
            })
            ->when($this->request->filled('program'), function($query) {
                $query->whereHas('studentEnroll', function($q) {
                    $q->where('program_id', $this->request->program);
                });
            })
            ->when($this->request->filled('semester'), function($query) {
                $query->whereHas('studentEnroll', function($q) {
                    $q->where('semester_id', $this->request->semester);
                });
            })
            ->when($this->request->filled('search'), function($query) {
                $query->where(function($q) {
                    $q->where('reference_number', 'like', '%'.$this->request->search.'%')
                      ->orWhere('transaction_id', 'like', '%'.$this->request->search.'%')
                      ->orWhereHas('studentEnroll.student', function($q) {
                          $q->where('name', 'like', '%'.$this->request->search.'%')
                            ->orWhere('student_id', 'like', '%'.$this->request->search.'%')
                            ->orWhere('email', 'like', '%'.$this->request->search.'%');
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
            'Semester',
            'Amount',
            'Payment Method',
            'Reference Number',
            'Transaction ID',
            'Payment Date',
            'Status',
            'Reconciled',
            'Reconciled By',
            'Reconciled At',
            'Reconciliation Notes',
            'Payment Type',
            'Confirmed By',
            'Confirmation Date'
        ];
    }

    public function map($payment): array
    {
        return [
            $payment->studentEnroll->student->student_id ?? 'N/A',
            $payment->studentEnroll->student->full_name ?? 'N/A',
            $payment->studentEnroll->program->faculty->title ?? 'N/A',
            $payment->studentEnroll->program->title ?? 'N/A',
            $payment->studentEnroll->semester_id ?? 'N/A',
            $payment->amount,
            strtoupper($payment->payment_method),
            $payment->reference_number,
            $payment->transaction_id,
            $payment->payment_date ? $payment->payment_date->format('Y-m-d H:i') : ($payment->created_at ? $payment->created_at->format('Y-m-d H:i') : 'N/A'),
            ucfirst($payment->status),
            $payment->is_reconciled ? 'Yes' : 'No',
            $payment->reconciled_by ?? 'N/A',
            $payment->reconciled_at ? $payment->reconciled_at->format('Y-m-d H:i') : 'N/A',
            $payment->reconciliation_notes ?? 'N/A',
            $payment->is_installment ? 'Installment #'.$payment->installment_number : 'Full Payment',
            $payment->confirmed_by ?? 'N/A',
            $payment->confirmation_date ? $payment->confirmation_date->format('Y-m-d H:i') : 'N/A'
        ];
    }
}