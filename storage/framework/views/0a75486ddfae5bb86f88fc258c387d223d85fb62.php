
<?php $__env->startSection('title', $title); ?>
<?php $__env->startSection('content'); ?>


<style>
    .btn-icon {
    margin-right: 5px;
}

</style>
<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check($access.'-create')): ?>
            <div class="col-md-4">
                <form class="needs-validation" novalidate action="<?php echo e(route('filepost')); ?>" method="post" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                    <div class="card">
                        <div class="card-header">
                            <h5><?php echo e(__('Create')); ?> <?php echo e($title); ?></h5>
                        </div>
                        <div class="card-block">
                            <!-- Form Start -->
                            <div class="form-group">
                                <label for="title" class="form-label"><?php echo e(__('File Title')); ?> <span>*</span></label>
                                <input type="text" class="form-control" name="title" id="title" value="<?php echo e(old('title')); ?>" required>
                                <div class="invalid-feedback">
                                  <?php echo e(__('This field is required')); ?>

                                </div>
                            </div>

                            <div class="form-group">
                                <label for="description" class="form-label"><?php echo e(__('File Description')); ?></label>
                                <textarea class="form-control" name="description" id="description"><?php echo e(old('description')); ?></textarea>
                            </div>

                           <!-- Add Plus Icon and Modal Trigger -->
                           <div class="form-group"> <label for="category_id" class="form-label"><?php echo e(__('Category')); ?> <span>*</span></label>
                             <div class="input-group">
                                 <select class="form-control" name="category_id" id="category_id" required>
                                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <option value="<?php echo e($category->id); ?>"><?php echo e($category->name); ?></option>
                                     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> </select> <a href="<?php echo e(route('categoriescreate')); ?>"
                             class="btn btn-primary"> + </a> </div> <div class="invalid-feedback"> <?php echo e(__('This field is required')); ?> </div> </div>


                            <div class="form-group">
                                <label for="file_path" class="form-label"><?php echo e(__('Upload File')); ?> <span>*</span></label>
                                <input type="file" class="form-control" name="file_path" id="file_path" required>
                                <div class="invalid-feedback">
                                  <?php echo e(__('This field is required')); ?>

                                </div>
                            </div>

                            <div class="form-group">
                                <label for="type" class="form-label"><?php echo e(__('File Type')); ?> <span>*</span></label>
                                <select class="form-control" name="type" id="type" required>
                                    <option value="PDF">PDF</option>
                                    <option value="Video">Video</option>
                                    <option value="Doc">Doc</option>
                                    <option value="Image">Image</option>
                                </select>
                                <div class="invalid-feedback">
                                  <?php echo e(__('This field is required')); ?>

                                </div>
                            </div>

                            <div class="form-group">
                                <label for="author" class="form-label"><?php echo e(__('Author')); ?></label>
                                <input type="text" class="form-control" name="author" id="author" value="<?php echo e(old('author')); ?>">
                            </div>

                            <div class="form-group">
                                <label for="publisher" class="form-label"><?php echo e(__('Publisher')); ?></label>
                                <input type="text" class="form-control" name="publisher" id="publisher" value="<?php echo e(old('publisher')); ?>">
                            </div>

                            <div class="form-group">
                                <label for="language" class="form-label"><?php echo e(__('Language')); ?></label>
                                <input type="text" class="form-control" name="language" id="language" value="<?php echo e(old('language', 'English')); ?>">
                            </div>

                            <div class="form-group">
                                <label for="edition" class="form-label"><?php echo e(__('Edition')); ?></label>
                                <input type="text" class="form-control" name="edition" id="edition" value="<?php echo e(old('edition')); ?>">
                            </div>

                            <div class="form-group">
                                <label for="isbn" class="form-label"><?php echo e(__('ISBN')); ?></label>
                                <input type="text" class="form-control" name="isbn" id="isbn" value="<?php echo e(old('isbn')); ?>">
                            </div>

                            <div class="form-group">
                                <label for="is_public" class="form-label"><?php echo e(__('Public')); ?></label>
                                <input type="checkbox" name="is_public" value="1">
                            </div>

                            <div class="form-group">
                                <label for="thumbnail" class="form-label"><?php echo e(__('Thumbnail')); ?> <span>*</span></label>
                                <input type="file" class="form-control" name="thumbnail" id="thumbnail" required>
                                <div class="invalid-feedback">
                                  <?php echo e(__('This field is required')); ?>

                                </div>
                            </div>


                          
<!-- resources/views/admin/files/create.blade.php -->
<div class="form-group"> 
    <label for="is_downloadable" class="form-label"><?php echo e(__('Downloadable')); ?></label> 
    <input type="checkbox" name="is_downloadable" id="is_downloadable" value="1" <?php echo e(old('is_downloadable') ? 'checked' : ''); ?>>
</div>




                            <!-- Form End -->
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> <?php echo e(__('Save')); ?></button>
                        </div>
                    </div>
                </form>
            </div>
            <?php endif; ?>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5><?php echo e($title); ?> <?php echo e(__('List')); ?></h5>
                    </div>
                    <div class="card-block">
                        <!-- [ Data table ] start -->
                        <div class="table-responsive">
                            <table id="basic-table" class="display table nowrap table-striped table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th><?php echo e(__('Title')); ?></th>
                                        
                                        <th><?php echo e(__('Category')); ?></th>
                                        <th><?php echo e(__('Uploaded By')); ?></th>
                                        <th><?php echo e(__('File Path')); ?></th>
                                        <th><?php echo e(__('Actions')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $materials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($key + 1); ?></td>
                                            <td><?php echo e($file->title); ?></td>
                                            
                                            <td><?php echo e($file->category->name); ?></td>
                                            <td><?php echo e($file->uploader->first_name ?? 'N/A'); ?></td>
                                            <td>
                                                <a href="<?php echo e(asset($file->file_path)); ?>" target="_blank">View Material</a>
                                            </td>
                                            <td>
                                                <div style="display: flex; gap: 5px;">
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check($access.'-show')): ?>
                                                        <a href="<?php echo e(route('fileshow', $file->id)); ?>" class="btn btn-icon btn-primary btn-sm">
                                                            <i class="far fa-eye"></i>
                                                        </a>
                                                    <?php endif; ?>
                                            
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check($access.'-edit')): ?>
                                                        <a href="<?php echo e(route('editfile', $file->id)); ?>" class="btn btn-icon btn-primary btn-sm">
                                                            <i class="far fa-edit"></i>
                                                        </a>
                                                    <?php endif; ?>
                                            
                                                    <form action="<?php echo e(route('deletefile', $file->id)); ?>" method="POST" onsubmit="return confirm('Are you sure you want to delete this material? This action cannot be undone.');">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('DELETE'); ?>
                                                        <button type="submit" class="btn btn-icon btn-danger btn-sm">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </form>
                                                </div>
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
 <!-- Delete Modal -->
 <div class="modal fade" id="deleteModal-<?php echo e($file->id); ?>" tabindex="-1" aria-labelledby="deleteModalLabel-<?php echo e($file->id); ?>" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel-<?php echo e($file->id); ?>"><?php echo e(__('Confirm Delete')); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php echo e(__('Are you sure you want to delete this material? This action cannot be undone.')); ?>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo e(__('Cancel')); ?></button>
                <form action="<?php echo e(route('deletefile', $file->id)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="btn btn-danger"><?php echo e(__('Delete')); ?></button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\business\backup\Dapin\Dapin\resources\views\admin\files\index.blade.php ENDPATH**/ ?>