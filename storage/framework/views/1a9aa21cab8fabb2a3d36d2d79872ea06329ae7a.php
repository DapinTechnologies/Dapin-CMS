<div class="form-group">
    <label for="route-<?php echo e($row->id); ?>"><?php echo e(__('field_route')); ?> <span>*</span></label>
    <select class="form-control" name="route" id="route-<?php echo e($row->id); ?>" required>
        <option value=""><?php echo e(__('select')); ?></option>
        <?php $__currentLoopData = $transportRoutes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transportRoute): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <option value="<?php echo e($transportRoute->id); ?>" <?php if(old('route') == $transportRoute->id): ?> selected <?php endif; ?>><?php echo e($transportRoute->title); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>

    <div class="invalid-feedback">
      <?php echo e(__('required_field')); ?> <?php echo e(__('field_route')); ?>

    </div>
</div>

<div class="form-group">
    <label for="vehicle-<?php echo e($row->id); ?>"><?php echo e(__('field_vehicle')); ?> <span>*</span></label>
    <select class="form-control" name="vehicle" id="vehicle-<?php echo e($row->id); ?>" required>
        <option value=""><?php echo e(__('select')); ?></option>
        <?php if(isset($vehicles)): ?>
        <?php $__currentLoopData = $vehicles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vehicle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <option value="<?php echo e($vehicle->id); ?>" <?php if(old('vehicle') == $vehicle->id): ?> selected <?php endif; ?>><?php echo e($vehicle->number); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
    </select>

    <div class="invalid-feedback">
      <?php echo e(__('required_field')); ?> <?php echo e(__('field_vehicle')); ?>

    </div>
</div>


<script src="<?php echo e(asset('dashboard/plugins/jquery/js/jquery.min.js')); ?>"></script>

<script type="text/javascript">
"use strict";
$("#route-<?php echo e($row->id); ?>").on('change',function(e){
    e.preventDefault();
    var vehicle=$("#vehicle-<?php echo e($row->id); ?>");
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $.ajax({
      type:'POST',
      url: "<?php echo e(route('filter-vehicle')); ?>",
      data:{
        _token:$('input[name=_token]').val(),
        route:$(this).val()
      },
      success:function(response){
          // var jsonData=JSON.parse(response);
          $('option', vehicle).remove();
          $('#vehicle-<?php echo e($row->id); ?>').append('<option value=""><?php echo e(__("select")); ?></option>');
          $.each(response, function(){
            $('<option/>', {
              'value': this.id,
              'text': this.number
            }).appendTo('#vehicle-<?php echo e($row->id); ?>');
          });
        }

    });
  });
</script>
<?php /**PATH C:\Users\User\Desktop\college\resources\views\common\inc\transport_vehicle_filter.blade.php ENDPATH**/ ?>