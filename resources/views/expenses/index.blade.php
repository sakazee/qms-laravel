@extends('layouts.app')
@section('title', __('expenses.expenses'))
@section('page-title', __('expenses.expenses'))
@section('breadcrumb')
    <span class="text-gray-600">{{ __('expenses.expenses') }}</span>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fa-solid fa-file-invoice-dollar text-emerald-700"></i>{{ __('expenses.expenses') }}</h3>
        <div class="flex items-center gap-3">
            <span class="rounded-lg bg-amber-50 px-3 py-1.5 font-serif text-[14px] font-bold text-amber-800 ring-1 ring-amber-200">
                {{ app()->getLocale() === 'bn' ? 'মোট: ৳' : 'Total: ৳' }}{{ format_amount($expenses->sum('amount'), 0) }}
            </span>
            <a href="{{ route('expenses.create') }}" class="btn btn-primary btn-sm">
                <i class="fa-solid fa-plus"></i>{{ __('expenses.create') }}
            </a>
        </div>
    </div>
    <div class="table-wrap">
        <table class="datatable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{ __('expenses.expense_head') }}</th>
                    <th>{{ __('expenses.title') }}</th>
                    <th>{{ __('expenses.amount') }}</th>
                    <th>{{ __('expenses.distribution_type') }}</th>
                    <th>{{ __('expenses.expense_date') }}</th>
                    <th>{{ app()->getLocale() === 'bn' ? 'বিতরণ' : 'Distributions' }}</th>
                    <th>{{ __('messages.action') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($expenses as $i => $expense)
                <tr>
                    <td>{{ format_amount($i + 1, 0) }}</td>
                    <td>
                        @if($expense->expenseHead)
                        <span class="inline-flex items-center gap-1.5">
                            <span class="inline-block h-2.5 w-2.5 rounded-full" style="background-color: {{ $expense->expenseHead->color }};"></span>
                            <span class="text-[12.5px] font-medium text-gray-700">{{ $expense->expenseHead->name }}</span>
                        </span>
                        @else
                            <span class="text-[12.5px] text-gray-400">—</span>
                        @endif
                    </td>
                    <td>
                        <div class="font-semibold text-gray-900">{{ $expense->title }}</div>
                        @if($expense->description)
                        <div class="max-w-[220px] truncate text-[12px] text-gray-400">{{ Str::limit($expense->description, 50) }}</div>
                        @endif
                    </td>
                    <td class="font-semibold">৳{{ format_amount($expense->amount, 0) }}</td>
                    <td>
                        @php
                            $distBadge = ['flat' => 'bg-sky-100 text-sky-700', 'custom_percent' => 'bg-emerald-100 text-emerald-800', 'purchase_percent' => 'bg-amber-100 text-amber-800'][$expense->distribution_type];
                        @endphp
                        <span class="badge {{ $distBadge }}">{{ $expense->distribution_type_label }}</span>
                    </td>
                    <td>{{ $expense->expense_date->format('d M Y') }}</td>
                    <td>
                        <div class="text-[12.5px] text-gray-600">
                            @foreach($expense->distributions->take(3) as $d)
                                {{ $d->animal->type_name }}: {{ format_amount($d->percentage, 0) }}%<br>
                            @endforeach
                            @if($expense->distributions->count() > 3)
                                <span class="text-gray-400">+{{ format_amount($expense->distributions->count() - 3, 0) }} {{ app()->getLocale() === 'bn' ? 'আরও' : 'more' }}</span>
                            @endif
                        </div>
                    </td>
                    <td>
                        <div class="flex items-center gap-1.5">
                            <a href="{{ route('expenses.edit', $expense) }}" class="action-btn action-edit" title="{{ __('messages.edit') }}">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <form action="{{ route('expenses.destroy', $expense) }}" method="POST" class="form-delete m-0">
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