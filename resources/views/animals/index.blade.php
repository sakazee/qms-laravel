@extends('layouts.app')
@section('title', __('animals.animals'))
@section('page-title', __('animals.animals'))
@section('breadcrumb')
    <li class="breadcrumb-item active">{{ __('animals.animals') }}</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title mb-0">
                    <i class="fas fa-horse text-success mr-2"></i>{{ __('animals.animals') }}
                </h3>
                <a href="{{ route('animals.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus mr-1"></i>{{ __('animals.create') }}
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover datatable mb-0">
                        <thead>
                            <tr>
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
                            @forelse($animals as $i => $animal)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>
                                    <span class="badge badge-{{ in_array($animal->type, ['cow','buffalo','camel']) ? 'primary' : 'secondary' }}">
                                        {{ $animal->type_name }}
                                    </span>
                                </td>
                                <td>{{ $animal->name ?: '—' }}</td>
                                <td><strong>৳{{ number_format($animal->purchase_price, 0) }}</strong></td>
                                <td class="text-center">{{ $animal->total_shares }}</td>
                                <td class="text-center">
                                    <span class="badge badge-info">{{ $animal->assigned_shares }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge badge-{{ $animal->available_shares > 0 ? 'success' : 'danger' }}">
                                        {{ $animal->available_shares }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge badge-{{ $animal->status_badge }}">
                                        {{ __('animals.status.' . $animal->status) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('animals.show', $animal) }}" class="btn btn-secondary" title="{{ __('messages.view') }}">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('animals.edit', $animal) }}" class="btn btn-info" title="{{ __('messages.edit') }}">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('animals.destroy', $animal) }}" method="POST" class="form-delete d-inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center py-4 text-muted">
                                    <i class="fas fa-horse fa-2x mb-2 d-block"></i>
                                    {{ __('messages.no_data_found') }}
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
