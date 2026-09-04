<div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
    <div>
        <label class="label">{{ __('partners.name') }} <span class="text-rose-600">*</span></label>
        <input type="text" name="name" value="{{ old('name', $partner->name ?? '') }}"
               class="input @error('name') border-rose-400 @enderror" required>
        @error('name')<p class="mt-1 text-[12px] font-medium text-rose-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label class="label">{{ __('partners.phone') }}</label>
        <input type="text" name="phone" value="{{ old('phone', $partner->phone ?? '') }}"
               class="input">
    </div>

    <div class="sm:col-span-2">
        <label class="label">{{ __('partners.address') }}</label>
        <input type="text" name="address" value="{{ old('address', $partner->address ?? '') }}"
               class="input">
    </div>

    <div class="sm:col-span-2">
        <label class="label">{{ __('messages.notes') }}</label>
        <textarea name="notes" rows="2"
                  class="input resize-none">{{ old('notes', $partner->notes ?? '') }}</textarea>
    </div>
</div>
