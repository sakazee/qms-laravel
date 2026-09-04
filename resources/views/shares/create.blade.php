@extends('layouts.app')
@section('title', __('shares.create'))
@section('page-title', __('shares.create'))
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('shares.index') }}">{{ __('shares.shares') }}</a></li>
    <li class="breadcrumb-item active">{{ __('shares.create') }}</li>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h3 class="card-title mb-0"><i class="fas fa-plus mr-2"></i>{{ __('shares.create') }}</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('shares.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ __('animals.animal') }} <span class="text-danger">*</span></label>
                                <select name="animal_id" id="animal_select" class="form-control select2 @error('animal_id') is-invalid @enderror" required>
                                    <option value="">-- {{ app()->getLocale() === 'bn' ? 'পশু নির্বাচন করুন' : 'Select Animal' }} --</option>
                                    @foreach($animals as $animal)
                                    <option value="{{ $animal->id }}" {{ old('animal_id') == $animal->id ? 'selected' : '' }}>
                                        {{ $animal->type_name }} {{ $animal->name ? '— ' . $animal->name : '' }}
                                        ({{ app()->getLocale() === 'bn' ? 'বাকি' : 'Avail' }}: {{ $animal->available_shares }})
                                    </option>
                                    @endforeach
                                </select>
                                @error('animal_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ __('partners.partner') }} <span class="text-danger">*</span></label>
                                <select name="partner_id" class="form-control select2 @error('partner_id') is-invalid @enderror" required>
                                    <option value="">-- {{ app()->getLocale() === 'bn' ? 'অংশীদার নির্বাচন করুন' : 'Select Partner' }} --</option>
                                    @foreach($partners as $partner)
                                    <option value="{{ $partner->id }}" {{ old('partner_id') == $partner->id ? 'selected' : '' }}>{{ $partner->name }}</option>
                                    @endforeach
                                </select>
                                @error('partner_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>

                    {{-- Animal Info Panel --}}
                    <div id="animal_info" class="alert alert-info d-none">
                        <div class="row text-center">
                            <div class="col-3"><strong id="info_total"></strong><br><small>{{ __('animals.total_shares') }}</small></div>
                            <div class="col-3"><strong id="info_assigned"></strong><br><small>{{ __('animals.assigned_shares') }}</small></div>
                            <div class="col-3"><strong id="info_available"></strong><br><small>{{ __('animals.available_shares') }}</small></div>
                            <div class="col-3"><strong id="info_price"></strong><br><small>{{ __('animals.share_price') }}</small></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ __('shares.shares_count') }} <span class="text-danger">*</span></label>
                                <input type="number" name="shares" id="shares_input"
                                       value="{{ old('shares', 1) }}"
                                       class="form-control @error('shares') is-invalid @enderror"
                                       min="1" max="7" required>
                                @error('shares')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ __('shares.share_amount') }}</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text">৳</span></div>
                                    <input type="text" id="calc_amount" class="form-control" readonly
                                           placeholder="{{ app()->getLocale() === 'bn' ? 'স্বয়ংক্রিয়' : 'Auto' }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>{{ __('messages.notes') }}</label>
                        <textarea name="notes" rows="2" class="form-control">{{ old('notes') }}</textarea>
                    </div>

                    <div class="d-flex justify-content-between mt-3">
                        <a href="{{ route('shares.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left mr-1"></i>{{ __('messages.back') }}</a>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i>{{ __('messages.save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let animalData = null;

$('#animal_select').on('change', function() {
    const id = $(this).val();
    if (!id) { $('#animal_info').addClass('d-none'); animalData = null; return; }

    $.getJSON(`/api/animal/${id}/info`, function(data) {
        animalData = data;
        $('#info_total').text(data.total_shares);
        $('#info_assigned').text(data.assigned_shares);
        $('#info_available').text(data.available_shares);
        $('#info_price').text('৳' + parseFloat(data.share_price).toLocaleString());
        $('#shares_input').attr('max', data.is_large ? Math.min(7, data.available_shares) : 1);
        if (!data.is_large) { $('#shares_input').val(1).prop('readonly', true); }
        else { $('#shares_input').prop('readonly', false); }
        $('#animal_info').removeClass('d-none');
        calcAmount();
    });
});

$('#shares_input').on('input', calcAmount);

function calcAmount() {
    if (!animalData) return;
    const shares = parseInt($('#shares_input').val()) || 0;
    const amount = shares * parseFloat(animalData.share_price);
    $('#calc_amount').val(amount > 0 ? amount.toFixed(2) : '');
}
</script>
@endpush
