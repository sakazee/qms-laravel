@extends('layouts.auth')

@section('content')
<div class="w-full max-w-md">
    <div class="mb-7 flex flex-col items-center">
        <div class="mb-3 flex h-14 w-14 items-center justify-center rounded-2xl bg-gold/15 ring-1 ring-gold/30">
            <i class="fa-solid fa-moon text-2xl text-gold"></i>
        </div>
        <div class="text-center font-serif text-2xl font-bold text-white">{{ __('messages.app_name') }}</div>
    </div>

    <div class="auth-card rounded-2xl bg-white p-8">
        <h2 class="font-serif text-lg font-semibold text-pine-900">
            {{ app()->getLocale() === 'bn' ? 'নতুন পাসওয়ার্ড সেট করুন' : 'Set a new password' }}
        </h2>
        <p class="mt-1 text-[13px] text-gray-500">
            {{ app()->getLocale() === 'bn' ? 'নিচে আপনার নতুন পাসওয়ার্ড দিন।' : 'Choose a new password for your account.' }}
        </p>

        @if($errors->any())
        <div class="alert alert-error mt-5">
            <ul class="list-inside list-disc space-y-0.5">
                @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('password.update') }}" method="POST" class="mt-6 space-y-4">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div>
                <label for="email" class="label">{{ app()->getLocale() === 'bn' ? 'ইমেইল ঠিকানা' : 'Email address' }}</label>
                <div class="relative">
                    <i class="fa-solid fa-envelope pointer-events-none absolute left-3.5 top-1/2 -translate-y-1/2 text-sm text-gray-400"></i>
                    <input type="email" id="email" name="email" value="{{ old('email', $email) }}"
                           class="input pl-10" required autofocus>
                </div>
            </div>

            <div>
                <label for="password" class="label">{{ app()->getLocale() === 'bn' ? 'নতুন পাসওয়ার্ড' : 'New password' }}</label>
                <div class="relative">
                    <i class="fa-solid fa-lock pointer-events-none absolute left-3.5 top-1/2 -translate-y-1/2 text-sm text-gray-400"></i>
                    <input type="password" id="password" name="password"
                           class="input pl-10" placeholder="••••••••" required>
                </div>
            </div>

            <div>
                <label for="password_confirmation" class="label">{{ app()->getLocale() === 'bn' ? 'নিশ্চিত করুন' : 'Confirm password' }}</label>
                <div class="relative">
                    <i class="fa-solid fa-lock pointer-events-none absolute left-3.5 top-1/2 -translate-y-1/2 text-sm text-gray-400"></i>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                           class="input pl-10" placeholder="••••••••" required>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-full py-2.5 text-[14px]">
                {{ app()->getLocale() === 'bn' ? 'পাসওয়ার্ড রিসেট করুন' : 'Reset password' }}
            </button>
        </form>
    </div>
</div>
@endsection