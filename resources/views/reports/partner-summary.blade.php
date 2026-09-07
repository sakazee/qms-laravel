@extends('layouts.app')
@section('title', __('reports.partner_summary'))
@section('page-title', __('reports.partner_summary'))
@section('breadcrumb')
    <span class="text-gray-600">{{ __('reports.partner_summary') }}</span>
@endsection

@section('content')
<div class="mb-3 flex justify-end gap-2 print:hidden">
    <a href="{{ route('reports.partner-summary.pdf') }}" class="btn btn-secondary btn-sm">
        <i class="fa-solid fa-file-pdf"></i>{{ __('reports.download_pdf') }}
    </a>
    <button onclick="window.print()" class="btn btn-secondary btn-sm">
        <i class="fa-solid fa-print"></i>{{ __('reports.print') }}
    </button>
</div>

<div class="card">
    <div class="card-header"><h3 class="card-title"><i class="fa-solid fa-users text-sky-700"></i>{{ __('reports.partner_summary') }}</h3></div>
    <div class="table-wrap">
        <table class="w-full text-[14px]">
            <thead class="border-b border-gray-200 bg-paper-100">
                <tr>
                    <th class="px-4 py-3 text-left text-[13px] font-bold uppercase tracking-wide text-gray-600">#</th>
                    <th class="px-4 py-3 text-left text-[13px] font-bold uppercase tracking-wide text-gray-600">{{ __('partners.name') }}</th>
                    <th class="px-4 py-3 text-left text-[13px] font-bold uppercase tracking-wide text-gray-600">{{ __('partners.phone') }}</th>
                    <th class="px-4 py-3 text-left text-[13px] font-bold uppercase tracking-wide text-gray-600">{{ __('partners.total_share') }}</th>
                    <th class="px-4 py-3 text-left text-[13px] font-bold uppercase tracking-wide text-gray-600">{{ __('partners.total_paid') }}</th>
                    <th class="px-4 py-3 text-left text-[13px] font-bold uppercase tracking-wide text-gray-600">{{ __('partners.due') }}</th>
                    <th class="px-4 py-3 text-left text-[13px] font-bold uppercase tracking-wide text-gray-600">{{ __('partners.advance') }}</th>
                    <th class="px-4 py-3 text-left text-[13px] font-bold uppercase tracking-wide text-gray-600">{{ __('partners.payment_status') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($partners as $i => $row)
                @php
                    $p      = $row['partner'];
                    $status = $row['due'] <= 0 ? 'paid' : ($row['total_paid'] > 0 ? 'partial' : 'unpaid');
                    $badge  = ['paid' => 'bg-emerald-100 text-emerald-800', 'partial' => 'bg-amber-100 text-amber-700', 'unpaid' => 'bg-rose-100 text-rose-700'][$status];
                @endphp
                <tr>
                    <td class="border-b border-gray-100 px-4 py-3 text-gray-700">{{ format_amount($i+1, 0) }}</td>
                    <td class="border-b border-gray-100 px-4 py-3 text-gray-900 font-semibold">{{ $p->name }}</td>
                    <td class="border-b border-gray-100 px-4 py-3 text-gray-700">{{ $p->phone ?: '—' }}</td>
                    <td class="border-b border-gray-100 px-4 py-3 text-gray-700">৳{{ format_amount($row['total_share'],0) }}</td>
                    <td class="border-b border-gray-100 px-4 py-3 text-emerald-700">৳{{ format_amount($row['total_paid'],0) }}</td>
                    <td class="border-b border-gray-100 px-4 py-3 {{ $row['due']>0 ? 'font-semibold text-rose-700' : 'text-gray-700' }}">
                        {{ $row['due']>0 ? '৳'.format_amount($row['due'],0) : '—' }}
                    </td>
                    <td class="border-b border-gray-100 px-4 py-3 {{ $row['advance']>0 ? 'text-sky-700' : 'text-gray-700' }}">
                        {{ $row['advance']>0 ? '৳'.format_amount($row['advance'],0) : '—' }}
                    </td>
                    <td class="border-b border-gray-100 px-4 py-3 text-gray-700"><span class="badge {{ $badge }}">{{ __('partners.status_'.$status) }}</span></td>
                </tr>
                @empty
                <tr>
                    <td colspan="8">
                        <div class="empty-state">
                            <i class="fa-solid fa-users text-3xl text-gray-300"></i>
                            <span class="text-[14.5px]">{{ __('messages.no_data_found') }}</span>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
            @if($partners->count())
            <tfoot>
                <tr class="bg-paper-100 font-semibold text-gray-900">
                    <td colspan="3" class="border-t border-gray-200 px-4 py-3">{{ __('messages.total') }}</td>
                    <td class="border-t border-gray-200 px-4 py-3">৳{{ format_amount($partners->sum('total_share'),0) }}</td>
                    <td class="border-t border-gray-200 px-4 py-3">৳{{ format_amount($partners->sum('total_paid'),0) }}</td>
                    <td class="border-t border-gray-200 px-4 py-3">৳{{ format_amount($partners->sum('due'),0) }}</td>
                    <td class="border-t border-gray-200 px-4 py-3">৳{{ format_amount($partners->sum('advance'),0) }}</td>
                    <td class="border-t border-gray-200 px-4 py-3"></td>
                </tr>
            </tfoot>
            @endif
        </table>
    </div>
</div>
@endsection
