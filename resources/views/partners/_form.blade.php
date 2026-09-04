<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>{{ __('partners.name') }} <span class="text-danger">*</span></label>
            <input type="text" name="name" value="{{ old('name', $partner->name ?? '') }}" class="form-control @error('name') is-invalid @enderror" required>
            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>{{ __('partners.phone') }}</label>
            <input type="text" name="phone" value="{{ old('phone', $partner->phone ?? '') }}" class="form-control">
        </div>
    </div>
</div>
<div class="form-group">
    <label>{{ __('partners.address') }}</label>
    <input type="text" name="address" value="{{ old('address', $partner->address ?? '') }}" class="form-control">
</div>
<div class="form-group">
    <label>{{ __('messages.notes') }}</label>
    <textarea name="notes" rows="2" class="form-control">{{ old('notes', $partner->notes ?? '') }}</textarea>
</div>
