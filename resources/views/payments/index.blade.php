@extends('layouts.app')
@section('title', __('payments.payments'))
@section('page-title', __('payments.payments'))
@section('breadcrumb')
    <li class="breadcrumb-item active">{{ __('payments.payments') }}</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title mb-0"><i class="fas fa-money-bill-wave text-success mr-2"></i>{{ __('payments.payments') }}</h3>
        <div>
            <span class="badge badge-success mr-3" style="font-size:14px">
                {{ app()->getLocale() === 'bn' ? 'মোট: ৳' : 'Total: ৳' }}{{ number_format($payments->sum('amount'), 0) }}
            </span>
            <div class="btn-group btn-group-sm mr-2">
                @foreach($partners as $p)
                @endforeach
            </div>
            <a href="{{ route('payments.create') }}" class="btn btn-success btn-sm">
                <i class="fas fa-plus mr-1"></i>{{ __('payments.create') }}
            </a>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover datatable mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ __('payments.partner') }}</th>
                        <th>{{ __('payments.amount') }}</th>
                        <th>{{ __('payments.payment_date') }}</th>
                        <th>{{ __('payments.payment_method') }}</th>
                        <th>{{ __('payments.reference') }}</th>
                        <th>{{ __('messages.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $i => $payment)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td><strong>{{ $payment->partner->name }}</strong></td>
                        <td><strong class="text-success">৳{{ number_format($payment->amount, 0) }}</strong></td>
                        <td>{{ $payment->payment_date->format('d M Y') }}</td>
                        <td>
                            <span class="badge badge-secondary">{{ $payment->payment_method_label }}</span>
                        </td>
                        <td>{{ $payment->reference ?: '—' }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('payments.edit', $payment) }}" class="btn btn-info"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('payments.destroy', $payment) }}" method="POST" class="form-delete d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center py-4 text-muted"><i class="fas fa-money-bill-wave fa-2x mb-2 d-block"></i>{{ __('messages.no_data_found') }}</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
