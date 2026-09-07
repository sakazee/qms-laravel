@extends('layouts.app')
@section('title', __('admin.edit_user'))
@section('page-title', __('admin.edit_user'))
@section('breadcrumb')
    <span><a href="{{ route('admin.users.index') }}" class="hover:text-emerald-700">{{ __('admin.users') }}</a></span>
    <i class="fa-solid fa-chevron-right text-[10px] text-gray-400"></i>
    <span class="text-gray-600">{{ __('admin.edit_user') }}</span>
@endsection

@section('content')
<div class="mx-auto max-w-2xl">
    <div class="card">
        <div class="card-header bg-emerald-800">
            <h3 class="card-title text-white"><i class="fa-solid fa-user-pen"></i>{{ __('admin.edit_user') }}</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.users.update', $user) }}" method="POST">
                @csrf @method('PUT')
                @include('admin.users._form', ['user' => $user])
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