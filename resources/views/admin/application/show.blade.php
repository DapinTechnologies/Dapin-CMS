@extends('admin.layouts.master')
@section('title', $title)
@section('page_css')
<link rel="stylesheet" href="{{ asset('dashboard/plugins/lightbox2-master/css/lightbox.min.css') }}">
@endsection
@section('content')

@php




    use App\Models\County;
    use App\Models\SubCounty;

    $counties = County::all();
    $subCounties = SubCounty::all(); // Ensure this references the correct table
@endphp

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-md-3">
                <div class="card user-card user-card-1">
                    <div class="card-body pb-0">
                        <div class="media user-about-block align-items-center mt-0 mb-3">
                            <div class="position-relative d-inline-block">
                                @if(is_file('uploads/'.$path.'/'.$row->photo))
                                    <img src="{{ asset('uploads/'.$path.'/'.$row->photo) }}" class="img-radius img-fluid wid-80" alt="{{ __('Photo') }}" onerror="this.src='{{ asset('dashboard/images/user/avatar-2.jpg') }}';">
                                @else
                                    <img src="{{ asset('dashboard/images/user/avatar-2.jpg') }}" class="img-radius img-fluid wid-80" alt="{{ __('Photo') }}">
                                @endif
                                <div class="certificated-badge">
                                    <i class="fas fa-certificate text-primary bg-icon"></i>
                                    <i class="fas fa-check front-icon text-white"></i>
                                </div>
                            </div>
                            <div class="media-body ms-3">
                                <h6 class="mb-1">{{ $row->first_name }} {{ $row->last_name }}</h6>
                                @if(isset($row->registration_no))
                                    <p class="mb-0 text-muted">#{{ $row->registration_no }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <span class="f-w-500"><i class="far fa-envelope m-r-10"></i>{{ __('Email') }} : </span>
                            <span class="float-end">{{ $row->email }}</span>
                        </li>
                        <li class="list-group-item">
                            <span class="f-w-500"><i class="fas fa-phone-alt m-r-10"></i>{{ __('Phone') }} : </span>
                            <span class="float-end">{{ $row->phone }}</span>
                        </li>
                        <li class="list-group-item">
                            <span class="f-w-500"><i class="fas fa-graduation-cap m-r-10"></i>{{ __('Program') }} : </span>
                            <span class="float-end">{{ $row->program->title ?? '' }}</span>
                        </li>
                        <li class="list-group-item">
                            <span class="f-w-500"><i class="far fa-calendar-alt m-r-10"></i>{{ __('Apply Date') }} : </span>
                            <span class="float-end">
                                @if(isset($setting->date_format))
                                    {{ date($setting->date_format, strtotime($row->apply_date)) }}
                                @else
                                    {{ date("Y-m-d", strtotime($row->apply_date)) }}
                                @endif
                            </span>
                        </li>
                        <li class="list-group-item border-bottom-0">
                            <span class="f-w-500"><i class="far fa-question-circle m-r-10"></i>{{ __('Status') }} : </span>
                            <span class="float-end">
                                @if( $row->status == 1 )
                                    <span class="badge badge-pill badge-primary">{{ __('Pending') }}</span>
                                @elseif( $row->status == 2 )
                                    <span class="badge badge-pill badge-success">{{ __('Approved') }}</span>
                                @else
                                    <span class="badge badge-pill badge-danger">{{ __('Rejected') }}</span>
                                @endif
                            </span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col-md-9">
                <div class="card">
                    <div class="card-block">
                        <div class="">
                            <div class="row">
                                <div class="col-md-4">
                                    <fieldset class="row gx-2 scheduler-border">
                                        <legend>{{ __('Present Address') }}</legend>
                                        <p><mark class="text-primary">County:</mark> {{ $row->county->CountyName ?? 'N/A' }}</p><hr/>
                                        <p><mark class="text-primary">Sub County:</mark> {{ $row->subcounty->SubCountyName  ?? '' }}</p><hr/>
                                    </fieldset>
                                </div>

                                <div class="col-md-4">
                                    @if(!empty($row->school_name))
                                        <fieldset class="row gx-2 scheduler-border">
                                            <legend>{{ __('School Information') }}</legend>
                                            <p><mark class="text-primary">{{ __('School Name') }}:</mark> {{ $row->school_name }}</p><hr/>
                                            <p><mark class="text-primary">{{ __('Exam ID') }}:</mark> {{ $row->school_exam_id }}</p><hr/>
                                        </fieldset>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Documents Section -->
        <div class="row">
            @if(is_file('uploads/'.$path.'/'.$row->school_transcript))
                <div class="col-md-3">
                    <a href="{{ asset('uploads/'.$path.'/'.$row->school_transcript) }}" data-lightbox="gallery">
                        <img src="{{ asset('uploads/'.$path.'/'.$row->school_transcript) }}" class="img-fluid">
                    </a>
                </div>
            @endif
            @if(is_file('uploads/'.$path.'/'.$row->school_certificate))
                <div class="col-md-3">
                    <a href="{{ asset('uploads/'.$path.'/'.$row->school_certificate) }}" data-lightbox="gallery">
                        <img src="{{ asset('uploads/'.$path.'/'.$row->school_certificate) }}" class="img-fluid">
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
<!-- End Content -->

@endsection

@section('page_js')
<script src="{{ asset('dashboard/plugins/lightbox2-master/js/lightbox.min.js') }}"></script>
@endsection