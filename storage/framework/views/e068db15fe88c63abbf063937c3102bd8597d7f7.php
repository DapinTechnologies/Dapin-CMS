<?php $__env->startSection('title', $title); ?>
<?php $__env->startSection('content'); ?>

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <!-- [ Card ] start -->
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5><?php echo e($title); ?></h5>
                    </div>
                    <form class="needs-validation" novalidate action="<?php echo e(route($route.'.store')); ?>" method="post" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="card-block">
                      <div class="row">
                        <!-- Form Start -->
                        <div class="form-group col-md-6">
                            <label for="book"><?php echo e(__('field_book')); ?> <span>*</span></label>
                            <select class="form-control select2" name="book" id="book" required>
                                <option value=""><?php echo e(__('select')); ?></option>
                                <?php $__currentLoopData = $books; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($book->id); ?>" <?php if(old('book') == $book->id): ?> selected <?php endif; ?>><?php echo e($book->isbn); ?> | <?php echo e($book->title); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_book')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="member"><?php echo e(__('field_member')); ?> <span>*</span></label>
                            <select class="form-control select2" name="member" id="member" required>
                                <option value=""><?php echo e(__('select')); ?></option>
                                <?php $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($member->id); ?>" <?php if(old('member') == $member->id): ?> selected <?php endif; ?>><?php echo e($member->library_id); ?> | <?php echo e($member->memberable->first_name ?? ''); ?> <?php echo e($member->memberable->last_name ?? ''); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_member')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="issue_date"><?php echo e(__('field_issue_date')); ?> <span>*</span></label>
                            <input type="date" class="form-control date" name="issue_date" id="issue_date" value="<?php echo e(date('Y-m-d')); ?>" required>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_issue_date')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="due_date"><?php echo e(__('field_due_return_date')); ?> <span>*</span></label>
                            <input type="date" class="form-control date" name="due_date" id="due_date" value="<?php echo e(date('Y-m-d')); ?>" required>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_due_return_date')); ?>

                            </div>
                        </div>
                        <!-- Form End -->
                      </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> <?php echo e(__('btn_issue')); ?></button>
                    </div>
                    </form>
                </div>
            </div>
            <!-- [ Card ] end -->
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home7/httpurba/public_html/college/resources/views/admin/issue-return/create.blade.php ENDPATH**/ ?>