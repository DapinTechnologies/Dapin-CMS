<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\Admin\SmsController;
use App\Services\SMSService;
use Illuminate\Support\Facades\Http;
use App\Models\SmsConfiguration;
use App\Http\Controllers\Admin\EnquiryController;
use App\Http\Controllers\Admin\AdmissionProcessController;
use App\Http\Controllers\Admin\VisitController;
use App\Http\Controllers\Admin\FileController;
use App\Http\Controllers\Admin\DirectorController;
use App\Http\Controllers\Admin\StatisticController;
use App\Http\Controllers\Admin\ReasonController;
use App\Http\Controllers\PesaController;
use App\Http\Controllers\Admin\Web\CoreValueController;
use App\Http\Controllers\Admin\FeesStudentController;
use App\Http\Controllers\Admin\FeesCategoryController;
use App\Http\Controllers\Admin\FeeStructureController;
use App\Http\Controllers\Admin\FeesMasterController;
use App\Http\Controllers\Admin\FeeClearanceController;
use App\Http\Controllers\Admin\FeeDashboardController;
use App\Http\Controllers\Admin\FeeReconciliationController;
use App\Http\Controllers\Admin\BursaryAllocationController;
use App\Http\Controllers\Admin\FeesAdjustmentController;
use App\Http\Controllers\Admin\Web\AboutUsController;
use App\Http\Controllers\Admin\DefaultersController;
use App\Http\Controllers\Admin\PartialPaymentsController;
use App\Http\Controllers\Admin\BursaryReportController;
use App\Http\Controllers\Admin\FinesDiscountsReportController;
use App\Http\Controllers\Admin\FeeCollectionReportController;
use App\Http\Controllers\Admin\GovernmentFeesReportController;
use App\Http\Controllers\Admin\ExternalFeesReportController;
use App\Http\Controllers\Admin\OutstandingFeesController;
// use App\Http\Controllers\DirectorController;
use App\Http\Controllers\Admin\PayrollController;
use App\Http\Controllers\Admin\IncomeReportController;
use App\Http\Controllers\Admin\ExpenseReportController;
use App\Http\Controllers\Admin\ReconciliationController;
use App\Http\Controllers\Admin\BillingController;
use App\Http\Controllers\Admin\ExpenseController;
use App\Http\Controllers\Admin\IncomeController;
use App\Http\Controllers\Admin\ReceivableInvoiceController;






Route::post('/frontend-inquiry', [App\Http\Controllers\Admin\EnquiryController::class, 'store'])->name('frontend.inquiry.store');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::prefix('reconciliation')->name('reconciliation.')->group(function () {
        Route::get('/', [ReconciliationController::class, 'index'])->name('index');
        Route::post('/', [ReconciliationController::class, 'store'])->name('store');
        Route::post('/quick-reconcile', [ReconciliationController::class, 'quickReconcile'])->name('quick-reconcile');
        Route::post('/bulk-reconcile', [ReconciliationController::class, 'bulkReconcile'])->name('bulk-reconcile');
        Route::post('/{id}/reconcile', [ReconciliationController::class, 'reconcile'])->name('reconcile');
        Route::post('/{id}/discrepancy', [ReconciliationController::class, 'markDiscrepancy'])->name('discrepancy');
        Route::get('/unreconciled', [ReconciliationController::class, 'unreconciled'])->name('unreconciled');
        Route::delete('/{id}', [ReconciliationController::class, 'destroy'])->name('destroy');
        Route::get('/report', [ReconciliationController::class, 'report'])->name('report');
    });
});

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth']], function() {

Route::get('/digital/files', [FileController::class, 'index'])->name('alldigitalbooks');

Route::get('statistics', [StatisticController::class, 'index'])->name('statistics.index');
    Route::get('statistics/create', [StatisticController::class, 'create'])->name('statistics.create');
    Route::post('statistics', [StatisticController::class, 'store'])->name('statistics.store');
    Route::get('statistics/{id}/edit', [StatisticController::class, 'edit'])->name('statistics.edit');
    Route::put('statistics/{id}', [StatisticController::class, 'update'])->name('statistics.update');
    Route::delete('statistics/{id}', [StatisticController::class, 'destroy'])->name('statistics.destroy');

    Route::get('/visits/map', [VisitController::class, 'showMap'])->name('visits.map');
Route::get('/visit-stats', [VisitController::class, 'showStats'])->name('visits.stats');
Route::get('/all/reason', [ReasonController::class, 'index'])->name('admin.reasons.index');
Route::get('/create/reason', [ReasonController::class, 'create'])->name('admin.reasons.create');
Route::post('/store/reasons', [ReasonController::class, 'store'])->name('admin.reasons.store');
Route::get('/edit/reason/{id}', [ReasonController::class, 'edit'])->name('admin.reasons.edit');
Route::post('/update/reasons/{id}', [ReasonController::class, 'update'])->name('admin.reasons.update');
Route::delete('/delete/reason/{id}', [ReasonController::class, 'destroy'])->name('admin.reasons.destroy');
Route::get('/admission-process', [AdmissionProcessController::class, 'index'])->name('admission.process.index');
Route::get('/admission-process/create', [AdmissionProcessController::class, 'create'])->name('admission.process.create');
Route::post('/admission-process', [AdmissionProcessController::class, 'store'])->name('admission.process.store');
Route::get('/admission-process/{id}/edit', [AdmissionProcessController::class, 'edit'])->name('admission.process.edit');
Route::put('/admission-process/{id}', [AdmissionProcessController::class, 'update'])->name('admission.process.update');
Route::delete('/admission-process/{id}', [AdmissionProcessController::class, 'destroy'])->name('admission.process.destroy');
Route::get('/directors', [DirectorController::class, 'index'])->name('directors.index');
    Route::post('/store/director', [DirectorController::class, 'store'])->name('directors.store');
    Route::put('/update/director/{id}', [DirectorController::class, 'update'])->name('directors.update');
    Route::post('histories', [AboutUsController::class, 'saveHistories'])->name('histories.store');
    
   Route::get('histories', [AboutUsController::class, 'histories'])->name('histories.index');
    Route::get('histories/create', [AboutUsController::class, 'create'])->name('histories.create');
    // Route::post('histories/store', [AboutUsController::class, 'saveHistories'])->name('histories.store');
      Route::get('histories/{id}/edit', [AboutUsController::class, 'edit'])->name('histories.edit');
    Route::post('histories/update/{id}', [AboutUsController::class, 'update'])->name('histories.update');
  Route::delete('histories/{id}', [AboutUsController::class, 'destroy'])->name('histories.destroy');
  Route::get('partners', [AboutUsController::class, 'partners'])->name('admin.about-us.partners');
Route::get('partners', [AboutUsController::class, 'partners'])->name('admin.about-us.partners');
Route::get('partners/create', [AboutUsController::class, 'createPartner'])->name('admin.about-us.partners.create');
Route::post('partners', [AboutUsController::class, 'storePartner'])->name('admin.about-us.partners.store');
Route::get('partners/{id}/edit', [AboutUsController::class, 'editPartner'])->name('admin.about-us.partners.edit');
Route::put('partners/{id}', [AboutUsController::class, 'updatePartner'])->name('admin.about-us.partners.update');
Route::delete('partners/{id}', [AboutUsController::class, 'destroyPartner'])->name('admin.about-us.partners.destroy');

Route::get('accreditations', [AboutUsController::class, 'accreditations'])->name('admin.about-us.accreditations');
Route::get('accreditations/create', [AboutUsController::class, 'createAccreditation'])->name('admin.about-us.accreditations.create');
Route::post('accreditations', [AboutUsController::class, 'storeAccreditation'])->name('admin.about-us.accreditations.store');
Route::get('accreditations/{id}/edit', [AboutUsController::class, 'editAccreditation'])->name('admin.about-us.accreditations.edit');
Route::put('accreditations/{id}', [AboutUsController::class, 'updateAccreditation'])->name('admin.about-us.accreditations.update');
Route::delete('accreditations/{id}', [AboutUsController::class, 'destroyAccreditation'])->name('admin.about-us.accreditations.destroy');

    Route::get('core-values', [CoreValueController::class, 'index'])->name('core-values.index');
    Route::get('core-values/create', [CoreValueController::class, 'create'])->name('core-values.create');
    Route::post('core-values', [CoreValueController::class, 'store'])->name('core-values.store');
    Route::get('core-values/{id}/edit', [CoreValueController::class, 'edit'])->name('core-values.edit');
    Route::put('core-values/{id}', [CoreValueController::class, 'update'])->name('core-values.update');
    Route::delete('core-values/{id}', [CoreValueController::class, 'destroy'])->name('core-values.destroy');

    Route::post('/frontend-inquiry', [App\Http\Controllers\Admin\EnquiryController::class, 'store'])->name('frontend.inquiry.store');
