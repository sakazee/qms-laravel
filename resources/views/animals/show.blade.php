@extends('layouts.app')
@section('title', __('animals.animal'))
@section('page-title', $animal->type_name . ' — ' . ($animal->name ?: ''))
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('animals.index') }}">{{ __('animals.animals') }}</a></li>
    <li class="breadcrumb-item active">{{ __('messages.view') }}</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-5">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h3 class="card-title mb-0"><i class="fas fa-horse mr-2"></i>{{ __('animals.animal') }}</h3>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr><th>{{ __('animals.type.label') }}</th><td><span class="badge badge-primary">{{ $animal->type_name }}</span></td></tr>
                    <tr><th>{{ __('animals.name') }}</th><td>{{ $animal->name ?: '—' }}</td></tr>
                    <tr><th>{{ __('animals.purchase_price') }}</th><td><strong>৳{{ number_format($animal->purchase_price, 2) }}</strong></td></tr>
                    <tr><th>{{ __('animals.total_shares') }}</th><td>{{ $animal->total_shares }}</td></tr>
                    <tr><th>{{ __('animals.assigned_shares') }}</th><td><span class="badge badge-info">{{ $animal->assigned_shares }}</span></td></tr>
                    <tr><th>{{ __('animals.available_shares') }}</th><td><span class="badge badge-{{ $animal->available_shares > 0 ? 'success' : 'danger' }}">{{ $animal->available_shares }}</span></td></tr>
                    <tr><th>{{ __('animals.share_price') }}</th><td>৳{{ number_format($animal->share_price, 2) }}</td></tr>
                    <tr><th>{{ __('animals.status.label') }}</th><td><span class="badge badge-{{ $animal->status_badge }}">{{ __('animals.status.' . $animal->status) }}</span></td></tr>
                </table>
            </div>
            <div class="card-footer">
                <a href="{{ route('animals.edit', $animal) }}" class="btn btn-info btn-sm"><i class="fas fa-edit mr-1"></i>{{ __('messages.edit') }}</a>
                <a href="{{ route('animals.index') }}" class="btn btn-secondary btn-sm ml-2"><i class="fas fa-arrow-left mr-1"></i>{{ __('messages.back') }}</a>
            </div>
        </div>
    </div>
    <div class="col-md-7">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title mb-0"><i class="fas fa-share-alt mr-2"></i>{{ __('shares.shares') }}</h3>
            </div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ __('partners.partner') }}</th>
                            <th>{{ __('shares.shares_count') }}</th>
                            <th>{{ __('shares.share_amount') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($animal->animalShares as $i => $share)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $share->partner->name }}</td>
                            <td class="text-center">{{ $share->shares }}</td>
                            <td>৳{{ number_format($share->share_amount, 2) }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center text-muted py-3">{{ __('messages.no_data_found') }}</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
