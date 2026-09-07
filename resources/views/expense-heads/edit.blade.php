@extends('layouts.app')
@section('title', __('expense_heads.edit'))
@section('page-title', __('expense_heads.edit'))
@section('breadcrumb')
    <span><a href="{{ route('expense-heads.index') }}" class="hover:text-emerald-700">{{ __('expense_heads.expense_heads') }}</a></span>
    <i class="fa-solid fa-chevron-right text-[11px] text-gray-400"></i>
    <span class="text-gray-600">{{ __('expense_heads.edit') }}</span>
@endsection

@section('content')
<div class="mx-auto max-w-2xl">
    <div class="card">
        <div class="card-header bg-sky-700">
            <h3 class="card-title text-white"><i class="fa-solid fa-pen"></i>{{ __('expense_heads.edit') }}: {{ $expenseHead->name }}</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('expense-heads.update', $expenseHead) }}" method="POST">
                @csrf @method('PUT')
                @include('expense-heads._form')
                <div class="mt-6 flex items-center justify-between">
                    <a href="{{ route('expense-heads.index') }}" class="btn btn-secondary">
                        <i class="fa-solid fa-arrow-left"></i>{{ __('messages.back') }}
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-save"></i>{{ __('messages.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection