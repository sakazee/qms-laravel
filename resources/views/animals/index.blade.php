@extends('layouts.app')
@section('title', __('animals.animals'))
@section('page-title', __('animals.animals'))
@section('breadcrumb')
    <span class="text-gray-600">{{ __('animals.animals') }}</span>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fa-solid fa-horse text-emerald-700"></i>{{ __('animals.animals') }}</h3>
        <div class="flex items-center gap-3">
            <button type="submit" form="bulk-form" class="btn btn-danger btn-sm bulk-delete-btn" disabled
                    title="{{ __('messages.delete_selected') }}">
                <i class="fa-solid fa-trash-can"></i>{{ __('messages.delete_selected') }} <span class="bulk-count"></span>
            </button>
            <a href="{{ route('animals.create') }}" class="btn btn-primary btn-sm">
                <i class="fa-solid fa-plus"></i> {{ __('animals.create') }}
            </a>
        </div>
    </div>
    <form id="bulk-form" action="{{ route('animals.bulk-destroy') }}" method="POST" class="bulk-form">
        @csrf
    </form>
    <div class="table-wrap">
        <table class="datatable">
            <thead>
                <tr>
                    <th class="w-10"><input type="checkbox" class="bulk-select-all" title="{{ __('messages.select_all') }}"></th>
                    <th>#</th>
                    <th>{{ __('animals.type.label') }}</th>
                    <th>{{ __('animals.name') }}</th>
                    <th>{{ __('animals.purchase_price') }}</th>
                    <th>{{ __('animals.total_shares') }}</th>
                    <th>{{ __('animals.assigned_shares') }}</th>
                    <th>{{ __('animals.available_shares') }}</th>
                    <th>{{ __('animals.status.label') }}</th>
                    <th>{{ __('messages.action') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($animals as $i => $animal)
                @php
                    $statusBadgeClass = [
                        'warning'  => 'bg-amber-100 text-amber-800',
                        'info'     => 'bg-sky-100 text-sky-700',
                        'success'  => 'bg-emerald-100 text-emerald-800',
                        'secondary'=> 'bg-gray-100 text-gray-600',
                    ][$animal->status_badge] ?? 'bg-gray-100 text-gray-600';
                @endphp
                <tr>
                    <td><input type="checkbox" class="bulk-checkbox" value="{{ $animal->id }}"></td>
                    <td>{{ format_amount($i + 1, 0) }}</td>
                    <td>
                        <span class="badge {{ in_array($animal->type, ['cow','buffalo','camel']) ? 'bg-sky-100 text-sky-700' : 'bg-gray-100 text-gray-600' }}">
                            <i class="fa-solid fa-circle text-[6px]"></i>
                            {{ $animal->type_name }}
                        </span>
                    </td>
                    <td>{{ $animal->name ?: '—' }}</td>
                    <td class="font-semibold">৳{{ format_amount($animal->purchase_price, 0) }}</td>
                    <td class="text-center">{{ format_amount($animal->total_shares, 0) }}</td>
                    <td class="text-center">
                        <span class="badge bg-sky-100 text-sky-700">{{ format_amount($animal->assigned_shares, 0) }}</span>
                    </td>
                    <td class="text-center">
                        <span class="badge {{ $animal->available_shares > 0 ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-700' }}">
                            {{ format_amount($animal->available_shares, 0) }}
                        </span>
                    </td>
                    <td>
                        <span class="badge {{ $statusBadgeClass }}">
                            {{ __('animals.status.' . $animal->status) }}
                        </span>
                    </td>
                    <td>
                        <div class="flex items-center gap-1.5">
                            <a href="{{ route('animals.show', $animal) }}" class="action-btn action-view" title="{{ __('messages.view') }}">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            <a href="{{ route('animals.edit', $animal) }}" class="action-btn action-edit" title="{{ __('messages.edit') }}">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <form action="{{ route('animals.toggle-status', $animal) }}" method="POST" class="m-0">
                                @csrf
                                <button type="submit" class="action-btn bg-indigo-100 text-indigo-700 hover:bg-indigo-200"
                                        title="{{ __('animals.next_status', ['status' => __('animals.status.' . $animal->next_status)]) }}">
                                    <i class="fa-solid fa-repeat"></i>
                                </button>
                            </form>
                            <form action="{{ route('animals.destroy', $animal) }}" method="POST" class="form-delete m-0">
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
