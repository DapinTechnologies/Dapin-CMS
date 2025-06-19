<div class="form-group col-md-4">
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
<div class="form-group col-md-4">
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
<div class="form-group col-md-4">
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
<div class="form-group col-md-4">
  <label for="semester"><?php echo e(__('field_semester')); ?> <span>*</span></label>
  <select class="form-control semester" name="semester" id="semester" required>
		<option value="0"><?php echo e(__('all')); ?></option>
		<?php if(isset($semesters)): ?>
		<?php $__currentLoopData = $semesters->sortBy('id'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $semester): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		<option value="<?php echo e($semester->id); ?>" <?php if( $selected_semester == $semester->id): ?> selected <?php endif; ?>><?php echo e($semester->title); ?></option>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		<?php endif; ?>
	</select>

	<div class="invalid-feedback">
		<?php echo e(__('required_field')); ?> <?php echo e(__('field_semester')); ?>

	</div>
</div>
<div class="form-group col-md-4">
  <label for="section"><?php echo e(__('field_section')); ?> <span>*</span></label>
  <select class="form-control section" name="section" id="section" required>
		<option value="0"><?php echo e(__('all')); ?></option>
		<?php if(isset($sections)): ?>
		<?php $__currentLoopData = $sections->sortBy('title'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		<option value="<?php echo e($section->id); ?>" <?php if( $selected_section == $section->id): ?> selected <?php endif; ?>><?php echo e($section->title); ?></option>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		<?php endif; ?>
  </select>

	<div class="invalid-feedback">
		<?php echo e(__('required_field')); ?> <?php echo e(__('field_section')); ?>

	</div>
</div>
<div class="form-group col-md-4">
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


<script src="<?php echo e(asset('dashboard/plugins/jquery/js/jquery.min.js')); ?>"></script>

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
      var semester=$(".semester");
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
            $('.semester').append('<option value="0"><?php echo e(__("all")); ?></option>');
            $.each(response, function(){
              $('<option/>', {
                'value': this.id,
                'text': this.title
              }).appendTo('.semester');
            });
          }

      });
    });

    $(".semester").on('change',function(e){
      e.preventDefault(e);
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
            $('.section').append('<option value="0"><?php echo e(__("all")); ?></option>');
            $.each(response, function(){
              $('<option/>', {
                'value': this.id,
                'text': this.title
              }).appendTo('.section');
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
</script><?php /**PATH C:\wamp64\www\Dapin-CMS-main\resources\views/common/inc/assignment_search_filter.blade.php ENDPATH**/ ?>