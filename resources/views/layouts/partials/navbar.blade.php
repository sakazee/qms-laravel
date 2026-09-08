<header class="sticky top-0 z-20 border-b border-gray-200 bg-white/90 backdrop-blur">
    <div class="mx-auto flex h-16 max-w-screen-2xl items-center gap-3 px-4 sm:px-6 lg:px-8">

        {{-- Left: sidebar toggle + template badge --}}
        <button type="button" @click="sidebarToggle()" :title="sidebarToggleIcon()" aria-label="{{ __('messages.toggle_sidebar') }}" class="-ml-1 rounded-lg bg-emerald-50 p-2 text-emerald-800 ring-1 ring-inset ring-emerald-200 hover:bg-emerald-100 focus:outline-none focus-visible:ring-2 focus-visible:ring-emerald-600">
            <i class="fa-solid text-lg" :class="sidebarToggleIcon()"></i>
        </button>

        @if(session('selected_template_id'))
            @php $tpl = \App\Models\Template::find(session('selected_template_id')); @endphp
            @if($tpl)
            <span class="hidden items-center gap-2 rounded-full border border-emerald-200 bg-emerald-50 px-3.5 py-1.5 text-[14px] font-semibold text-emerald-900 sm:inline-flex">
                <span class="relative flex h-2 w-2">
                    <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-600 opacity-60"></span>
                    <span class="relative inline-flex h-2 w-2 rounded-full bg-emerald-700"></span>
                </span>
                {{ $tpl->name }} <span class="text-emerald-600">—</span> {{ $tpl->year }}
            </span>
            @endif
        @else
        <a href="{{ route('templates.index') }}"
           class="hidden items-center gap-1.5 rounded-lg border border-emerald-300 bg-white px-3 py-1.5 text-[13.5px] font-semibold text-emerald-800 transition-colors hover:bg-emerald-50 sm:inline-flex">
            <i class="fa-solid fa-layer-group"></i>
            {{ __('templates.select_to_continue') }}
        </a>
        @endif

        {{-- Right: dropdowns --}}
        <div class="ml-auto flex items-center gap-1 sm:gap-2">

            @auth
            {{-- Admin / User mode toggle --}}
            @if(auth()->user()->isAdmin())
            <div class="hidden items-center gap-1 rounded-full border border-pine-200 bg-pine-50 p-1 xl:flex" role="group" aria-label="Mode">
                <a href="{{ route('admin.switch-to-user') }}"
                   class="rounded-full px-3 py-1 text-[13px] font-semibold transition-colors {{ session('mode') !== 'admin' ? 'bg-pine-900 text-white' : 'text-pine-700 hover:bg-pine-100' }}">
                    {{ __('admin.mode_user') }}
                </a>
                <a href="{{ route('admin.switch-to-admin') }}"
                   class="rounded-full px-3 py-1 text-[13px] font-semibold transition-colors {{ session('mode') === 'admin' ? 'bg-pine-900 text-white' : 'text-pine-700 hover:bg-pine-100' }}">
                    {{ __('admin.mode_admin') }}
                </a>
            </div>
            @endif

            {{-- Template selector --}}
            <div x-data="{ open: false }" @click.outside="open = false" class="relative">
                <button type="button" @click="open = !open" class="flex items-center gap-1.5 rounded-lg px-2.5 py-2 text-gray-600 hover:bg-paper-100 focus:outline-none focus-visible:ring-2 focus-visible:ring-emerald-600">
                    <i class="fa-solid fa-layer-group text-emerald-700"></i>
                    <span class="hidden text-[14px] font-medium md:inline">{{ __('templates.template') }}</span>
                    <i class="fa-solid fa-chevron-down text-[11px] text-gray-400"></i>
                </button>
                <div x-show="open" x-cloak x-transition
                     class="absolute right-0 z-50 mt-2 w-60 overflow-hidden rounded-xl border border-gray-200 bg-white shadow-lift">
                    <div class="border-b border-gray-100 px-4 py-2 text-[12px] font-bold uppercase tracking-wide text-gray-400">{{ __('templates.select') }}</div>
                    @php $userTemplates = \App\Models\Template::where('user_id', effective_user_id())->active()->latest()->get(); @endphp
                    @forelse($userTemplates as $tmpl)
                    <a href="{{ route('templates.select', $tmpl) }}"
                       class="dropdown-item {{ session('selected_template_id') == $tmpl->id ? 'bg-emerald-50 font-semibold text-emerald-900' : '' }}">
                        <i class="fa-solid fa-check-circle {{ session('selected_template_id') == $tmpl->id ? 'text-emerald-700' : 'text-transparent' }}"></i>
                        <span class="flex-1">{{ $tmpl->name }}</span>
                        <small class="text-gray-400">({{ $tmpl->year }})</small>
                    </a>
                    @empty
                    <span class="flex px-4 py-2.5 text-[14px] text-gray-400">{{ __('messages.no_data_found') }}</span>
                    @endforelse
                    <div class="border-t border-gray-100 py-1">
                        <a href="{{ route('templates.create') }}" class="dropdown-item text-emerald-800">
                            <i class="fa-solid fa-plus text-emerald-600"></i> {{ __('templates.create') }}
                        </a>
                        @if(session('selected_template_id'))
                        <a href="{{ route('templates.deselect') }}" class="dropdown-item text-rose-700">
                            <i class="fa-solid fa-xmark"></i> {{ __('templates.deselect') }}
                        </a>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Language switcher --}}
            <div x-data="{ open: false }" @click.outside="open = false" class="relative">
                <button type="button" @click="open = !open" class="flex items-center gap-1.5 rounded-lg px-2.5 py-2 text-gray-600 hover:bg-paper-100 focus:outline-none focus-visible:ring-2 focus-visible:ring-emerald-600">
                    <i class="fa-solid fa-globe"></i>
                    <span class="hidden text-[14px] font-medium sm:inline">{{ app()->getLocale() === 'bn' ? 'বাংলা' : 'EN' }}</span>
                    <i class="fa-solid fa-chevron-down text-[11px] text-gray-400"></i>
                </button>
                <div x-show="open" x-cloak x-transition
                     class="absolute right-0 z-50 mt-2 w-44 overflow-hidden rounded-xl border border-gray-200 bg-white py-1 shadow-lift">
                    <a href="{{ route('language.switch', 'bn') }}" class="dropdown-item {{ app()->getLocale() === 'bn' ? 'bg-emerald-50 font-semibold' : '' }}">
                        🇧🇩 বাংলা
                    </a>
                    <a href="{{ route('language.switch', 'en') }}" class="dropdown-item {{ app()->getLocale() === 'en' ? 'bg-emerald-50 font-semibold' : '' }}">
                        🇬🇧 English
                    </a>
                </div>
            </div>

            {{-- User dropdown --}}
            <div x-data="{ open: false }" @click.outside="open = false" class="relative">
                <button type="button" @click="open = !open" class="flex items-center gap-2 rounded-lg py-1.5 pl-1.5 pr-2 hover:bg-paper-100 focus:outline-none focus-visible:ring-2 focus-visible:ring-emerald-600">
                    <span class="flex h-8 w-8 items-center justify-center rounded-full bg-emerald-800 text-[15px] font-bold text-white">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </span>
                    <span class="hidden text-[14px] font-semibold text-gray-700 md:inline">{{ auth()->user()->name }}</span>
                    <i class="fa-solid fa-chevron-down text-[11px] text-gray-400"></i>
                </button>
                <div x-show="open" x-cloak x-transition
                     class="absolute right-0 z-50 mt-2 w-52 overflow-hidden rounded-xl border border-gray-200 bg-white py-1 shadow-lift">
                    <div class="border-b border-gray-100 px-4 py-2.5">
                        <div class="text-[14px] font-semibold text-gray-800">{{ auth()->user()->name }}</div>
                        <div class="text-[13px] text-gray-400">{{ auth()->user()->email }}</div>
                    </div>
                    <a href="{{ route('logout') }}" class="dropdown-item text-rose-700"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i> Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
                </div>
            </div>
            @endauth
        </div>
    </div>
</header>