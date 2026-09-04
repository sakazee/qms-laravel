@extends('layouts.app')
@section('title', __('animals.create'))
@section('page-title', __('animals.create'))
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('animals.index') }}">{{ __('animals.animals') }}</a></li>
    <li class="breadcrumb-item active">{{ __('animals.create') }}</li>
@endsection
@section('content')
<div class="row justify-content-center">
    <div class="col-md-9">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h3 class="card-title mb-0"><i class="fas fa-plus mr-2"></i>{{ __('animals.create') }}</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('animals.store') }}" method="POST">
                    @csrf
                    @include('animals._form')
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('animals.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left mr-1"></i>{{ __('messages.back') }}</a>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i>{{ __('messages.save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
