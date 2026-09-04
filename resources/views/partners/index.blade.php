@extends('layouts.app')
@section('title', __('partners.partners'))
@section('page-title', __('partners.partners'))
@section('breadcrumb')
    <li class="breadcrumb-item active">{{ __('partners.partners') }}</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title mb-0"><i class="fas fa-users text-success mr-2"></i>{{ __('partners.partners') }}</h3>
        <a href="{{ route('partners.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus mr-1"></i>{{ __('partners.create') }}
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover datatable mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ __('partners.name') }}</th>
                        <th>{{ __('partners.phone') }}</th>
                        <th>{{ __('partners.total_share') }}</th>
                        <th>{{ __('partners.total_paid') }}</th>
                        <th>{{ __('partners.due') }}</th>
                        <th>{{ __('partners.payment_status') }}</th>
                        <th>{{ __('messages.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($partners as $i => $partner)
                    @php
                        $totalShare = $partner->animalShares->sum('share_amount');
                        $totalPaid  = $partner->payments->sum('amount');
                        $due        = max(0, $totalShare - $totalPaid);
                        $status     = $due <= 0 ? 'paid' : ($totalPaid > 0 ? 'partial' : 'unpaid');
                        $badge      = ['paid' => 'success', 'partial' => 'warning', 'unpaid' => 'danger'][$status];
                    @endphp
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td><strong>{{ $partner->name }}</strong></td>
                        <td>{{ $partner->phone ?: '—' }}</td>
                        <td>৳{{ number_format($totalShare, 0) }}</td>
                        <td>৳{{ number_format($totalPaid, 0) }}</td>
                        <td>
                            @if($due > 0)
                                <span class="text-danger font-weight-bold">৳{{ number_format($due, 0) }}</span>
                            @else
                                <span class="text-success">—</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge badge-{{ $badge }}">
                                {{ __('partners.status_' . $status) }}
                            </span>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('partners.show', $partner) }}" class="btn btn-secondary"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('partners.edit', $partner) }}" class="btn btn-info"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('partners.destroy', $partner) }}" method="POST" class="form-delete d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="8" class="text-center py-4 text-muted"><i class="fas fa-users fa-2x mb-2 d-block"></i>{{ __('messages.no_data_found') }}</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
