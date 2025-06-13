
<?php $__env->startSection('title', $title); ?>
<?php $__env->startSection('content'); ?>

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-primary text-white py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title mb-1"><?php echo e($title); ?></h5>
                                <p class="card-subtitle text-white-80 mb-0">
                                    <i class="fas fa-calendar-alt me-1"></i> Semester: <?php echo e($enroll->semester->title ?? 'N/A'); ?> • <?php echo e(date('Y')); ?>

                                </p>
                            </div>
                            <div class="badge bg-white text-primary fs-6 py-2 px-3">
                                <i class="fas fa-user-graduate me-1"></i> <?php echo e($enroll->program->title ?? ''); ?>

                            </div>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <?php if(isset($enroll)): ?>
                        <!-- Registration Section -->
                        <div class="registration-section mb-5">
                            <div class="section-header d-flex justify-content-between align-items-center mb-4 border-bottom pb-2">
                                <div>
                                    <h4 class="section-title text-dark mb-0">
                                        <i class="fas fa-book me-2 text-primary"></i> Available Units
                                    </h4>
                                    <small class="text-muted">Your registered Units for this semester</small>
                                </div>
                                <div class="bg-light p-2 rounded">
                                    <i class="fas fa-clock me-1 text-success"></i> 
                                    <strong>Max Credit Hours:</strong> <?php echo e($enroll->program->max_credit_hour ?? '--'); ?>

                                </div>
                            </div>
                            
                            <?php if(isset($available_subjects) && count($available_subjects) > 0): ?>
                            <form class="needs-validation" novalidate action="<?php echo e(route($route.'.store')); ?>" method="post">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="student_enroll_id" value="<?php echo e($enroll->id); ?>">
                                
                                <div class="subject-cards row g-4">
                                    <?php $__currentLoopData = $available_subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="col-md-6 col-lg-4">
                                        <div class="card subject-card h-100 border">
                                            <div class="card-header bg-light py-2">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <span class="badge <?php echo e($subject->subject_type == 0 ? 'bg-primary' : 'bg-success'); ?> rounded-pill">
                                                        <?php echo e($subject->subject_type == 0 ? __('CORE') : __('Active Now')); ?>

                                                    </span>
                                                    
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <h5 class="subject-code text-dark mb-1">Unit Code: <?php echo e($subject->code); ?></h5>
                                                <h4 class="subject-title text-dark mb-2"><?php echo e($subject->title); ?></h4>
                                                
                                                <div class="subject-meta mb-3">
                                                    <div class="d-flex align-items-center mb-1">
                                                        <i class="fas fa-user-tie text-muted me-2"></i>
                                                        <small class="text-muted">Lecturer: <?php echo e($subject->teacher->first_name ?? 'TBA'); ?></small>
                                                    </div>
                                                    <div class="d-flex align-items-center">
                                                        <i class="fas fa-clock text-muted me-2"></i>
                                                        <small class="text-muted"><?php echo e($subject->credit_hour); ?> Credit Hours</small>
                                                    </div>
                                                </div>
                                                
                                                <div class="subject-description">
                                                    <p class="text-muted small mb-0"><?php echo e(Str::limit($subject->description, 100)); ?></p>
                                                </div>
                                            </div>
                                            <div class="card-footer bg-transparent border-top-0 pt-0">
                                                <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#courseModal-<?php echo e($subject->id); ?>">
                                                    <i class="fas fa-info-circle me-1"></i> Details
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                                
                              
                            </form>
                            <?php else: ?>
                            <div class="alert alert-warning bg-light border border-warning text-dark">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-exclamation-triangle text-warning me-3 fs-4"></i>
                                    <div>
                                        <h5 class="alert-heading mb-1">No units available</h5>
                                        <p class="mb-0">There are currently no Units available for you this semester</p>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>
                        
                        <!-- Help Section -->
                        <div class="card-footer bg-light border-top-0">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-headset text-primary me-3 fs-3"></i>
                                        <div>
                                            <h6 class="mb-1 text-dark">No Unit Available Assistance?</h6>
                                            <p class="small text-muted mb-0">Contact your academic advisor or visit the registrar's office</p>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

<style>
    /* Card Styling */
    .subject-card {
        transition: all 0.3s ease;
        border-radius: 4px;
        border-left: 4px solid var(--bs-primary);
    }
    .subject-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    .subject-code {
        font-family: 'Courier New', monospace;
        font-weight: 600;
        letter-spacing: 0.5px;
        color: var(--bs-dark);
    }
    .subject-title {
        font-weight: 600;
        font-size: 1.1rem;
        color: var(--bs-dark);
    }
    
    /* Section Titles */
    .section-title {
        font-weight: 600;
        position: relative;
        padding-bottom: 8px;
        color: var(--bs-dark);
    }
    .section-title:after {
        content: '';
        position: absolute;
        left: 0;
        bottom: 0;
        width: 40px;
        height: 3px;
        background: linear-gradient(90deg, var(--bs-primary), var(--bs-success));
        border-radius: 3px;
    }
    
    /* Table Styling */
    .table thead th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 0.5px;
    }
    
    /* Form Switch */
    .form-check-input.subject-toggle {
        width: 2.5em;
        height: 1.3em;
    }
    .form-check-input:checked {
        background-color: var(--bs-primary);
        border-color: var(--bs-primary);
    }
    
    /* Empty State */
    .empty-state {
        background-color: var(--bs-light);
    }
    .empty-state-icon {
        color: var(--bs-primary);
    }
    
    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .registration-actions .btn {
            width: 100%;
            margin-bottom: 10px;
        }
        .registration-actions .btn:not(:first-child) {
            margin-left: 0;
        }
        
        .card-footer .btn {
            width: 100%;
            margin-bottom: 10px;
        }
        .card-footer .btn:not(:first-child) {
            margin-left: 0;
        }
    }
</style>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('student.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\Dapin-CMS-main\resources\views/student/student-subject/index.blade.php ENDPATH**/ ?>