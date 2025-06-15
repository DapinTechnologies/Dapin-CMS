<div class="form-group col-md-12">
  <label for="permanent_province"><?php echo e(__('field_province')); ?></label>
  <select class="form-control" name="permanent_province" id="permanent_province">
    <option><?php echo e(__('select')); ?></option>
    <?php $__currentLoopData = $provinces; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $province): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <option value="<?php echo e($province->id); ?>" <?php if(isset($row)): ?> <?php echo e($row->permanent_province == $province->id ? 'selected' : ''); ?> <?php endif; ?>><?php echo e($province->title); ?></option>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </select>

  <div class="invalid-feedback">
  <?php echo e(__('required_field')); ?> <?php echo e(__('field_province')); ?>

  </div>
</div>

<div class="form-group col-md-12">
  <label for="permanent_district"><?php echo e(__('field_district')); ?></label>
  <select class="form-control" name="permanent_district" id="permanent_district">
    <option><?php echo e(__('select')); ?></option>
    <?php if(isset($row)): ?>
    <?php $__currentLoopData = $permanent_districts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $district): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <option value="<?php echo e($district->id); ?>" <?php echo e($row->permanent_district == $district->id ? 'selected' : ''); ?>><?php echo e($district->title); ?></option>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  <?php endif; ?>
  </select>

  <div class="invalid-feedback">
  <?php echo e(__('required_field')); ?> <?php echo e(__('field_district')); ?>

  </div>
</div>


<script type="text/javascript">
"use strict";
$("#permanent_province").on('change',function(e){
    e.preventDefault();
    var permanentDistrict=$("#permanent_district");
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $.ajax({
      type:'POST',
      url: "<?php echo e(route('filter-district')); ?>",
      data:{
        _token:$('input[name=_token]').val(),
        province:$(this).val()
      },
      success:function(response){
          // var jsonData=JSON.parse(response);
          $('option', permanentDistrict).remove();
          $('#permanent_district').append('<option value=""><?php echo e(__("select")); ?></option>');
          $.each(response, function(){
            $('<option/>', {
              'value': this.id,
              'text': this.title
            }).appendTo('#permanent_district');
          });
        }

    });
  });
</script><?php /**PATH C:\wamp64\www\Dapin-CMS-main\resources\views/common/inc/permanent_province.blade.php ENDPATH**/ ?>