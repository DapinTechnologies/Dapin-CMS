<?php $__env->startSection('title', $title); ?>
<?php $__env->startSection('content'); ?>
<!-- resources/views/sms/create.blade.php -->

<div class="container">
    <h1>Send New SMS</h1>

    <div class="row">
        <!-- [ Card ] start -->
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check($access.'-create')): ?>
        <div class="col-sm-12">
            <!-- Navigation Tabs -->
            <ul class="nav nav-tabs" id="smsTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link <?php echo e(Request::is('sms/create') || Request::is('sms/send') ? 'active' : ''); ?>" id="group-tab" data-bs-toggle="tab" href="#group" role="tab" aria-controls="group" aria-selected="true">
                        <?php echo e($title); ?> > <?php echo e(__('tab_group')); ?>

                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo e(Request::is('sms/individual') ? 'active' : ''); ?>" id="individual-tab" data-bs-toggle="tab" href="#individual" role="tab" aria-controls="individual" aria-selected="false">
                        <?php echo e($title); ?> > <?php echo e(__('tab_individual')); ?>

                    </a>
                </li>
            </ul>

            <!-- Tab Content -->
            <div class="tab-content" id="smsTabContent">
                
                <!-- Group SMS Form -->
                <div class="tab-pane fade show active" id="group" role="tabpanel" aria-labelledby="group-tab">
                    <div class="card">
                        <form class="needs-validation" novalidate action="<?php echo e(route('sms.send')); ?>" method="post">
                            <?php echo csrf_field(); ?>
                            <div class="card-body">
                                <div class="row gx-2">
                                    <!-- Send to All Students Option -->
                                    <div class="form-group col-md-12">
                                        <label for="all_students">
                                            <input type="checkbox" name="all_students" id="all_students" value="1">
                                            <?php echo e(__('Send to All Students')); ?>

                                        </label>
                                    </div>

                                    <!-- Select Individual Students -->
                                    <div class="form-group col-md-12" id="student-select">
                                        <label for="student"><?php echo e(__('field_student')); ?> <span>*</span></label>
                                        <select class="form-control select2" name="students[]" id="student" multiple>
                                            <option value=""><?php echo e(__('select')); ?></option>
                                            <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($student->id); ?>" <?php if(old('students') == $student->id): ?> selected <?php endif; ?>>
                                                    <?php echo e($student->student_id); ?> - <?php echo e($student->first_name); ?> <?php echo e($student->last_name); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>

                                    <!-- Message Input -->
                                    <div class="form-group col-md-12">
                                        <label for="message" class="form-label"><?php echo e(__('field_message')); ?> <span>*</span></label>
                                        <textarea class="form-control" name="message" id="message" rows="4" required><?php echo e(old('message')); ?></textarea>
                                        <div class="invalid-feedback">
                                            <?php echo e(__('required_field')); ?> <?php echo e(__('field_message')); ?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-paper-plane"></i> <?php echo e(__('btn_send')); ?>

                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Individual SMS Form -->
              <!-- Individual SMS Form -->
<div class="tab-pane fade" id="individual" role="tabpanel" aria-labelledby="individual-tab">
    <div class="card">
        <form class="needs-validation" novalidate action="<?php echo e(route('sms.sendIndividual')); ?>" method="post">
            <?php echo csrf_field(); ?>
            <div class="card-body">
                <div class="row gx-2">
                    <!-- Select Individual Student -->
                    <div class="form-group col-md-12">
                        <label for="student"><?php echo e(__('field_student')); ?> <span>*</span></label>
                        <select class="form-control select2" name="student_id" id="student" required>
                            <option value=""><?php echo e(__('select')); ?></option>
                            <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($student->id); ?>" <?php if(old('student_id') == $student->id): ?> selected <?php endif; ?>>
                                    <?php echo e($student->student_id); ?> - <?php echo e($student->first_name); ?> <?php echo e($student->last_name); ?> - <?php echo e($student->phone); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <!-- API Key Input -->
                   

                    <!-- Message Input -->
                    <div class="form-group col-md-12">
                        <label for="message" class="form-label"><?php echo e(__('field_message')); ?> <span>*</span></label>
                        <textarea class="form-control" name="message" id="message" rows="4" required><?php echo e(old('message')); ?></textarea>
                        <div class="invalid-feedback">
                            <?php echo e(__('required_field')); ?> <?php echo e(__('field_message')); ?>

                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-paper-plane"></i> <?php echo e(__('btn_send')); ?>

                </button>
            </div>
        </form>
    </div>
</div>

            </div>
        </div>
        <?php endif; ?>
        <!-- [ Card ] end -->
    </div>
</div>

<script>
    // Toggle student select visibility based on 'Send to All Students' checkbox
    document.getElementById('all_students').addEventListener('change', function () {
        const studentSelect = document.getElementById('student-select');
        studentSelect.style.display = this.checked ? 'none' : 'block';
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\Dapin-CMS-main\resources\views/admin/sms/create.blade.php ENDPATH**/ ?>