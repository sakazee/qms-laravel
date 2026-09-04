@extends('layouts.app')
@section('title', app()->getLocale() === 'bn' ? 'ড্যাশবোর্ড' : 'Dashboard')
@section('page-title', app()->getLocale() === 'bn' ? 'ড্যাশবোর্ড' : 'Dashboard')
@section('breadcrumb')
    <li class="breadcrumb-item active">{{ app()->getLocale() === 'bn' ? 'ড্যাশবোর্ড' : 'Dashboard' }}</li>
@endsection

@section('content')

@if(!session('selected_template_id'))
{{-- No Template Selected --}}
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card text-center" style="border-radius:16px;padding:40px 20px">
            <div style="font-size:70px;margin-bottom:16px">🌙</div>
            <h3 style="font-weight:700;color:#1a6b3a">{{ __('templates.no_template_selected') }}</h3>
            <p class="text-muted mb-4">{{ __('templates.select_to_continue') }}</p>
            <a href="{{ route('templates.index') }}" class="btn btn-primary btn-lg px-5">
                <i class="fas fa-layer-group mr-2"></i>
                {{ app()->getLocale() === 'bn' ? 'টেমপ্লেট নির্বাচন করুন' : 'Select Template' }}
            </a>
        </div>
    </div>
</div>
@else
{{-- Stats Cards --}}
<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $stats['total_animals'] ?? 0 }}</h3>
                <p>{{ __('reports.total_animals') }}</p>
            </div>
            <div class="icon"><i class="fas fa-horse"></i></div>
            <a href="{{ route('animals.index') }}" class="small-box-footer">
                {{ app()->getLocale() === 'bn' ? 'বিস্তারিত' : 'More info' }} <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $stats['total_partners'] ?? 0 }}</h3>
                <p>{{ __('reports.total_partners') }}</p>
            </div>
            <div class="icon"><i class="fas fa-users"></i></div>
            <a href="{{ route('partners.index') }}" class="small-box-footer">
                {{ app()->getLocale() === 'bn' ? 'বিস্তারিত' : 'More info' }} <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>৳{{ number_format($stats['total_cost'] ?? 0, 0) }}</h3>
                <p>{{ __('reports.total_cost') }}</p>
            </div>
            <div class="icon"><i class="fas fa-receipt"></i></div>
            <a href="{{ route('expenses.index') }}" class="small-box-footer">
                {{ app()->getLocale() === 'bn' ? 'বিস্তারিত' : 'More info' }} <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-primary">
            <div class="inner">
                <h3>৳{{ number_format($stats['total_collection'] ?? 0, 0) }}</h3>
                <p>{{ __('reports.total_collection') }}</p>
            </div>
            <div class="icon"><i class="fas fa-money-bill-wave"></i></div>
            <a href="{{ route('payments.index') }}" class="small-box-footer">
                {{ app()->getLocale() === 'bn' ? 'বিস্তারিত' : 'More info' }} <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
</div>

<div class="row">
    {{-- Due / Advance cards --}}
    <div class="col-md-3 col-6">
        <div class="info-box {{ ($stats['due'] ?? 0) > 0 ? 'bg-danger' : 'bg-success' }}">
            <span class="info-box-icon"><i class="fas fa-exclamation-circle"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">{{ __('reports.due') }}</span>
                <span class="info-box-number">৳{{ number_format($stats['due'] ?? 0, 0) }}</span>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="info-box bg-teal">
            <span class="info-box-icon"><i class="fas fa-piggy-bank"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">{{ __('reports.advance') }}</span>
                <span class="info-box-number">৳{{ number_format($stats['advance'] ?? 0, 0) }}</span>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="info-box bg-indigo">
            <span class="info-box-icon"><i class="fas fa-horse-head"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">{{ __('reports.total_animal_cost') }}</span>
                <span class="info-box-number">৳{{ number_format($stats['total_animal_cost'] ?? 0, 0) }}</span>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="info-box bg-orange">
            <span class="info-box-icon"><i class="fas fa-file-invoice-dollar"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">{{ __('reports.total_expenses') }}</span>
                <span class="info-box-number">৳{{ number_format($stats['total_expenses'] ?? 0, 0) }}</span>
            </div>
        </div>
    </div>
</div>

{{-- Quick Links --}}
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-bolt text-warning mr-2"></i>
                    {{ app()->getLocale() === 'bn' ? 'দ্রুত কার্যক্রম' : 'Quick Actions' }}
                </h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2 col-4 mb-3">
                        <a href="{{ route('animals.create') }}" class="btn btn-outline-success btn-block py-3">
                            <i class="fas fa-plus-circle d-block mb-1" style="font-size:22px"></i>
                            <small>{{ app()->getLocale() === 'bn' ? 'পশু যোগ' : 'Add Animal' }}</small>
                        </a>
                    </div>
                    <div class="col-md-2 col-4 mb-3">
                        <a href="{{ route('partners.create') }}" class="btn btn-outline-info btn-block py-3">
                            <i class="fas fa-user-plus d-block mb-1" style="font-size:22px"></i>
                            <small>{{ app()->getLocale() === 'bn' ? 'অংশীদার যোগ' : 'Add Partner' }}</small>
                        </a>
                    </div>
                    <div class="col-md-2 col-4 mb-3">
                        <a href="{{ route('shares.create') }}" class="btn btn-outline-primary btn-block py-3">
                            <i class="fas fa-share-alt d-block mb-1" style="font-size:22px"></i>
                            <small>{{ app()->getLocale() === 'bn' ? 'ভাগ নির্ধারণ' : 'Assign Share' }}</small>
                        </a>
                    </div>
                    <div class="col-md-2 col-4 mb-3">
                        <a href="{{ route('expenses.create') }}" class="btn btn-outline-warning btn-block py-3">
                            <i class="fas fa-file-invoice-dollar d-block mb-1" style="font-size:22px"></i>
                            <small>{{ app()->getLocale() === 'bn' ? 'খরচ যোগ' : 'Add Expense' }}</small>
                        </a>
                    </div>
                    <div class="col-md-2 col-4 mb-3">
                        <a href="{{ route('payments.create') }}" class="btn btn-outline-danger btn-block py-3">
                            <i class="fas fa-money-bill-wave d-block mb-1" style="font-size:22px"></i>
                            <small>{{ app()->getLocale() === 'bn' ? 'পেমেন্ট যোগ' : 'Add Payment' }}</small>
                        </a>
                    </div>
                    <div class="col-md-2 col-4 mb-3">
                        <a href="{{ route('reports.template-summary') }}" class="btn btn-outline-secondary btn-block py-3">
                            <i class="fas fa-chart-bar d-block mb-1" style="font-size:22px"></i>
                            <small>{{ app()->getLocale() === 'bn' ? 'রিপোর্ট' : 'Reports' }}</small>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection
