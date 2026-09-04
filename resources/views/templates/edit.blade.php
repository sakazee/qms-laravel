@extends('layouts.app')
@section('title', __('templates.edit'))
@section('page-title', __('templates.edit'))
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('templates.index') }}">{{ __('templates.templates') }}</a></li>
    <li class="breadcrumb-item active">{{ __('templates.edit') }}</li>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h3 class="card-title mb-0"><i class="fas fa-edit mr-2"></i>{{ __('templates.edit') }}: {{ $template->name }}</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('templates.update', $template) }}" method="POST">
                    @csrf @method('PUT')
                    @include('templates._form')
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('templates.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left mr-1"></i>{{ __('messages.back') }}
                        </a>
                        <button type="submit" class="btn btn-info">
                            <i class="fas fa-save mr-1"></i>{{ __('messages.save') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
