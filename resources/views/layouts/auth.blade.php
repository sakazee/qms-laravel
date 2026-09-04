<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('messages.app_name') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root { --green: #1a6b3a; }
        body {
            font-family: 'Hind Siliguri', sans-serif;
            background: linear-gradient(135deg, #1c2a1e 0%, #2d5016 50%, #1a6b3a 100%);
            min-height: 100vh;
        }
        .login-box { width: 400px; }
        .login-card-body {
            border-radius: 16px !important;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3) !important;
        }
        .login-logo {
            color: #fff !important;
            font-size: 22px;
            font-weight: 700;
            padding: 10px 0;
        }
        .login-logo i { color: #f4b942; margin-right: 8px; }
        .input-group-text { background: #f0f4f1; border: 1.5px solid #d8e4da; }
        .form-control {
            border: 1.5px solid #d8e4da;
            font-family: 'Hind Siliguri', sans-serif;
        }
        .form-control:focus { border-color: var(--green); box-shadow: 0 0 0 0.2rem rgba(26,107,58,0.15); }
        .btn-primary { background: var(--green) !important; border-color: var(--green) !important; border-radius: 8px; }
        a { color: var(--green); }
    </style>
</head>
<body class="hold-transition login-page">
    @yield('content')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
