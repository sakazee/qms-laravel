<div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
    <div>
        <label class="label">{{ __('payments.partner') }} <span class="text-rose-600">*</span></label>
        <select name="partner_id" class="input select2 js-partner-due-select @error('partner_id') border-rose-400 @enderror"
                data-due-map='{{ json_encode($partnerDueMap ?? []) }}' required>
            <option value="">-- {{ app()->getLocale() === 'bn' ? 'অংশীদার নির্বাচন করুন' : 'Select Partner' }} --</option>
            @foreach($partners as $partner)
            <option value="{{ $partner->id }}" {{ old('partner_id', request('partner_id', $payment->partner_id ?? '')) == $partner->id ? 'selected' : '' }}>{{ $partner->name }}</option>
            @endforeach
        </select>
        @error('partner_id')<p class="mt-1 text-[13px] font-medium text-rose-600">{{ $message }}</p>@enderror

        <div class="js-partner-due-row mt-2 hidden items-center gap-2 text-[13.5px]">
            <span class="text-gray-500">{{ __('payments.total_due') }}:</span>
            <span class="js-partner-due-amount font-semibold text-rose-700"></span>
        </div>
    </div>

    <div>
        <label class="label">{{ __('payments.amount') }} <span class="text-rose-600">*</span></label>
        <div class="relative">
            <span class="pointer-events-none absolute left-3.5 top-1/2 -translate-y-1/2 text-[14.5px] text-gray-400">৳</span>
            <input type="number" name="amount" value="{{ old('amount', $payment->amount ?? '') }}" class="input pl-8 @error('amount') border-rose-400 @enderror" min="0.01" step="0.01" required>
        </div>
        @error('amount')<p class="mt-1 text-[13px] font-medium text-rose-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label class="label">{{ __('payments.payment_date') }} <span class="text-rose-600">*</span></label>
        <input type="date" name="payment_date" value="{{ old('payment_date', isset($payment) ? $payment->payment_date->format('Y-m-d') : date('Y-m-d')) }}" class="input @error('payment_date') border-rose-400 @enderror" required>
        @error('payment_date')<p class="mt-1 text-[13px] font-medium text-rose-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label class="label">{{ __('payments.payment_method') }} <span class="text-rose-600">*</span></label>
        <select name="payment_method" class="input @error('payment_method') border-rose-400 @enderror" required>
            @foreach(['cash' => __('payments.method.cash'), 'bank' => __('payments.method.bank'), 'mobile_banking' => __('payments.method.mobile_banking'), 'other' => __('payments.method.other')] as $val => $label)
            <option value="{{ $val }}" {{ old('payment_method', $payment->payment_method ?? 'cash') === $val ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </select>
        @error('payment_method')<p class="mt-1 text-[13px] font-medium text-rose-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label class="label">{{ __('payments.reference') }}</label>
        <input type="text" name="reference" value="{{ old('reference', $payment->reference ?? '') }}" class="input">
    </div>

    <div class="sm:col-span-2">
        <label class="label">{{ __('messages.notes') }}</label>
        <textarea name="notes" rows="2" class="input resize-none">{{ old('notes', $payment->notes ?? '') }}</textarea>
    </div>
</div>

@push('scripts')
<script>
    window.qmsOnReady(function ($) {
        var $row = $('.js-partner-due-row');
        if ($row.length === 0) return;

        var $select = $('.js-partner-due-select');
        var dueMap = {};
        try { dueMap = JSON.parse($select.attr('data-due-map') || '{}'); } catch (e) { dueMap = {}; }

        function render() {
            var id = $select.val();
            if (!id) { $row.addClass('hidden'); return; }
            var due = dueMap[id] || 0;
            $row.removeClass('hidden');
            $('.js-partner-due-amount', $row).text('\u09F3' + Number(due).toFixed(2));
        }

        $select.on('change', render);
        render();
    });
</script>
@endpush
