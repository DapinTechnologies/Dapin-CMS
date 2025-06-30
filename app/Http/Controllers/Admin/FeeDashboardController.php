<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\StudentEnroll;
use App\Models\Program;
use App\Models\Faculty;
use App\Models\Semester;
use Illuminate\Http\Request;
use DB;

class FeeDashboardController extends Controller
{
    protected $title = 'Fee Dashboard';
    protected $route = 'admin.fee-dashboard';
    protected $view = 'admin.fee-dashboard';

    public function __construct()
    {
        $this->middleware('permission:view fee dashboard')->only(['index']);
        $this->middleware('permission:send fee notifications')->only(['sendNotifications']);
    }

    /**
     * Display the fee dashboard
     */
    // In FeeDashboardController.php
public function index(Request $request)
{
    $data['title'] = $this->title;
    $data['route'] = $this->route;
    $data['view'] = $this->view;
    
    // Get filter options
    $data['faculties'] = Faculty::active()->get();
    $data['semesters'] = Semester::active()->get();

    // Apply filters
    $query = Invoice::with(['studentEnroll.student', 'studentEnroll.program.faculty'])
        ->select('invoices.*');
        
    if ($request->faculty) {
        $query->whereHas('studentEnroll.program', function($q) use ($request) {
            $q->where('faculty_id', $request->faculty);
        });
    }
    
    if ($request->semester) {
        $query->whereHas('studentEnroll', function($q) use ($request) {
            $q->where('semester_id', $request->semester);
        });
    }
    
    if ($request->start_date && $request->end_date) {
        $query->whereBetween('assign_date', [$request->start_date, $request->end_date]);
    }
    
    $data['invoices'] = $query->get();
    
    // Summary calculations
    $data['totalBilled'] = $data['invoices']->sum('total_fee');
    $data['totalPaid'] = $data['invoices']->sum('amount_paid');
    $data['outstanding'] = $data['invoices']->sum('amount_due');
    
    // Payment status data
    $data['paymentStatus'] = $data['invoices']->groupBy('payment_status')
        ->map(function($group) {
            return [
                'count' => $group->count(),
                'total_amount' => $group->sum('total_fee')
            ];
        });
        
    $data['collectionTrend'] = $data['invoices']->groupBy(function($item) {
            return $item->assign_date;
        })
        ->map(function($group, $key) {
            return [
                'month' => $key,
                'total_paid' => $group->sum('amount_paid')
            ];
        })
        ->sortBy('month')
        ->values();

    // Faculty invoices data - optimized query
    $data['facultyInvoices'] = Faculty::with(['programs.invoices'])
        ->when($request->faculty, function($query) use ($request) {
            $query->where('id', $request->faculty);
        })
        ->get()
        ->map(function($faculty) {
            $totalBilled = 0;
            $totalPaid = 0;
            
            foreach ($faculty->programs as $program) {
                $totalBilled += $program->invoices->sum('total_fee');
                $totalPaid += $program->invoices->sum('amount_paid');
            }
            
            return [
                'faculty' => $faculty->title,
                'billed' => $totalBilled,
                'paid' => $totalPaid,
                'outstanding' => $totalBilled - $totalPaid
            ];
        });

    return view($this->view.'.index', $data);
}

    /**
     * Get fee dashboard data via AJAX
     */
    public function getDashboardData(Request $request)
    {
        // Apply the same filters as index method
        $query = Invoice::query();
        
        if ($request->faculty) {
            $query->whereHas('studentEnroll.program', function($q) use ($request) {
                $q->where('faculty_id', $request->faculty);
            });
        }
        
        if ($request->semester) {
            $query->whereHas('studentEnroll', function($q) use ($request) {
                $q->where('semester_id', $request->semester);
            });
        }
        
        if ($request->start_date && $request->end_date) {
            $query->whereBetween('assign_date', [$request->start_date, $request->end_date]);
        }
        
        $invoices = $query->get();
        
        // Return data for AJAX requests using only invoices table data
        return response()->json([
            'totalBilled' => $invoices->sum('total_fee'),
            'totalPaid' => $invoices->sum('amount_paid'),
            'outstanding' => $invoices->sum('amount_due'),
            'paymentStatus' => $invoices->groupBy('payment_status')
                ->map(function($group) {
                    return [
                        'count' => $group->count(),
                        'total_amount' => $group->sum('total_fee')
                    ];
                }),
            'collectionTrend' => $invoices->groupBy(function($item) {
                    return $item->assign_date->format('Y-m');
                })
                ->map(function($group, $key) {
                    return [
                        'month' => $key,
                        'total_paid' => $group->sum('amount_paid')
                    ];
                })
                ->sortBy('month')
                ->values()
        ]);
    }

