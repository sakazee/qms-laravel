@extends('layouts.app')
@section('title', __('profile.change_password'))
@section('page-title', __('profile.change_password'))
@section('breadcrumb')
    <span class="text-gray-600">{{ __('profile.change_password') }}</span>
@endsection

@section('content')
<div class="mx-auto max-w-2xl">
    <div class="card">
        <div class="card-header bg-emerald-800">
            <h3 class="card-title text-white"><i class="fa-solid fa-key"></i>{{ __('profile.change_password') }}</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('password.change.update') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 gap-5">
                    <div>
                        <label class="label">{{ __('profile.current_password') }} <span class="text-rose-600">*</span></label>
                        <div class="relative" x-data="{ show: false }">
                            <input :type="show ? 'text' : 'password'" name="current_password" autocomplete="current-password"
                                   class="input pr-11 @error('current_password') border-rose-400 @enderror" required>
                            <button type="button" @click="show = !show" :aria-label="show ? '{{ __('profile.hide_password') }}' : '{{ __('profile.show_password') }}'"
                                    class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-400 hover:text-emerald-700 focus:outline-none">
                                <i :class="show ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye'"></i>
                            </button>
                        </div>
                        @error('current_password')<p class="mt-1 text-[13px] font-medium text-rose-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="label">{{ __('profile.new_password') }} <span class="text-rose-600">*</span></label>
                        <div class="relative" x-data="{ show: false }">
                            <input :type="show ? 'text' : 'password'" name="new_password" autocomplete="new-password"
                                   class="input pr-11 @error('new_password') border-rose-400 @enderror" required>
                            <button type="button" @click="show = !show" :aria-label="show ? '{{ __('profile.hide_password') }}' : '{{ __('profile.show_password') }}'"
                                    class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-400 hover:text-emerald-700 focus:outline-none">
                                <i :class="show ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye'"></i>
                            </button>
                        </div>
                        <p class="mt-1 text-[12.5px] text-gray-500">{{ __('profile.password_hint') }}</p>
                        @error('new_password')<p class="mt-1 text-[13px] font-medium text-rose-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="label">{{ __('profile.confirm_new_password') }} <span class="text-rose-600">*</span></label>
                        <div class="relative" x-data="{ show: false }">
                            <input :type="show ? 'text' : 'password'" name="new_password_confirmation" autocomplete="new-password"
                                   class="input pr-11 @error('new_password') border-rose-400 @enderror" required>
                            <button type="button" @click="show = !show" :aria-label="show ? '{{ __('profile.hide_password') }}' : '{{ __('profile.show_password') }}'"
                                    class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-400 hover:text-emerald-700 focus:outline-none">
                                <i :class="show ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye'"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="mt-6 flex items-center justify-between">
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                        <i class="fa-solid fa-arrow-left"></i>{{ __('messages.back') }}
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-save"></i>{{ __('profile.update_password') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