Route::post('/frontend-subscribe', [App\Http\Controllers\Admin\EnquiryController::class, 'storeNewsletter'])->name('frontend.newsletter.store');
Route::post('/digita/file', [FileController::class, 'store'])->name('filepost');
Route::get('/files/{id}', [FileController::class, 'show'])->name('files.show');
Route::post('category/store/file', [FileController::class, 'Catestore'])->name('categoriesstore');
Route::get('/create/cate/item', [FileController::class, 'Catecreate'])->name('categoriescreate');
Route::get('/edit/cate/item/{id}', [FileController::class, 'CateEdit'])->name('catedit');
Route::post('category/update/{id}', [FileController::class, 'CateUpdate'])->name('categoriesupdate');
Route::delete('/categories/{id}', [FileController::class, 'destroyCate'])->name('categdestroy');
Route::get('/edit/file/{id}', [FileController::class, 'EditFile'])->name('editfile');
Route::post('material/update/{id}', [FileController::class, 'MaterialUpdate'])->name('materialsupdate');
Route::get('/material/show/file/{id}', [FileController::class, 'ShowMaterial'])->name('fileshow');

Route::delete('/materials/{id}', [FileController::class, 'destroy'])->name('deletefile');
Route::delete('/admin/inquiries/{id}', [EnquiryController::class, 'deleteInquiry'])->name('admin.inquiry.delete');
Route::get('admin/inquiry/{id}', [EnquiryController::class, 'show'])->name('admin.inquiry.show');
Route::post('admin/inquiry/{id}/reply', [EnquiryController::class, 'reply'])->name('admin.inquiry.reply');
Route::post('/admin/subscriptions/sendBulkEmail', [EnquiryController::class, 'sendBulkEmail'])->name('admin.subscriptions.sendBulkEmail');
Route::get('/admin/subscriptions', [EnquiryController::class, 'subindex'])->name('admin.subscriptions.index');
Route::delete('/admin/subscriptions/{id}', [EnquiryController::class, 'destroysub'])->name('admin.subscriptions.destroy');

});

Route::prefix('admin')->group(function () {
    Route::get('income-report', [IncomeReportController::class, 'index'])->name('admin.income-report.index');
    Route::get('income-report/print', [IncomeReportController::class, 'print'])->name('admin.income-report.print');
    Route::get('income-report/pdf', [IncomeReportController::class, 'pdf'])->name('admin.income-report.pdf');
    Route::get('income-report/chart-data', [IncomeReportController::class, 'chartData'])->name('admin.income-report.chart-data');
    
Route::get('admin/expense-report', [ExpenseReportController::class, 'index'])->name('admin.expense-report.index');
Route::get('admin/expense-report/print', [ExpenseReportController::class, 'print'])->name('admin.expense-report.print');
Route::get('admin/expense-report/pdf', [ExpenseReportController::class, 'pdf'])->name('admin.expense-report.pdf');
Route::get('admin/expense-report/chart-data', [ExpenseReportController::class, 'chartData'])->name('admin.expense-report.chart-data');
});



Route::get('/index/director',[DirectorController::class,'index'])->name('directors.index');
Route::get('/create/director',[DirectorController::class,'create'])->name('directors.create');
Route::post('/store/director',[DirectorController::class,'store'])->name('directors.store');
Route::put('/update/director/{id}', [DirectorController::class, 'update'])->name('directors.update');
Route::get('/home/about',[DirectorController::class,'About'])->name('aboutus');


Route::group(['prefix' => 'fees-student', 'as' => 'fees-student.'], function() {
    
    // Edit/Update Routes
    Route::get('quick-assign/{invoice}/edit', 'FeesStudentController@edit')->name('quick.assign.edit');
    Route::put('quick-assign/{invoice}', 'FeesStudentController@update')->name('quick.assign.update');
});


// Add these routes to your existing payroll routes
Route::get('/payroll/draft/{userId}/{periodId}', [PayrollController::class, 'getDraft'])->name('admin.payroll.draft.get');
Route::delete('/payroll/draft/{userId}/{periodId}/restart', [PayrollController::class, 'restartDraft'])->name('admin.payroll.draft.restart');
Route::post('/payroll/draft/save', [PayrollController::class, 'saveDraft'])->name('admin.payroll.draft.save');
//
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group whichlo
| contains the "web" middleware group. Now create something great!
|
*/


Route::prefix('admin/payroll')->name('admin.payroll.')->group(function () {
    Route::post('/settings/nhif/update', [PayrollController::class, 'updateNhifSettings'])
        ->name('settings.nhif.update');

    Route::post('/settings/paye/update', [PayrollController::class, 'updatePayeSettings'])
        ->name('settings.paye.update');
        
        
});
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth']], function () {
    Route::group(['prefix' => 'payroll', 'as' => 'payroll.'], function () {
        Route::post('/draft/save', [PayrollController::class, 'saveDraft'])->name('draft.save');
    });
});

Route::get('/invoice/{invoiceId}/show-payment-modal', [FeesStudentController::class, 'showPaymentModal'])->name('invoice.showPaymentModal');
Route::post('/payments/clear-print-flag', [FeesStudentController::class, 'clearPrintFlag'])->name('payments.clearPrintFlag');
Route::get('/admin/invoice/{id}/print', [FeesStudentController::class, 'printr'])->name('invoice.print');
Route::get('/admin/invoice/{invoice}/data', [FeesStudentController::class, 'getInvoiceData'])->name('invoice.data');
Route::get('invoice/details/{id}', [FeesStudentController::class, 'details'])->name('invoice.details');
Route::post('/receipt/download', [FeesStudentController::class, 'download'])->name('receipt.download');
Route::get('/payment/receipt/{payment}', [FeesStudentController::class, 'showReceipt'])->name('payment.receipt');
Route::get('payments/{payment}/download-receipt', [FeesStudentController::class, 'downloadReceipt1'])->name('payments.receipt.download');
Route::get('/payments/receipt/pdf/{payment}', [FeesStudentController::class, 'downloadReceipt'])->name('payments.receipt.pdf');

Route::get('/payment/{invoice}', [FeesStudentController::class, 'payshow'])->name('payment.page');

Route::post('/payment/process', [FeesStudentController::class, 'storepayment'])->name('payments.store');
Route::get('/payments/{payment}/receipt', [FeesStudentController::class, 'showReceipt'])->name('payments.receipt');

Route::get('/payment/receipt/{payment}/download', [FeesStudentController::class, 'downloadReceipt'])->name('payment.receipt.download');
        Route::get('invoices/{invoice}', [FeesStudentController::class, 'show'])
            ->name('invoice.show')
            ->middleware('permission:fees-student-due');
        
        Route::post('fees-student/quick-assign-store', [FeesStudentController::class, 'quickAssignStore'])
            ->name('admin.fees-student.quick.assign.store')
            ->middleware('permission:fees-student-quick-assign');
            Route::post('fees/estimate-students', [FeeStructureController::class, 'estimateStudents'])
    ->name('admin.fees.estimate-students');

   Route::get('invoices/{id}/edit', [FeesStudentController::class, 'edit'])->name('fees-student.edit');
    Route::put('invoices/{id}', [FeesStudentController::class, 'update'])->name('fees-student.update');
    Route::get('invoices/{id}', [FeesStudentController::class, 'show'])->name('fees-student.show');
    Route::get('invoices/{id}/print', [FeesStudentController::class, 'print'])->name('fees-student.print');
    // routes/web.php
Route::get('/invoices/{id}', [FeeStudentController::class, 'showinvoice'])->name('invoices.show'); 
    
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth']], function () {
    // ... other routes
    
    // Payments routes
    Route::get('payments/quick-receive', [\App\Http\Controllers\Admin\PaymentController::class, 'create'])
        ->name('payments.quick-receive');
        
    Route::post('payments/get-student-data', [\App\Http\Controllers\Admin\PaymentController::class, 'getStudentData'])
        ->name('payments.get-student-data');
        
    Route::post('payments/store', [\App\Http\Controllers\Admin\PaymentController::class, 'store'])
        ->name('payments.store');
        
    Route::get('payments/receipt/{id}', [\App\Http\Controllers\Admin\PaymentController::class, 'receipt'])
        ->name('payments.receipt');
        Route::post('payments/get-student-invoices', [PaymentController::class, 'getStudentInvoices'])
        ->name('payments.getStudentInvoices');
        
        
    Route::resource('payments', \App\Http\Controllers\Admin\PaymentController::class);
});
Route::get('/payment/get-fee-categories', [PaymentController::class, 'getFeeCategories'])
    ->name('payment.getFeeCategories');

