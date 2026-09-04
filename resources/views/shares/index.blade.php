@extends('layouts.app')
@section('title', __('shares.shares'))
@section('page-title', __('shares.shares'))
@section('breadcrumb')
    <li class="breadcrumb-item active">{{ __('shares.shares') }}</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title mb-0"><i class="fas fa-share-alt text-success mr-2"></i>{{ __('shares.shares') }}</h3>
        <a href="{{ route('shares.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus mr-1"></i>{{ __('shares.create') }}
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover datatable mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ __('animals.animal') }}</th>
                        <th>{{ __('animals.type.label') }}</th>
                        <th>{{ __('partners.partner') }}</th>
                        <th>{{ __('shares.shares_count') }}</th>
                        <th>{{ __('shares.share_amount') }}</th>
                        <th>{{ __('messages.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($shares as $i => $share)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $share->animal->name ?: $share->animal->type_name }}</td>
                        <td><span class="badge badge-primary">{{ $share->animal->type_name }}</span></td>
                        <td>{{ $share->partner->name }}</td>
                        <td class="text-center"><span class="badge badge-info">{{ $share->shares }}</span></td>
                        <td>৳{{ number_format($share->share_amount, 2) }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('shares.edit', $share) }}" class="btn btn-info"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('shares.destroy', $share) }}" method="POST" class="form-delete d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center py-4 text-muted"><i class="fas fa-share-alt fa-2x mb-2 d-block"></i>{{ __('messages.no_data_found') }}</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Animal Share Summary --}}
@if($animals->count())
<div class="card mt-3">
    <div class="card-header"><h3 class="card-title mb-0"><i class="fas fa-chart-pie mr-2"></i>{{ app()->getLocale() === 'bn' ? 'পশু ভাগের সারসংক্ষেপ' : 'Animal Share Summary' }}</h3></div>
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead><tr><th>{{ __('animals.animal') }}</th><th>{{ __('animals.total_shares') }}</th><th>{{ __('animals.assigned_shares') }}</th><th>{{ __('animals.available_shares') }}</th><th>{{ app()->getLocale() === 'bn' ? 'পূর্ণতা' : 'Filled' }}</th></tr></thead>
            <tbody>
                @foreach($animals as $animal)
                @php $pct = $animal->total_shares > 0 ? round(($animal->assigned_shares / $animal->total_shares) * 100) : 0; @endphp
                <tr>
                    <td>{{ $animal->name ?: $animal->type_name }}</td>
                    <td class="text-center">{{ $animal->total_shares }}</td>
                    <td class="text-center"><span class="badge badge-info">{{ $animal->assigned_shares }}</span></td>
                    <td class="text-center"><span class="badge badge-{{ $animal->available_shares > 0 ? 'success' : 'secondary' }}">{{ $animal->available_shares }}</span></td>
                    <td style="width:200px">
                        <div class="progress" style="height:8px">
                            <div class="progress-bar bg-{{ $pct == 100 ? 'success' : 'info' }}" style="width:{{ $pct }}%"></div>
                        </div>
                        <small class="text-muted">{{ $pct }}%</small>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif
@endsection
