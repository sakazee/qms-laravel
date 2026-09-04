@extends('layouts.app')
@section('title', __('expenses.expenses'))
@section('page-title', __('expenses.expenses'))
@section('breadcrumb')
    <li class="breadcrumb-item active">{{ __('expenses.expenses') }}</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title mb-0"><i class="fas fa-file-invoice-dollar text-warning mr-2"></i>{{ __('expenses.expenses') }}</h3>
        <div>
            <span class="badge badge-warning text-dark mr-3" style="font-size:14px">
                {{ app()->getLocale() === 'bn' ? 'মোট: ৳' : 'Total: ৳' }}{{ number_format($expenses->sum('amount'), 0) }}
            </span>
            <a href="{{ route('expenses.create') }}" class="btn btn-warning btn-sm text-dark">
                <i class="fas fa-plus mr-1"></i>{{ __('expenses.create') }}
            </a>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover datatable mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ __('expenses.title') }}</th>
                        <th>{{ __('expenses.amount') }}</th>
                        <th>{{ __('expenses.distribution_type') }}</th>
                        <th>{{ __('expenses.expense_date') }}</th>
                        <th>{{ app()->getLocale() === 'bn' ? 'বিতরণ' : 'Distributions' }}</th>
                        <th>{{ __('messages.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($expenses as $i => $expense)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>
                            <strong>{{ $expense->title }}</strong>
                            @if($expense->description)
                            <br><small class="text-muted">{{ Str::limit($expense->description, 50) }}</small>
                            @endif
                        </td>
                        <td><strong>৳{{ number_format($expense->amount, 0) }}</strong></td>
                        <td>
                            <span class="badge badge-{{ ['flat' => 'info', 'custom_percent' => 'primary', 'purchase_percent' => 'warning'][$expense->distribution_type] }}">
                                {{ $expense->distribution_type_label }}
                            </span>
                        </td>
                        <td>{{ $expense->expense_date->format('d M Y') }}</td>
                        <td>
                            <small>
                                @foreach($expense->distributions->take(3) as $d)
                                    {{ $d->animal->type_name }}: {{ $d->percentage }}%<br>
                                @endforeach
                                @if($expense->distributions->count() > 3)
                                    <span class="text-muted">+{{ $expense->distributions->count() - 3 }} {{ app()->getLocale() === 'bn' ? 'আরও' : 'more' }}</span>
                                @endif
                            </small>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('expenses.edit', $expense) }}" class="btn btn-info"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('expenses.destroy', $expense) }}" method="POST" class="form-delete d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center py-4 text-muted"><i class="fas fa-file-invoice-dollar fa-2x mb-2 d-block"></i>{{ __('messages.no_data_found') }}</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
