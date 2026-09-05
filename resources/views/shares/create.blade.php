@extends('layouts.app')
@section('title', __('shares.create'))
@section('page-title', __('shares.create'))
@section('breadcrumb')
    <span><a href="{{ route('shares.index') }}" class="hover:text-emerald-700">{{ __('shares.shares') }}</a></span>
    <i class="fa-solid fa-chevron-right text-[10px] text-gray-400"></i>
    <span class="text-gray-600">{{ __('shares.create') }}</span>
@endsection

@section('content')
<div class="mx-auto max-w-4xl">
    <div class="card">
        <div class="card-header bg-emerald-800">
            <h3 class="card-title text-white"><i class="fa-solid fa-plus"></i>{{ __('shares.create') }}</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('shares.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                    <div>
                        <label class="label">{{ __('animals.animal') }} <span class="text-rose-600">*</span></label>
                        <select name="animal_id" id="animal_select" class="input select2 @error('animal_id') border-rose-400 @enderror" required>
                            <option value="">-- {{ app()->getLocale() === 'bn' ? 'পশু নির্বাচন করুন' : 'Select Animal' }} --</option>
                            @foreach($animals as $animal)
                            <option value="{{ $animal->id }}" {{ old('animal_id') == $animal->id ? 'selected' : '' }}>
                                {{ $animal->type_name }} {{ $animal->name ? '— ' . $animal->name : '' }}
                                ({{ app()->getLocale() === 'bn' ? 'বাকি' : 'Avail' }}: {{ format_amount($animal->available_shares, 0) }})
                            </option>
                            @endforeach
                        </select>
                        @error('animal_id')<p class="mt-1 text-[12px] font-medium text-rose-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="label">{{ __('partners.partner') }} <span class="text-rose-600">*</span></label>
                        <select name="partner_id" class="input select2 @error('partner_id') border-rose-400 @enderror" required>
                            <option value="">-- {{ app()->getLocale() === 'bn' ? 'অংশীদার নির্বাচন করুন' : 'Select Partner' }} --</option>
                            @foreach($partners as $partner)
                            <option value="{{ $partner->id }}" {{ old('partner_id', request('partner_id')) == $partner->id ? 'selected' : '' }}>{{ $partner->name }}</option>
                            @endforeach
                        </select>
                        @error('partner_id')<p class="mt-1 text-[12px] font-medium text-rose-600">{{ $message }}</p>@enderror
                    </div>
                </div>

                {{-- Animal Info Panel --}}
                <div id="animal_info" class="alert alert-info d-none mt-5">
                    <div class="grid grid-cols-2 gap-4 text-center sm:grid-cols-4">
                        <div>
                            <div class="font-serif text-[17px] font-bold text-gray-900" id="info_total"></div>
                            <div class="text-[11.5px] font-semibold text-gray-500">{{ __('animals.total_shares') }}</div>
                        </div>
                        <div>
                            <div class="font-serif text-[17px] font-bold text-gray-900" id="info_assigned"></div>
                            <div class="text-[11.5px] font-semibold text-gray-500">{{ __('animals.assigned_shares') }}</div>
                        </div>
                        <div>
                            <div class="font-serif text-[17px] font-bold text-gray-900" id="info_available"></div>
                            <div class="text-[11.5px] font-semibold text-gray-500">{{ __('animals.available_shares') }}</div>
                        </div>
                        <div>
                            <div class="font-serif text-[17px] font-bold text-gray-900" id="info_price"></div>
                            <div class="text-[11.5px] font-semibold text-gray-500">{{ __('animals.share_price') }}</div>
                        </div>
                    </div>
                </div>

                <div class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-2">
                    <div>
                        <label class="label">{{ __('shares.shares_count') }} <span class="text-rose-600">*</span></label>
                        <input type="number" name="shares" id="shares_input"
                               value="{{ old('shares', 1) }}"
                               class="input @error('shares') border-rose-400 @enderror"
                               min="1" max="7" required>
                        @error('shares')<p class="mt-1 text-[12px] font-medium text-rose-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="label">{{ __('shares.share_amount') }}</label>
                        <div class="relative">
                            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-[13.5px] font-medium text-gray-500">৳</span>
                            <input type="text" id="calc_amount" class="input pl-8" readonly
                                   placeholder="{{ app()->getLocale() === 'bn' ? 'স্বয়ংক্রিয়' : 'Auto' }}">
                        </div>
                    </div>
                </div>

                <div class="mt-5">
                    <label class="label">{{ __('messages.notes') }}</label>
                    <textarea name="notes" rows="2" class="input resize-none">{{ old('notes') }}</textarea>
                </div>

                <div class="mt-6 flex items-center justify-between">
                    <a href="{{ route('shares.index') }}" class="btn btn-secondary">
                        <i class="fa-solid fa-arrow-left"></i>{{ __('messages.back') }}
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-save"></i>{{ __('messages.save') }}
                    </button>
                </div>
            </form>
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
        $('#info_total').text(window.qmsFmt(data.total_shares));
        $('#info_assigned').text(window.qmsFmt(data.assigned_shares));
        $('#info_available').text(window.qmsFmt(data.available_shares));
        $('#info_price').text('৳' + window.qmsFmt(parseFloat(data.share_price).toLocaleString()));
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
    $('#calc_amount').val(amount > 0 ? window.qmsFmt(amount.toFixed(2)) : '');
}
</script>
@endpush