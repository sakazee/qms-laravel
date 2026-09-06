@extends('layouts.app')
@section('title', app()->getLocale() === 'bn' ? 'ড্যাশবোর্ড' : 'Dashboard')
@section('page-title', app()->getLocale() === 'bn' ? 'ড্যাশবোর্ড' : 'Dashboard')
@section('breadcrumb')
    <span class="text-gray-600">{{ app()->getLocale() === 'bn' ? 'ড্যাশবোর্ড' : 'Dashboard' }}</span>
@endsection

@section('content')

@if(!session('selected_template_id'))
{{-- No Template Selected --}}
<div class="mx-auto max-w-xl py-10">
    <div class="card px-8 py-14 text-center">
        <div class="mx-auto mb-5 flex h-20 w-20 items-center justify-center rounded-full bg-gold/15 ring-1 ring-gold/30">
            <span class="text-4xl">🌙</span>
        </div>
        <h3 class="font-serif text-xl font-bold text-emerald-900">{{ __('templates.no_template_selected') }}</h3>
        <p class="mx-auto mt-2 max-w-sm text-[13.5px] text-gray-500">{{ __('templates.select_to_continue') }}</p>
        <a href="{{ route('templates.index') }}" class="btn btn-primary mx-auto mt-6 px-6 py-2.5">
            <i class="fa-solid fa-layer-group"></i>
            {{ app()->getLocale() === 'bn' ? 'টেমপ্লেট নির্বাচন করুন' : 'Select Template' }}
        </a>
    </div>
</div>

@else
@php $tpl = \App\Models\Template::find(session('selected_template_id')); @endphp

{{-- Season strip --}}
<div class="mb-6 overflow-hidden rounded-2xl bg-pine-900 shadow-lift">
    <div class="flex flex-col gap-6 bg-gradient-to-br from-pine-900 via-pine-800 to-emerald-800 px-7 py-6 sm:flex-row sm:items-center sm:justify-between">
        <div class="flex items-center gap-4">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gold/20 ring-1 ring-gold/40">
                <i class="fa-solid fa-moon text-xl text-gold"></i>
            </div>
            <div>
                <div class="text-[11px] font-bold uppercase tracking-[1.5px] text-gold-300">{{ app()->getLocale() === 'bn' ? 'সক্রিয় কোরবানি মৌসুম' : 'Active Qurbani Season' }}</div>
                <div class="font-serif text-xl font-bold text-white sm:text-2xl">{{ $tpl->name }} <span class="text-gold">—</span> <span class="font-sans">{{ $tpl->year }}</span></div>
            </div>
        </div>
        <div class="flex items-center gap-6">
            <div class="text-center">
                <div class="font-serif text-2xl font-bold text-emerald-300">৳{{ format_amount($stats['total_collection'] ?? 0, 0) }}</div>
                <div class="text-[11.5px] font-medium text-white/60">{{ __('reports.total_collection') }}</div>
            </div>
            <div class="h-10 w-px bg-white/15"></div>
            <div class="text-center">
                <div class="font-serif text-2xl font-bold text-gold">৳{{ format_amount(($stats['due'] ?? 0), 0) }}</div>
                <div class="text-[11.5px] font-medium text-white/60">{{ __('reports.due') }}</div>
            </div>
        </div>
    </div>
</div>

{{-- Primary stat cards --}}
<div class="grid grid-cols-2 gap-4 lg:grid-cols-4">
    <a href="{{ route('animals.index') }}" class="card group p-5 transition-shadow hover:shadow-lift">
        <div class="flex items-center justify-between">
            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-100 text-lg text-emerald-800"><i class="fa-solid fa-horse"></i></div>
            <i class="fa-solid fa-arrow-right text-gray-300 transition-transform group-hover:translate-x-0.5"></i>
        </div>
        <div class="mt-4 font-serif text-[26px] font-bold text-gray-900">{{ format_count($stats['total_animals'] ?? 0, __('reports.animal_count_prefix')) }}</div>
        <div class="text-[12.5px] font-medium text-gray-500">{{ __('reports.total_animals') }}</div>
    </a>
    <a href="{{ route('partners.index') }}" class="card group p-5 transition-shadow hover:shadow-lift">
        <div class="flex items-center justify-between">
            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-sky-100 text-lg text-sky-700"><i class="fa-solid fa-users"></i></div>
            <i class="fa-solid fa-arrow-right text-gray-300 transition-transform group-hover:translate-x-0.5"></i>
        </div>
        <div class="mt-4 font-serif text-[26px] font-bold text-gray-900">{{ format_count($stats['total_partners'] ?? 0, __('reports.partners_count_prefix')) }}</div>
        <div class="text-[12.5px] font-medium text-gray-500">{{ __('reports.total_partners') }}</div>
    </a>
    <a href="{{ route('expenses.index') }}" class="card group p-5 transition-shadow hover:shadow-lift">
        <div class="flex items-center justify-between">
            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-amber-100 text-lg text-amber-700"><i class="fa-solid fa-receipt"></i></div>
            <i class="fa-solid fa-arrow-right text-gray-300 transition-transform group-hover:translate-x-0.5"></i>
        </div>
        <div class="mt-4 font-serif text-[26px] font-bold text-gray-900">৳{{ format_amount($stats['total_cost'] ?? 0, 0) }}</div>
        <div class="text-[12.5px] font-medium text-gray-500">{{ __('reports.total_cost') }}</div>
    </a>
    <a href="{{ route('payments.index') }}" class="card group p-5 transition-shadow hover:shadow-lift">
        <div class="flex items-center justify-between">
            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-100 text-lg text-emerald-800"><i class="fa-solid fa-money-bill-wave"></i></div>
            <i class="fa-solid fa-arrow-right text-gray-300 transition-transform group-hover:translate-x-0.5"></i>
        </div>
        <div class="mt-4 font-serif text-[26px] font-bold text-gray-900">৳{{ format_amount($stats['total_collection'] ?? 0, 0) }}</div>
        <div class="text-[12.5px] font-medium text-gray-500">{{ __('reports.total_collection') }}</div>
    </a>
