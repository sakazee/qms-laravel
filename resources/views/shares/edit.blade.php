@extends('layouts.app')
@section('title', __('shares.edit'))
@section('page-title', __('shares.edit'))
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('shares.index') }}">{{ __('shares.shares') }}</a></li>
    <li class="breadcrumb-item active">{{ __('shares.edit') }}</li>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h3 class="card-title mb-0"><i class="fas fa-edit mr-2"></i>{{ __('shares.edit') }}</h3>
            </div>
            <div class="card-body">
                <div class="alert alert-secondary mb-4">
                    <strong>{{ __('animals.animal') }}:</strong> {{ $share->animal->type_name }} {{ $share->animal->name ? '— ' . $share->animal->name : '' }}<br>
                    <strong>{{ __('partners.partner') }}:</strong> {{ $share->partner->name }}
                </div>

                <form action="{{ route('shares.update', $share) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ __('shares.shares_count') }} <span class="text-danger">*</span></label>
                                <input type="number" name="shares" value="{{ old('shares', $share->shares) }}"
                                       class="form-control @error('shares') is-invalid @enderror"
                                       min="1" max="{{ $share->animal->max_shares }}"
                                       {{ !$share->animal->is_large ? 'readonly' : '' }} required>
                                @error('shares')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ __('shares.share_amount') }}</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text">৳</span></div>
                                    <input type="text" class="form-control" value="{{ number_format($share->share_amount, 2) }}" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>{{ __('messages.notes') }}</label>
                        <textarea name="notes" rows="2" class="form-control">{{ old('notes', $share->notes) }}</textarea>
                    </div>
                    <div class="d-flex justify-content-between mt-3">
                        <a href="{{ route('shares.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left mr-1"></i>{{ __('messages.back') }}</a>
                        <button type="submit" class="btn btn-info"><i class="fas fa-save mr-1"></i>{{ __('messages.save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
