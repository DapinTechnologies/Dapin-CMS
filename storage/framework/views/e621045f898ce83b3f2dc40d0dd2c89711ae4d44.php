<div class="form-group">
    <label for="hostel-<?php echo e($row->id); ?>"><?php echo e(__('field_hostel')); ?> <span>*</span></label>
    <select class="form-control" name="hostel" id="hostel-<?php echo e($row->id); ?>" required>
        <option value=""><?php echo e(__('select')); ?></option>
        <?php $__currentLoopData = $hostels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hostel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <option value="<?php echo e($hostel->id); ?>" <?php if(old('hostel') == $hostel->id): ?> selected <?php endif; ?>><?php echo e($hostel->name); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>

    <div class="invalid-feedback">
      <?php echo e(__('required_field')); ?> <?php echo e(__('field_hostel')); ?>

    </div>
</div>

<div class="form-group">
    <label for="hostel_room-<?php echo e($row->id); ?>"><?php echo e(__('field_room')); ?> <span>*</span></label>
    <select class="form-control" name="hostel_room" id="hostel_room-<?php echo e($row->id); ?>" required>
        <option value=""><?php echo e(__('select')); ?></option>
        <?php if(isset($rooms)): ?>
        <?php $__currentLoopData = $rooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <option value="<?php echo e($room->id); ?>" <?php if(old('room') == $room->id): ?> selected <?php endif; ?>><?php echo e($room->name); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
    </select>

    <div class="invalid-feedback">
      <?php echo e(__('required_field')); ?> <?php echo e(__('field_room')); ?>

    </div>
</div>


<script src="<?php echo e(asset('dashboard/plugins/jquery/js/jquery.min.js')); ?>"></script>

<script type="text/javascript">
"use strict";
$("#hostel-<?php echo e($row->id); ?>").on('change',function(e){
    e.preventDefault();
    var hostelRoom=$("#hostel_room-<?php echo e($row->id); ?>");
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $.ajax({
      type:'POST',
      url: "<?php echo e(route('filter-room')); ?>",
      data:{
        _token:$('input[name=_token]').val(),
        hostel:$(this).val()
      },
      success:function(response){
          // var jsonData=JSON.parse(response);
          $('option', hostelRoom).remove();
          $('#hostel_room-<?php echo e($row->id); ?>').append('<option value=""><?php echo e(__("select")); ?></option>');
          $.each(response, function(){
            $('<option/>', {
              'value': this.id,
              'text': this.name
            }).appendTo('#hostel_room-<?php echo e($row->id); ?>');
          });
        }

    });
  });
</script>
<?php /**PATH C:\Users\User\Desktop\college\resources\views\common\inc\hostel_room_filter.blade.php ENDPATH**/ ?>