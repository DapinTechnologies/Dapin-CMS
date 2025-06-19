<!-- Sidemenu -->
<div class="navbar-content scroll-div ps ps--active-y">
    <ul class="nav pcoded-inner-navbar">

        <li class="nav-item <?php echo e(Request::is('admin/dashboard*') ? 'active' : ''); ?>">
            <a href="<?php echo e(route('admin.dashboard.index')); ?>" class="nav-link">
                <span class="pcoded-micon"><i class="fas fa-home"></i></span>
                <span class="pcoded-mtext"><?php echo e(trans_choice('module_dashboard', 1)); ?></span>
            </a>
        </li>

        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['application-create', 'application-view', 'student-create', 'student-view', 'student-import', 'student-password-print', 'student-password-change', 'student-card', 'student-transfer-in-create', 'student-transfer-in-view', 'student-transfer-out-create', 'student-transfer-out-view', 'status-type-create', 'status-type-view', 'id-card-setting-view'])): ?>
        <li class="nav-item pcoded-hasmenu <?php echo e(Request::is('admin/admission*') ? 'pcoded-trigger active' : ''); ?>">
            <a href="#!" class="nav-link">
                <span class="pcoded-micon"><i class="fas fa-university"></i></span>
                <span class="pcoded-mtext"><?php echo e(trans_choice('module_admission', 2)); ?></span>
            </a>
            <ul class="pcoded-submenu">
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['application-create', 'application-view'])): ?>
                <li class="<?php echo e(Request::is('admin/admission/application*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.application.index')); ?>" class=""><?php echo e(trans_choice('module_application', 2)); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['student-create'])): ?>
                <li class="<?php echo e(Request::is('admin/admission/student/create') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.student.create')); ?>" class=""><?php echo e(trans_choice('module_registration', 1)); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['student-view', 'student-password-print', 'student-password-change', 'student-card', 'student-import'])): ?>
                <li class="<?php echo e(Request::is('admin/admission/student') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.student.index')); ?>" class=""><?php echo e(trans_choice('module_student', 1)); ?> <?php echo e(__('list')); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['student-transfer-in-create', 'student-transfer-in-view', 'student-transfer-out-create', 'student-transfer-out-view'])): ?>
                <li class="nav-item pcoded-hasmenu <?php echo e(Request::is('admin/admission/student-transfer*') ? 'pcoded-trigger active' : ''); ?>">
                    <a href="#!" class="nav-link">
                        <span class="pcoded-mtext"><?php echo e(trans_choice('module_student_transfer', 2)); ?></span>
                    </a>

                    <ul class="pcoded-submenu">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['student-transfer-in-create', 'student-transfer-in-view'])): ?>
                        <li class="<?php echo e(Request::is('admin/admission/student-transfer-in*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.student-transfer-in.index')); ?>" class=""><?php echo e(trans_choice('module_transfer_in', 1)); ?></a></li>
                        <?php endif; ?>

                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['student-transfer-out-create', 'student-transfer-out-view'])): ?>
                        <li class="<?php echo e(Request::is('admin/admission/student-transfer-out*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.student-transfer-out.index')); ?>" class=""><?php echo e(trans_choice('module_transfer_out', 1)); ?></a></li>
                        <?php endif; ?>
                    </ul>
                </li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['status-type-create', 'status-type-view'])): ?>
                <li class="<?php echo e(Request::is('admin/admission/status-type*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.status-type.index')); ?>" class=""><?php echo e(trans_choice('module_status_type', 2)); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['student-card'])): ?>
                <li class="<?php echo e(Request::is('admin/admission/id-card') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.id-card.index')); ?>" class=""><?php echo e(trans_choice('module_id_card', 2)); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['id-card-setting-view'])): ?>
                <li class="nav-item pcoded-hasmenu <?php echo e(Request::is('admin/admission/id-card-setting*') ? 'pcoded-trigger active' : ''); ?>">
                    <a href="#!" class="nav-link">
                        <span class="pcoded-mtext"><?php echo e(trans_choice('module_setting', 2)); ?></span>
                    </a>

                    <ul class="pcoded-submenu">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('id-card-setting-view')): ?>
                        <li class="<?php echo e(Request::is('admin/admission/id-card-setting*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.id-card-setting.index')); ?>" class=""><?php echo e(trans_choice('module_id_card_setting', 1)); ?></a></li>
                        <?php endif; ?>
                    </ul>
                </li>
                <?php endif; ?>
            </ul>
        </li>
        <?php endif; ?>

        <!--------START OF SMS MANAGEMENT---------->

<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['sms-view', 'sms-send','sms-balance'])): ?>
<li class="nav-item pcoded-hasmenu <?php echo e(Request::is('/sms*') ? 'pcoded-trigger active' : ''); ?>">
    <a href="#!" class="nav-link">
        <span class="pcoded-micon"><i class="fas fa-envelope"></i></span>
        <span class="pcoded-mtext">SMS Management</span>
    </a>
    <ul class="pcoded-submenu">
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('sms-view')): ?>
        <li class="<?php echo e(Request::is('/sms') ? 'active' : ''); ?>">
            <a href="<?php echo e(route('sms.index')); ?>"><?php echo e(__('View SMS Logs')); ?></a>
        </li>
        <?php endif; ?>

        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('sms-send')): ?>
        <li class="<?php echo e(Request::is('/sms/create') ? 'active' : ''); ?>">
            <a href="<?php echo e(route('sms.create')); ?>"><?php echo e(__('Send New SMS')); ?></a>
        </li>
        <?php endif; ?>
    </ul>
</li>
<?php endif; ?>

