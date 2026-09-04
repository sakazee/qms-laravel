@extends('layouts.auth')

@section('content')
<div class="login-box mx-auto">
    <div class="login-logo">
        <i class="fas fa-moon"></i>
        {{ __('messages.app_name') }}
    </div>

    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg text-muted" style="font-size:14px">
                {{ app()->getLocale() === 'bn' ? 'আপনার অ্যাকাউন্টে লগইন করুন' : 'Sign in to your account' }}
            </p>

            @if($errors->any())
            <div class="alert alert-danger py-2">
                @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
            </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="input-group mb-3">
                    <input type="email" name="email" value="{{ old('email') }}"
                           class="form-control @error('email') is-invalid @enderror"
                           placeholder="{{ app()->getLocale() === 'bn' ? 'ইমেইল ঠিকানা' : 'Email address' }}"
                           required autofocus>
                    <div class="input-group-append">
                        <div class="input-group-text"><i class="fas fa-envelope text-muted"></i></div>
                    </div>
                </div>

                <div class="input-group mb-3">
                    <input type="password" name="password"
                           class="form-control @error('password') is-invalid @enderror"
                           placeholder="{{ app()->getLocale() === 'bn' ? 'পাসওয়ার্ড' : 'Password' }}"
                           required>
                    <div class="input-group-append">
                        <div class="input-group-text"><i class="fas fa-lock text-muted"></i></div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-7">
                        <div class="icheck-primary">
                            <input type="checkbox" id="remember" name="remember">
                            <label for="remember">
                                {{ app()->getLocale() === 'bn' ? 'মনে রাখুন' : 'Remember Me' }}
                            </label>
                        </div>
                    </div>
                    <div class="col-5">
                        <button type="submit" class="btn btn-primary btn-block">
                            {{ app()->getLocale() === 'bn' ? 'লগইন' : 'Login' }}
                        </button>
                    </div>
                </div>
            </form>

            <p class="mb-1 mt-3 text-center">
                <a href="{{ route('password.request') }}">
                    {{ app()->getLocale() === 'bn' ? 'পাসওয়ার্ড ভুলে গেছেন?' : 'Forgot password?' }}
                </a>
            </p>
            <p class="mb-0 text-center">
                <a href="{{ route('register') }}">
                    {{ app()->getLocale() === 'bn' ? 'নতুন অ্যাকাউন্ট তৈরি করুন' : 'Register a new account' }}
                </a>
            </p>
        </div>
    </div>
</div>
@endsection
