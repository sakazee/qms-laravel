@extends('layouts.auth')
@section('content')
<div class="login-box mx-auto">
    <div class="login-logo"><i class="fas fa-moon"></i> {{ __('messages.app_name') }}</div>
    <div class="card"><div class="card-body login-card-body">
        <p class="login-box-msg">{{ app()->getLocale() === 'bn' ? 'পাসওয়ার্ড রিসেটের জন্য ইমেইল দিন' : 'Enter email to reset password' }}</p>
        @if(session('status'))<div class="alert alert-success">{{ session('status') }}</div>@endif
        @if($errors->any())<div class="alert alert-danger">@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>@endif
        <form action="{{ route('password.email') }}" method="POST">
            @csrf
            <div class="input-group mb-3">
                <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="Email" required>
                <div class="input-group-append"><div class="input-group-text"><i class="fas fa-envelope text-muted"></i></div></div>
            </div>
            <button type="submit" class="btn btn-primary btn-block">{{ app()->getLocale() === 'bn' ? 'রিসেট লিংক পাঠান' : 'Send Reset Link' }}</button>
        </form>
        <p class="mt-3 text-center"><a href="{{ route('login') }}">{{ app()->getLocale() === 'bn' ? 'লগইনে ফিরুন' : 'Back to Login' }}</a></p>
    </div></div>
</div>
@endsection
