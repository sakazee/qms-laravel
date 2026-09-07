@extends('layouts.app')
@section('title', __('templates.edit'))
@section('page-title', __('templates.edit'))
@section('breadcrumb')
    <span><a href="{{ route('templates.index') }}" class="hover:text-emerald-700">{{ __('templates.templates') }}</a></span>
    <i class="fa-solid fa-chevron-right text-[11px] text-gray-400"></i>
    <span class="text-gray-600">{{ __('templates.edit') }}</span>
@endsection

@section('content')
<div class="mx-auto max-w-3xl">
    <div class="card">
        <div class="card-header bg-sky-700">
            <h3 class="card-title text-white"><i class="fa-solid fa-pen"></i>{{ __('templates.edit') }}: {{ $template->name }}</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('templates.update', $template) }}" method="POST">
                @csrf @method('PUT')
                @include('templates._form')
                <div class="mt-6 flex items-center justify-between">
                    <a href="{{ route('templates.index') }}" class="btn btn-secondary">
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