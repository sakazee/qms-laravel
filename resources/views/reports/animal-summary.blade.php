@extends('layouts.app')
@section('title', __('reports.animal_summary'))
@section('page-title', __('reports.animal_summary'))
@section('breadcrumb')
    <li class="breadcrumb-item active">{{ __('reports.animal_summary') }}</li>
@endsection
@section('content')
<div class="mb-3 d-flex justify-content-end">
    <a href="{{ route('reports.animal-summary.pdf') }}" class="btn btn-danger">
        <i class="fas fa-file-pdf mr-1"></i>{{ __('reports.download_pdf') }}
    </a>
</div>
<div class="card">
    <div class="card-header"><h3 class="card-title mb-0"><i class="fas fa-horse mr-2"></i>{{ __('reports.animal_summary') }}</h3></div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-bordered mb-0">
                <thead class="thead-light">
                    <tr><th>#</th><th>{{ __('animals.type.label') }}</th><th>{{ __('animals.name') }}</th><th>{{ __('animals.purchase_price') }}</th><th>{{ __('animals.total_shares') }}</th><th>{{ __('animals.assigned_shares') }}</th><th>{{ __('animals.available_shares') }}</th><th>{{ app()->getLocale() === 'bn' ? 'অংশীদারগণ' : 'Partners' }}</th><th>{{ __('animals.status.label') }}</th></tr>
                </thead>
                <tbody>
                    @forelse($template->animals as $i => $animal)
                    <tr>
                        <td>{{ $i+1 }}</td>
                        <td><span class="badge badge-primary">{{ $animal->type_name }}</span></td>
                        <td>{{ $animal->name ?: '—' }}</td>
                        <td>৳{{ number_format($animal->purchase_price,0) }}</td>
                        <td class="text-center">{{ $animal->total_shares }}</td>
                        <td class="text-center"><span class="badge badge-info">{{ $animal->assigned_shares }}</span></td>
                        <td class="text-center"><span class="badge badge-{{ $animal->available_shares > 0 ? 'success' : 'secondary' }}">{{ $animal->available_shares }}</span></td>
                        <td>@foreach($animal->animalShares as $share)<small class="badge badge-light border mr-1">{{ $share->partner->name }}</small>@endforeach</td>
                        <td><span class="badge badge-{{ $animal->status_badge }}">{{ __('animals.status.'.$animal->status) }}</span></td>
                    </tr>
                    @empty
                    <tr><td colspan="9" class="text-center py-4 text-muted">{{ __('messages.no_data_found') }}</td></tr>
                    @endforelse
                </tbody>
                @if($template->animals->count())
                <tfoot class="font-weight-bold table-light">
                    <tr><td colspan="3">{{ __('messages.total') }}</td><td>৳{{ number_format($template->animals->sum('purchase_price'),0) }}</td><td class="text-center">{{ $template->animals->sum('total_shares') }}</td><td colspan="4"></td></tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>
</div>
@endsection
