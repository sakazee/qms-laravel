@extends('layouts.app')
@section('title', __('expenses.edit'))
@section('page-title', __('expenses.edit'))
@section('breadcrumb')
    <span><a href="{{ route('expenses.index') }}" class="hover:text-emerald-700">{{ __('expenses.expenses') }}</a></span>
    <i class="fa-solid fa-chevron-right text-[11px] text-gray-400"></i>
    <span class="text-gray-600">{{ __('expenses.edit') }}: {{ $expense->title }}</span>
@endsection

@section('content')
<div class="mx-auto max-w-5xl">
    <div class="card">
        <div class="card-header bg-sky-700">
            <h3 class="card-title text-white"><i class="fa-solid fa-pen"></i>{{ __('expenses.edit') }}: {{ $expense->title }}</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('expenses.update', $expense) }}" method="POST" id="expense_form">
                @csrf @method('PUT')
                @include('expenses._form', ['expense' => $expense])

                <div class="mt-6 flex items-center justify-between">
                    <a href="{{ route('expenses.index') }}" class="btn btn-secondary">
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