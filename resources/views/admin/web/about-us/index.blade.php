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
                <!-- Success/Error Messages -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <!-- Main Form - Wrapping all content including modals -->
                <form action="{{ route('admin.about-us.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input name="id" type="hidden" value="{{ isset($row->id) ? $row->id : -1 }}">

                    <div class="card">
                        <div class="card-header">
                            <h5>About Us Content</h5>
                            <div class="float-right">
                                @if(isset($row) && $row->id)
                                    <span class="badge badge-success">Editing Existing Content</span>
                                @else
                                    <span class="badge badge-primary">Creating New Content</span>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Main Form Fields -->
                        <div class="card-block">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="label">Label <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('label') is-invalid @enderror" 
                                           name="label" id="label" 
                                           value="{{ old('label', $row->label ?? '') }}" required>
                                    @error('label')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="title">Title <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                           name="title" id="title" 
                                           value="{{ old('title', $row->title ?? '') }}" required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-12">
                                    <label for="short_desc">Short Description</label>
                                    <textarea name="short_desc" id="short_desc" class="form-control @error('short_desc') is-invalid @enderror" 
                                              rows="3">{{ old('short_desc', $row->short_desc ?? '') }}</textarea>
                                    @error('short_desc')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-12">
                                    <label for="description">Full Description <span class="text-danger">*</span></label>
                                    <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" 
                                              rows="6" required>{{ old('description', $row->description ?? '') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="button_text">Button Text</label>
                                    <input type="text" class="form-control @error('button_text') is-invalid @enderror" 
                                           name="button_text" id="button_text" 
                                           value="{{ old('button_text', $row->button_text ?? '') }}">
                                    @error('button_text')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="video_id">Video ID</label>
                                    <input type="text" class="form-control @error('video_id') is-invalid @enderror" 
                                           name="video_id" id="video_id" 
                                           value="{{ old('video_id', $row->video_id ?? '') }}">
                                    <small class="form-text text-muted">YouTube video ID only</small>
                                    @error('video_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-12">
                                    <label for="attach">Featured Image</label>
                                    
                                    @if(isset($row->attach) && is_file('uploads/'.$path.'/'.$row->attach))
                                        <div class="mb-3">
                                            <img src="{{ asset('uploads/'.$path.'/'.$row->attach) }}" 
                                                 class="img-fluid rounded border" 
                                                 style="max-height: 200px; max-width: 100%;" 
                                                 alt="Current image">
                                            <div class="mt-2">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" 
                                                           name="remove_attach" id="remove_attach" value="1">
                                                    <label class="form-check-label text-danger" for="remove_attach">
                                                        <i class="fas fa-trash"></i> Remove current image
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    
                                    <input type="file" class="form-control @error('attach') is-invalid @enderror" 
                                           name="attach" id="attach" 
                                           accept="image/jpeg,image/png,image/jpg,image/gif">
                                    <small class="form-text text-muted">
                                        Recommended size: 800px height, any width. Formats: JPEG, PNG, JPG, GIF. Max: 2MB
                                    </small>
                                    @error('attach')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="mission_title">Mission Title</label>
                                    <input type="text" class="form-control @error('mission_title') is-invalid @enderror" 
                                           name="mission_title" id="mission_title" 
                                           value="{{ old('mission_title', $row->mission_title ?? '') }}">
                                    @error('mission_title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="vision_title">Vision Title</label>
                                    <input type="text" class="form-control @error('vision_title') is-invalid @enderror" 
                                           name="vision_title" id="vision_title" 
                                           value="{{ old('vision_title', $row->vision_title ?? '') }}">
                                    @error('vision_title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="mission_desc">Mission Description</label>
                                    <textarea name="mission_desc" id="mission_desc" class="form-control @error('mission_desc') is-invalid @enderror" 
                                              rows="4">{{ old('mission_desc', $row->mission_desc ?? '') }}</textarea>
                                    @error('mission_desc')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="vision_desc">Vision Description</label>
                                    <textarea name="vision_desc" id="vision_desc" class="form-control @error('vision_desc') is-invalid @enderror" 
                                              rows="4">{{ old('vision_desc', $row->vision_desc ?? '') }}</textarea>
                                    @error('vision_desc')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> 
                                {{ isset($row) && $row->id ? 'Update' : 'Save' }} About Us Content
                            </button>
                            
                            @if(isset($row) && $row->id)
                                <a href="{{ route('admin.about-us.index') }}" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Create New
                                </a>
                            @endif
                            
                            <button type="reset" class="btn btn-secondary">
                                <i class="fas fa-undo"></i> Reset Form
                            </button>
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
        if(typeof Toastr !== 'undefined') {
            Toastr.info('Changes will be saved when you submit the main form');
        } else {
            alert('Changes will be saved when you submit the main form');
        }
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
        
        if (!isValid) {
            e.preventDefault();
            if(typeof Toastr !== 'undefined') {
                Toastr.error('Please fill all required fields');
            } else {
                alert('Please fill all required fields');
            }
            return false;
        }
        
        return true;
    });
});
</script>

@endsection