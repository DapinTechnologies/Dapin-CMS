<?php $__env->startSection('title', $title); ?>
<?php $__env->startSection('content'); ?>

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <!-- [ Card ] start -->
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check($access.'-create')): ?>
            <div class="col-sm-12">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active text-uppercase" id="group-tab" data-bs-toggle="tab" href="#group" role="tab" aria-controls="group" aria-selected="true"><?php echo e($title); ?> > <?php echo e(__('tab_group')); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-uppercase" id="individual-tab" data-bs-toggle="tab" href="#individual" role="tab" aria-controls="individual" aria-selected="false"><?php echo e($title); ?> > <?php echo e(__('tab_individual')); ?></a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="group" role="tabpanel" aria-labelledby="group-tab">
                        <div class="card">
                            
                            <form class="needs-validation" novalidate action="<?php echo e(route($route.'.store')); ?>" method="post" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <div class="card-block">
                              <div class="row gx-2">
                                <!-- Form Start -->
                                <?php echo $__env->make('common.inc.notify_search_filter', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                                <div class="form-group col-md-12">
                                    <label for="subject" class="form-label"><?php echo e(__('field_mail_subject')); ?> <span>*</span></label>
                                    <input type="text" class="form-control" name="subject" id="subject" value="<?php echo e(old('subject')); ?>" required>

                                    <div class="invalid-feedback">
                                      <?php echo e(__('required_field')); ?> <?php echo e(__('field_mail_subject')); ?>

                                    </div>
                                </div>

                                <div class="form-group col-md-12">
                                    <label for="message" class="form-label"><?php echo e(__('field_message')); ?> <span>*</span></label>
                                    <textarea class="form-control" name="message" id="message" rows="4" required><?php echo e(old('message')); ?></textarea>
                                    <div class="alert alert-secondary" role="alert">
                                        <?php echo e(__('field_shortcode')); ?>: 
                                        [first_name] [last_name] [student_id] [batch] [faculty] [program] [session] [semester] [section] [father_name] [mother_name] [email] [phone]
                                    </div>

                                    <div class="invalid-feedback">
                                      <?php echo e(__('required_field')); ?> <?php echo e(__('field_message')); ?>

                                    </div>
                                </div>
                                <!-- Form End -->
                              </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-success"><i class="fas fa-paper-plane"></i> <?php echo e(__('btn_send')); ?></button>
                            </div>
                            </form>
                            
                        </div>
                    </div>
                    <div class="tab-pane fade" id="individual" role="tabpanel" aria-labelledby="individual-tab">
                        <div class="card">
                            
                            <form class="needs-validation" novalidate action="<?php echo e(route($route.'.store')); ?>" method="post" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <div class="card-block">
                              <div class="row gx-2">
                                <!-- Form Start -->
                                <div class="form-group col-md-12">
                                    <label for="student"><?php echo e(__('field_student')); ?> <span>*</span></label>
                                    <select class="form-control select2" name="students[]" id="student" multiple required>
                                        <option value=""><?php echo e(__('select')); ?></option>
                                        <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($student->id); ?>" <?php if(old('students') == $student->id): ?> selected <?php endif; ?>><?php echo e($student->student_id); ?> - <?php echo e($student->first_name); ?> <?php echo e($student->last_name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>

                                    <div class="invalid-feedback">
                                      <?php echo e(__('required_field')); ?> <?php echo e(__('field_student')); ?>

                                    </div>
                                </div>

                                <div class="form-group col-md-12">
                                    <label for="subject" class="form-label"><?php echo e(__('field_mail_subject')); ?> <span>*</span></label>
                                    <input type="text" class="form-control" name="subject" id="subject" value="<?php echo e(old('subject')); ?>" required>

                                    <div class="invalid-feedback">
                                      <?php echo e(__('required_field')); ?> <?php echo e(__('field_mail_subject')); ?>

                                    </div>
                                </div>

                                <div class="form-group col-md-12">
                                    <label for="message" class="form-label"><?php echo e(__('field_message')); ?> <span>*</span></label>
                                    <textarea class="form-control" name="message" id="message" rows="4" required><?php echo e(old('message')); ?></textarea>
                                    <div class="alert alert-secondary" role="alert">
                                        <?php echo e(__('field_shortcode')); ?>: 
                                        [first_name] [last_name] [student_id] [batch] [faculty] [program] [session] [semester] [section] [father_name] [mother_name] [email] [phone]
                                    </div>

                                    <div class="invalid-feedback">
                                      <?php echo e(__('required_field')); ?> <?php echo e(__('field_message')); ?>

                                    </div>
                                </div>
                                <!-- Form End -->
                              </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-success"><i class="fas fa-paper-plane"></i> <?php echo e(__('btn_send')); ?></button>
                            </div>
                            </form>
                            
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <!-- [ Card ] end -->
        </div>

        <div class="row">
            <!-- [ Card ] start -->
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-block">
                        <!-- [ Data table ] start -->
                        <div class="table-responsive">
                            <table id="basic-table" class="display table nowrap table-striped table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th><?php echo e(__('field_mail_subject')); ?></th>
                                        <th><?php echo e(__('field_message')); ?></th>
                                        <th><?php echo e(__('field_student')); ?></th>
                                        <th><?php echo e(__('field_date')); ?></th>
                                        <th><?php echo e(__('field_action')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($key + 1); ?></td>
                                        <td><?php echo str_limit($row->subject, 30, ' ...'); ?></td>
                                        <td><?php echo str_limit(strip_tags($row->message), 50, ' ...'); ?></td>
                                        <td><?php echo e($row->receive_count); ?></td>
                                        <td>
                                            <?php if(isset($setting->date_format)): ?>
                                            <?php echo e(date($setting->date_format, strtotime($row->created_at))); ?>

                                            <?php else: ?>
                                            <?php echo e(date("Y-m-d", strtotime($row->created_at))); ?>

                                            <?php endif; ?>

                                            | 

                                            <?php if(isset($setting->time_format)): ?>
                                            <?php echo e(date($setting->time_format, strtotime($row->created_at))); ?>

                                            <?php else: ?>
                                            <?php echo e(date("h:i A", strtotime($row->created_at))); ?>

                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-icon btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#showModal-<?php echo e($row->id); ?>">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <!-- Include Show modal -->
                                            <?php echo $__env->make($view.'.show', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check($access.'-delete')): ?>
                                            <button type="button" class="btn btn-icon btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal-<?php echo e($row->id); ?>">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                            <!-- Include Delete modal -->
                                            <?php echo $__env->make('admin.layouts.inc.delete', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\business\backup\Dapin\Dapin\resources\views\admin\email-notify\index.blade.php ENDPATH**/ ?>