<!--------END OF SMS MANAGEMENT---------->

        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['student-attendance-action', 'student-attendance-report', 'student-leave-manage-view', 'student-leave-manage-edit', 'student-note-create', 'student-note-view', 'student-enroll-single', 'student-enroll-group', 'student-enroll-adddrop', 'student-enroll-complete', 'student-enroll-alumni'])): ?>
        <li class="nav-item pcoded-hasmenu <?php echo e(Request::is('admin/student*') ? 'pcoded-trigger active' : ''); ?>">
            <a href="#!" class="nav-link">
                <span class="pcoded-micon"><i class="fas fa-user-graduate"></i></span>
                <span class="pcoded-mtext"><?php echo e(trans_choice('module_student', 2)); ?></span>
            </a>
            <ul class="pcoded-submenu">

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['student-attendance-action', 'student-attendance-report'])): ?>
                <li class="nav-item pcoded-hasmenu <?php echo e(Request::is('admin/student-attendance*') ? 'pcoded-trigger active' : ''); ?>">
                    <a href="#!" class="nav-link">
                        <span class="pcoded-mtext"><?php echo e(trans_choice('module_attendance', 2)); ?></span>
                    </a>

                    <ul class="pcoded-submenu">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('student-attendance-action')): ?>
                        <li class="<?php echo e(Request::is('admin/student-attendance') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.student-attendance.index')); ?>" class=""><?php echo e(trans_choice('module_student_subject_attendance', 2)); ?></a></li>
                        <?php endif; ?>

                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('student-attendance-report')): ?>
                        <li class="<?php echo e(Request::is('admin/student-attendance-report*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.student-attendance.report')); ?>" class=""><?php echo e(trans_choice('module_student_subject_report', 2)); ?></a></li>
                        <?php endif; ?>
                    </ul>
                </li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['student-leave-manage-view', 'student-leave-manage-edit'])): ?>
                <li class="<?php echo e(Request::is('admin/student-leave-manage*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.student-leave-manage.index')); ?>" class=""><?php echo e(trans_choice('module_leave_manage', 1)); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['student-note-create', 'student-note-view'])): ?>
                <li class="<?php echo e(Request::is('admin/student/student-note*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.student-note.index')); ?>" class=""><?php echo e(trans_choice('module_student_note', 2)); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['student-enroll-single', 'student-enroll-group', 'student-enroll-adddrop', 'student-enroll-complete'])): ?>
                <li class="nav-item pcoded-hasmenu <?php echo e(Request::is('admin/student/single-enroll*') ? 'pcoded-trigger active' : ''); ?> <?php echo e(Request::is('admin/student/group-enroll*') ? 'pcoded-trigger active' : ''); ?> <?php echo e(Request::is('admin/student/subject-adddrop*') ? 'pcoded-trigger active' : ''); ?> <?php echo e(Request::is('admin/student/course-complete*') ? 'pcoded-trigger active' : ''); ?>">
                    <a href="#!" class="nav-link">
                        <span class="pcoded-mtext"><?php echo e(trans_choice('module_student_enroll', 2)); ?></span>
                    </a>

                    <ul class="pcoded-submenu">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['student-enroll-single'])): ?>
                        <li class="<?php echo e(Request::is('admin/student/single-enroll*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.single-enroll.index')); ?>" class=""><?php echo e(trans_choice('module_single_enroll', 1)); ?></a></li>
                        <?php endif; ?>

                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['student-enroll-group'])): ?>
                        <li class="<?php echo e(Request::is('admin/student/group-enroll*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.group-enroll.index')); ?>" class=""><?php echo e(trans_choice('module_group_enroll', 2)); ?></a></li>
                        <?php endif; ?>

                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['student-enroll-adddrop'])): ?>
                        <li class="<?php echo e(Request::is('admin/student/subject-adddrop*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.subject-adddrop.index')); ?>" class=""><?php echo e(trans_choice('module_subject_adddrop', 2)); ?></a></li>
                        <?php endif; ?>

                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['student-enroll-complete'])): ?>
                        <li class="<?php echo e(Request::is('admin/student/course-complete*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.course-complete.index')); ?>" class=""><?php echo e(trans_choice('module_course_complete', 2)); ?></a></li>
                        <?php endif; ?>
                    </ul>
                </li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['student-enroll-alumni'])): ?>
                <li class="<?php echo e(Request::is('admin/student/student-alumni*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.student-alumni.index')); ?>" class=""><?php echo e(trans_choice('module_student_alumni', 1)); ?> <?php echo e(__('list')); ?></a></li>
                <?php endif; ?>
            </ul>
        </li>
        <?php endif; ?>

        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['faculty-create', 'faculty-view', 'program-create', 'program-view', 'batch-create', 'batch-view', 'session-create', 'session-view', 'semester-create', 'semester-view', 'section-create', 'section-view', 'class-room-create', 'class-room-view', 'subject-create', 'subject-view', 'enroll-subject-create', 'enroll-subject-view'])): ?>
        <li class="nav-item pcoded-hasmenu <?php echo e(Request::is('admin/academic*') ? 'pcoded-trigger active' : ''); ?>">
            <a href="#!" class="nav-link">
                <span class="pcoded-micon"><i class="fab fa-accusoft"></i></span>
                <span class="pcoded-mtext"><?php echo e(trans_choice('module_academic', 2)); ?></span>
            </a>
            <ul class="pcoded-submenu">
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['faculty-create', 'faculty-view'])): ?>
                <li class="<?php echo e(Request::is('admin/academic/faculty*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.faculty.index')); ?>" class=""><?php echo e(trans_choice('module_faculty', 2)); ?></a></li>
                <?php endif; ?>
                
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['program-create', 'program-view'])): ?>
                <li class="<?php echo e(Request::is('admin/academic/program*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.program.index')); ?>" class=""><?php echo e(trans_choice('module_program', 2)); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['batch-create', 'batch-view'])): ?>
                <li class="<?php echo e(Request::is('admin/academic/batch*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.batch.index')); ?>" class=""><?php echo e(trans_choice('module_batch', 2)); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['session-create', 'session-view'])): ?>
                <li class="<?php echo e(Request::is('admin/academic/session*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.session.index')); ?>" class=""><?php echo e(trans_choice('module_session', 2)); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['semester-create', 'semester-view'])): ?>
                <li class="<?php echo e(Request::is('admin/academic/semester*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.semester.index')); ?>" class=""><?php echo e(trans_choice('module_semester', 2)); ?></a></li>
                <?php endif; ?>
                
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['section-create', 'section-view'])): ?>
                <li class="<?php echo e(Request::is('admin/academic/section*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.section.index')); ?>" class=""><?php echo e(trans_choice('module_section', 2)); ?></a></li>
                <?php endif; ?>
                
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['class-room-create', 'class-room-view'])): ?>
                <li class="<?php echo e(Request::is('admin/academic/room*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.room.index')); ?>" class=""><?php echo e(trans_choice('module_class_room', 2)); ?></a></li>
                <?php endif; ?>
                
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['subject-create', 'subject-view'])): ?>
                <li class="<?php echo e(Request::is('admin/academic/subject*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.subject.index')); ?>" class=""><?php echo e(trans_choice('module_subject', 2)); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['enroll-subject-create', 'enroll-subject-view'])): ?>
                <li class="<?php echo e(Request::is('admin/academic/enroll-subject*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.enroll-subject.index')); ?>" class=""><?php echo e(trans_choice('module_enroll_subject', 2)); ?></a></li>
                <?php endif; ?>
            </ul>
        </li>
        <?php endif; ?>

        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['class-routine-create', 'class-routine-view', 'class-routine-print', 'exam-routine-create', 'exam-routine-view', 'exam-routine-print', 'class-routine-teacher', 'routine-setting-class', 'routine-setting-exam'])): ?>
        <li class="nav-item pcoded-hasmenu <?php echo e(Request::is('admin/routine*') ? 'pcoded-trigger active' : ''); ?>">
            <a href="#!" class="nav-link">
                <span class="pcoded-micon"><i class="far fa-calendar-alt"></i></span>
                <span class="pcoded-mtext"><?php echo e(trans_choice('module_routine', 2)); ?></span>
            </a>
            <ul class="pcoded-submenu">
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['class-routine-create'])): ?>
                <li class="<?php echo e(Request::is('admin/routine/class-routine/create') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.class-routine.create')); ?>" class=""><?php echo e(trans_choice('module_manage_class', 2)); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['class-routine-view', 'class-routine-print'])): ?>
                <li class="<?php echo e(Request::is('admin/routine/class-routine') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.class-routine.index')); ?>" class=""><?php echo e(trans_choice('module_class_routine', 2)); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['exam-routine-create'])): ?>
                <li class="<?php echo e(Request::is('admin/routine/exam-routine/create') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.exam-routine.create')); ?>" class=""><?php echo e(trans_choice('module_manage_exam', 2)); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['exam-routine-view', 'exam-routine-print'])): ?>
                <li class="<?php echo e(Request::is('admin/routine/exam-routine') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.exam-routine.index')); ?>" class=""><?php echo e(trans_choice('module_exam_routine', 2)); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('class-routine-teacher')): ?>
                <li class="<?php echo e(Request::is('admin/routine/class-routine-teacher') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.class-routine.teacher')); ?>" class=""><?php echo e(trans_choice('module_teacher_routine', 2)); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['routine-setting-class', 'routine-setting-exam'])): ?>
                <li class="nav-item pcoded-hasmenu <?php echo e(Request::is('admin/routine/routine-setting*') ? 'pcoded-trigger active' : ''); ?>">
                    <a href="#!" class="nav-link">
                        <span class="pcoded-mtext"><?php echo e(trans_choice('module_setting', 2)); ?></span>
                    </a>

                    <ul class="pcoded-submenu">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('routine-setting-class')): ?>
                        <li class="<?php echo e(Request::is('admin/routine/routine-setting/class*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.routine-setting.class')); ?>" class=""><?php echo e(trans_choice('module_class_routine', 1)); ?></a></li>
                        <?php endif; ?>

                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('routine-setting-exam')): ?>
                        <li class="<?php echo e(Request::is('admin/routine/routine-setting/exam*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.routine-setting.exam')); ?>" class=""><?php echo e(trans_choice('module_exam_routine', 1)); ?></a></li>
                        <?php endif; ?>
                    </ul>
                </li>
                <?php endif; ?>
            </ul>
        </li>
        <?php endif; ?>

       <!-- Examination Module -->
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any([
    'exam-attendance', 'exam-marking', 'exam-result', 
    'subject-marking', 'subject-result', 'grade-view', 
    'grade-create', 'exam-type-view', 'exam-type-create', 
    'admit-card-view', 'admit-card-print', 'admit-card-download',
    'marksheet-view', 'marksheet-print', 'marksheet-download', 
    'marksheet-setting-view', 'certificate-view', 'certificate-create', 
    'certificate-print', 'certificate-download', 'certificate-template-view', 
    'certificate-template-create'
])): ?>
<li class="nav-item pcoded-hasmenu <?php echo e(Request::is('admin/exam*') ? 'pcoded-trigger active' : ''); ?>">
    <a href="#!" class="nav-link">
        <span class="pcoded-micon"><i class="fas fa-file-alt"></i></span>
        <span class="pcoded-mtext"><?php echo e(trans_choice('module_examination', 2)); ?></span>
    </a>
    <ul class="pcoded-submenu">
        <!-- Examination Items -->
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('exam-attendance')): ?>
        <li class="<?php echo e(Request::is('admin/exam/exam-attendance*') ? 'active' : ''); ?>">
            <a href="<?php echo e(route('admin.exam-attendance.index')); ?>"><?php echo e(trans_choice('module_exam_attendance', 2)); ?></a>
        </li>
        <?php endif; ?>

        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('exam-marking')): ?>
        <li class="<?php echo e(Request::is('admin/exam/exam-marking*') ? 'active' : ''); ?>">
            <a href="<?php echo e(route('admin.exam-marking.index')); ?>"><?php echo e(trans_choice('module_exam_marking', 2)); ?></a>
        </li>
        <?php endif; ?>

        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('exam-result')): ?>
        <li class="<?php echo e(Request::is('admin/exam/exam-result*') ? 'active' : ''); ?>">
            <a href="<?php echo e(route('admin.exam-result')); ?>"><?php echo e(trans_choice('module_exam_result', 2)); ?></a>
        </li>
        <?php endif; ?>

        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('subject-marking')): ?>
        <li class="<?php echo e(Request::is('admin/exam/subject-marking*') ? 'active' : ''); ?>">
            <a href="<?php echo e(route('admin.subject-marking.index')); ?>"><?php echo e(trans_choice('module_subject_marking', 2)); ?></a>
        </li>
        <?php endif; ?>

        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('subject-result')): ?>
        <li class="<?php echo e(Request::is('admin/exam/subject-result*') ? 'active' : ''); ?>">
            <a href="<?php echo e(route('admin.subject-result')); ?>"><?php echo e(trans_choice('module_subject_result', 2)); ?></a>
        </li>
        <?php endif; ?>

        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['grade-view', 'grade-create'])): ?>
        <li class="<?php echo e(Request::is('admin/exam/grade*') ? 'active' : ''); ?>">
            <a href="<?php echo e(route('admin.grade.index')); ?>"><?php echo e(trans_choice('module_grade', 2)); ?></a>
        </li>
        <?php endif; ?>

        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['exam-type-view', 'exam-type-create'])): ?>
        <li class="<?php echo e(Request::is('admin/exam/exam-type*') ? 'active' : ''); ?>">
            <a href="<?php echo e(route('admin.exam-type.index')); ?>"><?php echo e(trans_choice('module_exam_type', 2)); ?></a>
        </li>
        <?php endif; ?>

        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['admit-card-view', 'admit-card-print', 'admit-card-download'])): ?>
        <li class="<?php echo e(Request::is('admin/exam/admit-card*') ? 'active' : ''); ?>">
            <a href="<?php echo e(route('admin.admit-card.index')); ?>"><?php echo e(trans_choice('module_admit_card', 2)); ?></a>
        </li>
        <?php endif; ?>

       

        <!-- Transcript Submenu -->
        <li class="nav-item pcoded-hasmenu <?php echo e(Request::is('admin/exam/transcript*') ? 'pcoded-trigger active' : ''); ?>">
            <a href="#!" class="nav-link">
                <span class="pcoded-mtext"><?php echo e(trans_choice('module_transcript', 2)); ?></span>
            </a>
            <ul class="pcoded-submenu">
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['marksheet-view', 'marksheet-print', 'marksheet-download'])): ?>
                <li class="<?php echo e(Request::is('admin/exam/transcript/marksheet-semester*') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('admin.marksheet.semester')); ?>"><?php echo e(trans_choice('module_marksheet_semester', 2)); ?></a>
                </li>
                <?php endif; ?>
                
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['marksheet-view', 'marksheet-print', 'marksheet-download'])): ?>
                <li class="<?php echo e(Request::is('admin/exam/transcript/marksheet') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('admin.marksheet.index')); ?>"><?php echo e(trans_choice('module_marksheet_total', 2)); ?></a>
                </li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['marksheet-setting-view'])): ?>
                <li class="<?php echo e(Request::is('admin/exam/transcript/marksheet-setting*') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('admin.marksheet-setting.index')); ?>"><?php echo e(trans_choice('module_marksheet_setting', 1)); ?></a>
                </li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['certificate-view', 'certificate-create', 'certificate-print', 'certificate-download'])): ?>
                <li class="<?php echo e(Request::is('admin/exam/transcript/certificate*') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('admin.certificate.index')); ?>"><?php echo e(trans_choice('module_certificate', 2)); ?></a>
                </li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['certificate-template-view', 'certificate-template-create'])): ?>
                <li class="<?php echo e(Request::is('admin/exam/transcript/certificate-template*') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('admin.certificate-template.index')); ?>"><?php echo e(trans_choice('module_certificate_template', 2)); ?></a>
                </li>
                <?php endif; ?>
            </ul>
        </li>

   <!-- Exam Reports Main Menu -->
 <li class="nav-item pcoded-hasmenu <?php echo e(Request::is('admin/exam*') ? 'pcoded-trigger active' : ''); ?>">
            <a href="#!" class="nav-link">
                <span class="pcoded-mtext">Exam Reports</span>
            </a>
            <ul class="pcoded-submenu">

             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('exam-result')): ?>
        <li class="<?php echo e(Request::is('admin/dashboard-repo*') ? 'active' : ''); ?>">
            <a href="<?php echo e(route('admin.dashboard-repo.index')); ?>">Exam Dashboard</a>
        </li>
        <?php endif; ?>
        
               <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['exam-routine-repo-index'])): ?>
    <li class="<?php echo e(Request::is('admin/exam/exam-routine-repo') ? 'active' : ''); ?>">
        <a href="<?php echo e(route('admin.exam-routine-repo.index')); ?>">All Exam Timetables</a>
    </li>
