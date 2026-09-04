@extends('layouts.app')
@section('title', $partner->name)
@section('page-title', $partner->name)
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('partners.index') }}">{{ __('partners.partners') }}</a></li>
    <li class="breadcrumb-item active">{{ __('messages.view') }}</li>
@endsection

@section('content')
@php
    $totalShare = $partner->animalShares->sum('share_amount');
    $totalPaid  = $partner->payments->sum('amount');
    $due        = max(0, $totalShare - $totalPaid);
    $advance    = max(0, $totalPaid - $totalShare);
@endphp
<div class="row">
    <div class="col-md-4">
        <div class="card card-primary card-outline">
            <div class="card-body text-center pt-4">
                <div class="rounded-circle bg-success text-white d-inline-flex align-items-center justify-content-center mb-3"
                     style="width:80px;height:80px;font-size:32px;font-weight:700">
                    {{ strtoupper(mb_substr($partner->name, 0, 1)) }}
                </div>
                <h4 class="font-weight-bold">{{ $partner->name }}</h4>
                @if($partner->phone)<p class="text-muted"><i class="fas fa-phone mr-1"></i>{{ $partner->phone }}</p>@endif
                @if($partner->address)<p class="text-muted"><i class="fas fa-map-marker-alt mr-1"></i>{{ $partner->address }}</p>@endif
            </div>
            <div class="card-footer p-0">
                <div class="row text-center" style="border-top:1px solid #eee">
                    <div class="col-4 p-3 border-right">
                        <div class="font-weight-bold text-info">৳{{ number_format($totalShare, 0) }}</div>
                        <small class="text-muted">{{ __('partners.total_share') }}</small>
                    </div>
                    <div class="col-4 p-3 border-right">
                        <div class="font-weight-bold text-success">৳{{ number_format($totalPaid, 0) }}</div>
                        <small class="text-muted">{{ __('partners.total_paid') }}</small>
                    </div>
                    <div class="col-4 p-3">
                        <div class="font-weight-bold text-{{ $due > 0 ? 'danger' : 'success' }}">৳{{ number_format($due, 0) }}</div>
                        <small class="text-muted">{{ __('partners.due') }}</small>
                    </div>
                </div>
            </div>
        </div>
        <a href="{{ route('partners.edit', $partner) }}" class="btn btn-info btn-block"><i class="fas fa-edit mr-1"></i>{{ __('messages.edit') }}</a>
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-header"><h3 class="card-title mb-0"><i class="fas fa-share-alt mr-2"></i>{{ __('shares.shares') }}</h3></div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead><tr><th>{{ __('animals.animal') }}</th><th>{{ __('animals.type.label') }}</th><th>{{ __('shares.shares_count') }}</th><th>{{ __('shares.share_amount') }}</th></tr></thead>
                    <tbody>
                        @forelse($partner->animalShares as $share)
                        <tr>
                            <td>{{ $share->animal->name ?: $share->animal->type_name }}</td>
                            <td>{{ $share->animal->type_name }}</td>
                            <td class="text-center">{{ $share->shares }}</td>
                            <td>৳{{ number_format($share->share_amount, 2) }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center py-3 text-muted">{{ __('messages.no_data_found') }}</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card">
            <div class="card-header"><h3 class="card-title mb-0"><i class="fas fa-money-bill-wave mr-2"></i>{{ __('payments.payments') }}</h3></div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead><tr><th>{{ __('payments.payment_date') }}</th><th>{{ __('payments.amount') }}</th><th>{{ __('payments.payment_method') }}</th></tr></thead>
                    <tbody>
                        @forelse($partner->payments as $payment)
                        <tr>
                            <td>{{ $payment->payment_date->format('d M Y') }}</td>
                            <td>৳{{ number_format($payment->amount, 2) }}</td>
                            <td>{{ $payment->payment_method_label }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="text-center py-3 text-muted">{{ __('messages.no_data_found') }}</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
