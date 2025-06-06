<div class="form-group col-md-6">
    <label for="department"><?php echo e(__('field_department')); ?> <span>*</span></label>
    <select class="form-control department" name="department" id="department" required>
        <option value=""><?php echo e(__('select')); ?></option>
        <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <option value="<?php echo e($department->id); ?>" <?php if(old('department') == $department->id): ?> selected <?php endif; ?>><?php echo e($department->title); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>

    <div class="invalid-feedback">
      <?php echo e(__('required_field')); ?> <?php echo e(__('field_department')); ?>

    </div>
</div>

<div class="form-group col-md-6">
    <label for="user"><?php echo e(__('field_staff')); ?> <span>*</span></label>
    <select class="form-control user select2" name="user" id="user" required>
        <option value=""><?php echo e(__('select')); ?></option>
        <?php if(isset($users)): ?>
        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <option value="<?php echo e($user->id); ?>" <?php if(old('user') == $user->id): ?> selected <?php endif; ?>><?php echo e($user->staff_id ?? ''); ?> - <?php echo e($user->first_name ?? ''); ?> <?php echo e($user->last_name ?? ''); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
    </select>

    <div class="invalid-feedback">
      <?php echo e(__('required_field')); ?> <?php echo e(__('field_staff')); ?>

    </div>
</div>

<div class="form-group col-md-6">
    <label for="category"><?php echo e(__('field_category')); ?> <span>*</span></label>
    <select class="form-control category" name="category" id="category" required>
        <option value=""><?php echo e(__('select')); ?></option>
        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <option value="<?php echo e($category->id); ?>" <?php if(old('category') == $category->id): ?> selected <?php endif; ?>><?php echo e($category->title); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>

    <div class="invalid-feedback">
      <?php echo e(__('required_field')); ?> <?php echo e(__('field_category')); ?>

    </div>
</div>

<div class="form-group col-md-6">
    <label for="item"><?php echo e(__('field_item')); ?> <span>*</span></label>
    <select class="form-control item" name="item" id="item" required>
        <option value=""><?php echo e(__('select')); ?></option>
        <?php if(isset($items)): ?>
        <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <option value="<?php echo e($item->id); ?>" <?php if(old('item') == $item->id): ?> selected <?php endif; ?>><?php echo e($item->name); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
    </select>

    <div class="invalid-feedback">
      <?php echo e(__('required_field')); ?> <?php echo e(__('field_item')); ?>

    </div>
</div>

<div class="form-group col-md-6">
    <label for="quantity"><?php echo e(__('field_quantity')); ?> (<?php echo e(__('field_available')); ?> : <span class="available"></span>) <span>*</span></label>
    <input type="text" class="form-control quantity autonumber" name="quantity" id="quantity" value="<?php echo e(old('quantity')); ?>" data-v-min="1" required>

    <div class="invalid-feedback">
      <?php echo e(__('required_field')); ?> <?php echo e(__('field_quantity')); ?>

    </div>
</div>


<script src="<?php echo e(asset('dashboard/plugins/jquery/js/jquery.min.js')); ?>"></script>

<script type="text/javascript">
  "use strict";
  $(".department").on('change',function(e){
    e.preventDefault();
    var user=$(".user");
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $.ajax({
      type:'POST',
      url: "<?php echo e(route('filter-department')); ?>",
      data:{
        _token:$('input[name=_token]').val(),
        department:$(this).val()
      },
      success:function(response){
          // var jsonData=JSON.parse(response);
          $('option', user).remove();
          $('.user').append('<option value=""><?php echo e(__("select")); ?></option>');
          $.each(response, function(){
            $('<option/>', {
              'value': this.id,
              'text': this.staff_id +' - '+ this.first_name +' '+ this.last_name
            }).appendTo('.user');
          });
        }

    });
  });

  $(".category").on('change',function(e){
    e.preventDefault();
    var item=$(".item");
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $.ajax({
      type:'POST',
      url: "<?php echo e(route('filter-item')); ?>",
      data:{
        _token:$('input[name=_token]').val(),
        category:$(this).val()
      },
      success:function(response){
          // var jsonData=JSON.parse(response);
          $('option', item).remove();
          $('.item').append('<option value=""><?php echo e(__("select")); ?></option>');
          $.each(response, function(){
            $('<option/>', {
              'value': this.id,
              'text': this.name
            }).appendTo('.item');
          });
        }

    });
  });

  $(".item").on('change',function(e){
    e.preventDefault();
    var quantity=$(".quantity");
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $.ajax({
      type:'POST',
      url: "<?php echo e(route('filter-quantity')); ?>",
      data:{
        _token:$('input[name=_token]').val(),
        item:$(this).val()
      },
      success:function(response){
          // var jsonData=JSON.parse(response);
          quantity.attr('data-v-max',response);
          $('.available').text(response);
        }

    });
  });
</script>
<?php /**PATH C:\Users\User\Desktop\college\resources\views\common\inc\inventory_search_filter.blade.php ENDPATH**/ ?>