
<?php $__env->startSection('title', $title); ?>
<?php $__env->startSection('content'); ?>

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->



         <div class="col-sm-12">
                <form class="needs-validation" novalidate action="<?php echo e(route($route.'.store')); ?>" method="post" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="card">
                    <div class="card-header">
                        <h5><?php echo e(__('btn_update')); ?> <?php echo e($title); ?></h5>
                        <div class="float-right">
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#historyModal">
                                <i class="fas fa-history"></i> Manage History
                            </button>
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#partnersModal">
                                <i class="fas fa-handshake"></i> Manage Partners
                            </button>
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#accreditationsModal">
                                <i class="fas fa-certificate"></i> Manage Accreditations
                            </button>
                        </div>
                    </div>
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

                        <div class="form-group col-md-6">
                            <label for="short_desc"><?php echo e(__('field_short_desc')); ?></label>
                            <textarea name="short_desc" id="short_desc" class="form-control texteditor"><?php echo e(isset($row->short_desc)?$row->short_desc:''); ?></textarea>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_short_desc')); ?>

                            </div>
                        </div> 

                        <div class="form-group col-md-12">
                            <label for="description"><?php echo e(__('field_description')); ?> <span>*</span></label>
                            <textarea name="description" id="description" class="form-control texteditor" required><?php echo e(isset($row->description)?$row->description:''); ?></textarea>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_description')); ?>

                            </div>
                        </div>

                         <div class="form-group col-md-6">
                            <label for="button_text"><?php echo e(__('field_button_text')); ?></label>
                            <input type="text" class="form-control" name="button_text" id="button_text" value="<?php echo e(isset($row->button_text)?$row->button_text:''); ?>">

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_button_text')); ?>

                            </div>
                        </div> 

                        <div class="form-group col-md-6">
                            <label for="video_id"><?php echo e(__('field_video_id')); ?></label>
                            <input type="text" class="form-control" name="video_id" id="video_id" value="<?php echo e(isset($row->video_id)?$row->video_id:''); ?>">

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_video_id')); ?>

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
<!-- History Modal -->
<div class="modal fade" id="historyModal" tabindex="-1" role="dialog" aria-labelledby="historyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="historyModalLabel">Manage History Timeline</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="historyContainer">
                    <?php if(isset($row) && $row->histories->count() > 0): ?>
                        <?php $__currentLoopData = $row->histories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $history): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="history-item mb-4 border p-3">
                            <!-- Existing history items -->
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                        <!-- Default empty form -->
                        <div class="history-item mb-4 border p-3">
                            <div class="row">
                                <input type="hidden" name="histories[0][id]" value="">
                                <div class="form-group col-md-2">
                                    <label>Year</label>
                                    <input type="text" class="form-control" name="histories[0][year]" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Title</label>
                                    <input type="text" class="form-control" name="histories[0][title]" required>
                                </div>
                                <div class="form-group col-md-5">
                                    <label>Image</label>
                                    <input type="file" class="form-control" name="histories[0][image]">
                                </div>
                                <div class="form-group col-md-1 d-flex align-items-end">
                                    <button type="button" class="btn btn-sm btn-danger remove-history">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Description</label>
                                    <textarea class="form-control" name="histories[0][description]"></textarea>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="addHistory">
                    <i class="fas fa-plus"></i> Add Another History Item
                </button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveHistory">Save Changes</button>
            </div>
        </div>
    </div>
</div>

<!-- Partners Modal -->
<div class="modal fade" id="partnersModal" tabindex="-1" role="dialog" aria-labelledby="partnersModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="partnersModalLabel">Manage Partners</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="partnersContainer">
                    <?php if(isset($row) && $row->partners->count() > 0): ?>
                        <?php $__currentLoopData = $row->partners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $partner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="partner-item mb-4 border p-3">
                            <!-- Existing partner items -->
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                        <!-- Default empty form -->
                        <div class="partner-item mb-4 border p-3">
                            <div class="row">
                                <input type="hidden" name="partners[0][id]" value="">
                                <div class="form-group col-md-4">
                                    <label>Name</label>
                                    <input type="text" class="form-control" name="partners[0][name]" required>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Logo</label>
                                    <input type="file" class="form-control" name="partners[0][logo]">
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Website URL</label>
                                    <input type="url" class="form-control" name="partners[0][url]">
                                </div>
                                <div class="form-group col-md-2 d-flex align-items-end">
                                    <button type="button" class="btn btn-sm btn-danger remove-partner">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="addPartner">
                    <i class="fas fa-plus"></i> Add Another Partner
                </button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="savePartners">Save Changes</button>
            </div>
        </div>
    </div>
</div>

