
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
                        <h5>Class Summary</h5>
                    </div>
                    <div class="card-block">
                        <form class="needs-validation" method="get" action="<?php echo e(route($route . '.index')); ?>">
                            <div class="row gx-2">

                                <!-- Faculty Filter -->
                                <div class="form-group col-md-3">
                                    <label for="faculty"><?php echo e(__('field_faculty')); ?></label>
                                    <select class="form-control select2" name="faculty" id="faculty">
                                        <option value="">All</option>
                                        <?php $__currentLoopData = $faculties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fac): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($fac->id); ?>" <?php echo e($selected_faculty == $fac->id ? 'selected' : ''); ?>>
                                                <?php echo e($fac->title); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <!-- Program Filter -->
                                <div class="form-group col-md-3">
                                    <label for="program"><?php echo e(__('field_program')); ?></label>
                                    <select class="form-control select2" name="program" id="program">
                                        <option value="">All</option>
                                        <?php $__currentLoopData = $programs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($prog->id); ?>" <?php echo e($selected_program == $prog->id ? 'selected' : ''); ?>>
                                                <?php echo e($prog->title); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <!-- Session Filter -->
                                <div class="form-group col-md-3">
                                    <label for="session"><?php echo e(__('field_session')); ?></label>
                                    <select class="form-control select2" name="session" id="session">
                                        <option value="">All</option>
                                        <?php $__currentLoopData = $sessions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sess): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($sess->id); ?>" <?php echo e($selected_session == $sess->id ? 'selected' : ''); ?>>
                                                <?php echo e($sess->title); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <!-- Semester Filter -->
                                <div class="form-group col-md-3">
                                    <label for="semester"><?php echo e(__('field_semester')); ?></label>
                                    <select class="form-control select2" name="semester" id="semester">
                                        <option value="">All</option>
                                        <?php $__currentLoopData = $semesters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($sem->id); ?>" <?php echo e($selected_semester == $sem->id ? 'selected' : ''); ?>>
                                                <?php echo e($sem->title); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <!-- Section Filter -->
                                <div class="form-group col-md-3">
                                    <label for="section"><?php echo e(__('field_section')); ?></label>
                                    <select class="form-control select2" name="section" id="section">
                                        <option value="">All</option>
                                        <?php $__currentLoopData = $sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sec): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($sec->id); ?>" <?php echo e($selected_section == $sec->id ? 'selected' : ''); ?>>
                                                <?php echo e($sec->title); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <!-- Subject Filter -->
                                <div class="form-group col-md-3">
                                    <label for="subject"><?php echo e(__('field_subject')); ?></label>
                                    <select class="form-control select2" name="subject" id="subject">
                                        <option value="">All</option>
                                        <?php $__currentLoopData = $subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($sub->id); ?>" <?php echo e($selected_subject == $sub->id ? 'selected' : ''); ?>>
                                                <?php echo e($sub->code); ?> - <?php echo e($sub->title); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <!-- Search Button -->
                                <div class="form-group col-md-3 align-self-end">
                                    <button type="submit" class="btn btn-info">
                                        <i class="fas fa-search"></i> <?php echo e(__('btn_search')); ?>

                                    </button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Statistics Table -->
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header"><h5>Summary</h5></div>
                    <div class="card-block">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                     <tr>
            <th><?php echo e(__('field_subject')); ?></th>
            <th><?php echo e(__('Total Students')); ?></th>
             <th><?php echo e(__('Highest Mark')); ?></th>
            <th><?php echo e(__('Lowest Mark')); ?></th>
            <th><?php echo e(__('Average Mark')); ?></th>
            <th><?php echo e(__('Distinction')); ?>(80-100)</th>
            <th><?php echo e(__('Merits')); ?>(70-79)</th>
            <th><?php echo e(__('Pass')); ?>(50-69)</th>
            <th><?php echo e(__('Fail')); ?>(0-49)</th>
            <th><?php echo e(__('Pass Percentage')); ?></th>
           
        </tr>
                                </thead>
                                <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $statistics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><?php echo e($stat['subject']->code); ?> - <?php echo e($stat['subject']->title); ?></td>
                                        <td><?php echo e($stat['total_students'] ?? 0); ?></td>
                                        <td><?php echo e($stat['highest'] ?? 'N/A'); ?></td>
                                        <td><?php echo e($stat['lowest'] ?? 'N/A'); ?></td>
                                        <td><?php echo e($stat['average'] ?? 'N/A'); ?></td>
                                        <td><?php echo e($stat['distinction'] ?? 0); ?></td> <!-- new -->
                                        <td><?php echo e($stat['merits'] ?? 0); ?></td>      <!-- new -->
                                        <td><?php echo e($stat['pass'] ?? 0); ?></td>
                                        <td><?php echo e($stat['fail'] ?? 0); ?></td>
                                        <td>
                                            <?php if(($stat['total_students'] ?? 0) > 0): ?>
                                                <?php echo e(round(($stat['pass'] / $stat['total_students']) * 100, 2)); ?>%
                                            <?php else: ?>
                                                0%
                                            <?php endif; ?>
                                        </td>
                                        
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="10" class="text-center"><?php echo e(__('no_result_found')); ?></td>
                                    </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

<?php $__env->stopSection(); ?>

<?php $__env->startSection('page_js'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\Dapin-CMS-main\resources\views/admin/subject-repo/index.blade.php ENDPATH**/ ?>