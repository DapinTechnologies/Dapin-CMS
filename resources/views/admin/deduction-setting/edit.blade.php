<!-- Edit modal content -->
<div id="editModal-{{ $row->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
          <form class="needs-validation" novalidate action="{{ route($route.'.update', $row->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">{{ __('modal_edit') }} {{ $title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <!-- Form Start -->
                <div class="form-group">
                    <label for="name" class="form-label">{{ __('field_name') }} <span>*</span></label>
                    <input type="text" class="form-control" name="name" id="name" value="{{ $row->name }}" required>

                    <div class="invalid-feedback">
                      {{ __('required_field') }} {{ __('field_name') }}
                    </div>
                </div>

                <div class="form-group">
                    <label for="type" class="form-label">{{ __('field_type') }} <span>*</span></label>
                    <select class="form-control" name="type" id="type-{{ $row->id }}" required onchange="toggleFields({{ $row->id }})">
                        <option value="">{{ __('select') }}</option>
                        <option value="fixed" {{ $row->type == 'fixed' ? 'selected' : '' }}>{{ __('field_fixed') }}</option>
                        <option value="rate" {{ $row->type == 'rate' ? 'selected' : '' }}>{{ __('field_rate') }}</option>
                        <option value="tiered" {{ $row->type == 'tiered' ? 'selected' : '' }}>{{ __('field_tiered') }}</option>
                    </select>

                    <div class="invalid-feedback">
                      {{ __('required_field') }} {{ __('field_type') }}
                    </div>
                </div>

                <!-- Fixed Amount Field -->
                <div class="form-group" id="fixed-field-{{ $row->id }}" style="display: {{ $row->type == 'fixed' ? 'block' : 'none' }};">
                    <label for="fixed_amount" class="form-label">{{ __('field_fixed_amount') }} ({!! $setting->currency_symbol !!}) <span>*</span></label>
                    <input type="text" class="form-control" name="fixed_amount" id="fixed_amount-{{ $row->id }}" value="{{ round($row->fixed_amount, 2) }}">

                    <div class="invalid-feedback">
                      {{ __('required_field') }} {{ __('field_fixed_amount') }}
                    </div>
                </div>

                <!-- Rate Fields -->
                <div id="rate-fields-{{ $row->id }}" style="display: {{ $row->type == 'rate' ? 'block' : 'none' }};">
                    <div class="form-group">
                        <label for="rate" class="form-label">{{ __('field_rate') }} (e.g., 0.0275) <span>*</span></label>
                        <input type="text" class="form-control" name="rate" id="rate-{{ $row->id }}" value="{{ $row->rate }}" placeholder="0.0275">

                        <div class="invalid-feedback">
                          {{ __('required_field') }} {{ __('field_rate') }}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="min_salary" class="form-label">{{ __('field_min_salary') }} ({!! $setting->currency_symbol !!}) <span>*</span></label>
                        <input type="text" class="form-control" name="min_salary" id="min_salary-{{ $row->id }}" value="{{ round($row->min_salary, 2) }}" placeholder="25000">

                        <div class="invalid-feedback">
                          {{ __('required_field') }} {{ __('field_min_salary') }}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="max_salary" class="form-label">{{ __('field_max_salary') }} ({!! $setting->currency_symbol !!})</label>
                        <input type="text" class="form-control" name="max_salary" id="max_salary-{{ $row->id }}" value="{{ round($row->max_salary, 2) }}" placeholder="Optional">

                        <div class="invalid-feedback">
                          {{ __('field_max_salary') }}
                        </div>
                    </div>
                </div>

                <!-- Tiered Fields -->
                <div id="tiered-fields-{{ $row->id }}" style="display: {{ $row->type == 'tiered' ? 'block' : 'none' }};">
                    <div class="form-group">
                        <label for="min_amount" class="form-label">{{ __('field_min_amount') }} ({!! $setting->currency_symbol !!}) <span>*</span></label>
                        <input type="text" class="form-control" name="min_amount" id="min_amount-{{ $row->id }}" value="{{ round($row->min_amount, 2) }}">

                        <div class="invalid-feedback">
                          {{ __('required_field') }} {{ __('field_min_amount') }}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="max_amount" class="form-label">{{ __('field_max_amount') }} ({!! $setting->currency_symbol !!}) <span>*</span></label>
                        <input type="text" class="form-control" name="max_amount" id="max_amount-{{ $row->id }}" value="{{ round($row->max_amount, 2) }}">

                        <div class="invalid-feedback">
                          {{ __('required_field') }} {{ __('field_max_amount') }}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="percentage" class="form-label">{{ __('field_percentage') }} (%) <span>*</span></label>
                        <input type="text" class="form-control" name="percentage" id="percentage-{{ $row->id }}" value="{{ round($row->percentage, 2) }}">

                        <div class="invalid-feedback">
                          {{ __('required_field') }} {{ __('field_percentage') }}
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="max_no_deduction_amount" class="form-label">{{ __('field_max_no_deduction_amount') }} ({!! $setting->currency_symbol !!})</label>
                    <input type="text" class="form-control" name="max_no_deduction_amount" id="max_no_deduction_amount-{{ $row->id }}" value="{{ round($row->max_no_deduction_amount, 2) }}">

                    <div class="invalid-feedback">
                      {{ __('field_max_no_deduction_amount') }}
                    </div>
                </div>

                <div class="form-group">
                    <label for="description" class="form-label">{{ __('field_description') }}</label>
                    <textarea class="form-control" name="description" id="description-{{ $row->id }}" rows="3">{{ $row->description }}</textarea>
                </div>

                <div class="form-group">
                    <div class="checkbox checkbox-primary">
                        <input type="checkbox" name="is_statutory" id="is_statutory-{{ $row->id }}" value="1" {{ $row->is_statutory ? 'checked' : '' }}>
                        <label for="is_statutory-{{ $row->id }}">{{ __('field_is_statutory') }}</label>
                    </div>
                </div>

                <div class="form-group">
                    <label for="status" class="form-label">{{ __('select_status') }}</label>
                    <select class="form-control" name="status" id="status">
                        <option value="1" {{ $row->status == 1 ? 'selected' : '' }}>{{ __('status_active') }}</option>
                        <option value="0" {{ $row->status == 0 ? 'selected' : '' }}>{{ __('status_inactive') }}</option>
                    </select>
                </div>
                <!-- Form End -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times"></i> {{ __('btn_close') }}</button>
                <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> {{ __('btn_update') }}</button>
            </div>

          </form>
        </div>
    </div>
</div>

<script>
function toggleFields(id) {
    const type = document.getElementById('type-' + id).value;
    const fixedField = document.getElementById('fixed-field-' + id);
    const rateFields = document.getElementById('rate-fields-' + id);
    const tieredFields = document.getElementById('tiered-fields-' + id);
    
    // Hide all fields first
    fixedField.style.display = 'none';
    rateFields.style.display = 'none';
    tieredFields.style.display = 'none';
    
    // Remove required from all fields
    document.getElementById('fixed_amount-' + id).removeAttribute('required');
    document.getElementById('rate-' + id).removeAttribute('required');
    document.getElementById('min_salary-' + id).removeAttribute('required');
    document.getElementById('min_amount-' + id).removeAttribute('required');
    document.getElementById('max_amount-' + id).removeAttribute('required');
    document.getElementById('percentage-' + id).removeAttribute('required');
    
    // Show relevant fields and set required
    if (type === 'fixed') {
        fixedField.style.display = 'block';
        document.getElementById('fixed_amount-' + id).setAttribute('required', 'required');
    } else if (type === 'rate') {
        rateFields.style.display = 'block';
        document.getElementById('rate-' + id).setAttribute('required', 'required');
        document.getElementById('min_salary-' + id).setAttribute('required', 'required');
    } else if (type === 'tiered') {
        tieredFields.style.display = 'block';
        document.getElementById('min_amount-' + id).setAttribute('required', 'required');
        document.getElementById('max_amount-' + id).setAttribute('required', 'required');
        document.getElementById('percentage-' + id).setAttribute('required', 'required');
    }
}
</script>