Route::get('/fees/get-categories', [FeeStudentController::class, 'getFeeCategories'])
    ->name('fees.getCategories');

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth']], function() {
    // Fee Reconciliation Routes
    Route::get('fee-reconciliation', [FeeReconciliationController::class, 'index'])->name('fee-reconciliation.index');
    Route::post('fee-reconciliation/reconcile/{payment}', [FeeReconciliationController::class, 'reconcile'])->name('fee-reconciliation.reconcile');
    Route::post('fee-reconciliation/batch-reconcile', [FeeReconciliationController::class, 'batchReconcile'])->name('fee-reconciliation.batch-reconcile');
    Route::get('fee-reconciliation/export', [FeeReconciliationController::class, 'export'])->name('fee-reconciliation.export');

    // Bursary Allocation Routes
    Route::group(['prefix' => 'bursary-allocation', 'as' => 'bursary-allocation.'], function() {
    Route::get('/', [BursaryAllocationController::class, 'index'])->name('index');
    Route::get('/create/{student_enroll_id?}', [BursaryAllocationController::class, 'create'])->name('create');
    Route::post('/', [BursaryAllocationController::class, 'store'])->name('store');
    Route::post('/batch-allocate', [BursaryAllocationController::class, 'batchAllocate'])->name('batch-allocate');
    Route::post('/store-fund', [BursaryAllocationController::class, 'storeFund'])->name('store-fund');
    Route::post('/{id}/reconcile', [BursaryAllocationController::class, 'reconcile'])->name('reconcile');
    Route::post('/batch-reconcile', [BursaryAllocationController::class, 'batchReconcile'])->name('batch-reconcile');
    Route::get('/export', [BursaryAllocationController::class, 'export'])->name('export');
    Route::get('/admin/bursary-types/{code}/details', [BursaryAllocationController::class, 'getBursaryTypeDetails'])->name('admin.bursary-types.details');
    Route::put('/update-fund', [BursaryAllocationController::class, 'updateFund'])->name('update-fund');
Route::delete('/delete-fund', [BursaryAllocationController::class, 'deleteFund'])->name('delete-fund');
    Route::get('/get-bursary-payments', [BursaryAllocationController::class, 'getBursaryPayments'])->name('get-bursary-payments');
});
});


Route::group(['prefix' => 'admin', 'as' => 'admin.'], function() {
    // Defaulters routes
    Route::group(['prefix' => 'defaulters', 'as' => 'defaulters.'], function() {
        Route::get('/', [DefaultersController::class, 'index'])->name('index');
        Route::get('/export', [DefaultersController::class, 'export'])->name('export');
    });
    
});Route::get('/admin/get-programs', [DefaultersController::class, 'getPrograms'])->name('admin.get-programs');


Route::group(['prefix' => 'admin', 'as' => 'admin.'], function() {
    // Outstanding fees routes
    Route::group(['prefix' => 'outstanding-fees', 'as' => 'outstanding-fees.'], function() {
        Route::get('/', [OutstandingFeesController::class, 'index'])->name('index');
        Route::get('/export', [OutstandingFeesController::class, 'export'])->name('export');
    });
});

Route::get('/admin/get-programs', [OutstandingFeesController::class, 'getPrograms'])->name('admin.get-programs');

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth']], function () {
    // Government Fees Report routes
    Route::group(['prefix' => 'government-fees-report', 'as' => 'government-fees-report.'], function () {
        Route::get('/', [GovernmentFeesReportController::class, 'index'])->name('index');
        Route::get('/export', [GovernmentFeesReportController::class, 'export'])->name('export');
    });

    // AJAX program loader
    Route::get('/get-programs', [GovernmentFeesReportController::class, 'getPrograms'])->name('get-programs');
});

Route::group(['prefix' => 'admin', 'as' => 'admin.'], function() {
// External Fees Report routes
Route::group(['prefix' => 'external-fees-report', 'as' => 'external-fees-report.'], function () {
    Route::get('/', [ExternalFeesReportController::class, 'index'])->name('index');
    Route::get('/export', [ExternalFeesReportController::class, 'export'])->name('export');
});

// AJAX program loader
    Route::get('/get-programs', [ExternalFeesReportController::class, 'getPrograms'])->name('get-programs');


});


Route::group(['prefix' => 'admin', 'as' => 'admin.'], function() {
    // Fee Collection Report routes
    Route::group(['prefix' => 'fee-collection-report', 'as' => 'fee-collection-report.'], function() {
        Route::get('/', [FeeCollectionReportController::class, 'index'])->name('index');
        Route::get('/export', [FeeCollectionReportController::class, 'export'])->name('export');
        // Add the get-programs route inside this group
        Route::get('/get-programs', [FeeCollectionReportController::class, 'getPrograms'])->name('get-programs');
    });
});

Route::group(['prefix' => 'admin', 'as' => 'admin.'], function() {
    // Partial payments routes
    Route::group(['prefix' => 'partial-payments', 'as' => 'partial-payments.'], function() {
        Route::get('/', [PartialPaymentsController::class, 'index'])->name('index');
        Route::get('/export', [PartialPaymentsController::class, 'export'])->name('export');
    });
    
    // Bursary Report
Route::group(['prefix' => 'bursary-report', 'as' => 'bursary-report.'], function() {
    Route::get('/', [BursaryReportController::class, 'index'])->name('index');
    Route::get('/get-programs', [BursaryReportController::class, 'getPrograms'])->name('get-programs');
    Route::get('/export', [BursaryReportController::class, 'export'])->name('export');
});

// Fines & Discounts Report
Route::group(['prefix' => 'fines-discounts-report', 'as' => 'fines-discounts-report.'], function() {
    Route::get('/', [FinesDiscountsReportController::class, 'index'])->name('index');
    Route::get('/get-programs', [FinesDiscountsReportController::class, 'getPrograms'])->name('get-programs');
    Route::get('/export', [FinesDiscountsReportController::class, 'export'])->name('export');
});

});

Route::get('/admin/get-programs', [PartialPaymentsController::class, 'getPrograms'])->name('admin.get-programs');

    Route::group([
    'prefix' => 'admin',
    'as' => 'admin.',
    'middleware' => ['auth']
], function () {
    // Fees Adjustment Routes
    Route::group([
        'prefix' => 'fees-adjustment',
        'as' => 'fees-adjustment.',
        'middleware' => ['permission:fees-adjustment-create'] // Added permission middleware
    ], function() {
        Route::get('/', [FeesAdjustmentController::class, 'index'])->name('index');
        Route::post('/', [FeesAdjustmentController::class, 'store'])->name('store');
        Route::get('/get-invoices', [FeesAdjustmentController::class, 'getInvoices'])->name('getInvoices');
        Route::get('/get-invoice-details', [FeesAdjustmentController::class, 'getInvoiceDetails'])->name('getInvoiceDetails');
    });
});


            Route::middleware(['auth'])->group(function() {
    // Fee editing routes
    Route::get('/admin/fees/get-invoice-data', [FeesStudentController::class, 'getInvoiceData'])
            ->name('fees.get-invoice-data')
        ->middleware('permission:fees-edit-view');

        Route::get('/admin/fees/get-details', [FeesStudentController::class, 'getDetails'])->name('invoices.getDetails');


    Route::post('/admin/fees/update', [FeesStudentController::class, 'updateFees'])
        ->name('fees.update')
        ->middleware('permission:fees-edit');
});
// Add these to your existing FeesStudentController routes
Route::get('fees/get-fees', [FeesStudentController::class, 'getFees'])->name('fees.get')
    ->middleware('permission:fees-edit-view');

Route::post('fees/update', [FeesStudentController::class, 'updateFees'])->name('fees.update')
    ->middleware('permission:fees-edit');

    Route::get('invoices/{invoice}/edit-data', [InvoiceController::class, 'getInvoiceData'])
    ->name('invoices.edit.data');
    // Add these routes
Route::put('invoices/{invoice}', [InvoiceController::class, 'update'])->name('invoices.update');
Route::get('invoices/{invoice}/edit', [InvoiceController::class, 'getInvoiceData'])->name('invoices.edit.data');

Route::get('fees/get-student-invoices', [FeesStudentController::class, 'getStudentInvoices'])->name('admin.fees.get-student-invoices');
Route::get('fees/invoice/{invoice}', [InvoiceController::class, 'show'])->name('fees.invoice.show');


// Fee Clearance Module Routes
    Route::prefix('admin/fee-clearance')->group(function () {
        Route::get('/', [FeeClearanceController::class, 'index'])->name('admin.fee-clearance.index');
        Route::get('/search', [FeeClearanceController::class, 'search'])->name('admin.fee-clearance.search');
        Route::get('/student/{id}', [FeeClearanceController::class, 'show'])->name('admin.fee-clearance.show');
        Route::post('/clear/{id}', [FeeClearanceController::class, 'clear'])->name('admin.fee-clearance.clear');
        Route::post('/notify/{id}', [FeeClearanceController::class, 'sendNotification'])->name('admin.fee-clearance.notify');
        Route::get('/history/{id}', [FeeClearanceController::class, 'paymentHistory'])->name('admin.fee-clearance.history');
        Route::get('/report', [FeeClearanceController::class, 'generateReport'])->name('admin.fee-clearance.report');
        Route::get('students/fetch', [FeeClearanceController::class, 'fetchStudents'])->name('students.fetch');
        
    });

