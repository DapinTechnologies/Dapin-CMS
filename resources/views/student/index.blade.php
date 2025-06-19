@extends('student.layouts.master')
@section('title', $title)

@section('page_css')
    <!-- Full calendar css -->
    <link rel="stylesheet" href="{{ asset('dashboard/plugins/fullcalendar/css/fullcalendar.min.css') }}">
@endsection

@section('content')

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">

            @php
                function field($slug){
                    return \App\Models\Field::field($slug);
                }
            @endphp 

            @if(field('panel_assignment')->status == 1)
            <div class="col-sm-12 col-lg-12">
                <div class="card">
                    @if(isset($assignments))
                    <div class="card-header">
                        <h5>{{ trans_choice('module_assignment', 2) }}</h5>
                    </div>
                    <div class="card-block">
                        <!-- [ Data table ] start -->
                        <div class="table-responsive">
                            <table class="display table nowrap table-striped table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>{{ __('field_title') }}</th>
                                        <th>{{ __('field_subject') }}</th>
                                        <th>{{ __('field_status') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach( $assignments as $key => $row )
                                @if($row->assignment->status == 1)
                                    <tr>
                                        <td>
                                            <a href="{{ route('student.assignment.show', $row->id) }}">{!! str_limit($row->assignment->title ?? '', 50, ' ...') !!}</a>
                                        </td>
                                        <td>{{ $row->assignment->subject->code ?? '' }}</td>
                                        <td>
                                            @if( $row->attendance == 1 )
                                            <span class="badge badge-pill badge-success">{{ __('status_submitted') }}</span>
                                            @else
                                            <span class="badge badge-pill badge-primary">{{ __('status_pending') }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endif
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- [ Data table ] end -->
                    </div>
                    @endif
                </div>
            </div>
            @endif

        </div>
 
        <div class="row">
            <div class="col-xl-8 col-md-8 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ trans_choice('module_calendar', 2) }}</h5>
                    </div>
                    <div class="card-block">
                        <!-- [ Calendar ] start -->
                        <div id='calendar' class='calendar'></div>
                        <!-- [ Calendar ] end -->
                    </div>
                </div>
            </div>
           
            <div class="col-xl-4 col-md-4 col-sm-12">
                <!-- [Today's Classes] start -->
                <div class="card statistial-visit">
                    <div class="card-header">
                        <h5>{{ __('Today\'s Classes') }} ({{ \Carbon\Carbon::now()->format('l') }})</h5>
                        @if(isset($program_id))
                            <span class="badge badge-primary">
                                <i class="fas fa-graduation-cap"></i> 
                                Program: {{ App\Models\Program::find($program_id)->name ?? 'N/A' }}
                            </span>
                        @endif
                    </div>
                    <div class="card-block">
                        @if($today_classes->isNotEmpty())
                            @foreach($today_classes as $class)
                            <p>
                                <mark style="color: #6777ef;">
                                    <i class="fas fa-book-open"></i>
                                    <span style="color: inherit;">
                                        {{ $class->subject->code ?? 'N/A' }} - 
                                        @if(isset($setting->time_format))
                                        {{ date($setting->time_format, strtotime($class->start_time)) }} to 
                                        {{ date($setting->time_format, strtotime($class->end_time)) }}
                                        @else
                                        {{ date("h:i A", strtotime($class->start_time)) }} to 
                                        {{ date("h:i A", strtotime($class->end_time)) }}
                                        @endif
                                    </span>
                                </mark>
                                <br>
                                <small>
                                    {{ __('Unit') }}: {{ $class->subject->code ?? 'N/A' }} |
                                    {{ __('Room') }}: {{ $class->room->title ?? 'N/A' }} | 
                                    {{ __('Lecturer') }}: {{ $class->teacher->first_name ?? '' }} {{ $class->teacher->last_name ?? '' }} 
                                </small>
                            </p>
                            @endforeach
                        @else
                            <p>
                                <mark style="color: #6777ef;">
                                    <i class="fas fa-book-open"></i>
                                    <span style="color: inherit;">
                                        {{ __('No classes scheduled for today') }}
                                    </span>
                                </mark>
                            </p>
                        @endif
                    </div>
                </div>
                <!-- [Today's Classes] end -->
                
                <!-- [Notice List] start -->
                <div class="card statistial-visit" style="margin-top: 20px;">
                    <div class="card-header">
                        <h5>{{ __('Recent Notices') }}</h5>
                    </div>
                    <div class="card-block">
                        @if($latest_notices->isNotEmpty())
                            @foreach($latest_notices as $notice)
                            <p>
                                <mark style="color: #6777ef;">
                                    <i class="fas fa-bullhorn"></i>
                                    <a href="{{ route('student.notice.show', $notice->id) }}" style="color: inherit;">
                                        {{ $notice->title }}
                                    </a>
                                </mark>
                                <br>
                                <small>
                                    @if(isset($setting->date_format))
                                    {{ date($setting->date_format, strtotime($notice->date)) }}
                                    @else
                                    {{ date("Y-m-d", strtotime($notice->date)) }}
                                    @endif
                                </small>
                            </p>
                            @endforeach
                        @else
                            <p>{{ __('No recent notices') }}</p>
                        @endif
                    </div>
                </div>
                <!-- [Notice List] end -->
            </div>
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

@endsection

@section('page_js')
    <!-- Full calendar js -->
    <script src="{{ asset('dashboard/plugins/fullcalendar/js/lib/moment.min.js') }}"></script>
    <script src="{{ asset('dashboard/plugins/fullcalendar/js/lib/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('dashboard/plugins/fullcalendar/js/fullcalendar.min.js') }}"></script>

    <script type="text/javascript">
        // Full calendar
        $(window).on('load', function() {
            "use strict";
            $('#calendar').fullCalendar({
                header: {
                    left: 'prev,next',
                    center: 'title',
                    right: 'today'
                },
                defaultDate: '@php echo date("Y-m-d"); @endphp',
                editable: false,
                droppable: false,
                events: [
                @php
                    foreach($events as $key => $row){
                        echo "{
                                title: '".$row->title."',
                                start: '".$row->start_date."',
                                end: '".$row->end_date."',
                                borderColor: '".$row->color."',
                                backgroundColor: '".$row->color."',
                                textColor: '#fff'
                            }, ";
                    }
                @endphp
                ],
            });
        });
    </script>
@endsection