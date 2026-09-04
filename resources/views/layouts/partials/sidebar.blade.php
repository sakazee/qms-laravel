<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <!-- Brand Logo -->
    <a href="{{ route('dashboard') }}" class="brand-link px-3 py-2">
        <i class="fas fa-moon text-warning mr-2" style="font-size:20px"></i>
        <span class="brand-text font-weight-bold">
            {{ app()->getLocale() === 'bn' ? 'কোরবানি সিস্টেম' : 'Qurbani System' }}
        </span>
    </a>

    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                {{-- Dashboard --}}
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>{{ app()->getLocale() === 'bn' ? 'ড্যাশবোর্ড' : 'Dashboard' }}</p>
                    </a>
                </li>

                {{-- Templates --}}
                <li class="nav-header">{{ app()->getLocale() === 'bn' ? 'ব্যবস্থাপনা' : 'MANAGEMENT' }}</li>

                <li class="nav-item">
                    <a href="{{ route('templates.index') }}" class="nav-link {{ request()->routeIs('templates.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-layer-group"></i>
                        <p>{{ __('templates.templates') }}</p>
                    </a>
                </li>

                {{-- Template-specific menu (only shown when template selected) --}}
                @if(session('selected_template_id'))

                <li class="nav-header">{{ app()->getLocale() === 'bn' ? 'কোরবানি' : 'QURBANI' }}</li>

                <li class="nav-item">
                    <a href="{{ route('animals.index') }}" class="nav-link {{ request()->routeIs('animals.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-horse"></i>
                        <p>{{ __('animals.animals') }}</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('partners.index') }}" class="nav-link {{ request()->routeIs('partners.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>{{ __('partners.partners') }}</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('shares.index') }}" class="nav-link {{ request()->routeIs('shares.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-share-alt"></i>
                        <p>{{ __('shares.shares') }}</p>
                    </a>
                </li>

                <li class="nav-header">{{ app()->getLocale() === 'bn' ? 'আর্থিক' : 'FINANCE' }}</li>

                <li class="nav-item">
                    <a href="{{ route('expenses.index') }}" class="nav-link {{ request()->routeIs('expenses.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-file-invoice-dollar"></i>
                        <p>{{ __('expenses.expenses') }}</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('payments.index') }}" class="nav-link {{ request()->routeIs('payments.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-money-bill-wave"></i>
                        <p>{{ __('payments.payments') }}</p>
                    </a>
                </li>

                <li class="nav-header">{{ app()->getLocale() === 'bn' ? 'রিপোর্ট' : 'REPORTS' }}</li>

                <li class="nav-item {{ request()->routeIs('reports.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-chart-bar"></i>
                        <p>
                            {{ __('reports.reports') }}
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('reports.template-summary') }}"
                               class="nav-link {{ request()->routeIs('reports.template-summary') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('reports.template_summary') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('reports.animal-summary') }}"
                               class="nav-link {{ request()->routeIs('reports.animal-summary') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('reports.animal_summary') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('reports.partner-summary') }}"
                               class="nav-link {{ request()->routeIs('reports.partner-summary') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('reports.partner_summary') }}</p>
                            </a>
                        </li>
                    </ul>
                </li>

                @endif {{-- end template selected check --}}

            </ul>
        </nav>
    </div>
</aside>
