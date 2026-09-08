<a href="{{ route('dashboard') }}" class="sidebar-brand flex items-center gap-2.5 border-b border-white/10 px-4 py-3">
    <i class="fa-solid fa-moon text-[17px] text-gold"></i>
    <span class="font-serif text-[14.5px] font-bold leading-tight text-white">
        {{ app()->getLocale() === 'bn' ? 'কোরবানি সিস্টেম' : 'Qurbani System' }}
    </span>
</a>

<nav class="flex-1 py-2">
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

    <a href="{{ route('expense-heads.index') }}"
       class="sidebar-link {{ request()->routeIs('expense-heads.*') ? 'active' : '' }}">
        <i class="fa-solid fa-tags w-5 text-center"></i>
        <span>{{ __('expense_heads.expense_heads') }}</span>
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
        <a href="{{ route('reports.partner-due-summary') }}"
           class="sidebar-link {{ request()->routeIs('reports.partner-due-summary') ? 'active' : '' }}">
            <i class="fa-solid fa-scale-balanced w-5 text-center"></i>
            <span>{{ __('reports.partner_due_summary') }}</span>
        </a>
    </div>

    @endif {{-- end template selected check --}}

    @if(auth()->user()->isAdmin() && session('mode') !== 'user')

    <div class="sidebar-header">{{ app()->getLocale() === 'bn' ? 'সুপার অ্যাডমিন' : 'SUPER ADMIN' }}</div>

    <a href="{{ route('admin.users.index') }}"
       class="sidebar-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
        <i class="fa-solid fa-users-gear w-5 text-center"></i>
        <span>{{ __('admin.users') }}</span>
    </a>

    <a href="{{ route('admin.templates.index') }}"
       class="sidebar-link {{ request()->routeIs('admin.templates.*') ? 'active' : '' }}">
        <i class="fa-solid fa-layer-group w-5 text-center"></i>
        <span>{{ __('admin.all_templates') }}</span>
    </a>

    @endif
</nav>

<div class="sidebar-footer border-t border-white/10 px-4 py-2 text-[12.5px] text-[#5f7d6b]">
    {{ config('app.name') }}
</div>