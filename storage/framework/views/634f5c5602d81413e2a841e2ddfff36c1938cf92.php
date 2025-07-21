

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?php echo e($title); ?></h1>
        <a href="<?php echo e(route($route.'.index')); ?>" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to List
        </a>
    </div>

    <!-- Student Search Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-primary text-white">
            <h6 class="m-0 font-weight-bold">Search Student</h6>
        </div>
        <div class="card-body">
            <form id="studentSearchForm">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="student_search">Search by Student ID or Name</label>
                            <input type="text" class="form-control" id="student_search" placeholder="Enter student ID or name">
                        </div>
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Search
                        </button>
                    </div>
                </div>
            </form>

            <div id="searchResults" class="mt-3" style="display: none;">
                <h6>Search Results</h6>
                <div class="list-group" id="studentList">
                    <!-- Results will be populated here -->
                </div>
            </div>
        </div>
    </div>

    <!-- Bursary Allocation Form -->
    <?php if($studentEnroll): ?>
    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-primary text-white">
            <h6 class="m-0 font-weight-bold">Bursary Allocation for <?php echo e($studentEnroll->student->full_name); ?> (ID: <?php echo e($studentEnroll->student->student_id); ?>)</h6>
        </div>
        <div class="card-body">
            <div class="alert alert-info">
                <h6>Student Information</h6>
                <hr>
                <div class="row">
                    <div class="col-md-4">
                        <p><strong>Program:</strong> <?php echo e($studentEnroll->program->title); ?></p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Faculty:</strong> <?php echo e($studentEnroll->program->faculty->title); ?></p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Current Semester:</strong> <?php echo e($studentEnroll->semester_id); ?></p>
                    </div>
                </div>
            </div>

            <div class="table-responsive mb-4">
                <table class="table table-bordered">
                    <thead class="thead-light">
                        <tr>
                            <th>Invoice No</th>
                            <th>Total Fee</th>
                            <th>Amount Paid</th>
                            <th>Bursary Allocated</th>
                            <th>Amount Due</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($invoice->invoice_no); ?></td>
                                <td><?php echo e(number_format($invoice->total_fee, 2)); ?></td>
                                <td><?php echo e(number_format($invoice->amount_paid, 2)); ?></td>
                                <td><?php echo e(number_format($invoice->bursary_allocated, 2)); ?></td>
                                <td><?php echo e(number_format($invoice->amount_due, 2)); ?></td>
                                <td>
                                    <?php if($invoice->payment_status == 'paid'): ?>
                                        <span class="badge bg-success">Paid</span>
                                    <?php else: ?>
                                        <span class="badge bg-<?php echo e($invoice->amount_due == $invoice->total_fee ? 'danger' : 'warning'); ?>">
                                            <?php echo e($invoice->amount_due == $invoice->total_fee ? 'Unpaid' : 'Partial'); ?>

                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-primary allocate-btn" 
                                            data-invoice-id="<?php echo e($invoice->id); ?>"
                                            data-max-amount="<?php echo e($invoice->amount_due); ?>">
                                        <i class="fas fa-hand-holding-usd"></i> Allocate Bursary
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="7" class="text-center">No outstanding invoices found for this student</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Bursary Allocation Modal -->
    <div class="modal fade" id="bursaryAllocationModal" tabindex="-1" role="dialog" aria-labelledby="bursaryAllocationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="bursaryAllocationModalLabel">
                        <i class="fas fa-hand-holding-usd me-2"></i> Allocate Bursary
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?php echo e(route($route.'.store')); ?>" method="POST" id="bursaryAllocationForm">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="student_enroll_id" id="student_enroll_id" value="<?php echo e($studentEnroll->id ?? ''); ?>">
                    <input type="hidden" name="invoice_id" id="invoice_id">
                    
                    <div class="modal-body">
                        <div class="alert alert-info">
                            <h6>Invoice Summary</h6>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Invoice No:</strong> <span id="modal_invoice_no"></span></p>
                                    <p><strong>Total Fee:</strong> <span id="modal_total_fee"></span></p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Amount Paid:</strong> <span id="modal_amount_paid"></span></p>
                                                                        <p><strong>Amount Due:</strong> <span id="modal_amount_due"></span></p>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="bursary_type" class="fw-bold">Bursary Type</label>
                            <select name="bursary_type" id="bursary_type" class="form-control" required>
                                <option value="">Select Bursary Type</option>
                                <?php $__currentLoopData = $bursaryTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($key); ?>"><?php echo e($type); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="amount" class="fw-bold">Amount to Allocate</label>
                            <input type="number" 
                                   name="amount" 
                                   id="amount" 
                                   class="form-control" 
                                   min="0.01" 
                                   step="0.01" 
                                   required
                                   placeholder="Enter amount to allocate">
                            <small class="text-muted">Maximum allocatable amount: <span id="max_amount_label">0.00</span></small>
                        </div>

                        <div class="form-group mb-3">
                            <label for="payment_date" class="fw-bold">Payment Date</label>
                            <input type="date" 
                                   name="payment_date" 
                                   id="payment_date" 
                                   class="form-control" 
                                   value="<?php echo e(date('Y-m-d')); ?>" 
                                   max="<?php echo e(date('Y-m-d')); ?>"
                                   required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="bursary_notes" class="fw-bold">Notes</label>
                            <textarea name="bursary_notes" 
                                      id="bursary_notes" 
                                      class="form-control" 
                                      rows="3" 
                                      placeholder="Any notes about this bursary allocation"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="fas fa-times me-1"></i> Cancel
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Allocate Bursary
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
$(document).ready(function() {
    // Student search functionality
    $('#studentSearchForm').submit(function(e) {
        e.preventDefault();
        var query = $('#student_search').val().trim();
        
        if(query.length < 3) {
            alert('Please enter at least 3 characters to search');
            return;
        }
        
        $.ajax({
            url: "<?php echo e(route('admin.bursary-allocation.search-students')); ?>",
            type: 'GET',
            data: { query: query },
            success: function(response) {
                var results = response.data;
                var $studentList = $('#studentList');
                
                $studentList.empty();
                
                if(results.length > 0) {
                    $.each(results, function(index, student) {
                        $studentList.append(`
                            <a href="<?php echo e(route($route.'.create')); ?>/${student.current_enroll.id}" 
                               class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">${student.full_name}</h6>
                                    <small>ID: ${student.student_id}</small>
                                </div>
                                <p class="mb-1">${student.current_enroll.program.title}</p>
                                <small>${student.current_enroll.program.faculty.title}</small>
                            </a>
                        `);
                    });
                    $('#searchResults').show();
                } else {
                    $studentList.append(`
                        <div class="list-group-item">
                            No students found matching your search criteria
                        </div>
                    `);
                    $('#searchResults').show();
                }
            },
            error: function(xhr) {
                alert('An error occurred while searching for students');
            }
        });
    });

    // Bursary allocation modal setup
    $(document).on('click', '.allocate-btn', function() {
        var invoiceId = $(this).data('invoice-id');
        var maxAmount = parseFloat($(this).data('max-amount'));
        var invoiceRow = $(this).closest('tr');
        
        // Set the invoice ID in the form
        $('#invoice_id').val(invoiceId);
        
        // Populate the modal with invoice details
        $('#modal_invoice_no').text(invoiceRow.find('td:eq(0)').text());
        $('#modal_total_fee').text(invoiceRow.find('td:eq(1)').text());
        $('#modal_amount_paid').text(invoiceRow.find('td:eq(2)').text());
        $('#modal_amount_due').text(invoiceRow.find('td:eq(4)').text());
        
        // Set the max amount for allocation
        $('#amount').attr('max', maxAmount);
        $('#max_amount_label').text(maxAmount.toFixed(2));
        
        // Show the modal
        $('#bursaryAllocationModal').modal('show');
    });

    // Validate amount doesn't exceed due amount
    $('#bursaryAllocationForm').submit(function(e) {
        var amount = parseFloat($('#amount').val());
        var maxAmount = parseFloat($('#amount').attr('max'));
        
        if(amount > maxAmount) {
            alert('Allocation amount cannot exceed the due amount of ' + maxAmount.toFixed(2));
            e.preventDefault();
            return false;
        }
        
        return true;
    });

    // Initialize date picker
    $('#payment_date').attr('max', new Date().toISOString().split('T')[0]);
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\Dapin-CMS-main\resources\views/admin/bursary-allocation/create.blade.php ENDPATH**/ ?>