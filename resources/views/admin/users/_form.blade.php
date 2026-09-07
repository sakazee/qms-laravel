<div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
    <div>
        <label class="label">{{ __('admin.user_name') }} <span class="text-rose-600">*</span></label>
        <input type="text" name="name" value="{{ old('name', $user->name ?? '') }}"
               class="input @error('name') border-rose-400 @enderror" required>
        @error('name')<p class="mt-1 text-[13px] font-medium text-rose-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label class="label">{{ __('admin.user_email') }} <span class="text-rose-600">*</span></label>
        <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}"
               class="input @error('email') border-rose-400 @enderror" required>
        @error('email')<p class="mt-1 text-[13px] font-medium text-rose-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label class="label">{{ __('admin.user_phone') }}</label>
        <input type="text" name="phone" value="{{ old('phone', $user->phone ?? '') }}"
               class="input @error('phone') border-rose-400 @enderror">
        @error('phone')<p class="mt-1 text-[13px] font-medium text-rose-600">{{ $message }}</p>@enderror
    </div>

    <div class="sm:col-span-2">
        <label class="label">{{ __('admin.user_role') }}</label>
        <select name="role" class="input">
            <option value="user"  {{ old('role', $user->role ?? 'user') === App\Models\User::ROLE_USER  ? 'selected' : '' }}>{{ __('admin.role_user') }}</option>
            <option value="admin" {{ old('role', $user->role ?? '') === App\Models\User::ROLE_ADMIN ? 'selected' : '' }}>{{ __('admin.role_admin') }}</option>
        </select>
        @error('role')<p class="mt-1 text-[13px] font-medium text-rose-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label class="label">{{ app()->getLocale() === 'bn' ? 'ভাষা' : 'Language' }}</label>
        <select name="locale" class="input">
            <option value="bn" {{ old('locale', $user->locale ?? 'bn') === 'bn' ? 'selected' : '' }}>বাংলা</option>
            <option value="en" {{ old('locale', $user->locale ?? '') === 'en' ? 'selected' : '' }}>English</option>
        </select>
        @error('locale')<p class="mt-1 text-[13px] font-medium text-rose-600">{{ $message }}</p>@enderror
    </div>
</div>