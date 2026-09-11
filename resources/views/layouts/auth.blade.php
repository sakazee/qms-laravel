<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('messages.app_name') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@300;400;500;600;700&family=Noto+Serif+Bengali:wght@500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet" media="print" onload="this.media='all'">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" media="print" onload="this.media='all'">
    <noscript>
        <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@300;400;500;600;700&family=Noto+Serif+Bengali:wght@500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    </noscript>

    <style>
        [x-cloak] { display: none !important; }
        .auth-bg {
            background:
                radial-gradient(1100px 500px at 85% -10%, rgba(201, 149, 45, 0.22), transparent 60%),
                radial-gradient(900px 600px at -10% 110%, rgba(22, 101, 52, 0.55), transparent 55%),
                linear-gradient(150deg, #0d1f15 0%, #12281b 45%, #175a34 100%);
        }
        .auth-card {
            box-shadow: 0 24px 64px -16px rgba(0, 0, 0, 0.45);
        }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="auth-bg flex min-h-screen items-center justify-center px-4 py-10 font-sans">
    @yield('content')
</body>
</html>