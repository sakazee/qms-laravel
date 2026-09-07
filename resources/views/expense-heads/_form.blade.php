<div class="grid grid-cols-1 gap-5">
    <div>
        <label class="label">{{ __('expense_heads.name') }} <span class="text-rose-600">*</span></label>
        <input type="text" name="name" value="{{ old('name', $expenseHead->name ?? '') }}"
               class="input @error('name') border-rose-400 @enderror"
               placeholder="{{ app()->getLocale() === 'bn' ? 'যেমন: পশুখাদ্য' : 'e.g. Animal Feed' }}" required>
        @error('name')<p class="mt-1 text-[13px] font-medium text-rose-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label class="label">{{ __('expense_heads.description') }}</label>
        <textarea name="description" rows="3"
                  class="input @error('description') border-rose-400 @enderror resize-none"
                  placeholder="{{ app()->getLocale() === 'bn' ? 'ঐচ্ছিক বিবরণ...' : 'Optional description...' }}">{{ old('description', $expenseHead->description ?? '') }}</textarea>
        @error('description')<p class="mt-1 text-[13px] font-medium text-rose-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label class="label">{{ __('expense_heads.color') }} <span class="text-rose-600">*</span></label>
        <div class="flex flex-wrap items-center gap-3.5">
            @foreach(\App\Models\ExpenseHead::COLORS as $color)
            <label class="cursor-pointer" title="{{ $color }}">
                <input type="radio" name="color" value="{{ $color }}" class="peer sr-only"
                       {{ old('color', $expenseHead->color ?? '#059669') === $color ? 'checked' : '' }}>
                <span class="block h-8 w-8 rounded-full ring-gray-700 ring-offset-2 transition peer-checked:ring-2"
                      style="background-color: {{ $color }};"></span>
            </label>
            @endforeach
        </div>
        @error('color')<p class="mt-1 text-[13px] font-medium text-rose-600">{{ $message }}</p>@enderror
    </div>
</div>