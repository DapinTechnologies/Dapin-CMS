<div class="form-group col-md-3">
    <label for="program_id">{{ __('field_program') }} <span>*</span></label>
    <select class="form-control select2" name="program_id" id="program_id" required>
        <option value="">{{ __('select') }}</option>
        @foreach($programs as $program)
            <option value="{{ $program->id }}" @if(old('program_id', $default->program_id ?? '') == $program->id) selected @endif>
                {{ $program->title }}
            </option>
        @endforeach
    </select>

    <div class="invalid-feedback">
        {{ __('required_field') }} {{ __('field_program') }}
    </div>
</div>

<div class="form-group col-md-3">
    <label for="exam_type">{{ __('field_exam_type') }} <span>*</span></label>
    <select class="form-control select2" name="exam_type" id="exam_type" required>
        <option value="">{{ __('select') }}</option>
        @foreach($types as $type)
            <option value="{{ $type->id }}" @if(old('exam_type', $default->exam_type_id ?? '') == $type->id) selected @endif>
                {{ $type->title }}
            </option>
        @endforeach
    </select>

    <div class="invalid-feedback">
        {{ __('required_field') }} {{ __('field_exam_type') }}
    </div>
</div>

<div class="form-group col-md-2">
    <label for="start_date">{{ __('field_start_date') }} <span>*</span></label>
    <input type="date" class="form-control" name="start_date" id="start_date" value="{{ old('start_date', $default->start_date ?? '') }}" required>

    <div class="invalid-feedback">
        {{ __('required_field') }} {{ __('field_start_date') }}
    </div>
</div>

<div class="form-group col-md-2">
    <label for="end_date">{{ __('field_end_date') }} <span>*</span></label>
    <input type="date" class="form-control" name="end_date" id="end_date" value="{{ old('end_date', $default->end_date ?? '') }}" required>

    <div class="invalid-feedback">
        {{ __('required_field') }} {{ __('field_end_date') }}
    </div>
</div>
