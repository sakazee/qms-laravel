<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'bn' ? 'ltr' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', __('messages.app_name')) | {{ __('messages.app_name') }}</title>

    <!-- Google Font - Hind Siliguri for Bengali -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@300;400;500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- AdminLTE 3 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">

    <style>
        :root {
            --font-primary: 'Hind Siliguri', 'Inter', sans-serif;
            --brand-color: #1a6b3a;
            --brand-dark: #145430;
            --brand-light: #e8f5e9;
            --accent: #f4b942;
            --sidebar-bg: #1c2a1e;
            --sidebar-text: #c8dcc9;
        }

        body {
            font-family: var(--font-primary);
            font-size: 14px;
            background-color: #f0f4f1;
        }

        /* Sidebar */
        .main-sidebar {
            background: var(--sidebar-bg) !important;
        }
        .brand-link {
            background: var(--brand-dark) !important;
            border-bottom: 1px solid rgba(255,255,255,0.1) !important;
        }
        .brand-link .brand-text {
            font-weight: 700;
            font-size: 15px;
            color: #fff !important;
            line-height: 1.3;
        }
        .sidebar .nav-link {
            color: var(--sidebar-text) !important;
            border-radius: 6px;
            margin: 2px 8px;
            transition: all 0.2s;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: var(--brand-color) !important;
            color: #fff !important;
        }
        .sidebar .nav-link i {
            color: inherit !important;
            width: 20px;
            text-align: center;
        }
        .nav-header {
            color: rgba(255,255,255,0.4) !important;
            font-size: 10px !important;
            font-weight: 700 !important;
            letter-spacing: 1px !important;
            padding: 10px 20px 5px !important;
            text-transform: uppercase;
        }
        .sidebar-mini.sidebar-collapse .nav-header { display: none; }

        /* Navbar */
        .main-header.navbar {
            background: #fff !important;
            border-bottom: 2px solid var(--brand-light);
            box-shadow: 0 2px 10px rgba(0,0,0,0.06);
        }
        .navbar-brand-link { display: none; }

        /* Template badge in navbar */
        .template-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--brand-light);
            color: var(--brand-dark);
            padding: 5px 14px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            border: 1px solid rgba(26,107,58,0.2);
        }
        .template-badge .dot {
            width: 8px; height: 8px;
            background: var(--brand-color);
            border-radius: 50%;
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0%,100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        /* Content */
        .content-header h1 {
            font-size: 20px;
            font-weight: 700;
            color: #1a2b1d;
        }
        .content-wrapper {
            background: #f0f4f1;
        }

        /* Cards */
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.07);
        }
        .card-header {
            border-radius: 12px 12px 0 0 !important;
            font-weight: 600;
            background: #fff;
            border-bottom: 1px solid #eef2ef;
            padding: 15px 20px;
        }
        .card-header.bg-primary { background: var(--brand-color) !important; }

        /* Stats cards */
        .small-box {
            border-radius: 12px !important;
            overflow: hidden;
        }
        .small-box h3 { font-size: 28px !important; font-weight: 700 !important; }
        .small-box p { font-size: 13px !important; }
        .small-box > .inner { padding: 15px 20px !important; }

        /* Tables */
        .table thead th {
            background: var(--brand-light);
            color: var(--brand-dark);
            font-weight: 600;
            font-size: 13px;
            border-top: none;
        }
        .table-hover tbody tr:hover { background: var(--brand-light); }

        /* Buttons */
        .btn-primary {
            background: var(--brand-color) !important;
            border-color: var(--brand-color) !important;
        }
        .btn-primary:hover { background: var(--brand-dark) !important; }
        .btn { border-radius: 6px; font-weight: 500; }
        .btn-sm { padding: 3px 10px; font-size: 12px; }

        /* Badges */
        .badge { font-size: 11px; font-weight: 600; border-radius: 4px; }

        /* Forms */
        .form-control, .custom-select {
            border-radius: 8px;
            border: 1.5px solid #d8e4da;
            font-family: var(--font-primary);
        }
        .form-control:focus {
            border-color: var(--brand-color);
            box-shadow: 0 0 0 0.2rem rgba(26,107,58,0.15);
        }
        label { font-weight: 500; color: #3d5c42; font-size: 13px; }

        /* Alerts */
        .alert { border-radius: 10px; border: none; }

        /* Footer */
        .main-footer {
            background: #fff;
            border-top: 1px solid #eef2ef;
            font-size: 13px;
            color: #6c8c72;
        }

        /* Bengali number support */
        .bn-num { font-family: 'Hind Siliguri', sans-serif; }

        /* Responsive table */
        @media (max-width: 768px) {
            .table-responsive { border-radius: 8px; }
        }
    </style>

    @stack('styles')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    {{-- Navbar --}}
    @include('layouts.partials.navbar')

    {{-- Sidebar --}}
    @include('layouts.partials.sidebar')

    {{-- Content Wrapper --}}
    <div class="content-wrapper">
        {{-- Content Header --}}
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2 align-items-center">
                    <div class="col-sm-6">
                        <h1 class="m-0">@yield('page-title')</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('messages.app_name') }}</a></li>
                            @yield('breadcrumb')
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        {{-- Main Content --}}
        <div class="content">
            <div class="container-fluid">
                {{-- Session Alerts --}}
                @include('layouts.partials.alerts')

                @yield('content')
            </div>
        </div>
    </div>

    {{-- Footer --}}
    <footer class="main-footer">
        <strong>{{ __('messages.app_name') }}</strong> &copy; {{ date('Y') }}
        <div class="float-right d-none d-sm-inline-block">
            <b>{{ config('app.name') }}</b>
        </div>
    </footer>

    <aside class="control-sidebar control-sidebar-dark"></aside>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    // Init DataTables
    $(document).ready(function() {
        if ($('.datatable').length) {
            $('.datatable').DataTable({
                language: {
                    @if(app()->getLocale() === 'bn')
                    url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/bn.json',
                    @endif
                    paginate: {
                        next: '<i class="fas fa-angle-right"></i>',
                        previous: '<i class="fas fa-angle-left"></i>'
                    }
                },
                pageLength: 15,
                responsive: true,
            });
        }

        // Select2
        $('.select2').select2({ theme: 'bootstrap4' });

        // Delete confirmation
        $(document).on('submit', '.form-delete', function(e) {
            e.preventDefault();
            const form = this;
            Swal.fire({
                title: '{{ __("messages.confirm_delete") }}',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '{{ __("messages.yes") }}',
                cancelButtonText: '{{ __("messages.cancel") }}',
            }).then((result) => {
                if (result.isConfirmed) form.submit();
            });
        });
    });

    @if(session('success'))
    Swal.fire({ icon: 'success', title: '{{ session("success") }}', timer: 2500, showConfirmButton: false, toast: true, position: 'top-end' });
    @endif
    @if(session('error'))
    Swal.fire({ icon: 'error', title: '{{ session("error") }}', timer: 4000, showConfirmButton: true, toast: true, position: 'top-end' });
    @endif
    @if(session('warning'))
    Swal.fire({ icon: 'warning', title: '{{ session("warning") }}', timer: 3500, showConfirmButton: false, toast: true, position: 'top-end' });
    @endif
</script>

@stack('scripts')
</body>
</html>
