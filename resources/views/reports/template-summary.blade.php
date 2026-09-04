@extends('layouts.app')
@section('title', __('reports.template_summary'))
@section('page-title', __('reports.template_summary'))
@section('breadcrumb')
    <li class="breadcrumb-item active">{{ __('reports.template_summary') }}</li>
@endsection

@section('content')
{{-- Actions --}}
<div class="mb-3 d-flex justify-content-end">
    <a href="{{ route('reports.template-summary.pdf') }}" class="btn btn-danger">
        <i class="fas fa-file-pdf mr-1"></i>{{ __('reports.download_pdf') }}
    </a>
    <button onclick="window.print()" class="btn btn-secondary ml-2">
        <i class="fas fa-print mr-1"></i>{{ __('reports.print') }}
    </button>
</div>

{{-- Stats Summary --}}
<div class="row">
    @php
        $cards = [
            ['label' => __('reports.total_animals'),    'value' => $stats['total_animals'],    'icon' => 'horse',       'color' => 'success'],
            ['label' => __('reports.total_partners'),   'value' => $stats['total_partners'],   'icon' => 'users',       'color' => 'info'],
            ['label' => __('reports.total_animal_cost'),'value' => '৳'.number_format($stats['total_animal_cost'],0), 'icon' => 'horse-head', 'color' => 'primary'],
            ['label' => __('reports.total_expenses'),   'value' => '৳'.number_format($stats['total_expenses'],0),    'icon' => 'receipt',    'color' => 'warning'],
            ['label' => __('reports.total_cost'),       'value' => '৳'.number_format($stats['total_cost'],0),        'icon' => 'calculator', 'color' => 'dark'],
            ['label' => __('reports.total_collection'), 'value' => '৳'.number_format($stats['total_collection'],0),  'icon' => 'money-bill-wave', 'color' => 'teal'],
            ['label' => __('reports.due'),              'value' => '৳'.number_format($stats['due'],0),               'icon' => 'exclamation-circle', 'color' => $stats['due']>0?'danger':'secondary'],
            ['label' => __('reports.advance'),          'value' => '৳'.number_format($stats['advance'],0),           'icon' => 'piggy-bank', 'color' => 'indigo'],
        ];
    @endphp
    @foreach($cards as $card)
    <div class="col-lg-3 col-md-4 col-6 mb-3">
        <div class="info-box bg-{{ $card['color'] }}">
            <span class="info-box-icon"><i class="fas fa-{{ $card['icon'] }}"></i></span>
            <div class="info-box-content">
                <span class="info-box-text" style="font-size:11px">{{ $card['label'] }}</span>
                <span class="info-box-number" style="font-size:16px;font-weight:700">{{ $card['value'] }}</span>
            </div>
        </div>
    </div>
    @endforeach
</div>

{{-- Animals Table --}}
<div class="card">
    <div class="card-header"><h3 class="card-title mb-0"><i class="fas fa-horse mr-2"></i>{{ __('animals.animals') }}</h3></div>
    <div class="card-body p-0">
        <table class="table table-bordered mb-0">
            <thead class="thead-light">
                <tr>
                    <th>#</th><th>{{ __('animals.type.label') }}</th><th>{{ __('animals.name') }}</th>
                    <th>{{ __('animals.purchase_price') }}</th><th>{{ __('animals.total_shares') }}</th>
                    <th>{{ __('animals.assigned_shares') }}</th><th>{{ __('animals.status.label') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($template->animals as $i => $animal)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td>{{ $animal->type_name }}</td>
                    <td>{{ $animal->name ?: '—' }}</td>
                    <td>৳{{ number_format($animal->purchase_price,0) }}</td>
                    <td class="text-center">{{ $animal->total_shares }}</td>
                    <td class="text-center">{{ $animal->assigned_shares }}</td>
                    <td><span class="badge badge-{{ $animal->status_badge }}">{{ __('animals.status.'.$animal->status) }}</span></td>
                </tr>
                @endforeach
                <tr class="font-weight-bold table-light">
                    <td colspan="3">{{ __('messages.total') }}</td>
                    <td>৳{{ number_format($template->animals->sum('purchase_price'),0) }}</td>
                    <td class="text-center">{{ $template->animals->sum('total_shares') }}</td>
                    <td colspan="2"></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

{{-- Expenses Table --}}
@if($template->expenses->count())
<div class="card">
    <div class="card-header"><h3 class="card-title mb-0"><i class="fas fa-file-invoice-dollar mr-2"></i>{{ __('expenses.expenses') }}</h3></div>
    <div class="card-body p-0">
        <table class="table table-bordered mb-0">
            <thead class="thead-light">
                <tr><th>#</th><th>{{ __('expenses.title') }}</th><th>{{ __('expenses.distribution_type') }}</th><th>{{ __('expenses.expense_date') }}</th><th>{{ __('expenses.amount') }}</th></tr>
            </thead>
            <tbody>
                @foreach($template->expenses as $i => $expense)
                <tr>
                    <td>{{ $i+1 }}</td><td>{{ $expense->title }}</td>
                    <td>{{ $expense->distribution_type_label }}</td>
                    <td>{{ $expense->expense_date->format('d M Y') }}</td>
                    <td>৳{{ number_format($expense->amount,0) }}</td>
                </tr>
                @endforeach
                <tr class="font-weight-bold table-light">
                    <td colspan="4">{{ __('messages.total') }}</td>
                    <td>৳{{ number_format($template->expenses->sum('amount'),0) }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endif
@endsection
