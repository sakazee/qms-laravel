<div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
    <div>
        <label class="label">{{ __('animals.type.label') }} <span class="text-rose-600">*</span></label>
        <select name="type" id="animal_type"
                class="input @error('type') border-rose-400 @enderror" required>
            <option value="">-- {{ app()->getLocale() === 'bn' ? 'ধরন নির্বাচন করুন' : 'Select Type' }} --</option>
            @foreach(['cow' => __('animals.type.cow'), 'buffalo' => __('animals.type.buffalo'), 'camel' => __('animals.type.camel'), 'goat' => __('animals.type.goat'), 'sheep' => __('animals.type.sheep'), 'other' => __('animals.type.other')] as $val => $label)
            <option value="{{ $val }}" {{ old('type', $animal->type ?? '') === $val ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </select>
        @error('type')<p class="mt-1 text-[12px] font-medium text-rose-600">{{ $message }}</p>@enderror
        <p id="share_hint" class="mt-1 text-[12px] text-gray-500"></p>
    </div>

    <div>
        <label class="label">{{ __('animals.name') }}</label>
        <input type="text" name="name" value="{{ old('name', $animal->name ?? '') }}"
               class="input"
               placeholder="{{ app()->getLocale() === 'bn' ? 'যেমন: কালো গরু' : 'e.g. Black Cow' }}">
    </div>

    <div>
        <label class="label">{{ __('animals.total_shares') }} <span class="text-rose-600">*</span></label>
        <input type="number" name="total_shares" id="total_shares"
               value="{{ old('total_shares', $animal->total_shares ?? 1) }}"
               class="input @error('total_shares') border-rose-400 @enderror"
               min="1" max="7" required>
        @error('total_shares')<p class="mt-1 text-[12px] font-medium text-rose-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label class="label">{{ __('animals.purchase_price') }} <span class="text-rose-600">*</span></label>
        <input type="number" name="purchase_price" id="purchase_price"
               value="{{ old('purchase_price', $animal->purchase_price ?? '') }}"
               class="input @error('purchase_price') border-rose-400 @enderror"
               placeholder="৳"
               min="0" step="0.01" required>
        @error('purchase_price')<p class="mt-1 text-[12px] font-medium text-rose-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label class="label">{{ __('animals.status.label') }} <span class="text-rose-600">*</span></label>
        <select name="status"
                class="input @error('status') border-rose-400 @enderror" required>
            @foreach(['pending' => __('animals.status.pending'), 'purchased' => __('animals.status.purchased'), 'slaughtered' => __('animals.status.slaughtered')] as $val => $label)
            <option value="{{ $val }}" {{ old('status', $animal->status ?? 'pending') === $val ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </select>
        @error('status')<p class="mt-1 text-[12px] font-medium text-rose-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label class="label">{{ app()->getLocale() === 'bn' ? 'প্রতি ভাগের মূল্য' : 'Price per Share' }}</label>
        <input type="text" id="share_price_display" class="input" readonly
               placeholder="{{ app()->getLocale() === 'bn' ? 'স্বয়ংক্রিয় গণনা' : 'Auto calculated' }}">
    </div>

    <div class="sm:col-span-2">
        <label class="label">{{ __('messages.notes') }}</label>
        <textarea name="notes" rows="2"
                  class="input resize-none">{{ old('notes', $animal->notes ?? '') }}</textarea>
    </div>
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
