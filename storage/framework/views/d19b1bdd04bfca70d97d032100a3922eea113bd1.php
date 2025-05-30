<?php $__env->startSection('title', $title); ?>
<?php $__env->startSection('content'); ?>

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-md-12 col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5><?php echo e($row->title); ?></h5>
                    </div>
                    <div class="card-block">
                        <a href="<?php echo e(route($route.'.index')); ?>" class="btn btn-primary"><i class="fas fa-arrow-left"></i> <?php echo e(__('btn_back')); ?></a>

                        <a href="<?php echo e(route($route.'.show', $row->id)); ?>" class="btn btn-info"><i class="fas fa-sync-alt"></i> <?php echo e(__('btn_refresh')); ?></a>
                    </div>
                    <div class="card-block">
                    <!-- Details View Start -->
                    <div class="">
                        <div class="row">
                            <div class="col-md-6">
                                <p><mark class="text-primary"><?php echo e(__('field_subject')); ?>:</mark> <?php echo e($row->subject->code ?? ''); ?> - <?php echo e($row->subject->title ?? ''); ?></p><hr/>
                                <p><mark class="text-primary"><?php echo e(__('field_faculty')); ?>:</mark> 
                                    <?php if($row->faculty_id == 0): ?>
                                    <?php echo e(__('all')); ?>

                                    <?php endif; ?>
                                    <?php if(isset($row->faculty->title)): ?>
                                    <?php echo e($row->faculty->title ?? ''); ?>

                                    <?php endif; ?>
                                </p><hr/>
                                <p><mark class="text-primary"><?php echo e(__('field_program')); ?>:</mark> 
                                    <?php if($row->program_id == 0): ?>
                                    <?php echo e(__('all')); ?>

                                    <?php endif; ?>
                                    <?php if(isset($row->program->title)): ?>
                                    <?php echo e($row->program->title ?? ''); ?>

                                    <?php endif; ?>
                                </p><hr/>
                                <p><mark class="text-primary"><?php echo e(__('field_session')); ?>:</mark> 
                                    <?php if($row->session_id == 0): ?>
                                    <?php echo e(__('all')); ?>

                                    <?php endif; ?>
                                    <?php if(isset($row->session->title)): ?>
                                    <?php echo e($row->session->title ?? ''); ?>

                                    <?php endif; ?>
                                </p><hr/>
                                <p><mark class="text-primary"><?php echo e(__('field_semester')); ?>:</mark> 
                                    <?php if($row->semester_id == 0): ?>
                                    <?php echo e(__('all')); ?>

                                    <?php endif; ?>
                                    <?php if(isset($row->semester->title)): ?>
                                    <?php echo e($row->semester->title ?? ''); ?>

                                    <?php endif; ?>
                                </p><hr/>
                                <p><mark class="text-primary"><?php echo e(__('field_section')); ?>:</mark> 
                                    <?php if($row->section_id == 0): ?>
                                    <?php echo e(__('all')); ?>

                                    <?php endif; ?>
                                    <?php if(isset($row->section->title)): ?>
                                    <?php echo e($row->section->title ?? ''); ?>

                                    <?php endif; ?>
                                </p><hr/>
                            </div>
                            <div class="col-md-6">
                                <p><mark class="text-primary"><?php echo e(__('field_total_marks')); ?>:</mark> <?php echo e(round($row->total_marks, 2)); ?></p><hr/>
                                
                                <p><mark class="text-primary"><?php echo e(__('field_start_date')); ?>:</mark> 
                                    <?php if(isset($setting->date_format)): ?>
                                    <?php echo e(date($setting->date_format, strtotime($row->start_date))); ?>

                                    <?php else: ?>
                                    <?php echo e(date("Y-m-d", strtotime($row->start_date))); ?>

                                    <?php endif; ?>
                                </p><hr/>
                                <p><mark class="text-primary"><?php echo e(__('field_end_date')); ?>:</mark> 
                                    <?php if(isset($setting->date_format)): ?>
                                    <?php echo e(date($setting->date_format, strtotime($row->end_date))); ?>

                                    <?php else: ?>
                                    <?php echo e(date("Y-m-d", strtotime($row->end_date))); ?>

                                    <?php endif; ?>
                                </p><hr/>

                                <p><mark class="text-primary"><?php echo e(__('field_recorded_by')); ?>:</mark> #<?php echo e($row->teacher->staff_id ?? ''); ?></p><hr/>

                                <?php if(is_file('uploads/'.$path.'/'.$row->attach)): ?>
                                <a href="<?php echo e(asset('uploads/'.$path.'/'.$row->attach)); ?>" class="btn btn-dark" download><i class="fas fa-download"></i> <?php echo e(__('field_attach')); ?></a>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <p><mark class="text-primary"><?php echo e(__('field_description')); ?>:</mark> <?php echo $row->description; ?></p><hr/>
                            </div>
                        </div>
                    </div>
                    <!-- Details View End -->
                    </div>
                </div>
            </div>
        </div>

        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check($access.'-marking')): ?>
        <div class="row">
            <div class="col-sm-12">
              <div class="card">
                <div class="card-block">
                    <p>1. Your Excel data should be in the format of the exported file. The first line of your Excel file should be the column headers as in the table example. Also make sure that your file is UTF-8 to avoid unnecessary encoding problems.</p><hr/>
                    <p>2. If the column you are trying to import is date, Make sure that is formatted in format Y-m-d (2022-06-30). Also keep the excel field format as text instead of date.</p><hr/>
                    <p>3. "Marks" must contain a numeric value.</p><hr/>

                    <form class="needs-validation" novalidate action="<?php echo e(route($route.'.import')); ?>" method="post" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <div class="row gx-2">
                            <input type="hidden" name="assignment" value="<?php echo e($row->id); ?>">

                            <div class="form-group col-md-3">
                                <label for="import"><?php echo e(__('field_marks')); ?> <span>*</span></label>
                                <input type="file" class="form-control" name="import" id="import" value="<?php echo e(old('import')); ?>" accept=".xlsx" required>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('File xlsx')); ?>

                                </div>
                            </div>

                            <div class="form-group col-md-3">
                                <button type="submit" class="btn btn-info btn-filter"><i class="fas fa-upload"></i> <?php echo e(__('btn_import')); ?></button>
                            </div>
                        </div>
                    </form>
                </div>

                <form class="needs-validation" novalidate action="<?php echo e(route($route.'.marking')); ?>" method="post" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>

                <?php if(count($row->students) > 0): ?>
                <div class="card-block">
                    <div class="form-group d-inline">
                        <button type="button" class="btn btn-dark btn-print">
                            <i class="fas fa-print"></i> <?php echo e(__('btn_print')); ?>

                        </button>

                        <a href="<?php echo e(route($route.'.export', $row->id)); ?>" class="btn btn-info"><i class="fas fa-download"></i> <?php echo e(__('btn_export')); ?></a>
                    </div>

                    <!-- [ Data table ] start -->
                    <div class="table-responsive">
                        <table class="display table nowrap table-striped table-hover printable">
                            <thead>
                                <tr>
                                    <th><?php echo e(__('field_student_id')); ?></th>
                                    <th><?php echo e(__('field_name')); ?></th>
                                    <th><?php echo e(__('field_status')); ?></th>
                                    <th><?php echo e(__('field_submission')); ?> <?php echo e(__('field_date')); ?></th>
                                    <th><?php echo e(__('field_attach')); ?></th>
                                    <th>
                                        <?php echo e(__('field_max_marks')); ?>

                                        <?php if(isset($row->total_marks)): ?>
                                         (<?php echo e(round($row->total_marks, 2)); ?>)
                                        <?php endif; ?>
                                     </th>
                                </tr>
                            </thead>
                            <tbody>
                              <?php $__currentLoopData = $row->students->sortBy('student_id'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $stuAss): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <input type="hidden" name="assignments[<?php echo e($key); ?>]" value="<?php echo e($stuAss->id); ?>">
                                <tr>
                                    <td>
                                        <a href="<?php echo e(route('admin.student.show', $stuAss->studentEnroll->student->id)); ?>">
                                        #<?php echo e($stuAss->studentEnroll->student->student_id); ?>

                                        </a>
                                    </td>
                                    <td><?php echo e($stuAss->studentEnroll->student->first_name ?? ''); ?> <?php echo e($stuAss->studentEnroll->student->last_name ?? ''); ?></td>
                                    <td>
                                        <?php if( $stuAss->attendance == 1 ): ?>
                                        <span class="badge badge-pill badge-success"><?php echo e(__('status_submitted')); ?></span>
                                        <?php else: ?>
                                        <span class="badge badge-pill badge-danger"><?php echo e(__('status_pending')); ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($stuAss->attendance == 1 && !empty($stuAss->date)): ?>
                                        <?php if(isset($setting->date_format)): ?>
                                        <?php echo e(date($setting->date_format, strtotime($stuAss->date))); ?>

                                        <?php else: ?>
                                        <?php echo e(date("Y-m-d", strtotime($stuAss->date))); ?>

                                        <?php endif; ?>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if(is_file('uploads/'.$path.'/'.$stuAss->attach)): ?>
                                        <a href="https://docs.google.com/viewer?url=<?php echo e(asset('uploads/'.$path.'/'.$stuAss->attach)); ?>" target="_blank" class="btn btn-icon btn-sm btn-success"><i class="fas fa-eye"></i></a>

                                        <a href="<?php echo e(asset('uploads/'.$path.'/'.$stuAss->attach)); ?>" target="_blank" class="btn btn-icon btn-sm btn-dark" download><i class="fas fa-download"></i></a>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="marks[<?php echo e($key); ?>]" id="marks" value="<?php echo e($stuAss->marks ? round($stuAss->marks, 2) : ''); ?>" style="width: 100px;" data-v-max="<?php echo e($row->total_marks ?? 0); ?>" data-v-min="0">
                                    </td>
                                </tr>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- [ Data table ] end -->
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-success update"><i class="fas fa-check"></i> <?php echo e(__('btn_update')); ?></button>
                </div>
                <?php endif; ?>
                </form>
              </div>
            </div>
        </div>
        <?php endif; ?>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\business\backup\Dapin\Dapin\resources\views\admin\assignment\show.blade.php ENDPATH**/ ?>