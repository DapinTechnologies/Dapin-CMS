    <!-- Show modal content -->
    <div id="showModal-<?php echo e($row->id); ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel"><?php echo e(__('modal_view')); ?> <?php echo e($title); ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <!-- Details View Start -->
                    
                    <div class="template-container" style="border-image: url('<?php echo e(asset('uploads/'.$path.'/'.$row->background)); ?>') 30 stretch; width: <?php echo e($row->width); ?>; height: <?php echo e($row->height); ?>;">
                      <div class="template-inner">
                        <!-- Header Section -->
                        <table class="table-no-border">
                            <tbody>
                                <tr>
                                    <td class="temp-logo">
                                      <div class="inner">
                                        <?php if(is_file('uploads/'.$path.'/'.$row->logo_left)): ?>
                                        <img src="<?php echo e(asset('uploads/'.$path.'/'.$row->logo_left)); ?>" alt="Logo">
                                        <?php endif; ?>
                                      </div>
                                    </td>
                                    <td class="temp-title">
                                      <div class="inner">
                                        <h2><?php echo e($setting->title ?? ''); ?></h2>
                                      </div>
                                    </td>
                                    <td class="temp-logo last">
                                      <div class="inner">
                                        <?php if($row->student_photo == 1): ?>
                                        <img src="<?php echo e(asset('dashboard/images/user/avatar-2.jpg')); ?>" alt="Student">
                                        <?php endif; ?>
                                      </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="table-no-border">
                            <tbody>
                                <tr>
                                    <td class="main-title">
                                        <h4><?php echo e($row->title); ?></h4>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <!-- Header Section -->

                        <!-- Header Section -->
                        <table class="table-no-border">
                            <tbody>
                                <tr>
                                    <td class="meta-data">
                                        <div class="inner"><?php echo e(__('field_no')); ?>: 000197</div>
                                    </td>
                                    <td class="meta-data last">
                                        <div class="inner"><?php echo e(__('field_date')); ?>: 
                                            <?php if(isset($setting->date_format)): ?>
                                            <?php echo e(date($setting->date_format, strtotime(date('Y-m-d')))); ?>

                                            <?php else: ?>
                                            <?php echo e(date("Y-m-d", strtotime(date('Y-m-d')))); ?>

                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <!-- Header Section -->

                        <!-- Header Section -->
                        <table class="table-no-border">
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="temp-body">
                                            <?php echo $row->body; ?>

                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <!-- Header Section -->

                        <!-- Header Section -->
                        <?php if($row->barcode == 1): ?>
                        <table class="table-no-border">
                            <tbody>
                                <tr>
                                    <td style="width: 33.33%; text-align: center;"></td>
                                    <td style="width: 33.33%; text-align: center; font-family: 'IDAHC39M Code 39 Barcode', Times, serif;">
                                        <?php echo DNS1D::getBarcodeSVG('IDAHC39M', 'C39', 1, 33, '#000', false); ?>

                                    </td>
                                    <td style="width: 33.33%; text-align: center;"></td>
                                </tr>
                            </tbody>
                        </table>
                        <?php endif; ?>
                        <table class="table-no-border">
                            <tbody>
                                <tr>
                                    <td class="temp-footer">
                                      <div class="inner">
                                        <p><?php echo $row->footer_left; ?></p>
                                      </div>
                                    </td>
                                    <td class="temp-footer">
                                      <div class="inner">
                                        <p><?php echo $row->footer_center; ?></p>
                                      </div>
                                    </td>
                                    <td class="temp-footer">
                                      <div class="inner">
                                        <p><?php echo $row->footer_right; ?></p>
                                      </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <!-- Header Section -->
                      </div>
                    </div>

                    <!-- Details View End -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times"></i> <?php echo e(__('btn_close')); ?></button>
                </div>
            </div>
        </div>
    </div><?php /**PATH C:\Users\User\Desktop\business\backup\Dapin\Dapin\resources\views\admin\certificate-template\show.blade.php ENDPATH**/ ?>