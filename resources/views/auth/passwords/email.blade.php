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
            {{ app()->getLocale() === 'bn' ? 'পাসওয়ার্ড রিসেট' : 'Reset your password' }}
        </h2>
        <p class="mt-1 text-[13px] text-gray-500">
            {{ app()->getLocale() === 'bn' ? 'আপনার ইমেইল ঠিকানা দিন, আমরা রিসেট লিংক পাঠাবো।' : 'Enter your email and we will send you a reset link.' }}
        </p>

        @if(session('status'))
        <div class="alert alert-success mt-5">{{ session('status') }}</div>
        @endif
        @if($errors->any())
        <div class="alert alert-error mt-5">
            <ul class="list-inside list-disc space-y-0.5">
                @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('password.email') }}" method="POST" class="mt-6 space-y-4">
            @csrf
            <div>
                <label for="email" class="label">{{ app()->getLocale() === 'bn' ? 'ইমেইল ঠিকানা' : 'Email address' }}</label>
                <div class="relative">
                    <i class="fa-solid fa-envelope pointer-events-none absolute left-3.5 top-1/2 -translate-y-1/2 text-sm text-gray-400"></i>
                    <input type="email" id="email" name="email" value="{{ old('email') }}"
                           class="input pl-10" placeholder="you@example.com" required autofocus>
                </div>
            </div>
            <button type="submit" class="btn btn-primary w-full py-2.5 text-[14px]">
                {{ app()->getLocale() === 'bn' ? 'রিসেট লিংক পাঠান' : 'Send reset link' }}
            </button>
        </form>

        <p class="mt-5 text-center text-[13px] text-gray-500">
            <a href="{{ route('login') }}" class="font-medium text-emerald-800 hover:text-emerald-900">
                <i class="fa-solid fa-arrow-left mr-1 text-[11px]"></i>{{ app()->getLocale() === 'bn' ? 'লগইনে ফিরুন' : 'Back to login' }}
            </a>
        </p>
    </div>
</div>
@endsection