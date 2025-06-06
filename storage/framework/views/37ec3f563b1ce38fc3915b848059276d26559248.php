<?php $__env->startSection('title', $title); ?>
<?php $__env->startSection('content'); ?>

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-sm-8">
                <div class="card">
                    <div class="card-header">
                        <h5><?php echo e($row->assignment->title ?? ''); ?></h5>
                    </div>
                    <div class="card-block">
                        <a href="<?php echo e(route($route.'.index')); ?>" class="btn btn-primary"><i class="fas fa-arrow-left"></i> <?php echo e(__('btn_back')); ?></a>
                    </div>
                    <div class="card-block">
                    <!-- Details View Start -->
                    <div class="">
                        <div class="row">
                            <div class="col-md-6">
                                <p><mark class="text-primary"><?php echo e(__('field_subject')); ?>:</mark> <?php echo e($row->assignment->subject->code ?? ''); ?> - <?php echo e($row->assignment->subject->title ?? ''); ?></p><hr/>
                                <p><mark class="text-primary"><?php echo e(__('field_session')); ?>:</mark> <?php echo e($row->studentEnroll->session->title ?? ''); ?></p><hr/>
                                <p><mark class="text-primary"><?php echo e(__('field_semester')); ?>:</mark> <?php echo e($row->studentEnroll->semester->title ?? ''); ?></p><hr/>
                                <p><mark class="text-primary"><?php echo e(__('field_section')); ?>:</mark> <?php echo e($row->studentEnroll->section->title ?? ''); ?></p><hr/>
                            </div>
                            <div class="col-md-6">
                                <?php if(!empty($row->marks)): ?>
                                <p><mark class="text-primary"><?php echo e(__('field_marks_obtained')); ?>:</mark> <?php echo e(round($row->marks, 2)); ?></p><hr/>
                                <?php endif; ?>

                                <p><mark class="text-primary"><?php echo e(__('field_max_marks')); ?>:</mark> <?php echo e(round($row->assignment->total_marks ?? 0, 2)); ?></p><hr/>
                                
                                <p><mark class="text-primary"><?php echo e(__('field_start_date')); ?>:</mark> 
                                    <?php if(isset($setting->date_format)): ?>
                                    <?php echo e(date($setting->date_format, strtotime($row->assignment->start_date))); ?>

                                    <?php else: ?>
                                    <?php echo e(date("Y-m-d", strtotime($row->assignment->start_date))); ?>

                                    <?php endif; ?>
                                </p><hr/>
                                <p><mark class="text-primary"><?php echo e(__('field_end_date')); ?>:</mark> 
                                    <?php if(isset($setting->date_format)): ?>
                                    <?php echo e(date($setting->date_format, strtotime($row->assignment->end_date))); ?>

                                    <?php else: ?>
                                    <?php echo e(date("Y-m-d", strtotime($row->assignment->end_date))); ?>

                                    <?php endif; ?>
                                </p><hr/>

                                <?php if(!empty($row->date)): ?>
                                <p><mark class="text-primary"><?php echo e(__('field_submission')); ?> <?php echo e(__('field_date')); ?>:</mark> 
                                    <?php if(isset($setting->date_format)): ?>
                                    <?php echo e(date($setting->date_format, strtotime($row->date))); ?>

                                    <?php else: ?>
                                    <?php echo e(date("Y-m-d", strtotime($row->date))); ?>

                                    <?php endif; ?>
                                </p><hr/>
                                <?php endif; ?>

                                <p><mark class="text-primary"><?php echo e(__('field_status')); ?>:</mark> 
                                    <?php if( $row->attendance == 1 ): ?>
                                    <span class="badge badge-pill badge-success"><?php echo e(__('status_submitted')); ?></span>
                                    <?php else: ?>
                                    <span class="badge badge-pill badge-primary"><?php echo e(__('status_pending')); ?></span>
                                    <?php endif; ?>
                                </p><hr/>

                                <?php if(is_file('uploads/'.$path.'/'.$row->assignment->attach)): ?>
                                <mark class="text-primary"><?php echo e(__('field_attach')); ?>:</mark>
                                <a href="<?php echo e(asset('uploads/'.$path.'/'.$row->assignment->attach)); ?>" class="btn btn-dark" download><i class="fas fa-download"></i> <?php echo e(__('field_attach')); ?></a>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <p><mark class="text-primary"><?php echo e(__('field_description')); ?>:</mark> <?php echo $row->assignment->description; ?></p><hr/>
                            </div>
                        </div>
                    </div>
                    <!-- Details View End -->
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card">
                    <?php if(is_file('uploads/'.$path.'/'.$row->attach)): ?>
                    <div class="card-header">
                        <?php echo e(__('field_your_file')); ?> : 
                        <a href="<?php echo e(asset('uploads/'.$path.'/'.$row->attach)); ?>" class="btn btn-dark" download><i class="fas fa-download"></i> <?php echo e(__('btn_download')); ?></a>
                    </div>
                    <?php endif; ?>
                    
                    <?php if($row->assignment->end_date >= date("Y-m-d")): ?>
                    <div class="card-block">
                        <form class="needs-validation" novalidate action="<?php echo e(route($route.'.update', $row->id)); ?>" method="post" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>

                        <div class="form-group">
                            <label for="attach"><?php echo e(__('field_upload_pdf')); ?></label>
                            <input type="file" class="form-control" name="attach" id="attach" value="<?php echo e(old('attach')); ?>" accept=".pdf" required>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_upload_pdf')); ?>

                            </div>
                        </div>

                        <button type="submit" class="btn btn-success"><i class="fas fa-upload"></i> <?php echo e(__('btn_upload')); ?></button>
                        </form>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

<?php $__env->stopSection(); ?>
<?php echo $__env->make('student.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\college\resources\views\student\assignment\show.blade.php ENDPATH**/ ?>