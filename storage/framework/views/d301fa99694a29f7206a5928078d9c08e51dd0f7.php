<?php $__env->startSection('title', $title); ?>
<?php $__env->startSection('content'); ?>

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-sm-12">
                <form class="needs-validation" novalidate action="<?php echo e(route($route.'.store')); ?>" method="post" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="card">
                    <div class="card-header">
                        <h5><?php echo e(__('btn_update')); ?> <?php echo e($title); ?></h5>
                    </div>
                    <div class="card-block">
                      <div class="row">
                        <!-- Form Start -->
                        <input name="id" type="hidden" value="<?php echo e((isset($row->id))?$row->id:-1); ?>">

                        <div class="form-group col-md-6">
                            <label for="label"><?php echo e(__('field_label')); ?> <span>*</span></label>
                            <input type="text" class="form-control" name="label" id="label" value="<?php echo e(isset($row->label)?$row->label:''); ?>" required>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_label')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="title"><?php echo e(__('field_title')); ?> <span>*</span></label>
                            <input type="text" class="form-control" name="title" id="title" value="<?php echo e(isset($row->title)?$row->title:''); ?>" required>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_title')); ?>

                            </div>
                        </div>

                        

                        <div class="form-group col-md-12">
                            <label for="description"><?php echo e(__('field_description')); ?> <span>*</span></label>
                            <textarea name="description" id="description" class="form-control texteditor" required><?php echo e(isset($row->description)?$row->description:''); ?></textarea>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_description')); ?>

                            </div>
                        </div>

                        

                        

                        <div class="form-group col-md-12">
                            <?php if(isset($row->attach)): ?>
                            <?php if(is_file('uploads/'.$path.'/'.$row->attach)): ?>
                            <img src="<?php echo e(asset('uploads/'.$path.'/'.$row->attach)); ?>" class="img-fluid" style="max-height: 300px; max-width: 100%;" alt="<?php echo e(__('field_attach')); ?>">
                            <div class="clearfix"></div>
                            <?php endif; ?>
                            <?php endif; ?>

                            <label for="attach"><?php echo e(__('field_attach')); ?>: <span><?php echo e(__('image_size', ['height' => 800, 'width' => 'Any'])); ?></span></label>
                            <input type="file" class="form-control" name="attach" id="attach">

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_attach')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="mission_title"><?php echo e(__('field_mission_title')); ?></label>
                            <input type="text" class="form-control" name="mission_title" id="mission_title" value="<?php echo e(isset($row->mission_title)?$row->mission_title:''); ?>">

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_mission_title')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="vision_title"><?php echo e(__('field_vision_title')); ?></label>
                            <input type="text" class="form-control" name="vision_title" id="title" value="<?php echo e(isset($row->vision_title)?$row->vision_title:''); ?>">

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_vision_title')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="mission_desc"><?php echo e(__('field_mission_desc')); ?></label>
                            <textarea name="mission_desc" id="mission_desc" class="form-control texteditor"><?php echo e(isset($row->mission_desc)?$row->mission_desc:''); ?></textarea>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_mission_desc')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="vision_desc"><?php echo e(__('field_vision_desc')); ?></label>
                            <textarea name="vision_desc" id="vision_desc" class="form-control texteditor"><?php echo e(isset($row->vision_desc)?$row->vision_desc:''); ?></textarea>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_vision_desc')); ?>

                            </div>
                        </div>
                        <!-- Form End -->
                      </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> <?php echo e(__('btn_update')); ?></button>
                    </div>
                </div>
                </form>
            </div>
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\college\resources\views\admin\web\about-us\index.blade.php ENDPATH**/ ?>