@extends('layouts.app')
@section('title', $partner->name)
@section('page-title', $partner->name)
@section('breadcrumb')
    <span><a href="{{ route('partners.index') }}" class="hover:text-emerald-700">{{ __('partners.partners') }}</a></span>
    <i class="fa-solid fa-chevron-right text-[11px] text-gray-400"></i>
    <span class="text-gray-600">{{ __('messages.view') }}</span>
@endsection

@section('content')
@php
    $totalShare = $partner->animalShares->sum('share_amount');
    $totalPaid  = $partner->payments->sum('amount');
    $due        = max(0, $totalShare - $totalPaid);
    $advance    = max(0, $totalPaid - $totalShare);
@endphp

<div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
    <div class="lg:col-span-1">
        <div class="card">
            <div class="flex flex-col items-center gap-3 border-b border-gray-100 px-5 py-6">
                <div class="flex h-20 w-20 items-center justify-center rounded-full bg-emerald-800 text-[32px] font-bold text-white">
                    {{ strtoupper(mb_substr($partner->name, 0, 1)) }}
                </div>
                <div class="text-center">
                    <h4 class="font-serif text-[17px] font-bold text-gray-900">{{ $partner->name }}</h4>
                    @if($partner->phone)
                        <p class="mt-1 inline-flex items-center gap-1.5 text-[14px] text-gray-500"><i class="fa-solid fa-phone"></i>{{ $partner->phone }}</p>
                    @endif
                    @if($partner->address)
                        <p class="mt-0.5 inline-flex items-center gap-1.5 text-[14px] text-gray-500"><i class="fa-solid fa-location-dot"></i>{{ $partner->address }}</p>
                    @endif
                </div>
            </div>
            <div class="grid grid-cols-3 divide-x divide-gray-100 border-b border-gray-100">
                <div class="px-3 py-4 text-center">
                    <div class="text-[15px] font-bold text-sky-700">৳{{ format_amount($totalShare, 0) }}</div>
                    <div class="mt-0.5 text-[12.5px] text-gray-500">{{ __('partners.total_share') }}</div>
                </div>
                <div class="px-3 py-4 text-center">
                    <div class="text-[15px] font-bold text-emerald-700">৳{{ format_amount($totalPaid, 0) }}</div>
                    <div class="mt-0.5 text-[12.5px] text-gray-500">{{ __('partners.total_paid') }}</div>
                </div>
                <div class="px-3 py-4 text-center">
                    <div class="text-[15px] font-bold {{ $due > 0 ? 'text-rose-700' : 'text-emerald-700' }}">৳{{ format_amount($due, 0) }}</div>
                    <div class="mt-0.5 text-[12.5px] text-gray-500">{{ __('partners.due') }}</div>
                </div>
            </div>
            <div class="flex flex-col gap-2 px-5 py-4">
                <a href="{{ route('payments.create', ['partner_id' => $partner->id]) }}" class="btn btn-primary w-full">
                    <i class="fa-solid fa-money-bill-wave"></i>{{ __('payments.take_payment') }}
                </a>
                <a href="{{ route('shares.create', ['partner_id' => $partner->id]) }}" class="btn btn-info w-full">
                    <i class="fa-solid fa-share-nodes"></i>{{ __('shares.add_animal_share') }}
                </a>
                <a href="{{ route('partners.edit', $partner) }}" class="btn btn-secondary w-full">
                    <i class="fa-solid fa-pen"></i>{{ __('messages.edit') }}
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
                            <th>{{ __('animals.animal') }}</th>
                            <th>{{ __('animals.type.label') }}</th>
                            <th>{{ __('shares.shares_count') }}</th>
                            <th>{{ __('shares.share_amount') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($partner->animalShares as $share)
                        <tr>
                            <td class="font-semibold text-gray-900">{{ $share->animal->name ?: $share->animal->type_name }}</td>
                            <td>{{ $share->animal->type_name }}</td>
                            <td class="text-center">{{ $share->shares }}</td>
                            <td>৳{{ format_amount($share->share_amount, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fa-solid fa-money-bill-wave text-emerald-700"></i>{{ __('payments.payments') }}</h3>
            </div>
            <div class="table-wrap">
                <table class="datatable">
                    <thead>
                        <tr>
                            <th>{{ __('payments.payment_date') }}</th>
                            <th>{{ __('payments.amount') }}</th>
                            <th>{{ __('payments.payment_method') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($partner->payments as $payment)
                        <tr>
                            <td>{{ $payment->payment_date->format('d M Y') }}</td>
                            <td>৳{{ format_amount($payment->amount, 2) }}</td>
                            <td>{{ $payment->payment_method_label }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
