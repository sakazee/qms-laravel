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
            {{ app()->getLocale() === 'bn' ? 'আপনার অ্যাকাউন্টে লগইন করুন' : 'Sign in to your account' }}
        </h2>
        <p class="mt-1 text-[14px] text-gray-500">
            {{ app()->getLocale() === 'bn' ? 'ধন্যবাদ, আবার ফিরে আসার জন্য!' : 'Welcome back to the Qurbani season.' }}
        </p>

        @if($errors->any())
        <div class="alert alert-error mt-5">
            <ul class="list-inside list-disc space-y-0.5">
                @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('login') }}" method="POST" class="mt-6 space-y-4">
            @csrf
            <div>
                <label for="email" class="label">{{ app()->getLocale() === 'bn' ? 'ইমেইল ঠিকানা' : 'Email address' }}</label>
                <div class="relative">
                    <i class="fa-solid fa-envelope pointer-events-none absolute left-3.5 top-1/2 -translate-y-1/2 text-sm text-gray-400"></i>
                    <input type="email" id="email" name="email" value="{{ old('email') }}"
                           class="input pl-10" placeholder="you@example.com" required autofocus>
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

            <div class="flex items-center justify-between">
                <label class="flex cursor-pointer items-center gap-2 text-[14px] text-gray-600">
                    <input type="checkbox" name="remember" value="1" class="h-4 w-4 rounded border-gray-300 text-emerald-800 focus:ring-emerald-600">
                    {{ app()->getLocale() === 'bn' ? 'মনে রাখুন' : 'Remember me' }}
                </label>
                <a href="{{ route('password.request') }}" class="text-[13.5px] font-medium text-emerald-800 hover:text-emerald-900">
                    {{ app()->getLocale() === 'bn' ? 'পাসওয়ার্ড ভুলে গেছেন?' : 'Forgot password?' }}
                </a>
            </div>

            <button type="submit" class="btn btn-primary w-full py-2.5 text-[15px]">
                {{ app()->getLocale() === 'bn' ? 'লগইন করুন' : 'Login' }}
            </button>
        </form>
    </div>

    <p class="mt-5 text-center text-[14px] text-white/70">
        {!! app()->getLocale() === 'bn'
            ? 'নতুন ব্যবহারকারী? <a href="'.route('register').'" class="font-semibold text-gold hover:text-gold-300">অ্যাকাউন্ট তৈরি করুন</a>'
            : 'New here? <a href="'.route('register').'" class="font-semibold text-gold hover:text-gold-300">Create an account</a>' !!}
    </p>
</div>
@endsection