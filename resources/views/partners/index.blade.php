@extends('layouts.app')
@section('title', __('partners.partners'))
@section('page-title', __('partners.partners'))
@section('breadcrumb')
    <span class="text-gray-600">{{ __('partners.partners') }}</span>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fa-solid fa-users text-emerald-700"></i>{{ __('partners.partners') }}</h3>
        <div class="flex items-center gap-3">
            <button type="submit" form="bulk-form" class="btn btn-danger btn-sm bulk-delete-btn" disabled
                    title="{{ __('messages.delete_selected') }}">
                <i class="fa-solid fa-trash-can"></i>{{ __('messages.delete_selected') }} <span class="bulk-count"></span>
            </button>
            <a href="{{ route('partners.create') }}" class="btn btn-primary btn-sm">
                <i class="fa-solid fa-plus"></i> {{ __('partners.create') }}
            </a>
        </div>
    </div>
    <form id="bulk-form" action="{{ route('partners.bulk-destroy') }}" method="POST" class="bulk-form">
        @csrf
    </form>
    <div class="table-wrap">
        <table class="datatable">
            <thead>
                <tr>
                    <th class="w-10"><input type="checkbox" class="bulk-select-all" title="{{ __('messages.select_all') }}"></th>
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
                @foreach($partners as $i => $partner)
                @php
                    $totalShare = $partner->animalShares->sum('share_amount');
                    $totalPaid  = $partner->payments->sum('amount');
                    $due        = max(0, $totalShare - $totalPaid);
                    $status     = $due <= 0 ? 'paid' : ($totalPaid > 0 ? 'partial' : 'unpaid');
                    $badgeClass = ['paid' => 'bg-emerald-100 text-emerald-800', 'partial' => 'bg-amber-100 text-amber-800', 'unpaid' => 'bg-rose-100 text-rose-700'][$status];
                @endphp
                <tr>
                    <td><input type="checkbox" class="bulk-checkbox" value="{{ $partner->id }}"></td>
                    <td>{{ format_amount($i + 1, 0) }}</td>
                    <td class="font-semibold text-gray-900">{{ $partner->name }}</td>
                    <td>{{ $partner->phone ?: '—' }}</td>
                    <td>৳{{ format_amount($totalShare, 0) }}</td>
                    <td>৳{{ format_amount($totalPaid, 0) }}</td>
                    <td>
                        @if($due > 0)
                            <span class="font-semibold text-rose-700">৳{{ format_amount($due, 0) }}</span>
                        @else
                            <span class="text-emerald-700">—</span>
                        @endif
                    </td>
                    <td>
                        <span class="badge {{ $badgeClass }}">
                            {{ __('partners.status_' . $status) }}
                        </span>
                    </td>
                    <td>
                        <div class="flex items-center gap-1.5">
                            <a href="{{ route('partners.show', $partner) }}" class="action-btn action-view" title="{{ __('messages.view') }}">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            <a href="{{ route('partners.edit', $partner) }}" class="action-btn action-edit" title="{{ __('messages.edit') }}">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <form action="{{ route('partners.destroy', $partner) }}" method="POST" class="form-delete m-0">
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
</div>
@endsection
