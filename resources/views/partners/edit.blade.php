@extends('layouts.app')
@section('title', __('partners.edit'))
@section('page-title', __('partners.edit'))
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('partners.index') }}">{{ __('partners.partners') }}</a></li>
    <li class="breadcrumb-item active">{{ __('partners.edit') }}</li>
@endsection
@section('content')
<div class="row justify-content-center"><div class="col-md-8">
    <div class="card">
        <div class="card-header bg-info text-white"><h3 class="card-title mb-0"><i class="fas fa-edit mr-2"></i>{{ __('partners.edit') }}</h3></div>
        <div class="card-body">
            <form action="{{ route('partners.update', $partner) }}" method="POST">
                @csrf @method('PUT')
                @include('partners._form')
                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('partners.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left mr-1"></i>{{ __('messages.back') }}</a>
                    <button type="submit" class="btn btn-info"><i class="fas fa-save mr-1"></i>{{ __('messages.save') }}</button>
                </div>
            </form>
        </div>
    </div>
</div></div>
@endsection
