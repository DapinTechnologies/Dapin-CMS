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
                        <h5><?php echo e($title); ?> <?php echo e(__('btn_import')); ?></h5>
                    </div>
                    <div class="card-block">
                        <a href="<?php echo e(route($route.'.index')); ?>" class="btn btn-primary"><i class="fas fa-arrow-left"></i> <?php echo e(__('btn_back')); ?></a>

                        <a href="<?php echo e(route($route.'.import')); ?>" class="btn btn-info"><i class="fas fa-sync-alt"></i> <?php echo e(__('btn_refresh')); ?></a>
                    </div>

                    <div class="card-block">
                        <p>1. Your Excel data should be in the format of the download file. The first line of your Excel file should be the column headers as in the table example. Also make sure that your file is UTF-8 to avoid unnecessary encoding problems. <a href="<?php echo e(asset('dashboard/sample/exam.xlsx')); ?>" class="text-primary" download>Download Sample File</a></p><hr/>
                        <p>2. For "Attendance" use ( P=Present, A=Absent ).</p><hr/>
                        <p>3. "Achieve Marks" must contain a numeric value.</p><hr/>
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-block">
                        <form class="needs-validation" novalidate action="<?php echo e(route($route.'.import.store')); ?>" method="post" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                            <div class="row gx-2">
                                <div class="form-group col-md-3">
                                    <label for="session"><?php echo e(__('field_session')); ?> <span>*</span></label>
                                    <select class="form-control session" name="session" id="session" required>
                                        <option value=""><?php echo e(__('select')); ?></option>
                                        <?php $__currentLoopData = $sessions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $session): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($session->id); ?>" <?php if( old('session') == $session->id): ?> selected <?php endif; ?>><?php echo e($session->title); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                                        <option value="<?php echo e($subject->id); ?>" <?php if( old('subject') == $subject->id): ?> selected <?php endif; ?>><?php echo e($subject->code); ?> - <?php echo e($subject->title); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </select>

                                    <div class="invalid-feedback">
                                      <?php echo e(__('required_field')); ?> <?php echo e(__('field_subject')); ?>

                                    </div>
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="type"><?php echo e(__('field_type')); ?> <span>*</span></label>
                                    <select class="form-control" name="type" id="type" required>
                                        <option value=""><?php echo e(__('select')); ?></option>
                                        <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($type->id); ?>" <?php if( old('type') == $type->id): ?> selected <?php endif; ?>><?php echo e($type->title); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>

                                    <div class="invalid-feedback">
                                      <?php echo e(__('required_field')); ?> <?php echo e(__('field_type')); ?>

                                    </div>
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="date"><?php echo e(__('field_date')); ?> <span>*</span></label>
                                    <input type="date" class="form-control date" name="date" id="date" value="<?php echo e(date('Y-m-d')); ?>" required>
                                        
                                    <div class="invalid-feedback">
                                        <?php echo e(__('required_field')); ?> <?php echo e(__('field_date')); ?>

                                    </div>
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="import"><?php echo e(__('File xlsx')); ?> <span>*</span></label>
                                    <input type="file" class="form-control" name="import" id="import" value="<?php echo e(old('import')); ?>" accept=".xlsx" required>

                                    <div class="invalid-feedback">
                                      <?php echo e(__('required_field')); ?> <?php echo e(__('File xlsx')); ?>

                                    </div>
                                </div>

                                <div class="form-group col-md-3">
                                    <button type="submit" class="btn btn-info btn-filter"><i class="fas fa-upload"></i> <?php echo e(__('btn_upload')); ?></button>
                                </div>
                            </div>
                        </form>
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
<script type="text/javascript">
    "use strict";
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
          session:$(this).val()
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
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\business\backup\Dapin\Dapin\resources\views\admin\exam\import.blade.php ENDPATH**/ ?>