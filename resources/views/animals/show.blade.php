@extends('layouts.app')
@section('title', __('animals.animal'))
@section('page-title', $animal->type_name . ' — ' . ($animal->name ?: ''))
@section('breadcrumb')
    <span><a href="{{ route('animals.index') }}" class="hover:text-emerald-700">{{ __('animals.animals') }}</a></span>
    <i class="fa-solid fa-chevron-right text-[10px] text-gray-400"></i>
    <span class="text-gray-600">{{ __('messages.view') }}</span>
@endsection

@section('content')
@php
    $statusBadgeClass = [
        'warning'  => 'bg-amber-100 text-amber-800',
        'info'     => 'bg-sky-100 text-sky-700',
        'success'  => 'bg-emerald-100 text-emerald-800',
        'secondary'=> 'bg-gray-100 text-gray-600',
    ][$animal->status_badge] ?? 'bg-gray-100 text-gray-600';
@endphp
<div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
    <div class="lg:col-span-1">
        <div class="card">
            <div class="card-header bg-emerald-800">
                <h3 class="card-title text-white"><i class="fa-solid fa-horse"></i>{{ __('animals.animal') }}</h3>
            </div>
            <div class="card-body">
                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-1">
                    <div>
                        <p class="text-[12px] font-semibold text-gray-500">{{ __('animals.type.label') }}</p>
                        <p class="text-[14px] font-medium text-gray-900">
                            <span class="badge bg-sky-100 text-sky-700">{{ $animal->type_name }}</span>
                        </p>
                    </div>
                    <div>
                        <p class="text-[12px] font-semibold text-gray-500">{{ __('animals.name') }}</p>
                        <p class="text-[14px] font-medium text-gray-900">{{ $animal->name ?: '—' }}</p>
                    </div>
                    <div>
                        <p class="text-[12px] font-semibold text-gray-500">{{ __('animals.purchase_price') }}</p>
                        <p class="text-[14px] font-medium text-gray-900">৳{{ number_format($animal->purchase_price, 2) }}</p>
                    </div>
                    <div>
                        <p class="text-[12px] font-semibold text-gray-500">{{ __('animals.total_shares') }}</p>
                        <p class="text-[14px] font-medium text-gray-900">{{ $animal->total_shares }}</p>
                    </div>
                    <div>
                        <p class="text-[12px] font-semibold text-gray-500">{{ __('animals.assigned_shares') }}</p>
                        <p class="text-[14px] font-medium text-gray-900">
                            <span class="badge bg-sky-100 text-sky-700">{{ $animal->assigned_shares }}</span>
                        </p>
                    </div>
                    <div>
                        <p class="text-[12px] font-semibold text-gray-500">{{ __('animals.available_shares') }}</p>
                        <p class="text-[14px] font-medium text-gray-900">
                            <span class="badge {{ $animal->available_shares > 0 ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-700' }}">{{ $animal->available_shares }}</span>
                        </p>
                    </div>
                    <div>
                        <p class="text-[12px] font-semibold text-gray-500">{{ __('animals.share_price') }}</p>
                        <p class="text-[14px] font-medium text-gray-900">৳{{ number_format($animal->share_price, 2) }}</p>
                    </div>
                    <div>
                        <p class="text-[12px] font-semibold text-gray-500">{{ __('animals.status.label') }}</p>
                        <p class="text-[14px] font-medium text-gray-900">
                            <span class="badge {{ $statusBadgeClass }}">{{ __('animals.status.' . $animal->status) }}</span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-2 border-t border-gray-100 px-5 py-3">
                <a href="{{ route('animals.edit', $animal) }}" class="btn btn-info btn-sm">
                    <i class="fa-solid fa-pen"></i>{{ __('messages.edit') }}
                </a>
                <a href="{{ route('animals.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fa-solid fa-arrow-left"></i>{{ __('messages.back') }}
                </a>
            </div>
        </div>
    </div>

    <div class="lg:col-span-2">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fa-solid fa-share-nodes text-emerald-700"></i>{{ __('shares.shares') }}</h3>
            </div>
            <div class="table-wrap">
                <table class="datatable">
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
                            <td class="font-semibold text-gray-900">{{ $share->partner->name }}</td>
                            <td class="text-center">{{ $share->shares }}</td>
                            <td>৳{{ number_format($share->share_amount, 2) }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4">
                                <div class="empty-state">
                                    <i class="fa-solid fa-share-nodes text-3xl text-gray-300"></i>
                                    <span class="text-[13.5px]">{{ __('messages.no_data_found') }}</span>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
