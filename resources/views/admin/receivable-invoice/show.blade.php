<!-- Show modal content -->
<div id="showModal-{{ $row->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">{{ __('modal_view') }} {{ $title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <!-- Details View Start -->
                <h4><mark class="text-primary">Invoice:</mark> {{ $row->invoice_no }}</h4>
                <hr/>
                <div class="">
                    <div class="row">
                        <div class="col-md-6">
                            <p><mark class="text-primary">{{ __('field_payer_type') }}:</mark> 
                                @if($row->payer_type == 'student')
                                <span class="badge badge-pill badge-primary">{{ __('field_student') }}</span>
                                @elseif($row->payer_type == 'staff')
                                <span class="badge badge-pill badge-info">{{ __('field_staff') }}</span>
                                @else
                                <span class="badge badge-pill badge-secondary">{{ __('field_outsider') }}</span>
                                @endif
                            </p><hr/>

                            <p><mark class="text-primary">{{ __('field_payer') }}:</mark> 
                                @if($row->payer_type == 'student' && $row->student)
                                    {{ $row->student->first_name }} {{ $row->student->last_name }}
                                    <br><small class="text-muted">ID: {{ $row->student->student_id }}</small>
                                    @if($row->student->email)
                                    <br><small class="text-muted">Email: {{ $row->student->email }}</small>
                                    @endif
                                    @if($row->student->phone)
                                    <br><small class="text-muted">Phone: {{ $row->student->phone }}</small>
                                    @endif
                                @elseif($row->payer_type == 'staff' && $row->staff)
                                    {{ $row->staff->first_name }} {{ $row->staff->last_name }}
                                    <br><small class="text-muted">ID: {{ $row->staff->staff_id }}</small>
                                    @if($row->staff->email)
                                    <br><small class="text-muted">Email: {{ $row->staff->email }}</small>
                                    @endif
                                    @if($row->staff->phone)
                                    <br><small class="text-muted">Phone: {{ $row->staff->phone }}</small>
                                    @endif
                                @else
                                    {{ $row->payer_name }}
                                    @if($row->payer_email)
                                    <br><small class="text-muted">Email: {{ $row->payer_email }}</small>
                                    @endif
                                    @if($row->payer_phone)
                                    <br><small class="text-muted">Phone: {{ $row->payer_phone }}</small>
                                    @endif
                                @endif
                            </p><hr/>

                            <p><mark class="text-primary">{{ __('field_title') }}:</mark> {{ $row->title }}</p><hr/>
                        </div>
                        <div class="col-md-6">
                            <p><mark class="text-primary">{{ __('field_amount') }}:</mark> {{ round($row->amount, $setting->decimal_place ?? 2) }} {!! $setting->currency_symbol !!}</p><hr/>
                            
                            <p><mark class="text-primary">{{ __('field_date') }}:</mark> 
                                @if(isset($setting->date_format))
                                {{ date($setting->date_format, strtotime($row->date)) }}
                                @else
                                {{ date("Y-m-d", strtotime($row->date)) }}
                                @endif
                            </p><hr/>

                            <p><mark class="text-primary">{{ __('field_due_date') }}:</mark> 
                                @if($row->due_date)
                                    @if(isset($setting->date_format))
                                    {{ date($setting->date_format, strtotime($row->due_date)) }}
                                    @else
                                    {{ date("Y-m-d", strtotime($row->due_date)) }}
                                    @endif
                                @else
                                N/A
                                @endif
                            </p><hr/>

                            <p><mark class="text-primary">{{ __('field_status') }}:</mark> 
                                @if($row->status == 1)
                                <span class="badge badge-pill badge-success">{{ __('status_active') }}</span>
                                @else
                                <span class="badge badge-pill badge-danger">{{ __('status_inactive') }}</span>
                                @endif
                            </p><hr/>
                        </div>
                        <div class="col-md-12">
                            <p><mark class="text-primary">{{ __('field_description') }}:</mark> {!! $row->description ?? 'N/A' !!}</p><hr/>
                        </div>
                        <div class="col-md-6">
                            <p><mark class="text-primary">{{ __('field_created_by') }}:</mark> {{ $row->createdBy->first_name ?? '' }} {{ $row->createdBy->last_name ?? '' }}</p><hr/>
                        </div>
                        <div class="col-md-6">
                            <p><mark class="text-primary">{{ __('field_updated_by') }}:</mark> {{ $row->updatedBy->first_name ?? '' }} {{ $row->updatedBy->last_name ?? '' }}</p><hr/>
                        </div>
                    </div>
                </div>
                <!-- Details View End -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times"></i> {{ __('btn_close') }}</button>
            </div>
        </div>
    </div>
</div>