 

<?php $__env->startSection('title', $title); ?>

<?php $__env->startSection('content'); ?>
<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">

            
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header"><h5>Department Summary</h5></div>
                    <div class="card-block">
                        <form class="needs-validation" novalidate method="get" action="<?php echo e(route($route . '.index')); ?>">
                            <div class="row gx-2">
                                <div class="form-group col-md-4">
                                    <label for="faculty"><?php echo e(__('field_faculty')); ?></label>
                                    <select class="form-control" name="faculty" id="faculty">
                                        <option value=""><?php echo e(__('all')); ?></option>
                                        <?php $__currentLoopData = $faculties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $faculty): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($faculty->id); ?>" 
                                                <?php if($selected_faculty == $faculty->id): ?> selected <?php endif; ?>>
                                                <?php echo e($faculty->title); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="program"><?php echo e(__('field_program')); ?></label>
                                    <select class="form-control" name="program" id="program">
                                        <option value=""><?php echo e(__('all')); ?></option>
                                        <?php if(isset($programs)): ?>
                                            <?php $__currentLoopData = $programs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $program): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($program->id); ?>" 
                                                    <?php if($selected_program == $program->id): ?> selected <?php endif; ?>>
                                                    <?php echo e($program->title); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                               

                                <div class="form-group col-md-4">
                                    <label for="teacher"><?php echo e(__('field_teacher')); ?></label>
                                    <select class="form-control select2" name="teacher" id="teacher">
                                        <option value=""><?php echo e(__('all')); ?></option>
                                        <?php $__currentLoopData = $teachers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $teacher): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($teacher->id); ?>" 
                                                <?php if($selected_teacher == $teacher->id): ?> selected <?php endif; ?>>
                                                <?php echo e($teacher->first_name); ?> <?php echo e($teacher->last_name); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="exam_type"><?php echo e(__('field_type')); ?></label>
                                    <select class="form-control" name="exam_type" id="exam_type">
                                        <option value=""><?php echo e(__('all')); ?></option>
                                        <?php $__currentLoopData = $exam_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($type->id); ?>" 
                                                <?php if($selected_exam_type == $type->id): ?> selected <?php endif; ?>>
                                                <?php echo e($type->title); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <div class="form-group col-md-2">
                                    <button type="submit" class="btn btn-info mt-4">
                                        <i class="fas fa-search"></i> <?php echo e(__('btn_search')); ?>

                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

          <?php if(count($rows) > 0): ?>
<div class="col-sm-12 mb-4">
    <div class="row">
        
        <div class="col-md-3 mb-3 mb-md-0">
            <div class="card border-left-primary shadow h-100 py-2" style="background: linear-gradient(to right, #f8f9fc 0%, #e6f3ff 100%);">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Trainers</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php
                                    $uniqueTeachers = collect($rows)->unique('teacher.id')->count();
                                ?>
                                <?php echo e($uniqueTeachers); ?>

                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chalkboard-teacher fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="col-md-3 mb-3 mb-md-0">
            <div class="card border-left-success shadow h-100 py-2" style="background: linear-gradient(to right, #f8f9fc 0%, #e6f8f0 100%);">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Average Pass Rate</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php
                                    $totalPassRate = collect($rows)->avg('pass_rate');
                                ?>
                                <?php echo e(round($totalPassRate, 2)); ?>%
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-percentage fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="col-md-3 mb-3 mb-md-0">
            <div class="card border-left-info shadow h-100 py-2" style="background: linear-gradient(to right, #f8f9fc 0%, #e6f6ff 100%);">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Best Performing Trainer</div>
                            <?php
                                $bestTeacher = collect($rows)->groupBy('teacher.id')->map(function($courses) {
                                    return [
                                        'teacher' => $courses->first()['teacher'],
                                        'avg_pass_rate' => $courses->avg('pass_rate'),
                                        'total_courses' => $courses->count()
                                    ];
                                })->sortByDesc('avg_pass_rate')->first();
                            ?>
                            <div class="h6 mb-0 font-weight-bold text-gray-800">
                                <?php echo e($bestTeacher['teacher']->name ?? 'N/A'); ?> (<?php echo e(round($bestTeacher['avg_pass_rate'] ?? 0, 2)); ?>%)
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-trophy fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="col-md-3">
            <div class="card border-left-warning shadow h-100 py-2" style="background: linear-gradient(to right, #f8f9fc 0%, #fff8e6 100%);">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Lowest Performing Trainer</div>
                            <?php
                                $worstTeacher = collect($rows)->groupBy('teacher.id')->map(function($courses) {
                                    return [
                                        'teacher' => $courses->first()['teacher'],
                                        'avg_pass_rate' => $courses->avg('pass_rate'),
                                        'total_courses' => $courses->count()
                                    ];
                                })->sortBy('avg_pass_rate')->first();
                            ?>
                            <div class="h6 mb-0 font-weight-bold text-gray-800">
                                <?php echo e($worstTeacher['teacher']->name ?? 'N/A'); ?> (<?php echo e(round($worstTeacher['avg_pass_rate'] ?? 0, 2)); ?>%)
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
            
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <a href="<?php echo e(route($route . '.index')); ?>" class="btn btn-info">
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
                                        <th>Trainer</th>
                                        <th><?php echo e(__('field_type')); ?></th>
                                        <th><?php echo e(__('field_subject')); ?></th>
                                        <th>Total Students</th>
                                        <th>Passed</th>
                                        <th>Failed</th>
                                        <th>Pass Rate (%)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($row['teacher']->name ?? 'N/A'); ?></td>
                                            <td><?php echo e($row['exam_type'] ?? 'N/A'); ?></td>
                                            <td><?php echo e($row['subject']->name ?? 'N/A'); ?> (<?php echo e($row['subject']->code ?? ''); ?>)</td>
                                            <td><?php echo e($row['total_students']); ?></td>
                                            <td><?php echo e($row['passed']); ?></td>
                                            <td><?php echo e($row['failed']); ?></td>
                                            <td><?php echo e($row['pass_rate']); ?>%</td>
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
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\Dapin-CMS-main\resources\views/admin/department-repo/index.blade.php ENDPATH**/ ?>