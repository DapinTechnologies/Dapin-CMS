<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faculty;
use App\Models\Program;
use App\Models\Semester;
use App\Models\FeeStructure;
use App\Models\FeeStructureItem;
use App\Models\StudentEnrollment;
use App\Models\Invoice;
use App\Models\Fee;
use App\Models\InvoiceItem;
use App\Models\AcademicYear;
use App\Exports\FeeStructuresExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Student;
use App\Models\StudentEnroll;
use App\Models\FeesCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class FeeStructureController extends Controller
{
    protected $title = 'Fee Structure';
    protected $route = 'admin.fee-structures';
    protected $view = 'admin.fee-structures';

    public function __construct()
    {
        $this->middleware('permission:view fee structures')->only(['index', 'show']);
        $this->middleware('permission:create fee structures')->only(['create', 'store']);
        $this->middleware('permission:edit fee structures')->only(['edit', 'update']);
        $this->middleware('permission:delete fee structures')->only(['destroy']);
        $this->middleware('permission:manage fee items')->only(['addItem', 'removeItem']);
        $this->middleware('permission:batch assign fee structures')->only(['previewBatchAssign', 'batchAssign']);
    }
    
    public function index(Request $request)
    {
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;

        // Filter Parameters
        $data['selected_faculty'] = $request->faculty ?? '0';
        $data['selected_program'] = $request->program ?? '0';
        $data['selected_semester'] = $request->semester ?? '0';
        $data['selected_category'] = $request->category ?? '0';

        // Search Query with eager loading
        $query = FeeStructure::with(['faculty', 'program', 'items.category'])
            ->when($request->faculty, function($q) use ($request) {
                $q->where('faculty_id', $request->faculty);
            })
            ->when($request->program, function($q) use ($request) {
                $q->where('program_id', $request->program);
            })
            ->when($request->semester, function($q) use ($request) {
                $q->where('semester', $request->semester);
            })
            ->when($request->category, function($q) use ($request) {
                $q->whereHas('items', function($query) use ($request) {
                    $query->where('fees_category_id', $request->category);
                });
            });

        $data['feeStructures'] = $query->paginate(10);

        // Filter Data
        $data['faculties'] = Faculty::where('status', '1')->orderBy('title', 'asc')->get();
        $data['programs'] = Program::where('status', '1')->orderBy('title', 'asc')->get();
        $data['semesters'] = Semester::where('status', '1')->orderBy('title', 'asc')->get();
        $data['categories'] = FeesCategory::where('status', '1')
            ->orderBy('title', 'asc')
            ->get();

        return view($this->view.'.index', $data);
    }

    public function create()
{
    $data['title'] = $this->title;
    $data['route'] = $this->route;
    $data['view'] = $this->view;

    $data['faculties'] = Faculty::where('status', '1')->orderBy('title', 'asc')->get();
    $data['programs'] = Program::where('status', '1')->orderBy('title', 'asc')->get();
    $data['semesters'] = Semester::where('status', '1')->orderBy('title', 'asc')->get();
    $data['categories'] = FeesCategory::where('status', '1')
        ->orderBy('title', 'asc')
        ->get();

    return view($this->view.'.create', $data);
}

public function store(Request $request)
{
    $validated = $this->validateRequest($request);
    
    DB::transaction(function () use ($validated, $request) {
        $feeStructure = $this->createFeeStructure($validated);
        $categories = $this->getSelectedCategories($validated['fee_categories']);
        $totalAmount = $this->createFeeStructureItems($feeStructure, $categories, $request);
        
        if ($request->assign_to_students) {
            $this->processStudentInvoices($validated, $categories, $totalAmount, $request);
        }
    });

    return redirect()
        ->route($this->route.'.index')
        ->with('success', 'Fee structure created successfully.');
}

/**
 * Validate the incoming request
 */
protected function validateRequest(Request $request)
{
    return $request->validate([
        'faculty_id' => 'required|exists:faculties,id',
        'program_id' => 'required|exists:programs,id',
        'semester' => 'required|string',
        'fee_categories' => 'required|array',
        'fee_categories.*' => 'exists:fees_categories,id',
        'assign_to_students' => 'sometimes|boolean',
        'due_date' => 'required_if:assign_to_students,1|nullable|date|after_or_equal:today',
        'send_invoices' => 'sometimes|boolean',
        'notify_students' => 'sometimes|boolean',
    ]);
}

/**
 * Create the base fee structure
 */
protected function createFeeStructure(array $validated)
{
    return FeeStructure::create([
        'faculty_id' => $validated['faculty_id'],
        'program_id' => $validated['program_id'],
        'semester' => $validated['semester'],
        'total_amount' => 0,
    ]);
}

/**
 * Get selected fee categories
 */
protected function getSelectedCategories(array $categoryIds)
{
    return FeesCategory::whereIn('id', $categoryIds)->get();
}

/**
 * Create fee structure items and calculate total amount
 */
protected function createFeeStructureItems($feeStructure, $categories, Request $request)
{
    $totalAmount = 0;
    
    foreach ($categories as $category) {
        $feeStructure->items()->create([
            'fees_category_id' => $category->id,
            'fee_category_title' => $category->title,
            'fee_category_slug' => $category->slug,
            'fee_category_description' => $category->description,
            'amount' => $category->amount,
            'is_one_time' => $request->input('one_time.'.$category->id, false),
        ]);
        $totalAmount += $category->amount;
    }

    $feeStructure->update(['total_amount' => $totalAmount]);
    
    return $totalAmount;
}

/**
 * Process invoices for all enrolled students
 */
protected function processStudentInvoices($validated, $categories, $totalAmount, $request)
{
    $enrollments = $this->getEnrolledStudents(
        $validated['faculty_id'],
        $validated['program_id'],
        $validated['semester']
    );

    if ($enrollments->isEmpty()) {
        throw new \Exception("No enrolled students found for the selected criteria.");
    }

    foreach ($enrollments as $enrollment) {
        $invoice = $this->createStudentInvoice($enrollment, $totalAmount, $validated['due_date']);
        $this->createFeeRecords($invoice, $enrollment, $categories, $validated['due_date']);
        
        if ($request->notify_students && $enrollment->student) {
            $this->sendStudentNotification($enrollment->student, $totalAmount, $validated['due_date']);
        }
    }
}

/**
 * Get enrolled students for given criteria
 */
protected function getEnrolledStudents($facultyId, $programId, $semester)
{
    // First get the semester ID if we have a title
    $semesterModel = Semester::where('title', $semester)
        ->orWhere('id', $semester)
        ->first();

    if (!$semesterModel) {
        return collect(); // Return empty collection if semester doesn't exist
    }

    return StudentEnroll::where('program_id', $programId)
        ->where('semester_id', $semesterModel->id)
        ->where('status', '1')
        ->whereHas('program', function($q) use ($facultyId) {
            $q->where('faculty_id', $facultyId);
        })
        ->with('student')
        ->get();
}

/**
 * Create an invoice for a student
 */
protected function createStudentInvoice($enrollment, $totalAmount, $dueDate)
{
    $invoiceNo = $this->generateInvoiceNumber();
    
    return Invoice::create([
        'student_enroll_id' => $enrollment->id,
        'invoice_no' => $invoiceNo,
        'total_fee' => $totalAmount,
        'amount_due' => $totalAmount,
        'amount_paid' => 0,
        'payment_status' => 'pending',
        'assign_date' => now(),
        'due_date' => $dueDate,
    ]);
}

/**
 * Generate the next invoice number
 */
protected function generateInvoiceNumber()
{
    $lastInvoice = Invoice::orderBy('id', 'desc')->first();
    return $lastInvoice 
        ? 'INV-' . str_pad((int)str_replace('INV-', '', $lastInvoice->invoice_no) + 1, 3, '0', STR_PAD_LEFT)
        : 'INV-001';
}

/**
 * Create fee records for an invoice
 */
protected function createFeeRecords($invoice, $enrollment, $categories, $dueDate)
{
    foreach ($categories as $category) {
        Fee::create([
            'invoice_id' => $invoice->id,
            'student_enroll_id' => $enrollment->id,
            'category_id' => $category->id,
            'amount' => $category->amount,
            'assign_date' => now(),
            'due_date' => $dueDate,
            'created_by' => auth()->id(),
        ]);
    }
}

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

        $message = "Dear {$name} ({$studentIdCode}), a school fee of KES {$formattedAmount} has been invoiced to your account. Please clear it by {$formattedDueDate}. For any queries, contact the accounts office.";

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
    }
}

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

