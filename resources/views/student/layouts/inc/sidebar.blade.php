<div class="navbar-content scroll-div ps ps--active-y">
    <ul class="nav pcoded-inner-navbar">

         @php
            function panel($slug){
                return \App\Models\Field::field($slug);
            }
        @endphp 

        <li class="nav-item {{ Request::is('student/dashboard*') ? 'active' : '' }}">
            <a href="{{ route('student.dashboard.index') }}" class="nav-link">
                <span class="pcoded-micon"><i class="fas fa-desktop"></i></span>
                <span class="pcoded-mtext">{{ trans_choice('module_dashboard', 1) }}</span>
            </a>
        </li>

        @if(($panel = panel('panel_class_routine')) && $panel->status == 1)
        <li class="nav-item {{ Request::is('student/class-routine*') ? 'active' : '' }}">
            <a href="{{ route('student.class-routine.index') }}" class="nav-link">
                <span class="pcoded-micon"><i class="fas fa-clock"></i></span>
                <span class="pcoded-mtext">{{ trans_choice('module_class_routine', 2) }}</span>
            </a>
        </li>
        @endif

        @if(($panel = panel('panel_exam_routine')) && $panel->status == 1)
        <li class="nav-item {{ Request::is('student/exam-routine*') ? 'active' : '' }}">
            <a href="{{ route('student.exam-routine.index') }}" class="nav-link">
                <span class="pcoded-micon"><i class="fas fa-align-left"></i></span>
                <span class="pcoded-mtext">{{ trans_choice('module_exam_routine', 2) }}</span>
            </a>
        </li>
        @endif



  @if(($panel = panel('testfile')) && $panel->status == 1)
        <li class="nav-item {{ Request::is('student/test*') ? 'active' : '' }}">
            <a href="{{ route('testfile') }}" class="nav-link">
                <span class="pcoded-micon"><i class="fas fa-align-left"></i></span>
                <span class="pcoded-mtext">{{ trans_choice('Test', 2) }}</span>
            </a>
        </li>
        @endif




        @if(($panel = panel('panel_attendance')) && $panel->status == 1)
        <li class="nav-item {{ Request::is('student/attendance*') ? 'active' : '' }}">
            <a href="{{ route('student.attendance.index') }}" class="nav-link">
                <span class="pcoded-micon"><i class="fas fa-calendar-check"></i></span>
                <span class="pcoded-mtext">{{ trans_choice('module_attendance', 2) }}</span>
            </a>
        </li>
        @endif

        @if(($panel = panel('panel_leave')) && $panel->status == 1)
        <li class="nav-item {{ Request::is('student/leave*') ? 'active' : '' }}">
            <a href="{{ route('student.leave.index') }}" class="nav-link">
                <span class="pcoded-micon"><i class="far fa-edit"></i></span>
                <span class="pcoded-mtext">{{ trans_choice('module_apply_leave', 2) }}</span>
            </a>
        </li>
        @endif

        @if(($panel = panel('panel_fees_report')) && $panel->status == 1)
        <li class="nav-item {{ Request::is('student/fees*') ? 'active' : '' }}">
            <a href="{{ route('student.fees.index') }}" class="nav-link">
                <span class="pcoded-micon"><i class="fas fa-money-bill-wave"></i></span>
                <span class="pcoded-mtext">{{ trans_choice('module_fees_report', 2) }}</span>
            </a>
        </li>
        @endif

        <li class="nav-item {{ Request::is('student/subject*') ? 'active' : '' }}">
            <a href="{{ route('student.subject.index') }}" class="nav-link">
                <span class="pcoded-micon"><i class="fas fa-clipboard-list"></i></span>
                <span class="pcoded-mtext">{{ __('Register Units') }}</span>
            </a>
        </li>

        @if(($panel = panel('panel_library')) && $panel->status == 1)
        <li class="nav-item {{ Request::is('student/library*') ? 'active' : '' }}">
            <a href="{{ route('student.library.index') }}" class="nav-link">
                <span class="pcoded-micon"><i class="fas fa-book-open"></i></span>
                <span class="pcoded-mtext">{{ trans_choice('module_library', 2) }}</span>
            </a>
        </li>
        @endif
    
   @if(($panel = panel('panel_digital')) && $panel->status == 1)
<li class="nav-item {{ Request::is('student/all/digital/file/student*') ? 'active' : '' }}">
    <a href="{{ route('studentlibrarydigital') }}" class="nav-link">
        <span class="pcoded-micon"><i class="fas fa-book-open"></i></span>
        <span class="pcoded-mtext">{{ trans_choice('Digital Library', 2) }}</span>
    </a>
</li>
@endif



        @if(($panel = panel('panel_notice')) && $panel->status == 1)
        <li class="nav-item {{ Request::is('student/notice*') ? 'active' : '' }}">
            <a href="{{ route('student.notice.index') }}" class="nav-link">
                <span class="pcoded-micon"><i class="fas fa-bullhorn"></i></span>
                <span class="pcoded-mtext">{{ trans_choice('module_notice', 2) }}</span>
            </a>
        </li>
        @endif

        @if(($panel = panel('panel_assignment')) && $panel->status == 1)
        <li class="nav-item {{ Request::is('student/assignment*') ? 'active' : '' }}">
            <a href="{{ route('student.assignment.index') }}" class="nav-link">
                <span class="pcoded-micon"><i class="fas fa-newspaper"></i></span>
                <span class="pcoded-mtext">{{ trans_choice('module_assignment', 2) }}</span>
            </a>
        </li>
        @endif

        @if(($panel = panel('panel_download')) && $panel->status == 1)
        <li class="nav-item {{ Request::is('student/download*') ? 'active' : '' }}">
            <a href="{{ route('student.download.index') }}" class="nav-link">
                <span class="pcoded-micon"><i class="fas fa-download"></i></span>
                <span class="pcoded-mtext">{{ trans_choice('module_download', 2) }}</span>
            </a>
        </li>
        @endif

        @if(($panel = panel('panel_transcript')) && $panel->status == 1)
        <li class="nav-item {{ Request::is('student/transcript*') ? 'active' : '' }}">
            <a href="{{ route('student.transcript.index') }}" class="nav-link">
                <span class="pcoded-micon"><i class="fas fa-pen-square"></i></span>
                <span class="pcoded-mtext">{{ trans_choice('module_transcript', 1) }}</span>
            </a>
        </li>
        @endif

        @if(($panel = panel('panel_profile')) && $panel->status == 1)
        <li class="nav-item {{ Request::is('student/profile*') ? 'active' : '' }}">
            <a href="{{ route('student.profile.index') }}" class="nav-link">
                <span class="pcoded-micon"><i class="fas fa-id-card"></i></span>
                <span class="pcoded-mtext">{{ trans_choice('module_profile', 2) }}</span>
            </a>
        </li>
        @endif

    </ul>
</div>
<!-- End Sidebar -->
