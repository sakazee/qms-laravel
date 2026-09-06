<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', __('messages.app_name')) | {{ __('messages.app_name') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@300;400;500;600;700&family=Noto+Serif+Bengali:wght@500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>[x-cloak]{display:none!important}</style>

    @vite('resources/js/app.js')
    @stack('styles')

    <script>
        window.__qms_locale = {{ \Illuminate\Support\Js::from(app()->getLocale()) }};
        window.__qms_translate = {{ \Illuminate\Support\Js::from([
            'confirmDelete'     => __('messages.confirm_delete'),
            'confirmBulkDelete' => __('messages.confirm_bulk_delete'),
            'yes'               => __('messages.yes'),
            'cancel'            => __('messages.cancel'),
        ]) }};
    </script>
</head>
<body class="bg-paper" data-flash-success="{{ session('success') }}"
                       data-flash-error="{{ session('error') }}"
                       data-flash-warning="{{ session('warning') }}">
<div x-data="{ sidebarOpen: false }" @keydown.escape.window="sidebarOpen = false" class="flex min-h-screen">

    {{-- Mobile overlay --}}
    <div x-show="sidebarOpen" x-cloak class="fixed inset-0 z-30 bg-pine-950/60 backdrop-blur-sm lg:hidden" @click="sidebarOpen = false"></div>

    {{-- Sidebar --}}
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
           class="fixed inset-y-0 left-0 z-40 flex w-64 flex-col overflow-y-auto bg-pine-900 shadow-lift transition-transform duration-200 lg:sticky lg:top-0 lg:h-screen lg:translate-x-0">
        @include('layouts.partials.sidebar')
    </aside>

    {{-- Main column --}}
    <div class="flex min-h-screen w-full flex-col">
        {{-- Navbar --}}
        @include('layouts.partials.navbar')

        {{-- Content --}}
        <main class="flex-1 px-4 py-6 sm:px-6 lg:px-8">
            <div class="mx-auto">
                <div class="mb-5 flex flex-wrap items-center justify-between gap-3">
                    <h1 class="font-serif text-[22px] font-bold text-pine-900">@yield('page-title')</h1>
                    @hasSection('breadcrumb')
                    <nav class="flex items-center gap-1.5 text-[12.5px] text-gray-500">
                        <a href="{{ route('dashboard') }}" class="hover:text-emerald-700">{{ __('messages.app_name') }}</a>
                        <i class="fa-solid fa-chevron-right text-[10px] text-gray-400"></i>
                        @yield('breadcrumb')
                    </nav>
                    @endif
                </div>

                @include('layouts.partials.alerts')

                @yield('content')
            </div>
        </main>

        {{-- Footer --}}
        <footer class="border-t border-gray-200 bg-white px-6 py-4">
            <div class="mx-auto flex flex-wrap items-center justify-between gap-2 text-[12.5px] text-gray-500">
                <span><strong class="text-emerald-800">{{ __('messages.app_name') }}</strong> &copy; {{ date('Y') }}</span>
                <span class="hidden sm:inline"><b>{{ config('app.name') }}</b></span>
</div>
        </div>
    </div>
</div>

<script>
    window.qmsOnReady = (function () {
        const queue = [];
        let done = false;
        let timer = null;

        function tryBoot() {
            if (done) return;
            if (!window.jQuery || !window.jQuery.fn || typeof window.jQuery.fn.select2 !== 'function') return;
            done = true;
            if (timer) clearInterval(timer);
            const $ = window.jQuery;
            for (let i = 0; i < queue.length; i++) queue[i]($);
            queue.length = 0;
        }

        document.addEventListener('DOMContentLoaded', tryBoot);
        timer = setInterval(tryBoot, 100);

        return function (fn) {
            if (done) { fn(window.jQuery); return; }
            queue.push(fn);
        };
    })();
</script>
@stack('scripts')
</body>
</html>