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
                        <!-- [ Data table ] start -->
                        <div class="table-responsive">
                            <table id="basic-table" class="display table nowrap table-striped table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th><?php echo e(__('field_notice_no')); ?></th>
                                        <th><?php echo e(__('field_title')); ?></th>
                                        <th><?php echo e(__('field_category')); ?></th>
                                        <th><?php echo e(__('field_publish_date')); ?></th>
                                        <th><?php echo e(__('field_action')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><a href="<?php echo e(route($route.'.show', $row->id)); ?>">#<?php echo e($row->notice_no); ?></a></td>
                                        <?php
                                        $unread = 0;
                                        $user = Auth::guard('student')->user();
                                        foreach ($user->unreadNotifications as $notification) {
                                            if($notification->data['type'] == 'notice' && $notification->data['id'] == $row->id) {
                                                $unread = 1;
                                            }
                                        }
                                        ?>
                                        <td>
                                            <?php if($unread == 1): ?>
                                            <a href="<?php echo e(route($route.'.show', $row->id)); ?>"><b><?php echo str_limit($row->title, 50, ' ...'); ?></b></a>
                                            <?php else: ?>
                                            <a href="<?php echo e(route($route.'.show', $row->id)); ?>"><?php echo str_limit($row->title, 50, ' ...'); ?></a>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e($row->category->title ?? ''); ?></td>
                                        <td>
                                            <?php if(isset($setting->date_format)): ?>
                                            <?php echo e(date($setting->date_format, strtotime($row->date))); ?>

                                            <?php else: ?>
                                            <?php echo e(date("Y-m-d", strtotime($row->date))); ?>

                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="<?php echo e(route($route.'.show', $row->id)); ?>" class="btn btn-icon btn-success btn-sm"><i class="fas fa-eye"></i></a>

                                            <?php if(is_file('uploads/'.$path.'/'.$row->attach)): ?>
                                            <a href="<?php echo e(asset('uploads/'.$path.'/'.$row->attach)); ?>" class="btn btn-icon btn-dark btn-sm" download><i class="fas fa-download"></i></a>
                                            <?php endif; ?>

                                            <?php if(isset($row->url)): ?>
                                            <a href="<?php echo e(url($row->url)); ?>" class="btn btn-icon btn-dark btn-sm" target="_blank"><i class="fas fa-link"></i></a>
                                            <?php endif; ?>
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
    </div>
</div>
<!-- End Content-->

<?php $__env->stopSection(); ?>
<?php echo $__env->make('student.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\Dapin-CMS-main\resources\views/student/notice/index.blade.php ENDPATH**/ ?>