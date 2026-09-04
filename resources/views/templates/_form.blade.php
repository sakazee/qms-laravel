<div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
    <div>
        <label class="label">{{ __('templates.name') }} <span class="text-rose-600">*</span></label>
        <input type="text" name="name" value="{{ old('name', $template->name ?? '') }}"
               class="input @error('name') border-rose-400 @enderror"
               placeholder="{{ app()->getLocale() === 'bn' ? 'যেমন: কোরবানি ২০২৫' : 'e.g. Qurbani 2025' }}" required>
        @error('name')<p class="mt-1 text-[12px] font-medium text-rose-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label class="label">{{ __('templates.year') }} <span class="text-rose-600">*</span></label>
        <input type="text" name="year" value="{{ old('year', $template->year ?? date('Y')) }}"
               class="input @error('year') border-rose-400 @enderror"
               placeholder="{{ app()->getLocale() === 'bn' ? 'যেমন: ২০২৫ / 2025' : 'e.g. 2025' }}" required>
        @error('year')<p class="mt-1 text-[12px] font-medium text-rose-600">{{ $message }}</p>@enderror
    </div>

    <div class="sm:col-span-2">
        <label class="label">{{ __('templates.description') }}</label>
        <textarea name="description" rows="3"
                  class="input @error('description') border-rose-400 @enderror resize-none"
                  placeholder="{{ app()->getLocale() === 'bn' ? 'ঐচ্ছিক বিবরণ...' : 'Optional description...' }}">{{ old('description', $template->description ?? '') }}</textarea>
        @error('description')<p class="mt-1 text-[12px] font-medium text-rose-600">{{ $message }}</p>@enderror
    </div>

    <div class="sm:col-span-2">
        <label class="label">{{ __('templates.status') }} <span class="text-rose-600">*</span></label>
        <select name="status" class="input" required>
            <option value="active"   {{ old('status', $template->status ?? 'active') === 'active'   ? 'selected' : '' }}>{{ __('templates.active') }}</option>
            <option value="inactive" {{ old('status', $template->status ?? '') === 'inactive' ? 'selected' : '' }}>{{ __('templates.inactive') }}</option>
        </select>
        @error('status')<p class="mt-1 text-[12px] font-medium text-rose-600">{{ $message }}</p>@enderror
    </div>
</div>