<div class="form-group">
    <label>{{ __('templates.name') }} <span class="text-danger">*</span></label>
    <input type="text" name="name" value="{{ old('name', $template->name ?? '') }}"
           class="form-control @error('name') is-invalid @enderror"
           placeholder="{{ app()->getLocale() === 'bn' ? 'যেমন: কোরবানি ২০২৫' : 'e.g. Qurbani 2025' }}" required>
    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="form-group">
    <label>{{ __('templates.year') }} <span class="text-danger">*</span></label>
    <input type="text" name="year" value="{{ old('year', $template->year ?? date('Y')) }}"
           class="form-control @error('year') is-invalid @enderror"
           placeholder="{{ app()->getLocale() === 'bn' ? 'যেমন: ২০২৫ / 2025' : 'e.g. 2025' }}" required>
    @error('year')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="form-group">
    <label>{{ __('templates.description') }}</label>
    <textarea name="description" rows="3"
              class="form-control @error('description') is-invalid @enderror"
              placeholder="{{ app()->getLocale() === 'bn' ? 'ঐচ্ছিক বিবরণ...' : 'Optional description...' }}">{{ old('description', $template->description ?? '') }}</textarea>
    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="form-group">
    <label>{{ __('templates.status') }} <span class="text-danger">*</span></label>
    <select name="status" class="form-control @error('status') is-invalid @enderror" required>
        <option value="active"   {{ old('status', $template->status ?? 'active') === 'active'   ? 'selected' : '' }}>{{ __('templates.active') }}</option>
        <option value="inactive" {{ old('status', $template->status ?? '') === 'inactive' ? 'selected' : '' }}>{{ __('templates.inactive') }}</option>
    </select>
    @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