// Fee Structure Routes
Route::prefix('admin/fee-structures')->group(function () {
    Route::get('/', [FeeStructureController::class, 'index'])->name('admin.fee-structures.index');
    Route::get('/create', [FeeStructureController::class, 'create'])->name('admin.fee-structures.create');
    Route::post('/', [FeeStructureController::class, 'store'])->name('admin.fee-structures.store');
    Route::get('/{feeStructure}', [FeeStructureController::class, 'show'])->name('admin.fee-structures.show');
    Route::get('/{feeStructure}/edit', [FeeStructureController::class, 'edit'])->name('admin.fee-structures.edit');
    Route::put('/{feeStructure}', [FeeStructureController::class, 'update'])->name('admin.fee-structures.update');
    Route::delete('/{feeStructure}', [FeeStructureController::class, 'destroy'])->name('admin.fee-structures.destroy');
    Route::post('/{feeStructure}/send-invoice', [FeeStructureController::class, 'sendInvoice'])
        ->name('admin.fee-structures.sendInvoice')
        ->middleware('permission:create fee structures');
    Route::post('/remove-item', [FeeStructureController::class, 'removeItem'])
        ->name('admin.fee-structures.remove-item');
        Route::get('/import-template', [FeeStructureController::class, 'downloadImportTemplate'])
    ->name('admin.fee-structures.import-template')
    ->middleware('permission:import fee structures');
     
   // Batch assignment routes
    Route::get('/batch-assign', [FeeStructureController::class, 'previewBatchAssign'])
        ->name('admin.fee-structures.batch-assign');
    
    Route::post('/batch-assign', [FeeStructureController::class, 'batchAssign'])
        ->name('admin.fee-structures.batch-assign');

    // Additional routes for items
    Route::post('/{feeStructure}/items', [FeeStructureController::class, 'addItem'])->name('admin.fee-structures.items.store');
    Route::delete('/items/{item}', [FeeStructureController::class, 'removeItem'])->name('admin.fee-structures.items.destroy');

    
    Route::post('/import', [FeeStructureController::class, 'import'])->name('admin.fee-structures.import');
    
 // Export routes
    Route::get('/export', [FeeStructureController::class, 'export'])
        ->name('admin.fee-structures.export');
        

});

// Web Routes
Route::middleware(['XSS', 'track.visits'])->namespace('Web')->group(function () {

    // Home Route
    Route::get('/', 'HomeController@index')->name('home');
    // Course Route
    Route::get('/course', 'CourseController@index')->name('course');
    Route::get('/course/{slug}', 'CourseController@show')->name('course.single');
    // Event Route
    Route::get('/event', 'EventController@index')->name('event');
    Route::get('/event/{id}/{slug}', 'EventController@show')->name('event.single');
    // Faq Route
    Route::get('/faq', 'FaqController@index')->name('faq');
    // Gallery Route
    Route::get('/gallery', 'GalleryController@index')->name('gallery');
    // News Route
    Route::get('/news', 'NewsController@index')->name('news');
    Route::get('/news/{id}/{slug}', 'NewsController@show')->name('news.single');
    // Page Route
    Route::get('/page/{slug}', 'PageController@show')->name('page.single');

    // Application Route
    Route::get('application', 'ApplicationController@index')->name('application.index');
    Route::post('application', 'ApplicationController@store')->name('application.store');


    // SetCookie Route
    Route::get('/set-cookie', 'HomeController@setCookie')->name('setCookie');
// Route::post('/frontend/inquiry/store', [FrontendController::class, 'storeInquiry'])->name('frontend.inquiry.store');
Route::post('/frontend/newsletter/store', [FrontendController::class, 'storeNewsletterSubscription'])->name('frontend.newsletterstore');
Route::post('/frontend-inquiry', [App\Http\Controllers\Admin\EnquiryController::class, 'store'])->name('frontend.inquiry.store');
Route::post('/frontend-subscribe', [App\Http\Controllers\Admin\EnquiryController::class, 'storeNewsletter'])->name('frontend.newsletter.store');


});

Route::get('/digital/book/home', [FileController::class, 'Home'])->name('materialhome');


//Route::get('/digital/book/home', [FileController::class, 'Home'])->name('materialhome');

Route::get('/home/view/home/{id}', [FileController::class, 'ViewHome'])->name('viewFile');

Route::get('/download-material/{id}', [FileController::class, 'download'])->name('download');




// Route for viewing material (accessible by logged-in students)






Route::get('/materials/{id}/download', [FileController::class, 'download'])->name('material.download');
Route::get('/materials/create', [FileController::class, 'create'])->name('materials.create');
Route::post('/materials/store', [FileController::class, 'storefile'])->name('materials.store');

Route::get('/materials', [FileController::class, 'allpdfs'])->name('materials.index');
Route::get('/materials/{id}', [FileController::class, 'allpdfshow'])->name('materials.show');

Route::get('/view/file/home/{id}', [FileController::class, 'ViewOnlyFile'])->name('viewOnlyFile');



// Display M-Pesa payment page
Route::get('/payment-process/{feeId}', [PesaController::class, 'Feepaymentmpesa'])
    ->name('paymentprocess');

// Process STK Push payment - use the correct method name 'initiatePush'
Route::post('/initiate-push', [PesaController::class, 'initiatePush'])
    ->name('initiatepush');

// M-Pesa callback - use the correct method name 'handleCallback'
Route::post('/api/mpesa/callback', [PesaController::class, 'handleCallback'])
    ->name('mpesa.callback');
    Route::post('/stkcallback',[PesaController::class,'stkCallback'])->name('stkcallback');





Route::post('/paybill/store', [PesaController::class, 'store'])->name('storegatedetails');
Route::get('/settings', [PesaController::class, 'index'])->name('settings.index');

 Route::get('/pay/pesa/store/', [PesaController::class, 'Feepaymentmpesa'])->name('paymentprocess');

// Route::get('/payment/{fee_id}', [PaymentController::class, 'showPaymentForm'])->name('paymentform');

Route::get('/payment/success/{fee_id}', [PaymentController::class, 'paymentSuccess'])->name('payment.success');




Route::get('/test/balance', function (SMSService $smsService)
 { // Fetch the SMS configuration from the database
     $smsConfig = SmsConfiguration::first(); 
     // Check if configuration exists 
     if ($smsConfig) { $apiKey = $smsConfig->api_key; 
        // Make the API request
         $response = Http::post('https://smsportal.dapintechnologies.com/sms/v3/profile',
          [ 'api_key' => $apiKey ]); 
          // Check the response and return the balance 
          if ($response->successful()) { return $response->json();
         } 
         return 'Failed to authenticate API key.';
         }
         return 'No SMS configuration found in the database.'; });



// Ajax Filter Routes
Route::middleware(['XSS'])->group(function () {

    // Filter Routes
    Route::post('filter-district', 'AddressController@filterDistrict')->name('filter-district');
    Route::post('filter-batch', 'FilterController@filterBatch')->name('filter-batch');
    Route::post('filter-program', 'FilterController@filterProgram')->name('filter-program');
    Route::post('filter-session', 'FilterController@filterSession')->name('filter-session');
    Route::post('filter-semester', 'FilterController@filterSemester')->name('filter-semester');
    Route::post('filter-section', 'FilterController@filterSection')->name('filter-section');
    Route::post('filter-subject', 'FilterController@filterSubject')->name('filter-subject');
    Route::post('filter-enroll-subject', 'FilterController@filterEnrollSubject')->name('filter-enroll-subject');
    Route::post('filter-student-subject', 'FilterController@filterStudentSubject')->name('filter-student-subject');
    Route::post('filter-techer-subject', 'FilterController@filterTecherSubject')->name('filter-techer-subject');
    Route::post('filter-item', 'InventoryController@filterItem')->name('filter-item');
    Route::post('filter-quantity', 'InventoryController@filterQuantity')->name('filter-quantity');
    Route::post('filter-department', 'InventoryController@filterDepartment')->name('filter-department');
    Route::post('filter-room', 'HostelController@filterRoom')->name('filter-room');
    Route::post('filter-vehicle', 'TransportController@filterVehicle')->name('filter-vehicle');

});


// Set Lang Version
Route::get('locale/language/{locale}', function ($locale){

    \Session::put('locale', $locale);

    \App::setLocale($locale);

    return redirect()->back();
    
})->name('version');


// Auth Routes
Route::middleware(['XSS'])->prefix('admin')->group(function () {
    // Auth::routes();
    Auth::routes(['register' => false]);
});


// Verify Purchase
Route::middleware(['XSS'])->group(function () {
    
    Route::get('verify-purchase', 'PurchaseVerificationController@index')->name('verify');
    Route::post('verify-purchase', 'PurchaseVerificationController@verify')->name('verify-purchase');

});


