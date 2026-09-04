@extends('layouts.app')
@section('title', __('reports.partner_summary'))
@section('page-title', __('reports.partner_summary'))
@section('breadcrumb')
    <li class="breadcrumb-item active">{{ __('reports.partner_summary') }}</li>
@endsection

@section('content')
<div class="mb-3 d-flex justify-content-end">
    <a href="{{ route('reports.partner-summary.pdf') }}" class="btn btn-danger">
        <i class="fas fa-file-pdf mr-1"></i>{{ __('reports.download_pdf') }}
    </a>
</div>

<div class="card">
    <div class="card-header"><h3 class="card-title mb-0"><i class="fas fa-users mr-2"></i>{{ __('reports.partner_summary') }}</h3></div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-bordered mb-0">
                <thead class="thead-light">
                    <tr>
                        <th>#</th>
                        <th>{{ __('partners.name') }}</th>
                        <th>{{ __('partners.phone') }}</th>
                        <th>{{ __('partners.total_share') }}</th>
                        <th>{{ __('partners.total_paid') }}</th>
                        <th>{{ __('partners.due') }}</th>
                        <th>{{ __('partners.advance') }}</th>
                        <th>{{ __('partners.payment_status') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($partners as $i => $row)
                    @php
                        $p      = $row['partner'];
                        $status = $row['due'] <= 0 ? 'paid' : ($row['total_paid'] > 0 ? 'partial' : 'unpaid');
                        $badge  = ['paid' => 'success', 'partial' => 'warning', 'unpaid' => 'danger'][$status];
                    @endphp
                    <tr>
                        <td>{{ $i+1 }}</td>
                        <td><strong>{{ $p->name }}</strong></td>
                        <td>{{ $p->phone ?: '—' }}</td>
                        <td>৳{{ number_format($row['total_share'],0) }}</td>
                        <td class="text-success">৳{{ number_format($row['total_paid'],0) }}</td>
                        <td class="{{ $row['due']>0 ? 'text-danger font-weight-bold' : '' }}">
                            {{ $row['due']>0 ? '৳'.number_format($row['due'],0) : '—' }}
                        </td>
                        <td class="{{ $row['advance']>0 ? 'text-info' : '' }}">
                            {{ $row['advance']>0 ? '৳'.number_format($row['advance'],0) : '—' }}
                        </td>
                        <td><span class="badge badge-{{ $badge }}">{{ __('partners.status_'.$status) }}</span></td>
                    </tr>
                    @empty
                    <tr><td colspan="8" class="text-center py-4 text-muted">{{ __('messages.no_data_found') }}</td></tr>
                    @endforelse
                </tbody>
                @if($partners->count())
                <tfoot class="font-weight-bold table-light">
                    <tr>
                        <td colspan="3">{{ __('messages.total') }}</td>
                        <td>৳{{ number_format($partners->sum('total_share'),0) }}</td>
                        <td>৳{{ number_format($partners->sum('total_paid'),0) }}</td>
                        <td>৳{{ number_format($partners->sum('due'),0) }}</td>
                        <td>৳{{ number_format($partners->sum('advance'),0) }}</td>
                        <td></td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>
</div>
@endsection
