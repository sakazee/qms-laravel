@extends('layouts.app')
@section('title', __('payments.payments'))
@section('page-title', __('payments.payments'))
@section('breadcrumb')
    <span class="text-gray-600">{{ __('payments.payments') }}</span>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fa-solid fa-money-bill-wave text-emerald-700"></i>{{ __('payments.payments') }}</h3>
        <div class="flex items-center gap-3">
            <span class="badge bg-emerald-100 text-emerald-800">
                {{ app()->getLocale() === 'bn' ? 'মোট: ৳' : 'Total: ৳' }}{{ number_format($payments->sum('amount'), 0) }}
            </span>
            <a href="{{ route('payments.create') }}" class="btn btn-primary btn-sm">
                <i class="fa-solid fa-plus"></i> {{ __('payments.create') }}
            </a>
        </div>
    </div>
    <div class="table-wrap">
        <table class="datatable">
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
                    <td>
                        <div class="font-semibold text-gray-900">{{ $payment->partner->name }}</div>
                    </td>
                    <td class="font-semibold text-emerald-700">৳{{ number_format($payment->amount, 0) }}</td>
                    <td>{{ $payment->payment_date->format('d M Y') }}</td>
                    <td>
                        <span class="badge bg-gray-100 text-gray-600">{{ $payment->payment_method_label }}</span>
                    </td>
                    <td>{{ $payment->reference ?: '—' }}</td>
                    <td>
                        <div class="flex items-center gap-1.5">
                            <a href="{{ route('payments.edit', $payment) }}" class="action-btn action-edit" title="{{ __('messages.edit') }}">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <form action="{{ route('payments.destroy', $payment) }}" method="POST" class="form-delete m-0">
                                @csrf @method('DELETE')
                                <button type="submit" class="action-btn action-delete" title="{{ __('messages.delete') }}">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7">
                        <div class="empty-state">
                            <i class="fa-solid fa-money-bill-wave text-3xl text-gray-300"></i>
                            <span class="text-[13.5px]">{{ __('messages.no_data_found') }}</span>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
