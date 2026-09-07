@extends('layouts.app')
@section('title', __('admin.add_user'))
@section('page-title', __('admin.add_user'))
@section('breadcrumb')
    <span><a href="{{ route('admin.users.index') }}" class="hover:text-emerald-700">{{ __('admin.users') }}</a></span>
    <i class="fa-solid fa-chevron-right text-[10px] text-gray-400"></i>
    <span class="text-gray-600">{{ __('admin.add_user') }}</span>
@endsection

@section('content')
<div class="mx-auto max-w-2xl">
    <div class="card">
        <div class="card-header bg-emerald-800">
            <h3 class="card-title text-white"><i class="fa-solid fa-user-plus"></i>{{ __('admin.add_user') }}</h3>
        </div>
        <div class="card-body">
            <div class="mb-5 rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-[13px] text-amber-800">
                <i class="fa-solid fa-circle-info"></i> {{ __('admin.password_generated_hint') }}
            </div>
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                @include('admin.users._form', ['user' => null])
                <div class="mt-6 flex items-center justify-between">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                        <i class="fa-solid fa-arrow-left"></i>{{ __('messages.back') }}
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-save"></i>{{ __('messages.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection