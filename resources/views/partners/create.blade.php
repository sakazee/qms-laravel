@extends('layouts.app')
@section('title', __('partners.create'))
@section('page-title', __('partners.create'))
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('partners.index') }}">{{ __('partners.partners') }}</a></li>
    <li class="breadcrumb-item active">{{ __('partners.create') }}</li>
@endsection
@section('content')
<div class="row justify-content-center"><div class="col-md-8">
    <div class="card">
        <div class="card-header bg-primary text-white"><h3 class="card-title mb-0"><i class="fas fa-user-plus mr-2"></i>{{ __('partners.create') }}</h3></div>
        <div class="card-body">
            <form action="{{ route('partners.store') }}" method="POST">
                @csrf
                @include('partners._form')
                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('partners.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left mr-1"></i>{{ __('messages.back') }}</a>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i>{{ __('messages.save') }}</button>
                </div>
            </form>
        </div>
    </div>
</div></div>
@endsection
