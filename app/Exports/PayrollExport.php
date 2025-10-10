<?php
// app/Exports/PayrollExport.php

namespace App\Exports;

use App\Models\PayrollRun;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PayrollExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $run;

    public function __construct(PayrollRun $run)
    {
        $this->run = $run;
    }

    public function collection()
    {
        return $this->run->entries()->with('user')->get();
    }

    public function headings(): array
    {
        return [
            'Staff ID',
            'Employee Name',
            'Basic Salary',
            'Allowances',
            'Gross Earnings',
            'NSSF Employee',
            'NHIF',
            'PAYE',
            'Other Deductions',
            'Total Deductions',
            'Net Pay',
            'Status'
        ];
    }

    public function map($entry): array
    {
        return [
            $entry->user->staff_id,
            $entry->user->first_name . ' ' . $entry->user->last_name,
            $entry->basic_salary,
            $entry->taxable_allowances + $entry->non_taxable_allowances,
            $entry->gross_earnings,
            $entry->nssf_employee,
            $entry->nhif,
            $entry->paye_net,
            $entry->other_deductions,
            $entry->total_deductions,
            $entry->net_pay,
            $entry->is_paid ? 'Paid' : 'Pending'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}