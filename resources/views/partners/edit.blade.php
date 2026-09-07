@extends('layouts.app')
@section('title', __('partners.edit'))
@section('page-title', __('partners.edit'))
@section('breadcrumb')
    <span><a href="{{ route('partners.index') }}" class="hover:text-emerald-700">{{ __('partners.partners') }}</a></span>
    <i class="fa-solid fa-chevron-right text-[11px] text-gray-400"></i>
    <span class="text-gray-600">{{ __('partners.edit') }}</span>
@endsection

@section('content')
<div class="mx-auto max-w-3xl">
    <div class="card">
        <div class="card-header bg-sky-700">
            <h3 class="card-title text-white"><i class="fa-solid fa-pen"></i>{{ __('partners.edit') }}</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('partners.update', $partner) }}" method="POST">
                @csrf @method('PUT')
                @include('partners._form')
                <div class="mt-6 flex items-center justify-between">
                    <a href="{{ route('partners.index') }}" class="btn btn-secondary">
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
