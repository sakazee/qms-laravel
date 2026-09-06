@extends('layouts.app')
@section('title', __('reports.partner_due_summary'))
@section('page-title', __('reports.partner_due_summary'))
@section('breadcrumb')
    <span class="text-gray-600">{{ __('reports.partner_due_summary') }}</span>
@endsection

@section('content')
<div class="mb-3 flex justify-end gap-2 print:hidden">
    <a href="{{ route('reports.partner-due-summary.pdf') }}" class="btn btn-secondary btn-sm">
        <i class="fa-solid fa-file-pdf"></i>{{ __('reports.download_pdf') }}
    </a>
    <button onclick="window.print()" class="btn btn-secondary btn-sm">
        <i class="fa-solid fa-print"></i>{{ __('reports.print') }}
    </button>
</div>

<div class="card">
    <div class="card-header"><h3 class="card-title"><i class="fa-solid fa-scale-balanced text-sky-700"></i>{{ __('reports.partner_due_summary') }}</h3></div>
    <div class="table-wrap">
        <table class="w-full text-[13px]">
            <thead class="border-b border-gray-200 bg-paper-100">
                <tr>
                    <th class="px-4 py-3 text-left text-[12px] font-bold uppercase tracking-wide text-gray-600">#</th>
                    <th class="px-4 py-3 text-left text-[12px] font-bold uppercase tracking-wide text-gray-600">{{ __('partners.name') }}</th>
                    <th class="px-4 py-3 text-right text-[12px] font-bold uppercase tracking-wide text-gray-600">{{ __('reports.total_shares') }}</th>
                    <th class="px-4 py-3 text-right text-[12px] font-bold uppercase tracking-wide text-gray-600">{{ __('reports.total_due') }}</th>
                    <th class="px-4 py-3 text-right text-[12px] font-bold uppercase tracking-wide text-gray-600">{{ __('reports.total_paid') }}</th>
                    <th class="px-4 py-3 text-right text-[12px] font-bold uppercase tracking-wide text-gray-600">{{ __('reports.balance') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($partners as $i => $row)
                @php
                    $p = $row['partner'];
                @endphp
                <tr>
                    <td class="border-b border-gray-100 px-4 py-3 text-gray-700">{{ format_amount($i+1, 0) }}</td>
                    <td class="border-b border-gray-100 px-4 py-3 text-gray-900 font-semibold">{{ $p->name }}</td>
                    <td class="border-b border-gray-100 px-4 py-3 text-right text-gray-700">{{ format_amount($row['total_shares'], 0) }}</td>
                    <td class="border-b border-gray-100 px-4 py-3 text-right text-gray-900 font-semibold">৳{{ format_amount($row['total_due'],0) }}</td>
                    <td class="border-b border-gray-100 px-4 py-3 text-right text-emerald-700">৳{{ format_amount($row['total_paid'],0) }}</td>
                    <td class="border-b border-gray-100 px-4 py-3 text-right {{ $row['balance']>0 ? 'font-semibold text-rose-700' : 'text-gray-700' }}">
                        ৳{{ format_amount($row['balance'],0) }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6">
                        <div class="empty-state">
                            <i class="fa-solid fa-scale-balanced text-3xl text-gray-300"></i>
                            <span class="text-[13.5px]">{{ __('messages.no_data_found') }}</span>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
            @if($partners->count())
            <tfoot>
                <tr class="bg-paper-100 font-semibold text-gray-900">
                    <td colspan="2" class="border-t border-gray-200 px-4 py-3">{{ __('messages.total') }}</td>
                    <td class="border-t border-gray-200 px-4 py-3 text-right">{{ format_amount($partners->sum('total_shares'),0) }}</td>
                    <td class="border-t border-gray-200 px-4 py-3 text-right">৳{{ format_amount($partners->sum('total_due'),0) }}</td>
                    <td class="border-t border-gray-200 px-4 py-3 text-right">৳{{ format_amount($partners->sum('total_paid'),0) }}</td>
                    <td class="border-t border-gray-200 px-4 py-3 text-right">৳{{ format_amount($partners->sum('balance'),0) }}</td>
                </tr>
            </tfoot>
            @endif
        </table>
    </div>
</div>
@endsection