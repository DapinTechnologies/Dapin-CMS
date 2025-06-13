
<?php $__env->startSection('title', $title); ?>

<?php $__env->startSection('content'); ?>
<div class="main-body">
    <div class="page-wrapper">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Invigilation Exam Schedule</h5>
                    </div>
                    
                    <div class="card-block">
                        <p style="background-color: #fff8e1; color: #795548; padding: 15px; border-left: 6px solid #ffb300;">
                            <strong>Notice:</strong> Search by teacher name and/or exam date to view schedules.
                        </p>

                        <a href="<?php echo e(route($route.'.index')); ?>" class="btn btn-info"><i class="fas fa-sync-alt"></i> <?php echo e(__('btn_refresh')); ?></a>

                        <button type="button" class="btn btn-primary" id="toggle-filter-btn">
                            <i class="fas fa-filter"></i> <?php echo e(__('btn_filter')); ?>

                        </button>
                    </div>

                    <div class="card-block" id="filter-section" style="display: none;">
                        <form class="needs-validation" novalidate method="get" action="<?php echo e(route($route.'.index')); ?>">
                            <div class="row">
                                <!-- Teacher Search Fields -->
                                <div class="form-group col-md-6">
                                    <label for="teacher_id">Select Teacher</label>
                                    <select class="form-control select2" name="teacher_id" id="teacher_id">
                                        <option value=""><?php echo e(__('select')); ?></option>
                                        <?php $__currentLoopData = $teachers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $teacher): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($teacher->id); ?>" 
                                                
                                                <?php echo e($teacher->first_name); ?> <?php echo e($teacher->last_name); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="exam_date">Exam Date</label>
                                    <input type="date" class="form-control" name="exam_date" id="exam_date" 
                                           value="<?php echo e($request->exam_date ?? ''); ?>">
                                </div>

                                <div class="form-group col-md-3 align-self-end">
                                    <button type="submit" class="btn btn-info btn-block">
                                        <i class="fas fa-search"></i> <?php echo e(__('btn_search')); ?>

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
            <th>Invigilitor</th>
            <th>Unit</th>
            
            <th>Date</th>
            <th>Start Time</th>
            <th>End Time</th>
            <th>Room</th>
            <th>Program</th>
            <th>Faculty</th>
        </tr>
    </thead>
    <tbody>
        <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td><?php echo e($key + 1); ?></td>
            <td>
                <?php if($row->users && $row->users->count() > 0): ?>
                    <?php echo e($row->users->map(fn($user) => $user->first_name . ' ' . $user->last_name)->implode(', ')); ?>

                <?php else: ?>
                    N/A
                <?php endif; ?>
            </td>
            <td>
                <?php if(isset($row->subject->title)): ?>
                    <?php echo e($row->subject->title); ?>

                    <?php if(isset($row->subject->name)): ?>
                        (<?php echo e($row->subject->id); ?>)
                    <?php endif; ?>
                <?php elseif(isset($row->subject_title)): ?>
                    <?php echo e($row->subject_title); ?>

                    <?php if(isset($row->subject_code)): ?>
                        (<?php echo e($row->subject_code); ?>)
                    <?php endif; ?>
                <?php else: ?>
                    N/A
                <?php endif; ?>
            </td>
           
    



            <td>
                <?php if(isset($row->date)): ?>
                    <?php echo e(isset($setting->date_format) ? date($setting->date_format, strtotime($row->date)) : date("Y-m-d", strtotime($row->date))); ?>

                <?php else: ?>
                    N/A
                <?php endif; ?>
            </td>
            <td>
                <?php if(isset($row->start_time)): ?>
                    <?php echo e(date('h:i A', strtotime($row->start_time))); ?>

                <?php else: ?>
                    N/A
                <?php endif; ?>
            </td>
            <td>
                <?php if(isset($row->end_time)): ?>
                    <?php echo e(date('h:i A', strtotime($row->end_time))); ?>

                <?php else: ?>
                    N/A
                <?php endif; ?>
            </td>
            <td>
                                            <?php $__currentLoopData = $row->rooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php echo e($room->title); ?><?php if($loop->last): ?> <?php else: ?> , <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </td>
            <td><?php echo e($row->program->title ?? ($row->program_title ?? 'N/A')); ?></td>
            <td><?php echo e($row->program->faculty->title ?? 'N/A'); ?></td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>
                        </div>
                        <?php else: ?>
                            <p class="text-center text-muted"><?php echo e(__('No exam schedules found.')); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

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

        // Initialize Select2 for teacher dropdown
        $('.select2').select2({
            placeholder: "Select a teacher",
            allowClear: true
        });

        
        // Faculty-Program AJAX
        $('#faculty').change(function() {
            var faculty_id = $(this).val();
            $('#program').html('<option value="0"><?php echo e(__("all")); ?></option>');
            if (faculty_id != 0) {
                $.ajax({
                    url: "<?php echo e(route($route.'.index')); ?>",
                    type: "GET",
                    data: {
                        faculty_id: faculty_id
                    },
                    success: function(data) {
                        $.each(data, function(key, value) {
                            $("#program").append('<option value="' + value.id + '">' + value.title + '</option>');
                        });
                    }
                });
            }
        });
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\Dapin-CMS-main\resources\views/admin/exam-teacher-repo/index.blade.php ENDPATH**/ ?>