    /**
     * Send notifications to students with outstanding balances
     */
    /**
 * Send notifications to students with outstanding balances
 */
public function sendNotifications(Request $request)
{
    $request->validate([
        'due_date' => 'required|date|after_or_equal:today',
        'faculty' => 'sometimes|nullable|exists:faculties,id',
        'semester' => 'sometimes|nullable|exists:semesters,id',
        'start_date' => 'sometimes|nullable|date',
        'end_date' => 'sometimes|nullable|date|after_or_equal:start_date',
    ]);

    try {
        // Get invoices with outstanding balances
        $query = Invoice::with(['studentEnroll.student'])
            ->where('amount_due', '>', 0);

        if ($request->faculty) {
            $query->whereHas('studentEnroll.program', function($q) use ($request) {
                $q->where('faculty_id', $request->faculty);
            });
        }
        
        if ($request->semester) {
            $query->whereHas('studentEnroll', function($q) use ($request) {
                $q->where('semester_id', $request->semester);
            });
        }
        
        if ($request->start_date && $request->end_date) {
            $query->whereBetween('assign_date', [$request->start_date, $request->end_date]);
        }

        $invoices = $query->get();

        if ($invoices->isEmpty()) {
            return redirect()->back()
                ->with('error', 'No students with outstanding balances found matching the criteria.');
        }

        $successCount = 0;
        $failedCount = 0;

        foreach ($invoices as $invoice) {
            if ($invoice->studentEnroll && $invoice->studentEnroll->student) {
                try {
                    $this->sendStudentNotification(
                        $invoice->studentEnroll->student,
                        $invoice->amount_due,
                        $request->due_date
                    );
                    $successCount++;
                } catch (\Exception $e) {
                    \Log::error('Failed to send notification to student: ' . $invoice->studentEnroll->student->id, [
                        'error' => $e->getMessage()
                    ]);
                    $failedCount++;
                }
            }
        }

        $message = "Notifications sent successfully to {$successCount} students.";
        if ($failedCount > 0) {
            $message .= " Failed to send to {$failedCount} students.";
        }

        return redirect()->back()
            ->with('success', $message);

    } catch (\Exception $e) {
        return redirect()->back()
            ->with('error', 'Failed to send notifications: ' . $e->getMessage());
    }
}

/**
 * Send single notification to student
 */
public function sendSingleNotification(Request $request)
{
    $request->validate([
        'invoice_id' => 'required|exists:invoices,id',
        'due_date' => 'required|date|after_or_equal:today',
    ]);

    try {
        $invoice = Invoice::with(['studentEnroll.student'])
            ->findOrFail($request->invoice_id);

        if ($invoice->amount_due <= 0) {
            return redirect()->back()
                ->with('error', 'This invoice has no outstanding balance.');
        }

        if (!$invoice->studentEnroll || !$invoice->studentEnroll->student) {
            return redirect()->back()
                ->with('error', 'Student information not found for this invoice.');
        }

        $this->sendStudentNotification(
            $invoice->studentEnroll->student,
            $invoice->amount_due,
            $request->due_date
        );

        return redirect()->back()
            ->with('success', 'Notification sent successfully to student.');

    } catch (\Exception $e) {
        return redirect()->back()
            ->with('error', 'Failed to send notification: ' . $e->getMessage());
    }
}

    /**
     * Send SMS notification to student
     */
    protected function sendStudentNotification($student, $amount, $dueDate)
    {
        try {
            $apiUrl = 'https://smsportal.dapintechnologies.com/sms/v3/sendsms';
            $apiKey = '0CHxwhLRQ78MEFablqnsAtkgBNDjrJWou569KYpUd3eySPXT4ZOzv1cIiVG2mf';
            $serviceId = 0;
            $from = 'Dapin';

            $name = $student->first_name . ' ' . $student->last_name;
            $studentIdCode = $student->student_id;
            $formattedAmount = number_format($amount, 2);
            $formattedDueDate = \Carbon\Carbon::parse($dueDate)->format('d/m/Y');

            $message = "Dear {$name} ({$studentIdCode}), you have an outstanding fee balance of KES {$formattedAmount}. Please clear it by {$formattedDueDate} to avoid penalties. For any queries, contact the accounts office.";

            $payload = [
                'api_key' => $apiKey,
                'service_id' => $serviceId,
                'mobile' => $this->formatPhoneNumberForSms($student->phone),
                'response_type' => 'json',
                'shortcode' => $from,
                'message' => $message,
                'date_send' => now()->format('Y-m-d H:i:s'),
            ];

            $response = \Illuminate\Support\Facades\Http::withOptions(['verify' => false])
                ->post($apiUrl, $payload);

            \Log::info('SMS Notification Sent', [
                'student_id' => $student->id,
                'response' => $response->json()
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to send SMS notification', [
                'student_id' => $student->id,
                'error' => $e->getMessage()
            ]);
            throw $e; // Re-throw to be caught by the calling method
        }
    }

    /**
     * Format phone number for SMS
     */
    protected function formatPhoneNumberForSms($phone)
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);
        
        if (strpos($phone, '0') === 0) {
            return '254' . substr($phone, 1);
        } elseif (strpos($phone, '254') === 0) {
            return $phone;
        } elseif (strpos($phone, '+254') === 0) {
            return substr($phone, 1);
        }
        
        return $phone;
    }
}