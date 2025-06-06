
<?php $__env->startSection('title', 'Assign Fee Categories'); ?>
<?php $__env->startSection('content'); ?>

<h4>Assign Fee Categories</h4>

<form method="POST" action="<?php echo e(route('admin.fees-category.store-multiple')); ?>">
    <?php echo csrf_field(); ?>

    <!-- Dynamic Categories + Amounts -->
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

<!-- Display Assigned Categories & Amounts -->
<?php if(session('assignedCategories')): ?>
    <h5>Assigned Categories and Amounts:</h5>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Category</th>
                <th>Amount (Ksh)</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = session('assignedCategories'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($category['name']); ?></td>
                    <td><?php echo e(number_format($category['amount'], 2)); ?></td>
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

<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\college\resources\views\admin\fees-student\assign-fee-category.blade.php ENDPATH**/ ?>