public function sendInvoice(FeeStructure $feeStructure, Request $request)
{
    $request->validate([
        'due_date' => 'required|date|after_or_equal:today',
        'send_sms' => 'sometimes|boolean',
        'send_email' => 'sometimes|boolean'
    ]);

    try {
        DB::beginTransaction();

        $enrollments = $this->getEnrolledStudents(
            $feeStructure->faculty_id,
            $feeStructure->program_id,
            $feeStructure->semester
        );

        if ($enrollments->isEmpty()) {
            throw new \Exception("No enrolled students found matching this fee structure criteria.");
        }

        $categories = $feeStructure->items->map(function($item) {
            return (object)[
                'id' => $item->fees_category_id,
                'title' => $item->fee_category_title,
                'amount' => $item->amount
            ];
        });

        $totalAmount = $feeStructure->items->sum('amount');
        $invoiceCount = 0;

        foreach ($enrollments as $enrollment) {
            $existingInvoice = Invoice::where('student_enroll_id', $enrollment->id)
                ->whereHas('fees', function($q) use ($feeStructure) {
                    $q->whereIn('category_id', $feeStructure->items->pluck('fees_category_id'));
                })
                ->first();

            if (!$existingInvoice) {
                $invoice = $this->createStudentInvoice($enrollment, $totalAmount, $request->due_date);
                $this->createFeeRecords($invoice, $enrollment, $categories, $request->due_date);
                
                if ($enrollment->student) {
                    if ($request->send_sms) {
                        $this->sendStudentNotification($enrollment->student, $totalAmount, $request->due_date);
                    }
                    if ($request->send_email) {
                        // Add your email sending logic here
                    }
                }
                $invoiceCount++;
            }
        }

        DB::commit();

        return redirect()->back()
            ->with('success', "Successfully created $invoiceCount invoices for enrolled students");

    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()
            ->with('error', 'Failed to send invoices: ' . $e->getMessage());
    }
}