<!-- Accreditations Modal -->
<div class="modal fade" id="accreditationsModal" tabindex="-1" role="dialog" aria-labelledby="accreditationsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="accreditationsModalLabel">Manage Accreditations</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="accreditationsContainer">
                    <?php if(isset($row) && $row->accreditations->count() > 0): ?>
                        <?php $__currentLoopData = $row->accreditations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $accreditation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="accreditation-item mb-4 border p-3">
                            <!-- Existing accreditation items -->
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                        <!-- Default empty form -->
                        <div class="accreditation-item mb-4 border p-3">
                            <div class="row">
                                <input type="hidden" name="accreditations[0][id]" value="">
                                <div class="form-group col-md-4">
                                    <label>Name</label>
                                    <input type="text" class="form-control" name="accreditations[0][name]" required>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Logo</label>
                                    <input type="file" class="form-control" name="accreditations[0][logo]">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Description</label>
                                    <textarea class="form-control" name="accreditations[0][description]"></textarea>
                                </div>
                                <div class="form-group col-md-1 d-flex align-items-end">
                                    <button type="button" class="btn btn-sm btn-danger remove-accreditation">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="addAccreditation">
                    <i class="fas fa-plus"></i> Add Another Accreditation
                </button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveAccreditations">Save Changes</button>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script>

  $(document).ready(function() {
    // Initialize indices
    let historyIndex = <?php echo e(isset($row) && $row->histories->count() > 0 ? $row->histories->count() : 1); ?>;
    let partnerIndex = <?php echo e(isset($row) && $row->partners->count() > 0 ? $row->partners->count() : 1); ?>;
    let accreditationIndex = <?php echo e(isset($row) && $row->accreditations->count() > 0 ? $row->accreditations->count() : 1); ?>;

    // Add History Item
    $('#addHistory').click(function() {
        let html = `
        <div class="history-item mb-4 border p-3">
            <div class="row">
                <input type="hidden" name="histories[${historyIndex}][id]" value="">
                <div class="form-group col-md-2">
                    <label>Year</label>
                    <input type="text" class="form-control" name="histories[${historyIndex}][year]" required>
                </div>
                <div class="form-group col-md-4">
                    <label>Title</label>
                    <input type="text" class="form-control" name="histories[${historyIndex}][title]" required>
                </div>
                <div class="form-group col-md-5">
                    <label>Image</label>
                    <input type="file" class="form-control" name="histories[${historyIndex}][image]">
                </div>
                <div class="form-group col-md-1 d-flex align-items-end">
                    <button type="button" class="btn btn-sm btn-danger remove-history">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
                <div class="form-group col-md-12">
                    <label>Description</label>
                    <textarea class="form-control" name="histories[${historyIndex}][description]"></textarea>
                </div>
            </div>
        </div>`;
        $('#historyContainer').append(html);
        historyIndex++;
    });

    // Add Partner
    $('#addPartner').click(function() {
        let html = `
        <div class="partner-item mb-4 border p-3">
            <div class="row">
                <input type="hidden" name="partners[${partnerIndex}][id]" value="">
                <div class="form-group col-md-4">
                    <label>Name</label>
                    <input type="text" class="form-control" name="partners[${partnerIndex}][name]" required>
                </div>
                <div class="form-group col-md-3">
                    <label>Logo</label>
                    <input type="file" class="form-control" name="partners[${partnerIndex}][logo]">
                </div>
                <div class="form-group col-md-3">
                    <label>Website URL</label>
                    <input type="url" class="form-control" name="partners[${partnerIndex}][url]">
                </div>
                <div class="form-group col-md-2 d-flex align-items-end">
                    <button type="button" class="btn btn-sm btn-danger remove-partner">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        </div>`;
        $('#partnersContainer').append(html);
        partnerIndex++;
    });

    // Add Accreditation
    $('#addAccreditation').click(function() {
        let html = `
        <div class="accreditation-item mb-4 border p-3">
            <div class="row">
                <input type="hidden" name="accreditations[${accreditationIndex}][id]" value="">
                <div class="form-group col-md-4">
                    <label>Name</label>
                    <input type="text" class="form-control" name="accreditations[${accreditationIndex}][name]" required>
                </div>
                <div class="form-group col-md-3">
                    <label>Logo</label>
                    <input type="file" class="form-control" name="accreditations[${accreditationIndex}][logo]">
                </div>
                <div class="form-group col-md-4">
                    <label>Description</label>
                    <textarea class="form-control" name="accreditations[${accreditationIndex}][description]"></textarea>
                </div>
                <div class="form-group col-md-1 d-flex align-items-end">
                    <button type="button" class="btn btn-sm btn-danger remove-accreditation">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        </div>`;
        $('#accreditationsContainer').append(html);
        accreditationIndex++;
    });

    // Remove items with protection against empty state
    $(document).on('click', '.remove-history', function() {
        if($('.history-item').length > 1) {
            $(this).closest('.history-item').remove();
        } else {
            alert('You must have at least one history entry.');
        }
    });
    
    $(document).on('click', '.remove-partner', function() {
        if($('.partner-item').length > 1) {
            $(this).closest('.partner-item').remove();
        } else {
            alert('You must have at least one partner entry.');
        }
    });
    
    $(document).on('click', '.remove-accreditation', function() {
        if($('.accreditation-item').length > 1) {
            $(this).closest('.accreditation-item').remove();
        } else {
            alert('You must have at least one accreditation entry.');
        }
    });

    // Save buttons
    $('#saveHistory, #savePartners, #saveAccreditations').click(function() {
        $(this).closest('.modal').modal('hide');
    });

    // Handle form submission
    $('form').submit(function(e) {
        // You can add any final validation here before submission
        return true;
    });
});
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\cms\Dapin-CMS\resources\views/admin/web/about-us/index.blade.php ENDPATH**/ ?>