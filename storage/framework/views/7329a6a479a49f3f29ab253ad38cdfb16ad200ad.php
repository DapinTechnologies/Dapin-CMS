
<?php $__env->startSection('title', $title); ?>

<?php $__env->startSection('content'); ?>
<div class="main-body">
    <div class="page-wrapper">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>All Exam Timetables</h5>
                    </div>
                    
                    <div class="card-block">
                        <p style="background-color: #fff8e1; color: #795548; padding: 15px; border-left: 6px solid #ffb300;">
                            <strong>Notice:</strong> Use the filter to narrow down the exam report listings.
                        </p>

                        <a href="<?php echo e(route($route.'.index')); ?>" class="btn btn-info"><i class="fas fa-sync-alt"></i> <?php echo e(__('btn_refresh')); ?></a>

                        <button type="button" class="btn btn-primary" id="toggle-filter-btn">
                            <i class="fas fa-filter"></i> <?php echo e(__('btn_filter')); ?>

                        </button>
                    </div>

                    <div class="card-block" id="filter-section" style="display: none;">
                        <form class="needs-validation" novalidate method="get" action="<?php echo e(route($route.'.index')); ?>">
                            <div class="row">

                                
                                <div class="form-group col-md-3">
                                    <label for="faculty"><?php echo e(__('field_faculty')); ?> <span>*</span></label>
                                    <select class="form-control" name="faculty" id="faculty" required>
                                        <option value=""><?php echo e(__('select')); ?></option>
                                        <?php $__currentLoopData = $faculties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $faculty): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($faculty->id); ?>" <?php if($selected_faculty == $faculty->id): ?> selected <?php endif; ?>>
                                                <?php echo e($faculty->title); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                               

                               
                               


                                
                                <div class="form-group col-md-3">
                                    <label for="type"><?php echo e(__('field_type')); ?> <span>*</span></label>
                                    <select class="form-control" name="type" id="type" required>
                                        <option value=""><?php echo e(__('select')); ?></option>
                                        <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($type->id); ?>" <?php if($selected_type == $type->id): ?> selected <?php endif; ?>>
                                                <?php echo e($type->title); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <div class="form-group col-md-3 align-self-end">
                                    <button type="submit" class="btn btn-info">
                                        <i class="fas fa-search"></i> <?php echo e(__('btn_filter')); ?>

                                    </button>
                                </div>

                            </div>
                        </form>
                    </div>

                    <div class="card-block">
                        <?php if(isset($rows) && count($rows)): ?>
                        <div class="table-responsive">
                            <table class="display table table-striped table-hover nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th><?php echo e(__('field_faculty')); ?></th>
                                        
                                        
                                        <th><?php echo e(__('field_type')); ?></th>
                                        <th><?php echo e(__('field_start_date')); ?></th>
                                        <th><?php echo e(__('field_end_date')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($key + 1); ?></td>
                                        <td><?php echo e($row->faculty_title ?? 'N/A'); ?></td>
                                        
                                        <td><?php echo e($row->exam_type_title ?? 'N/A'); ?></td>
                                        <td><?php echo e(isset($setting->date_format) ? date($setting->date_format, strtotime($row->date)) : date("Y-m-d", strtotime($row->date))); ?></td>
                                        <td><?php echo e(isset($setting->date_format) 
                                                ? date($setting->date_format, strtotime($row->end_date ?? $row->date)) 
                                                : date("Y-m-d", strtotime($row->end_date ?? $row->date))); ?></td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                        <?php else: ?>
                            <p class="text-center text-muted"><?php echo e(__('No data found.')); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->startSection('page_js'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleFilterBtn = document.getElementById('toggle-filter-btn');
        const filterSection = document.getElementById('filter-section');

        toggleFilterBtn.addEventListener('click', function() {
            filterSection.style.display = (filterSection.style.display === 'none') ? 'block' : 'none';
        });

        if (new URLSearchParams(window.location.search).toString() !== '') {
            filterSection.style.display = 'block';
        }

       
    });
</script>
<?php $__env->stopSection(); ?>
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Toastr for notifications (if you're using it) -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\Dapin-CMS-main\resources\views/admin/exam-routine-repo/index.blade.php ENDPATH**/ ?>