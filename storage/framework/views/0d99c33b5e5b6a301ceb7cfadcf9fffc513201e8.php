
<?php $__env->startSection('title', $title); ?>
<?php $__env->startSection('content'); ?>

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Top Students by Program</h5>
                    </div>
                    <div class="card-block">
                        <form class="needs-validation" novalidate method="get" action="<?php echo e(route('admin.result2-repo.index')); ?>">
    <div class="row gx-2">
        <div class="form-group col-md-3">
            <label for="faculty"><?php echo e(__('field_faculty')); ?></label>
            <select class="form-control" name="faculty" id="faculty">
                <option value=""><?php echo e(__('all')); ?></option>
                <?php $__currentLoopData = $faculties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $faculty): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($faculty->id); ?>" <?php if($selected_faculty == $faculty->id): ?> selected <?php endif; ?>><?php echo e($faculty->title); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <div class="form-group col-md-3">
            <label for="program"><?php echo e(__('field_program')); ?></label>
            <select class="form-control" name="program" id="program">
                <option value=""><?php echo e(__('all')); ?></option>
                <?php if(isset($selected_faculty)): ?>
                    <?php $__currentLoopData = $programs->where('faculty_id', $selected_faculty); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $program): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($program->id); ?>" <?php if($selected_program == $program->id): ?> selected <?php endif; ?>><?php echo e($program->title); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <?php $__currentLoopData = $programs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $program): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($program->id); ?>" <?php if($selected_program == $program->id): ?> selected <?php endif; ?>><?php echo e($program->title); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            </select>
        </div>

        <div class="form-group col-md-3">
            <label for="semester"><?php echo e(__('field_semester')); ?></label>
            <select class="form-control" name="semester" id="semester">
                <option value=""><?php echo e(__('all')); ?></option>
                <?php $__currentLoopData = $semesters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $semester): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($semester->id); ?>" <?php if($selected_semester == $semester->id): ?> selected <?php endif; ?>><?php echo e($semester->title); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <div class="form-group col-md-3">
            <button type="submit" class="btn btn-info btn-filter mt-4">
                <i class="fas fa-search"></i> <?php echo e(__('btn_search')); ?>

            </button>
        </div>
    </div>
</form>
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <a href="<?php echo e(route('admin.result2-repo.index')); ?>" class="btn btn-info">
                            <i class="fas fa-sync-alt"></i> <?php echo e(__('btn_refresh')); ?>

                        </a>
                        <button type="button" class="btn btn-dark btn-print">
                            <i class="fas fa-print"></i> <?php echo e(__('btn_print')); ?>

                        </button>
                    </div>

                    <div class="card-block">
                        <?php if(count($rows) > 0): ?>
                        <div class="table-responsive">
                            <table class="display table nowrap table-striped table-hover printable">
                                <thead>
                                    <tr>
                                        <th>Rank</th>
                                        <th>Student Name</th>
                                        <th>Course</th>
                                        <th>Average Grade</th>
                                        <th>Performance Trend</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td>
                                                <?php if($index + 1 == 1): ?>
                                                    <span class="badge bg-warning text-dark" style="background: linear-gradient(to right, #FFD700, #D4AF37) !important;">
                                                        <i class="fas fa-trophy"></i> 1st
                                                    </span>
                                                <?php elseif($index + 1 == 2): ?>
                                                    <span class="badge bg-secondary" style="background: linear-gradient(to right, #C0C0C0, #A8A8A8) !important;">
                                                        <i class="fas fa-medal"></i> 2nd
                                                    </span>
                                                <?php elseif($index + 1 == 3): ?>
                                                    <span class="badge bg-danger" style="background: linear-gradient(to right, #CD7F32, #B87333) !important;">
                                                        <i class="fas fa-award"></i> 3rd
                                                    </span>
                                                <?php else: ?>
                                                    <?php echo e($index + 1); ?>

                                                <?php endif; ?>
                                            </td>
                                        <td>
    <div class="d-flex align-items-center">
        <?php
            // Default avatar path
            $photoPath = asset('dashboard/images/user/avatar-2.jpg');
            
            // If student has photo
            if ($row['student']->photo) {
                if (Str::startsWith($row['student']->photo, 'http')) {
                    $photoPath = $row['student']->photo;
                } else {
                    $photoPath = asset('storage/' . ltrim($row['student']->photo, '/'));
                }
            }
        ?>
        
        <div class="student-avatar me-2">
            <img src="<?php echo e($photoPath); ?>" 
                 class="rounded-circle" 
                 alt="<?php echo e($row['student']->first_name); ?>"
                 onerror="this.onerror=null;this.src='<?php echo e(asset('dashboard/images/user/avatar-2.jpg')); ?>'">
        </div>
        <div>
            <?php echo e($row['student']->first_name); ?> <?php echo e($row['student']->last_name); ?>

            <?php if(!$row['student']->photo): ?>
                <small class="text-muted d-block">No photo uploaded</small>
            <?php endif; ?>
        </div>
    </div>
</td>
                                            <td>
                                                <?php echo e($row['program']->title); ?>

                                                <?php
                                                    $percentage = $row['total_marks'];
                                                    $color = 'bg-danger'; // red by default
                                                    if ($percentage >= 70) {
                                                        $color = 'bg-success'; // green
                                                    } elseif ($percentage >= 40) {
                                                        $color = 'bg-warning'; // yellow
                                                    }
                                                ?>
                                                <div class="progress mt-2" style="height: 10px;">
                                                    <div class="progress-bar <?php echo e($color); ?>" role="progressbar" style="width: <?php echo e($percentage); ?>%;" aria-valuenow="<?php echo e($percentage); ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                               
                                            </td>
                                            <td><?php echo e($row['total_marks']); ?>%</td>
                                            <td>
    <a href="<?php echo e(route('admin.result-repo.index')); ?>" class="btn btn-sm btn-primary">
        <i class="fas fa-file-alt"></i> View Results
    </a>
</td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                        <?php else: ?>
                        <div class="card-block">
                            <h5><?php echo e(__('no_result_found')); ?></h5>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\Dapin-CMS-main\resources\views/admin/result2-repo/index.blade.php ENDPATH**/ ?>