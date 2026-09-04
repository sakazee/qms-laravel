<a href="{{ route('dashboard') }}" class="flex items-center gap-3 border-b border-white/10 px-5 py-4">
    <i class="fa-solid fa-moon text-xl text-gold"></i>
    <span class="font-serif text-[15.5px] font-bold leading-tight text-white">
        {{ app()->getLocale() === 'bn' ? 'কোরবানি সিস্টেম' : 'Qurbani System' }}
    </span>
</a>

<nav class="flex-1 py-3">
    <div class="sidebar-header">{{ app()->getLocale() === 'bn' ? 'ওভারভিউ' : 'OVERVIEW' }}</div>

    <a href="{{ route('dashboard') }}"
       class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <i class="fa-solid fa-gauge-high w-5 text-center"></i>
        <span>{{ app()->getLocale() === 'bn' ? 'ড্যাশবোর্ড' : 'Dashboard' }}</span>
    </a>

    <div class="sidebar-header">{{ app()->getLocale() === 'bn' ? 'ব্যবস্থাপনা' : 'MANAGEMENT' }}</div>

    <a href="{{ route('templates.index') }}"
       class="sidebar-link {{ request()->routeIs('templates.*') ? 'active' : '' }}">
        <i class="fa-solid fa-layer-group w-5 text-center"></i>
        <span>{{ __('templates.templates') }}</span>
    </a>

    @if(session('selected_template_id'))

    <div class="sidebar-header">{{ app()->getLocale() === 'bn' ? 'কোরবানি' : 'QURBANI' }}</div>

    <a href="{{ route('animals.index') }}"
       class="sidebar-link {{ request()->routeIs('animals.*') ? 'active' : '' }}">
        <i class="fa-solid fa-horse w-5 text-center"></i>
        <span>{{ __('animals.animals') }}</span>
    </a>

    <a href="{{ route('partners.index') }}"
       class="sidebar-link {{ request()->routeIs('partners.*') ? 'active' : '' }}">
        <i class="fa-solid fa-users w-5 text-center"></i>
        <span>{{ __('partners.partners') }}</span>
    </a>

    <a href="{{ route('shares.index') }}"
       class="sidebar-link {{ request()->routeIs('shares.*') ? 'active' : '' }}">
        <i class="fa-solid fa-share-nodes w-5 text-center"></i>
        <span>{{ __('shares.shares') }}</span>
    </a>

    <div class="sidebar-header">{{ app()->getLocale() === 'bn' ? 'আর্থিক' : 'FINANCE' }}</div>

    <a href="{{ route('expenses.index') }}"
       class="sidebar-link {{ request()->routeIs('expenses.*') ? 'active' : '' }}">
        <i class="fa-solid fa-file-invoice-dollar w-5 text-center"></i>
        <span>{{ __('expenses.expenses') }}</span>
    </a>

    <a href="{{ route('payments.index') }}"
       class="sidebar-link {{ request()->routeIs('payments.*') ? 'active' : '' }}">
        <i class="fa-solid fa-money-bill-wave w-5 text-center"></i>
        <span>{{ __('payments.payments') }}</span>
    </a>

    <div class="sidebar-header">{{ app()->getLocale() === 'bn' ? 'রিপোর্ট' : 'REPORTS' }}</div>

    <div class="mb-1">
        <a href="{{ route('reports.template-summary') }}"
           class="sidebar-link {{ request()->routeIs('reports.template-summary') ? 'active' : '' }}">
            <i class="fa-solid fa-table-columns w-5 text-center"></i>
            <span>{{ __('reports.template_summary') }}</span>
        </a>
        <a href="{{ route('reports.animal-summary') }}"
           class="sidebar-link {{ request()->routeIs('reports.animal-summary') ? 'active' : '' }}">
            <i class="fa-solid fa-chart-column w-5 text-center"></i>
            <span>{{ __('reports.animal_summary') }}</span>
        </a>
        <a href="{{ route('reports.partner-summary') }}"
           class="sidebar-link {{ request()->routeIs('reports.partner-summary') ? 'active' : '' }}">
            <i class="fa-solid fa-chart-pie w-5 text-center"></i>
            <span>{{ __('reports.partner_summary') }}</span>
        </a>
    </div>

    @endif {{-- end template selected check --}}
</nav>

<div class="border-t border-white/10 px-5 py-3 text-[11.5px] text-[#5f7d6b]">
    {{ config('app.name') }}
</div>