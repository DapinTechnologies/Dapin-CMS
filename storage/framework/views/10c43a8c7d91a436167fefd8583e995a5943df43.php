
<?php $__env->startSection('title', 'Edit Material'); ?>
<?php $__env->startSection('content'); ?>

<div class="main-body">
    <div class="page-wrapper">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <form class="needs-validation" action="<?php echo e(route('materialsupdate', $material->id)); ?>" method="post" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="card">
                        <div class="card-header">
                            <h5>Edit Material</h5>
                        </div>
                        <div class="card-block">
                            <!-- Form Start -->
                            <div class="form-group">
                                <label for="title"><?php echo e(__('File Title')); ?> <span>*</span></label>
                                <input type="text" class="form-control" name="title" value="<?php echo e($material->title); ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="description"><?php echo e(__('File Description')); ?></label>
                                <textarea class="form-control" name="description"><?php echo e($material->description); ?></textarea>
                            </div>

                            <div class="form-group">
                                <label for="category_id"><?php echo e(__('Category')); ?> <span>*</span></label>
                                <select class="form-control" name="category_id" required>
                                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($category->id); ?>" <?php echo e($material->category_id == $category->id ? 'selected' : ''); ?>>
                                            <?php echo e($category->name); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="type"><?php echo e(__('File Type')); ?> <span>*</span></label>
                                <select class="form-control" name="type" required>
                                    <option value="PDF" <?php echo e($material->type == 'PDF' ? 'selected' : ''); ?>>PDF</option>
                                    <option value="Video" <?php echo e($material->type == 'Video' ? 'selected' : ''); ?>>Video</option>
                                    <option value="Doc" <?php echo e($material->type == 'Doc' ? 'selected' : ''); ?>>Doc</option>
                                    <option value="Image" <?php echo e($material->type == 'Image' ? 'selected' : ''); ?>>Image</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="file_path"><?php echo e(__('Upload New File')); ?></label>
                                <input type="file" class="form-control" name="file_path">
                            </div>

                            <div class="form-group">
                                <label for="thumbnail"><?php echo e(__('Upload New Thumbnail')); ?></label>
                                <input type="file" class="form-control" name="thumbnail">
                            </div>

                            <div class="form-group">
                                <label for="author"><?php echo e(__('Author')); ?></label>
                                <input type="text" class="form-control" name="author" value="<?php echo e($material->author); ?>">
                            </div>

                            <div class="form-group">
                                <label for="publisher"><?php echo e(__('Publisher')); ?></label>
                                <input type="text" class="form-control" name="publisher" value="<?php echo e($material->publisher); ?>">
                            </div>

                            <div class="form-group">
                                <label for="language"><?php echo e(__('Language')); ?></label>
                                <input type="text" class="form-control" name="language" value="<?php echo e($material->language); ?>">
                            </div>

                            <div class="form-group">
                                <label for="edition"><?php echo e(__('Edition')); ?></label>
                                <input type="text" class="form-control" name="edition" value="<?php echo e($material->edition); ?>">
                            </div>

                            <div class="form-group">
                                <label for="isbn"><?php echo e(__('ISBN')); ?></label>
                                <input type="text" class="form-control" name="isbn" value="<?php echo e($material->isbn); ?>">
                            </div>

                            <div class="form-group">
                                <label for="is_public"><?php echo e(__('Public')); ?></label>
                                <input type="checkbox" name="is_public" value="1" <?php echo e($material->is_public ? 'checked' : ''); ?>>
                            </div>

                            

                           
                            
<div class="form-group"> 
    <label for="is_downloadable" class="form-label"><?php echo e(__('Downloadable')); ?></label> 
    <input type="checkbox" name="is_downloadable" id="is_downloadable" value="1" <?php echo e(old('is_downloadable', $material->is_downloadable) ? 'checked' : ''); ?>>
</div>





                            <!-- Form End -->
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-success">Update Material</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\business\backup\Dapin\Dapin\resources\views\admin\files\editmaterial.blade.php ENDPATH**/ ?>