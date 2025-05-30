@extends('admin.layouts.master')
@section('title', $title)
@section('page_css')
<link rel="stylesheet" href="{{ asset('dashboard/plugins/lightbox2-master/css/lightbox.min.css') }}">
<style>
    .list-group-item .heading {
        font-weight: bold;
        color: #333;
    }
    .list-group-item .data {
        margin-left: 10px;
        color: #555;
    }
    .button-row {
        display: flex;
        gap: 10px;
    }
</style>
@endsection
@section('content')

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->

        <!-- Back Buttons at the top -->
        <div class="mt-3 mb-3 button-row">
            <a href="{{ route('admin.dashboard.index') }}" class="btn btn-secondary">{{ __('Back to Dashboard') }}</a>
            <button class="btn btn-secondary" onclick="history.back();">{{ __('Back') }}</button>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="card user-card user-card-1">
                    <div class="card-body pb-0">
                        <div class="media user-about-block align-items-center mt-0 mb-3">
                            {{-- <div class="media-body ms-3">
                                <h6 class="mb-1">{{ $row->first_name }} {{ $row->last_name }}</h6>
                                @if(isset($row->registration_no))
                                <p class="mb-0 text-muted">#{{ $row->registration_no }}</p>
                                @endif
                            </div> --}}
                        </div>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <span class="heading"><i class="fas fa-phone-alt m-r-10"></i>{{ __('Phone') }} :</span>
                            <span class="data">{{ $message->phone_number }}</span>
                        </li>
                        <li class="list-group-item">
                            <span class="heading"><i class="fas fa-time-alt m-r-10"></i>{{ __('Time Sent') }} :</span>
                            <span class="data">{{ $message->sent_at }}</span>
                        </li>
                        <li class="list-group-item">
                            <span class="heading"><i class="fas fa-graduati m-r-10"></i>{{ __('Status') }} :</span>
                            <span class="data">{{ $message->status }}</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card">
                    <div class="card-block">
                        <div class="">
                            <div class="row">
                                <div class="col-md-12">
                                    <li class="list-group-item">
                                        <span class="heading"><i class="fa fa-graduation m-r-10"></i>{{ __('Text Message') }} :</span>
                                        <span class="data">{{ $message->message }}</span>
                                    </li>
                                    @if(!empty($students))
                                        <li class="list-group-item">
                                            <span class="heading"><i class="fa fa-users m-r-10"></i>{{ __('Recipients') }} :</span>
                                            <ul class="data">
                                                @foreach($students as $student)
                                                    <li>{{ $student->first_name }} {{ $student->last_name }} - {{ $student->phone }}</li>
                                                @endforeach
                                            </ul>
                                        </li>
                                    @endif
                                </div>
                            </div>
                            <!-- Back Buttons at the bottom -->
                          
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ Main Content ] end -->

    </div>
</div>
<!-- End Content-->

@endsection

@section('page_js')
<script src="{{ asset('dashboard/plugins/lightbox2-master/js/lightbox.min.js') }}"></script>
@endsection