public function estimateStudents(Request $request)
{
    $validated = $request->validate([
        'faculty_id' => 'required|exists:faculties,id',
        'program_id' => 'required|exists:programs,id',
        'semester' => 'required|string'
    ]);

    $count = StudentEnroll::where('program_id', $validated['program_id'])
        ->where('semester_id', $validated['semester'])
        ->where('status', '1')
        ->count();

    $total = $count * FeesCategory::whereIn('id', $request->input('fee_categories', []))
        ->sum('amount');

    return response()->json([
        'count' => $count,
        'total' => $total
    ]);
}


    public function edit(FeeStructure $feeStructure)
    {
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;

        $data['feeStructure'] = $feeStructure->load(['items.category']);
        $data['faculties'] = Faculty::where('status', '1')->orderBy('title', 'asc')->get();
        $data['programs'] = Program::where('status', '1')->orderBy('title', 'asc')->get();
        $data['semesters'] = Semester::where('status', '1')->orderBy('title', 'asc')->get();
        $data['categories'] = FeesCategory::where('status', '1')
            ->orderBy('title', 'asc')
            ->get();
        $data['selectedCategories'] = $feeStructure->items->pluck('fees_category_id')->toArray();

        return view($this->view.'.edit', $data);
    }

    public function update(Request $request, FeeStructure $feeStructure)
    {
        $validated = $request->validate([
            'faculty_id' => 'required|exists:faculties,id',
            'program_id' => 'required|exists:programs,id',
            'semester' => 'required|string',
            'fee_categories' => 'required|array',
            'fee_categories.*' => 'exists:fees_categories,id',
        ]);

        DB::transaction(function () use ($validated, $request, $feeStructure) {
            $feeStructure->update([
                'faculty_id' => $validated['faculty_id'],
                'program_id' => $validated['program_id'],
                'semester' => $validated['semester'],
            ]);

            // Delete all existing items
            $feeStructure->items()->delete();

            $totalAmount = 0;
            $categories = FeesCategory::whereIn('id', $validated['fee_categories'])->get();
            
            foreach ($categories as $category) {
                $feeStructure->items()->create([
                    'fees_category_id' => $category->id,
                    'fee_category_title' => $category->title,
                    'fee_category_slug' => $category->slug,
                    'fee_category_description' => $category->description,
                    'amount' => $category->amount,
                    'is_one_time' => $request->input('one_time.'.$category->id, false),
                ]);
                $totalAmount += $category->amount;
            }

            $feeStructure->update(['total_amount' => $totalAmount]);
        });

        return redirect()->route($this->route.'.index')->with('success', 'Fee structure updated successfully.');
    }

   public function show(FeeStructure $feeStructure)
{
    $data['title'] = $this->title;
    $data['route'] = $this->route;
    $data['view'] = $this->view;

    // Load relationships safely
    $feeStructure->load(['faculty', 'program', 'items.category']);
    
    $data['feeStructure'] = $feeStructure;

    // Get semester model
    $semesterModel = Semester::where('title', $feeStructure->semester)
        ->orWhere('id', $feeStructure->semester)
        ->first();
    
    // Get students data for the modal
    $studentEnrollments = StudentEnroll::where('program_id', $feeStructure->program_id)
        ->when($semesterModel, function($q) use ($semesterModel) {
            $q->where('semester_id', $semesterModel->id);
        })
        ->where('status', '1')
        ->with('student')
        ->get();
    
    $data['students'] = $studentEnrollments->map(function($enrollment) {
        return $enrollment->student;
    })->filter();
    
    $data['studentCount'] = $studentEnrollments->count();
    
    // Get all invoices related to this fee structure
    $invoices = Invoice::whereHas('studentEnroll', function($q) use ($feeStructure, $semesterModel) {
            $q->where('program_id', $feeStructure->program_id)
              ->when($semesterModel, function($q) use ($semesterModel) {
                  $q->where('semester_id', $semesterModel->id);
              });
        })
        ->with(['studentEnroll.student', 'fees'])
        ->orderBy('created_at', 'desc')
        ->get();
    
    $data['invoices'] = $invoices;
    $data['invoiceCount'] = $invoices->count();
    
    // Filter invoices by payment status
    $data['pendingInvoices'] = $invoices->where('payment_status', 'pending');
    $data['paidInvoices'] = $invoices->where('payment_status', 'paid');
    $data['partialInvoices'] = $invoices->where('payment_status', 'partial');
    
    $data['pendingPaymentCount'] = $data['pendingInvoices']->count();
    $data['paidCount'] = $data['paidInvoices']->count();
    $data['partialPaymentCount'] = $data['partialInvoices']->count();
    
    // Get invoice dates
    $data['firstInvoiceDate'] = $invoices->first() ? $invoices->first()->created_at : null;
    $data['lastInvoiceDate'] = $invoices->last() ? $invoices->last()->created_at : null;
    
    // Communication stats (you'll need to implement these queries based on your notification system)
    $data['smsCount'] = 0; // Replace with actual query for SMS count
    $data['lastSmsDate'] = null; // Replace with actual query for last SMS date
    $data['emailCount'] = 0; // Replace with actual query for email count
    $data['lastEmailDate'] = null; // Replace with actual query for last email date

    return view($this->view.'.show', $data);
}

    public function destroy(FeeStructure $feeStructure)
    {
        $feeStructure->delete();
        return redirect()->route($this->route.'.index')->with('success', 'Fee structure deleted successfully.');
    }

    public function addItem(Request $request, FeeStructure $feeStructure)
    {
        $validated = $request->validate([
            'fees_category_id' => 'required|exists:fees_categories,id',
            'amount' => 'required|numeric|min:0',
            'is_one_time' => 'sometimes|boolean',
        ]);

        $category = FeesCategory::findOrFail($validated['fees_category_id']);

        $item = $feeStructure->items()->create([
            'fees_category_id' => $category->id,
            'fee_category_title' => $category->title,
            'fee_category_slug' => $category->slug,
            'fee_category_description' => $category->description,
            'amount' => $validated['amount'],
            'is_one_time' => $validated['is_one_time'] ?? false,
        ]);

        // Update total amount
        $feeStructure->update([
            'total_amount' => $feeStructure->items()->sum('amount')
        ]);

        return back()->with('success', 'Fee item added successfully.');
    }

    public function removeItem(Request $request)
{
    $request->validate([
        'id' => 'required|exists:fee_structure_items,id'
    ]);

    try {
        DB::transaction(function () use ($request) {
            $item = FeeStructureItem::findOrFail($request->id);
            $feeStructure = $item->feeStructure;
            $item->delete();
            
            // Update total amount
            $feeStructure->update([
                'total_amount' => $feeStructure->items()->sum('amount')
            ]);
        });

        return response()->json(['success' => true]);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Error removing item'], 500);
    }
}

   public function export()
{
    // Get filter parameters from request
    $faculty = request()->get('faculty');
    $program = request()->get('program');
    $semester = request()->get('semester');
    $category = request()->get('category');

    // Build query with filters
    $query = FeeStructure::with(['faculty', 'program', 'items.category'])
        ->when($faculty, function($q) use ($faculty) {
            $q->where('faculty_id', $faculty);
        })
        ->when($program, function($q) use ($program) {
            $q->where('program_id', $program);
        })
        ->when($semester, function($q) use ($semester) {
            $q->where('semester', $semester);
        })
        ->when($category, function($q) use ($category) {
            $q->whereHas('items', function($query) use ($category) {
                $query->where('fees_category_id', $category);
            });
        });

    $data = $query->get();

    // Generate filename with timestamp and filters
    $filename = 'fee_structures_' . now()->format('Y_m_d_His');
    
    if ($faculty) {
        $facultyName = Faculty::find($faculty)->title ?? '';
        $filename .= '_' . Str::slug($facultyName);
    }
    
    if ($program) {
        $programName = Program::find($program)->title ?? '';
        $filename .= '_' . Str::slug($programName);
    }
    
    if ($semester) {
        $filename .= '_' . Str::slug($semester);
    }

    $filename .= '.xlsx';

    return Excel::download(new FeeStructuresExport($data), $filename);
}

    public function import(Request $request)
{
    $request->validate([
        'import_file' => 'required|file|mimes:csv,xls,xlsx',
        'header_row' => 'sometimes|boolean'
    ]);

    try {
        DB::beginTransaction();

        $file = $request->file('import_file');
        $hasHeader = $request->boolean('header_row', true);
        
        if ($file->getClientOriginalExtension() === 'csv') {
            $this->importFromCSV($file, $hasHeader);
        } else {
            $this->importFromExcel($file, $hasHeader);
        }

        DB::commit();
        
        return redirect()
            ->route($this->route.'.index')
            ->with('success', 'Fee structures imported successfully.');

    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()
            ->back()
            ->with('error', 'Error importing file: ' . $e->getMessage());
    }
}

