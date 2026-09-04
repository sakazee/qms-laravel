@extends('layouts.app')
@section('title', __('templates.create'))
@section('page-title', __('templates.create'))
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('templates.index') }}">{{ __('templates.templates') }}</a></li>
    <li class="breadcrumb-item active">{{ __('templates.create') }}</li>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h3 class="card-title mb-0"><i class="fas fa-plus mr-2"></i>{{ __('templates.create') }}</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('templates.store') }}" method="POST">
                    @csrf
                    @include('templates._form')
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('templates.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left mr-1"></i>{{ __('messages.back') }}
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-1"></i>{{ __('messages.save') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