// Payment Routes
Route::middleware(['XSS'])->name('payment.')->namespace('Payment')->prefix('payment')->group(function () {

    // Paypal Routes
    // Route::get('paypal', 'PaypalController@index')->name('paypal.index');
    Route::post('paypal/process', 'PaypalController@process')->name('paypal.process');
    Route::get('paypal/success', 'PaypalController@paymentSuccess')->name('paypal.success');
    Route::get('paypal/cancel', 'PaypalController@paymentCancel')->name('paypal.cancel');

    // Stripe Routes
    // Route::get('stripe', 'StripeController@index')->name('stripe.index');
    Route::post('stripe/process', 'StripeController@process')->name('stripe.process');

    // Razorpay Routes
    // Route::get('razorpay', 'RazorpayController@index')->name('razorpay.index');
    Route::post('razorpay/process', 'RazorpayController@process')->name('razorpay.process');

    // Paystack Routes
    // Route::get('paystack', 'PaystackController@index')->name('paystack.index');
    Route::post('paystack/process', 'PaystackController@redirectToGateway')->name('paystack.process');
    Route::get('paystack/callback', 'PaystackController@handleGatewayCallback')->name('paystack.callback');

    // Flutterwave Routes
    // Route::get('flutterwave', 'FlutterwaveController@index')->name('flutterwave.index');
    Route::post('flutterwave/process', 'FlutterwaveController@process')->name('flutterwave.process');
    Route::get('flutterwave/callback', 'FlutterwaveController@callback')->name('flutterwave.callback');

    // Skrill Routes
    // Route::get('skrill', 'SkrillController@index')->name('skrill.index');
    Route::get('skrill/process', 'SkrillController@makePayment')->name('skrill.process');
    Route::get('skrill/completed', 'SkrillController@paymentCompleted')->name('skrill.completed');
    Route::get('skrill/cancelled', 'SkrillController@paymentCancelled')->name('skrill.cancelled');

});

Route::get('admin/fee-dashboard', [FeeDashboardController::class, 'index'])->name('admin.fee-dashboard.index');
Route::get('admin/fee-dashboard/data', [FeeDashboardController::class, 'getDashboardData'])->name('admin.fee-dashboard.data');
Route::post('admin/fee-dashboard/send-notifications', [FeeDashboardController::class, 'sendNotifications'])
        ->name('admin.fee-dashboard.send-notifications');

    Route::post('admin/fee-dashboard/send-single-notification', [FeeDashboardController::class, 'sendSingleNotification'])
        ->name('admin.fee-dashboard.send-single-notification');


