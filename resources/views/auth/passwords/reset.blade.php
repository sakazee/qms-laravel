@extends('layouts.auth')
@section('content')
<div class="login-box mx-auto">
    <div class="login-logo"><i class="fas fa-moon"></i> {{ __('messages.app_name') }}</div>
    <div class="card"><div class="card-body login-card-body">
        <p class="login-box-msg">{{ app()->getLocale() === 'bn' ? 'নতুন পাসওয়ার্ড সেট করুন' : 'Set new password' }}</p>
        @if($errors->any())<div class="alert alert-danger">@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>@endif
        <form action="{{ route('password.update') }}" method="POST">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <div class="input-group mb-3">
                <input type="email" name="email" value="{{ old('email', $email) }}" class="form-control" placeholder="Email" required>
                <div class="input-group-append"><div class="input-group-text"><i class="fas fa-envelope text-muted"></i></div></div>
            </div>
            <div class="input-group mb-3">
                <input type="password" name="password" class="form-control" placeholder="{{ app()->getLocale() === 'bn' ? 'নতুন পাসওয়ার্ড' : 'New Password' }}" required>
                <div class="input-group-append"><div class="input-group-text"><i class="fas fa-lock text-muted"></i></div></div>
            </div>
            <div class="input-group mb-3">
                <input type="password" name="password_confirmation" class="form-control" placeholder="{{ app()->getLocale() === 'bn' ? 'নিশ্চিত করুন' : 'Confirm' }}" required>
                <div class="input-group-append"><div class="input-group-text"><i class="fas fa-lock text-muted"></i></div></div>
            </div>
            <button type="submit" class="btn btn-primary btn-block">{{ app()->getLocale() === 'bn' ? 'পাসওয়ার্ড রিসেট করুন' : 'Reset Password' }}</button>
        </form>
    </div></div>
</div>
@endsection