<?php endif; ?>


 <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('exam-attendance')): ?>
        <li class="<?php echo e(Request::is('admin/exam-attendance-repo*') ? 'active' : ''); ?>">
            <a href="<?php echo e(route('admin.attendance-repo.index')); ?>">All Exam Attendance</a>
        </li>
        <?php endif; ?>

         <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('result-repo')): ?>
        <li class="<?php echo e(Request::is('admin/result-repo*') ? 'active' : ''); ?>">
            <a href="<?php echo e(route('admin.result-repo.index')); ?>">Individual Exam Result</a>
        </li>
        <?php endif; ?>

         <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('exam-teacher-repo')): ?>
        <li class="<?php echo e(Request::is('admin/exam-teacher-repo*') ? 'active' : ''); ?>">
            <a href="<?php echo e(route('admin.exam-teacher-repo.index')); ?>">Invigilation Schedule</a>
        </li>
        <?php endif; ?>

        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Class Summary')): ?>
        <li class="<?php echo e(Request::is('admin/exam/subject-repo*') ? 'active' : ''); ?>">
            <a href="<?php echo e(route('admin.subject-repo.index')); ?>">Class Summary</a>
        </li>
        <?php endif; ?>

        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('result2-repo')): ?>
        <li class="<?php echo e(Request::is('admin/result2-repo*') ? 'active' : ''); ?>">
            <a href="<?php echo e(route('admin.result2-repo.index')); ?>">Top Perfomers</a>
        </li>
        <?php endif; ?>

        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('teacher-report')): ?>
        <li class="<?php echo e(Request::is('admin/teacher-report*') ? 'active' : ''); ?>">
            <a href="<?php echo e(route('admin.teacher-report.index')); ?>">Trainer Performance</a>
        </li>
        <?php endif; ?>

        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('department-repo')): ?>
        <li class="<?php echo e(Request::is('admin/department-repo*') ? 'active' : ''); ?>">
            <a href="<?php echo e(route('admin.department-repo.index')); ?>">Department Summary</a>
        </li>
        <?php endif; ?>

         <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('exam-result')): ?>
        <li class="<?php echo e(Request::is('admin/result3-repo*') ? 'active' : ''); ?>">
            <a href="<?php echo e(route('admin.result3-repo.index')); ?>">Performance trends</a>
        </li>
        <?php endif; ?>

       
               
            </ul>
        </li>

        
 <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['admit-setting-view', 'result-contribution-view'])): ?>
                <li class="nav-item pcoded-hasmenu <?php echo e(Request::is('admin/exam/admit-setting*') ? 'pcoded-trigger active' : ''); ?> <?php echo e(Request::is('admin/exam/result-contribution*') ? 'pcoded-trigger active' : ''); ?>">
                    <a href="#!" class="nav-link">
                        <span class="pcoded-mtext"><?php echo e(trans_choice('module_setting', 2)); ?></span>
                    </a>

                    <ul class="pcoded-submenu">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('admit-setting-view')): ?>
                        <li class="<?php echo e(Request::is('admin/exam/admit-setting*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.admit-setting.index')); ?>" class=""><?php echo e(trans_choice('module_admit_setting', 1)); ?></a></li>
                        <?php endif; ?>

                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('result-contribution-view')): ?>
                        <li class="<?php echo e(Request::is('admin/exam/result-contribution*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.result-contribution.index')); ?>" class=""><?php echo e(trans_choice('module_result_contribution', 2)); ?></a></li>
                        <?php endif; ?>
                    </ul>
                </li>
                <?php endif; ?>

    </ul>
