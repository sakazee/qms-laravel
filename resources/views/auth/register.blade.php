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
            {{ app()->getLocale() === 'bn' ? 'নতুন অ্যাকাউন্ট তৈরি করুন' : 'Create a new account' }}
        </h2>
        <p class="mt-1 text-[14px] text-gray-500">
            {{ app()->getLocale() === 'bn' ? 'একটি অ্যাকাউন্ট তৈরি করে কোরবানি ব্যবস্থাপনা শুরু করুন।' : 'Set up an account and start managing your Qurbani.' }}
        </p>

        @if($errors->any())
        <div class="alert alert-error mt-5">
            <ul class="list-inside list-disc space-y-0.5">
                @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('register') }}" method="POST" class="mt-6 space-y-4">
            @csrf
            <div>
                <label for="name" class="label">{{ app()->getLocale() === 'bn' ? 'আপনার নাম' : 'Full name' }}</label>
                <div class="relative">
                    <i class="fa-solid fa-user pointer-events-none absolute left-3.5 top-1/2 -translate-y-1/2 text-sm text-gray-400"></i>
                    <input type="text" id="name" name="name" value="{{ old('name') }}"
                           class="input pl-10" placeholder="{{ app()->getLocale() === 'bn' ? 'আপনার নাম লিখুন' : 'Your name' }}" required autofocus>
                </div>
            </div>

            <div>
                <label for="email" class="label">{{ app()->getLocale() === 'bn' ? 'ইমেইল ঠিকানা' : 'Email address' }}</label>
                <div class="relative">
                    <i class="fa-solid fa-envelope pointer-events-none absolute left-3.5 top-1/2 -translate-y-1/2 text-sm text-gray-400"></i>
                    <input type="email" id="email" name="email" value="{{ old('email') }}"
                           class="input pl-10" placeholder="you@example.com" required>
                </div>
            </div>

            <div>
                <label for="password" class="label">{{ app()->getLocale() === 'bn' ? 'পাসওয়ার্ড' : 'Password' }}</label>
                <div class="relative">
                    <i class="fa-solid fa-lock pointer-events-none absolute left-3.5 top-1/2 -translate-y-1/2 text-sm text-gray-400"></i>
                    <input type="password" id="password" name="password"
                           class="input pl-10" placeholder="••••••••" required>
                </div>
            </div>

            <div>
                <label for="password_confirmation" class="label">{{ app()->getLocale() === 'bn' ? 'পাসওয়ার্ড নিশ্চিত করুন' : 'Confirm password' }}</label>
                <div class="relative">
                    <i class="fa-solid fa-lock pointer-events-none absolute left-3.5 top-1/2 -translate-y-1/2 text-sm text-gray-400"></i>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                           class="input pl-10" placeholder="••••••••" required>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-full py-2.5 text-[15px]">
                {{ app()->getLocale() === 'bn' ? 'নিবন্ধন করুন' : 'Register' }}
            </button>
        </form>
    </div>

    <p class="mt-5 text-center text-[14px] text-white/70">
        {!! app()->getLocale() === 'bn'
            ? 'ইতিমধ্যে অ্যাকাউন্ট আছে? <a href="'.route('login').'" class="font-semibold text-gold hover:text-gold-300">লগইন করুন</a>'
            : 'Already have an account? <a href="'.route('login').'" class="font-semibold text-gold hover:text-gold-300">Login</a>' !!}
    </p>
</div>
@endsection