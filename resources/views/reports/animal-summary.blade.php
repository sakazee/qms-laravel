@extends('layouts.app')
@section('title', __('reports.animal_summary'))
@section('page-title', __('reports.animal_summary'))
@section('breadcrumb')
    <span class="text-gray-600">{{ __('reports.animal_summary') }}</span>
@endsection

@section('content')
<div class="mb-3 flex justify-end gap-2 print:hidden">
    <a href="{{ route('reports.animal-summary.pdf') }}" class="btn btn-secondary btn-sm">
        <i class="fa-solid fa-file-pdf"></i>{{ __('reports.download_pdf') }}
    </a>
    <button onclick="window.print()" class="btn btn-secondary btn-sm">
        <i class="fa-solid fa-print"></i>{{ __('reports.print') }}
    </button>
</div>

<div class="card">
    <div class="card-header"><h3 class="card-title"><i class="fa-solid fa-horse text-emerald-700"></i>{{ __('reports.animal_summary') }}</h3></div>
    <div class="table-wrap">
        <table class="w-full text-[13px]">
            <thead class="border-b border-gray-200 bg-paper-100">
                <tr>
                    <th class="px-4 py-3 text-left text-[12px] font-bold uppercase tracking-wide text-gray-600">#</th>
                    <th class="px-4 py-3 text-left text-[12px] font-bold uppercase tracking-wide text-gray-600">{{ __('animals.type.label') }}</th>
                    <th class="px-4 py-3 text-left text-[12px] font-bold uppercase tracking-wide text-gray-600">{{ __('animals.name') }}</th>
                    <th class="px-4 py-3 text-left text-[12px] font-bold uppercase tracking-wide text-gray-600">{{ __('animals.purchase_price') }}</th>
                    <th class="px-4 py-3 text-center text-[12px] font-bold uppercase tracking-wide text-gray-600">{{ __('animals.total_shares') }}</th>
                    <th class="px-4 py-3 text-center text-[12px] font-bold uppercase tracking-wide text-gray-600">{{ __('animals.assigned_shares') }}</th>
                    <th class="px-4 py-3 text-center text-[12px] font-bold uppercase tracking-wide text-gray-600">{{ __('animals.available_shares') }}</th>
                    <th class="px-4 py-3 text-left text-[12px] font-bold uppercase tracking-wide text-gray-600">{{ app()->getLocale() === 'bn' ? 'অংশীদারগণ' : 'Partners' }}</th>
                    <th class="px-4 py-3 text-left text-[12px] font-bold uppercase tracking-wide text-gray-600">{{ __('animals.status.label') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($template->animals as $i => $animal)
                <tr>
                    <td class="border-b border-gray-100 px-4 py-3 text-gray-700">{{ $i+1 }}</td>
                    <td class="border-b border-gray-100 px-4 py-3 text-gray-700"><span class="badge bg-sky-100 text-sky-700">{{ $animal->type_name }}</span></td>
                    <td class="border-b border-gray-100 px-4 py-3 text-gray-700">{{ $animal->name ?: '—' }}</td>
                    <td class="border-b border-gray-100 px-4 py-3 text-gray-700">৳{{ format_amount($animal->purchase_price,0) }}</td>
                    <td class="border-b border-gray-100 px-4 py-3 text-center text-gray-700">{{ $animal->total_shares }}</td>
                    <td class="border-b border-gray-100 px-4 py-3 text-center text-gray-700"><span class="badge bg-sky-100 text-sky-700">{{ $animal->assigned_shares }}</span></td>
                    <td class="border-b border-gray-100 px-4 py-3 text-center text-gray-700"><span class="badge {{ $animal->available_shares > 0 ? 'bg-emerald-100 text-emerald-800' : 'bg-gray-100 text-gray-600' }}">{{ $animal->available_shares }}</span></td>
                    <td class="border-b border-gray-100 px-4 py-3 text-gray-700">@foreach($animal->animalShares as $share)<span class="mr-1 inline-flex items-center rounded-md bg-paper-100 px-2 py-0.5 text-[12px] font-medium text-gray-700 ring-1 ring-gray-200">{{ $share->partner->name }}</span>@endforeach</td>
                    <td class="border-b border-gray-100 px-4 py-3 text-gray-700"><span class="badge bg-gray-100 text-gray-600">{{ __('animals.status.'.$animal->status) }}</span></td>
                </tr>
                @empty
                <tr>
                    <td colspan="9">
                        <div class="empty-state">
                            <i class="fa-solid fa-horse text-3xl text-gray-300"></i>
                            <span class="text-[13.5px]">{{ __('messages.no_data_found') }}</span>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
            @if($template->animals->count())
            <tfoot>
                <tr class="bg-paper-100 font-semibold text-gray-900">
                    <td colspan="3" class="border-t border-gray-200 px-4 py-3">{{ __('messages.total') }}</td>
                    <td class="border-t border-gray-200 px-4 py-3">৳{{ format_amount($template->animals->sum('purchase_price'),0) }}</td>
                    <td class="border-t border-gray-200 px-4 py-3 text-center">{{ $template->animals->sum('total_shares') }}</td>
                    <td colspan="4" class="border-t border-gray-200 px-4 py-3"></td>
                </tr>
            </tfoot>
            @endif
        </table>
    </div>
</div>
@endsection