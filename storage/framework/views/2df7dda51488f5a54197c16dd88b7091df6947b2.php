<?php $__env->startSection('title', $title); ?>
<?php $__env->startSection('content'); ?>

<!-- Start Content -->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check($access.'-create')): ?>
            <div class="col-md-4">
                <form class="needs-validation" novalidate action="<?php echo e(route($route.'.store')); ?>" method="post" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="card">
                        <div class="card-header">
                            <h5><?php echo e(__('btn_create')); ?> <?php echo e($title); ?></h5>
                        </div>
                        <div class="card-block">
                            <!-- Form Start -->
                            <div class="form-group">
                                <label for="title" class="form-label"><?php echo e(__('field_title')); ?> <span>*</span></label>
                                <input type="text" class="form-control" name="title" id="title" value="<?php echo e(old('title')); ?>" required>
                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_title')); ?>

                                </div>
                            </div>

                            <div class="form-group">
                                <label for="amount" class="form-label"><?php echo e(__('Amount')); ?> <span>*</span></label>
                                <input type="number" class="form-control" name="amount" id="amount" value="<?php echo e(old('amount')); ?>" min="0" step="0.01" required>
                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('Amount')); ?>

                                </div>
                            </div>
                            <!-- Form End -->
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> <?php echo e(__('btn_save')); ?></button>
                        </div>
                    </div>
                </form>
            </div>
            <?php endif; ?>

            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5><?php echo e($title); ?> <?php echo e(__('list')); ?></h5>
                    </div>
                    <div class="card-block">
                        <!-- [ Data table ] start -->
                        <div class="table-responsive">
                            <table id="basic-table" class="display table nowrap table-striped table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th><?php echo e(__('field_title')); ?></th>
                                        <th><?php echo e(__('field_amount')); ?></th>
                                        <th><?php echo e(__('field_status')); ?></th>
                                        <th><?php echo e(__('field_action')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                  <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($key + 1); ?></td>
                                        <td><?php echo e($row->title); ?></td>
                                        <td><?php echo e(number_format($row->amount, 2)); ?></td>
                                        <td>
                                            <?php if($row->status == 1): ?>
                                            <span class="badge badge-pill badge-success"><?php echo e(__('status_active')); ?></span>
                                            <?php else: ?>
                                            <span class="badge badge-pill badge-danger"><?php echo e(__('status_inactive')); ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check($access.'-edit')): ?>
                                            <button type="button" class="btn btn-icon btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editModal-<?php echo e($row->id); ?>">
                                                <i class="far fa-edit"></i>
                                            </button>
                                            <?php endif; ?>

 <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check($access.'-delete')): ?>
<form action="<?php echo e(route($route.'.destroy', $row->id)); ?>" method="POST" class="d-inline">
    <?php echo csrf_field(); ?>
    <?php echo method_field('DELETE'); ?>
    <button type="submit" class="btn btn-icon btn-danger btn-sm" title="Delete">
        <i class="fas fa-trash-alt"></i>
    </button>
</form>
<?php endif; ?>


                                        </td>
                                    </tr>

                                    
                                    <div class="modal fade" id="editModal-<?php echo e($row->id); ?>" tabindex="-1" aria-labelledby="editModalLabel-<?php echo e($row->id); ?>" aria-hidden="true">
                                      <div class="modal-dialog">
                                        <form method="POST" action="<?php echo e(route($route.'.update', $row->id)); ?>">
                                          <?php echo csrf_field(); ?>
                                          <?php echo method_field('PUT'); ?>
                                          <div class="modal-content">
                                            <div class="modal-header">
                                              <h5 class="modal-title" id="editModalLabel-<?php echo e($row->id); ?>">Update Fee Category</h5>
                                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                              <!-- Title input -->
                                              <div class="form-group">
                                                <label for="title-<?php echo e($row->id); ?>"><?php echo e(__('field_title')); ?> <span>*</span></label>
                                                <input type="text" class="form-control" id="title-<?php echo e($row->id); ?>" name="title" value="<?php echo e(old('title', $row->title)); ?>" required>
                                              </div>

                                              <!-- Amount input -->
                                              <div class="form-group mt-3">
                                                <label for="amount-<?php echo e($row->id); ?>"><?php echo e(__('Amount')); ?> <span>*</span></label>
                                                <input type="number" class="form-control" id="amount-<?php echo e($row->id); ?>" name="amount" value="<?php echo e(old('amount', $row->amount)); ?>" min="0" step="0.01" required>
                                              </div>

                                              <!-- Status select -->
                                              <div class="form-group mt-3">
                                                <label for="status-<?php echo e($row->id); ?>"><?php echo e(__('field_status')); ?></label>
                                                <select name="status" id="status-<?php echo e($row->id); ?>" class="form-control" required>
                                                  <option value="1" <?php echo e($row->status == 1 ? 'selected' : ''); ?>><?php echo e(__('status_active')); ?></option>
                                                  <option value="0" <?php echo e($row->status == 0 ? 'selected' : ''); ?>><?php echo e(__('status_inactive')); ?></option>
                                                </select>
                                              </div>
                                            </div>
                                            <div class="modal-footer">
                                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo e(__('btn_close')); ?></button>
                                              <button type="submit" class="btn btn-primary"><?php echo e(__('Update')); ?></button>
                                            </div>
                                          </div>
                                        </form>
                                      </div>
                                    </div>
                                    

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
<!-- End Content -->

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\college\resources\views\admin\fees-category\index.blade.php ENDPATH**/ ?>