</div>

{{-- Secondary stats --}}
<div class="mt-4 grid grid-cols-2 gap-4 lg:grid-cols-4">
    <div class="rounded-xl border {{ ($stats['due'] ?? 0) > 0 ? 'border-rose-200 bg-rose-50' : 'border-emerald-200 bg-emerald-50' }} p-4">
        <div class="text-[12.5px] font-semibold {{ ($stats['due'] ?? 0) > 0 ? 'text-rose-700' : 'text-emerald-700' }}">{{ __('reports.due') }}</div>
        <div class="mt-0.5 font-serif text-xl font-bold text-gray-900">৳{{ format_amount($stats['due'] ?? 0, 0) }}</div>
    </div>
    <div class="rounded-xl border border-teal-200 bg-teal-50 p-4">
        <div class="text-[12.5px] font-semibold text-teal-700">{{ __('reports.advance') }}</div>
        <div class="mt-0.5 font-serif text-xl font-bold text-gray-900">৳{{ format_amount($stats['advance'] ?? 0, 0) }}</div>
    </div>
    <div class="rounded-xl border border-indigo-200 bg-indigo-50 p-4">
        <div class="text-[12.5px] font-semibold text-indigo-700">{{ __('reports.total_animal_cost') }}</div>
        <div class="mt-0.5 font-serif text-xl font-bold text-gray-900">৳{{ format_amount($stats['total_animal_cost'] ?? 0, 0) }}</div>
    </div>
    <div class="rounded-xl border border-orange-200 bg-orange-50 p-4">
        <div class="text-[12.5px] font-semibold text-orange-700">{{ __('reports.total_expenses') }}</div>
        <div class="mt-0.5 font-serif text-xl font-bold text-gray-900">৳{{ format_amount($stats['total_expenses'] ?? 0, 0) }}</div>
    </div>
</div>

{{-- Quick actions --}}
<div class="card mt-6">
    <div class="card-header">
        <h3 class="card-title"><i class="fa-solid fa-bolt text-gold"></i>{{ app()->getLocale() === 'bn' ? 'দ্রুত কার্যক্রম' : 'Quick Actions' }}</h3>
    </div>
    <div class="card-body">
        <div class="grid grid-cols-2 gap-3 sm:grid-cols-3 lg:grid-cols-6">
            <a href="{{ route('animals.create') }}" class="flex flex-col items-center gap-1.5 rounded-xl border border-emerald-300/60 bg-white px-3 py-4 text-emerald-800 transition-colors hover:bg-emerald-800 hover:text-white">
                <i class="fa-solid fa-plus-circle text-[22px]"></i>
                <span class="text-[12px] font-semibold">{{ app()->getLocale() === 'bn' ? 'পশু যোগ' : 'Add Animal' }}</span>
            </a>
            <a href="{{ route('partners.create') }}" class="flex flex-col items-center gap-1.5 rounded-xl border border-sky-300/60 bg-white px-3 py-4 text-sky-700 transition-colors hover:bg-sky-800 hover:text-white">
                <i class="fa-solid fa-user-plus text-[22px]"></i>
                <span class="text-[12px] font-semibold">{{ app()->getLocale() === 'bn' ? 'অংশীদার যোগ' : 'Add Partner' }}</span>
            </a>
            <a href="{{ route('shares.create') }}" class="flex flex-col items-center gap-1.5 rounded-xl border border-indigo-300/60 bg-white px-3 py-4 text-indigo-700 transition-colors hover:bg-indigo-800 hover:text-white">
                <i class="fa-solid fa-share-nodes text-[22px]"></i>
                <span class="text-[12px] font-semibold">{{ app()->getLocale() === 'bn' ? 'ভাগ নির্ধারণ' : 'Assign Share' }}</span>
            </a>
            <a href="{{ route('expenses.create') }}" class="flex flex-col items-center gap-1.5 rounded-xl border border-amber-300/60 bg-white px-3 py-4 text-amber-700 transition-colors hover:bg-amber-600 hover:text-white">
                <i class="fa-solid fa-file-invoice-dollar text-[22px]"></i>
                <span class="text-[12px] font-semibold">{{ app()->getLocale() === 'bn' ? 'খরচ যোগ' : 'Add Expense' }}</span>
            </a>
            <a href="{{ route('payments.create') }}" class="flex flex-col items-center gap-1.5 rounded-xl border border-rose-300/60 bg-white px-3 py-4 text-rose-700 transition-colors hover:bg-rose-700 hover:text-white">
                <i class="fa-solid fa-money-bill-wave text-[22px]"></i>
                <span class="text-[12px] font-semibold">{{ app()->getLocale() === 'bn' ? 'পেমেন্ট যোগ' : 'Add Payment' }}</span>
            </a>
            <a href="{{ route('reports.template-summary') }}" class="flex flex-col items-center gap-1.5 rounded-xl border border-gray-300 bg-white px-3 py-4 text-gray-700 transition-colors hover:bg-gray-800 hover:text-white">
                <i class="fa-solid fa-chart-column text-[22px]"></i>
                <span class="text-[12px] font-semibold">{{ app()->getLocale() === 'bn' ? 'রিপোর্ট' : 'Reports' }}</span>
            </a>
        </div>
    </div>
</div>
@endif
@endsection