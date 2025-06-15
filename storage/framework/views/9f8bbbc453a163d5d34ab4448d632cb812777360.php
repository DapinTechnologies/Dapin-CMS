<?php $__env->startSection('title', $title); ?>
<?php $__env->startSection('content'); ?>

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5><?php echo e($title); ?></h5>
                    </div>
                    
                    <div class="card-block">
                        <form class="needs-validation" novalidate method="get" action="<?php echo e(route($route.'.index')); ?>">
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label><?php echo e(__('field_start_date')); ?></label>
                                    <input type="date" name="start_date" class="form-control date" value="<?php echo e(isset($start_date)? $start_date : null); ?>">

                                    <div class="invalid-feedback">
                                      <?php echo e(__('required_field')); ?> <?php echo e(__('field_start_date')); ?>

                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label><?php echo e(__('field_end_date')); ?></label>
                                    <input type="date" name="end_date" class="form-control date" value="<?php echo e(isset($end_date)? $end_date : null); ?>">

                                    <div class="invalid-feedback">
                                      <?php echo e(__('required_field')); ?> <?php echo e(__('field_end_date')); ?>

                                    </div>
                                </div>
                                <div class="form-group col-6 col-md-3">
                                    <button type="submit" class="btn btn-info btn-filter"><i class="fas fa-search"></i> <?php echo e(__('btn_search')); ?></button>
                                </div>

                                <div class="dropdown form-group col-6 col-md-3 btn-filter">
                                  <button class="btn btn-info dropdown-toggle" type="button" id="dropdownCalculation" data-bs-toggle="dropdown" aria-expanded="false">
                                    <?php if($date_range == 1): ?>
                                    <?php echo e(__('cal_1_month')); ?>

                                    <?php elseif($date_range == 3): ?>
                                    <?php echo e(__('cal_3_months')); ?>

                                    <?php elseif($date_range == 6): ?>
                                    <?php echo e(__('cal_6_months')); ?>

                                    <?php elseif($date_range == 12): ?>
                                    <?php echo e(__('cal_1_year')); ?>

                                    <?php elseif($date_range == 0): ?>
                                    <?php echo e(__('cal_beginning')); ?>

                                    <?php else: ?>
                                    <?php echo e(__('cal_date_range')); ?>

                                    <?php endif; ?>
                                  </button>
                                  <div class="dropdown-menu" aria-labelledby="dropdownCalculation">
                                    <a class="dropdown-item" href="<?php echo e(route($route.'.show', '1')); ?>"><?php echo e(__('cal_1_month')); ?></a>
                                    <a class="dropdown-item" href="<?php echo e(route($route.'.show', '3')); ?>"><?php echo e(__('cal_3_months')); ?></a>
                                    <a class="dropdown-item" href="<?php echo e(route($route.'.show', '6')); ?>"><?php echo e(__('cal_6_months')); ?></a>
                                    <a class="dropdown-item" href="<?php echo e(route($route.'.show', '12')); ?>"><?php echo e(__('cal_1_year')); ?></a>
                                    <a class="dropdown-item" href="<?php echo e(route($route.'.show', '0')); ?>"><?php echo e(__('cal_beginning')); ?></a>
                                  </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">

            <!-- [ wallet section ] start-->
            <div class="col-md-6 col-xl-4">
                <div class="card theme-bg bitcoin-wallet">
                    <div class="card-block">
                        <h5 class="text-white mb-2"><?php echo e(__('cal_overall_income')); ?></h5>
                        <h2 class="text-white mb-2 f-w-300"><?php echo $setting->currency_symbol; ?> <?php echo e($total_income ?? '0'); ?></h2>
                        <i class="fas fa-arrow-circle-up f-70 text-white"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xl-4">
                <div class="card theme-bg2 bitcoin-wallet">
                    <div class="card-block">
                        <h5 class="text-white mb-2"><?php echo e(__('cal_overall_expense')); ?></h5>
                        <h2 class="text-white mb-2 f-w-300"><?php echo $setting->currency_symbol; ?> <?php echo e($total_expense ?? '0'); ?></h2>
                        <i class="fas fa-arrow-circle-down f-70 text-white"></i>
                    </div>
                </div>
            </div>

            <?php
                $total_outcome = $total_income - $total_expense;
            ?>
            <div class="col-md-12 col-xl-4">
                <div class="card bg-c-blue bitcoin-wallet">
                    <div class="card-block">
                        <h5 class="text-white mb-2"><?php echo e(__('cal_outcome')); ?></h5>
                        <h2 class="text-white mb-2 f-w-300"><?php echo $setting->currency_symbol; ?> <?php echo e($total_outcome ?? '0'); ?></h2>
                        <i class="fas fa-chart-line f-70 text-white"></i>
                    </div>
                </div>
            </div>
            <!-- [ wallet section ] end-->

        </div>

        <div class="row">
            <div class="col-xl-4 col-md-4">
                <div class="card">
                    <div class="card-block">
                        <canvas id="incomes"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-4">
                <div class="card">
                    <div class="card-block">
                        <canvas id="expenses"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-xl-12 col-md-12">
                <div class="card">
                    <div class="card-block">
                        <canvas id="incomes-expenses"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

