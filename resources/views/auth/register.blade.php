@extends('layouts.auth')

@section('content')
<div class="login-box mx-auto">
    <div class="login-logo">
        <i class="fas fa-moon"></i>
        {{ __('messages.app_name') }}
    </div>
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg text-muted">
                {{ app()->getLocale() === 'bn' ? 'নতুন অ্যাকাউন্ট তৈরি করুন' : 'Register a new account' }}
            </p>
            @if($errors->any())
            <div class="alert alert-danger py-2">
                @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
            </div>
            @endif
            <form action="{{ route('register') }}" method="POST">
                @csrf
                <div class="input-group mb-3">
                    <input type="text" name="name" value="{{ old('name') }}"
                           class="form-control @error('name') is-invalid @enderror"
                           placeholder="{{ app()->getLocale() === 'bn' ? 'আপনার নাম' : 'Full Name' }}" required autofocus>
                    <div class="input-group-append"><div class="input-group-text"><i class="fas fa-user text-muted"></i></div></div>
                </div>
                <div class="input-group mb-3">
                    <input type="email" name="email" value="{{ old('email') }}"
                           class="form-control @error('email') is-invalid @enderror"
                           placeholder="{{ app()->getLocale() === 'bn' ? 'ইমেইল ঠিকানা' : 'Email address' }}" required>
                    <div class="input-group-append"><div class="input-group-text"><i class="fas fa-envelope text-muted"></i></div></div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" name="password"
                           class="form-control @error('password') is-invalid @enderror"
                           placeholder="{{ app()->getLocale() === 'bn' ? 'পাসওয়ার্ড' : 'Password' }}" required>
                    <div class="input-group-append"><div class="input-group-text"><i class="fas fa-lock text-muted"></i></div></div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" name="password_confirmation"
                           class="form-control"
                           placeholder="{{ app()->getLocale() === 'bn' ? 'পাসওয়ার্ড নিশ্চিত করুন' : 'Confirm Password' }}" required>
                    <div class="input-group-append"><div class="input-group-text"><i class="fas fa-lock text-muted"></i></div></div>
                </div>
                <button type="submit" class="btn btn-primary btn-block">
                    {{ app()->getLocale() === 'bn' ? 'নিবন্ধন করুন' : 'Register' }}
                </button>
            </form>
            <p class="mb-0 mt-3 text-center">
                <a href="{{ route('login') }}">{{ app()->getLocale() === 'bn' ? 'ইতিমধ্যে অ্যাকাউন্ট আছে? লগইন করুন' : 'Already have an account? Login' }}</a>
            </p>
        </div>
    </div>
</div>
@endsection