</li>
<?php endif; ?>

 <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['assignment-create', 'assignment-view', 'assignment-marking', 'content-create', 'content-view', 'content-type-view', 'content-type-create'])): ?>
        <li class="nav-item pcoded-hasmenu <?php echo e(Request::is('admin/download*') ? 'pcoded-trigger active' : ''); ?>">
            <a href="#!" class="nav-link">
                <span class="pcoded-micon"><i class="fas fa-newspaper"></i></span>
                <span class="pcoded-mtext"><?php echo e(trans_choice('module_study_material', 2)); ?></span>
            </a>
            <ul class="pcoded-submenu">
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['assignment-create', 'assignment-view', 'assignment-marking'])): ?>
                <li class="<?php echo e(Request::is('admin/download/assignment*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.assignment.index')); ?>" class=""><?php echo e(trans_choice('module_assignment', 2)); ?></a></li>
                <?php endif; ?>
                
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['content-create', 'content-view'])): ?>
                <li class="<?php echo e(Request::is('admin/download/content*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.content.index')); ?>" class=""><?php echo e(trans_choice('module_content', 1)); ?> <?php echo e(__('list')); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['content-type-view', 'content-type-create'])): ?>
                <li class="<?php echo e(Request::is('admin/download/content-type*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.content-type.index')); ?>" class=""><?php echo e(trans_choice('module_content_type', 2)); ?></a></li>
                <?php endif; ?>
            </ul>
        </li>
        <?php endif; ?>

        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['fees-student-due', 'fees-student-quick-assign', 'fees-student-quick-received', 'fees-student-report', 'fees-student-print', 'fees-master-view', 'fees-master-create', 'fees-category-view', 'fees-category-create', 'fees-discount-view', 'fees-discount-create', 'fees-fine-view', 'fees-fine-create', 'fees-receipt-view'])): ?>
        <li class="nav-item pcoded-hasmenu <?php echo e(Request::is('admin/fees*') ? 'pcoded-trigger active' : ''); ?>">
            <a href="#!" class="nav-link">
                <span class="pcoded-micon"><i class="fas fa-money-bill-wave"></i></span>
                <span class="pcoded-mtext"><?php echo e(trans_choice('module_fees_collection', 1)); ?></span>
            </a>
            <ul class="pcoded-submenu">
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['fees-student-due', 'fees-student-quick-assign', 'fees-student-quick-received', 'fees-student-report', 'fees-student-print'])): ?>
                <li class="nav-item pcoded-hasmenu <?php echo e(Request::is('admin/fees-student*') ? 'pcoded-trigger active' : ''); ?>">
                    <a href="#!" class="nav-link">
                        <span class="pcoded-mtext"><?php echo e(trans_choice('module_student_fees', 2)); ?></span>
                    </a>

                    <ul class="pcoded-submenu">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('fees-student-due')): ?>
                        <li class="<?php echo e(Request::is('admin/fees-student') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.fees-student.index')); ?>" class=""><?php echo e(trans_choice('module_fees_due', 1)); ?></a></li>
                        <?php endif; ?>

                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('fees-student-quick-assign')): ?>
                        <li class="<?php echo e(Request::is('admin/fees-student-quick-assign*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.fees-student.quick.assign')); ?>" class=""><?php echo e(trans_choice('module_fees_quick_assign', 1)); ?></a></li>
                        <?php endif; ?>

                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('fees-student-quick-received')): ?>
                        <li class="<?php echo e(Request::is('admin/fees-student-quick-received*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.fees-student.quick.received')); ?>" class=""><?php echo e(trans_choice('module_fees_quick_received', 1)); ?></a></li>
                        <?php endif; ?>

                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['fees-student-report', 'fees-student-print'])): ?>
                        <li class="<?php echo e(Request::is('admin/fees-student-report*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.fees-student.report')); ?>" class=""><?php echo e(trans_choice('module_fees_report', 2)); ?></a></li>
                        <?php endif; ?>
                    </ul>
                </li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['fees-master-create'])): ?>
                <li class="<?php echo e(Request::is('admin/fees-master/create*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.fees-master.create')); ?>" class=""><?php echo e(trans_choice('module_fees_master', 2)); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['fees-master-view'])): ?>
                <li class="<?php echo e(Request::is('admin/fees-master') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.fees-master.index')); ?>" class=""><?php echo e(trans_choice('module_fees_master_history', 2)); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['fees-category-view', 'fees-category-create'])): ?>
                <li class="<?php echo e(Request::is('admin/fees-category*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.fees-category.index')); ?>" class=""><?php echo e(trans_choice('module_fees_category', 2)); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['fees-discount-view', 'fees-discount-create'])): ?>
                <li class="<?php echo e(Request::is('admin/fees-discount*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.fees-discount.index')); ?>" class=""><?php echo e(trans_choice('module_fees_discount', 2)); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['fees-fine-view', 'fees-fine-create'])): ?>
                <li class="<?php echo e(Request::is('admin/fees-fine*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.fees-fine.index')); ?>" class=""><?php echo e(trans_choice('module_fees_fine', 2)); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['fees-fine-view', 'fees-fine-create', 'fees-receipt-view'])): ?>
                <li class="nav-item pcoded-hasmenu <?php echo e(Request::is('admin/fees-receipt*') ? 'pcoded-trigger active' : ''); ?>">
                    <a href="#!" class="nav-link">
                        <span class="pcoded-mtext"><?php echo e(trans_choice('module_setting', 2)); ?></span>
                    </a>

                    <ul class="pcoded-submenu">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('fees-receipt-view')): ?>
                        <li class="<?php echo e(Request::is('admin/fees-receipt*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.fees-receipt.index')); ?>" class=""><?php echo e(trans_choice('module_fees_receipt_setting', 1)); ?></a></li>
                        <?php endif; ?>
                    </ul>
                </li>
                <?php endif; ?>
            </ul>
        </li>
        <?php endif; ?>

        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['user-create', 'user-view', 'user-password-print', 'user-password-change', 'staff-note-create', 'staff-note-view', 'payroll-view', 'payroll-action', 'payroll-print', 'payroll-report', 'work-shift-type-create', 'work-shift-type-view', 'designation-create', 'designation-view', 'department-create', 'department-view', 'tax-setting-create', 'tax-setting-view', 'pay-slip-setting-view'])): ?>
        <li class="nav-item pcoded-hasmenu <?php echo e(Request::is('admin/staff*') ? 'pcoded-trigger active' : ''); ?>">
            <a href="#!" class="nav-link">
                <span class="pcoded-micon"><i class="fas fa-users-cog"></i></span>
                <span class="pcoded-mtext"><?php echo e(trans_choice('module_human_resource', 2)); ?></span>
            </a>
            <ul class="pcoded-submenu">
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['user-create', 'user-view', 'user-password-print', 'user-password-change',])): ?>
                <li class="<?php echo e(Request::is('admin/staff/user*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.user.index')); ?>" class=""><?php echo e(trans_choice('module_staff', 1)); ?> <?php echo e(__('list')); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['staff-note-create', 'staff-note-view'])): ?>
                <li class="<?php echo e(Request::is('admin/staff/staff-note*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.staff-note.index')); ?>" class=""><?php echo e(trans_choice('module_staff_note', 2)); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['payroll-view', 'payroll-action', 'payroll-print'])): ?>
                <li class="<?php echo e(Request::is('admin/staff/payroll') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.payroll.index')); ?>" class=""><?php echo e(trans_choice('module_payroll', 2)); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['payroll-report'])): ?>
                <li class="<?php echo e(Request::is('admin/staff/payroll-report*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.payroll.report')); ?>" class=""><?php echo e(trans_choice('module_payroll_report', 2)); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['work-shift-type-create', 'work-shift-type-view'])): ?>
                <li class="<?php echo e(Request::is('admin/staff/work-shift-type*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.work-shift-type.index')); ?>" class=""><?php echo e(trans_choice('module_work_shift_type', 2)); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['designation-create', 'designation-view'])): ?>
                <li class="<?php echo e(Request::is('admin/staff/designation*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.designation.index')); ?>" class=""><?php echo e(trans_choice('module_designation', 2)); ?></a></li>
                <?php endif; ?>
                
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['department-create', 'department-view'])): ?>
                <li class="<?php echo e(Request::is('admin/staff/department*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.department.index')); ?>" class=""><?php echo e(trans_choice('module_department', 2)); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['tax-setting-create', 'tax-setting-view', 'pay-slip-setting-view'])): ?>
                <li class="nav-item pcoded-hasmenu <?php echo e(Request::is('admin/staff/tax-setting*') ? 'pcoded-trigger active' : ''); ?> <?php echo e(Request::is('admin/staff/pay-slip-setting*') ? 'pcoded-trigger active' : ''); ?>">
                    <a href="#!" class="nav-link">
                        <span class="pcoded-mtext"><?php echo e(trans_choice('module_setting', 2)); ?></span>
                    </a>

                    <ul class="pcoded-submenu">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['tax-setting-create', 'tax-setting-view'])): ?>
                        <li class="<?php echo e(Request::is('admin/staff/tax-setting*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.tax-setting.index')); ?>" class=""><?php echo e(trans_choice('module_tax_setting', 2)); ?></a></li>
                        <?php endif; ?>

                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('pay-slip-setting-view')): ?>
                        <li class="<?php echo e(Request::is('admin/staff/pay-slip-setting*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.pay-slip-setting.index')); ?>" class=""><?php echo e(trans_choice('module_pay_slip_setting', 1)); ?></a></li>
                        <?php endif; ?>
                    </ul>
                </li>
                <?php endif; ?>
            </ul>
        </li>
        <?php endif; ?>

        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['staff-daily-attendance-action', 'staff-daily-attendance-report', 'staff-hourly-attendance-action', 'staff-hourly-attendance-report'])): ?>
        <li class="nav-item pcoded-hasmenu <?php echo e(Request::is('admin/attendance*') ? 'pcoded-trigger active' : ''); ?>">
            <a href="#!" class="nav-link">
                <span class="pcoded-micon"><i class="fas fa-calendar-check"></i></span>
                <span class="pcoded-mtext"><?php echo e(trans_choice('module_staff_attendance', 2)); ?></span>
            </a>
            <ul class="pcoded-submenu">
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('staff-daily-attendance-action')): ?>
                <li class="<?php echo e(Request::is('admin/attendance/staff-daily-attendance*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.staff-daily-attendance.index')); ?>" class=""><?php echo e(trans_choice('module_staff_daily_attendance', 2)); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('staff-daily-attendance-report')): ?>
                <li class="<?php echo e(Request::is('admin/attendance/staff-daily-report*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.staff-daily-attendance.report')); ?>" class=""><?php echo e(trans_choice('module_staff_daily_report', 2)); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('staff-hourly-attendance-action')): ?>
                <li class="<?php echo e(Request::is('admin/attendance/staff-hourly-attendance*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.staff-hourly-attendance.index')); ?>" class=""><?php echo e(trans_choice('module_staff_hourly_attendance', 2)); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('staff-hourly-attendance-report')): ?>
                <li class="<?php echo e(Request::is('admin/attendance/staff-hourly-report*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.staff-hourly-attendance.report')); ?>" class=""><?php echo e(trans_choice('module_staff_hourly_report', 2)); ?></a></li>
                <?php endif; ?>
            </ul>
        </li>
        <?php endif; ?>

        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['staff-leave-create', 'staff-leave-view', 'leave-type-create', 'leave-type-view', 'staff-leave-manage-edit', 'staff-leave-manage-view'])): ?>
        <li class="nav-item pcoded-hasmenu <?php echo e(Request::is('admin/leave*') ? 'pcoded-trigger active' : ''); ?>">
            <a href="#!" class="nav-link">
                <span class="pcoded-micon"><i class="fas fa-notes-medical"></i></span>
                <span class="pcoded-mtext"><?php echo e(trans_choice('module_leave_manager', 2)); ?></span>
            </a>
            <ul class="pcoded-submenu">
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['staff-leave-create'])): ?>
                <li class="<?php echo e(Request::is('admin/leave/staff-leave/create') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.staff-leave.create')); ?>" class=""><?php echo e(trans_choice('module_apply_leave', 1)); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['staff-leave-view'])): ?>
                <li class="<?php echo e(Request::is('admin/leave/staff-leave') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.staff-leave.index')); ?>" class=""><?php echo e(trans_choice('module_my_leave', 2)); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['leave-type-create', 'leave-type-view'])): ?>
                <li class="<?php echo e(Request::is('admin/leave/leave-type*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.leave-type.index')); ?>" class=""><?php echo e(trans_choice('module_leave_type', 2)); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['staff-leave-manage-edit', 'staff-leave-manage-view'])): ?>
                <li class="<?php echo e(Request::is('admin/leave/leave-manage*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.leave-manage.index')); ?>" class=""><?php echo e(trans_choice('module_leave_manage', 1)); ?></a></li>
                <?php endif; ?>
            </ul>
        </li>
        <?php endif; ?>

        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['income-create', 'income-view', 'income-category-create', 'income-category-view', 'expense-create', 'expense-view', 'expense-category-create', 'expense-category-view', 'outcome-view'])): ?>
        <li class="nav-item pcoded-hasmenu <?php echo e(Request::is('admin/account*') ? 'pcoded-trigger active' : ''); ?>">
            <a href="#!" class="nav-link">
                <span class="pcoded-micon"><i class="fas fa-credit-card"></i></span>
                <span class="pcoded-mtext"><?php echo e(trans_choice('module_income_expense', 2)); ?></span>
            </a>
            <ul class="pcoded-submenu">
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['income-create', 'income-view'])): ?>
                <li class="<?php echo e(Request::is('admin/account/income*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.income.index')); ?>" class=""><?php echo e(trans_choice('module_income', 1)); ?> <?php echo e(__('list')); ?></a></li>
                <?php endif; ?>
                
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['income-category-create', 'income-category-view'])): ?>
                <li class="<?php echo e(Request::is('admin/account/income-category*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.income-category.index')); ?>" class=""><?php echo e(trans_choice('module_income_category', 2)); ?></a></li>
                <?php endif; ?>
                
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['expense-create', 'expense-view'])): ?>
                <li class="<?php echo e(Request::is('admin/account/expense*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.expense.index')); ?>" class=""><?php echo e(trans_choice('module_expense', 1)); ?> <?php echo e(__('list')); ?></a></li>
                <?php endif; ?>
                
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['expense-category-create', 'expense-category-view'])): ?>
                <li class="<?php echo e(Request::is('admin/account/expense-category*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.expense-category.index')); ?>" class=""><?php echo e(trans_choice('module_expense_category', 2)); ?></a></li>
                <?php endif; ?>
                
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('outcome-view')): ?>
                <li class="<?php echo e(Request::is('admin/account/outcome*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.outcome.index')); ?>" class=""><?php echo e(trans_choice('module_outcome_calculation', 2)); ?></a></li>
                <?php endif; ?>
            </ul>
        </li>
        <?php endif; ?>

        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['email-notify-create', 'email-notify-view', 'sms-notify-create', 'sms-notify-view', 'event-create', 'event-view', 'event-calendar', 'notice-create', 'notice-view', 'notice-category-create', 'notice-category-view'])): ?>
        <li class="nav-item pcoded-hasmenu <?php echo e(Request::is('admin/communicate*') ? 'pcoded-trigger active' : ''); ?>">
            <a href="#!" class="nav-link">
                <span class="pcoded-micon"><i class="fas fa-bullhorn"></i></span>
                <span class="pcoded-mtext"><?php echo e(trans_choice('module_communicate', 2)); ?></span>
            </a>
            <ul class="pcoded-submenu">
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['email-notify-create', 'email-notify-view'])): ?>
                <li class="<?php echo e(Request::is('admin/communicate/email-notify*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.email-notify.index')); ?>" class=""><?php echo e(trans_choice('module_email_notify', 2)); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['sms-notify-create', 'sms-notify-view'])): ?>
                <li class="<?php echo e(Request::is('admin/communicate/sms-notify*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.sms-notify.index')); ?>" class=""><?php echo e(trans_choice('module_sms_notify', 2)); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['event-create', 'event-view'])): ?>
                <li class="<?php echo e(Request::is('admin/communicate/event') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.event.index')); ?>" class=""><?php echo e(trans_choice('module_event', 2)); ?> <?php echo e(__('list')); ?></a></li>
                <?php endif; ?>
                
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('event-calendar')): ?>
                <li class="<?php echo e(Request::is('admin/communicate/event-calendar') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.event.calendar')); ?>" class=""><?php echo e(trans_choice('module_calendar', 2)); ?></a></li>
                <?php endif; ?>
                
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['notice-create', 'notice-view'])): ?>
                <li class="<?php echo e(Request::is('admin/communicate/notice*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.notice.index')); ?>" class=""><?php echo e(trans_choice('module_notice', 1)); ?> <?php echo e(__('list')); ?></a></li>
                <?php endif; ?>
                
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any('notice-category-create', 'notice-category-view')): ?>
                <li class="<?php echo e(Request::is('admin/communicate/notice-category*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.notice-category.index')); ?>" class=""><?php echo e(trans_choice('module_notice_category', 2)); ?></a></li>
                <?php endif; ?>
            </ul>
        </li>
        <?php endif; ?>

        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['book-issue-action', 'book-issue-view', 'library-member-view', 'library-member-create', 'library-member-card', 'book-create', 'book-view', 'book-print', 'book-request-create', 'book-request-view', 'book-category-create', 'book-category-view', 'library-card-setting-view'])): ?>
        <li class="nav-item pcoded-hasmenu <?php echo e(Request::is('admin/library*') ? 'pcoded-trigger active' : ''); ?> <?php echo e(Request::is('admin/member/library*') ? 'pcoded-trigger active' : ''); ?>">
            <a href="#!" class="nav-link">
                <span class="pcoded-micon"><i class="fas fa-book-open"></i></span>
                <span class="pcoded-mtext"><?php echo e(trans_choice('module_library', 2)); ?></span>
            </a>
            <ul class="pcoded-submenu">
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['book-issue-action'])): ?>
                <li class="<?php echo e(Request::is('admin/library/issue-return/create') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.issue-return.create')); ?>" class=""><?php echo e(trans_choice('module_book_issue', 1)); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['book-issue-action', 'book-issue-view'])): ?>
                <li class="<?php echo e(Request::is('admin/library/issue-return') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.issue-return.index')); ?>" class=""><?php echo e(trans_choice('module_book_issue_return', 1)); ?></a></li>
                <?php endif; ?>

            

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['library-member-create', 'library-member-view', 'library-member-card'])): ?>
                <li class="nav-item pcoded-hasmenu <?php echo e(Request::is('admin/member/library*') ? 'pcoded-trigger active' : ''); ?>">
                    <a href="#!" class="nav-link">
                        <span class="pcoded-mtext"><?php echo e(trans_choice('module_member', 2)); ?></span>
                    </a>

                    <ul class="pcoded-submenu">
                        <li class="<?php echo e(Request::is('admin/member/library-student*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.library-student.index')); ?>" class=""><?php echo e(trans_choice('module_student', 1)); ?> <?php echo e(__('list')); ?></a></li>

                        <li class="<?php echo e(Request::is('admin/member/library-staff*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.library-staff.index')); ?>" class=""><?php echo e(trans_choice('module_staff', 1)); ?> <?php echo e(__('list')); ?></a></li>

                        <li class="<?php echo e(Request::is('admin/member/library-outsider*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.library-outsider.index')); ?>" class=""><?php echo e(trans_choice('module_outsider', 1)); ?> <?php echo e(__('list')); ?></a></li>
                    </ul>
                </li>
                <?php endif; ?>
                
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['book-create', 'book-view', 'book-print'])): ?>
                <li class="<?php echo e(Request::is('admin/library/book-list*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.book-list.index')); ?>" class=""><?php echo e(trans_choice('module_book', 1)); ?> <?php echo e(__('list')); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['book-request-create', 'book-request-view'])): ?>
                <li class="<?php echo e(Request::is('admin/library/book-request*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.book-request.index')); ?>" class=""><?php echo e(trans_choice('module_book_request', 2)); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['book-category-create', 'book-category-view'])): ?>
                <li class="<?php echo e(Request::is('admin/library/book-category*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.book-category.index')); ?>" class=""><?php echo e(trans_choice('module_book_category', 2)); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['library-card-setting-view'])): ?>
                <li class="nav-item pcoded-hasmenu <?php echo e(Request::is('admin/library-card-setting*') ? 'pcoded-trigger active' : ''); ?>">
                    <a href="#!" class="nav-link">
                        <span class="pcoded-mtext"><?php echo e(trans_choice('module_setting', 2)); ?></span>
                    </a>

                    <ul class="pcoded-submenu">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('library-card-setting-view')): ?>
                        <li class="<?php echo e(Request::is('admin/library-card-setting*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.library-card-setting.index')); ?>" class=""><?php echo e(trans_choice('module_library_card_setting', 1)); ?></a></li>
                        <?php endif; ?>
                    </ul>
                </li>
                <?php endif; ?>


                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['book-issue-action'])): ?>
                <li class="<?php echo e(Request::is('digital/book/') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('alldigitalbooks')); ?>" class=""><?php echo e(__('Digital Books')); ?></a>
                </li>
            <?php endif; ?>


            </ul>
        </li>
        <?php endif; ?>

        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['item-issue-action', 'item-issue-view', 'item-stock-create', 'item-stock-view', 'item-create', 'item-view', 'item-store-create', 'item-store-view', 'item-supplier-create', 'item-supplier-view', 'item-category-create', 'item-category-view'])): ?>
        <li class="nav-item pcoded-hasmenu <?php echo e(Request::is('admin/inventory*') ? 'pcoded-trigger active' : ''); ?>">
            <a href="#!" class="nav-link">
                <span class="pcoded-micon"><i class="fas fa-dolly-flatbed"></i></span>
                <span class="pcoded-mtext"><?php echo e(trans_choice('module_inventory', 2)); ?></span>
            </a>
            <ul class="pcoded-submenu">
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['item-issue-action'])): ?>
                <li class="<?php echo e(Request::is('admin/inventory/item-issue/create') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.item-issue.create')); ?>" class=""><?php echo e(trans_choice('module_item_issue', 1)); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['item-issue-action', 'item-issue-view'])): ?>
                <li class="<?php echo e(Request::is('admin/inventory/item-issue') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.item-issue.index')); ?>" class=""><?php echo e(trans_choice('module_item_issue_return', 1)); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['item-stock-create', 'item-stock-view'])): ?>
                <li class="<?php echo e(Request::is('admin/inventory/item-stock*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.item-stock.index')); ?>" class=""><?php echo e(trans_choice('module_item_stock', 2)); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['item-create', 'item-view'])): ?>
                <li class="<?php echo e(Request::is('admin/inventory/item-list*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.item-list.index')); ?>" class=""><?php echo e(trans_choice('module_item', 1)); ?> <?php echo e(__('list')); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['item-store-create', 'item-store-view'])): ?>
                <li class="<?php echo e(Request::is('admin/inventory/item-store*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.item-store.index')); ?>" class=""><?php echo e(trans_choice('module_item_store', 2)); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['item-supplier-create', 'item-supplier-view'])): ?>
                <li class="<?php echo e(Request::is('admin/inventory/item-supplier*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.item-supplier.index')); ?>" class=""><?php echo e(trans_choice('module_item_supplier', 2)); ?></a></li>
                <?php endif; ?>
                
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['item-category-create', 'item-category-view'])): ?>
                <li class="<?php echo e(Request::is('admin/inventory/item-category*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.item-category.index')); ?>" class=""><?php echo e(trans_choice('module_item_category', 2)); ?></a></li>
                <?php endif; ?>
            </ul>
        </li>
        <?php endif; ?>

        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['hostel-member-create', 'hostel-member-view', 'hostel-room-create', 'hostel-room-view', 'hostel-create', 'hostel-view', 'room-type-create', 'room-type-view'])): ?>
        <li class="nav-item pcoded-hasmenu <?php echo e(Request::is('admin/hostel*') ? 'pcoded-trigger active' : ''); ?>">
            <a href="#!" class="nav-link">
                <span class="pcoded-micon"><i class="fas fa-hotel"></i></span>
                <span class="pcoded-mtext"><?php echo e(trans_choice('module_hostel', 2)); ?></span>
            </a>
            <ul class="pcoded-submenu">
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['hostel-member-create', 'hostel-member-view'])): ?>
                <li class="nav-item pcoded-hasmenu <?php echo e(Request::is('admin/hostel-student*') ? 'pcoded-trigger active' : ''); ?> <?php echo e(Request::is('admin/hostel-staff*') ? 'pcoded-trigger active' : ''); ?>">
                    <a href="#!" class="nav-link">
                        <span class="pcoded-mtext"><?php echo e(trans_choice('module_member', 2)); ?></span>
                    </a>

                    <ul class="pcoded-submenu">
                        <li class="<?php echo e(Request::is('admin/hostel-student*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.hostel-student.index')); ?>" class=""><?php echo e(trans_choice('module_student', 1)); ?> <?php echo e(__('list')); ?></a></li>

                        <li class="<?php echo e(Request::is('admin/hostel-staff*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.hostel-staff.index')); ?>" class=""><?php echo e(trans_choice('module_staff', 1)); ?> <?php echo e(__('list')); ?></a></li>
                    </ul>
                </li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['hostel-room-create', 'hostel-room-view'])): ?>
                <li class="<?php echo e(Request::is('admin/hostel/hostel-room*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.hostel-room.index')); ?>" class=""><?php echo e(trans_choice('module_hostel_room', 2)); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['hostel-create', 'hostel-view'])): ?>
                <li class="<?php echo e(Request::is('admin/hostel/hostel') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.hostel.index')); ?>" class=""><?php echo e(trans_choice('module_hostel', 1)); ?> <?php echo e(__('list')); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['room-type-create', 'room-type-view'])): ?>
                <li class="<?php echo e(Request::is('admin/hostel/room-type*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.room-type.index')); ?>" class=""><?php echo e(trans_choice('module_room_type', 2)); ?></a></li>
                <?php endif; ?>
            </ul>
        </li>
        <?php endif; ?>

        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['transport-member-create', 'transport-member-view', 'transport-vehicle-create', 'transport-vehicle-view', 'transport-route-create', 'transport-route-view'])): ?>
        <li class="nav-item pcoded-hasmenu <?php echo e(Request::is('admin/transport*') ? 'pcoded-trigger active' : ''); ?>">
            <a href="#!" class="nav-link">
                <span class="pcoded-micon"><i class="fas fa-bus-alt"></i></span>
                <span class="pcoded-mtext"><?php echo e(trans_choice('module_transport', 2)); ?></span>
            </a>
            <ul class="pcoded-submenu">
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['transport-member-create', 'transport-member-view'])): ?>
                <li class="nav-item pcoded-hasmenu <?php echo e(Request::is('admin/transport-student*') ? 'pcoded-trigger active' : ''); ?> <?php echo e(Request::is('admin/transport-staff*') ? 'pcoded-trigger active' : ''); ?>">
                    <a href="#!" class="nav-link">
                        <span class="pcoded-mtext"><?php echo e(trans_choice('module_member', 2)); ?></span>
                    </a>

                    <ul class="pcoded-submenu">
                        <li class="<?php echo e(Request::is('admin/transport-student*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.transport-student.index')); ?>" class=""><?php echo e(trans_choice('module_student', 1)); ?> <?php echo e(__('list')); ?></a></li>

                        <li class="<?php echo e(Request::is('admin/transport-staff*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.transport-staff.index')); ?>" class=""><?php echo e(trans_choice('module_staff', 1)); ?> <?php echo e(__('list')); ?></a></li>
                    </ul>
                </li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['transport-vehicle-create', 'transport-vehicle-view'])): ?>
                <li class="<?php echo e(Request::is('admin/transport-vehicle*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.transport-vehicle.index')); ?>" class=""><?php echo e(trans_choice('module_transport_vehicle', 2)); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['transport-route-create', 'transport-route-view'])): ?>
                <li class="<?php echo e(Request::is('admin/transport-route*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.transport-route.index')); ?>" class=""><?php echo e(trans_choice('module_transport_route', 2)); ?></a></li>
                <?php endif; ?>
            </ul>
        </li>
        <?php endif; ?>

        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['visitor-create', 'visitor-view', 'visitor-print', 'visit-purpose-create', 'visit-purpose-view', 'visitor-token-setting-view', 'enquiry-create', 'enquiry-view', 'enquiry-source-create', 'enquiry-source-view', 'enquiry-reference-create', 'enquiry-reference-view', 'phone-log-create', 'phone-log-view', 'complain-create', 'complain-view', 'complain-type-create', 'complain-type-view', 'complain-source-create', 'complain-source-view', 'postal-exchange-create', 'postal-exchange-view', 'postal-type-create', 'postal-type-view', 'meeting-create', 'meeting-view', 'meeting-type-create', 'meeting-type-view'])): ?>
        <li class="nav-item pcoded-hasmenu <?php echo e(Request::is('admin/frontdesk*') ? 'pcoded-trigger active' : ''); ?>">
            <a href="#!" class="nav-link">
                <span class="pcoded-micon"><i class="fas fa-desktop"></i></span>
                <span class="pcoded-mtext"><?php echo e(trans_choice('module_front_desk', 2)); ?></span>
            </a>
            <ul class="pcoded-submenu">
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['visitor-create', 'visitor-view', 'visitor-print'])): ?>
                <li class="<?php echo e(Request::is('admin/frontdesk/visit*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.visitor.index')); ?>" class=""><?php echo e(trans_choice('module_visitor_log', 2)); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['phone-log-create', 'phone-log-view'])): ?>
                <li class="<?php echo e(Request::is('admin/frontdesk/phone-log*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.phone-log.index')); ?>" class=""><?php echo e(trans_choice('module_phone_log', 2)); ?></a></li>
                <?php endif; ?>
                
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['enquiry-create', 'enquiry-view'])): ?>
                <li class="<?php echo e(Request::is('admin/frontdesk/enquiry*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.enquiry.index')); ?>" class=""><?php echo e(trans_choice('module_enquiry', 1)); ?> <?php echo e(__('list')); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['complain-create', 'complaine-view'])): ?>
                <li class="<?php echo e(Request::is('admin/frontdesk/complain*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.complain.index')); ?>" class=""><?php echo e(trans_choice('module_complain', 1)); ?> <?php echo e(__('list')); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['postal-exchange-create', 'postal-exchange-view'])): ?>
                <li class="<?php echo e(Request::is('admin/frontdesk/postal*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.postal-exchange.index')); ?>" class=""><?php echo e(trans_choice('module_postal_exchange', 2)); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['meeting-create', 'meeting-view'])): ?>
                <li class="<?php echo e(Request::is('admin/frontdesk/meeting*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.meeting.index')); ?>" class=""><?php echo e(trans_choice('module_meeting', 2)); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['visit-purpose-create', 'visit-purpose-view', 'visitor-token-setting-view', 'enquiry-source-create', 'enquiry-source-view', 'enquiry-reference-create', 'enquiry-reference-view', 'complain-type-create', 'complain-type-view', 'complain-source-create', 'complain-source-view', 'postal-type-create', 'postal-type-view', 'meeting-type-create', 'meeting-type-view'])): ?>
                <li class="nav-item pcoded-hasmenu <?php echo e(Request::is('admin/frontdesk/visit-purpose*') ? 'pcoded-trigger active' : ''); ?> <?php echo e(Request::is('admin/frontdesk/visitor-token-setting*') ? 'pcoded-trigger active' : ''); ?> <?php echo e(Request::is('admin/frontdesk/enquiry-source*') ? 'pcoded-trigger active' : ''); ?> <?php echo e(Request::is('admin/frontdesk/enquiry-reference*') ? 'pcoded-trigger active' : ''); ?> <?php echo e(Request::is('admin/frontdesk/complain-type*') ? 'pcoded-trigger active' : ''); ?> <?php echo e(Request::is('admin/frontdesk/complain-source*') ? 'pcoded-trigger active' : ''); ?> <?php echo e(Request::is('admin/frontdesk/postal-type*') ? 'pcoded-trigger active' : ''); ?> <?php echo e(Request::is('admin/frontdesk/meeting-type*') ? 'pcoded-trigger active' : ''); ?>">
                    <a href="#!" class="nav-link">
                        <span class="pcoded-mtext"><?php echo e(trans_choice('module_setting', 2)); ?></span>
                    </a>

                    <ul class="pcoded-submenu">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['visit-purpose-create', 'visit-purpose-view'])): ?>
                        <li class="<?php echo e(Request::is('admin/frontdesk/visit-purpose*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.visit-purpose.index')); ?>" class=""><?php echo e(trans_choice('module_visit_purpose', 2)); ?></a></li>
                        <?php endif; ?>

                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('visitor-token-setting-view')): ?>
                        <li class="<?php echo e(Request::is('admin/frontdesk/visitor-token-setting*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.visitor-token-setting.index')); ?>" class=""><?php echo e(trans_choice('module_visitor_token_setting', 2)); ?></a></li>
                        <?php endif; ?>

                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['enquiry-source-create', 'enquiry-source-view'])): ?>
                        <li class="<?php echo e(Request::is('admin/frontdesk/enquiry-source*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.enquiry-source.index')); ?>" class=""><?php echo e(trans_choice('module_enquiry_source', 2)); ?></a></li>
                        <?php endif; ?>

                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['enquiry-reference-create', 'enquiry-reference-view'])): ?>
                        <li class="<?php echo e(Request::is('admin/frontdesk/enquiry-reference*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.enquiry-reference.index')); ?>" class=""><?php echo e(trans_choice('module_enquiry_reference', 2)); ?></a></li>
                        <?php endif; ?>

                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['complain-type-create', 'complain-type-view'])): ?>
                        <li class="<?php echo e(Request::is('admin/frontdesk/complain-type*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.complain-type.index')); ?>" class=""><?php echo e(trans_choice('module_complain_type', 2)); ?></a></li>
                        <?php endif; ?>

                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['complain-source-create', 'complain-source-view'])): ?>
                        <li class="<?php echo e(Request::is('admin/frontdesk/complain-source*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.complain-source.index')); ?>" class=""><?php echo e(trans_choice('module_complain_source', 2)); ?></a></li>
                        <?php endif; ?>

                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['postal-type-create', 'postal-type-view'])): ?>
                        <li class="<?php echo e(Request::is('admin/frontdesk/postal-type*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.postal-type.index')); ?>" class=""><?php echo e(trans_choice('module_postal_type', 2)); ?></a></li>
                        <?php endif; ?>

                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['meeting-type-create', 'meeting-type-view'])): ?>
                        <li class="<?php echo e(Request::is('admin/frontdesk/meeting-type*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.meeting-type.index')); ?>" class=""><?php echo e(trans_choice('module_meeting_type', 2)); ?></a></li>
                        <?php endif; ?>
                    </ul>
                </li>
                <?php endif; ?>
            </ul>
        </li>
        <?php endif; ?>
        
        <!-- Remove the standalone Transcript module since it's now part of Examination -->
        
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['report-student-progress', 'report-subject-students', 'report-student-attendance', 'report-subject-attendance', 'report-collected-fees', 'report-student-fees', 'report-salary-paid', 'report-staff-leaves', 'report-income', 'report-expense', 'report-library', 'report-book-return', 'report-inventory', 'report-hostel', 'report-transport'])): ?>
        <li class="nav-item pcoded-hasmenu <?php echo e(Request::is('admin/report*') ? 'pcoded-trigger active' : ''); ?>">
            <a href="#!" class="nav-link">
                <span class="pcoded-micon"><i class="fas fa-chart-line"></i></span>
                <span class="pcoded-mtext"><?php echo e(trans_choice('module_report', 2)); ?></span>
            </a>
            <ul class="pcoded-submenu">
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('report-student-progress')): ?>
                <li class="<?php echo e(Request::is('admin/report/student') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.report.student')); ?>" class=""><?php echo e(trans_choice('module_student_progress', 1)); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('report-subject-students')): ?>
                <li class="<?php echo e(Request::is('admin/report/subject') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.report.subject')); ?>" class=""><?php echo e(trans_choice('module_course_students', 1)); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('report-student-attendance')): ?>
                <li class="<?php echo e(Request::is('admin/report/student-attendance') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.report.student-attendance')); ?>" class=""><?php echo e(trans_choice('module_student_attendance', 1)); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('report-subject-attendance')): ?>
                <li class="<?php echo e(Request::is('admin/report/subject-attendance') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.report.subject-attendance')); ?>" class=""><?php echo e(trans_choice('module_student_subject_attendance', 1)); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('report-collected-fees')): ?>
                <li class="<?php echo e(Request::is('admin/report/fees') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.report.fees')); ?>" class=""><?php echo e(trans_choice('module_collected_fees', 1)); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('report-student-fees')): ?>
                <li class="<?php echo e(Request::is('admin/report/student-fees') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.report.student-fees')); ?>" class=""><?php echo e(trans_choice('module_student_fees', 1)); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('report-salary-paid')): ?>
                <li class="<?php echo e(Request::is('admin/report/payroll') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.report.payroll')); ?>" class=""><?php echo e(trans_choice('module_salary_paid', 1)); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('report-staff-leaves')): ?>
                <li class="<?php echo e(Request::is('admin/report/leave') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.report.leave')); ?>" class=""><?php echo e(trans_choice('module_staff_leaves', 1)); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('report-income')): ?>
                <li class="<?php echo e(Request::is('admin/report/income') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.report.income')); ?>" class=""><?php echo e(trans_choice('module_total_income', 1)); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('report-expense')): ?>
                <li class="<?php echo e(Request::is('admin/report/expense') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.report.expense')); ?>" class=""><?php echo e(trans_choice('module_total_expense', 1)); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('report-library')): ?>
                <li class="<?php echo e(Request::is('admin/report/library') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.report.library')); ?>" class=""><?php echo e(trans_choice('module_library_history', 1)); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('report-book-return')): ?>
                <li class="<?php echo e(Request::is('admin/report/book-return') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.report.book-return')); ?>" class=""><?php echo e(trans_choice('module_book_return_due', 1)); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('report-inventory')): ?>
                <li class="<?php echo e(Request::is('admin/report/inventory') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.report.inventory')); ?>" class=""><?php echo e(trans_choice('module_inventory_history', 1)); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('report-hostel')): ?>
                <li class="<?php echo e(Request::is('admin/report/hostel') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.report.hostel')); ?>" class=""><?php echo e(trans_choice('module_hostel_members', 1)); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('report-transport')): ?>
                <li class="<?php echo e(Request::is('admin/report/transport') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.report.transport')); ?>" class=""><?php echo e(trans_choice('module_transport_members', 1)); ?></a></li>
                <?php endif; ?>
            </ul>
        </li>
        <?php endif; ?>

        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['topbar-setting-view', 'social-setting-view', 'slider-view', 'slider-create', 'about-us-view', 'feature-view', 'feature-create', 'course-view', 'course-create', 'web-event-view', 'web-event-create', 'news-view', 'news-create', 'gallery-view', 'gallery-create', 'faq-view', 'faq-create', 'testimonial-view', 'testimonial-create', 'page-view', 'page-create', 'call-to-action-view'])): ?>
        <li class="nav-item pcoded-hasmenu <?php echo e(Request::is('admin/web*') ? 'pcoded-trigger active' : ''); ?>">
            <a href="#!" class="nav-link">
                <span class="pcoded-micon"><i class="fas fa-globe"></i></span>
                <span class="pcoded-mtext"><?php echo e(trans_choice('module_front_web', 2)); ?></span>
            </a>
            <ul class="pcoded-submenu">
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('topbar-setting-view')): ?>
                <li class="<?php echo e(Request::is('admin/web/topbar-setting*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.topbar-setting.index')); ?>" class=""><?php echo e(trans_choice('module_topbar_setting', 1)); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('social-setting-view')): ?>
                <li class="<?php echo e(Request::is('admin/web/social-setting*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.social-setting.index')); ?>" class=""><?php echo e(trans_choice('module_social_setting', 1)); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['slider-view', 'slider-create'])): ?>
                <li class="<?php echo e(Request::is('admin/web/slider*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.slider.index')); ?>" class=""><?php echo e(trans_choice('module_slider', 2)); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('about-us-view')): ?>
                <li class="<?php echo e(Request::is('admin/web/about-us*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.about-us.index')); ?>" class=""><?php echo e(trans_choice('module_about_us', 1)); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['feature-view', 'feature-create'])): ?>
                <li class="<?php echo e(Request::is('admin/web/feature*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.feature.index')); ?>" class=""><?php echo e(trans_choice('module_feature', 2)); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['course-view', 'course-create'])): ?>
                <li class="<?php echo e(Request::is('admin/web/course*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.course.index')); ?>" class=""><?php echo e(trans_choice('module_course', 2)); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['web-event-view', 'web-event-create'])): ?>
                <li class="<?php echo e(Request::is('admin/web/web-event*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.web-event.index')); ?>" class=""><?php echo e(trans_choice('module_event', 2)); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['news-view', 'news-create'])): ?>
                <li class="<?php echo e(Request::is('admin/web/news*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.news.index')); ?>" class=""><?php echo e(trans_choice('module_news', 2)); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['faq-view', 'faq-create'])): ?>
                <li class="<?php echo e(Request::is('admin/web/faq*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.faq.index')); ?>" class=""><?php echo e(trans_choice('module_faq', 2)); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['gallery-view', 'gallery-create'])): ?>
                <li class="<?php echo e(Request::is('admin/web/gallery*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.gallery.index')); ?>" class=""><?php echo e(trans_choice('module_gallery', 2)); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['testimonial-view', 'testimonial-create'])): ?>
                <li class="<?php echo e(Request::is('admin/web/testimonial*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.testimonial.index')); ?>" class=""><?php echo e(trans_choice('module_testimonial', 2)); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['page-view', 'page-create'])): ?>
                <li class="<?php echo e(Request::is('admin/web/page*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.page.index')); ?>" class=""><?php echo e(trans_choice('module_footer_page', 2)); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('call-to-action-view')): ?>
                <li class="<?php echo e(Request::is('admin/web/call-to-action*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.call-to-action.index')); ?>" class=""><?php echo e(trans_choice('module_call_to_action', 1)); ?></a></li>
                <?php endif; ?>
            </ul>
        </li>
        <?php endif; ?>

        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['setting-view', 'province-view', 'province-create', 'district-view', 'district-create', 'language-view', 'language-create', 'translations-view', 'translations-create', 'setting-mail', 'setting-sms', 'setting-payment', 'application-setting-view', 'schedule-setting-view', 'role-view', 'role-edit', 'field-staff', 'field-student', 'field-application', 'student-panel-view'])): ?>
        <li class="nav-item pcoded-hasmenu <?php echo e(Request::is('admin/setting*') ? 'pcoded-trigger active' : ''); ?> <?php echo e(Request::is('admin/translations*') ? 'pcoded-trigger active' : ''); ?>">
            <a href="#!" class="nav-link">
                <span class="pcoded-micon"><i class="fas fa-cog"></i></span>
                <span class="pcoded-mtext"><?php echo e(trans_choice('module_setting', 2)); ?></span>
            </a>
            <ul class="pcoded-submenu">
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('setting-view')): ?>
                <li class="<?php echo e(Request::is('admin/setting') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.setting.index')); ?>" class=""><?php echo e(trans_choice('module_general_setting', 1)); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['province-view', 'province-create'])): ?>
                <li class="<?php echo e(Request::is('admin/setting/province*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.province.index')); ?>" class=""><?php echo e(trans_choice('module_province', 2)); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['district-view', 'district-create'])): ?>
                <li class="<?php echo e(Request::is('admin/setting/district*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.district.index')); ?>" class=""><?php echo e(trans_choice('module_district', 2)); ?></a></li>
                <?php endif; ?>
                
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['language-view', 'language-create'])): ?>
                <li class="<?php echo e(Request::is('admin/setting/language*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.language.index')); ?>" class=""><?php echo e(trans_choice('module_language', 2)); ?></a></li>
                <?php endif; ?>
                
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['translations-view', 'translations-create'])): ?>
                <li class="<?php echo e(Request::is('admin/translations*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.translations.index')); ?>" class=""><?php echo e(trans_choice('module_translate', 2)); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('setting-mail')): ?>
                <li class="<?php echo e(Request::is('admin/setting/mail-setting*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.mail-setting.index')); ?>" class=""><?php echo e(trans_choice('module_mail_setting', 1)); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('setting-sms')): ?>
                <li class="<?php echo e(Request::is('admin/setting/sms-setting*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.sms-setting.index')); ?>" class=""><?php echo e(trans_choice('module_sms_setting', 2)); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('setting-payment')): ?>
                <li class="<?php echo e(Request::is('admin/setting/payment-setting*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.payment-setting.index')); ?>" class=""><?php echo e(trans_choice('module_payment_setting', 2)); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('application-setting-view')): ?>
                <li class="<?php echo e(Request::is('admin/setting/application-setting*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.application-setting.index')); ?>" class=""><?php echo e(trans_choice('module_application_setting', 1)); ?></a></li>
                <?php endif; ?>

                

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['role-view', 'role-edit'])): ?>
                <li class="<?php echo e(Request::is('admin/setting/role*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.role.index')); ?>" class=""><?php echo e(trans_choice('module_role', 2)); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['field-staff', 'field-student', 'field-application'])): ?>
                <li class="nav-item pcoded-hasmenu <?php echo e(Request::is('admin/setting/field*') ? 'pcoded-trigger active' : ''); ?>">
                    <a href="#!" class="nav-link">
                        <span class="pcoded-mtext"><?php echo e(trans_choice('module_field_setting', 2)); ?></span>
                    </a>

                    <ul class="pcoded-submenu">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['field-staff'])): ?>
                        <li class="<?php echo e(Request::is('admin/setting/field-user*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.field.user')); ?>" class=""><?php echo e(trans_choice('module_staff', 2)); ?></a></li>
                        <?php endif; ?>

                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['field-student'])): ?>
                        <li class="<?php echo e(Request::is('admin/setting/field-student*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.field.student')); ?>" class=""><?php echo e(trans_choice('module_student', 2)); ?></a></li>
                        <?php endif; ?>

                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['field-application'])): ?>
                        <li class="<?php echo e(Request::is('admin/setting/field-application*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.field.application')); ?>" class=""><?php echo e(trans_choice('module_application', 2)); ?></a></li>
                        <?php endif; ?>
                    </ul>
                </li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['student-panel-view'])): ?>
                <li class="<?php echo e(Request::is('admin/setting/student-panel*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.student.panel')); ?>" class=""><?php echo e(trans_choice('module_student_panel', 2)); ?></a></li>
                <?php endif; ?>
            </ul>
        </li>
        <?php endif; ?>

        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['profile-view', 'profile-edit'])): ?>
        <li class="nav-item <?php echo e(Request::is('admin/profile*') ? 'active' : ''); ?>">
            <a href="<?php echo e(route('admin.profile.index')); ?>" class="nav-link">
                <span class="pcoded-micon"><i class="fas fa-user-edit"></i></span>
                <span class="pcoded-mtext"><?php echo e(trans_choice('module_profile', 2)); ?></span>
            </a>
        </li>
        <?php endif; ?>

    </ul>
</div>
<!-- End Sidebar -->

   

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const sidebar = document.querySelector('.pcoded-hasmenu');

        // Check local storage to see if the sidebar should be expanded
        if (localStorage.getItem('sidebar-expanded') === 'true') {
            sidebar.classList.add('pcoded-trigger');
        }

        // Toggle sidebar state on click
        sidebar.addEventListener('click', function () {
            const isExpanded = sidebar.classList.toggle('pcoded-trigger');
            localStorage.setItem('sidebar-expanded', isExpanded);
        });
    });
</script>
<script>// Make sure this is in your scripts
if ($('#pcoded').length) {
    $('#pcoded').pcodedmenu({
        menuTrigger: 'click',
        subMenuSubItem: 'click',
    });
}</script><?php /**PATH C:\wamp64\www\Dapin-CMS-main\resources\views/admin/layouts/inc/sidebar.blade.php ENDPATH**/ ?>