// Admin Routes
Route::middleware(['auth:web', 'XSS', 'license'])->name('admin.')->namespace('Admin')->prefix('admin')->group(function () {

    // Dashboard Route
    Route::get('/', 'DashboardController@index')->name('dashboard.index');
    Route::get('dashboard', 'DashboardController@index')->name('dashboard.index');
    
    // SMS Routes
    Route::prefix('sms')->group(function () {
        Route::get('/', 'SmsController@index')->name('sms.index');
        Route::get('/create', 'SmsController@create')->name('sms.create');
        Route::post('/send', 'SmsController@send')->name('sms.send');
        Route::post('/send-individual', 'SmsController@sendIndividual')->name('sms.sendIndividual');
        Route::get('/send/test', 'SmsController@sendTest')->name('sms.test');
        Route::post('/config/store', 'SmsController@store')->name('sms.store');
        Route::get('/search', 'SmsController@search')->name('sms.search');
        Route::get('/{id}', 'SmsController@show')->name('sms.show');
        Route::get('/balance/credit', 'SmsController@showCredits')->name('sms.balance');
    });




    // Student Routes
    Route::resource('admission/application', 'ApplicationController');
    Route::resource('admission/student', 'StudentController');
    Route::get('admission/student-card/{id}', 'StudentController@card')->name('student.card');
    // Route::get('admission/student-status/{id}', 'StudentController@status')->name('student.status');
    Route::post('admission/student-send-password/{id}', 'StudentController@sendPassword')->name('student.send-password');
    Route::get('admission/student-print-password/{id}', 'StudentController@printPassword')->name('student.print-password');
    Route::post('admission/student-password-change', 'StudentController@passwordChange')->name('student-password-change');
    Route::get('admission/student-import', 'StudentController@import')->name('student.import');
    Route::post('admission/student-import-store', 'StudentController@importStore')->name('student.import.store');
    Route::get('admission/student-password-multiprint', 'StudentController@multiPrintPassword')->name('student.password-multiprint');

    //Route::resource('students', 'Admin\StudentController');
    Route::post('/admin/student/store', [StudentController::class, 'store'])->name('admin.student.store');




    // Admission Routes
    Route::resource('admission/student-transfer-out', 'StudentTransferOutController');
    Route::resource('admission/student-transfer-in', 'StudentTransferInController');
    Route::resource('admission/status-type', 'StatusTypeController');
    Route::resource('admission/id-card', 'StudentIdCardController');
    Route::get('admission/id-card-print/{id}', 'StudentIdCardController@print')->name('id-card.print');
    Route::get('admission/id-card-multiprint', 'StudentIdCardController@multiPrint')->name('id-card.multiprint');
    Route::resource('admission/id-card-setting', 'StudentIdCardSettingController');



    // Student Attendance Routes
    Route::resource('student-attendance', 'StudentAttendanceController');
    Route::get('student-attendance-report', 'StudentAttendanceController@report')->name('student-attendance.report');
    Route::get('student-attendance-import', 'StudentAttendanceController@import')->name('student-attendance.import');
    Route::post('student-attendance-import-store', 'StudentAttendanceController@importStore')->name('student-attendance.import.store');

    // Student Leave Manage
    Route::resource('student-leave-manage', 'StudentLeaveManagementController');
    Route::post('student-leave-manage-status/{id}', 'StudentLeaveManagementController@status')->name('student-leave-manage.status');

    // Student Enroll Routes
    Route::resource('student/student-note', 'StudentNoteController');
    Route::resource('student/single-enroll', 'StudentSingleEnrollController');
    Route::resource('student/group-enroll', 'StudentGroupEnrollController');
    Route::resource('student/subject-adddrop', 'SubjectAddDropController');
    Route::resource('student/course-complete', 'CourseCompleteController');
    Route::resource('student/student-alumni', 'StudentAlumniController');



    // Academic Routes
    Route::resource('academic/faculty', 'FacultyController');
    Route::resource('academic/program', 'ProgramController');
    Route::resource('academic/batch', 'BatchController');
    Route::resource('academic/session', 'SessionController');
    Route::get('academic/session-current/{id}', 'SessionController@current')->name('session.current');
    Route::resource('academic/semester', 'SemesterController');
    Route::resource('academic/section', 'SectionController');
    Route::resource('academic/room', 'ClassRoomController');
    Route::resource('academic/subject', 'SubjectController');
    Route::get('academic/subject-import', 'SubjectController@import')->name('subject.import');
    Route::post('academic/subject-import-store', 'SubjectController@importStore')->name('subject.import.store');
    Route::resource('academic/enroll-subject', 'EnrollSubjectController');

    
    // Routine Routes
    Route::resource('routine/class-routine', 'ClassRoutineController');
    Route::get('routine/class-routine-teacher', 'ClassRoutineController@teacher')->name('class-routine.teacher');
    Route::post('routine/class-routine/print', 'ClassRoutineController@print')->name('class-routine.print');
    Route::resource('routine/exam-routine', 'ExamRoutineController');
    Route::post('routine/exam-routine/print', 'ExamRoutineController@print')->name('exam-routine.print');
    Route::get('routine/routine-setting/class', 'RoutineSettingController@class')->name('routine-setting.class');
    Route::get('routine/routine-setting/exam', 'RoutineSettingController@exam')->name('routine-setting.exam');
    Route::post('routine/routine-setting/store', 'RoutineSettingController@store')->name('routine-setting.store');



    // Exam Routes
    Route::resource('exam/exam-attendance', 'ExamAttendanceController');
    Route::get('exam/exam-attendance-import', 'ExamAttendanceController@import')->name('exam-attendance.import');
    Route::post('exam/exam-attendance-import-store', 'ExamAttendanceController@importStore')->name('exam-attendance.import.store');
    Route::resource('exam/exam-marking', 'ExamMarkingController');
    Route::get('exam/exam-result', 'ExamMarkingController@result')->name('exam-result');
    Route::resource('exam/subject-marking', 'SubjectMarkingController');
    Route::get('exam/subject-result', 'SubjectMarkingController@result')->name('subject-result');
    Route::resource('exam/exam-type', 'ExamTypeController');
    Route::resource('exam/grade', 'GradeController');
    Route::resource('exam/result-contribution', 'ResultContributionController');
    Route::resource('exam/admit-card', 'AdmitCardController');
    Route::get('exam/admit-card-print/{id}', 'AdmitCardController@print')->name('admit-card.print');
    Route::get('exam/admit-card-multiprint', 'AdmitCardController@multiPrint')->name('admit-card.multiprint');
    Route::get('exam/admit-card-download/{id}', 'AdmitCardController@download')->name('admit-card.download');
    Route::resource('exam/admit-setting', 'AdmitCardSettingController');
    Route::post('exam/exam-routine-repo/print', 'ExamRoutineRepoController@print')->name('exam-routine-repo.print');
    Route::resource('exam/exam-routine-repo', 'ExamRoutineRepoController');
    Route::resource('exam/attendance-repo', 'ExamAttendanceRepoController');
    Route::resource('exam/result-repo', 'ExamResultRepoController');
    Route::resource('exam/exam-teacher-repo', 'ExamTeacherRepoController');
    Route::resource('exam/subject-repo', 'SubjectRepoController');
    Route::resource('exam/result2-repo', 'Exam2ResultRepoController');
     Route::resource('exam/teacher-report', 'ExamTeacherReportController');
     Route::resource('exam/department-repo', 'ExamDepartmentRepoController');
     Route::resource('exam/dashboard-repo', 'ExamDashboardRepoController');
     Route::resource('exam/result3-repo', 'ExamResult3RepoController');


    // Assignment Routes
    Route::resource('download/assignment', 'AssignmentController');
    Route::post('download/assignment-marking', 'AssignmentController@marking')->name('assignment.marking');
    Route::get('download/assignment-export/{id}', 'AssignmentController@export')->name('assignment.export');
    Route::post('download/assignment-import', 'AssignmentController@import')->name('assignment.import');

    // Content Routes
    Route::resource('download/content', 'ContentController');    
    Route::resource('download/content-type', 'ContentTypeController');


    

    // Fees Collection Student
    Route::get('fees-student', 'FeesStudentController@index')->name('fees-student.index');
    Route::post('fees-student-pay', 'FeesStudentController@pay')->name('fees-student.pay');
    Route::post('fees-student-unpay/{id}', 'FeesStudentController@unpay')->name('fees-student.unpay');
    Route::post('fees-student-cancel/{id}', 'FeesStudentController@cancel')->name('fees-student.cancel');
    Route::get('fees-student-report', 'FeesStudentController@report')->name('fees-student.report');
    Route::get('fees-student-print/{id}', 'FeesStudentController@print')->name('fees-student.print');
    Route::get('fees-student-multiprint', 'FeesStudentController@multiPrint')->name('fees-student.multiprint');

    // Quick Collection Student
    Route::get('fees-student-quick-received', 'FeesStudentController@quickReceived')->name('fees-student.quick.received');
    Route::post('fees-student-quick-received', 'FeesStudentController@quickReceivedStore')->name('fees-student.quick.received.store');
    Route::get('fees-student-quick-assign', 'FeesStudentController@quickAssign')->name('fees-student.quick.assign');
    Route::post('fees-student-quick-assign', 'FeesStudentController@quickAssignStore')->name('fees-student.quick.assign.store');
     Route::get('quick-assign/{invoice}/edit', 'FeesStudentController@edit')->name('fees-student.quick.assign.edit');
    Route::put('quick-assign/{invoice}', 'FeesStudentController@update')->name('fees-student.quick.assign.update');
    
    // Fees Master Routes
    Route::resource('fees-master', 'FeesMasterController');
     Route::get('/', [FeesMasterController::class, 'index'])->name('index');
    Route::get('/create', [FeesMasterController::class, 'create'])->name('create');
    Route::post('/', [FeesMasterController::class, 'store'])->name('store');
    Route::get('fees-master/get-fee-structure', [FeesMasterController::class, 'getFeeStructure'])
        ->name('fees-master.getFeeStructure');
        Route::post('/send-reminder', [FeesMasterController::class, 'sendReminder'])->name('send-reminder');


    // Fees Routes
    Route::resource('fees-discount', 'FeesDiscountController');
    Route::resource('fees-fine', 'FeesFineController');
    Route::resource('fees-category', 'FeesCategoryController');
    Route::resource('fees-receipt', 'ReceiptSettingController');
   
    



    // Staff Routes
    Route::resource('staff/user','UserController');
    Route::get('staff/user-status/{id}', 'UserController@status')->name('user.status');
    Route::post('staff/user-send-password/{id}', 'UserController@sendPassword')->name('user.send-password');
    // Route::get('staff/user-print-password/{id}', 'UserController@printPassword')->name('user.print-password');
    Route::post('staff/user-password-change', 'UserController@passwordChange')->name('user-password-change');
    Route::get('staff/user-import', 'UserController@import')->name('user.import');
    Route::post('staff/user-import-store', 'UserController@importStore')->name('user.import.store');

    // Payroll Routes
    Route::resource('staff/payroll', 'PayrollController');
    Route::get('staff/payroll-generate/{id}/{month}/{year}', 'PayrollController@generate')->name('payroll.generate');
    Route::post('staff/payroll-pay/{id}', 'PayrollController@pay')->name('payroll.pay');
    Route::post('staff/payroll-unpay/{id}', 'PayrollController@unpay')->name('payroll.unpay');
    Route::get('staff/payroll-report', 'PayrollController@report')->name('payroll.report');
    Route::get('staff/payroll-print/{id}', 'PayrollController@print')->name('payroll.print');
    Route::resource('staff/pay-slip-setting', 'PaySlipSettingController');



    // Human Resource Routes
    Route::resource('staff/designation', 'DesignationController');
    Route::resource('staff/department', 'DepartmentController');
    Route::resource('staff/work-shift-type', 'WorkShiftTypeController');
    Route::resource('staff/staff-note', 'StaffNoteController');
    Route::resource('staff/tax-setting', 'TaxSettingController');
    Route::resource('payroll/deduction-setting', 'DeductionSettingController');

Route::resource('payroll', 'PayrollController');
    Route::get('payroll/run/{id}/show', 'PayrollController@showRun')->name('payroll.run.show');
    Route::post('payroll/bulk-generate', 'PayrollController@bulkGenerate')->name('payroll.bulk-generate');
    Route::post('payroll/generate-employee', 'PayrollController@generateForEmployee')->name('payroll.generate-employee');
    Route::post('payroll/{id}/pay', 'PayrollController@pay')->name('payroll.pay');
    Route::post('payroll/bulk-pay', 'PayrollController@bulkPay')->name('payroll.bulk-pay');
    Route::get('payroll/{id}/payslip', 'PayrollController@exportPdf')->name('payroll.payslip');
    Route::get('payroll/run/{id}/master-report', 'PayrollController@downloadMasterReport')->name('payroll.master-report');
    Route::get('payroll/run/{id}/export-pdfs', 'PayrollController@exportAllPayslips')->name('payroll.export-all');
    
    // Payroll Components Management
    Route::get('payroll-components', 'PayrollComponentController@index')->name('payroll-components.index');
    Route::post('payroll-components', 'PayrollComponentController@store')->name('payroll-components.store');
    Route::put('payroll-components/{id}', 'PayrollComponentController@update')->name('payroll-components.update');
    Route::post('payroll-components/{id}/toggle-status', 'PayrollComponentController@toggleStatus')->name('payroll-components.toggle-status');
    
    // NHIF Management
    Route::get('nhif-settings', 'NHIFController@index')->name('nhif-settings.index');
    Route::post('nhif-settings', 'NHIFController@store')->name('nhif-settings.store');
    Route::put('nhif-settings/{id}', 'NHIFController@update')->name('nhif-settings.update');
    Route::delete('nhif-settings/{id}', 'NHIFController@destroy')->name('nhif-settings.destroy');
    
    // PAYE Management
    Route::get('paye-settings', 'PAYEController@index')->name('paye-settings.index');
    Route::post('paye-settings', 'PAYEController@store')->name('paye-settings.store');
    Route::put('paye-settings/{id}', 'PAYEController@update')->name('paye-settings.update');

    // Staff Attendance Routes
    Route::resource('attendance/staff-daily-attendance', 'StaffAttendanceController');
    Route::get('attendance/staff-daily-report', 'StaffAttendanceController@report')->name('staff-daily-attendance.report');
    Route::resource('attendance/staff-hourly-attendance', 'StaffHourlyAttendanceController');
    Route::get('attendance/staff-hourly-report', 'StaffHourlyAttendanceController@report')->name('staff-hourly-attendance.report');
    Route::get('attendance/staff-hourly-report/{id}', 'StaffHourlyAttendanceController@reportDetails')->name('staff-hourly-attendance.report.details');


    // Excel Export Routes
Route::get('payroll/run/{id}/export-excel', [PayrollController::class, 'exportExcel'])->name('payroll.export-excel');
Route::get('payroll/run/{id}/export-master-excel', [PayrollController::class, 'exportMasterReportExcel'])->name('payroll.export-master-excel');
Route::get('payroll/entry/{id}/export-payslip-excel', [PayrollController::class, 'exportPayslipExcel'])->name('payroll.export-payslip-excel');
Route::get('payroll/run/{id}/export-all-payslips', [PayrollController::class, 'exportAllPayslips'])->name('payroll.export-all-payslips');

// Print Routes
Route::get('payroll/entry/{id}/print', [PayrollController::class, 'printPayslip'])->name('payroll.print-payslip');
Route::get('payroll/run/{id}/print-master', [PayrollController::class, 'printMasterReport'])->name('payroll.print-master-report');


    Route::post('/settings/nhif/update', [PayrollController::class, 'updateNhifSettings'])
         ->name('admin.payroll.settings.nhif.update');
         
    Route::post('/settings/paye/update', [PayrollController::class, 'updatePayeSettings'])
         ->name('admin.payroll.settings.paye.update');


    // Staff Leave Routes
    Route::resource('leave/staff-leave', 'LeaveController');
    Route::resource('leave/leave-type', 'LeaveTypeController');
    Route::resource('leave/leave-manage', 'LeaveManagementController');
    Route::post('leave/leave-manage-status/{id}', 'LeaveManagementController@status')->name('leave-manage.status');



    // Income Expense Routes
    Route::resource('account/income', 'IncomeController');
    Route::resource('account/income-category', 'IncomeCategoryController');
    Route::resource('account/expense', 'ExpenseController');
    Route::resource('account/expense-category', 'ExpenseCategoryController');
    Route::resource('account/outcome', 'OutcomeCalculationController');
    

    // Communicate Routes
    Route::resource('communicate/email-notify', 'EmailNotifyController');
    Route::resource('communicate/sms-notify', 'SMSNotifyController');
    Route::resource('communicate/event', 'EventController');
    Route::get('communicate/event-calendar', 'EventController@calendar')->name('event.calendar');
    Route::resource('communicate/notice', 'NoticeController');
    Route::resource('communicate/notice-category', 'NoticeCategoryController');

// Billing Routes
Route::group(['prefix' => 'billing', 'as' => 'billing.'], function() {
    Route::get('/', [BillingController::class, 'index'])->name('index');
    Route::get('/create', [BillingController::class, 'create'])->name('create');
    Route::post('/', [BillingController::class, 'store'])->name('store');
    Route::get('/{billing}', [BillingController::class, 'show'])->name('show');
    Route::get('/{billing}/edit', [BillingController::class, 'edit'])->name('edit');
    Route::put('/{billing}', [BillingController::class, 'update'])->name('update');
    Route::delete('/{billing}', [BillingController::class, 'destroy'])->name('destroy');
    Route::get('/{billing}/print', [BillingController::class, 'print'])->name('print');
});

// Expense Routes (add receipt route)
Route::group(['prefix' => 'expense', 'as' => 'expense.'], function() {
    // ... other routes ...
    Route::get('/{expense}/receipt', [ExpenseController::class, 'receipt'])->name('receipt');
});

// Receivable Invoice Routes
Route::group(['prefix' => 'receivable-invoice', 'as' => 'receivable-invoice.'], function() {
    Route::get('/', [ReceivableInvoiceController::class, 'index'])->name('index');
    Route::get('/create', [ReceivableInvoiceController::class, 'create'])->name('create');
    Route::post('/', [ReceivableInvoiceController::class, 'store'])->name('store');
    Route::get('/{receivableInvoice}', [ReceivableInvoiceController::class, 'show'])->name('show');
    Route::get('/{receivableInvoice}/edit', [ReceivableInvoiceController::class, 'edit'])->name('edit');
    Route::put('/{receivableInvoice}', [ReceivableInvoiceController::class, 'update'])->name('update');
    Route::delete('/{receivableInvoice}', [ReceivableInvoiceController::class, 'destroy'])->name('destroy');
    Route::get('/{receivableInvoice}/print', [ReceivableInvoiceController::class, 'print'])->name('print');
    // AJAX routes for searchable dropdowns
Route::get('/receivable-invoice/ajax/students', [ReceivableInvoiceController::class, 'getStudents'])->name('ajax.students');
Route::get('/receivable-invoice/ajax/staff', [ReceivableInvoiceController::class, 'getStaff'])->name('ajax.staff');
    // AJAX routes for dropdowns
    Route::get('/get/students', [ReceivableInvoiceController::class, 'getStudents'])->name('get.students');
    Route::get('/get/staff', [ReceivableInvoiceController::class, 'getStaff'])->name('get.staff');
});



// Income Routes
Route::group(['prefix' => 'income', 'as' => 'income.'], function() {
    // ... other routes ...
    Route::get('/{income}/receipt', [IncomeController::class, 'receipt'])->name('receipt');
});


    // Library Routes
    Route::resource('library/book-list', 'BookController');
    Route::get('library/book-list-token-print/{id}', 'BookController@tokenPrint')->name('book-list.token.print');
    Route::get('library/book-list-multitoken-print', 'BookController@multitokenPrint')->name('book-list.multitoken.print');
    Route::get('library/book-list-import', 'BookController@import')->name('book-list.import');
    Route::post('library/book-list-import-store', 'BookController@importStore')->name('book-list.import.store');
    Route::resource('library/book-request', 'BookRequestController');
    Route::resource('library/book-category', 'BookCategoryController');
    Route::resource('library/issue-return', 'IssueReturnController');
    Route::post('library/issue-return-penalty/{id}', 'IssueReturnController@penalty')->name('issue-return.penalty');

    // Library Member Routes
    Route::resource('member/library-student', 'LibraryStudentController');
    Route::resource('member/library-staff', 'LibraryStaffController');
    Route::resource('member/library-outsider', 'OutSideUserController');
    Route::post('member/library-outsider-status/{id}', 'OutSideUserController@status')->name('library-outsider.status');
    Route::get('member/library-student-card/{id}', 'LibraryStudentController@libraryCard')->name('library-student.card');
    Route::get('member/library-staff-card/{id}', 'LibraryStaffController@libraryCard')->name('library-staff.card');
    Route::get('member/library-outsider-card/{id}', 'OutSideUserController@libraryCard')->name('library-outsider.card');
    Route::resource('library-card-setting', 'LibraryIdCardSettingController');



    // Inventory Routes
    Route::resource('inventory/item-list', 'ItemController');
    Route::resource('inventory/item-issue', 'ItemIssueController');
    Route::post('inventory/item-issue-penalty/{id}', 'ItemIssueController@penalty')->name('item-issue.penalty');
    Route::resource('inventory/item-stock', 'ItemStockController');
    Route::resource('inventory/item-store', 'ItemStoreController');
    Route::resource('inventory/item-supplier', 'ItemSupplierController');
    Route::resource('inventory/item-category', 'ItemCategoryController');



    // Hostel Routes
    Route::resource('hostel/hostel', 'HostelController');
    Route::resource('hostel/hostel-room', 'HostelRoomController');
    Route::resource('hostel/room-type', 'HostelRoomTypeController');
    Route::resource('hostel-student', 'HostelStudentController');
    Route::resource('hostel-staff', 'HostelStaffController');



    // Transport Routes
    Route::resource('transport-route', 'TransportRouteController');
    Route::resource('transport-vehicle', 'TransportVehicleController');
    Route::resource('transport-student', 'TransportStudentController');
    Route::resource('transport-staff', 'TransportStaffController');



    // Visitor Routes
    Route::resource('frontdesk/visitor', 'VisitorController');
    Route::get('frontdesk/visitor-out/{id}', 'VisitorController@outTime')->name('visitor.out');
    Route::get('frontdesk/visitor-token-print/{id}', 'VisitorController@tokenPrint')->name('visitor.token.print');
    Route::resource('frontdesk/visit-purpose', 'VisitPurposeController');
    Route::resource('frontdesk/visitor-token-setting', 'VisitorTokenSettingController');

    // Phone Log Routes
    Route::resource('frontdesk/phone-log', 'PhoneLogController');

    // Enquiry Routes
    Route::resource('frontdesk/enquiry', 'EnquiryController');
    Route::post('frontdesk/enquiry-status/{id}', 'EnquiryController@status')->name('enquiry.status');
    Route::resource('frontdesk/enquiry-source', 'EnquirySourceController');
    Route::resource('frontdesk/enquiry-reference', 'EnquiryReferenceController');

    // Complain Routes
    Route::resource('frontdesk/complain', 'ComplainController');
    Route::post('frontdesk/complain-status/{id}', 'ComplainController@status')->name('complain.status');
    Route::resource('frontdesk/complain-type', 'ComplainTypeController');
    Route::resource('frontdesk/complain-source', 'ComplainSourceController');

    // Postal Exchange Routes
    Route::resource('frontdesk/postal-exchange', 'PostalExchangeController');
    Route::post('frontdesk/postal-exchange-status/{id}', 'PostalExchangeController@status')->name('postal-exchange.status');
    Route::resource('frontdesk/postal-type', 'PostalExchangeTypeController');

    // Postal Exchange Routes
    Route::resource('frontdesk/meeting', 'MeetingScheduleController');
    Route::post('frontdesk/meeting-status/{id}', 'MeetingScheduleController@status')->name('meeting.status');
    Route::resource('frontdesk/meeting-type', 'MeetingTypeController');




    // Marksheet Routes
    Route::resource('transcript/marksheet', 'MarksheetController');
    Route::get('transcript/marksheet-print/{id}', 'MarksheetController@print')->name('marksheet.print');
    Route::get('transcript/marksheet-download/{id}', 'MarksheetController@download')->name('marksheet.download');
    Route::get('transcript/marksheet-semester', 'MarksheetController@semester')->name('marksheet.semester');
    Route::get('transcript/marksheet-semester-print/{id}/{session}', 'MarksheetController@semesterPrint')->name('marksheet.semester.print');
    Route::get('transcript/marksheet-semester-download/{id}/{session}', 'MarksheetController@semesterDownload')->name('marksheet.semester.download');
    Route::get('transcript/marksheet-semester-multiprint', 'MarksheetController@multiPrint')->name('marksheet.semester.multiprint');
    Route::resource('transcript/marksheet-setting', 'MarksheetSettingController');

    // Certificate Routes
    Route::resource('transcript/certificate', 'CertificateController');
    Route::get('transcript/certificate-print/{id}', 'CertificateController@print')->name('certificate.print');
    Route::get('transcript/certificate-download/{id}', 'CertificateController@download')->name('certificate.download');
    Route::get('transcript/certificate-multiprint', 'CertificateController@multiPrint')->name('certificate.multiprint');
    Route::resource('transcript/certificate-template', 'CertificateTemplateController');
    


    // Report Routes
    Route::get('report/student', 'ReportController@student')->name('report.student');
    Route::get('report/subject', 'ReportController@subject')->name('report.subject');
    Route::get('report/student-attendance', 'ReportController@studentAttendance')->name('report.student-attendance');
    Route::get('report/subject-attendance', 'ReportController@subjectAttendance')->name('report.subject-attendance');
    Route::get('report/fees', 'ReportController@fees')->name('report.fees');
    Route::get('report/student-fees', 'ReportController@studentFees')->name('report.student-fees');
    Route::get('report/payroll', 'ReportController@payroll')->name('report.payroll');
    Route::get('report/leave', 'ReportController@leave')->name('report.leave');
    Route::get('report/income', 'ReportController@income')->name('report.income');
    Route::get('report/expense', 'ReportController@expense')->name('report.expense');
    Route::get('report/library', 'ReportController@library')->name('report.library');
    Route::get('report/book-return', 'ReportController@bookReturn')->name('report.book-return');
    Route::get('report/inventory', 'ReportController@inventory')->name('report.inventory');
    Route::get('report/hostel', 'ReportController@hostel')->name('report.hostel');
    Route::get('report/transport', 'ReportController@transport')->name('report.transport');

    

    // Setting Routes
    Route::get('setting', 'SettingController@index')->name('setting.index');
    Route::post('setting/siteinfo', 'SettingController@siteInfo')->name('setting.siteinfo');

    // Address Routes
    Route::resource('setting/province','ProvinceController');
    Route::resource('setting/district','DistrictController');

    // Language Routes
    Route::resource('setting/language', 'LanguageController');
    Route::get('setting/language-default/{id}', 'LanguageController@default')->name('language.default');

    // Translations Routes
    Route::get('translations', 'TranslateController@index')->name('translations.index');
    Route::post('translations/create', 'TranslateController@store')->name('translations.create');
    Route::post('translations/update', 'TranslateController@transUpdate')->name('translation.update.json');
    Route::post('translations/updateKey', 'TranslateController@transUpdateKey')->name('translation.update.json.key');
    Route::delete('translations/destroy/{key}', 'TranslateController@destroy')->name('translations.destroy');

    // Roles And Permission Routes
    Route::resource('setting/role','RoleController');

    // Env Setting Routes
    Route::resource('setting/mail-setting','MailSettingController');
    Route::resource('setting/sms-setting','SMSSettingController');
    Route::resource('setting/payment-setting','PaymentSettingController');

    // Sechedule Setting
    Route::resource('setting/schedule-setting', 'ScheduleSettingController');

    // Application Setting
    Route::resource('setting/application-setting', 'ApplicationSettingController');

    // Field Setting Routes
    Route::get('setting/field-user', 'FieldController@user')->name('field.user');
    Route::get('setting/field-student', 'FieldController@student')->name('field.student');
    Route::get('setting/field-application', 'FieldController@application')->name('field.application');
    Route::get('setting/student-panel', 'FieldController@panel')->name('student.panel');
    Route::post('setting/field-store', 'FieldController@store')->name('field.store');



    // Profile Routes
    Route::resource('profile','ProfileController');
    Route::get('profile/account', 'ProfileController@account')->name('profile.account');
    Route::post('profile/changemail', 'ProfileController@changeMail')->name('profile.changemail');
    Route::post('profile/changepass', 'ProfileController@changePass')->name('profile.changepass');



    // Front Web Routes
    Route::prefix('web')->namespace('Web')->group(function () {

        Route::resource('slider', 'SliderController');
        Route::resource('feature', 'FeatureController');

 //Route::post('about-us', [App\Http\Controllers\Admin\Web\AboutUsController::class, 'store'])->name('about-us.store');
Route::resource('about-us', App\Http\Controllers\Admin\Web\AboutUsController::class);


        Route::resource('course', 'CourseController');
            
Route::get('/events', [WebEventController::class, 'index'])->name('events');
        
          Route::resource('web-event', 'WebEventController');
        Route::resource('news', 'NewsController');
        Route::resource('gallery', 'GalleryController');
        Route::resource('faq', 'FaqController');
        Route::resource('testimonial', 'TestimonialController');
        Route::resource('page', 'PageController');
        Route::resource('call-to-action', 'CallToActionController');
        Route::resource('social-setting', 'SocialSettingController');
        Route::resource('topbar-setting', 'TopbarSettingController');
        
    });


});


