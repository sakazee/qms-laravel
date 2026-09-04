<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>{{ __('payments.partner') }} <span class="text-danger">*</span></label>
            <select name="partner_id" class="form-control select2 @error('partner_id') is-invalid @enderror" required>
                <option value="">-- {{ app()->getLocale() === 'bn' ? 'অংশীদার নির্বাচন করুন' : 'Select Partner' }} --</option>
                @foreach($partners as $partner)
                <option value="{{ $partner->id }}" {{ old('partner_id', $payment->partner_id ?? '') == $partner->id ? 'selected' : '' }}>{{ $partner->name }}</option>
                @endforeach
            </select>
            @error('partner_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>{{ __('payments.amount') }} <span class="text-danger">*</span></label>
            <div class="input-group">
                <div class="input-group-prepend"><span class="input-group-text">৳</span></div>
                <input type="number" name="amount" value="{{ old('amount', $payment->amount ?? '') }}" class="form-control @error('amount') is-invalid @enderror" min="0.01" step="0.01" required>
            </div>
            @error('amount')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label>{{ __('payments.payment_date') }} <span class="text-danger">*</span></label>
            <input type="date" name="payment_date" value="{{ old('payment_date', isset($payment) ? $payment->payment_date->format('Y-m-d') : date('Y-m-d')) }}" class="form-control @error('payment_date') is-invalid @enderror" required>
            @error('payment_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>{{ __('payments.payment_method') }} <span class="text-danger">*</span></label>
            <select name="payment_method" class="form-control @error('payment_method') is-invalid @enderror" required>
                @foreach(['cash' => __('payments.method.cash'), 'bank' => __('payments.method.bank'), 'mobile_banking' => __('payments.method.mobile_banking'), 'other' => __('payments.method.other')] as $val => $label)
                <option value="{{ $val }}" {{ old('payment_method', $payment->payment_method ?? 'cash') === $val ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
            @error('payment_method')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>{{ __('payments.reference') }}</label>
            <input type="text" name="reference" value="{{ old('reference', $payment->reference ?? '') }}" class="form-control">
        </div>
    </div>
</div>
<div class="form-group">
    <label>{{ __('messages.notes') }}</label>
    <textarea name="notes" rows="2" class="form-control">{{ old('notes', $payment->notes ?? '') }}</textarea>
</div>
