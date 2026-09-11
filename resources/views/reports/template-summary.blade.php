@extends('layouts.app')
@section('title', __('reports.template_summary'))
@section('page-title', __('reports.template_summary'))
@section('breadcrumb')
    <span class="text-gray-600">{{ __('reports.template_summary') }}</span>
@endsection

@section('content')
    {{-- Actions --}}
    <div class="mb-3 flex justify-end gap-2 print:hidden">
        <a href="{{ route('reports.template-summary.pdf') }}" class="btn btn-secondary btn-sm">
            <i class="fa-solid fa-file-pdf"></i>{{ __('reports.download_pdf') }}
        </a>
        <button onclick="window.print()" class="btn btn-secondary btn-sm">
            <i class="fa-solid fa-print"></i>{{ __('reports.print') }}
        </button>
    </div>

    {{-- Stats Summary --}}
    @php
        $cards = [
            ['label' => __('reports.total_animals'),      'value' => format_count($stats['total_animals'], __('reports.animal_count_prefix')), 'icon' => 'horse',          'color' => 'border-emerald-200 bg-emerald-50 text-emerald-700'],
            ['label' => __('reports.total_partners'),     'value' => format_count($stats['total_partners'], __('reports.partners_count_prefix')), 'icon' => 'users',          'color' => 'border-sky-200 bg-sky-50 text-sky-700'],
            ['label' => __('reports.total_animal_cost'),  'value' => '৳'.format_amount($stats['total_animal_cost'],0), 'icon' => 'horse-head',     'color' => 'border-amber-200 bg-amber-50 text-amber-700'],
            ['label' => __('reports.total_expenses'),     'value' => '৳'.format_amount($stats['total_expenses'],0),    'icon' => 'receipt',        'color' => 'border-rose-200 bg-rose-50 text-rose-700'],
            ['label' => __('reports.total_cost'),         'value' => '৳'.format_amount($stats['total_cost'],0),        'icon' => 'calculator',     'color' => 'border-gray-200 bg-gray-50 text-gray-700'],
            ['label' => __('reports.total_collection'),   'value' => '৳'.format_amount($stats['total_collection'],0),  'icon' => 'money-bill-wave','color' => 'border-emerald-200 bg-emerald-50 text-emerald-700'],
            ['label' => __('reports.due'),                'value' => '৳'.format_amount($stats['due'],0),               'icon' => 'exclamation-circle', 'color' => $stats['due']>0 ? 'border-rose-200 bg-rose-50 text-rose-700' : 'border-gray-200 bg-gray-50 text-gray-600'],
            ['label' => __('reports.advance'),            'value' => '৳'.format_amount($stats['advance'],0),           'icon' => 'piggy-bank',     'color' => 'border-sky-200 bg-sky-50 text-sky-700'],
        ];
    @endphp
    <div class="grid grid-cols-2 gap-4 lg:grid-cols-4">
        @foreach($cards as $card)
            <div class="rounded-xl border {{ $card['color'] }} p-4">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-{{ $card['icon'] }} text-[16px]"></i>
                    <span class="text-[13.5px] font-medium text-gray-500">{{ $card['label'] }}</span>
                </div>
                <div class="mt-0.5 font-serif text-[22px] font-bold text-gray-900">{{ $card['value'] }}</div>
            </div>
        @endforeach
    </div>

    {{-- Animals Table --}}
    <div class="card mt-6">
        <div class="card-header"><h3 class="card-title"><i
                        class="fa-solid fa-horse text-emerald-700"></i>{{ __('animals.animals') }}</h3></div>
        <div class="table-wrap">
            <table class="w-full text-[14px]">
                <thead class="border-b border-gray-200 bg-paper-100">
                <tr>
                    <th class="px-4 py-3 text-left text-[13px] font-bold uppercase tracking-wide text-gray-600">#</th>
                    <th class="px-4 py-3 text-left text-[13px] font-bold uppercase tracking-wide text-gray-600">{{ __('animals.type.label') }}</th>
                    <th class="px-4 py-3 text-left text-[13px] font-bold uppercase tracking-wide text-gray-600">{{ __('animals.name') }}</th>
                    <th class="px-4 py-3 text-left text-[13px] font-bold uppercase tracking-wide text-gray-600">{{ __('animals.purchase_price') }}</th>
                    <th class="px-4 py-3 text-left text-[13px] font-bold uppercase tracking-wide text-gray-600">{{ __('expenses.expenses') }}</th>
                    <th class="px-4 py-3 text-center text-[13px] font-bold uppercase tracking-wide text-gray-600">{{ __('animals.total_shares') }}</th>
                    <th class="px-4 py-3 text-center text-[13px] font-bold uppercase tracking-wide text-gray-600">{{ __('animals.assigned_shares') }}</th>
                    <th class="px-4 py-3 text-left text-[13px] font-bold uppercase tracking-wide text-gray-600">{{ __('animals.status.label') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($template->animals as $i => $animal)
                    <tr>
                        <td class="border-b border-gray-100 px-4 py-3 text-gray-700">{{ format_amount($i+1, 0) }}</td>
                        <td class="border-b border-gray-100 px-4 py-3 text-gray-700">{{ $animal->type_name }}</td>
                        <td class="border-b border-gray-100 px-4 py-3 text-gray-700">{{ $animal->name ?: '—' }}</td>
                        <td class="border-b border-gray-100 px-4 py-3 text-gray-700">
                            ৳{{ format_amount($animal->purchase_price,0) }}</td>
                        <td class="border-b border-gray-100 px-4 py-3 text-gray-700">
                            ৳{{ format_amount($animal_expenses[$animal->id] ?? 0, 0) }}</td>
                        <td class="border-b border-gray-100 px-4 py-3 text-center text-gray-700">{{ $animal->total_shares }}</td>
                        <td class="border-b border-gray-100 px-4 py-3 text-center text-gray-700">{{ $animal->assigned_shares }}</td>
                        <td class="border-b border-gray-100 px-4 py-3 text-gray-700"><span
                                    class="badge bg-gray-100 text-gray-600">{{ __('animals.status.'.$animal->status) }}</span>
                        </td>
                    </tr>
                @endforeach
                <tr class="bg-paper-100 font-semibold text-gray-900">
                    <td colspan="3" class="border-b border-gray-100 px-4 py-3">{{ __('messages.total') }}</td>
                    <td class="border-b border-gray-100 px-4 py-3">
                        ৳{{ format_amount($template->animals->sum('purchase_price'),0) }}</td>
                    <td class="border-b border-gray-100 px-4 py-3">
                        ৳{{ format_amount($animal_expenses->sum(), 0) }}</td>
                    <td class="border-b border-gray-100 px-4 py-3 text-center">{{ format_amount($template->animals->sum('total_shares'), 0) }}</td>
                    <td colspan="2" class="border-b border-gray-100 px-4 py-3"></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    {{-- Expenses Table --}}
    @if($template->expenses->count())
        <div class="card mt-6">
            <div class="card-header"><h3 class="card-title"><i
                            class="fa-solid fa-file-invoice-dollar text-amber-700"></i>{{ __('expenses.expenses') }}
                </h3></div>
            <div class="table-wrap">
                <table class="w-full text-[14px]">
                    <thead class="border-b border-gray-200 bg-paper-100">
                    <tr>
                        <th class="px-4 py-3 text-left text-[13px] font-bold uppercase tracking-wide text-gray-600">#
                        </th>
                        <th class="px-4 py-3 text-left text-[13px] font-bold uppercase tracking-wide text-gray-600">{{ __('expenses.title') }}</th>
                        <th class="px-4 py-3 text-left text-[13px] font-bold uppercase tracking-wide text-gray-600">{{ __('expenses.animals_covered') }}</th>
                        <th class="px-4 py-3 text-left text-[13px] font-bold uppercase tracking-wide text-gray-600">{{ __('expenses.expense_date') }}</th>
                        <th class="px-4 py-3 text-left text-[13px] font-bold uppercase tracking-wide text-gray-600">{{ __('expenses.amount') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($template->expenses as $i => $expense)
                        <tr>
                            <td class="border-b border-gray-100 px-4 py-3 text-gray-700">{{ format_amount($i+1, 0) }}</td>
                            <td class="border-b border-gray-100 px-4 py-3 text-gray-700">{{ $expense->title }}</td>
                            <td class="border-b border-gray-100 px-4 py-3 text-gray-700">{{ format_amount($expense->distributions->count(), 0) }}
                                / {{ format_amount($template->animals->count(), 0) }}</td>
                            <td class="border-b border-gray-100 px-4 py-3 text-gray-700">{{ $expense->expense_date->format('d M Y') }}</td>
                            <td class="border-b border-gray-100 px-4 py-3 text-gray-700">
                                ৳{{ format_amount($expense->amount,0) }}</td>
                        </tr>
                    @endforeach
                    <tr class="bg-paper-100 font-semibold text-gray-900">
                        <td colspan="4" class="border-b border-gray-100 px-4 py-3">{{ __('messages.total') }}</td>
                        <td class="border-b border-gray-100 px-4 py-3">
                            ৳{{ format_amount($template->expenses->sum('amount'),0) }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    @endif
@endsection
