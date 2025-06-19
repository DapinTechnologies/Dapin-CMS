<!-- Sidemenu -->
<div class="navbar-content scroll-div ps ps--active-y">
    <ul class="nav pcoded-inner-navbar">

         <?php
            function panel($slug){
                return \App\Models\Field::field($slug);
            }
        ?> 

        <li class="nav-item <?php echo e(Request::is('student/dashboard*') ? 'active' : ''); ?>">
            <a href="<?php echo e(route('student.dashboard.index')); ?>" class="nav-link">
                <span class="pcoded-micon"><i class="fas fa-desktop"></i></span>
                <span class="pcoded-mtext"><?php echo e(trans_choice('module_dashboard', 1)); ?></span>
            </a>
        </li>


        <?php if(($panel = panel('panel_class_routine')) && $panel->status == 1): ?>
        <li class="nav-item <?php echo e(Request::is('student/class-routine*') ? 'active' : ''); ?>">
            <a href="<?php echo e(route('student.class-routine.index')); ?>" class="nav-link">
                <span class="pcoded-micon"><i class="fas fa-clock"></i></span>
                <span class="pcoded-mtext"><?php echo e(trans_choice('module_class_routine', 2)); ?></span>
            </a>
        </li>
        <?php endif; ?>

        <?php if(($panel = panel('panel_exam_routine')) && $panel->status == 1): ?>
        <li class="nav-item <?php echo e(Request::is('student/exam-routine*') ? 'active' : ''); ?>">
            <a href="<?php echo e(route('student.exam-routine.index')); ?>" class="nav-link">
                <span class="pcoded-micon"><i class="fas fa-align-left"></i></span>
                <span class="pcoded-mtext"><?php echo e(trans_choice('module_exam_routine', 2)); ?></span>
            </a>
        </li>
        <?php endif; ?>

        <?php if(($panel = panel('panel_attendance')) && $panel->status == 1): ?>
        <li class="nav-item <?php echo e(Request::is('student/attendance*') ? 'active' : ''); ?>">
            <a href="<?php echo e(route('student.attendance.index')); ?>" class="nav-link">
                <span class="pcoded-micon"><i class="fas fa-calendar-check"></i></span>
                <span class="pcoded-mtext"><?php echo e(trans_choice('module_attendance', 2)); ?></span>
            </a>
        </li>
        <?php endif; ?>

        <?php if(($panel = panel('panel_leave')) && $panel->status == 1): ?>
        <li class="nav-item <?php echo e(Request::is('student/leave*') ? 'active' : ''); ?>">
            <a href="<?php echo e(route('student.leave.index')); ?>" class="nav-link">
                <span class="pcoded-micon"><i class="far fa-edit"></i></span>
                <span class="pcoded-mtext"><?php echo e(trans_choice('module_apply_leave', 2)); ?></span>
            </a>
        </li>
        <?php endif; ?>

        <?php if(($panel = panel('panel_fees_report')) && $panel->status == 1): ?>
        <li class="nav-item <?php echo e(Request::is('student/fees*') ? 'active' : ''); ?>">
            <a href="<?php echo e(route('student.fees.index')); ?>" class="nav-link">
                <span class="pcoded-micon"><i class="fas fa-money-bill-wave"></i></span>
                <span class="pcoded-mtext"><?php echo e(trans_choice('module_fees_report', 2)); ?></span>
            </a>
        </li>
        <?php endif; ?>

         
     

<li class="nav-item <?php echo e(Request::is('student/subject*') ? 'active' : ''); ?>">
    <a href="<?php echo e(route('student.subject.index')); ?>" class="nav-link">
        <span class="pcoded-micon"><i class="fas fa-clipboard-list"></i></span>
        <span class="pcoded-mtext"><?php echo e(__('Register Units')); ?></span>
    </a>
</li>

        <?php if(($panel = panel('panel_library')) && $panel->status == 1): ?>
        <li class="nav-item <?php echo e(Request::is('student/library*') ? 'active' : ''); ?>">
            <a href="<?php echo e(route('student.library.index')); ?>" class="nav-link">
                <span class="pcoded-micon"><i class="fas fa-book-open"></i></span>
                <span class="pcoded-mtext"><?php echo e(trans_choice('module_library', 2)); ?></span>
            </a>
        </li>
        <?php endif; ?>
    
        <?php if(($panel = panel('panel_digital')) && $panel->status == 1): ?>
        <li class="nav-item <?php echo e(Request::is('student/digital*') ? 'active' : ''); ?>">
            <a href="<?php echo e(route('studentlibrarydigital')); ?>" class="nav-link">
                <span class="pcoded-micon"><i class="fas fa-book-open"></i></span>
                <span class="pcoded-mtext"><?php echo e(trans_choice('Digital Library', 2)); ?></span>
            </a>
        </li>
        <?php endif; ?>

        <?php if(($panel = panel('panel_notice')) && $panel->status == 1): ?>
        <li class="nav-item <?php echo e(Request::is('student/notice*') ? 'active' : ''); ?>">
            <a href="<?php echo e(route('student.notice.index')); ?>" class="nav-link">
                <span class="pcoded-micon"><i class="fas fa-bullhorn"></i></span>
                <span class="pcoded-mtext"><?php echo e(trans_choice('module_notice', 2)); ?></span>
            </a>
        </li>
        <?php endif; ?>

        <?php if(($panel = panel('panel_assignment')) && $panel->status == 1): ?>
        <li class="nav-item <?php echo e(Request::is('student/assignment*') ? 'active' : ''); ?>">
            <a href="<?php echo e(route('student.assignment.index')); ?>" class="nav-link">
                <span class="pcoded-micon"><i class="fas fa-newspaper"></i></span>
                <span class="pcoded-mtext"><?php echo e(trans_choice('module_assignment', 2)); ?></span>
            </a>
        </li>
        <?php endif; ?>

        <?php if(($panel = panel('panel_download')) && $panel->status == 1): ?>
        <li class="nav-item <?php echo e(Request::is('student/download*') ? 'active' : ''); ?>">
            <a href="<?php echo e(route('student.download.index')); ?>" class="nav-link">
                <span class="pcoded-micon"><i class="fas fa-download"></i></span>
                <span class="pcoded-mtext"><?php echo e(trans_choice('module_download', 2)); ?></span>
            </a>
        </li>
        <?php endif; ?>

        <?php if(($panel = panel('panel_transcript')) && $panel->status == 1): ?>
        <li class="nav-item <?php echo e(Request::is('student/transcript*') ? 'active' : ''); ?>">
            <a href="<?php echo e(route('student.transcript.index')); ?>" class="nav-link">
                <span class="pcoded-micon"><i class="fas fa-pen-square"></i></span>
                <span class="pcoded-mtext"><?php echo e(trans_choice('module_transcript', 1)); ?></span>
            </a>
        </li>
        <?php endif; ?>

        <?php if(($panel = panel('panel_profile')) && $panel->status == 1): ?>
        <li class="nav-item <?php echo e(Request::is('student/profile*') ? 'active' : ''); ?>">
            <a href="<?php echo e(route('student.profile.index')); ?>" class="nav-link">
                <span class="pcoded-micon"><i class="fas fa-id-card"></i></span>
                <span class="pcoded-mtext"><?php echo e(trans_choice('module_profile', 2)); ?></span>
            </a>
        </li>
        <?php endif; ?>

    </ul>
</div>
<!-- End Sidebar --><?php /**PATH C:\wamp64\www\Dapin-CMS-main\resources\views/student/layouts/inc/sidebar.blade.php ENDPATH**/ ?>