<?php $__env->stopSection(); ?>

<?php $__env->startSection('page_js'); ?>
    <!-- chartjs js -->
    <script src="<?php echo e(asset('dashboard/plugins/chart-chartjs/js/chart.min.js')); ?>"></script>
    
    <script type="text/javascript">
        'use strict';
        $(document).ready(function() {
            // [ bar-chart ] start
            var labels =  <?php echo $months ?>;
            var monthly_incomes =  <?php echo $monthly_incomes ?>;
            var monthly_expenses =  <?php echo $monthly_expenses ?>;

            var bar = document.getElementById("incomes-expenses").getContext('2d');
            var theme_g1 = bar.createLinearGradient(0, 300, 0, 0);
            theme_g1.addColorStop(0, '#1de9b6');
            theme_g1.addColorStop(1, '#1dc4e9');
            var theme_g2 = bar.createLinearGradient(0, 300, 0, 0);
            theme_g2.addColorStop(0, '#899FD4');
            theme_g2.addColorStop(1, '#A389D4');
            var calcul = {
                labels: labels,
                datasets: [{
                    label: "<?php echo e(__('cal_overall_income')); ?>",
                    data: monthly_incomes,
                    borderColor: theme_g1,
                    backgroundColor: theme_g1,
                    hoverborderColor: theme_g1,
                    hoverBackgroundColor: theme_g1,
                }, {
                    label: "<?php echo e(__('cal_overall_expense')); ?>",
                    data: monthly_expenses,
                    borderColor: theme_g2,
                    backgroundColor: theme_g2,
                    hoverborderColor: theme_g2,
                    hoverBackgroundColor: theme_g2,
                }]
            };
            var myBarChart = new Chart(bar, {
                type: 'bar',
                data: calcul,
                options: {
                    barValueSpacing: 100
                }
            });
            // [ bar-chart ] end


            // [ pie-chart ] start
            var bar = document.getElementById("incomes").getContext('2d');
            var incomes = {
                labels: [
                    <?php $__currentLoopData = $income_categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $income_category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    '<?php echo e($income_category->title); ?>', 
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                ],
                datasets: [{
                    data: [
                    <?php $__currentLoopData = $income_categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $income_category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php echo e($income_category->incomes->where('status', '1')->where('date', '>=', $start_date)->where('date', '<=', $end_date)->sum('amount')); ?>, 
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    ],
                    backgroundColor: [
                        "#1de9b6",
                        "#899FD4",
                        "#04a9f5",
                        "#2f4858",
                        "#386c5f",
                        "#a2b455",
                        "#daeb89",
                        "#7a91fb",
                        "#b0ec8f",
                        "#fa7239"
                    ]
                }]
            };
            var myPieChart = new Chart(bar, {
                type: 'doughnut',
                data: incomes,
                responsive: true,
                options: {
                    maintainAspectRatio: false,
                    plugins: {
                        title: {
                            display: true,
                            text: '<?php echo e(trans_choice('module_income', 2)); ?>'
                        }
                    }
                }
            });
            // [ pie-chart ] end

            // [ pie-chart ] start
            var bar = document.getElementById("expenses").getContext('2d');
            var expenses = {
                labels: [
                    <?php $__currentLoopData = $expense_categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $expense_category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    '<?php echo e($expense_category->title); ?>', 
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                ],
                datasets: [{
                    data: [
                    <?php $__currentLoopData = $expense_categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $expense_category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php echo e($expense_category->expenses->where('status', '1')->where('date', '>=', $start_date)->where('date', '<=', $end_date)->sum('amount')); ?>, 
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    ],
                    backgroundColor: [
                        "#1de9b6",
                        "#899FD4",
                        "#04a9f5",
                        "#2f4858",
                        "#386c5f",
                        "#a2b455",
                        "#daeb89",
                        "#7a91fb",
                        "#b0ec8f",
                        "#fa7239"
                    ]
                }]
            };
            var myPieChart = new Chart(bar, {
                type: 'doughnut',
                data: expenses,
                responsive: true,
                options: {
                    maintainAspectRatio: false,
                    plugins: {
                        title: {
                            display: true,
                            text: '<?php echo e(trans_choice('module_expense', 2)); ?>'
                        }
                    }
                }
            });
            // [ pie-chart ] end
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\Dapin-CMS-main\resources\views/admin/outcome/index.blade.php ENDPATH**/ ?>