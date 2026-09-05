@extends('layouts.app')
@section('title', __('shares.shares'))
@section('page-title', __('shares.shares'))
@section('breadcrumb')
    <span class="text-gray-600">{{ __('shares.shares') }}</span>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fa-solid fa-share-nodes text-emerald-700"></i>{{ __('shares.shares') }}</h3>
        <a href="{{ route('shares.create') }}" class="btn btn-primary btn-sm">
            <i class="fa-solid fa-plus"></i>{{ __('shares.create') }}
        </a>
    </div>
    <div class="table-wrap">
        <table class="datatable">
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
                @foreach($shares as $i => $share)
                <tr>
                    <td>{{ format_amount($i + 1, 0) }}</td>
                    <td class="font-semibold text-gray-900">{{ $share->animal->name ?: $share->animal->type_name }}</td>
                    <td><span class="badge bg-sky-100 text-sky-700">{{ $share->animal->type_name }}</span></td>
                    <td>{{ $share->partner->name }}</td>
                    <td class="text-center"><span class="badge bg-emerald-100 text-emerald-800">{{ $share->shares }}</span></td>
                    <td class="font-semibold">৳{{ format_amount($share->share_amount, 2) }}</td>
                    <td>
                        <div class="flex items-center gap-1.5">
                            <a href="{{ route('shares.edit', $share) }}" class="action-btn action-edit" title="{{ __('messages.edit') }}">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <form action="{{ route('shares.destroy', $share) }}" method="POST" class="form-delete m-0">
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

@if($animals->count())
<div class="card mt-4">
    <div class="card-header">
        <h3 class="card-title"><i class="fa-solid fa-chart-pie text-emerald-700"></i>{{ app()->getLocale() === 'bn' ? 'পশু ভাগের সারসংক্ষেপ' : 'Animal Share Summary' }}</h3>
    </div>
    <div class="table-wrap">
        <table class="w-full text-[13px]">
            <thead>
                <tr class="border-b border-gray-200 bg-paper-100 text-left text-[12px] font-bold uppercase tracking-wide text-gray-600">
                    <th class="px-4 py-3">{{ __('animals.animal') }}</th>
                    <th class="px-4 py-3 text-center">{{ __('animals.total_shares') }}</th>
                    <th class="px-4 py-3 text-center">{{ __('animals.assigned_shares') }}</th>
                    <th class="px-4 py-3 text-center">{{ __('animals.available_shares') }}</th>
                    <th class="px-4 py-3">{{ app()->getLocale() === 'bn' ? 'পূর্ণতা' : 'Filled' }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($animals as $animal)
                @php $pct = $animal->total_shares > 0 ? round(($animal->assigned_shares / $animal->total_shares) * 100) : 0; @endphp
                <tr class="border-b border-gray-100">
                    <td class="px-4 py-3 font-medium text-gray-900">{{ $animal->name ?: $animal->type_name }}</td>
                    <td class="px-4 py-3 text-center">{{ format_amount($animal->total_shares, 0) }}</td>
                    <td class="px-4 py-3 text-center">
                        <span class="badge bg-sky-100 text-sky-700">{{ format_amount($animal->assigned_shares, 0) }}</span>
                    </td>
                    <td class="px-4 py-3 text-center">
                        <span class="badge {{ $animal->available_shares > 0 ? 'bg-emerald-100 text-emerald-800' : 'bg-gray-100 text-gray-500' }}">{{ format_amount($animal->available_shares, 0) }}</span>
                    </td>
                    <td class="px-4 py-3" style="width:200px">
                        <div class="h-2 w-[160px] overflow-hidden rounded-full bg-gray-200">
                            <div class="h-full rounded-full {{ $pct == 100 ? 'bg-emerald-600' : 'bg-sky-500' }}" style="width:{{ $pct }}%"></div>
                        </div>
                        <span class="mt-0.5 block text-[11.5px] text-gray-500">{{ format_amount($pct, 0) }}%</span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif
@endsection