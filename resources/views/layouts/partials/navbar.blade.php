<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left: Sidebar toggle + template badge -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                <i class="fas fa-bars"></i>
            </a>
        </li>
        @if(session('selected_template_id'))
            @php $tpl = \App\Models\Template::find(session('selected_template_id')); @endphp
            @if($tpl)
            <li class="nav-item d-none d-sm-flex align-items-center ml-2">
                <span class="template-badge">
                    <span class="dot"></span>
                    {{ $tpl->name }} — {{ $tpl->year }}
                </span>
            </li>
            @endif
        @else
        <li class="nav-item d-none d-sm-flex align-items-center ml-2">
            <a href="{{ route('templates.index') }}" class="btn btn-sm btn-outline-success">
                <i class="fas fa-layer-group mr-1"></i>
                {{ __('templates.select_to_continue') }}
            </a>
        </li>
        @endif
    </ul>

    <!-- Right: Language + Template selector + User -->
    <ul class="navbar-nav ml-auto">

        {{-- Template Selector Dropdown --}}
        @auth
        <li class="nav-item dropdown mr-2">
            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                <i class="fas fa-layer-group text-success"></i>
                <span class="d-none d-md-inline ml-1">{{ __('templates.template') }}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-right" style="min-width:220px">
                <div class="dropdown-header text-muted" style="font-size:11px">
                    {{ __('templates.select') }}
                </div>
                @php
                    $userTemplates = \App\Models\Template::where('user_id', auth()->id())->active()->latest()->get();
                @endphp
                @forelse($userTemplates as $tmpl)
                <a class="dropdown-item {{ session('selected_template_id') == $tmpl->id ? 'active' : '' }}"
                   href="{{ route('templates.select', $tmpl) }}">
                    <i class="fas fa-check-circle mr-2 {{ session('selected_template_id') == $tmpl->id ? '' : 'text-transparent' }}" style="{{ session('selected_template_id') == $tmpl->id ? '' : 'visibility:hidden' }}"></i>
                    {{ $tmpl->name }}
                    <small class="text-muted ml-1">({{ $tmpl->year }})</small>
                </a>
                @empty
                <span class="dropdown-item text-muted">{{ __('messages.no_data_found') }}</span>
                @endforelse
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{ route('templates.create') }}">
                    <i class="fas fa-plus text-success mr-2"></i> {{ __('templates.create') }}
                </a>
                @if(session('selected_template_id'))
                <a class="dropdown-item text-danger" href="{{ route('templates.deselect') }}">
                    <i class="fas fa-times mr-2"></i> {{ __('templates.deselect') }}
                </a>
                @endif
            </div>
        </li>

        {{-- Language Switcher --}}
        <li class="nav-item dropdown mr-2">
            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                <i class="fas fa-globe"></i>
                <span class="d-none d-sm-inline ml-1">{{ app()->getLocale() === 'bn' ? 'বাংলা' : 'EN' }}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item {{ app()->getLocale() === 'bn' ? 'active' : '' }}"
                   href="{{ route('language.switch', 'bn') }}">
                    🇧🇩 বাংলা
                </a>
                <a class="dropdown-item {{ app()->getLocale() === 'en' ? 'active' : '' }}"
                   href="{{ route('language.switch', 'en') }}">
                    🇬🇧 English
                </a>
            </div>
        </li>

        {{-- User Dropdown --}}
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center"
                         style="width:32px;height:32px;font-weight:700;font-size:14px">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <span class="ml-2 d-none d-md-inline" style="font-weight:600;font-size:13px">{{ auth()->user()->name }}</span>
                </div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-header">{{ auth()->user()->email }}</div>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
            </div>
        </li>
        @endauth
    </ul>
</nav>
