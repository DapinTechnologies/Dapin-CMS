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
                <h4><mark class="text-primary">Billing:</mark> {{ $row->billing_no }}</h4>
                <hr/>
                <div class="">
                    <div class="row">
                        <div class="col-md-6">
                            <p><mark class="text-primary">{{ __('field_supplier') }}:</mark> {{ $row->supplier->title ?? '' }}</p><hr/>
                            <p><mark class="text-primary">{{ __('field_title') }}:</mark> {{ $row->title }}</p><hr/>
                            <p><mark class="text-primary">{{ __('field_amount') }}:</mark> {{ round($row->amount, $setting->decimal_place ?? 2) }} {!! $setting->currency_symbol !!}</p><hr/>
                        </div>
                        <div class="col-md-6">
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