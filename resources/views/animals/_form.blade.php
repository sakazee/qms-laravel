<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>{{ __('animals.type.label') }} <span class="text-danger">*</span></label>
            <select name="type" id="animal_type" class="form-control @error('type') is-invalid @enderror" required>
                <option value="">-- {{ app()->getLocale() === 'bn' ? 'ধরন নির্বাচন করুন' : 'Select Type' }} --</option>
                @foreach(['cow' => __('animals.type.cow'), 'buffalo' => __('animals.type.buffalo'), 'camel' => __('animals.type.camel'), 'goat' => __('animals.type.goat'), 'sheep' => __('animals.type.sheep'), 'other' => __('animals.type.other')] as $val => $label)
                <option value="{{ $val }}" {{ old('type', $animal->type ?? '') === $val ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
            @error('type')<div class="invalid-feedback">{{ $message }}</div>@enderror
            <small id="share_hint" class="form-text text-muted"></small>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>{{ __('animals.name') }}</label>
            <input type="text" name="name" value="{{ old('name', $animal->name ?? '') }}"
                   class="form-control" placeholder="{{ app()->getLocale() === 'bn' ? 'যেমন: কালো গরু' : 'e.g. Black Cow' }}">
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>{{ __('animals.total_shares') }} <span class="text-danger">*</span></label>
            <input type="number" name="total_shares" id="total_shares"
                   value="{{ old('total_shares', $animal->total_shares ?? 1) }}"
                   class="form-control @error('total_shares') is-invalid @enderror"
                   min="1" max="7" required>
            @error('total_shares')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>{{ __('animals.purchase_price') }} <span class="text-danger">*</span></label>
            <div class="input-group">
                <div class="input-group-prepend"><span class="input-group-text">৳</span></div>
                <input type="number" name="purchase_price" id="purchase_price"
                       value="{{ old('purchase_price', $animal->purchase_price ?? '') }}"
                       class="form-control @error('purchase_price') is-invalid @enderror"
                       min="0" step="0.01" required>
            </div>
            @error('purchase_price')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>{{ __('animals.status.label') }} <span class="text-danger">*</span></label>
            <select name="status" class="form-control @error('status') is-invalid @enderror" required>
                @foreach(['pending' => __('animals.status.pending'), 'purchased' => __('animals.status.purchased'), 'slaughtered' => __('animals.status.slaughtered')] as $val => $label)
                <option value="{{ $val }}" {{ old('status', $animal->status ?? 'pending') === $val ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
            @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>{{ app()->getLocale() === 'bn' ? 'প্রতি ভাগের মূল্য' : 'Price per Share' }}</label>
            <div class="input-group">
                <div class="input-group-prepend"><span class="input-group-text">৳</span></div>
                <input type="text" id="share_price_display" class="form-control" readonly
                       placeholder="{{ app()->getLocale() === 'bn' ? 'স্বয়ংক্রিয় গণনা' : 'Auto calculated' }}">
            </div>
        </div>
    </div>
</div>

<div class="form-group">
    <label>{{ __('messages.notes') }}</label>
    <textarea name="notes" rows="2" class="form-control">{{ old('notes', $animal->notes ?? '') }}</textarea>
</div>

@push('scripts')
<script>
const largeAnimals = ['cow', 'buffalo', 'camel'];
const hint = {
    bn: { large: 'বড় পশু: সর্বোচ্চ ৭টি ভাগ', small: 'ছোট পশু: সর্বোচ্চ ১টি ভাগ' },
    en: { large: 'Large animal: max 7 shares', small: 'Small animal: max 1 share' }
};
const locale = '{{ app()->getLocale() }}';

$('#animal_type').on('change', function() {
    const type = $(this).val();
    const isLarge = largeAnimals.includes(type);
    const maxShares = isLarge ? 7 : 1;
    $('#total_shares').attr('max', maxShares);
    if (!isLarge && parseInt($('#total_shares').val()) > 1) {
        $('#total_shares').val(1);
    }
    $('#share_hint').text(isLarge ? hint[locale].large : hint[locale].small);
    calcSharePrice();
}).trigger('change');

function calcSharePrice() {
    const price = parseFloat($('#purchase_price').val()) || 0;
    const shares = parseInt($('#total_shares').val()) || 1;
    const perShare = shares > 0 ? (price / shares).toFixed(2) : 0;
    $('#share_price_display').val(perShare > 0 ? '৳' + parseFloat(perShare).toLocaleString() : '');
}
$('#purchase_price, #total_shares').on('input', calcSharePrice);
</script>
@endpush
