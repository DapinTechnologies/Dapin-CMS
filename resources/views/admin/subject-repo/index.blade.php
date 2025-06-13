@extends('admin.layouts.master')
@section('title', $title)

@section('content')

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Class Summary</h5>
                    </div>
                    <div class="card-block">
                        <form class="needs-validation" method="get" action="{{ route($route . '.index') }}">
                            <div class="row gx-2">

                                <!-- Faculty Filter -->
                                <div class="form-group col-md-3">
                                    <label for="faculty">{{ __('field_faculty') }}</label>
                                    <select class="form-control select2" name="faculty" id="faculty">
                                        <option value="">All</option>
                                        @foreach($faculties as $fac)
                                            <option value="{{ $fac->id }}" {{ $selected_faculty == $fac->id ? 'selected' : '' }}>
                                                {{ $fac->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Program Filter -->
                                <div class="form-group col-md-3">
                                    <label for="program">{{ __('field_program') }}</label>
                                    <select class="form-control select2" name="program" id="program">
                                        <option value="">All</option>
                                        @foreach($programs as $prog)
                                            <option value="{{ $prog->id }}" {{ $selected_program == $prog->id ? 'selected' : '' }}>
                                                {{ $prog->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Session Filter -->
                                <div class="form-group col-md-3">
                                    <label for="session">{{ __('field_session') }}</label>
                                    <select class="form-control select2" name="session" id="session">
                                        <option value="">All</option>
                                        @foreach($sessions as $sess)
                                            <option value="{{ $sess->id }}" {{ $selected_session == $sess->id ? 'selected' : '' }}>
                                                {{ $sess->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Semester Filter -->
                                <div class="form-group col-md-3">
                                    <label for="semester">{{ __('field_semester') }}</label>
                                    <select class="form-control select2" name="semester" id="semester">
                                        <option value="">All</option>
                                        @foreach($semesters as $sem)
                                            <option value="{{ $sem->id }}" {{ $selected_semester == $sem->id ? 'selected' : '' }}>
                                                {{ $sem->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Section Filter -->
                                <div class="form-group col-md-3">
                                    <label for="section">{{ __('field_section') }}</label>
                                    <select class="form-control select2" name="section" id="section">
                                        <option value="">All</option>
                                        @foreach($sections as $sec)
                                            <option value="{{ $sec->id }}" {{ $selected_section == $sec->id ? 'selected' : '' }}>
                                                {{ $sec->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Subject Filter -->
                                <div class="form-group col-md-3">
                                    <label for="subject">{{ __('field_subject') }}</label>
                                    <select class="form-control select2" name="subject" id="subject">
                                        <option value="">All</option>
                                        @foreach($subjects as $sub)
                                            <option value="{{ $sub->id }}" {{ $selected_subject == $sub->id ? 'selected' : '' }}>
                                                {{ $sub->code }} - {{ $sub->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Search Button -->
                                <div class="form-group col-md-3 align-self-end">
                                    <button type="submit" class="btn btn-info">
                                        <i class="fas fa-search"></i> {{ __('btn_search') }}
                                    </button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Statistics Table -->
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header"><h5>Summary</h5></div>
                    <div class="card-block">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                     <tr>
            <th>{{ __('field_subject') }}</th>
            <th>{{ __('Total Students') }}</th>
             <th>{{ __('Highest Mark') }}</th>
            <th>{{ __('Lowest Mark') }}</th>
            <th>{{ __('Average Mark') }}</th>
            <th>{{ __('Distinction') }}(80-100)</th>
            <th>{{ __('Merits') }}(70-79)</th>
            <th>{{ __('Pass') }}(50-69)</th>
            <th>{{ __('Fail') }}(0-49)</th>
            <th>{{ __('Pass Percentage') }}</th>
           
        </tr>
                                </thead>
                                <tbody>
                                    @forelse($statistics as $stat)
                                    <tr>
                                        <td>{{ $stat['subject']->code }} - {{ $stat['subject']->title }}</td>
                                        <td>{{ $stat['total_students'] ?? 0 }}</td>
                                        <td>{{ $stat['highest'] ?? 'N/A' }}</td>
                                        <td>{{ $stat['lowest'] ?? 'N/A' }}</td>
                                        <td>{{ $stat['average'] ?? 'N/A' }}</td>
                                        <td>{{ $stat['distinction'] ?? 0 }}</td> <!-- new -->
                                        <td>{{ $stat['merits'] ?? 0 }}</td>      <!-- new -->
                                        <td>{{ $stat['pass'] ?? 0 }}</td>
                                        <td>{{ $stat['fail'] ?? 0 }}</td>
                                        <td>
                                            @if(($stat['total_students'] ?? 0) > 0)
                                                {{ round(($stat['pass'] / $stat['total_students']) * 100, 2) }}%
                                            @else
                                                0%
                                            @endif
                                        </td>
                                        
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="10" class="text-center">{{ __('no_result_found') }}</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
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
{{-- No JS needed since AJAX is removed --}}
@endsection
