<div class="form-group">
  <label for="faculty"><?php echo e(__('field_faculty')); ?> <span>*</span></label>
  <select class="form-control faculty" name="faculty" id="faculty" required>
		<option value=""><?php echo e(__('select')); ?></option>
		<?php if(isset($faculties)): ?>
		<?php $__currentLoopData = $faculties->sortBy('title'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $faculty): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		<option value="<?php echo e($faculty->id); ?>" <?php if(isset($row)): ?> <?php echo e($row->program->faculty_id == $faculty->id ? 'selected' : ''); ?> <?php endif; ?>><?php echo e($faculty->title); ?></option>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		<?php endif; ?>
	</select>

	<div class="invalid-feedback">
		<?php echo e(__('required_field')); ?> <?php echo e(__('field_faculty')); ?>

	</div>
</div>
<div class="form-group">
  <label for="program"><?php echo e(__('field_program')); ?> <span>*</span></label>
  <select class="form-control program" name="program" id="program" required>
		<option value=""><?php echo e(__('select')); ?></option>
		<?php if(isset($programs)): ?>
		<?php $__currentLoopData = $programs->sortBy('title'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $program): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		<option value="<?php echo e($program->id); ?>" <?php if(isset($row)): ?> <?php echo e($row->program_id == $program->id ? 'selected' : ''); ?> <?php endif; ?>><?php echo e($program->title); ?></option>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		<?php endif; ?>
	</select>

	<div class="invalid-feedback">
		<?php echo e(__('required_field')); ?> <?php echo e(__('field_program')); ?>

	</div>
</div>
<div class="form-group">
  <label for="semester"><?php echo e(__('field_semester')); ?> <span>*</span></label>
  <select class="form-control semester" name="semester" id="semester" required>
		<option value=""><?php echo e(__('select')); ?></option>
		<?php if(isset($semesters)): ?>
		<?php $__currentLoopData = $semesters->sortBy('id'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $semester): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		<option value="<?php echo e($semester->id); ?>" <?php if(isset($row)): ?> <?php echo e($row->semester_id == $semester->id ? 'selected' : ''); ?> <?php endif; ?>><?php echo e($semester->title); ?></option>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		<?php endif; ?>
	</select>

	<div class="invalid-feedback">
		<?php echo e(__('required_field')); ?> <?php echo e(__('field_semester')); ?>

	</div>
</div>
<div class="form-group">
  <label for="section"><?php echo e(__('field_section')); ?> <span>*</span></label>
  <select class="form-control section" name="section" id="section" required>
		<option value=""><?php echo e(__('select')); ?></option>
		<?php if(isset($sections)): ?>
		<?php $__currentLoopData = $sections->sortBy('title'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		<option value="<?php echo e($section->id); ?>" <?php if(isset($row)): ?> <?php echo e($row->section_id == $section->id ? 'selected' : ''); ?> <?php endif; ?>><?php echo e($section->title); ?></option>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		<?php endif; ?>
	</select>

	<div class="invalid-feedback">
		<?php echo e(__('required_field')); ?> <?php echo e(__('field_section')); ?>

	</div>
</div>


<script src="<?php echo e(asset('dashboard/plugins/jquery/js/jquery.min.js')); ?>"></script>

<script type="text/javascript">
    "use strict";
    $(".faculty").on('change',function(e){
      e.preventDefault();
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
      e.preventDefault();
      var semester=$(".semester");
      var subject=$(".subject");
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      $.ajax({
        type:'POST',
        url: "<?php echo e(route('filter-semester')); ?>",
        data:{
          _token:$('input[name=_token]').val(),
          program:$(this).val()
        },
        success:function(response){
            // var jsonData=JSON.parse(response);
            $('option', semester).remove();
            $('.semester').append('<option value=""><?php echo e(__("select")); ?></option>');
            $.each(response, function(){
              $('<option/>', {
                'value': this.id,
                'text': this.title
              }).appendTo('.semester');
            });
          }

      });

      $.ajax({
        type:'POST',
        url: "<?php echo e(route('filter-subject')); ?>",
        data:{
          _token:$('input[name=_token]').val(),
          program:$(this).val()
        },
        success:function(response){
            // var jsonData=JSON.parse(response);
            $('option', subject).remove();
            $.each(response, function(){
              $('<option/>', {
                'value': this.id,
                'text': this.code +' - '+ this.title
              }).appendTo('.subject');
            });
          }

      });
    });

    $(".semester").on('change',function(e){
      e.preventDefault();
      var section=$(".section");
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      $.ajax({
        type:'POST',
        url: "<?php echo e(route('filter-section')); ?>",
        data:{
          _token:$('input[name=_token]').val(),
          semester:$(this).val(),
          program:$('.program option:selected').val()
        },
        success:function(response){
            // var jsonData=JSON.parse(response);
            $('option', section).remove();
            $('.section').append('<option value=""><?php echo e(__("select")); ?></option>');
            $.each(response, function(){
              $('<option/>', {
                'value': this.id,
                'text': this.title
              }).appendTo('.section');
            });
          }

      });
    });
</script><?php /**PATH C:\wamp64\www\Dapin-CMS-main\resources\views/common/inc/subject_enroll_filter.blade.php ENDPATH**/ ?>