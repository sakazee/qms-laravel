@extends('layouts.app')
@section('title', __('expense_heads.expense_heads'))
@section('page-title', __('expense_heads.expense_heads'))
@section('breadcrumb')
    <span class="text-gray-600">{{ __('expense_heads.expense_heads') }}</span>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fa-solid fa-tags text-emerald-700"></i>{{ __('expense_heads.expense_heads') }}</h3>
        <a href="{{ route('expense-heads.create') }}" class="btn btn-primary btn-sm">
            <i class="fa-solid fa-plus"></i> {{ __('expense_heads.create') }}
        </a>
    </div>
    <div class="table-wrap">
        <table class="datatable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{ __('expense_heads.name') }}</th>
                    <th>{{ __('expense_heads.description') }}</th>
                    <th>{{ __('expense_heads.color') }}</th>
                    <th>{{ __('messages.action') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($expenseHeads as $i => $expenseHead)
                <tr>
                    <td>{{ format_amount($i + 1, 0) }}</td>
                    <td>
                        <div class="font-semibold text-gray-900">{{ $expenseHead->name }}</div>
                    </td>
                    <td>
                        <div class="max-w-[260px] truncate text-[13px] text-gray-500">{{ $expenseHead->description ?: '—' }}</div>
                    </td>
                    <td>
                        <span class="inline-flex items-center gap-2">
                            <span class="inline-block h-3.5 w-3.5 rounded-full" style="background-color: {{ $expenseHead->color }};"></span>
                            <span class="font-mono text-[12px] uppercase text-gray-500">{{ $expenseHead->color }}</span>
                        </span>
                    </td>
                    <td>
                        <div class="flex items-center gap-1.5">
                            <a href="{{ route('expense-heads.edit', $expenseHead) }}" class="action-btn action-edit" title="{{ __('messages.edit') }}">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <form action="{{ route('expense-heads.destroy', $expenseHead) }}" method="POST" class="form-delete m-0">
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