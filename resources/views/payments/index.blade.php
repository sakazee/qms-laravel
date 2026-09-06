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
                {{ app()->getLocale() === 'bn' ? 'মোট: ৳' : 'Total: ৳' }}{{ format_amount($payments->sum('amount'), 0) }}
            </span>
            <button type="submit" form="bulk-form" class="btn btn-danger btn-sm bulk-delete-btn" disabled
                    title="{{ __('messages.delete_selected') }}">
                <i class="fa-solid fa-trash-can"></i>{{ __('messages.delete_selected') }} <span class="bulk-count"></span>
            </button>
            <a href="{{ route('payments.create') }}" class="btn btn-primary btn-sm">
                <i class="fa-solid fa-plus"></i> {{ __('payments.create') }}
            </a>
        </div>
    </div>
    <form id="bulk-form" action="{{ route('payments.bulk-destroy') }}" method="POST" class="bulk-form">
        @csrf
    <div class="table-wrap">
        <table class="datatable">
            <thead>
                <tr>
                    <th class="w-10"><input type="checkbox" class="bulk-select-all" title="{{ __('messages.select_all') }}"></th>
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
                @foreach($payments as $i => $payment)
                <tr>
                    <td><input type="checkbox" class="bulk-checkbox" value="{{ $payment->id }}"></td>
                    <td>{{ format_amount($i + 1, 0) }}</td>
                    <td>
                        <div class="font-semibold text-gray-900">{{ $payment->partner->name }}</div>
                    </td>
                    <td class="font-semibold text-emerald-700">৳{{ format_amount($payment->amount, 0) }}</td>
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
                @endforeach
            </tbody>
        </table>
    </div>
    </form>
</div>
@endsection
