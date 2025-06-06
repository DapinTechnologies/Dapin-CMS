
<?php $__env->startSection('title', $title); ?>
<?php $__env->startSection('content'); ?>

<h4>Assign Multiple Fee Categories</h4>
<!-- Link to Assigned Fees History page -->
<a href="<?php echo e(route('admin.fees-student.assigned-history')); ?>" class="btn btn-info mb-3">
    View Assigned Fees History
</a>
<a href="<?php echo e(route('admin.fees-summary')); ?>" class="btn btn-info mb-3">View School Fees Summary</a>

<form method="POST" action="<?php echo e(route('admin.fees-student.store-multiple')); ?>">
    <?php echo csrf_field(); ?>

    <!-- Single select student -->
    <div class="form-group">
        <label>Select Student</label>
        <select name="student_id" class="form-control" required>
            <option value="">-- Select Student --</option>
            <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $enroll): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($enroll->student): ?>
                <option value="<?php echo e($enroll->id); ?>">
                    <?php echo e($enroll->student->student_id); ?> - <?php echo e($enroll->student->first_name); ?> <?php echo e($enroll->student->last_name); ?>

                </option>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>

    <!-- Categories + Amounts dynamic rows -->
    <div id="category-section">
        <div class="form-group d-flex category-row">
            <select name="categories[]" class="form-control" required>
                <option value="">-- Select Category --</option>
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($cat->id); ?>"><?php echo e($cat->title); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <input type="number" name="amounts[]" class="form-control ml-2" placeholder="Amount" min="0" required>
            <button type="button" class="btn btn-danger ml-2 remove-category-btn" title="Remove Category">&times;</button>
        </div>
    </div>

    <button type="button" class="btn btn-secondary mb-2" id="add-category-btn">+ Add Category</button>
    <button type="submit" class="btn btn-primary">Assign</button>
</form>
<?php if(session('success')): ?>
    <div class="alert alert-success"><?php echo e(session('success')); ?></div>
<?php endif; ?>

<?php if(session('assignedFees') && session('studentEnroll')): ?>
    <h5>Assigned Fees for 
        <?php echo e(session('studentEnroll')->student->student_id); ?> - 
        <?php echo e(session('studentEnroll')->student->first_name); ?> <?php echo e(session('studentEnroll')->student->last_name); ?>

    </h5>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Category</th>
                <th>Amount (Ksh)</th>
                <th>Assigned Date</th>
                <th>Due Date</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = session('assignedFees'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($fee->category->title ?? 'N/A'); ?></td>
                    <td><?php echo e(number_format($fee->fee_amount, 2)); ?></td>
                    <td><?php echo e(\Carbon\Carbon::parse($fee->assign_date)->format('d-M-Y')); ?></td>
                    <td><?php echo e(\Carbon\Carbon::parse($fee->due_date)->format('d-M-Y')); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
<?php endif; ?>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
    // Add new category + amount row
    $('#add-category-btn').on('click', function() {
        const newRow = `
            <div class="form-group d-flex category-row">
                <select name="categories[]" class="form-control" required>
                    <option value="">-- Select Category --</option>
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($cat->id); ?>"><?php echo e($cat->title); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <input type="number" name="amounts[]" class="form-control ml-2" placeholder="Amount" min="0" required>
                <button type="button" class="btn btn-danger ml-2 remove-category-btn" title="Remove Category">&times;</button>
            </div>`;
        $('#category-section').append(newRow);
    });

    // Remove category + amount row
    $('#category-section').on('click', '.remove-category-btn', function() {
        if ($('.category-row').length > 1) {
            $(this).closest('.category-row').remove();
        } else {
            alert('At least one category is required.');
        }
    });
});
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\college\resources\views\admin\fees-student\assign-multiple.blade.php ENDPATH**/ ?>