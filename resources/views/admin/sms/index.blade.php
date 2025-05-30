@extends('admin.layouts.master')
@section('title', $title)
@section('content')

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->

        <!-- Back to Dashboard Button at the top -->
        <div class="mt-3 mb-3">
            <a href="{{ route('admin.dashboard.index') }}" class="btn btn-secondary">{{ __('Back to Dashboard') }}</a>
        </div>

        <div class="row">
            <div class="card-block">
                <form class="needs-validation" novalidate method="get" action="{{ route('sms.search') }}">
                    @csrf
                    <div class="row gx-2">
                        <div class="form-group col-md-6">
                            <label for="phone">{{ __('Phone Number') }}</label>
                            <input type="text" class="form-control" name="phone" id="phone">
                            <div class="invalid-feedback">
                                {{ __('required_field') }} {{ __('Phone Number') }}
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="message_type">{{ __('Message Type') }}</label>
                            <select class="form-control" name="message_type" id="message_type">
                                <option value="">{{ __('All') }}</option>
                                <option value="individual">{{ __('Individual') }}</option>
                                <option value="bulk">{{ __('Bulk') }}</option>
                            </select>
                        </div>
                        <div class="form-group col-md-2 d-flex align-items-end">
                            <button type="submit" class="btn btn-info btn-sm btn-filter mr-2"><i class="fas fa-search"></i> {{ __('') }}</button>
                            <a href="{{ route('sms.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-sync-alt"></i> {{ __('') }}</a>
                        </div>
                    </div>
                </form>
            </div>
            @php use Carbon\Carbon; @endphp
                
                    
            
            <div class="col-sm-12">
                <div class="card">        
                    @php 
                    $count = \App\Models\SmsMessage::count(); 
                    @endphp 
              
                    <div class="card-block">
                      
                        <!-- [ Data table ] start -->
                        <div class="table-responsive">
                            <div class="export-icons text-lg-center"> Total Messages Sent
                                <span class="badge badge-warning"> {{$count}}</span>
                            </div>
                            <table id="export-table" class="display table nowrap table-striped table-hover" style="width:100%">
                              
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Phone Number</th>
                                        <th>Message</th>
                                        {{-- <th>Status</th> --}}
                                        <th>Sent At</th>
                                        <th>Type</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($filteredMessages as $message)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $message->phone_number }}</td>
                                            <td>{{ Str::words($message->message, 10 ) }}</td>

                                             {{-- <td> <span class="badge {{ $message->status == 'Success' ? 'badge-success' : 'badge-danger' }}">
                                                {{ $message->status }} </span> </td> --}}
                                                 <td>{{ Carbon::parse($message->sent_at)->format('H:i, d-m-Y') }}</td>
                                            <td>{{ $message->is_bulk ? 'Bulk' : 'Individual' }}</td>
                                            <td>
                                                @can($access.'-view') <a href="{{ route('sms.show', $message->id) }}" 
                                                    class="btn btn-icon btn-primary btn-sm"> <i class="far fa-eye"></i> </a> @endcan

                                               
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- [ Data table ] end -->
                    </div>
                </div>
            </div>
        </div>
        <!-- [ Main Content ] end -->
        
        <!-- Back to Dashboard Button at the bottom -->
        <div class="mt-3">
            <a href="{{ route('admin.dashboard.index') }}" class="btn btn-secondary">{{ __('Back to Dashboard') }}</a>
        </div>
    </div>
</div>
<!-- End Content-->

@endsection

@section('page_js')
<script type="text/javascript">
"use strict";
$(".faculty").on('change',function(e){
    e.preventDefault();
    var program=$(".program");
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $.ajax({
      type:'POST',
      url: "{{ route('filter-program') }}",
      data:{
        _token:$('input[name=_token]').val(),
        faculty:$(this).val()
      },
      success:function(response){
          // var jsonData=JSON.parse(response);
          $('option', program).remove();
          $('.program').append('<option value="0">{{ __("all") }}</option>');
          $.each(response, function(){
            $('<option/>', {
              'value': this.id,
              'text': this.title
            }).appendTo('.program');
          });
        }

    });
  });
</script>
@endsection
