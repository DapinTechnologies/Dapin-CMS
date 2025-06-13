<?php $__env->startSection('title', $title); ?>
<?php $__env->startSection('content'); ?>

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->

        <!-- Back to Dashboard Button at the top -->
        <div class="mt-3 mb-3">
            <a href="<?php echo e(route('admin.dashboard.index')); ?>" class="btn btn-secondary"><?php echo e(__('Back to Dashboard')); ?></a>
        </div>

        <div class="row">
            <div class="card-block">
                <form class="needs-validation" novalidate method="get" action="<?php echo e(route('sms.search')); ?>">
                    <?php echo csrf_field(); ?>
                    <div class="row gx-2">
                        <div class="form-group col-md-6">
                            <label for="phone"><?php echo e(__('Phone Number')); ?></label>
                            <input type="text" class="form-control" name="phone" id="phone">
                            <div class="invalid-feedback">
                                <?php echo e(__('required_field')); ?> <?php echo e(__('Phone Number')); ?>

                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="message_type"><?php echo e(__('Message Type')); ?></label>
                            <select class="form-control" name="message_type" id="message_type">
                                <option value=""><?php echo e(__('All')); ?></option>
                                <option value="individual"><?php echo e(__('Individual')); ?></option>
                                <option value="bulk"><?php echo e(__('Bulk')); ?></option>
                            </select>
                        </div>
                        <div class="form-group col-md-2 d-flex align-items-end">
                            <button type="submit" class="btn btn-info btn-sm btn-filter mr-2"><i class="fas fa-search"></i> <?php echo e(__('')); ?></button>
                            <a href="<?php echo e(route('sms.index')); ?>" class="btn btn-secondary btn-sm"><i class="fas fa-sync-alt"></i> <?php echo e(__('')); ?></a>
                        </div>
                    </div>
                </form>
            </div>
            <?php use Carbon\Carbon; ?>
                
                    
            
            <div class="col-sm-12">
                <div class="card">        
                    <?php 
                    $count = \App\Models\SmsMessage::count(); 
                    ?> 
              
                    <div class="card-block">
                      
                        <!-- [ Data table ] start -->
                        <div class="table-responsive">
                            <div class="export-icons text-lg-center"> Total Messages Sent
                                <span class="badge badge-warning"> <?php echo e($count); ?></span>
                            </div>
                            <table id="export-table" class="display table nowrap table-striped table-hover" style="width:100%">
                              
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Phone Number</th>
                                        <th>Message</th>
                                        
                                        <th>Sent At</th>
                                        <th>Type</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $filteredMessages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($loop->iteration); ?></td>
                                            <td><?php echo e($message->phone_number); ?></td>
                                            <td><?php echo e(Str::words($message->message, 10 )); ?></td>

                                             
                                                 <td><?php echo e(Carbon::parse($message->sent_at)->format('H:i, d-m-Y')); ?></td>
                                            <td><?php echo e($message->is_bulk ? 'Bulk' : 'Individual'); ?></td>
                                            <td>
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check($access.'-view')): ?> <a href="<?php echo e(route('sms.show', $message->id)); ?>" 
                                                    class="btn btn-icon btn-primary btn-sm"> <i class="far fa-eye"></i> </a> <?php endif; ?>

                                               
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- [ Data table ] end -->
                    </div>
                </div>
            </div>
        </div>
        <!-- [ Main Content ] end -->
        
        <!-- Back to Dashboard Button at the bottom -->
        <div class="mt-3">
            <a href="<?php echo e(route('admin.dashboard.index')); ?>" class="btn btn-secondary"><?php echo e(__('Back to Dashboard')); ?></a>
        </div>
    </div>
</div>
<!-- End Content-->

<?php $__env->stopSection(); ?>

<?php $__env->startSection('page_js'); ?>
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
          $('.program').append('<option value="0"><?php echo e(__("all")); ?></option>');
          $.each(response, function(){
            $('<option/>', {
              'value': this.id,
              'text': this.title
            }).appendTo('.program');
          });
        }

    });
  });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\Dapin-CMS-main\resources\views/admin/sms/index.blade.php ENDPATH**/ ?>