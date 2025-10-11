@extends('admin.layouts.master')
@section('title', $title)
@section('content')

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="float-right">
    <a href="{{ route('admin.histories.index') }}" class="btn btn-primary btn-sm">
    <i class="fas fa-history"></i> Manage History
</a>
    <a href="{{ route('admin.admin.about-us.partners') }}" class="btn btn-primary btn-sm">
    <i class="fas fa-handshake"></i> Manage Partners
</a>

    <a href="{{route('admin.admin.about-us.accreditations')}}" class="btn btn-primary btn-sm">
        <i class="fas fa-certificate"></i> Manage Accreditations
    </a>
      <a href="{{route('admin.core-values.index')}}" class="btn btn-primary btn-sm">
        <i class="fas fa-certificate"></i> Manage Core Values
    </a>
</div>
            <div class="col-sm-12">
                <!-- Main Form - Wrapping all content including modals -->
            <form action="{{ route('admin.about-us.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf



 <input name="id" type="hidden" value="{{ isset($row->id) ? $row->id : -1 }}">
    
    <!-- Add a test field -->
    <input type="hidden" name="debug_test" value="form_is_working">

                    <div class="card">
                      
                        
                        <!-- Main Form Fields -->
                        <div class="card-block">
                            <div class="row">
                                <input name="id" type="hidden" value="{{ isset($row->id) ? $row->id : -1 }}">

                                <div class="form-group col-md-6">
                                    <label for="label">{{ __('field_label') }} <span>*</span></label>
                                    <input type="text" class="form-control" name="label" id="label" value="{{ isset($row->label) ? $row->label : '' }}" required>
                                    <div class="invalid-feedback">
                                        {{ __('required_field') }} {{ __('field_label') }}
                                    </div>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="title">{{ __('field_title') }} <span>*</span></label>
                                    <input type="text" class="form-control" name="title" id="title" value="{{ isset($row->title) ? $row->title : '' }}" required>
                                    <div class="invalid-feedback">
                                        {{ __('required_field') }} {{ __('field_title') }}
                                    </div>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="short_desc">{{ __('field_short_desc') }}</label>
                                    <textarea name="short_desc" id="short_desc" class="form-control texteditor">{{ isset($row->short_desc) ? $row->short_desc : '' }}</textarea>
                                    <div class="invalid-feedback">
                                        {{ __('required_field') }} {{ __('field_short_desc') }}
                                    </div>
                                </div>

                                <div class="form-group col-md-12">
                                    <label for="description">{{ __('field_description') }} <span>*</span></label>
                                    <textarea name="description" id="description" class="form-control texteditor" required>{{ isset($row->description) ? $row->description : '' }}</textarea>
                                    <div class="invalid-feedback">
                                        {{ __('required_field') }} {{ __('field_description') }}
                                    </div>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="button_text">{{ __('field_button_text') }}</label>
                                    <input type="text" class="form-control" name="button_text" id="button_text" value="{{ isset($row->button_text) ? $row->button_text : '' }}">
                                    <div class="invalid-feedback">
                                        {{ __('required_field') }} {{ __('field_button_text') }}
                                    </div>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="video_id">{{ __('field_video_id') }}</label>
                                    <input type="text" class="form-control" name="video_id" id="video_id" value="{{ isset($row->video_id) ? $row->video_id : '' }}">
                                    <div class="invalid-feedback">
                                        {{ __('required_field') }} {{ __('field_video_id') }}
                                    </div>
                                </div>

                                <div class="form-group col-md-12">
                                    @if(isset($row->attach) && is_file('uploads/'.$path.'/'.$row->attach))
                                        <img src="{{ asset('uploads/'.$path.'/'.$row->attach) }}" class="img-fluid" style="max-height: 300px; max-width: 100%;" alt="{{ __('field_attach') }}">
                                        <div class="clearfix"></div>
                                    @endif
                                    <label for="attach">{{ __('field_attach') }}: <span>{{ __('image_size', ['height' => 800, 'width' => 'Any']) }}</span></label>
                                    <input type="file" class="form-control" name="attach" id="attach">
                                    <div class="invalid-feedback">
                                        {{ __('required_field') }} {{ __('field_attach') }}
                                    </div>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="mission_title">{{ __('field_mission_title') }}</label>
                                    <input type="text" class="form-control" name="mission_title" id="mission_title" value="{{ isset($row->mission_title) ? $row->mission_title : '' }}">
                                    <div class="invalid-feedback">
                                        {{ __('required_field') }} {{ __('field_mission_title') }}
                                    </div>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="vision_title">{{ __('field_vision_title') }}</label>
                                    <input type="text" class="form-control" name="vision_title" id="vision_title" value="{{ isset($row->vision_title) ? $row->vision_title : '' }}">
                                    <div class="invalid-feedback">
                                        {{ __('required_field') }} {{ __('field_vision_title') }}
                                    </div>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="mission_desc">{{ __('field_mission_desc') }}</label>
                                    <textarea name="mission_desc" id="mission_desc" class="form-control texteditor">{{ isset($row->mission_desc) ? $row->mission_desc : '' }}</textarea>
                                    <div class="invalid-feedback">
                                        {{ __('required_field') }} {{ __('field_mission_desc') }}
                                    </div>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="vision_desc">{{ __('field_vision_desc') }}</label>
                                    <textarea name="vision_desc" id="vision_desc" class="form-control texteditor">{{ isset($row->vision_desc) ? $row->vision_desc : '' }}</textarea>
                                    <div class="invalid-feedback">
                                        {{ __('required_field') }} {{ __('field_vision_desc') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> {{ __('btn_update') }}</button>
                        </div>
                    </div>

                    <!-- ============ MODALS ============ -->
                    <!-- All modals must be INSIDE the form tags -->
                    
                    <!-- History Modal -->
                    <div class="modal fade" id="historyModal" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Manage History Timeline</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div id="historyContainer">
                                        @if(isset($row) && $row->histories->count() > 0)
                                            @foreach($row->histories as $index => $history)
                                            <div class="history-item mb-4 border p-3">
                                                <div class="row">
                                                    <input type="hidden" name="histories[{{$index}}][id]" value="{{ $history->id }}">
                                                    <div class="form-group col-md-2">
                                                        <label>Year</label>
                                                        <input type="text" class="form-control" name="histories[{{$index}}][year]" value="{{ $history->year }}" required>
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label>Title</label>
                                                        <input type="text" class="form-control" name="histories[{{$index}}][title]" value="{{ $history->title }}" required>
                                                    </div>
                                                    <div class="form-group col-md-5">
                                                        <label>Image</label>
                                                        <input type="file" class="form-control" name="histories[{{$index}}][image]">
                                                        @if($history->image)
                                                            <img src="{{ asset('uploads/about-us/history/'.$history->image) }}" class="img-thumbnail mt-2" style="max-height: 50px;">
                                                        @endif
                                                    </div>
                                                    <div class="form-group col-md-1 d-flex align-items-end">
                                                        <button type="button" class="btn btn-sm btn-danger remove-history">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label>Description</label>
                                                        <textarea class="form-control" name="histories[{{$index}}][description]">{{ $history->description }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        @else
                                            <!-- Default empty form -->
                                            <div class="history-item mb-4 border p-3">
                                                <div class="row">
                                                    <input type="hidden" name="histories[0][id]" value="">
                                                    <div class="form-group col-md-2">
                                                        <label>Year</label>
                                                        <input type="text" class="form-control" name="histories[0][year]" required>
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label>Title</label>
                                                        <input type="text" class="form-control" name="histories[0][title]" required>
                                                    </div>
                                                    <div class="form-group col-md-5">
                                                        <label>Image</label>
                                                        <input type="file" class="form-control" name="histories[0][image]">
                                                    </div>
                                                    <div class="form-group col-md-1 d-flex align-items-end">
                                                        <button type="button" class="btn btn-sm btn-danger remove-history">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label>Description</label>
                                                        <textarea class="form-control" name="histories[0][description]"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" id="addHistory">
                                        <i class="fas fa-plus"></i> Add Another History Item
                                    </button>
                                      <button type="button" class="btn btn-success" id="saveHistory">
                    <i class="fas fa-save"></i> Save History
                </button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Partners Modal -->
                    <div class="modal fade" id="partnersModal" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Manage Partners</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div id="partnersContainer">
                                        @if(isset($row) && $row->partners->count() > 0)
                                            @foreach($row->partners as $index => $partner)
                                            <div class="partner-item mb-4 border p-3">
                                                <div class="row">
                                                    <input type="hidden" name="partners[{{$index}}][id]" value="{{ $partner->id }}">
                                                    <div class="form-group col-md-4">
                                                        <label>Name</label>
                                                        <input type="text" class="form-control" name="partners[{{$index}}][name]" value="{{ $partner->name }}" required>
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label>Logo</label>
                                                        <input type="file" class="form-control" name="partners[{{$index}}][logo]">
                                                        @if($partner->logo)
                                                            <img src="{{ asset('uploads/about-us/partners/'.$partner->logo) }}" class="img-thumbnail mt-2" style="max-height: 50px;">
                                                        @endif
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label>Website URL</label>
                                                        <input type="url" class="form-control" name="partners[{{$index}}][url]" value="{{ $partner->url }}">
                                                    </div>
                                                    <div class="form-group col-md-2 d-flex align-items-end">
                                                        <button type="button" class="btn btn-sm btn-danger remove-partner">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        @else
                                            <!-- Default empty form -->
                                            <div class="partner-item mb-4 border p-3">
                                                <div class="row">
                                                    <input type="hidden" name="partners[0][id]" value="">
                                                    <div class="form-group col-md-4">
                                                        <label>Name</label>
                                                        <input type="text" class="form-control" name="partners[0][name]" required>
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label>Logo</label>
                                                        <input type="file" class="form-control" name="partners[0][logo]">
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label>Website URL</label>
                                                        <input type="url" class="form-control" name="partners[0][url]">
                                                    </div>
                                                    <div class="form-group col-md-2 d-flex align-items-end">
                                                        <button type="button" class="btn btn-sm btn-danger remove-partner">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" id="addPartner">
                                        <i class="fas fa-plus"></i> Add Another Partner
                                    </button>
   <button type="button" class="btn btn-success" id="savePartners">
                    <i class="fas fa-save"></i> Save Partners
                </button>



                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Accreditations Modal -->
                    <div class="modal fade" id="accreditationsModal" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Manage Accreditations</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div id="accreditationsContainer">
                                        @if(isset($row) && $row->accreditations->count() > 0)
                                            @foreach($row->accreditations as $index => $accreditation)
                                            <div class="accreditation-item mb-4 border p-3">
                                                <div class="row">
                                                    <input type="hidden" name="accreditations[{{$index}}][id]" value="{{ $accreditation->id }}">
                                                    <div class="form-group col-md-4">
                                                        <label>Name</label>
                                                        <input type="text" class="form-control" name="accreditations[{{$index}}][name]" value="{{ $accreditation->name }}" required>
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label>Logo</label>
                                                        <input type="file" class="form-control" name="accreditations[{{$index}}][logo]">
                                                        @if($accreditation->logo)
                                                            <img src="{{ asset('uploads/about-us/accreditations/'.$accreditation->logo) }}" class="img-thumbnail mt-2" style="max-height: 50px;">
                                                        @endif
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label>Description</label>
                                                        <textarea class="form-control" name="accreditations[{{$index}}][description]">{{ $accreditation->description }}</textarea>
                                                    </div>
                                                    <div class="form-group col-md-1 d-flex align-items-end">
                                                        <button type="button" class="btn btn-sm btn-danger remove-accreditation">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        @else
                                            <!-- Default empty form -->
                                            <div class="accreditation-item mb-4 border p-3">
                                                <div class="row">
                                                    <input type="hidden" name="accreditations[0][id]" value="">
                                                    <div class="form-group col-md-4">
                                                        <label>Name</label>
                                                        <input type="text" class="form-control" name="accreditations[0][name]" required>
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label>Logo</label>
                                                        <input type="file" class="form-control" name="accreditations[0][logo]">
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label>Description</label>
                                                        <textarea class="form-control" name="accreditations[0][description]"></textarea>
                                                    </div>
                                                    <div class="form-group col-md-1 d-flex align-items-end">
                                                        <button type="button" class="btn btn-sm btn-danger remove-accreditation">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" id="addAccreditation">
                                        <i class="fas fa-plus"></i> Add Another Accreditation
                                    </button>

   <button type="button" class="btn btn-success" id="saveAccreditations">
                    <i class="fas fa-save"></i> Save Accreditations
                </button>


                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </form> <!-- Closing form tag -->
            </div>
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>

<!-- JavaScript -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

<script>
$(document).ready(function() {
    // Initialize indices
    let historyIndex = {{ isset($row) && $row->histories->count() > 0 ? $row->histories->count() : 1 }};
    let partnerIndex = {{ isset($row) && $row->partners->count() > 0 ? $row->partners->count() : 1 }};
    let accreditationIndex = {{ isset($row) && $row->accreditations->count() > 0 ? $row->accreditations->count() : 1 }};
$('#saveHistory, #savePartners, #saveAccreditations').click(function() {
        // Just close the modal - data is already part of the main form
        $(this).closest('.modal').modal('hide');
        
        // Optional: Show a message that changes will be saved when main form is submitted
        Toastr.info('Changes will be saved when you submit the main form');
    });
    // Add History Item
    $('#addHistory').click(function() {
        let html = `
        <div class="history-item mb-4 border p-3">
            <div class="row">
                <input type="hidden" name="histories[${historyIndex}][id]" value="">
                <div class="form-group col-md-2">
                    <label>Year</label>
                    <input type="text" class="form-control" name="histories[${historyIndex}][year]" required>
                </div>
                <div class="form-group col-md-4">
                    <label>Title</label>
                    <input type="text" class="form-control" name="histories[${historyIndex}][title]" required>
                </div>
                <div class="form-group col-md-5">
                    <label>Image</label>
                    <input type="file" class="form-control" name="histories[${historyIndex}][image]">
                </div>
                <div class="form-group col-md-1 d-flex align-items-end">
                    <button type="button" class="btn btn-sm btn-danger remove-history">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
                <div class="form-group col-md-12">
                    <label>Description</label>
                    <textarea class="form-control" name="histories[${historyIndex}][description]"></textarea>
                </div>
            </div>
        </div>`;
        $('#historyContainer').append(html);
        historyIndex++;
    });

    // Add Partner
    $('#addPartner').click(function() {
        let html = `
        <div class="partner-item mb-4 border p-3">
            <div class="row">
                <input type="hidden" name="partners[${partnerIndex}][id]" value="">
                <div class="form-group col-md-4">
                    <label>Name</label>
                    <input type="text" class="form-control" name="partners[${partnerIndex}][name]" required>
                </div>
                <div class="form-group col-md-3">
                    <label>Logo</label>
                    <input type="file" class="form-control" name="partners[${partnerIndex}][logo]">
                </div>
                <div class="form-group col-md-3">
                    <label>Website URL</label>
                    <input type="url" class="form-control" name="partners[${partnerIndex}][url]">
                </div>
                <div class="form-group col-md-2 d-flex align-items-end">
                    <button type="button" class="btn btn-sm btn-danger remove-partner">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        </div>`;
        $('#partnersContainer').append(html);
        partnerIndex++;
    });

    // Add Accreditation
    $('#addAccreditation').click(function() {
        let html = `
        <div class="accreditation-item mb-4 border p-3">
            <div class="row">
                <input type="hidden" name="accreditations[${accreditationIndex}][id]" value="">
                <div class="form-group col-md-4">
                    <label>Name</label>
                    <input type="text" class="form-control" name="accreditations[${accreditationIndex}][name]" required>
                </div>
                <div class="form-group col-md-3">
                    <label>Logo</label>
                    <input type="file" class="form-control" name="accreditations[${accreditationIndex}][logo]">
                </div>
                <div class="form-group col-md-4">
                    <label>Description</label>
                    <textarea class="form-control" name="accreditations[${accreditationIndex}][description]"></textarea>
                </div>
                <div class="form-group col-md-1 d-flex align-items-end">
                    <button type="button" class="btn btn-sm btn-danger remove-accreditation">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        </div>`;
        $('#accreditationsContainer').append(html);
        accreditationIndex++;
    });

    // Remove items with protection against empty state
    $(document).on('click', '.remove-history', function() {
        if($('.history-item').length > 1) {
            $(this).closest('.history-item').remove();
        } else {
            alert('You must have at least one history entry.');
        }
    });
    
    $(document).on('click', '.remove-partner', function() {
        if($('.partner-item').length > 1) {
            $(this).closest('.partner-item').remove();
        } else {
            alert('You must have at least one partner entry.');
        }
    });
    
    $(document).on('click', '.remove-accreditation', function() {
        if($('.accreditation-item').length > 1) {
            $(this).closest('.accreditation-item').remove();
        } else {
            alert('You must have at least one accreditation entry.');
        }
    });

    // Form validation before submission
    $('form').submit(function(e) {
        let isValid = true;
        
        // Validate required fields in main form
        $('input[required], textarea[required]', this).each(function() {
            if (!$(this).val()) {
                $(this).addClass('is-invalid');
                isValid = false;
            }
        });
        
        // Validate at least one item in each section
        if ($('.history-item').length === 0 || 
            $('.partner-item').length === 0 || 
            $('.accreditation-item').length === 0) {
            alert('Please add at least one item to each section');
            isValid = false;
        }
        
        if (!isValid) {
            e.preventDefault();
            Toastr.error('Please fill all required fields');
            return false;
        }
        
        return true;
    });
});
</script>

@endsection