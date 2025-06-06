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
                        <h5><?php echo e($title); ?></h5>
                    </div>
                    <div class="card-block">
                        <form class="needs-validation" novalidate method="get" action="<?php echo e(route($route .'.subject-attendance')); ?>">
                            <div class="row gx-2">
                                <div class="form-group col-md-3">
                                    <label for="faculty"><?php echo e(__('field_faculty')); ?> <span>*</span></label>
                                    <select class="form-control faculty" name="faculty" id="faculty" required>
                                        <option value=""><?php echo e(__('select')); ?></option>
                                        <?php if(isset($faculties)): ?>
                                        <?php $__currentLoopData = $faculties->sortBy('title'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $faculty): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($faculty->id); ?>" <?php if( $selected_faculty == $faculty->id): ?> selected <?php endif; ?>><?php echo e($faculty->title); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </select>

                                    <div class="invalid-feedback">
                                        <?php echo e(__('required_field')); ?> <?php echo e(__('field_faculty')); ?>

                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="program"><?php echo e(__('field_program')); ?> <span>*</span></label>
                                    <select class="form-control program" name="program" id="program" required>
                                        <option value=""><?php echo e(__('select')); ?></option>
                                        <?php if(isset($programs)): ?>
                                        <?php $__currentLoopData = $programs->sortBy('title'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $program): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($program->id); ?>" <?php if( $selected_program == $program->id): ?> selected <?php endif; ?>><?php echo e($program->title); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </select>

                                    <div class="invalid-feedback">
                                        <?php echo e(__('required_field')); ?> <?php echo e(__('field_program')); ?>

                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="session"><?php echo e(__('field_session')); ?> <span>*</span></label>
                                    <select class="form-control session" name="session" id="session" required>
                                        <option value=""><?php echo e(__('select')); ?></option>
                                        <?php if(isset($sessions)): ?>
                                        <?php $__currentLoopData = $sessions->sortByDesc('id'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $session): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($session->id); ?>" <?php if( $selected_session == $session->id): ?> selected <?php endif; ?>><?php echo e($session->title); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </select>

                                    <div class="invalid-feedback">
                                        <?php echo e(__('required_field')); ?> <?php echo e(__('field_session')); ?>

                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="subject"><?php echo e(__('field_subject')); ?> <span>*</span></label>
                                    <select class="form-control subject" name="subject" id="subject" required>
                                        <option value=""><?php echo e(__('select')); ?></option>
                                        <?php if(isset($subjects)): ?>
                                        <?php $__currentLoopData = $subjects->sortBy('code'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($subject->id); ?>" <?php if( $selected_subject == $subject->id): ?> selected <?php endif; ?>><?php echo e($subject->code); ?> - <?php echo e($subject->title); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </select>

                                    <div class="invalid-feedback">
                                        <?php echo e(__('required_field')); ?> <?php echo e(__('field_subject')); ?>

                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <button type="submit" class="btn btn-info btn-filter"><i class="fas fa-search"></i> <?php echo e(__('btn_search')); ?></button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <?php if(isset($attendances) && isset($rows)): ?>
                    <div class="card-header">
                        <p><?php echo e(__('attendance_present')); ?>: <span class="text-primary"><?php echo e(__('P')); ?></span> | <?php echo e(__('attendance_absent')); ?>: <span class="text-danger"><?php echo e(__('A')); ?></span> | <?php echo e(__('attendance_leave')); ?>: <span class="text-success"><?php echo e(__('L')); ?></span> | <?php echo e(__('attendance_holiday')); ?>: <span class="text-warning"><?php echo e(__('H')); ?></span></p>
                    </div>
                    <div class="card-block">
                        <!-- [ Data table ] start -->
                        <div class="table-responsive">
                            <table class="table table-attendance table-striped table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th><?php echo e(__('field_student_id')); ?></th>
                                        <th><?php echo e(__('field_name')); ?></th>
                                        <th><?php echo e(__('field_semester')); ?></th>
                                        <th><?php echo e(__('field_section')); ?></th>
                                        <th><?php echo e(__('field_period')); ?></th>
                                        <th><?php echo e(__('P')); ?></th>
                                        <th><?php echo e(__('A')); ?></th>
                                        <th><?php echo e(__('L')); ?></th>
                                        <th><?php echo e(__('H')); ?></th>
                                        <th><?php echo e(__('%')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                  <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td>
                                            <?php if(isset($row->student->student_id)): ?>
                                            <a href="<?php echo e(route('admin.student.show', $row->student->id)); ?>">
                                            #<?php echo e($row->student->student_id ?? ''); ?>

                                            </a>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e($row->student->first_name ?? ''); ?> <?php echo e($row->student->last_name ?? ''); ?></td>
                                        <td><?php echo e($row->semester->title ?? ''); ?></td>
                                        <td><?php echo e($row->section->title ?? ''); ?></td>
                                        <?php
                                            $total_present = 0;
                                            $total_absent = 0;
                                            $total_leave = 0;
                                            $total_holiday = 0;
                                        ?>
                                        <?php if(isset($attendances)): ?>
                                        <?php $__currentLoopData = $attendances; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user_attend): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($user_attend->studentEnroll->student_id == $row->student_id): ?>
                                            <?php if($user_attend->attendance == 1): ?>
                                            <?php
                                                $total_present = $total_present + 1;
                                            ?>
                                            <?php elseif($user_attend->attendance == 2): ?>
                                            <?php
                                                $total_absent = $total_absent + 1;
                                            ?>
                                            <?php elseif($user_attend->attendance == 3): ?>
                                            <?php
                                                $total_leave = $total_leave + 1;
                                            ?>
                                            <?php elseif($user_attend->attendance == 4): ?>
                                            <?php
                                                $total_holiday = $total_holiday + 1;
                                            ?>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                        <?php
                                            $total_working_days = $total_present + $total_absent + $total_leave;
                                        ?>
                                        <td><?php echo e($total_working_days); ?></td>
                                        <td><?php echo e($total_present); ?></td>
                                        <td><?php echo e($total_absent); ?></td>
                                        <td><?php echo e($total_leave); ?></td>
                                        <td><?php echo e($total_holiday); ?></td>
                                        <?php
                                            if($total_working_days == 0){
                                                $total_working_days = 1;
                                            }
                                        ?>
                                        <td><?php echo e(round((($total_present / $total_working_days) * 100), 2)); ?> %</td>
                                    </tr>
                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>

                                <caption><?php echo e($row->program->title ?? ''); ?> - <?php echo e($row->session->title ?? ''); ?></caption>
                            </table>
                        </div>
                        <!-- [ Data table ] end -->
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

<?php $__env->stopSection(); ?>

<?php $__env->startSection('page_js'); ?>
<script type="text/javascript">
    "use strict";
    $(".faculty").on('change',function(e){
      e.preventDefault(e);
      var program=$(".program");
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      $.ajax({
        type:'POST',
        url: "<?php echo e(route('filter-program')); ?>",
        data:{
          _token:$('input[name=_token]').val(),
          faculty:$(this).val()
        },
        success:function(response){
            // var jsonData=JSON.parse(response);
            $('option', program).remove();
            $('.program').append('<option value=""><?php echo e(__("select")); ?></option>');
            $.each(response, function(){
              $('<option/>', {
                'value': this.id,
                'text': this.title
              }).appendTo('.program');
            });
          }

      });
    });

    $(".program").on('change',function(e){
      e.preventDefault(e);
      var session=$(".session");
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      $.ajax({
        type:'POST',
        url: "<?php echo e(route('filter-session')); ?>",
        data:{
          _token:$('input[name=_token]').val(),
          program:$(this).val()
        },
        success:function(response){
            // var jsonData=JSON.parse(response);
            $('option', session).remove();
            $('.session').append('<option value=""><?php echo e(__("select")); ?></option>');
            $.each(response, function(){
              $('<option/>', {
                'value': this.id,
                'text': this.title
              }).appendTo('.session');
            });
          }

      });
    });

    $(".session").on('change',function(e){
      e.preventDefault(e);
      var subject=$(".subject");
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      $.ajax({
        type:'POST',
        url: "<?php echo e(route('filter-techer-subject')); ?>",
        data:{
          _token:$('input[name=_token]').val(),
          session:$(this).val(),
          program:$('.program option:selected').val()
        },
        success:function(response){
            // var jsonData=JSON.parse(response);
            $('option', subject).remove();
            $('.subject').append('<option value=""><?php echo e(__("select")); ?></option>');
            $.each(response, function(){
              $('<option/>', {
                'value': this.id,
                'text': this.code +' - '+ this.title
              }).appendTo('.subject');
            });
          }

      });
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\college\resources\views\admin\report\subject-attendance.blade.php ENDPATH**/ ?>