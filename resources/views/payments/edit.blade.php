@extends('layouts.app')
@section('title', __('payments.edit'))
@section('page-title', __('payments.edit'))
@section('breadcrumb')
    <span><a href="{{ route('payments.index') }}" class="hover:text-emerald-700">{{ __('payments.payments') }}</a></span>
    <i class="fa-solid fa-chevron-right text-[10px] text-gray-400"></i>
    <span class="text-gray-600">{{ __('payments.edit') }}</span>
@endsection

@section('content')
<div class="mx-auto max-w-3xl">
    <div class="card">
        <div class="card-header bg-sky-700">
            <h3 class="card-title text-white"><i class="fa-solid fa-pen"></i>{{ __('payments.edit') }}</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('payments.update', $payment) }}" method="POST">
                @csrf @method('PUT')
                @include('payments._form')
                <div class="mt-6 flex items-center justify-between">
                    <a href="{{ route('payments.index') }}" class="btn btn-secondary">
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
