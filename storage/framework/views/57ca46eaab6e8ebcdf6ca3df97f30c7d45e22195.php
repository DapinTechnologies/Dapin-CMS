    <!-- Edit modal content -->
    <div id="payModal-<?php echo e($row->id); ?>" class="modal fade" tabindex="-1" role="dialog" id="payModal-<?php echo e($row->id); ?>" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <form class="needs-validation" novalidate action="<?php echo e(route($route.'.pay')); ?>" method="post" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel"><?php echo e($title); ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <!-- View Start -->
                    <div class="">
                        <div class="row">
                            <div class="col-md-6">
                                <p><mark class="text-primary"><?php echo e(__('field_student_id')); ?>:</mark> #<?php echo e($row->studentEnroll->student->student_id ?? ''); ?></p><hr/>
                                <p><mark class="text-primary"><?php echo e(__('field_name')); ?>:</mark> <?php echo e($row->studentEnroll->student->first_name ?? ''); ?> <?php echo e($row->studentEnroll->student->last_name ?? ''); ?></p><hr/>
                                <p><mark class="text-primary"><?php echo e(__('field_program')); ?>:</mark> <?php echo e($row->studentEnroll->program->title ?? ''); ?></p><hr/>
                            </div>
                            <div class="col-md-6">
                                <p><mark class="text-primary"><?php echo e(__('field_fees_type')); ?>:</mark> <?php echo e($row->category->title ?? ''); ?></p><hr/>
                                <p><mark class="text-primary"><?php echo e(__('field_session')); ?>:</mark> <?php echo e($row->studentEnroll->session->title ?? ''); ?></p><hr/>
                                <p><mark class="text-primary"><?php echo e(__('field_semester')); ?>:</mark> <?php echo e($row->studentEnroll->semester->title ?? ''); ?> (<?php echo e($row->studentEnroll->section->title ?? ''); ?>)</p><hr/>
                            </div>
                        </div>
                    </div>
                    <br/>

                    <input type="text" name="fee_id" value="<?php echo e($row->id); ?>" hidden>

                    <!-- Form Start -->
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="due_date" class="form-label"><?php echo e(__('field_due_date')); ?> <span>*</span></label>
                            <input type="date" class="form-control" name="due_date" id="due_date" value="<?php echo e($row->due_date); ?>" required readonly>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_due_date')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="pay_date" class="form-label"><?php echo e(__('field_pay_date')); ?> <span>*</span></label>
                            <input type="date" class="form-control" name="pay_date" id="pay_date" value="<?php echo e(date('Y-m-d')); ?>" required readonly>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_pay_date')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="fee_amount" class="form-label"><?php echo e(__('field_amount')); ?> (<?php echo $setting->currency_symbol; ?>) <span>*</span></label>
                            <input type="text" class="form-control autonumber" name="fee_amount" id="fee_amount" value="<?php echo e(round($row->fee_amount, 2)); ?>" required readonly>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_amount')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="discount_amount" class="form-label"><?php echo e(__('field_discount')); ?> (<?php echo $setting->currency_symbol; ?>) <span>*</span></label>
                            <input type="text" class="form-control autonumber" name="discount_amount" id="discount_amount" value="<?php echo e(round($discount_amount, 2)); ?>" required readonly>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_discount')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="fine_amount" class="form-label"><?php echo e(__('field_fine_amount')); ?> (<?php echo $setting->currency_symbol; ?>) <span>*</span></label>
                            <input type="text" class="form-control autonumber" name="fine_amount" id="fine_amount" value="<?php echo e(round($fine_amount, 2)); ?>" required readonly>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_fine_amount')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="net_amount" class="form-label"><?php echo e(__('field_net_amount')); ?> (<?php echo $setting->currency_symbol; ?>) <span>*</span></label>
                            <input type="text" class="form-control autonumber" name="paid_amount" id="net_amount" value="<?php echo e(round($net_amount, 2)); ?>"  required readonly>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_net_amount')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="payment_method" class="form-label"><?php echo e(__('field_payment_method')); ?> <span>*</span></label>
                            <select class="form-control" name="payment_method" id="payment_method-<?php echo e($row->id); ?>" required>
                                <option value=""><?php echo e(__('select')); ?></option>
                                <option value="1" <?php if( old('payment_method') == 1 ): ?> selected <?php endif; ?>><?php echo e(__('payment_method_card')); ?></option>
                                <option value="2" <?php if( old('payment_method') == 2 ): ?> selected <?php endif; ?>><?php echo e(__('payment_method_cash')); ?></option>
                                <option value="3" <?php if( old('payment_method') == 3 ): ?> selected <?php endif; ?>><?php echo e(__('payment_method_cheque')); ?></option>
                                <option value="4" <?php if( old('payment_method') == 4 ): ?> selected <?php endif; ?>><?php echo e(__('payment_method_bank')); ?></option>
                                <option value="5" <?php if( old('payment_method') == 5 ): ?> selected <?php endif; ?>><?php echo e(__('payment_method_e_wallet')); ?></option>
                            </select>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_payment_method')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="note" class="form-label"><?php echo e(__('field_note')); ?></label>
                            <input type="text" class="form-control" name="note" id="note-<?php echo e($row->id); ?>" value="<?php echo e(old('note')); ?>">
                        </div>
                    </div>
                    <!-- Form End -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times"></i> <?php echo e(__('btn_close')); ?></button>
                    <button type="submit" class="btn btn-success"><i class="fas fa-money-check"></i> <?php echo e(__('btn_received')); ?></button>
                </div>
              </form>
            </div>
        </div>
    </div><?php /**PATH C:\Users\User\Desktop\business\backup\Dapin\Dapin\resources\views\admin\fees-student\pay.blade.php ENDPATH**/ ?>