// Student Login Routes
Route::prefix('student')->name('student.')->namespace('Student')->group(function(){
    
    Route::namespace('Auth')->group(function(){
            
        // Login Routes
        Route::get('/login','LoginController@showLoginForm')->name('login');
        Route::post('/login','LoginController@login')->name('login.store');
        Route::post('/logout','LoginController@logout')->name('logout');

        // Register Routes
        // Route::get('/register','RegisterController@showRegisterForm')->name('register');
        // Route::post('/register','RegisterController@register')->name('register.store');

        // Forgot Password Routes
        // Route::get('/password/reset','ForgotPasswordController@showLinkRequestForm')->name('password.request');
        // Route::post('/password/email','ForgotPasswordController@sendResetLinkEmail')->name('password.email');

        // Reset Password Routes
        // Route::get('/password/reset/{token}/{email}','ResetPasswordController@showResetForm')->name('password.reset');
        // Route::post('/password/reset','ResetPasswordController@reset')->name('password.update');
    });

});



// Student Dashboard Routes
Route::middleware(['auth:student', 'XSS'])->prefix('student')->name('student.')->namespace('Student')->group(function () {

    // Dashboard Route
    
    Route::get('/', 'DashboardController@index')->name('dashboard.index');
    Route::get('dashboard', 'DashboardController@index')->name('dashboard.index');

    // Transcript Routes
    Route::get('transcript', 'TranscriptController@index')->name('transcript.index');

    // Assignment Routes
    Route::get('assignment', 'AssignmentController@index')->name('assignment.index');
    Route::get('assignment/{id}', 'AssignmentController@show')->name('assignment.show');
    Route::post('assignment/{id}/update', 'AssignmentController@update')->name('assignment.update');

    // Class Routine Routes
    Route::get('class-routine', 'ClassRoutineController@index')->name('class-routine.index');

    // Attendance Report
    Route::get('attendance', 'AttendanceController@index')->name('attendance.index');

    // Exam Routine Routes
    Route::get('exam-routine', 'ExamRoutineController@index')->name('exam-routine.index');

    // Fees Routes
    Route::get('fees', 'FeesController@index')->name('fees.index');
    Route::get('fees/pay/{id}', 'FeesController@pay')->name('fees.pay');

  
     // Custom delete route
Route::delete('student/subjects/remove/{id}', [StudentSubjectController::class, 'destroy'])
    ->name('student.subjects.remove');

// Resource route (keep this)
Route::resource('subject', 'App\Http\Controllers\Student\StudentSubjectController');

    // Library Routes
    Route::get('library', 'LibraryController@index')->name('library.index');

    // Calendar Routes
    // Route::get('event-calendar', 'EventController@calendar')->name('event.calendar');

    // Notice Routes
    Route::get('notice', 'NoticeController@index')->name('notice.index');
    Route::get('notice/{id}', 'NoticeController@show')->name('notice.show');

    // Leave Routes
    Route::resource('leave', 'LeaveController');

    // Download Routes
    Route::get('download', 'DownloadCenterController@index')->name('download.index');
    Route::get('download/{id}', 'DownloadCenterController@show')->name('download.show');

    // Profile Routes
    Route::resource('profile','ProfileController');
    Route::get('profile/account', 'ProfileController@account')->name('profile.account');
    // Route::post('profile/changemail', 'ProfileController@changeMail')->name('profile.changemail');
    // Route::post('profile/changepass', 'ProfileController@changePass')->name('profile.changepass');



Route::get('/all/ditigal/file/student', [FileController::class, 'DigitalFilestudent'])->name('studentlibrarydigital');
Route::get('/student/test/', [StudentFileController::class, 'testFile'])->name('testfile');
Route::get('/student/all/ditigal/file/student', [\App\Http\Controllers\Student\FileController::class, 'DigitalFilestudent'])->name('student.studentlibrarydigital');

    
// Remove any existing route definition and use this:
Route::get('/student/digital/material/{id}/view', [App\Http\Controllers\Admin\FileController::class, 'viewMaterial'])
    ->name('digital.material.view');

});