protected function importFromCSV($file, $hasHeader)
{
    $handle = fopen($file->getPathname(), 'r');
    
    if ($hasHeader) {
        $headers = fgetcsv($handle);
    }

    while (($row = fgetcsv($handle)) !== false) {
        $this->processImportRow($row);
    }

    fclose($handle);
}

protected function importFromExcel($file, $hasHeader)
{
    $data = Excel::toArray([], $file)[0];
    
    $startRow = $hasHeader ? 1 : 0;
    
    for ($i = $startRow; $i < count($data); $i++) {
        $this->processImportRow($data[$i]);
    }
}

protected function processImportRow($row)
{
    // Expected columns: faculty,program,semester,category1:amount,category2:amount,...
    $facultyTitle = trim($row[0]);
    $programTitle = trim($row[1]);
    $semesterTitle = trim($row[2]);
    
    // Find or create faculty
    $faculty = Faculty::firstOrCreate(
        ['title' => $facultyTitle],
        ['slug' => Str::slug($facultyTitle), 'status' => '1']
    );
    
    // Find or create program
    $program = Program::firstOrCreate(
        ['title' => $programTitle, 'faculty_id' => $faculty->id],
        ['slug' => Str::slug($programTitle), 'status' => '1']
    );
    
    // Find semester
    $semester = Semester::where('title', $semesterTitle)
        ->orWhere('id', $semesterTitle)
        ->firstOrFail();
    
    // Create fee structure
    $feeStructure = FeeStructure::firstOrCreate([
        'faculty_id' => $faculty->id,
        'program_id' => $program->id,
        'semester' => $semester->title,
    ], ['total_amount' => 0]);
    
    // Process fee categories
    $totalAmount = 0;
    for ($i = 3; $i < count($row); $i++) {
        if (empty($row[$i])) continue;
        
        $parts = explode(':', $row[$i]);
        if (count($parts) !== 2) continue;
        
        $categoryTitle = trim($parts[0]);
        $amount = (float) trim($parts[1]);
        
        $category = FeesCategory::firstOrCreate(
            ['title' => $categoryTitle],
            [
                'slug' => Str::slug($categoryTitle),
                'amount' => $amount,
                'status' => '1'
            ]
        );
        
        // Add item to fee structure if not exists
        $existingItem = $feeStructure->items()
            ->where('fees_category_id', $category->id)
            ->first();
            
        if (!$existingItem) {
            $feeStructure->items()->create([
                'fees_category_id' => $category->id,
                'fee_category_title' => $category->title,
                'fee_category_slug' => $category->slug,
                'fee_category_description' => $category->description,
                'amount' => $amount,
                'is_one_time' => false,
            ]);
            
            $totalAmount += $amount;
        }
    }
    
    // Update total amount
    $feeStructure->update(['total_amount' => $totalAmount]);
}
public function downloadImportTemplate()
{
    $headers = [
        'Content-Type' => 'text/csv',
        'Content-Disposition' => 'attachment; filename="fee_structures_template.csv"',
    ];

    $callback = function() {
        $file = fopen('php://output', 'w');
        
        // Header row
        fputcsv($file, [
            'Faculty', 
            'Program', 
            'Semester',
            'Tuition Fee:50000',
            'Registration Fee:1000',
            'Library Fee:2000',
            // Add other fee categories as needed
        ]);
        
        // Example data row
        fputcsv($file, [
            'Science and Technology',
            'Computer Science',
            'First Semester',
            'Tuition Fee:50000',
            'Registration Fee:1000',
            'Library Fee:2000',
        ]);
        
        fclose($file);
    };

    return response()->stream($callback, 200, $headers);
}

}